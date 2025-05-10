<?php

namespace App\Console\Commands;

use App\Application\UseCases\Product\Create\CreateProductDTO;
use App\Application\UseCases\Product\Import\ImportProductsUseCase;
use App\Domain\Enum\ProductStatusEnum;
use App\Infra\Persistence\Models\ImportHistoryModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportOpenFoodData extends Command
{
    protected $signature = 'openfood:import';
    protected $description = 'Import data from Open Food Facts into the database';

    public function __construct(private ImportProductsUseCase $importProductsUseCase)
    {
        parent::__construct();
    }

    public function handle()
    {
        $indexUrl = 'https://challenges.coode.sh/food/data/json/index.txt';
        $response = $this->fetchIndexFile($indexUrl);

        if (!$response) {
            return Command::FAILURE;
        }

        $files = explode("\n", trim($response));

        foreach ($files as $file) {
            $url = "https://challenges.coode.sh/food/data/json/{$file}";
            $this->info("Importing: $url");

            $startedAt = Carbon::now();

            try {
                $importedCount = $this->importProductsFromFile($url);
                $this->registerImportHistory($file, $importedCount, true, $startedAt);
            } catch (Exception $e) {
                Log::error("Failed to import from $url: " . $e->getMessage());
                $this->registerImportHistory($file, 0, false, $startedAt, $e->getMessage());
            }
        }


        return Command::SUCCESS;
    }

    private function fetchIndexFile(string $url): ?string
    {
        $response = Http::get($url);

        if (!$response->ok()) {
            Log::error('Failed to fetch index.txt');
            return null;
        }

        return $response->body();
    }

    private function importProductsFromFile(string $url): int
    {
        $productsDTO = [];
        foreach ($this->readGzFileOnDemand($url) as $chunk) {
            $continue = $this->processChunk($chunk, $productsDTO, 100);
            if (!$continue) {
                break; // Limit reached
            }
        }

        if (count($productsDTO) > 0) {
            $this->importProductsUseCase->execute($productsDTO);
        }

        return count($productsDTO);
    }

    private function readGzFileOnDemand(string $url, int $chunkSize = 1024 * 1024)
    {
        $file = gzopen($url, 'rb');
        if (!$file) {
            throw new Exception("Unable to open file: $url");
        }

        while (!gzeof($file)) {
            yield gzread($file, $chunkSize);
        }

        gzclose($file);
    }

    private function processChunk(string $chunk, array &$productsDTO, int $limit = 100): bool
    {
        $products = explode("\n", trim($chunk));

        foreach ($products as $productData) {
            if (count($productsDTO) >= $limit) {
                return false;
            }

            $product = json_decode($productData);
            if ($product === null || empty($product->product_name)) {
                continue;
            }

            $productsDTO[] = $this->createProductDTO($product);
        }

        return true;
    }

    private function createProductDTO(object $product): CreateProductDTO
    {
        return new CreateProductDTO(
            $product->code,
            $product->brands,
            $product->categories,
            $product->product_name,
            $product->image_url,
            $product->ingredients_text,
            $product->energy_100g ?? 0,
            $product->fat_100g ?? 0,
            $product->{'saturated-fat_100g'} ?? 0,
            $product->sugars_100g ?? 0,
            $product->proteins_100g ?? 0,
            $product->salt_100g ?? 0,
            Carbon::now(),
            ProductStatusEnum::PUBLISHED
        );
    }

    private function registerImportHistory(string $filename, int $totalImported, bool $success, Carbon $startedAt, string $error = null): void
    {
        ImportHistoryModel::create([
            'filename' => $filename,
            'total_imported' => $totalImported,
            'started_at' => $startedAt,
            'finished_at' => Carbon::now(),
            'status' => $success ? 'SUCCESS' : 'FAILED',
            'error_message' => $error,
        ]);
    }
}

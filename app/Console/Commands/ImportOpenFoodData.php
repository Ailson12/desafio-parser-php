<?php

namespace App\Console\Commands;

use App\Application\UseCases\Product\Create\CreateProductDTO;
use App\Application\UseCases\Product\Import\ImportProductsUseCase;
use App\Domain\Enum\ProductStatusEnum;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportOpenFoodData extends Command
{
    protected $signature = 'openfood:import';
    protected $description = 'Import data from Open Food Facts into the database';

    private $importProductsUseCase;

    public function __construct(ImportProductsUseCase $importProductsUseCase)
    {
        parent::__construct();
        $this->importProductsUseCase = $importProductsUseCase;
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

            $this->importProductsFromFile($url);
        }
    }

    private function fetchIndexFile($url)
    {
        $response = Http::get($url);

        if (!$response->ok()) {
            Log::error('Search failed index.txt');
            return null;
        }

        return $response->body();
    }

    private function importProductsFromFile($url)
    {
        $productsDTO = [];

        foreach ($this->readGzFileOnDemand($url) as $chunk) {
            $this->processChunk($chunk, $productsDTO);

            if (count($productsDTO) >= 100) {
                break;  // Limite de 100 produtos
            }
        }

        if (count($productsDTO) > 0) {
            $this->importProductsUseCase->execute($productsDTO);
        }
    }

    private function readGzFileOnDemand($url, $chunkSize = 1024 * 1024)
    {
        $file = gzopen($url, 'rb');
        if (!$file) {
            return null;
        }

        while (!gzeof($file)) {
            $chunk = gzread($file, $chunkSize);
            yield $chunk;
        }

        gzclose($file);
    }


    private function processChunk($chunk, &$productsDTO)
    {
        $products = explode("\n", trim($chunk));

        foreach ($products as $productData) {
            $product = json_decode($productData);
            if ($product == null || !$product->product_name) {
                continue;
            }

            $newProduct = $this->createProductDTO($product);
            $productsDTO[] = $newProduct;
        }
    }

    private function createProductDTO($product)
    {
        return new CreateProductDTO(
            $product->code,
            $product->brands,
            $product->categories,
            $product->product_name,
            $product->image_url,
            $product->ingredients_text,
            $product->energy_100g,
            $product->fat_100g,
            $product->{'saturated-fat_100g'},
            $product->sugars_100g,
            $product->proteins_100g,
            $product->salt_100g,
            Carbon::now(),
            ProductStatusEnum::PUBLISHED
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Infra\Persistence\Models\ImportHistoryModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class StatusController extends Controller
{
    public function index()
    {
        $dbRead = $this->canReadDatabase();
        $dbWrite = $this->canWriteDatabase();

        $lastCron = ImportHistoryModel::latest('finished_at')->first();

        return response()->json([
            'memory_usage' => memory_get_usage(true),
            'db_connection' => [
                'read' => $dbRead,
                'write' => $dbWrite,
            ],
            'last_cron_execution' => $lastCron ? $lastCron->finished_at : null,
        ]);
    }

    private function canReadDatabase(): bool
    {
        try {
            return Schema::hasTable('products');
        } catch (Throwable $throwable) {
            return false;
        }
    }

    private function canWriteDatabase(): bool
    {
        try {
            $migrationFake = 'test_write_access_' . now()->timestamp;
            DB::table('migrations')->insert([
                'migration' => $migrationFake,
                'batch' => 9999,
            ]);

            DB::table('migrations')
                ->where('migration', $migrationFake)
                ->delete();

            return true;
        } catch (\Throwable $e) {
            Log::error('Error when testing database writes: ' . $e->getMessage());
            return false;
        }
    }
}

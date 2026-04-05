<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class SystemHealthService
{
    /**
     * Check if Smart Validation is active
     * (Always true as it's code-based, but we can check if Request classes exist)
     */
    public function checkValidationStatus(): bool
    {
        return class_exists('App\Http\Requests\StoreProductRequest') && 
               class_exists('App\Http\Requests\UpdateProductRequest');
    }

    /**
     * Check if Database Transactions are supported
     */
    public function checkTransactionStatus(): bool
    {
        try {
            DB::beginTransaction();
            DB::rollBack();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if File Cleanup is possible (Storage permissions)
     */
    public function checkFileCleanupStatus(): bool
    {
        try {
            // Check if public storage is writable
            return is_writable(storage_path('app/public'));
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if Performance Optimization (Indexes) is active
     */
    public function checkPerformanceStatus(): bool
    {
        try {
            // Check if composite index exists on product_attributes
            // Note: Schema::hasIndex is not always reliable across all drivers, 
            // but for MySQL it works by checking Doctrine schema manager
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('product_attributes');
            
            foreach ($indexes as $index) {
                if ($index->getColumns() === ['product_id', 'attribute_name']) {
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            // Fallback: assume true if migration exists in migrations table
            return DB::table('migrations')
                ->where('migration', 'like', '%add_composite_index_to_product_attributes_table%')
                ->exists();
        }
    }

    /**
     * Get all statuses
     */
    public function getSystemStatus(): array
    {
        return [
            'validation' => $this->checkValidationStatus(),
            'transaction' => $this->checkTransactionStatus(),
            'file_cleanup' => $this->checkFileCleanupStatus(),
            'performance' => $this->checkPerformanceStatus(),
        ];
    }
}

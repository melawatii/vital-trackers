<?php

namespace App\Repositories\Contracts;

/**
 * Base repository contract.
 */
interface BaseRepositoryInterface
{
    /**
     * Get all records.
     */
    public function getAll(
        array $filters = []
    );

    /**
     * Find record by ID.
     */
    public function findById(
        string $id
    );

    /**
     * Create new record.
     */
    public function create(
        array $data
    );

    /**
     * Update existing record.
     */
    public function update(
        string $id,
        array $data
    );

    /**
     * Delete record.
     */
    public function delete(
        string $id
    ): bool;
}
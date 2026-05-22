<?php

namespace App\Repositories\Mongo;

use App\Repositories\Contracts\BaseRepositoryInterface;

/**
 * Base MongoDB repository.
 */
class BaseRepository implements BaseRepositoryInterface
{
    /**
     * Model instance.
     *
     * @var mixed
     */
    protected $model;

    /**
     * Repository constructor.
     */
    public function __construct(
        $model
    ) {

        $this->model = $model;
    }

    /**
     * Get all records.
     */
    public function getAll(
        array $filters = []
    ) {

        /**
         * Initialize query.
         */
        $query = $this->model->query();

        /**
         * Apply filters.
         */
        foreach ($filters as $field => $value) {

            $query->where(
                $field,
                $value
            );
        }

        return $query
            ->latest()
            ->get();
    }

    /**
     * Find record by ID.
     */
    public function findById(
        string $id
    ) {

        return $this->model
            ->findOrFail($id);
    }

    /**
     * Store new record.
     */
    public function create(
        array $data
    ) {

        return $this->model
            ->create($data);
    }

    /**
     * Update existing record.
     */
    public function update(
        string $id,
        array $data
    ) {

        /**
         * Find existing record.
         */
        $record = $this->findById($id);

        /**
         * Update record.
         */
        $record->update($data);

        return $record;
    }

    /**
     * Delete record.
     */
    public function delete(
        string $id
    ): bool {

        return (bool) $this
            ->findById($id)
            ->delete();
    }
}
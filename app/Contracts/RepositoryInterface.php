<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface
{
    /**
     * Get all records.
     */
    public function all(): Collection;

    /**
     * Find a record by its ID.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id);

    /**
     * Find a record by a specific column value.
     *
     * @param  string  $column
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    /**
     * Create a new record.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Update an existing record.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function update($model, array $data);

    /**
     * Delete a record.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function delete($model);
}

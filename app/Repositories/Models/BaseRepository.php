<?php

namespace App\Repositories\Models;

use App\Contracts\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    /** @var Model */
    protected $model;

    /** @var array */
    protected $relations;

    /**
     * BaseRepository constructor.
     */
    public function __construct(Model $model, array $relations = [])
    {
        $this->model = $model;
        $this->relations = $relations;
    }

    /**
     * Retrieve all records, optionally with relations.
     */
    public function all(): Collection
    {
        return $this->applyRelations($this->model)->get();
    }

    /**
     * Find a record by ID, optionally with relations.
     */
    public function find(int $id): ?Model
    {
        return $this->applyRelations($this->model)->find($id);
    }

    /**
     * Create a new record in the database.
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a record in the database.
     *
     * @param  Model  $model
     */
    public function update($model, array $data): bool
    {
        return $model->update($data);
    }

    /**
     * Delete a record from the database.
     *
     * @param  Model  $model
     */
    public function delete($model): ?bool
    {
        return $model->delete();
    }

    /**
     * Paginate the records, optionally with relations.
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->applyRelations($this->model)->paginate($perPage);
    }

    /**
     * Simple pagination (no total count), optionally with relations.
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function simplePaginate(int $perPage = 10)
    {
        return $this->applyRelations($this->model)->simplePaginate($perPage);
    }

    /**
     * Apply the specified relations to the query if available.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyRelations(Model $model)
    {
        $query = $model->newQuery();
        if (! empty($this->relations)) {
            $query->with($this->relations);
        }

        return $query;
    }

    public function exists(array $conditions): bool
    {
        return $this->model->where($conditions)->exists();
    }

    /**
     * Perform a search using Scout, if available.
     */
    public function search(string $query, $perPage = 10): Collection|LengthAwarePaginator
    {
        if (method_exists($this->model, 'search')) {
            $builder = $this->model::search($query);

            $results = $builder->paginate($perPage);
            if ($results->isEmpty()) {
                return new Collection([]);
            }

            if (! empty($this->relations)) {
                $results->load($this->relations);
            }

            return $results;
        }

        return new Collection([]);
    }

    /**
     * Retrieve users who do not have any of the specified relations.
     *
     * @param  array  $relations  An array of relation names to check.
     * @return \Illuminate\Database\Eloquent\Collection A collection of users without the specified relations.
     */
    public function getNoRelations(array $relations)
    {
        $query = $this->model->newQuery();
        foreach ($relations as $relation) {
            $query->doesntHave($relation);
        }

        return $query->get();
    }

    /**
     * Retrieve users who have all of the specified relations.
     *
     * @param  array  $relations  An array of relation names to check.
     * @return \Illuminate\Database\Eloquent\Collection A collection of users with the specified relations.
     */
    public function getWithRelations(array $relations)
    {
        $query = $this->model->newQuery();
        foreach ($relations as $relation) {
            $query->has($relation);
        }

        return $query->get();
    }

    /**
     * Find a record by a given condition.
     */
    public function simpleFind(array $condition): ?Model
    {
        return $this->model->where($condition)->first() ?? null;
    }

    public function updateOrCreate(array $conditions, array $data): Model
    {
        return $this->model->updateOrCreate($conditions, $data);
    }
}

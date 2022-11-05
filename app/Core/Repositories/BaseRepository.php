<?php

namespace App\Core\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{

    /**
     * @var
     */
    protected $model;

    protected $itemsPerPage;


    /**
     * @param $model
     */
    public function __construct()
    {
        $this->makeModel();
        $this->itemsPerPage = config("global.items_per_page");
    }


    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    abstract public function model();


    /**
     * @return Model|mixed
     * @throws GeneralException
     */
    public function makeModel()
    {
        $model = app()->make($this->model());

        if (! $model instanceof Model) {
            throw new GeneralException("Class {$this->model()} must be an instance of ".Model::class);
        }

        return $this->model = $model;
    }

    /**
     * @param $id
     * @param array $columns
     * @return array|null
     */
    public function getById($id, $columns = ['*'])
    {
        $row = $this->model->find($id, $columns);

        return is_null($row) ? null : $row;
    }

    /**
     * @param array $ids
     * @return array|null
     */
    public function getByIds(array $ids)
    {
        return $this->model
            ->whereIn('id', $ids)
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * @param array $columns
     * @return array
     */
    public function getAll($columns = ['*'])
    {
        return $this->model->get($columns);
    }


    /**
     * @param array $attributes
     * @return array
     */
    public function create(array $attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function firstOrCreate(array $attributes)
    {
        return $this->model->firstOrCreate($attributes);
    }

    /**
     * @param array $firstBy
     * @param array $attributes
     * @return array
     */
    public function firstByOrCreateBy(array $firstBy, array $attributes)
    {
        return $this->model->firstOrCreate($firstBy, $attributes);
    }

    /**
     * Update the model in the database by an identifier.
     *
     * @param $id
     * @param array $attributes
     * @return bool|int
     */
    public function updateById($id, array $attributes = [])
    {
        return $this->model->where('id', $id)->update($attributes);

//        $result = $this->model->find($id);
//        if (! is_null($result)) {
//            $result = $result->update($attributes);
//        }
//        else {
//            $result = 0;
//        }
//
//        return $result;
    }

    /**
     * Update the model in the database by identifiers.
     *
     * @param array $ids
     * @param array $attributes
     * @return bool|int
     */
    public function updateByIds(array $ids, array $attributes = [])
    {
        return $this->model->whereIn('id', $ids)->update($attributes);
    }

    /**
     * Delete the model in the database by an identifier.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById($id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * Delete the model in the database by an identifier.
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public function firstByKeyValue($key, $value)
    {
        return $this->model->where($key, $value)->first();
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function latestBy($column = "created_at")
    {
        return $this->model->latest($column)
            ->first();
    }


    public function query()
    {
        if ($this->model instanceof \Illuminate\Database\Eloquent\Builder){
            return  $this->model;
        }

        return $this->model->query();
    }

    /**
     * @param array $where
     * @param array $updateOrCreate
     * @return array
     */
    public function updateOrCreate(array $where, array $updateOrCreate)
    {
        return $this->model->updateOrCreate($where, $updateOrCreate);

    }


    /**
     * Delete the model in the database by an identifier.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteByIds(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }


}

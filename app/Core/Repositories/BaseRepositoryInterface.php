<?php

namespace App\Core\Repositories;

use Illuminate\Database\Query\Builder;

interface BaseRepositoryInterface
{

    /**
     * @param  array  $columns
     * @return array
     */
    public function getAll($columns = ['*']);

    /**
     * @param $id
     * @param  array  $columns
     * @return array|null
     */
    public function getById($id, $columns = ['*']);


    /**
     * @param  array  $ids
     * @return array|null
     */
    public function getByIds(array $ids);


    /**
     * @param  array  $attributes
     * @return array
     */
    public function create(array $attributes);

    /**
     * @param  array  $attributes
     * @return array
     */
    public function firstOrCreate(array $attributes);

    /**
     * @param  array  $firstBy
     * @param  array  $attributes
     * @return array
     */
    public function firstByOrCreateBy(array $firstBy, array $attributes);

    /**
     * Update the model in the database by an identifier.
     *
     * @param $id
     * @param  array  $attributes
     * @return bool|int
     */
    public function updateById($id, array $attributes = []);


    /**
     * Update the model in the database by identifiers.
     *
     * @param  array  $ids
     * @param  array  $attributes
     * @return bool|int
     */
    public function updateByIds(array $ids, array $attributes = []);


    /**
     * Delete the model in the database by an identifier.
     *
     * @param $id
     * @return bool
     */
    public function deleteById($id);

    /**
     * first By Key Value
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public function firstByKeyValue($key, $value);


    /**
     * Find or Fail
     *
     * @param $id
     * @return bool
     */
    public function findOrFail($id);


    /**
     * Find or Fail
     *
     * @param $column
     * @return bool
     */
    public function latestBy($column);

    /**
     * @param array $where
     * @param array $updateOrCreate
     * @return array
     */
    public function updateOrCreate(array $where, array $updateOrCreate);

    /**
     * Delete the model in the database by an identifier.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteByIds(array $ids);


    /**
     * Use model query funtion
     *
     * @return Builder
     */
    public function query();


}

<?php


namespace App\Core\Repositories\Traits;


use Milito\QueryFilter\QueryFilter;

trait QueryFilterAppend
{
    public function filter(QueryFilter $filter) : self
    {
        $this->model = $this->query()->filter($filter);

        return $this;
    }
}

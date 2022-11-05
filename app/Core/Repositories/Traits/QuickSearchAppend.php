<?php


namespace App\Core\Repositories\Traits;


trait QuickSearchAppend
{
    public function quickSearch($search)
    {
        return $this->where(self::QuickSearchField, $search, "Like")->limit(5)->get();
    }
}

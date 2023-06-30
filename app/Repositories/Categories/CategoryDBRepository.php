<?php

namespace App\Repositories\Categories;

use Illuminate\Support\Facades\DB;

class CategoryDBRepository implements CategoryInterface
{

    public function getCategoriesToTree()
    {
        return DB::table('categories')
            ->select(['id', 'name', 'slug', '_lft', '_rgt', 'parent_id'])
            ->orderBy('name')
            ->get()
            ->toTree();
    }
}

<?php

namespace App\Repositories\Categories;

use App\Models\Category;

class CategoryEloquentRepository implements CategoryInterface
{

    public function getCategoriesToTree()
    {
        return Category::query()->select(['id', 'name', 'slug', '_lft', '_rgt', 'parent_id'])->orderBy('name')->get()->toTree();
    }
}

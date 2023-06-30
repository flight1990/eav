<?php

namespace App\Repositories\Brands;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class BrandEloquentRepository implements BrandInterface
{
    public function getAllBrands(): Collection|array
    {
        return Brand::query()
            ->select(['id', 'name', 'slug'])
            ->orderBy('name')
            ->get();
    }
}

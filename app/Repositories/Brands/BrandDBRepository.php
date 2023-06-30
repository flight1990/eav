<?php

namespace App\Repositories\Brands;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BrandDBRepository implements BrandInterface
{
    public function getAllBrands(): array
    {
        return DB::table('brands')
            ->select(['id', 'name', 'slug'])
            ->orderBy('name')
            ->get()
            ->toArray();
    }
}

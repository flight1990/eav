<?php

namespace App\Repositories\Products;

use App\Models\Product;

class ProductEloquentRepository implements ProductInterface
{

    public function getAllProducts()
    {
        return Product::select(['id', 'name', 'slug'])
            ->when(request()->filled('filters.brands'), function ($q) {
                $q->whereHas('brand', function ($q) {
                    $q->whereIn('slug', request('filters.brands'));
                });
            })
            ->when(request()->has('filters.attributes'), function ($q) {
                foreach (request('filters.attributes') as $attributeID => $valuesIDS) {
                    $q->whereHas('attributeValues', function ($attributeValues) use ($attributeID, $valuesIDS) {
                            $attributeValues->where('attribute_id', $attributeID)->where(function ($q) use ($valuesIDS) {
                                $q->whereIn('attribute_values.id', $valuesIDS);
                            });
                        });
                    }
            })
            ->paginate();
    }
}

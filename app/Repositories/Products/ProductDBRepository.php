<?php

namespace App\Repositories\Products;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductDBRepository implements ProductInterface
{
    public function getAllProducts(): LengthAwarePaginator
    {
        return DB::table('products')
            ->select(['products.id', 'products.name', 'products.slug'])
            ->when(request()->filled('filters.brands'), function ($q) {
                $q->join('brands', 'brands.id', 'products.brand_id')
                    ->whereIn('brands.slug', request('filters.brands'));
            })
            ->when(request()->filled('filters.attributes'), function ($q) {
                $q->join('attribute_value_product', 'attribute_value_product.product_id', 'products.id')
                    ->join('attribute_values', 'attribute_values.id', 'attribute_value_product.attribute_value_id')
                    ->where(function ($q) {
                        foreach (request('filters.attributes') as $attributeID => $valuesIDS) {
                            $q->orWhere('attribute_values.attribute_id', $attributeID)
                                ->whereIn('attribute_values.id', $valuesIDS);
                        }
                    });
            })
            ->groupBy('products.id')
            ->when(count(request('filters.attributes', [])), function ($q) {
                $q->having(DB::raw('count(products.id)'), '>=', count(request('filters.attributes')));
            })
            ->paginate();
    }
}

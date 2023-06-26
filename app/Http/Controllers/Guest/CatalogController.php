<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttributeValueResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::search($request->input('query', ''))->query(function ($q) use ($request) {
            $q->select(['id', 'name', 'slug', 'category_id', 'brand_id'])
                ->when($request->filled('filters.brands'), function ($q) use ($request) {
                    $q->whereHas('brand', function ($q) use ($request) {
                        $q->whereIn('slug', $request->input('filters.brands'));
                    });
                })
                ->when(request()->has('filters.attributes'), function ($products) {
                    $products->when(request()->has('filters.attributes'), function ($q) {
                        foreach (request('filters.attributes') as $attributeID => $valuesIDS) {
                            $q->whereNotNull('attributes->' . $attributeID)->where(function ($q) use ($attributeID, $valuesIDS) {
                                foreach ($valuesIDS as $valuesID) {
                                    $q->orWhereJsonContains('attributes->' . $attributeID, $valuesID);
                                }
                            });
                        }
                    });
                })
                ->orderBy('name');
        })
            ->paginate(100)
            ->withQueryString();

        $brands = Brand::query()
            ->select(['id', 'name', 'slug'])
            ->orderBy('name')
            ->withCount('products')
            ->get()->toBase();

        $categories = Category::query()
            ->select(['id', 'name', 'slug', '_lft', '_rgt', 'parent_id'])
            ->orderBy('name')
            ->withCount('products')
            ->get()
            ->toTree();

        $attributeValues = AttributeValue::query()
            ->with(['attribute'])

            ->get();

        return inertia('Guest/Catalog/Index', [
            'products' => ProductResource::collection($products),
            'brands' => BrandResource::collection($brands),
            'categories' => CategoryResource::collection($categories),
            'attributeValues' => AttributeValueResource::collection($attributeValues)
                ->collection
                ->sortBy(['attribute.name', 'value'])
                ->groupBy('attribute.name')
        ]);
    }
}

<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttributeValueResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Repositories\Brands\BrandInterface;
use App\Repositories\Categories\CategoryInterface;
use App\Repositories\Products\ProductInterface;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class CatalogController extends Controller
{
    protected BrandInterface $brandRepository;
    protected ProductInterface $productRepository;
    protected CategoryInterface $categoryRepository;

    public function __construct(BrandInterface $brandRepository, ProductInterface $productRepository, CategoryInterface $categoryRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request): Response|ResponseFactory
    {
        $products = $this->productRepository->getAllProducts();
        $brands = $this->brandRepository->getAllBrands();
        $categories = $this->categoryRepository->getCategoriesToTree();

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

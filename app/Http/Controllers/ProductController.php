<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService
    ) {}

    public function index(Request $request)
    {
        $categoryId = $request->get('category');
        $sortBy = $request->get('sort', 'name');
        $products = $this->productService->getAllProducts($categoryId, $sortBy);
        $categories = $this->categoryService->getAllCategories();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(int $id)
    {
        $product = $this->productService->getProduct($id);
        return view('products.show', compact('product'));
    }
}

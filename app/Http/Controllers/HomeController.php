<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\CategoryService;

class HomeController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService
    ) {}

    public function index()
    {
        $featuredProducts = $this->productService->getFeaturedProducts();
        $categories = $this->categoryService->getAllCategories();

        return view('home.index', compact('featuredProducts', 'categories'));
    }
}

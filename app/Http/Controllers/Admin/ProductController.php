<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService
    ) {}

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|integer|exists:categories,id' // Validation pour category_id
        ]);

        // S'assurer que le ProductService gère bien category_id
        $this->productService->createProduct($validatedData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès');
    }

    public function edit(int $id)
    {
        $product = $this->productService->getProduct($id);
        $categories = $this->categoryService->getAllCategories();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|integer|exists:categories,id'
        ]);

        $product = $this->productService->getProduct($id);
        $this->productService->updateProduct($product, $validatedData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit mis à jour avec succès');
    }

    public function destroy(int $id)
    {
        $product = $this->productService->getProduct($id);
        $this->productService->deleteProduct($product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
}

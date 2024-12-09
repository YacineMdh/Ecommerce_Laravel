<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {}

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $this->categoryService->createCategory($validatedData);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès');
    }

    public function edit($id)
    {
        $category = $this->categoryService->getCategory($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category = $this->categoryService->getCategory($id);
        $this->categoryService->updateCategory($category, $validatedData);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès');
    }

    public function destroy($id)
    {
        $category = $this->categoryService->getCategory($id);
        $this->categoryService->deleteCategory($category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès');
    }
}

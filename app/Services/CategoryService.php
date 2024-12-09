<?php
// app/Services/CategoryService.php
namespace App\Services;

use App\Entities\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function createCategory(array $data): Category
    {
        $category = new Category();
        $category->setName($data['name']);
        $category->setDescription($data['description'] ?? null);

        $this->categoryRepository->save($category);

        return $category;
    }
}

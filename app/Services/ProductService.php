<?php

namespace App\Services;

use App\Entities\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class ProductService
{

    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository
    ) {}

    public function getAllProducts(): array
    {
        return $this->productRepository->findAll();
    }

    public function getProduct(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    public function createProduct(array $data): Product
    {
        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPrice($data['price']);
        $product->setStock($data['stock']);

        // Récupérer et définir la catégorie
        $category = $this->categoryRepository->find($data['category_id']);
        if (!$category) {
            throw new \Exception('Catégorie non trouvée');
        }
        $product->setCategory($category);

        $this->productRepository->save($product);

        return $product;
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPrice((float)$data['price']);
        $product->setStock((int)$data['stock']);

        $this->productRepository->save($product);

        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $this->productRepository->delete($product);
    }

    public function getFeaturedProducts(int $limit = 3): array
    {
        return $this->productRepository->findFeaturedProducts($limit);
    }
    public function getTotalProducts(): int
    {
        return $this->productRepository->getTotalCount();
    }

    public function getTopProducts(int $limit = 5): array
    {
        return $this->productRepository->findTopProducts($limit);
    }
}

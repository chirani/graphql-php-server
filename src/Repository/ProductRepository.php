<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProductRepository
{
    public function __construct(private EntityManagerInterface $em) {}

    public function findAll(): array
    {
        $products = $this->em
            ->getRepository(Product::class)
            ->findAll();

        count($products);

        return $products;
    }

    public function findByCategory(string $category): array
    {
        $products = $this->em
            ->getRepository(Product::class)
            ->findBy(["category" => $category]);

        count($products);

        return $products;
    }
}

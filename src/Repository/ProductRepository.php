<?php

namespace App\Repository;

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
}

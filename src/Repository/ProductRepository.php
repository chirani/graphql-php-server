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

    public function findByCategory(string $category): array
    {
        return $this->em->getRepository(Product::class)
            ->findBy(['category' => $category]);
    }

    public function findByCategory2(string $categoryId): array
    {
        $repository = $this->em->getRepository(Product::class);

        $queryBuilder = $repository->createQueryBuilder("p");

        $queryBuilder
            ->select('p')
            ->leftJoin('p.prices', 'pr')
            ->where('p.category = :category_id')
            ->setParameter('category_id', $categoryId);

        $results = $queryBuilder->getQuery()->getResult();

        return $results;
    }
}

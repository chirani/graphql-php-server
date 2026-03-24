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
            ->addSelect('pr')
            ->addSelect('cu')
            ->join('p.category', 'c')
            ->leftJoin('p.productAttributes', 'pa')
            ->leftJoin('pa.productAttributeValues', 'pav')
            ->leftJoin('p.brand', 'br')
            ->leftJoin('p.productContents', 'pc')
            ->leftJoin('p.prices', 'pr')
            ->leftJoin('pr.currency', 'cu')
            ->where('c.id = :category')
            ->setParameter('category', $categoryId);

        $results = $queryBuilder->getQuery()->getResult();

        return $results;
    }
}

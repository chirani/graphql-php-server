<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProductRepository
{
    public function __construct(private EntityManagerInterface $em) {}

    public function findAll(): array
    {
        $repository = $this->em->getRepository(Product::class);

        $queryBuilder = $repository->createQueryBuilder("p");

        $queryBuilder
            ->select('p')
            ->addSelect('pr')
            ->addSelect('cu')
            ->leftJoin('p.productAttributes', 'pa')
            ->leftJoin('pa.productAttributeValues', 'pav')
            ->leftJoin('p.brand', 'br')
            ->leftJoin('p.productContents', 'pc')
            ->leftJoin('p.prices', 'pr')
            ->leftJoin('pr.currency', 'cu');

        $results = $queryBuilder->getQuery()->getResult();

        return $results;
    }

    public function findByCategory(string $categoryId): array
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

    public function findById(string $productId) {
        $qb = $this->em->createQueryBuilder();

        $qb->select('p, pa, pav, br, pc, pr, cu')
            ->from(Product::class, 'p')
            ->leftJoin('p.productAttributes', 'pa')
            ->leftJoin('pa.productAttributeValues', 'pav')
            ->leftJoin('p.brand', 'br')
            ->leftJoin('p.productContents', 'pc')
            ->leftJoin('p.prices', 'pr')
            ->leftJoin('pr.currency', 'cu')
            ->where('p.id = :productId')
            ->setParameter('productId', $productId);

        $result = $qb->getQuery()->getResult();
        return $result;

    }
}

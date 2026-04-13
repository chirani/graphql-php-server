<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;

class CategoryRepository
{
    public function __construct(private EntityManagerInterface $em) {}

    public function findAll(): array
    {

        $categories = $this->em
            ->getRepository(Category::class)
            ->findAll();

        return $categories;
    }
}

<?php

namespace App\MyGraphql;

use App\MyGraphql\ObjectTypes\CategoryType;
use App\MyGraphql\ObjectTypes\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;

class SchemaBuilder
{
    public static function build(EntityManager $entityManager): Schema
    {

        $categoryRepo = new CategoryRepository($entityManager);
        $productRepo = new ProductRepository($entityManager);

        // Reminder for myself : Complex types must be defined here::
        $categoryType = new CategoryType();
        $productType = new ProductType();

        $queryType = new ObjectType([
            "name" => "Query",
            'fields' => [
                'hello' => [
                    'type' => Type::string(),
                    'resolve' => fn() => 'Heyyooo!'
                ],
                'categories' => [
                    'type' => Type::listOf($categoryType),
                    'resolve' => function () use ($categoryRepo) {
                        return $categoryRepo->findAll();
                    }
                ],
                'product' =>[
                    "type" => Type::listOf($productType),
                    'args' => [
                        'productId' => Type::string()
                    ],
                    'resolve' => function ($_, $args) use ($productRepo) {
                        return $productRepo->findById($args["productId"]);
                    }
                ],
                "products" => [
                    "type" => Type::listOf($productType),
                    'args' => [
                        'category' => Type::string()
                    ],
                    'resolve' => function ($_, $args) use ($productRepo) {
                        if ($args["category"] === "all") {
                            return $productRepo->findAll();
                        } else {
                            return $productRepo->findByCategory($args["category"]);
                        }
                    }
                ]
            ]
        ]);

        return new Schema(['query' => $queryType]);
    }
}

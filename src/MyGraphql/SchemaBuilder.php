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
        $productType = new ObjectType([
            "name" => "Product",
            "fields" => [
                "id" => Type::int(),
                "name" => Type::string(),
                "category_id" => Type::string(),
            ]
        ]);
        $categoryRepo = new CategoryRepository($entityManager);
        $productRepo = new ProductRepository($entityManager);

        $queryType = new ObjectType([
            "name" => "Query",
            'fields' => [
                'hello' => [
                    'type' => Type::string(),
                    'resolve' => fn() => 'Heyyooo!'
                ],
                'categories' => [
                    'type' => Type::listOf(new CategoryType()),
                    'resolve' => function () use ($categoryRepo) {
                        return $categoryRepo->findAll();
                    }
                ],
                "products" => [
                    "type" => Type::listOf(new ProductType()),
                    'args' => [
                        'category' => Type::string()
                    ],
                    'resolve' => function ($_, $args) use ($productRepo) {
                        if ($args["category"] === "all") {
                            return $productRepo->findAll();
                        }
                    }
                ]
            ]
        ]);

        return new Schema(['query' => $queryType]);
    }
}

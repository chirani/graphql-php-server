<?php

namespace App\MyGraphql;

use App\MyGraphql\ObjectTypes\CategoryType;
use App\Repository\CategoryRepository;
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
                ]
            ]
        ]);

        return new Schema(['query' => $queryType]);
    }
}

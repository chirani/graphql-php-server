<?php

namespace App\MyGraphql;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;

class SchemaBuilder
{
    public static function build(): Schema
    {
        $productType = new ObjectType([
            "name" => "Product",
            "fields" => [
                "id" => Type::int(),
                "name" => Type::string(),
                "category_id" => Type::string(),
            ]
        ]);

        $queryType = new ObjectType([
            "name" => "Query",
            'fields' => [
                'hello' => [
                    'type' => Type::string(),
                    'resolve' => fn() => 'Heyyooo!'
                ]
            ]
        ]);

        return new Schema(['query' => $queryType]);
    }
}

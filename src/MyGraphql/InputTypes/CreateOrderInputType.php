<?php

namespace App\MyGraphql\InputTypes;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class CreateOrderInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'CreateOrderInput',
            'fields' => function () {
                return [
                    'email' => Type::nonNull(Type::string()),
                    'name' => Type::nonNull(Type::string()),
                    'currencyId' => Type::nonNull(Type::string()),
                    'address' => Type::nonNull(Type::string()),
                    'message' => Type::string(),
                    'items' => Type::listOf(new OrderItemInputType()),
                ];
            }
        ]);
    }
}

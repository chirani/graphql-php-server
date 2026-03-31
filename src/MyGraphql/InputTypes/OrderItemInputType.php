<?php

namespace App\MyGraphql\InputTypes;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class OrderItemInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'OrderItemInput',
            'fields' => function () {
                return [
                    'productId' => Type::nonNull(Type::string()),
                    'quantity' => Type::nonNull(Type::int()),
                    'attributes' => Type::listOf(new OrderItemAttributeInputType()),
                ];
            }
        ]);
    }
}

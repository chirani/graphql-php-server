<?php

namespace App\MyGraphql\ObjectTypes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class MessageType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'CreateOrderResponse',
            'fields' => [
                'message' => Type::getNullableType(Type::string()),
            ],
        ]);
    }
}

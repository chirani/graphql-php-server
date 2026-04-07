<?php

namespace App\MyGraphql;

use App\MyGraphql\InputTypes\CreateOrderInputType;
use App\MyGraphql\ObjectTypes\CategoryType;
use App\MyGraphql\ObjectTypes\MessageType;
use App\MyGraphql\ObjectTypes\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use GraphQL\Error\UserError;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;

class SchemaBuilder
{
    public static function build(EntityManager $entityManager): Schema
    {

        $categoryRepo = new CategoryRepository($entityManager);
        $productRepo = new ProductRepository($entityManager);
        $orderRepo = new OrderRepository($entityManager);

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
                'product' => [
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

        $messageType = new MessageType();

        $mutationType = new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'setMessage' => [
                    'type' => Type::string(),
                    'args' => [
                        'message' => Type::string(),
                    ],
                    'resolve' => function ($_, $args) {
                        return "Message received: " . $args['message'];
                    }
                ],
                'createOrder' => [
                    'type' => $messageType,
                    'args' => [
                        'input' => Type::nonNull(new CreateOrderInputType()),
                    ],
                    'resolve' => function ($_, $args) use ($orderRepo) {
                        try {
                            $orderData = $args['input'];

                            $cartItems = $orderData['items'] ?? null;
                            $email = $orderData['email'] ?? null;
                            $name = $orderData['name'] ?? null;
                            $address = $orderData['address'] ?? null;
                            $currencyId = $orderData['currencyId'] ?? null;

                            // --- Validation ---
                            if (!$cartItems || !is_array($cartItems) || count($cartItems) === 0) {
                                throw new UserError('Cart items are required and cannot be empty.', 400);
                            }
                            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                throw new UserError('Invalid email address.', 400);
                            }
                            if (!$name) {
                                throw new UserError('Name is required.', 400);
                            }
                            if (!$address) {
                                throw new UserError('Address is required.', 400);
                            }
                            if (!$currencyId) {
                                throw new UserError('Currency ID is required.', 400);
                            }

                            $orderRepo->createOrder($cartItems, $name, $email, $address, $currencyId);

                            return [
                                'message' => 'Order made',
                            ];
                        } catch (UserError $e) {

                            throw $e;
                        } catch (\Throwable $e) {

                            error_log($e->getMessage());

                            throw new UserError('Internal server error. Please try again later.', 400);
                        }
                    }
                ]
            ],
        ]);

        return new Schema(['query' => $queryType, 'mutation' => $mutationType]);
    }
}

<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\OrderItemAttribute;
use App\Entity\Product;
use App\Entity\ProductAttribute;
use App\Entity\ProductAttributeValue;
use App\Http\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(private EntityManagerInterface $em) {}

    public function createOrder(array $cartItems, string $name, string $email, string $address, string $currencyId): Order
    {

        $response = new Response();
        $em = $this->em;

        $order = new Order($name, $email, $address);
        $currency = $em->getRepository(Currency::class)->find($currencyId);
        $order->setCurrency($currency);

        foreach ($cartItems as $cartItem) {
            $product = $em->getRepository(Product::class)
                ->find($cartItem['productId']);


            if (is_null($product)) {
                $response->error("Product not Found in DB", 404);
            }

            $orderItem = new OrderItem(
                $order,
                $product,
                $cartItem['price_amount'],
                $cartItem['quantity']
            );

            $em->persist($orderItem);

            foreach ($cartItem['attributes'] as $attributeId => $attributeValueId) {
                $attribute = $em->getRepository(ProductAttribute::class)
                    ->find($attributeId);

                if (is_null($attribute)) {
                    $response->error("Attribute not Found", 404);
                }

                $attributeValue = $em->getRepository(ProductAttributeValue::class)
                    ->find($attributeValueId);

                if (is_null($attributeValue)) {
                    $response->error("Attribute Value not Found", 404);
                }

                $orderItemAttribute = new OrderItemAttribute(
                    $orderItem,
                    $attribute,
                    $attributeValue
                );

                $em->persist($orderItemAttribute);
            }
        }

        $em->persist($order);
        $em->flush();

        return $order;
    }
}

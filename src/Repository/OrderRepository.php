<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\OrderItemAttribute;
use App\Entity\Product;
use App\Entity\ProductAttribute;
use App\Entity\ProductAttributeValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\UserError;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(private EntityManagerInterface $em) {}

    public function createOrder(array $cartItems, string $name, string $email, string $address, string $currencyId): Order
    {
        $em = $this->em;

        $order = new Order($name, $email, $address);
        $currency = $em->getRepository(Currency::class)->find($currencyId);
        $order->setCurrency($currency);

        foreach ($cartItems as $cartItem) {
            $product = $em->getRepository(Product::class)
                ->find($cartItem['productId']);

            if (is_null($product)) {
                throw new UserError("Product not Found in DB", 404);
            }

            $orderItem = new OrderItem(
                $order,
                $product,
                $cartItem['price_amount'],
                $cartItem['quantity']
            );

            $em->persist($orderItem);

            foreach ($cartItem['attributes'] as $itemAttribute) {
                $attributeId = $itemAttribute["attributeId"];
                $attributeValueId = $itemAttribute["attributeValueId"];

                $attribute = $em->getRepository(ProductAttribute::class)
                    ->findOneBy(["sid" => $attributeId, "product" => $product->getId()]);


                if (is_null($attribute)) {
                    throw new UserError("Attribute not Found", 404);
                }

                $attributeValue = $em->getRepository(ProductAttributeValue::class)
                    ->findBy(["id" => $attributeValueId]);


                if (!count($attributeValue)) {
                    throw new UserError("Attribute Value not Found", 404);
                }

                $orderItemAttribute = new OrderItemAttribute();
                $orderItemAttribute->setOrderItem($orderItem);
                $orderItemAttribute->setProductAttribute($attribute);
                $orderItemAttribute->setProductAttributeValue($attributeValue[0]);

                $em->persist($orderItemAttribute);
            }
        }

        $em->persist($order);
        $em->flush();

        return $order;
    }
}

<?php

namespace App\Entity;

use App\Entity\Order;
use App\Entity\OrderItemAttribute;
use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "order_items")]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: "order_items")]
    #[ORM\JoinColumn(name: "order_id", referencedColumnName: "id")]
    private Order $order;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private float $price_amount;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'order_items')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', columnDefinition: "VARCHAR(255)")]
    private ?Product $product = null;

    #[ORM\Column(type: "integer")]
    private int $quantity;

    #[ORM\OneToMany(mappedBy: "orderItem", targetEntity: OrderItemAttribute::class)]
    private Collection $attributes;

    public function __construct(
        Order $order,
        Product $product,
        float $price_amount,
        int $quantity
    ) {
        $this->order = $order;
        $this->product = $product;
        $this->price_amount = $price_amount;
        $this->quantity = $quantity;
        $this->attributes = new ArrayCollection();
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
}

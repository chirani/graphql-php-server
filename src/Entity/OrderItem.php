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

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: "items")]
    #[ORM\JoinColumn(name: "order_id", referencedColumnName: "id")]
    private Order $order;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id")]
    private Product $product;

    #[ORM\Column(type: "string")]
    private string $name;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private float $price;

    #[ORM\Column(type: "integer")]
    private int $quantity;

    #[ORM\OneToMany(mappedBy: "orderItem", targetEntity: OrderItemAttribute::class)]
    private Collection $attributes;

    public function __construct(
        Order $order,
        Product $product,
        string $name,
        float $price,
        int $quantity
    ) {
        $this->order = $order;
        $this->product = $product;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->attributes = new ArrayCollection();
    }
}

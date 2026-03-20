<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'prices')]
class Price
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: 'float')]
    private float $amount;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'prices')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Currency::class, inversedBy: 'prices')]
    #[ORM\JoinColumn(name: 'currency_id', referencedColumnName: 'id', nullable: false)]
    private ?Currency $currency = null;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
    }
}

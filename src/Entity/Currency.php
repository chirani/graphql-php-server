<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'currency')]
class Currency
{
    #[ORM\Id]
    #[ORM\Column(type: "string")]
    private string $id;

    #[ORM\Column(type: "string")]
    private string $label;

    #[ORM\Column(type: "string")]
    private string $symbol;

    #[ORM\OneToMany(mappedBy: 'currency', targetEntity: Price::class)]
    private Collection $prices;

    #[ORM\OneToMany(mappedBy: "currency", targetEntity: Order::class)]
    private Collection $orders;

    public function __construct(string $label, string $symbol)
    {
        $this->id = $label;
        $this->label = $label;
        $this->symbol = $symbol;
        $this->prices = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}

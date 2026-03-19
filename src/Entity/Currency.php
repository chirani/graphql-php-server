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

    #[ORM\OneToMany(mappedBy: 'prices', targetEntity: Price::class)]
    private Collection $prices;

    public function __construct(string $label, string $symbol)
    {
        $this->id = $label;
        $this->label = $label;
        $this->symbol = $symbol;
        $this->prices = new ArrayCollection();
    }
}

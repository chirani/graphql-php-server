<?php

namespace App\Entity;

use App\Entity\OrderItem as EntityOrderItem;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "orders")]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $address;

    #[ORM\Column(type: "datetime")]
    private \DateTime $createdAt;

    #[ORM\OneToMany(mappedBy: "order", targetEntity: EntityOrderItem::class)]
    private Collection $items;

    #[ORM\ManyToOne(targetEntity: Currency::class, inversedBy: "orders")]
    #[ORM\JoinColumn(name: "currency_id", referencedColumnName: "id", columnDefinition: "VARCHAR(255)")]
    private Currency $currency;

    public function __construct(string $name, string $email, string $address)
    {
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->createdAt = new \DateTime();
        $this->items = new ArrayCollection();
    }
    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

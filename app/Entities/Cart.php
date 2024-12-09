<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'carts')]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'cart')]
    private User $user;

    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'cart', cascade: ['persist', 'remove'])]
    private Collection $items;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $total = '0.00';

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    // Getters and setters

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(CartItem $item): void
    {
        $this->items->add($item);
        $item->setCart($this);
    }

    public function removeItem(CartItem $item): void
    {
        $this->items->removeElement($item);
    }

    public function getTotal(): float
    {
        return (float) $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = (string) $total;
    }

}

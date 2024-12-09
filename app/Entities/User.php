<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Contracts\Auth\Authenticatable;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User implements Authenticatable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'boolean')]
    private bool $isAdmin = false;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'user')]
    private Collection $orders;

    #[ORM\OneToOne(targetEntity: Cart::class, mappedBy: 'user')]
    private ?Cart $cart = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $rememberToken = null;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    // Getters and setters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function addOrder(Order $order): void
    {
        $this->orders->add($order);
    }

    public function removeOrder(Order $order): void
    {
        $this->orders->removeElement($order);
    }

    public function addCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->id;
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    public function setRememberToken($value): void
    {
        $this->rememberToken = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }
}

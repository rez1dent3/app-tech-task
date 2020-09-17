<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 * @package App\Entity
 * @ORM\Entity(repositoryClass="\App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 * @ORM\HasLifecycleCallbacks
 */
class Order
{

    use Traits\HasTimestamps;

    public const STATUS_NEW = 'new';
    public const STATUS_PAID = 'paid';

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2)
     */
    protected float $amount = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", name="user_id")
     */
    protected int $userId = 1; // default value

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected string $status = self::STATUS_NEW;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(
     *     name="orders_products",
     *     joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     * )
     */
    protected Collection $products;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isNewStatus(): bool
    {
        return $this->getStatus() === self::STATUS_NEW;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Product $product
     * @return self
     */
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->amount += $product->getPrice();
            $this->products->add($product);
        }

        return $this;
    }

    /**
     * @param Product[] $products
     * @return self
     */
    public function addProducts(iterable $products): self
    {
        foreach ($products as $product) {
            $this->addProduct($product);
        }

        return $this;
    }

}

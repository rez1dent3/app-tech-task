<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package App\Entity
 * @ORM\Entity(repositoryClass="\App\Repository\ProductRepository")
 * @ORM\Table(name="projects")
 */
class Product
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected string $name;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    protected float $price;

    /**
     * @var \DateTimeInterface|null
     * @ORM\Column(type="datetime")
     */
    protected ?\DateTimeInterface $createdAt;

    /**
     * @var \DateTimeInterface|null
     * @ORM\Column(type="datetime")
     */
    protected ?\DateTimeInterface $updatedAt;

}

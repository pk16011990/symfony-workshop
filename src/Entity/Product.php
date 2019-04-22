<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=3)
     * @var string
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $hidden;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Flag")
     * @ORM\Cache()
     * @var \App\Entity\Flag[]|\Doctrine\Common\Collections\ArrayCollection
     */
    private $flags;

    /**
     * @param string $name
     * @param string $price
     * @param bool $hidden
     * @param array $flags
     */
    public function __construct(string $name, string $price, bool $hidden, array $flags)
    {
        $this->name = $name;
        $this->price = $price;
        $this->hidden = $hidden;
        $this->flags = new ArrayCollection($flags);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * @return \App\Entity\Flag[]
     */
    public function getFlags(): array
    {
        return $this->flags->toArray();
    }

}
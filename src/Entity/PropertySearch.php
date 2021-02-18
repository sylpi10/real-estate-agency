<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraint as Assert;

class PropertySearch
{
    /**
     * @var int|null
     * @Assert\Range(min=12, max=400)
     */
    private $minSurface;
    private $maxPrice;

    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    public function setMinSurface(int $minSurface): self
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }
}

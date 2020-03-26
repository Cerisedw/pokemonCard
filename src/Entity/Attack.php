<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttackRepository")
 */
class Attack
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=550, nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $damage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $convertedEnergyCost;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Type", inversedBy="attacks", cascade={"persist"})
     */
    private $cost;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Card", mappedBy="attacks")
     */
    private $cards;

    public function __construct(array $arr)
    {
        $this->cost = new ArrayCollection();
        $this->hydrate($arr);
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDamage(): ?string
    {
        return $this->damage;
    }

    public function setDamage(?string $damage): self
    {
        $this->damage = $damage;

        return $this;
    }

    public function getConvertedEnergyCost(): ?int
    {
        return $this->convertedEnergyCost;
    }

    public function setConvertedEnergyCost(?int $convertedEnergyCost): self
    {
        $this->convertedEnergyCost = $convertedEnergyCost;

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function getCost(): Collection
    {
        return $this->cost;
    }

    public function addCost(Type $cost): self
    {
        if (!$this->cost->contains($cost)) {
            $this->cost[] = $cost;
        }

        return $this;
    }

    public function removeCost(Type $cost): self
    {
        if ($this->cost->contains($cost)) {
            $this->cost->removeElement($cost);
        }

        return $this;
    }



    private function hydrate (array $donnees){
        foreach($donnees as $key => $value){
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->addAttack($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            $card->removeAttack($this);
        }

        return $this;
    }

}

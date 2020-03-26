<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nationalPokedexNumber;

    /**
     * @ORM\Column(type="string", length=350, nullable=true)
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="string", length=350, nullable=true)
     */
    private $imageUrlHiRes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $supertype;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hp;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $convertedRetreatCost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $artist;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rarity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $series;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $setCollection;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $setCode;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Type", inversedBy="cards", cascade={"persist"})
     */
    private $types;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Attack", inversedBy="cards", cascade={"persist"})
     */
    private $attacks;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Weakness", cascade={"persist", "remove"})
     */
    private $weakness;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ability", cascade={"persist", "remove"})
     */
    private $abilities;



    public function __construct(array $arr)
    {
        $this->hydrate($arr);
        $this->types = new ArrayCollection();
        $this->attacks = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNationalPokedexNumber(): ?int
    {
        return $this->nationalPokedexNumber;
    }

    public function setNationalPokedexNumber(?int $nationalPokedexNumber): self
    {
        $this->nationalPokedexNumber = $nationalPokedexNumber;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getImageUrlHiRes(): ?string
    {
        return $this->imageUrlHiRes;
    }

    public function setImageUrlHiRes(?string $imageUrlHiRes): self
    {
        $this->imageUrlHiRes = $imageUrlHiRes;

        return $this;
    }

    public function getSupertype(): ?string
    {
        return $this->supertype;
    }

    public function setSupertype(?string $supertype): self
    {
        $this->supertype = $supertype;

        return $this;
    }

    public function getHp(): ?string
    {
        return $this->hp;
    }

    public function setHp(?string $hp): self
    {
        $this->hp = $hp;

        return $this;
    }

    public function getConvertedRetreatCost(): ?int
    {
        return $this->convertedRetreatCost;
    }

    public function setConvertedRetreatCost(?int $convertedRetreatCost): self
    {
        $this->convertedRetreatCost = $convertedRetreatCost;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(?string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(?string $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(?string $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getSetCollection(): ?string
    {
        return $this->setCollection;
    }

    public function setSetCollection(?string $setCollection): self
    {
        $this->setCollection = $setCollection;

        return $this;
    }

    public function getSetCode(): ?string
    {
        return $this->setCode;
    }

    public function setSetCode(?string $setCode): self
    {
        $this->setCode = $setCode;

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
     * @return Collection|Type[]
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->types->contains($type)) {
            $this->types->removeElement($type);
        }

        return $this;
    }

    /**
     * @return Collection|Attack[]
     */
    public function getAttacks(): Collection
    {
        return $this->attacks;
    }

    public function addAttack(Attack $attack): self
    {
        if (!$this->attacks->contains($attack)) {
            $this->attacks[] = $attack;
        }

        return $this;
    }

    public function removeAttack(Attack $attack): self
    {
        if ($this->attacks->contains($attack)) {
            $this->attacks->removeElement($attack);
        }

        return $this;
    }

    public function getWeakness(): ?Weakness
    {
        return $this->weakness;
    }

    public function setWeakness(?Weakness $weakness): self
    {
        $this->weakness = $weakness;

        return $this;
    }

    public function getAbilities(): ?Ability
    {
        return $this->abilities;
    }

    public function setAbilities(?Ability $abilities): self
    {
        $this->abilities = $abilities;

        return $this;
    }


}

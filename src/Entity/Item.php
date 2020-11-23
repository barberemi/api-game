<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 *
 * @UniqueEntity("name")
 */
class Item
{
    use TimestampableEntity;

    const COMMON_RARITY    = 'common';
    const UNUSUAL_RARITY   = 'unusual';
    const RARE_RARITY      = 'rare';
    const EPIC_RARITY      = 'epic';
    const LEGENDARY_RARITY = 'legendary';
    const RARITIES = [self::COMMON_RARITY, self::UNUSUAL_RARITY, self::RARE_RARITY, self::EPIC_RARITY, self::LEGENDARY_RARITY];

    const CRAFT_TYPE     = 'craft';
    const HELMET_TYPE    = 'helmet';
    const AMULET_TYPE    = 'amulet';
    const SHOULDERS_TYPE = 'shoulders';
    const GLOVERS_TYPE   = 'glovers';
    const ARMOR_TYPE     = 'armor';
    const BELT_TYPE      = 'belt';
    const PANTS_TYPE     = 'pants';
    const SHOES_TYPE     = 'shoes';
    const WEAPON_TYPE    = 'weapon';
    const TYPES = [
        self::CRAFT_TYPE, self::HELMET_TYPE, self::AMULET_TYPE, self::SHOULDERS_TYPE, self::GLOVERS_TYPE,
        self::ARMOR_TYPE, self::BELT_TYPE, self::PANTS_TYPE, self::SHOES_TYPE, self::WEAPON_TYPE
    ];

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"update"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $cost;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $level;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     *
     * @Serializer\Expose
     * @Serializer\Type("float")
     * @Serializer\Groups({"create", "update"})
     */
    protected $dropRate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Choice(choices=ITEM::RARITIES)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $rarity = self::COMMON_RARITY;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Choice(choices=Item::TYPES)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $type = self::CRAFT_TYPE;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="item", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\BindCharacteristic>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $characteristics;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Crafting", mappedBy="itemToCraft", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Crafting>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $itemsToCraft;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Crafting", mappedBy="itemNeededToCraft", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Crafting>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $itemsNeededToCraft;

    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->characteristics = new ArrayCollection();
        $this->itemsToCraft = new ArrayCollection();
        $this->itemsNeededToCraft = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return Item
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Item
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     *
     * @return Item
     */
    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     *
     * @return Item
     */
    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return float
     */
    public function getDropRate(): float
    {
        return $this->dropRate;
    }

    /**
     * @param float $dropRate
     * @return Item
     */
    public function setDropRate(float $dropRate): self
    {
        $this->dropRate = $dropRate;

        return $this;
    }

    /**
     * @return string
     */
    public function getRarity(): string
    {
        return $this->rarity;
    }

    /**
     * @param string $rarity
     * @return Item
     */
    public function setRarity(string $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Item
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCharacteristics(): Collection
    {
        return $this->characteristics;
    }

    /**
     * @param Collection $characteristics
     *
     * @return Item
     */
    public function setCharacteristics(Collection $characteristics): self
    {
        $this->characteristics = $characteristics;

        return $this;
    }

    /**
     * @param Characteristic $characteristic
     *
     * @return Item
     */
    public function addCharacteristic(Characteristic $characteristic): self
    {
        if (!$this->characteristics->contains($characteristic)) {
            $this->characteristics[] = $characteristic;
            $characteristic->addItem($this);
        }

        return $this;
    }

    /**
     * @param Characteristic $characteristic
     *
     * @return Item
     */
    public function removeCharacteristic(Characteristic $characteristic): self
    {
        if ($this->characteristics->contains($characteristic)) {
            $this->characteristics->removeElement($characteristic);
            $characteristic->removeItem($this);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItemsToCraft(): ArrayCollection
    {
        return $this->itemsToCraft;
    }

    /**
     * @param ArrayCollection $itemsToCraft
     * @return Item
     */
    public function setItemsToCraft(ArrayCollection $itemsToCraft): self
    {
        $this->itemsToCraft = $itemsToCraft;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItemsNeededToCraft(): ArrayCollection
    {
        return $this->itemsNeededToCraft;
    }

    /**
     * @param ArrayCollection $itemsNeededToCraft
     * @return Item
     */
    public function setItemsNeededToCraft(ArrayCollection $itemsNeededToCraft): self
    {
        $this->itemsNeededToCraft = $itemsNeededToCraft;

        return $this;
    }
}

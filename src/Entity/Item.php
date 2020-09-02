<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 *
 * @UniqueEntity("name")
 */
class Item
{
    use TimestampableEntity;

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
     * Item constructor.
     */
    public function __construct()
    {
        $this->characteristics = new ArrayCollection();
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
}

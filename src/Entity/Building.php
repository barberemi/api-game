<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="building")
 * @ORM\Entity(repositoryClass="App\Repository\BuildingRepository")
 *
 * @UniqueEntity("name")
 */
class Building
{
    use TimestampableEntity;

    const ORB_TYPE      = 'orb';
    const ACTION_TYPE   = 'action';
    const DEFENSE_TYPE  = 'defense';
    const USER_BAG_TYPE = 'user_bag';
    const TOWN_BAG_TYPE = 'town_bag';
    const TYPES = [self::USER_BAG_TYPE, self::TOWN_BAG_TYPE, self::DEFENSE_TYPE, self::ACTION_TYPE, self::ORB_TYPE];

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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $label;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Choice(choices=Building::TYPES)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $type = self::DEFENSE_TYPE;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $amount = 1;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $description;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     *
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"create", "update"})
     */
    protected $isUserBuilding = true;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $neededActions = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $neededMaterials = 10;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Building", mappedBy="parent", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Building>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $children;

    /**
     * @var Building
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Building", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Building")
     * @Serializer\Groups({"create", "update"})
     */
    protected $parent;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Construction", mappedBy="building", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Construction>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $constructions;

    /**
     * Building constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->constructions = new ArrayCollection();
    }

    /**
     * @Serializer\VirtualProperty()
     * @return null|int
     */
    public function hasParentId(): ?int
    {
        return $this->getParent() ? $this->getParent()->getId() : null;
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
     * @return Building
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
     * @return Building
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Building
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Building
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @return Building
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUserBuilding(): bool
    {
        return $this->isUserBuilding;
    }

    /**
     * @param bool $isUserBuilding
     * @return Building
     */
    public function setIsUserBuilding(bool $isUserBuilding): self
    {
        $this->isUserBuilding = $isUserBuilding;

        return $this;
    }

    /**
     * @return int
     */
    public function getNeededMaterials(): int
    {
        return $this->neededMaterials;
    }

    /**
     * @param int $neededMaterials
     * @return Building
     */
    public function setNeededMaterials(int $neededMaterials): self
    {
        $this->neededMaterials = $neededMaterials;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren(): ArrayCollection
    {
        return $this->children;
    }

    /**
     * @param ArrayCollection $children
     *
     * @return Building
     */
    public function setChildren(ArrayCollection $children): self
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @param Building $child
     *
     * @return Building
     */
    public function addChildren(Building $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    /**
     * @param Building $child
     *
     * @return Building
     */
    public function removeChildren(Building $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            $child->setParent(null);
        }

        return $this;
    }

    /**
     * @return null|Building
     */
    public function getParent(): ?Building
    {
        return $this->parent;
    }

    /**
     * @param null|Building $parent
     *
     * @return Building
     */
    public function setParent(?Building $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return int
     */
    public function getNeededActions(): int
    {
        return $this->neededActions;
    }

    /**
     * @param int $neededActions
     * @return Building
     */
    public function setNeededActions(int $neededActions): self
    {
        $this->neededActions = $neededActions;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getConstructions()
    {
        return $this->constructions;
    }

    /**
     * @param Collection $constructions
     * @return Building
     */
    public function setConstructions(Collection $constructions): self
    {
        $this->constructions = $constructions;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Building
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}

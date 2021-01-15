<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="map")
 * @ORM\Entity(repositoryClass="App\Repository\MapRepository")
 *
 * @UniqueEntity("name")
 */
class Map
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
    protected $levelMin = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $nbFloors = 10;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Monster", mappedBy="map", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Monster>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $monsters;

    /**
     * Map constructor.
     */
    public function __construct()
    {
        $this->monsters = new ArrayCollection();
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
     * @return Map
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
     * @return Map
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevelMin(): int
    {
        return $this->levelMin;
    }

    /**
     * @param int $levelMin
     *
     * @return Map
     */
    public function setLevelMin(int $levelMin): self
    {
        $this->levelMin = $levelMin;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMonsters(): Collection
    {
        return $this->monsters;
    }

    /**
     * @param ArrayCollection $monsters
     *
     * @return Map
     */
    public function setMonsters(ArrayCollection $monsters): self
    {
        $this->monsters = $monsters;

        return $this;
    }

    /**
     * @param Monster $monster
     *
     * @return Map
     */
    public function addMonster(Monster $monster): self
    {
        if (!$this->monsters->contains($monster)) {
            $this->monsters[] = $monster;
            $monster->setMap($this);
        }

        return $this;
    }

    /**
     * @param Monster $monster
     *
     * @return Map
     */
    public function removeMonster(Monster $monster): self
    {
        if ($this->monsters->contains($monster)) {
            $this->monsters->removeElement($monster);
            $monster->setMap(null);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getNbFloors(): int
    {
        return $this->nbFloors;
    }

    /**
     * @param int $nbFloors
     * @return Map
     */
    public function setNbFloors(int $nbFloors): self
    {
        $this->nbFloors = $nbFloors;

        return $this;
    }

    /**
     * @return Monster|null
     */
    public function getBoss(): ?Monster
    {
        /** @var Monster $monster */
        foreach ($this->getMonsters() as $monster) {
            if ($monster->isBoss()) {
                return $monster;
            }
        }

        return null;
    }
}

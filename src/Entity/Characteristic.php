<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="characteristic")
 * @ORM\Entity(repositoryClass="App\Repository\CharacteristicRepository")
 *
 * @UniqueEntity("name")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Characteristic
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
     * @ORM\Column(type="text")
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $description;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="characteristic", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     */
    protected $monsterCharacteristics;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="characteristic", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     */
    protected $skillCharacteristics;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="characteristic", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     */
    protected $baseAcademyCharacteristics;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="characteristic", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     */
    protected $academyCharacteristics;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="characteristic", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     */
    protected $itemCharacteristics;

    /**
     * Characteristic constructor.
     */
    public function __construct()
    {
        $this->monsterCharacteristics = new ArrayCollection();
        $this->skillCharacteristics = new ArrayCollection();
        $this->baseAcademyCharacteristics = new ArrayCollection();
        $this->academyCharacteristics = new ArrayCollection();
        $this->itemCharacteristics = new ArrayCollection();
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
     * @return Characteristic
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
     * @return Characteristic
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
     *
     * @return Characteristic
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
     * @return Characteristic
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMonsterCharacteristics(): Collection
    {
        return $this->monsterCharacteristics;
    }

    /**
     * @param Collection $monsterCharacteristics
     *
     * @return Characteristic
     */
    public function setMonsterCharacteristics(Collection $monsterCharacteristics): self
    {
        $this->monsterCharacteristics = $monsterCharacteristics;

        return $this;
    }

    /**
     * @param Monster $monster
     *
     * @return Characteristic
     */
    public function addMonster(Monster $monster): self
    {
        if (!$this->monsterCharacteristics->contains($monster)) {
            $this->monsterCharacteristics[] = $monster;
            $monster->addCharacteristic($this);
        }

        return $this;
    }

    /**
     * @param Monster $monster
     *
     * @return Characteristic
     */
    public function removeMonster(Monster $monster): self
    {
        if ($this->monsterCharacteristics->contains($monster)) {
            $this->monsterCharacteristics->removeElement($monster);
            $monster->removeCharacteristic($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSkillCharacteristics(): Collection
    {
        return $this->skillCharacteristics;
    }

    /**
     * @param Collection $skillCharacteristics
     *
     * @return Characteristic
     */
    public function setSkillCharacteristics(Collection $skillCharacteristics): self
    {
        $this->skillCharacteristics = $skillCharacteristics;

        return $this;
    }

    /**
     * @param Skill $skill
     *
     * @return Characteristic
     */
    public function addSkill(Skill $skill): self
    {
        if (!$this->skillCharacteristics->contains($skill)) {
            $this->skillCharacteristics[] = $skill;
            $skill->addCharacteristic($this);
        }

        return $this;
    }

    /**
     * @param Skill $skill
     *
     * @return Characteristic
     */
    public function removeSkill(Skill $skill): self
    {
        if ($this->skillCharacteristics->contains($skill)) {
            $this->skillCharacteristics->removeElement($skill);
            $skill->removeCharacteristic($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getBaseAcademyCharacteristics(): Collection
    {
        return $this->baseAcademyCharacteristics;
    }

    /**
     * @param Collection $baseAcademyCharacteristics
     *
     * @return Characteristic
     */
    public function setBaseAcademyCharacteristics(Collection $baseAcademyCharacteristics): self
    {
        $this->baseAcademyCharacteristics = $baseAcademyCharacteristics;

        return $this;
    }

    /**
     * @param Academy $academy
     *
     * @return Characteristic
     */
    public function addBaseAcademy(Academy $academy): self
    {
        if (!$this->baseAcademyCharacteristics->contains($academy)) {
            $this->baseAcademyCharacteristics[] = $academy;
            $academy->addBaseCharacteristic($this);
        }

        return $this;
    }

    /**
     * @param Academy $academy
     *
     * @return Characteristic
     */
    public function removeBaseAcademy(Academy $academy): self
    {
        if ($this->baseAcademyCharacteristics->contains($academy)) {
            $this->baseAcademyCharacteristics->removeElement($academy);
            $academy->removeBaseCharacteristic($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAcademyCharacteristics(): Collection
    {
        return $this->academyCharacteristics;
    }

    /**
     * @param Collection $academyCharacteristics
     *
     * @return Characteristic
     */
    public function setAcademyCharacteristics(Collection $academyCharacteristics): self
    {
        $this->academyCharacteristics = $academyCharacteristics;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getItemCharacteristics(): Collection
    {
        return $this->itemCharacteristics;
    }

    /**
     * @param Collection $itemCharacteristics
     *
     * @return Characteristic
     */
    public function setItemCharacteristics(Collection $itemCharacteristics): self
    {
        $this->itemCharacteristics = $itemCharacteristics;

        return $this;
    }

    /**
     * @param Item $item
     *
     * @return Characteristic
     */
    public function addItem(Item $item): self
    {
        if (!$this->itemCharacteristics->contains($item)) {
            $this->itemCharacteristics[] = $item;
            $item->addCharacteristic($this);
        }

        return $this;
    }

    /**
     * @param Item $item
     *
     * @return Characteristic
     */
    public function removeItem(Item $item): self
    {
        if ($this->itemCharacteristics->contains($item)) {
            $this->itemCharacteristics->removeElement($item);
            $item->removeCharacteristic($this);
        }

        return $this;
    }
}

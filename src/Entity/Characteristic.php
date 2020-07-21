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
    protected $userCharacteristics;

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
    protected $academyCharacteristics;

    /**
     * Characteristic constructor.
     */
    public function __construct()
    {
        $this->userCharacteristics = new ArrayCollection();
        $this->monsterCharacteristics = new ArrayCollection();
        $this->skillCharacteristics = new ArrayCollection();
        $this->academyCharacteristics = new ArrayCollection();
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
    public function getUserCharacteristics(): Collection
    {
        return $this->userCharacteristics;
    }

    /**
     * @param Collection $userCharacteristics
     *
     * @return Characteristic
     */
    public function setUserCharacteristics(Collection $userCharacteristics): self
    {
        $this->userCharacteristics = $userCharacteristics;

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Characteristic
     */
    public function addUser(User $user): self
    {
        if (!$this->userCharacteristics->contains($user)) {
            $this->userCharacteristics[] = $user;
            $user->addCharacteristic($this);
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Characteristic
     */
    public function removeUser(User $user): self
    {
        if ($this->userCharacteristics->contains($user)) {
            $this->userCharacteristics->removeElement($user);
            $user->removeCharacteristic($this);
        }

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
     * @param Academy $academy
     *
     * @return Characteristic
     */
    public function addAcademy(Academy $academy): self
    {
        if (!$this->academyCharacteristics->contains($academy)) {
            $this->academyCharacteristics[] = $academy;
            $academy->addBaseCharacteristic($this);
        }

        return $this;
    }

    /**
     * @param Academy $academy
     *
     * @return Characteristic
     */
    public function removeAcademy(Academy $academy): self
    {
        if ($this->academyCharacteristics->contains($academy)) {
            $this->academyCharacteristics->removeElement($academy);
            $academy->removeBaseCharacteristic($this);
        }

        return $this;
    }
}

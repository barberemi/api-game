<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="academy")
 * @ORM\Entity(repositoryClass="App\Repository\AcademyRepository")
 *
 * @UniqueEntity("name")
 */
class Academy
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
    protected $labelLight;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $labelDark;

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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $color;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $role;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="academy", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\User>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $users;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Monster", mappedBy="academy", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Monster>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $monsters;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="baseAcademy", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\BindCharacteristic>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $baseCharacteristics;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="academy", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\BindCharacteristic>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $characteristicsByLevel;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Skill", mappedBy="academy", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Skill>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $skills;

    /**
     * Academy constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->monsters = new ArrayCollection();
        $this->baseCharacteristics = new ArrayCollection();
        $this->characteristicsByLevel = new ArrayCollection();
        $this->skills = new ArrayCollection();
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
     * @return Academy
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
     * @return Academy
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
     * @return Academy
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return Academy
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return Academy
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabelLight(): string
    {
        return $this->labelLight;
    }

    /**
     * @param string $labelLight
     * @return Academy
     */
    public function setLabelLight(string $labelLight): self
    {
        $this->labelLight = $labelLight;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabelDark(): string
    {
        return $this->labelDark;
    }

    /**
     * @param string $labelDark
     * @return Academy
     */
    public function setLabelDark(string $labelDark): self
    {
        $this->labelDark = $labelDark;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     *
     * @return Academy
     */
    public function setUsers(ArrayCollection $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Academy
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAcademy($this);
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Academy
     */
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->setAcademy(null);
        }

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
     * @return Academy
     */
    public function setMonsters(ArrayCollection $monsters): self
    {
        $this->monsters = $monsters;

        return $this;
    }

    /**
     * @param Monster $monster
     *
     * @return Academy
     */
    public function addMonster(Monster $monster): self
    {
        if (!$this->monsters->contains($monster)) {
            $this->monsters[] = $monster;
            $monster->setAcademy($this);
        }

        return $this;
    }

    /**
     * @param Monster $monster
     *
     * @return Academy
     */
    public function removeMonster(Monster $monster): self
    {
        if ($this->monsters->contains($monster)) {
            $this->monsters->removeElement($monster);
            $monster->setAcademy(null);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getBaseCharacteristics(): Collection
    {
        return $this->baseCharacteristics;
    }

    /**
     * @param Collection $baseCharacteristics
     *
     * @return Academy
     */
    public function setBaseCharacteristics(Collection $baseCharacteristics): self
    {
        $this->baseCharacteristics = $baseCharacteristics;

        return $this;
    }

    /**
     * @param BindCharacteristic $baseCharacteristic
     *
     * @return Academy
     */
    public function addBaseCharacteristic(BindCharacteristic $baseCharacteristic): self
    {
        if (!$this->baseCharacteristics->contains($baseCharacteristic)) {
            $this->baseCharacteristics[] = $baseCharacteristic;
            $baseCharacteristic->setAcademy($this);
        }

        return $this;
    }

    /**
     * @param BindCharacteristic $baseCharacteristic
     *
     * @return Academy
     */
    public function removeBaseCharacteristic(BindCharacteristic $baseCharacteristic): self
    {
        if ($this->baseCharacteristics->contains($baseCharacteristic)) {
            $this->baseCharacteristics->removeElement($baseCharacteristic);
            $baseCharacteristic->setAcademy(null);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCharacteristics(): Collection
    {
        return $this->characteristicsByLevel;
    }

    /**
     * @param Collection $characteristicsByLevel
     *
     * @return Academy
     */
    public function setCharacteristics(Collection $characteristicsByLevel): self
    {
        $this->characteristicsByLevel = $characteristicsByLevel;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSkills(): ArrayCollection
    {
        return $this->skills;
    }

    /**
     * @param ArrayCollection $skills
     *
     * @return Academy
     */
    public function setSkills(ArrayCollection $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * @param Skill $skill
     *
     * @return Academy
     */
    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setAcademy($this);
        }

        return $this;
    }

    /**
     * @param Skill $skill
     *
     * @return Academy
     */
    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            $skill->setAcademy(null);
        }

        return $this;
    }
}

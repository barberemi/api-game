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
 * @Serializer\ExclusionPolicy("all")
 *
 * @UniqueEntity("name")
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
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\BindCharacteristic>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $users;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="characteristic", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\BindCharacteristic>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $monsters;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="characteristic", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\BindCharacteristic>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $skills;

    /**
     * Characteristic constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->monsters = new ArrayCollection();
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
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param Collection $users
     *
     * @return Characteristic
     */
    public function setUsers(Collection $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Characteristic
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
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
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeCharacteristic($this);
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
     * @param Collection $monsters
     *
     * @return Characteristic
     */
    public function setMonsters(Collection $monsters): self
    {
        $this->monsters = $monsters;

        return $this;
    }

    /**
     * @param Monster $monster
     *
     * @return Characteristic
     */
    public function addMonster(Monster $monster): self
    {
        if (!$this->monsters->contains($monster)) {
            $this->monsters[] = $monster;
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
        if ($this->monsters->contains($monster)) {
            $this->monsters->removeElement($monster);
            $monster->removeCharacteristic($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    /**
     * @param Collection $skills
     *
     * @return Characteristic
     */
    public function setSkills(Collection $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * @param Skill $skill
     *
     * @return Characteristic
     */
    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
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
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            $skill->removeCharacteristic($this);
        }

        return $this;
    }
}

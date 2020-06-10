<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="monster")
 * @ORM\Entity(repositoryClass="App\Repository\MonsterRepository")
 */
class Monster
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"get"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank
     * @Groups({"get"})
     */
    protected $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\MonsterCharacteristic", mappedBy="monster", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Groups({"get"})
     */
    protected $characteristics;

    /**
     * @var Academy
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Academy", inversedBy="monsters")
     * @ORM\JoinColumn(name="academy_id", referencedColumnName="id")
     * @Groups({"get"})
     */
    protected $academy;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="monsters", cascade={"persist"})
     * @ORM\JoinTable(name="monster_skill")
     * @ORM\OrderBy({"id" = "ASC"})
     * @Groups({"get"})
     */
    protected $skills;

    /**
     * Monster constructor.
     */
    public function __construct()
    {
        $this->characteristics = new ArrayCollection();
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
     * @return Monster
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
     * @return Monster
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return Monster
     */
    public function setCharacteristics(Collection $characteristics): self
    {
        $this->characteristics = $characteristics;

        return $this;
    }

    /**
     * @param Characteristic $characteristic
     *
     * @return Monster
     */
    public function addCharacteristic(Characteristic $characteristic): self
    {
        if (!$this->characteristics->contains($characteristic)) {
            $this->characteristics[] = $characteristic;
            $characteristic->addMonster($this);
        }

        return $this;
    }

    /**
     * @param Characteristic $characteristic
     *
     * @return Monster
     */
    public function removeCharacteristic(Characteristic $characteristic): self
    {
        if ($this->characteristics->contains($characteristic)) {
            $this->characteristics->removeElement($characteristic);
            $characteristic->removeMonster($this);
        }

        return $this;
    }

    /**
     * @return null|Academy
     */
    public function getAcademy(): ?Academy
    {
        return $this->academy;
    }

    /**
     * @param null|Academy $academy
     *
     * @return Monster
     */
    public function setAcademy(?Academy $academy): self
    {
        $this->academy = $academy;

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
     * @return Monster
     */
    public function setSkills(Collection $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * @param Skill $skill
     *
     * @return Monster
     */
    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->addMonster($this);
        }

        return $this;
    }

    /**
     * @param Skill $skill
     *
     * @return Monster
     */
    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            $skill->removeMonster($this);
        }

        return $this;
    }
}
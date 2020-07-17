<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

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
     * @Assert\NotBlank
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
    protected $givenXp;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BindCharacteristic", mappedBy="monster", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\BindCharacteristic>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $characteristics;

    /**
     * @var Academy
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Academy", inversedBy="monsters", cascade={"persist"})
     * @ORM\JoinColumn(name="academy_id", referencedColumnName="id")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Academy")
     * @Serializer\Groups({"create", "update"})
     */
    protected $academy;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="monsters", cascade={"persist"})
     * @ORM\JoinTable(name="monster_skill")
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Skill>")
     * @Serializer\Groups({"create", "update"})
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

    /**
     * @return int
     */
    public function getGivenXp(): int
    {
        return $this->givenXp;
    }

    /**
     * @param int $givenXp
     *
     * @return Monster
     */
    public function setGivenXp(int $givenXp): self
    {
        $this->givenXp = $givenXp;

        return $this;
    }
}

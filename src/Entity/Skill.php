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
 * @ORM\Table(name="skill")
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 *
 * @UniqueEntity("name")
 */
class Skill
{
    use TimestampableEntity;

    const DARK  = 'dark';
    const LIGHT = 'light';
    const TREE_TYPES = [self::DARK, self::LIGHT];

    const MELEE       = 'melee';
    const RANGE       = 'range';
    const HEAL        = 'heal';
    const HOT         = 'hot';
    const DOT         = 'dot';
    const MOVEMENT    = 'movement';
    const SKILL_BLOCK = 'skill_block';
    const UNKNOWN     = 'unknown';
    const SKILL_TYPES = [self::MELEE, self::RANGE, self::HEAL, self::HOT, self::DOT, self::MOVEMENT, self::SKILL_BLOCK, self::UNKNOWN];

    const HEALTH_TYPE       = 'health';
    const STRENGTH_TYPE     = 'strength';
    const INTELLIGENCE_TYPE = 'intelligence';
    const HASTE_TYPE        = 'haste';
    const FOCUS_TYPE        = 'focus';
    const SCALE_TYPES = [self::HEALTH_TYPE, self::STRENGTH_TYPE, self::INTELLIGENCE_TYPE, self::HASTE_TYPE, self::FOCUS_TYPE];

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
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $cooldown = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $duration = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     *
     * @Assert\Choice(choices=Skill::TREE_TYPES)
     *
     */
    protected $treeType = self::LIGHT;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     *
     * @Assert\Choice(choices=Skill::SKILL_TYPES)
     *
     */
    protected $type = self::MELEE;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $amount = 0;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     *
     * @Serializer\Expose
     * @Serializer\Type("float")
     * @Serializer\Groups({"create", "update"})
     */
    protected $rate = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Choice(choices=Skill::SCALE_TYPES)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $scaleType = self::STRENGTH_TYPE;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $level = 1;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $image;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="skills", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\User>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $users;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Monster", mappedBy="skills", cascade={"persist"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Monster>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $monsters;

    /**
     * @var Academy
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Academy", inversedBy="skills", cascade={"persist"})
     * @ORM\JoinColumn(name="academy_id", referencedColumnName="id")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Academy")
     * @Serializer\Groups({"create", "update"})
     */
    protected $academy;

    /**
     * Skill constructor.
     */
    public function __construct()
    {
        $this->treeType = self::LIGHT;
        $this->users = new ArrayCollection();
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
     * @return Skill
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
     * @return Skill
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
     * @return Skill
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
     * @return Skill
     */
    public function setUsers(Collection $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Skill
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addSkill($this);
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Skill
     */
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeSkill($this);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getCooldown(): int
    {
        return $this->cooldown;
    }

    /**
     * @param int $cooldown
     *
     * @return Skill
     */
    public function setCooldown(int $cooldown): self
    {
        $this->cooldown = $cooldown;

        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     *
     * @return Skill
     */
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

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
     * @return Skill
     */
    public function setMonsters(ArrayCollection $monsters): self
    {
        $this->monsters = $monsters;

        return $this;
    }

    /**
     * @param Monster $monster
     *
     * @return Skill
     */
    public function addMonster(Monster $monster): self
    {
        if (!$this->monsters->contains($monster)) {
            $this->monsters[] = $monster;
            $monster->addSkill($this);
        }

        return $this;
    }

    /**
     * @param Monster $monster
     *
     * @return Skill
     */
    public function removeMonster(Monster $monster): self
    {
        if ($this->monsters->contains($monster)) {
            $this->monsters->removeElement($monster);
            $monster->removeSkill($this);
        }

        return $this;
    }

    /**
     * @return Academy
     */
    public function getAcademy(): Academy
    {
        return $this->academy;
    }

    /**
     * @param null|Academy $academy
     *
     * @return Skill
     */
    public function setAcademy(?Academy $academy): self
    {
        $this->academy = $academy;

        return $this;
    }

    /**
     * @return string
     */
    public function getTreeType(): string
    {
        return $this->treeType;
    }

    /**
     * @param string $treeType
     *
     * @return Skill
     */
    public function setTreeType(string $treeType): self
    {
        $this->treeType = $treeType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     *
     * @return Skill
     */
    public function setType(?string $type): self
    {
        $this->type = $type;

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
     *
     * @return Skill
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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
     * @return Skill
     */
    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return Skill
     */
    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getScaleType(): ?string
    {
        return $this->scaleType;
    }

    /**
     * @param null|string $scaleType
     * @return Skill
     */
    public function setScaleType(?string $scaleType): self
    {
        $this->scaleType = $scaleType;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Skill
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}

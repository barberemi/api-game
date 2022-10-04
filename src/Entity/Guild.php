<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="guild")
 * @ORM\Entity(repositoryClass="App\Repository\GuildRepository")
 *
 * @UniqueEntity("name")
 */
class Guild
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
    protected $position = 0;

    /**
     * @var array|null
     *
     * @ORM\Column(type="json", nullable=true)
     *
     * @Serializer\Expose
     * @Serializer\Type("array")
     * @Serializer\Groups({"update"})
     */
    protected $exploration;

    /**
     * @var null|string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $announcement;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Exclude
     */
    protected $lastAttack = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Exclude
     */
    protected $lastTrueAttack = 0;

    /**
     * @var null|int
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $minAttack;

    /**
     * @var null|int
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $maxAttack;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $upDraw = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $downDraw = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $seasonRecord = 0;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="guild", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(5)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\User>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $users;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="guild", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Message>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $messages;

    /**
     * @var Monster
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Monster", inversedBy="guilds", cascade={"persist"})
     * @ORM\JoinColumn(name="monster_id", referencedColumnName="id")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Monster")
     * @Serializer\Groups({"create", "update"})
     */
    protected $monster;

    /**
     * @var Collection
     *
     * @Serializer\MaxDepth(6)
     * @ORM\OneToMany(targetEntity="App\Entity\OwnItem", mappedBy="guild", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\OwnItem>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $items;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Construction", mappedBy="guild", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Construction>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $constructions;

    /**
     * Guild constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->constructions = new ArrayCollection();
    }

    /**
     * @Serializer\VirtualProperty()
     * @return int
     */
    public function getDefense(): int
    {
        $defense = 0;
        // Get all guild constructions defense
        /** @var Construction $construction */
        foreach ($this->getConstructions() as $construction) {
            if (
                $construction->getStatus() === Construction::DONE_STATUS &&
                $construction->getBuilding()->getType() === Building::DEFENSE_TYPE
            ) {
                $defense = $defense + $construction->getBuilding()->getAmount();
            }
        }

        // Get all guild users defense
        /** @var User $user */
        foreach ($this->getUsers() as $user) {
            $defense = $defense + $user->getDefense();
        }

        return $defense;
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
     * @return Guild
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
     * @return Guild
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return Guild
     */
    public function setUsers(ArrayCollection $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Guild
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setGuild($this);
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return Guild
     */
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->setGuild(null);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return Guild
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    /**
     * @param Collection $messages
     *
     * @return Guild
     */
    public function setMessages(Collection $messages): self
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * @param Message $message
     *
     * @return Guild
     */
    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setGuild($this);
        }

        return $this;
    }

    /**
     * @param Message $message
     *
     * @return Guild
     */
    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            $message->setGuild(null);
        }

        return $this;
    }

    /**
     * @return null|Monster
     */
    public function getMonster(): ?Monster
    {
        return $this->monster;
    }

    /**
     * @param null|Monster $monster
     * @return Guild
     */
    public function setMonster(?Monster $monster): self
    {
        $this->monster = $monster;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param $items
     * @return Guild
     */
    public function setItems($items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param OwnItem $item
     *
     * @return Guild
     */
    public function addItem(OwnItem $item): self
    {
        $this->items[] = $item;
        $item->setGuild($this);

        return $this;
    }

    /**
     * @return array|null
     */
    public function getExploration(): ?array
    {
        return $this->exploration;
    }

    /**
     * @param array|null $exploration
     * @return Guild
     */
    public function setExploration(?array $exploration): self
    {
        $this->exploration = $exploration;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAnnouncement(): ?string
    {
        return $this->announcement;
    }

    /**
     * @param string|null $announcement
     * @return Guild
     */
    public function setAnnouncement(?string $announcement): self
    {
        $this->announcement = $announcement;

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
     * @return Guild
     */
    public function setConstructions(Collection $constructions): self
    {
        $this->constructions = $constructions;

        return $this;
    }

    /**
     * @return int
     */
    public function getLastAttack(): int
    {
        return $this->lastAttack;
    }

    /**
     * @param int $lastAttack
     * @return Guild
     */
    public function setLastAttack(int $lastAttack): self
    {
        $this->lastAttack = $lastAttack;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinAttack(): ?int
    {
        return $this->minAttack;
    }

    /**
     * @param int|null $minAttack
     * @return Guild
     */
    public function setMinAttack(?int $minAttack): self
    {
        $this->minAttack = $minAttack;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxAttack(): ?int
    {
        return $this->maxAttack;
    }

    /**
     * @param int|null $maxAttack
     * @return Guild
     */
    public function setMaxAttack(?int $maxAttack): self
    {
        $this->maxAttack = $maxAttack;

        return $this;
    }

    /**
     * @return int
     */
    public function getLastTrueAttack(): int
    {
        return $this->lastTrueAttack;
    }

    /**
     * @param int $lastTrueAttack
     * @return Guild
     */
    public function setLastTrueAttack(int $lastTrueAttack): self
    {
        $this->lastTrueAttack = $lastTrueAttack;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpDraw(): int
    {
        return $this->upDraw;
    }

    /**
     * @param int $upDraw
     * @return Guild
     */
    public function setUpDraw(int $upDraw): self
    {
        $this->upDraw = $upDraw;

        return $this;
    }

    /**
     * @return int
     */
    public function getDownDraw(): int
    {
        return $this->downDraw;
    }

    /**
     * @param int $downDraw
     * @return Guild
     */
    public function setDownDraw(int $downDraw): self
    {
        $this->downDraw = $downDraw;

        return $this;
    }

    /**
     * @return int
     */
    public function getSeasonRecord(): int
    {
        return $this->seasonRecord;
    }

    /**
     * @param int $seasonRecord
     * @return Guild
     */
    public function setSeasonRecord(int $seasonRecord): self
    {
        $this->seasonRecord = $seasonRecord;

        return $this;
    }
}

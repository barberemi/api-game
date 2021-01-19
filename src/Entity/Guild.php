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
    protected $nbMembers;

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
     * @Serializer\MaxDepth(5)
     * @ORM\OneToMany(targetEntity="App\Entity\OwnItem", mappedBy="guild", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\OwnItem>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $items;

    /**
     * Guild constructor.
     */
    public function __construct()
    {
        $this->nbMembers = 5;
        $this->users = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->items = new ArrayCollection();
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
    public function getNbMembers(): int
    {
        return $this->nbMembers;
    }

    /**
     * @param int $nbMembers
     *
     * @return Guild
     */
    public function setNbMembers(int $nbMembers): self
    {
        $this->nbMembers = $nbMembers;

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
}

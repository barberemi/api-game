<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use App\Helper\LevelHelper;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Exclude
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     *
     * @Serializer\Exclude
     */
    protected $salt;

    /**
     * @var null|string
     *
     * @Assert\NotBlank(groups={"registration"})
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update", "registration"})
     */
    protected $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank
     * @Assert\Email
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $role;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     *
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"create", "update"})
     */
    protected $isActive = false;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $experience = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $money = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $itemSpaceNb = 10;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     *
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"create", "update"})
     */
    protected $isDead = false;

    /**
     * @var Academy
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Academy", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="academy_id", referencedColumnName="id")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Academy")
     * @Serializer\Groups({"create", "update"})
     */
    protected $academy;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="users", cascade={"persist"})
     * @ORM\JoinTable(name="user_skill")
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Skill>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $skills;

    /**
     * @var Guild
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Guild", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="guild_id", referencedColumnName="id")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Guild")
     * @Serializer\Groups({"create", "update"})
     */
    protected $guild;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Message>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $messages;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OwnItem", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\OwnItem>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $items;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="friendsWithMe", cascade={"persist"})
     * @ORM\JoinTable(name="friends",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_user_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\User>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $friends;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="friends")
     */
    protected $friendsWithMe;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->friends = new ArrayCollection();
        $this->friendsWithMe = new ArrayCollection();
        $this->salt = md5(uniqid(null, true));
        $this->role = 'ROLE_USER';
    }

    /**
     * @Serializer\VirtualProperty()
     * @return int
     */
    public function getLevel(): int
    {
        return LevelHelper::levelFromXp($this->getExperience());
    }

    /**
     * @Serializer\VirtualProperty()
     * @return int
     */
    public function getXpToNextLevel(): int
    {
        return LevelHelper::xpToLevel($this->getLevel() + 1);
    }

    /**
     * @Serializer\VirtualProperty()
     * @return int
     */
    public function getXpToActualLevel(): int
    {
        return LevelHelper::xpToLevel($this->getLevel());
    }

    /**
     * @Serializer\VirtualProperty()
     * @return int
     */
    public function getSkillPoints(): int
    {
        return LevelHelper::skillPointsOfLevel($this->getLevel());
    }

    /**
     * @Serializer\VirtualProperty()
     * @return int
     */
    public function getRemainingSkillPoints(): int
    {
        $usedSkillPoints = count($this->getSkills());
        return LevelHelper::skillPointsOfLevel($this->getLevel()) - $usedSkillPoints;
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
     * @return User
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     *
     * @return User
     */
    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param null|string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getEmail();//Use by JWT for authenticate user
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    /**
     * @param string $role
     *
     * @return User
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     *
     * @return User
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

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
     * @return User
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
     * @return User
     */
    public function setSkills(Collection $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * @param Skill $skill
     *
     * @return User
     */
    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->addUser($this);
        }

        return $this;
    }

    /**
     * @param Skill $skill
     *
     * @return User
     */
    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            $skill->removeUser($this);
        }

        return $this;
    }

    /**
     * @return null|Guild
     */
    public function getGuild(): ?Guild
    {
        return $this->guild;
    }

    /**
     * @param null|Guild $guild
     *
     * @return User
     */
    public function setGuild(?Guild $guild): self
    {
        $this->guild = $guild;

        return $this;
    }

    /**
     * @return int
     */
    public function getExperience(): int
    {
        return $this->experience;
    }

    /**
     * @param int $experience
     *
     * @return User
     */
    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * @return int
     */
    public function getMoney(): int
    {
        return $this->money;
    }

    /**
     * @param int $money
     *
     * @return User
     */
    public function setMoney(int $money): self
    {
        $this->money = $money;

        return $this;
    }

    /**
     * @return int
     */
    public function getItemSpaceNb(): int
    {
        return $this->itemSpaceNb;
    }

    /**
     * @param int $itemSpaceNb
     *
     * @return User
     */
    public function setItemSpaceNb(int $itemSpaceNb): self
    {
        $this->itemSpaceNb = $itemSpaceNb;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDead(): bool
    {
        return $this->isDead;
    }

    /**
     * @param bool $isDead
     *
     * @return User
     */
    public function setIsDead(bool $isDead): self
    {
        $this->isDead = $isDead;

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
     * @return User
     */
    public function setMessages(Collection $messages): self
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * @param Message $message
     *
     * @return User
     */
    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    /**
     * @param Message $message
     *
     * @return User
     */
    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            $message->setUser(null);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param Collection $items
     * @return User
     */
    public function setItems(Collection $items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFriends(): ArrayCollection
    {
        return $this->friends;
    }

    /**
     * @param ArrayCollection $friends
     * @return User
     */
    public function setFriends(ArrayCollection $friends): self
    {
        $this->friends = $friends;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFriendsWithMe(): ArrayCollection
    {
        return $this->friendsWithMe;
    }

    /**
     * @param ArrayCollection $friendsWithMe
     * @return User
     */
    public function setFriendsWithMe(ArrayCollection $friendsWithMe): self
    {
        $this->friendsWithMe = $friendsWithMe;

        return $this;
    }
}

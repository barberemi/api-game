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

    const MEMBER_GUILD_ROLE  = 'member';
    const OFFICER_GUILD_ROLE = 'officer';
    const MASTER_GUILD_ROLE  = 'master';
    const GUILD_ROLES = [self::MEMBER_GUILD_ROLE, self::OFFICER_GUILD_ROLE, self::MASTER_GUILD_ROLE];

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
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $name;

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
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Fight", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     *
     * @Serializer\MaxDepth(5)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\Fight>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $fights;

    /**
     * @var Academy
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Academy", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="academy_id", referencedColumnName="id")
     *
     * @Serializer\MaxDepth(3)
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
     * @Serializer\MaxDepth(3)
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
     * @Serializer\MaxDepth(5)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Guild")
     * @Serializer\Groups({"create", "update"})
     */
    protected $guild;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Choice(choices=User::GUILD_ROLES)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $guildRole = self::MEMBER_GUILD_ROLE;

    /**
     * @var ArrayCollection
     *
     * @Serializer\MaxDepth(3)
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
     * @Serializer\MaxDepth(6)
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
     * @ORM\OrderBy({"name" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
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
        $this->fights = new ArrayCollection();
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
     * @Serializer\VirtualProperty()
     * @return null|Collection
     */
    public function getCharacteristics(): ?Collection
    {
        if ($this->getAcademy()) {
            /** @var BindCharacteristic $baseCharacteristic */
            foreach ($this->getAcademy()->getBaseCharacteristics() as $baseCharacteristic) {
                /** @var BindCharacteristic $byLevelCharacteristic */
                foreach ($this->getAcademy()->getCharacteristics() as $byLevelCharacteristic) {
                    if ($baseCharacteristic->getCharacteristic() === $byLevelCharacteristic->getCharacteristic()) {
                        $baseCharacteristic->setAmount($baseCharacteristic->getAmount() + $byLevelCharacteristic->getAmount() * $this->getLevel());
                    }
                }
            }

            return $this->getAcademy()->getBaseCharacteristics();
        }

        return null;
    }

    /**
     * @Serializer\VirtualProperty()
     * @return bool
     */
    public function getCanGuildBossFight(): bool
    {
        if ($this->getGuild() && $this->getGuild()->getMonster()) {
            /** @var Fight $fight */
            foreach ($this->getFights() as $fight) {
                if (
                    $fight->getType() !== Fight::WAITING_TYPE &&
                    $fight->getMonster()->isGuildBoss() &&
                    $fight->getMonster()->getId() === $this->getGuild()->getMonster()->getId() &&
                    $fight->getUpdatedAt()->format('Y-m-d') >= (new \DateTime())->format('Y-m-d')
                ) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @Serializer\VirtualProperty()
     * @return null|Fight
     */
    public function getLastGuildBossFightOfDay(): ?Fight
    {
        if ($this->getGuild() && $this->getGuild()->getMonster()) {
            /** @var Fight $fight */
            foreach ($this->getFights() as $fight) {
                if (
                    $fight->getMonster()->isGuildBoss() &&
                    $fight->getMonster()->getId() === $this->getGuild()->getMonster()->getId() &&
                    $fight->getUpdatedAt()->format('Y-m-d') >= (new \DateTime())->format('Y-m-d')
                ) {
                    return $fight;
                }
            }
        }

        return null;
    }

    /**
     * @Serializer\VirtualProperty()
     * @return Collection
     */
    public function getEquippedItems(): Collection
    {
        return $this->items->filter(function (OwnItem $own) {
            return $own->isEquipped();
        });
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
     * @param OwnItem $item
     *
     * @return User
     */
    public function addItem(OwnItem $item): self
    {
        $this->items[] = $item;
        $item->setUser($this);

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
     * @param User $friend
     * @return User
     */
    public function addFriend(User $friend): self
    {
        if (!$this->friends->contains($friend) && $friend->getId() !== $this->getId()) {
            $this->friends[] = $friend;
        }

        return $this;
    }

    /**
     * @param User $friend
     * @return User
     */
    public function removeFriend(User $friend): self
    {
        if ($this->friends->contains($friend)) {
            $this->friends->removeElement($friend);
        }

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

    /**
     * @return array|null
     */
    public function getExploration(): ?array
    {
        return $this->exploration;
    }

    /**
     * @param array|null $exploration
     * @return User
     */
    public function setExploration(?array $exploration): self
    {
        $this->exploration = $exploration;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFights(): Collection
    {
        return $this->fights;
    }

    /**
     * @param Collection $fights
     * @return User
     */
    public function setFights(Collection $fights): self
    {
        $this->fights = $fights;

        return $this;
    }

    /**
     * @param Fight $fight
     *
     * @return User
     */
    public function addFight(Fight $fight): self
    {
        if (!$this->fights->contains($fight)) {
            $this->fights[] = $fight;
            $fight->setUser($this);
        }

        return $this;
    }

    /**
     * @param Fight $fight
     *
     * @return User
     */
    public function removeFight(Fight $fight): self
    {
        if ($this->fights->contains($fight)) {
            $this->fights->removeElement($fight);
            $fight->setUser(null);
        }

        return $this;
    }

    /**
     * @param null|Collection $bindCharacteristics
     * @param string $characteristicName
     * @return int
     */
    public function getSpecificCharacteristic(?Collection $bindCharacteristics, string $characteristicName): int
    {
        $amount = 0;
        if ($bindCharacteristics) {
            foreach ($bindCharacteristics as $bind) {
                if ($bind->getCharacteristic()->getName() === $characteristicName) {
                    $amount = $amount + $bind->getAmount();
                }
            }
        }

        return $amount;
    }

    /**
     * @return null|string
     */
    public function getGuildRole(): ?string
    {
        return $this->guildRole;
    }

    /**
     * @param null|string $guildRole
     * @return User
     */
    public function setGuildRole(?string $guildRole): self
    {
        $this->guildRole = $guildRole;

        return $this;
    }
}

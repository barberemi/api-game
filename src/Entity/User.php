<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups({"get"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $salt;

    /**
     * @var null|string
     *
     * @Assert\NotBlank(groups={"registration"})
     */
    protected $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank
     * @Assert\Email
     * @Groups({"get"})
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     * @Groups({"get"})
     */
    protected $role;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Groups({"get"})
     */
    protected $isActive = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\UserCharacteristic", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Groups({"get"})
     */
    protected $characteristics;

    /**
     * @var Academy
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Academy", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="academy_id", referencedColumnName="id")
     * @Groups({"get"})
     */
    protected $academy;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="users", cascade={"persist"})
     * @ORM\JoinTable(name="user_skill")
     * @ORM\OrderBy({"id" = "ASC"})
     * @Groups({"get"})
     */
    protected $skills;

    /**
     * @var Guild
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Guild", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="guild_id", referencedColumnName="id")
     * @Groups({"get"})
     */
    protected $guild;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->characteristics = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->salt = md5(uniqid(null, true));
        $this->role = 'ROLE_USER';
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
     * @return Collection
     */
    public function getCharacteristics(): Collection
    {
        return $this->characteristics;
    }

    /**
     * @param Collection $characteristics
     *
     * @return User
     */
    public function setCharacteristics(Collection $characteristics): self
    {
        $this->characteristics = $characteristics;

        return $this;
    }

    /**
     * @param Characteristic $characteristic
     *
     * @return User
     */
    public function addCharacteristic(Characteristic $characteristic): self
    {
        if (!$this->characteristics->contains($characteristic)) {
            $this->characteristics[] = $characteristic;
            $characteristic->addUser($this);
        }

        return $this;
    }

    /**
     * @param Characteristic $characteristic
     *
     * @return User
     */
    public function removeCharacteristic(Characteristic $characteristic): self
    {
        if ($this->characteristics->contains($characteristic)) {
            $this->characteristics->removeElement($characteristic);
            $characteristic->removeUser($this);
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
}

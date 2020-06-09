<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
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
     * @Groups({"get"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"get"})
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Groups({"get"})
     */
    protected $description;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="academy", cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     * @Groups({"get"})
     */
    protected $users;

    /**
     * Academy constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="fight")
 * @ORM\Entity(repositoryClass="App\Repository\FightRepository")
 */
class Fight
{
    use TimestampableEntity;

    const WON_TYPE     = 'won';
    const LOST_TYPE    = 'lost';
    const WAITING_TYPE = 'waiting';
    const TYPES = [self::WON_TYPE, self::LOST_TYPE, self::WAITING_TYPE];

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
     * @Assert\Choice(choices=Fight::TYPES)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"update"})
     */
    protected $type = self::WAITING_TYPE;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     *
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"update"})
     */
    protected $isRewarded = false;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $round = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Monster", inversedBy="fights")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Monster")
     * @Serializer\Groups({"create", "update"})
     */
    protected $monster;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="fights")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\User")
     * @Serializer\Groups({"create", "update"})
     */
    protected $user;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OwnItem", mappedBy="fight", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\OwnItem>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $items;

    /**
     * Fight constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }


    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return Fight
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Fight
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRewarded(): bool
    {
        return $this->isRewarded;
    }

    /**
     * @param bool $isRewarded
     * @return Fight
     */
    public function setIsRewarded(bool $isRewarded): self
    {
        $this->isRewarded = $isRewarded;

        return $this;
    }

    /**
     * @return int
     */
    public function getRound(): int
    {
        return $this->round;
    }

    /**
     * @param int $round
     * @return Fight
     */
    public function setRound(int $round): self
    {
        $this->round = $round;

        return $this;
    }

    /**
     * @return Monster
     */
    public function getMonster(): Monster
    {
        return $this->monster;
    }

    /**
     * @param Monster $monster
     *
     * @return Fight
     */
    public function setMonster(Monster $monster): self
    {
        $this->monster = $monster;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

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
     * @return Fight
     */
    public function setItems(Collection $items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param OwnItem $item
     *
     * @return Fight
     */
    public function addItem(OwnItem $item): self
    {
        $this->items[] = $item;
        $item->setFight($this);

        return $this;
    }
}

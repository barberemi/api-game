<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="owm_item")
 * @ORM\Entity(repositoryClass="App\Repository\OwnItemRepository")
 */
class OwnItem
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
     * @var bool
     *
     * @ORM\Column(type="boolean")
     *
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"create", "update"})
     */
    protected $isEquipped = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="items")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\User")
     * @Serializer\Groups({"create", "update"})
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Monster", inversedBy="items")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Monster")
     * @Serializer\Groups({"create", "update"})
     */
    protected $monster;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fight", inversedBy="items")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Fight")
     * @Serializer\Groups({"create", "update"})
     */
    protected $fight;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Guild", inversedBy="items")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Guild")
     * @Serializer\Groups({"create", "update"})
     */
    protected $guild;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Map", inversedBy="items")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Map")
     * @Serializer\Groups({"create", "update"})
     */
    protected $map;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="itemsRewarded1")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Season")
     * @Serializer\Groups({"create", "update"})
     */
    protected $seasonReward1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="itemsRewarded2")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Season")
     * @Serializer\Groups({"create", "update"})
     */
    protected $seasonReward2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="itemsRewarded3")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Season")
     * @Serializer\Groups({"create", "update"})
     */
    protected $seasonReward3;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="itemsRewarded4")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Season")
     * @Serializer\Groups({"create", "update"})
     */
    protected $seasonReward4;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Item")
     * @Serializer\Groups({"create", "update"})
     */
    protected $item;

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param null|$id
     *
     * @return OwnItem
     */
    public function setId($id): self
    {
        $this->id = $id;

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
     * @return OwnItem
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEquipped(): bool
    {
        return $this->isEquipped;
    }

    /**
     * @param bool $isEquipped
     * @return OwnItem
     */
    public function setIsEquipped(bool $isEquipped): self
    {
        $this->isEquipped = $isEquipped;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param $user
     *
     * @return OwnItem
     */
    public function setUser($user): self
    {
        $this->user = $user;

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
     * @param $monster
     *
     * @return OwnItem
     */
    public function setMonster($monster): self
    {
        $this->monster = $monster;

        return $this;
    }

    /**
     * @return Fight
     */
    public function getFight(): Fight
    {
        return $this->fight;
    }

    /**
     * @param $fight
     * @return OwnItem
     */
    public function setFight($fight): self
    {
        $this->fight = $fight;

        return $this;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @param $item
     *
     * @return OwnItem
     */
    public function setItem($item): self
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuild()
    {
        return $this->guild;
    }

    /**
     * @param $guild
     * @return OwnItem
     */
    public function setGuild($guild): self
    {
        $this->guild = $guild;

        return $this;
    }

    /**
     * @return Map
     */
    public function getMap(): Map
    {
        return $this->map;
    }

    /**
     * @param $map
     *
     * @return OwnItem
     */
    public function setMap($map): self
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @return Season
     */
    public function getSeasonReward1(): Season
    {
        return $this->seasonReward1;
    }

    /**
     * @param $seasonReward1
     *
     * @return OwnItem
     */
    public function setSeasonReward1($seasonReward1): self
    {
        $this->seasonReward1 = $seasonReward1;

        return $this;
    }

    /**
     * @return Season
     */
    public function getSeasonReward2(): Season
    {
        return $this->seasonReward2;
    }

    /**
     * @param $seasonReward2
     *
     * @return OwnItem
     */
    public function setSeasonReward2($seasonReward2): self
    {
        $this->seasonReward2 = $seasonReward2;

        return $this;
    }

    /**
     * @return Season
     */
    public function getSeasonReward3(): Season
    {
        return $this->seasonReward3;
    }

    /**
     * @param $seasonReward3
     *
     * @return OwnItem
     */
    public function setSeasonReward3($seasonReward3): self
    {
        $this->seasonReward3 = $seasonReward3;

        return $this;
    }

    /**
     * @return Season
     */
    public function getSeasonReward4(): Season
    {
        return $this->seasonReward4;
    }

    /**
     * @param $seasonReward4
     *
     * @return OwnItem
     */
    public function setSeasonReward4($seasonReward4): self
    {
        $this->seasonReward4 = $seasonReward4;

        return $this;
    }
}

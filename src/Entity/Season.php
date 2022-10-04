<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="season")
 * @ORM\Entity(repositoryClass="App\Repository\SeasonRepository")
 */
class Season
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
     * @var \Date|null
     *
     * @ORM\Column(type="date", nullable=true)
     *
     * @Serializer\Expose
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $startingAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="date", nullable=true)
     *
     * @Serializer\Expose
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $endingAt;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OwnItem", mappedBy="seasonReward1", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\OwnItem>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $itemsRewarded1;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OwnItem", mappedBy="seasonReward2", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\OwnItem>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $itemsRewarded2;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OwnItem", mappedBy="seasonReward3", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\OwnItem>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $itemsRewarded3;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OwnItem", mappedBy="seasonReward4", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Entity\OwnItem>")
     * @Serializer\Groups({"create", "update"})
     */
    protected $itemsRewarded4;

    /**
     * Season constructor.
     */
    public function __construct()
    {
        $this->itemsRewarded1 = new ArrayCollection();
        $this->itemsRewarded2 = new ArrayCollection();
        $this->itemsRewarded3 = new ArrayCollection();
        $this->itemsRewarded4 = new ArrayCollection();
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
     * @return Season
     */
    public function setId($id): self
    {
        $this->id = $id;

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
     * @return Season
     */
    public function setIsRewarded(bool $isRewarded): self
    {
        $this->isRewarded = $isRewarded;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartingAt(): ?\DateTime
    {
        return $this->startingAt;
    }

    /**
     * @param \DateTime|null $startingAt
     *
     * @return Season
     */
    public function setStartingAt(?\DateTime $startingAt): Season
    {
        $this->startingAt = $startingAt;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndingAt(): ?\DateTime
    {
        return $this->endingAt;
    }

    /**
     * @param \DateTime|null $endingAt
     *
     * @return Season
     */
    public function setEndingAt(?\DateTime $endingAt): Season
    {
        $this->endingAt = $endingAt;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getItemsRewarded1(): Collection
    {
        return $this->itemsRewarded1;
    }

    /**
     * @param Collection $itemsRewarded1
     * @return Season
     */
    public function setItemsRewarded1(Collection $itemsRewarded1): self
    {
        $this->itemsRewarded1 = $itemsRewarded1;

        return $this;
    }

    /**
     * @param OwnItem $itemRewarded1
     *
     * @return Season
     */
    public function addItemRewarded1(OwnItem $itemRewarded1): self
    {
        $this->itemsRewarded1[] = $itemRewarded1;
        $itemRewarded1->setSeasonReward1($this);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getItemsRewarded2(): Collection
    {
        return $this->itemsRewarded2;
    }

    /**
     * @param Collection $itemsRewarded2
     * @return Season
     */
    public function setItemsRewarded2(Collection $itemsRewarded2): self
    {
        $this->itemsRewarded2 = $itemsRewarded2;

        return $this;
    }

    /**
     * @param OwnItem $itemRewarded2
     *
     * @return Season
     */
    public function addItemRewarded2(OwnItem $itemRewarded2): self
    {
        $this->itemsRewarded2[] = $itemRewarded2;
        $itemRewarded2->setSeasonReward2($this);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getItemsRewarded3(): Collection
    {
        return $this->itemsRewarded3;
    }

    /**
     * @param Collection $itemsRewarded3
     * @return Season
     */
    public function setItemsRewarded3(Collection $itemsRewarded3): self
    {
        $this->itemsRewarded3 = $itemsRewarded3;

        return $this;
    }

    /**
     * @param OwnItem $itemRewarded3
     *
     * @return Season
     */
    public function addItemRewarded3(OwnItem $itemRewarded3): self
    {
        $this->itemsRewarded3[] = $itemRewarded3;
        $itemRewarded3->setSeasonReward3($this);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getItemsRewarded4(): Collection
    {
        return $this->itemsRewarded4;
    }

    /**
     * @param Collection $itemsRewarded4
     * @return Season
     */
    public function setItemsRewarded4(Collection $itemsRewarded4): self
    {
        $this->itemsRewarded4 = $itemsRewarded4;

        return $this;
    }

    /**
     * @param OwnItem $itemRewarded4
     *
     * @return Season
     */
    public function addItemRewarded4(OwnItem $itemRewarded4): self
    {
        $this->itemsRewarded4[] = $itemRewarded4;
        $itemRewarded4->setSeasonReward4($this);

        return $this;
    }
}

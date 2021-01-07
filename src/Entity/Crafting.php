<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="crafting")
 * @ORM\Entity(repositoryClass="App\Repository\CraftingRepository")
 */
class Crafting
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
     * @Assert\GreaterThanOrEqual(1)
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="itemsToCraft")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Item")
     * @Serializer\Groups({"create", "update"})
     */
    protected $itemToCraft;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="itemsNeededToCraft")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Item")
     * @Serializer\Groups({"create", "update"})
     */
    protected $itemNeededToCraft;

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
     * @return Crafting
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
     * @return Crafting
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Item
     */
    public function getItemToCraft()
    {
        return $this->itemToCraft;
    }

    /**
     * @param $itemToCraft
     * @return Crafting
     */
    public function setItemToCraft($itemToCraft): self
    {
        $this->itemToCraft = $itemToCraft;

        return $this;
    }

    /**
     * @return Item
     */
    public function getItemNeededToCraft()
    {
        return $this->itemNeededToCraft;
    }

    /**
     * @param $itemNeededToCraft
     * @return Crafting
     */
    public function setItemNeededToCraft($itemNeededToCraft): self
    {
        $this->itemNeededToCraft = $itemNeededToCraft;

        return $this;
    }
}

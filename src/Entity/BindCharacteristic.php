<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="bind_characteristic")
 * @ORM\Entity(repositoryClass="App\Repository\BindCharacteristicRepository")
 */
class BindCharacteristic
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Monster", inversedBy="characteristics")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Monster")
     * @Serializer\Groups({"create", "update"})
     */
    protected $monster;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Academy", inversedBy="baseCharacteristics")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Academy")
     * @Serializer\Groups({"create", "update"})
     */
    protected $baseAcademy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Academy", inversedBy="characteristicsByLevel")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Academy")
     * @Serializer\Groups({"create", "update"})
     */
    protected $academy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="characteristics")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Item")
     * @Serializer\Groups({"create", "update"})
     */
    protected $item;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characteristic")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Characteristic")
     * @Serializer\Groups({"create", "update"})
     */
    protected $characteristic;

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
     * @return BindCharacteristic
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
     * @return BindCharacteristic
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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
     * @return BindCharacteristic
     */
    public function setMonster($monster): self
    {
        $this->monster = $monster;

        return $this;
    }

    /**
     * @return Characteristic
     */
    public function getCharacteristic(): Characteristic
    {
        return $this->characteristic;
    }

    /**
     * @param $characteristic
     *
     * @return BindCharacteristic
     */
    public function setCharacteristic($characteristic): self
    {
        $this->characteristic = $characteristic;

        return $this;
    }

    /**
     * @return Academy
     */
    public function getBaseAcademy(): Academy
    {
        return $this->baseAcademy;
    }

    /**
     * @param $baseAcademy
     *
     * @return BindCharacteristic
     */
    public function setBaseAcademy($baseAcademy): self
    {
        $this->baseAcademy = $baseAcademy;

        return $this;
    }

    /**
     * @return Academy
     */
    public function getAcademy(): Academy
    {
        return $this->academy;
    }

    /**
     * @param $academy
     *
     * @return BindCharacteristic
     */
    public function setAcademy($academy): self
    {
        $this->academy = $academy;

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
     * @return BindCharacteristic
     */
    public function setItem($item): self
    {
        $this->item = $item;

        return $this;
    }
}

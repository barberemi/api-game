<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="monster_characteristic")
 * @ORM\Entity(repositoryClass="App\Repository\MonsterCharacteristicRepository")
 */
class MonsterCharacteristic
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
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThanOrEqual(1)
     * @Groups({"get"})
     */
    protected $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Monster", inversedBy="characteristics")
     * @Groups({"get"})
     */
    protected $monster;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characteristic", inversedBy="monsters")
     * @Groups({"get"})
     */
    protected $characteristic;

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
     * @return MonsterCharacteristic
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
     * @return MonsterCharacteristic
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
     * @return MonsterCharacteristic
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
     * @return MonsterCharacteristic
     */
    public function setCharacteristic($characteristic): self
    {
        $this->characteristic = $characteristic;

        return $this;
    }
}

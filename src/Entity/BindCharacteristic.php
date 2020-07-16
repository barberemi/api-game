<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="bind_characteristic")
 * @ORM\Entity(repositoryClass="App\Repository\BindCharacteristicRepository")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class BindCharacteristic
{
    use TimestampableEntity;

    const TYPES = ['addition', 'substraction'];

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
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\Choice(choices=BindCharacteristic::TYPES)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="characteristics")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\User")
     * @Serializer\Groups({"create", "update"})
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Monster", inversedBy="characteristics")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Monster")
     * @Serializer\Groups({"create", "update"})
     */
    protected $monster;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SKill", inversedBy="characteristics")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Skill")
     * @Serializer\Groups({"create", "update"})
     */
    protected $skill;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characteristic", inversedBy="users")
     *
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Characteristic")
     * @Serializer\Groups({"create", "update"})
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param $user
     *
     * @return BindCharacteristic
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
     * @return BindCharacteristic
     */
    public function setMonster($monster): self
    {
        $this->monster = $monster;

        return $this;
    }

    /**
     * @return Skill
     */
    public function getSkill(): Skill
    {
        return $this->skill;
    }

    /**
     * @param $skill
     *
     * @return BindCharacteristic
     */
    public function setSkill($skill): self
    {
        $this->skill = $skill;

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return BindCharacteristic
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="construction")
 * @ORM\Entity(repositoryClass="App\Repository\ConstructionRepository")
 */
class Construction
{
    use TimestampableEntity;

    const IN_PROGRESS_STATUS = 'in_progress';
    const DONE_STATUS = 'done';
    const STATUS = [self::IN_PROGRESS_STATUS, self::DONE_STATUS];

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
    protected $remainingActions = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     * @Serializer\Groups({"create", "update"})
     */
    protected $remainingMaterials = 10;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Choice(choices=Construction::STATUS)
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"create", "update"})
     */
    protected $status = self::IN_PROGRESS_STATUS;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Guild", inversedBy="constructions")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Guild")
     * @Serializer\Groups({"create", "update"})
     */
    protected $guild;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="constructions")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\user")
     * @Serializer\Groups({"create", "update"})
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Building", inversedBy="constructions")
     *
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose
     * @Serializer\Type("App\Entity\Building")
     * @Serializer\Groups({"create", "update"})
     */
    protected $building;

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
     * @return Construction
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getRemainingActions(): int
    {
        return $this->remainingActions;
    }

    /**
     * @param int $remainingActions
     * @return Construction
     */
    public function setRemainingActions(int $remainingActions): self
    {
        $this->remainingActions = $remainingActions;

        return $this;
    }

    /**
     * @return int
     */
    public function getRemainingMaterials(): int
    {
        return $this->remainingMaterials;
    }

    /**
     * @param int $remainingMaterials
     * @return Construction
     */
    public function setRemainingMaterials(int $remainingMaterials): self
    {
        $this->remainingMaterials = $remainingMaterials;

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
     * @param Guild|null $guild
     * @return Construction
     */
    public function setGuild(?Guild $guild): self
    {
        $this->guild = $guild;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Construction
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Building
     */
    public function getBuilding(): Building
    {
        return $this->building;
    }

    /**
     * @param Building $building
     * @return Construction
     */
    public function setBuilding(Building $building): self
    {
        $this->building = $building;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Construction
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}

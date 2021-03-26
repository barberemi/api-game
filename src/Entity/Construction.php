<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="construction")
 * @ORM\Entity(repositoryClass="App\Repository\ConstructionRepository")
 */
class Construction
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
    protected $remainingActions = 10;

    /**
     * @var array|null
     *
     * @ORM\Column(type="json", nullable=true)
     *
     * @Serializer\Expose
     * @Serializer\Type("array")
     * @Serializer\Groups({"create", "update"})
     */
    protected $remainingMaterials;

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
     * @return array|null
     */
    public function getRemainingMaterials(): ?array
    {
        return $this->remainingMaterials;
    }

    /**
     * @param array|null $remainingMaterials
     * @return Construction
     */
    public function setRemainingMaterials(?array $remainingMaterials): self
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
}

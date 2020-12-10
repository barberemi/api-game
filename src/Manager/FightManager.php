<?php

namespace App\Manager;

use App\Entity\Monster;
use App\Entity\User;
use App\Entity\Fight;
use App\Helper\FightHelper;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class FightManager extends AbstractManager
{
    /**
     * FightManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Fight::class);
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function get(int $id)
    {
        $fight  = $this->em->getRepository($this->repositoryNamespace)->find($id);

        if (!$fight) throw new \Exception(sprintf('Fight id %d doesnt exists.', $id));

        return $fight;
    }

    /**
     * @param Fight $fight
     * @return array|null
     */
    public function generateFight(Fight $fight): ?array
    {
        return FightHelper::generate($fight->getUser(), $fight->getMonster());
    }
}

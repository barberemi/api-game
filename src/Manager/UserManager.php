<?php

namespace App\Manager;

use App\Entity\Map;
use App\Entity\User;
use App\Helper\ExplorationHelper;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class UserManager extends AbstractManager
{
    /**
     * CharacteristicManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, User::class);
    }

    /**
     * @param array $data
     *
     * @return array|mixed
     *
     * @throws \Exception
     */
    public function create(array $data)
    {
        $exist = $this->em->getRepository(User::class)->findBy(['email' => $data['email']]);

        if ($exist) {
            throw new \Exception('User with this email already exists.');
        }

        $data['plainPassword'] = $data['password'];

        return parent::create($data);
    }

    /**
     * @param int int $idUser
     * @param $idMap
     *
     * @return null|array
     *
     * @throws \Exception
     */
    public function generateExploration(int $idUser, int $idMap): ?array
    {
        /** @var User $user */
        $user = $this->em->getRepository(User::class)->find($idUser);
        if (!$user) {
            throw new \Exception('User doesnt exists.');
        }

        /** @var Map $map */
        $map = $this->em->getRepository(Map::class)->find($idMap);
        if (!$map) {
            throw new \Exception('Map doesnt exists.');
        }

        $exploration = ExplorationHelper::generate($user, $map);
        $user->setExploration($exploration);
        $user = $this->em->getRepository(User::class)->softUpdate($user);

        return $user->getExploration();
    }

    /**
     * @param int $idUser
     * @param int $position
     *
     * @return null|array
     *
     * @throws \Exception
     */
    public function moveFromExploration(int $idUser, int $position): ?array
    {
        /** @var User $user */
        $user = $this->em->getRepository(User::class)->find($idUser);
        if (!$user) {
            throw new \Exception('User doesnt exists.');
        }

        $exploration = ExplorationHelper::moveToPosition($user->getExploration(), $position);
        $user->setExploration($exploration);
        $user = $this->em->getRepository(User::class)->softUpdate($user);

        return $user->getExploration();
    }
}

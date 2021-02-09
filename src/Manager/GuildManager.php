<?php

namespace App\Manager;

use App\Entity\Guild;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class GuildManager extends AbstractManager
{
    /**
     * GuildManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Guild::class);
    }

    /**
     * @param User $user
     * @param int $id
     * @param array $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function addOrRemoveMember(User $user, int $id, array $data)
    {
        $guild = $this->em->getRepository(Guild::class)->find($id);
        if (!$guild) {
            throw new \Exception('Guild with this id doesnt exists.');
        }

        $member = $this->em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if (!$member) {
            throw new \Exception('User with this email doesnt exists.');
        }
        if ($member->getGuild() && $member->getGuild() !== $guild) {
            throw new \Exception('User already have a guild.');
        }

        if (!array_key_exists('type', $data)) {
            throw new \Exception('No type to know if you want add or delete member.');
        }

        if ($data['type'] === "add") {
            if ($user->getRole() !== 'ROLE_ADMIN' &&
                $user->getGuildRole() !== User::MASTER_GUILD_ROLE &&
                $user->getGuildRole() !== User::OFFICER_GUILD_ROLE
            ) {
                throw new \Exception('User havent privileges to add a member.');
            }
            $guild->addUser($member);
            if ($member->getGuildRole() === null) {
                $member->setGuildRole(User::MEMBER_GUILD_ROLE);
                $this->em->getRepository(User::class)->softUpdate($member);
            }
        } else {
            if ($user->getRole() !== 'ROLE_ADMIN' &&
                $user->getGuildRole() !== User::MASTER_GUILD_ROLE &&
                $user->getGuildRole() !== User::OFFICER_GUILD_ROLE &&
                $user !== $member
            ) {
                throw new \Exception('User havent privileges to delete a member.');
            }
            $guild->removeUser($member);
            $member->setGuildRole(null);
            $this->em->getRepository(User::class)->softUpdate($member);
        }

        $this->em->getRepository($this->repositoryNamespace)->update($guild);

        return json_decode($this->serialize($guild));
    }
}

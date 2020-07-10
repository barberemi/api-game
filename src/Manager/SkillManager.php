<?php

namespace App\Manager;

use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class SkillManager extends AbstractManager
{
    /**
     * SkillManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Skill::class);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $entities = $this->em->getRepository(Skill::class)->findBy([
            'parent' => null,
        ]);

        $data = ['items' => []];
        foreach ($entities as $entity) {
            $data['items'][] = json_decode($this->serialize($entity));
        }

        return $data;
    }
}

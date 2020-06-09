<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SkillRepository extends AbstractRepository
{
    /**
     * SkillRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Skill::class, $validator);
    }
}

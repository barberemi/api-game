<?php

namespace App\Manager;

use App\Entity\Construction;
use App\Entity\OwnItem;
use App\Entity\User;
use App\Helper\ConstructionHelper;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class ConstructionManager extends AbstractManager
{
    /**
     * ConstructionManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Construction::class);
    }

    /**
     * @param int $id
     * @param mixed $user
     * @param array $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function giveActionOrMaterial(int $id, $user, array $data)
    {
        // Check if construction exists
        /** @var Construction $construction */
        $construction = $this->em->getRepository($this->repositoryNamespace)->find($id);
        if (!$construction) throw new \Exception(sprintf('Construction id %d doesnt exists.', $id));

        // Check if user can (ADMIN OR User of the guild)
        if ($user->getRole() !== 'ROLE_ADMIN'){
            if ($construction->getUser() && $construction->getUser()->getId() !== $user->getId()) {
                throw new \Exception('This user cannot construct this building.');
            }
            if ($construction->getGuild() && $user->getGuild() && $construction->getGuild()->getId() !== $user->getGuild()->getId()) {
                throw new \Exception('Not on the same guild.');
            }
        }

        // Check if parent construction is DONE
        $parentBuilding = $construction->getBuilding()->getParent();
        if ($parentBuilding) {
            if ($construction->getUser()) {
                /** @var Construction $constructionParent */
                $constructionParent = $this->em->getRepository($this->repositoryNamespace)->findOneBy(
                    ['user' => $construction->getUser(), 'building' => $parentBuilding]
                );
            } else {
                /** @var Construction $constructionParent */
                $constructionParent = $this->em->getRepository($this->repositoryNamespace)->findOneBy(
                    ['guild' => $construction->getGuild(), 'building' => $parentBuilding]
                );
            }
            if ($constructionParent && $constructionParent->getStatus() !== Construction::DONE_STATUS) {
                throw new \Exception('Construction parent need to be DONE.');
            }
        }

        ConstructionHelper::decrementData($construction, $data);

        if ($data['type'] === "action") {
            if ($user->getRemainingActions() < 1) {
                throw new \Exception('Havent enough actions. Try tomorrow.');
            }
            $user->setRemainingActions($user->getRemainingActions() - 1);
            $this->em->getRepository(User::class)->softUpdate($user);
        } else if ($data['type'] === "material") {
            $find = false;
            /** @var OwnItem $item */
            foreach ($user->getItems() as $item) {
                if($item->getItem()->getName() === "Bois") {
                    $find = true;
                    $this->em->getRepository(OwnItem::class)->delete($item);
                    break;
                }
            }
            if (!$find) {
                throw new \Exception('Havent Wood on your inventory.');
            }
        }

        $construction = $this->em->getRepository($this->repositoryNamespace)->update($construction);

        return json_decode($this->serialize($user));
    }
}
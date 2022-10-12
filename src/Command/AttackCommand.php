<?php

namespace App\Command;

use App\Entity\Guild;
use App\Entity\Season;
use App\Entity\User;
use App\Entity\OwnItem;
use App\Helper\AttackHelper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 */
class AttackCommand extends Command
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;


    /**
     * AttackCommand constructor.
     *
     * @param LoggerInterface        $logger
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct();
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('app:attack-monster')
            ->setDescription('Daily monsters attack.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger->info(sprintf('[Reset Attack] Started.'));

        $guilds = $this->entityManager->getRepository(Guild::class)->findAll();
        $count = 0;
        $currentSeason = null;

        /** @var Guild $guild */
        foreach ($guilds as $guild) {
            $count++;

            /** **************** **/
            /** 1 - SCOUTING - 1 **/
            /** **************** **/
            // Nbr monstres fixe
            $guild->setLastAttack(AttackHelper::newLastAttackMonsters($guild));

            // Nbr monstres avec un pourcentage (vrai nb)
            $guild->setLastTrueAttack(AttackHelper::nightAttack($guild));

            // Reset mini and maxi attack
            $guild->setMinAttack(null);
            $guild->setMaxAttack(null);

            // Tirages
            $nbScout = 0;
            /** @var User $user */
            foreach ($guild->getUsers() as $user) {
                if ($user->getJob() && $user->getJob()->getName() === "scout") {
                    $nbScout++;
                }
            }
            // No scouts => no draws
            if ($nbScout === 0) {
                $guild->setUpDraw(0);
                $guild->setDownDraw(0);
            } else {
                $minInterval = AttackHelper::minInterval($guild);
                $maxInterval = AttackHelper::maxInterval($guild);

                $diff      = $maxInterval - $minInterval;
                $variation = round($diff / $nbScout);
                $attack    = Attackhelper::nightAttack($guild);
                $clone     = $minInterval + $variation;
                $downDraw  = 0;
                while ($clone <= $attack) {
                    $downDraw++;
                    $clone = $clone + $variation;
                }

                $guild->setDownDraw($downDraw);
                $guild->setUpDraw($nbScout - $downDraw - 1);
            }

            /** **************** **/
            /** 2 -  ATTACK  - 2 **/
            /** **************** **/
            $this->logger->info(sprintf('Guild %s attacked by %d monsters.', $guild->getName(), $guild->getLastTrueAttack()));

            if ($guild->getDefense() < $guild->getLastTrueAttack()) {
                // Reset le nombre de jour dans la saison
                $guild->setSeasonDay(1);
                // Reset de l'exploration et de la position de guilde
                $guild->setExploration(null);
                $guild->setPosition(0);
                // Reset du boss de guild et des fights en cours
                $guild->setMonster(null);
                // Mise a 0 du champ User pour le message de défaite de la guilde
                /** @var User $user */
                foreach ($guild->getUsers() as $user) {
                    $user->setHasSurvivedToAttack(0);
                }
            } else {
                // Ajout de 1 au compteur de jour de saison
                $guild->setSeasonDay($guild->getSeasonDay() + 1);
                // Mise a 1 du champ User pour le message de victoire de la guilde
                /** @var User $user */
                foreach ($guild->getUsers() as $user) {
                    $user->setHasSurvivedToAttack(1);
                }
            }
            // Check si on a dépassé le record de saison
            if ($guild->getSeasonDay() > $guild->getSeasonRecord()) {
                $guild->setSeasonRecord($guild->getSeasonDay());
            }

            // Flush
            if ($count % 30 === 0) {
                $this->entityManager->flush();
            }
        }
        $this->entityManager->flush();
        $this->logger->info($count . ' guilds attacked successfully.');

        /** **************** **/
        /** 3 -  SEASON  - 3 **/
        /** **************** **/
        date_default_timezone_set('Europe/Paris');
        $date = new \DateTime();
        $date->modify("-1 day");
        $seasons = $this->entityManager->getRepository(Season::class)->findAll();

        /** @var Season $season */
        foreach ($seasons as $season) {
            if (
                $season->getStartingAt()->format("Y-m-d") < $date->format("Y-m-d") &&
                $season->getEndingAt()->format("Y-m-d") >= $date->format("Y-m-d")
            ) {
                $currentSeason = $season;
            }
        }

        if (isset($currentSeason)) {
            // Check si jour de fin de saison
            if (
                $currentSeason->getEndingAt()->format("Y-m-d") === $date->format("Y-m-d") &&
                !$currentSeason->isRewarded()
            ) {
                $currentSeason->setIsRewarded(true);
                $this->logger->info(sprintf('Fin de la saison %d.', $currentSeason->getId()));

                if ($guilds) {
                    // Order guilds by ranking : season_record desc
                    usort($guilds, function ($guild1, $guild2) {
                        return $guild2->getSeasonRecord() <=> $guild1->getSeasonRecord();
                    });

                    // Reset des compteurs de jours de saison des guildes
                    /** @var Guild $aGuild */
                    foreach ($guilds as $aGuild) {
                        $aGuild->setSeasonDay(0);
                        $aGuild->setSeasonRecord(0);
                    }

                    // Check des objets à donner aux joueurs du TOP 1 des guildes
                    /** @var OwnItem $ownItem */
                    foreach ($currentSeason->getItemsRewarded1() as $ownItem) {
                        /** @var User $user */
                        foreach ($guilds[0]->getUsers() as $user) {
                            $newOwnItem = (new OwnItem())->setUser($user)->setItem($ownItem->getItem());
                            $user->addItem($newOwnItem);
                        }
                        $this->logger->info(sprintf('Obtention objet %s pour la guilde %s.', $ownItem->getItem()->getName(), $guilds[0]->getName()));
                    }

                    // Check des objets à donner aux joueurs du TOP 2-9 des guildes
                    /** @var OwnItem $ownItem */
                    foreach ($currentSeason->getItemsRewarded2() as $ownItem) {
                        for ($i = 1; $i <= 9; $i++) {
                            // Pas de guilde on stop
                            if (!array_key_exists($i, $guilds)) {
                                break;
                            }
                            /** @var User $user */
                            foreach ($guilds[$i]->getUsers() as $user) {
                                $newOwnItem = (new OwnItem())->setUser($user)->setItem($ownItem->getItem());
                                $user->addItem($newOwnItem);
                            }
                            $this->logger->info(sprintf('Obtention objet %s pour la guilde %s.', $ownItem->getItem()->getName(), $guilds[$i]->getName()));
                        }
                    }

                    // Check des objets à donner aux joueurs du TOP 10-50 des guildes
                    /** @var OwnItem $ownItem */
                    foreach ($currentSeason->getItemsRewarded3() as $ownItem) {
                        for ($i = 10; $i <= 50; $i++) {
                            // Pas de guilde on stop
                            if (!array_key_exists($i, $guilds)) {
                                break;
                            }
                            /** @var User $user */
                            foreach ($guilds[$i]->getUsers() as $user) {
                                $newOwnItem = (new OwnItem())->setUser($user)->setItem($ownItem->getItem());
                                $user->addItem($newOwnItem);
                            }
                            $this->logger->info(sprintf('Obtention objet %s pour la guilde %s.', $ownItem->getItem()->getName(), $guilds[$i]->getName()));
                        }
                    }

                    // Check des objets à donner aux joueurs du TOP 51-* des guildes
                    /** @var OwnItem $ownItem */
                    foreach ($currentSeason->getItemsRewarded4() as $ownItem) {
                        for ($i = 51; $i <= 1000; $i++) {
                            // Pas de guilde on stop
                            if (!array_key_exists($i, $guilds)) {
                                break;
                            }
                            /** @var User $user */
                            foreach ($guilds[$i]->getUsers() as $user) {
                                $newOwnItem = (new OwnItem())->setUser($user)->setItem($ownItem->getItem());
                                $user->addItem($newOwnItem);
                            }
                            $this->logger->info(sprintf('Obtention objet %s pour la guilde %s.', $ownItem->getItem()->getName(), $guilds[$i]->getName()));
                        }
                    }
                    $this->logger->info(sprintf('Objets de fin de saison données avec succès.'));
                }
            }
        }

        $this->entityManager->flush();

        $this->logger->info(sprintf('[Reset Attack] Finished.'));

        return 1;
    }
}

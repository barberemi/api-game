<?php

namespace App\Command;

use App\Entity\Guild;
use App\Entity\User;
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
                $guild->setUpDraw($nbScout - $downDraw -1);
            }

            /** **************** **/
            /** 2 -  ATTACK  - 2 **/
            /** **************** **/

            $this->logger->info(sprintf('Guild %s attacked by %d monsters.', $guild->getName(), $guild->getLastTrueAttack()));

            if ($guild->getDefense() < $guild->getLastTrueAttack()) {

            }

            if ($count % 30 === 0) {
                $this->entityManager->flush();
            }
        }
        $this->entityManager->flush();
        $this->logger->info($count . ' guilds attacked successfully.');

        $this->logger->info(sprintf('[Reset Attack] Finished.'));

        return 1;
    }
}

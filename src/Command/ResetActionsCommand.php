<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 */
class ResetActionsCommand extends Command
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
     * ItemsCommand constructor.
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
        $this->setName('app:user-reset-actions')
            ->setDescription('Reset users actions.');
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
        $this->logger->info(sprintf('[Reset users actions] Started.'));

        $users = $this->entityManager->getRepository(User::class)->findAll();
        $count = 0;

        /** @var User $user */
        foreach ($users as $user) {
            $count++;
            $user->setRemainingActions($user->getMaxActions());

            if ($count % 30 === 0) {
                $this->entityManager->flush();
            }
        }
        $this->entityManager->flush();
        $this->logger->info($count . ' actions users reset successfully.');

        $this->logger->info(sprintf('[Reset users actions] Finished.'));

        return 1;
    }
}

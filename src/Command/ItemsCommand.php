<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 */
class ItemsCommand extends Command
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
        $this->setName('app:copy-dofus-items')
            ->setDescription('To copy items from Dofus API.');
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
        $this->logger->info(sprintf('[Copy Dofus Items] Started.'));

        $this->logger->info(sprintf('[Copy Dofus Items] File reading on progress...'));
        $content    = file_get_contents(dirname(__DIR__) . "/Command/equipments.json");
        $equipments = json_decode($content, true);

        $types = [];
        $characteristics = [];
        foreach ($equipments as $equipment) {
            if (!in_array($equipment['type'], $types)) {
                $types[] = $equipment['type'];
            }
            if (array_key_exists('statistics', $equipment)) {
                foreach ($equipment['statistics'] as $characteristic) {
//                    dd(array_key_first($characteristic));
                    if (!in_array(array_key_first($characteristic), $characteristics)) {
                        $characteristics[] = array_key_first($characteristic);
                    }
                }
            }
        }
        $this->logger->info(sprintf('[Copy Dofus Items] File reading finished.'));

        $this->logger->info(sprintf('All types of equipments :'));
        foreach ($types as $type) {
            $this->logger->info(sprintf('%s', $type));
        }
        $this->logger->info(sprintf('All characteristics of equipments :'));
//        foreach ($characteristics as $characteristic) {
//            $this->logger->info(sprintf('%s', $characteristic));
//        }
        $this->logger->info(count($characteristics));
//        $courses = $this->entityManager->getRepository(Course::class)->findAll();
//
//        $messageContent = [];
//        foreach ($courses as $course) {
//            $messageContent[] = [
//                'course_id' => $course->getId(),
//                'tracing_id' => uniqid(sprintf('program-generation-%d-', $course->getId())),
//            ];
//        }
//        $this->slackMessageFactory->notifyProgramGenerationStarted($itemCount);
        $this->logger->info(sprintf('[Copy Dofus Items] Finished.'));

        return 1;
    }
}

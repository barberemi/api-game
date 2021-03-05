<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 */
class MapsCommand extends Command
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
        $this->setName('app:copy-dofus-maps')
            ->setDescription('To copy maps from Dofus API.');
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
        $this->logger->info(sprintf('[Copy Dofus Maps] Started.'));

        $this->logger->info(sprintf('[Copy Dofus Maps] File reading on progress...'));
        $content    = file_get_contents(dirname(__DIR__) . "/Command/monsters.json");
        $monsters = json_decode($content, true);

        $maps = [];
        $types = [];
        foreach ($monsters as $monster) {
            if (array_key_exists('areas', $monster)) {
                foreach ($monster['areas'] as $area) {
                    if (!in_array($area, $maps)) {
                        $maps[] = $area;
                    }
                }
            }
            if (!in_array($monster['type'], $types)) {
                $types[] = $monster['type'];
            }
        }
        $this->logger->info(sprintf('[Copy Dofus Maps] File reading finished.'));

        $this->logger->info(sprintf('All areas of monsters (' . count($maps) . ') :'));
        foreach ($maps as $map) {
            $this->logger->info(sprintf('%s', $map));
        }

        $this->logger->info(sprintf('All types of monsters (' . count($types) . ') :'));
        foreach ($types as $type) {
            $this->logger->info(sprintf('%s', $type));
        }
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
        $this->logger->info(sprintf('[Copy Dofus Maps] Finished.'));

        return 1;
    }
}

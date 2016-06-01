<?php

namespace OverwatchBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
use OverwatchBundle\Document\Verdict;
use OverwatchBundle\Document\UserScore;
use OverwatchBundle\Repository\OverwatchRepository;
use OverwatchBundle\Service\OverwatchService;
use OverwatchBundle\Service\UserScoreService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Document\User;
use UserBundle\Service\UserService;

class ProcessUserScoresCommand extends BaseContainerAwareCommand {

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var OverwatchService
     */
    private $overwatchService;

    /**
     * @var  OverwatchRepository
     */
    private $overwatchRepository;

    /**
     * @var UserScoreService
     */
    private $userScoreService;

    /**
     * @var int
     */
    private $processed = 0;

    protected function configure() {
        $this->setName('owt:processUserScores')
            ->setDescription('Calculates and sums user submitted verdicts');
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $start = microtime(true);

        $periods = $this->userScoreService->getAvailablePeriods();

        foreach ($periods as $period) {
            $aggregatedUserScores = $this->overwatchRepository->getUserscores($period);
            $this->overwatchRepository->deleteByPeriod($period);

            foreach ($aggregatedUserScores as $aggregatedUserScore) {
                $userScore = new UserScore();

                $userScore->setUserId($aggregatedUserScore['_id']);
                $userScore->setVerdicts($aggregatedUserScore['value']);
                $userScore->setPeriod($period);
                $userScore->setPosition(8);

                $this->userScoreService->save($userScore);
                $this->processed++;
            }

            $i = 1;
            $scoresByPeriod = $this->userScoreService->findByPeriod($period);
            foreach ($scoresByPeriod as $currentScore) {
                $currentScore->setPosition($i);
                $this->userScoreService->save($currentScore);

                $i++;
            }
        }

        $output->writeln(sprintf('Calculated %d user scores in %f seconds', $this->processed, microtime(true) - $start));
    }

    protected function initServices() {
        $this->userService = $this->container->get(UserService::ID);
        $this->overwatchService = $this->container->get(OverwatchService::ID);
        $this->userScoreService = $this->container->get(UserScoreService::ID);

        $this->overwatchRepository = $this->container
            ->get('doctrine_mongodb')
            ->getManager()
            ->getRepository(OverwatchRepository::ID);
    }
}
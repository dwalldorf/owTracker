<?php

namespace OverwatchBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
use OverwatchBundle\Document\UserScore;
use OverwatchBundle\Repository\OverwatchRepository;
use OverwatchBundle\Service\OverwatchService;
use OverwatchBundle\Service\UserScoreService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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

    protected function initServices() {
        $this->userService = $this->getService(UserService::ID);
        $this->overwatchService = $this->getService(OverwatchService::ID);
        $this->userScoreService = $this->getService(UserScoreService::ID);

        $this->overwatchRepository = $this->container
            ->get('doctrine_mongodb')
            ->getManager()
            ->getRepository(OverwatchRepository::ID);
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $periods = $this->userScoreService->getAvailablePeriods();
        $calculated = new \DateTime();

        foreach ($periods as $period) {
            $aggregatedUserScores = $this->overwatchRepository->getUserscores($period);
            $this->overwatchRepository->deleteByPeriod($period);

            $position = 1;
            foreach ($aggregatedUserScores as $aggregatedUserScore) {
                $userScore = new UserScore();

                $userScore->setUserId($aggregatedUserScore['_id']);
                $userScore->setVerdicts($aggregatedUserScore['value']);
                $userScore->setPeriod($period);
                $userScore->setPosition($position);
                $userScore->setCalculated($calculated);

                $this->userScoreService->save($userScore);

                $position++;
                $this->processed++;
                unset($userScore);
            }

            $i = 1;
            $scoresByPeriod = $this->userScoreService->findByPeriod($period);
            foreach ($scoresByPeriod as $currentScore) {
                $currentScore->setPosition($i);
                $this->userScoreService->save($currentScore);

                $i++;
            }
        }
    }
}
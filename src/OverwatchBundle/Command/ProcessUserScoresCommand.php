<?php

namespace OverwatchBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
use OverwatchBundle\Document\Overwatch;
use OverwatchBundle\Document\OverwatchUserScore;
use OverwatchBundle\Service\OverwatchService;
use OverwatchBundle\Service\OverwatchUserScoreService;
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
     * @var OverwatchUserScoreService
     */
    private $overwatchUserScoreService;

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

        $this->calculateUserScores();

        $output->writeln(sprintf('Calculated %d user scores in %f seconds', $this->processed, microtime(true) - $start));
    }

    protected function initServices() {
        $this->userService = $this->container->get(UserService::ID);
        $this->overwatchService = $this->container->get(OverwatchService::ID);
        $this->overwatchUserScoreService = $this->container->get(OverwatchUserScoreService::ID);
    }

    private function calculateUserScores() {
        $periods = $this->overwatchUserScoreService->getAvailablePeriods();
        $users = $this->userService->getAllActiveUsers();

        foreach ($users as $user) {
            $overwatchCases = $this->overwatchService->getByUser($user);

            if ($overwatchCases) {
                foreach ($periods as $period) {
                    $userScore = $this->getUserScore($period, $user, $overwatchCases);
                    $this->overwatchUserScoreService->save($userScore);
                }
            }
        }
    }

    /**
     * @param int $period
     * @param User $user
     * @param Overwatch[] $overwatchCases
     * @return OverwatchUserScore
     */
    private function getUserScore($period, User $user, array $overwatchCases) {
        $start = microtime(true);

        $userScore = new OverwatchUserScore($period, $user->getId());

        if ($period === 0) {
            $userScore->setNumberOfOverwatches(count($overwatchCases));
        } else {
            foreach ($overwatchCases as $overwatchCase) {
                $until = new \DateTime(sprintf('-%d day', $period));
                $untilTimestamp = $until->getTimestamp();
                $overwatchDate = $overwatchCase->getOverwatchDate();

                if ($overwatchDate) {
                    $overwatchTimestamp = $overwatchDate->getTimestamp();
                    if ($overwatchTimestamp > $untilTimestamp) {
                        $userScore->addOverwatch();
                    }
                }
            }
        }

        $userScore->setCalculated(new \DateTime());
        $userScore->setCalulatedInMs(microtime(true) - $start);

        $this->processed++;
        return $userScore;
    }
}
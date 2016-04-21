<?php

namespace OverwatchBundle\Command;

use OverwatchBundle\Document\Overwatch;
use OverwatchBundle\Document\OverwatchUserScore;
use OverwatchBundle\Service\OverwatchService;
use OverwatchBundle\Service\OverwatchUserScoreService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Document\User;
use UserBundle\Service\UserService;

class CalculateUserScoresCommand extends ContainerAwareCommand {

    /**
     * @var ContainerInterface
     */
    private $container;

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

    protected function configure() {
        $this->setName('owt:userScores')
            ->setDescription('Calculates and sums user submitted verdicts');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $start = microtime(true);

        $count = $this->calculateUserScores();

        $output->writeln(sprintf('Calculated %d user scores in %f seconds', $count, microtime(true) - $start));
    }

    protected function initServices() {
        $this->container = $this->getContainer();

        $this->userService = $this->container->get(UserService::ID);
        $this->overwatchService = $this->container->get(OverwatchService::ID);
        $this->overwatchUserScoreService = $this->container->get(OverwatchUserScoreService::ID);
    }

    /**
     * @return int
     */
    private function calculateUserScores() {
        $count = 0;
        $users = $this->userService->getAllActiveUsers();

        foreach ($users as $user) {
            $overwatchCases = $this->overwatchService->getByUser($user);

            if ($overwatchCases) {
                $dailyScore = $this->getUserScore(OverwatchUserScore::DAILY_PERIOD, $user, $overwatchCases);
                $weeklyScore = $this->getUserScore(OverwatchUserScore::WEEKLY_PERIOD, $user, $overwatchCases);
                $monthlyScore = $this->getUserScore(OverwatchUserScore::MONTHLY_PERIOD, $user, $overwatchCases);

                $this->overwatchUserScoreService->save($dailyScore);
                $this->overwatchUserScoreService->save($weeklyScore);
                $this->overwatchUserScoreService->save($monthlyScore);

                $count = $count + 3;
            }
        }

        return $count;
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
        $userScore->setCalculated(new \DateTime());
        $userScore->setCalulatedInMs(microtime(true) - $start);

        return $userScore;
    }
}
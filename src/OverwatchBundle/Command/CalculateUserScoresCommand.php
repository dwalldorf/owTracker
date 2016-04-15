<?php

namespace OverwatchBundle\Command;

use OverwatchBundle\Document\Overwatch;
use OverwatchBundle\Document\OverwatchUserScore;
use OverwatchBundle\Service\OverwatchService;
use OverwatchBundle\Service\OverwatchUserScoreService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Document\User;
use UserBundle\Service\UserService;

class CalculateUserScoresCommand extends ContainerAwareCommand {

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
        $this->setName('overwatch:userScores')
            ->setDescription('Calculates and sums user submitted verdicts');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->initServices();

        $this->calculateUserScores();
    }

    private function initServices() {
        $this->container = $this->getContainer();

        $this->userService = $this->container->get(UserService::ID);
        $this->overwatchService = $this->container->get(OverwatchService::ID);
        $this->overwatchUserScoreService = $this->container->get(OverwatchUserScoreService::ID);
    }

    private function calculateUserScores() {
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
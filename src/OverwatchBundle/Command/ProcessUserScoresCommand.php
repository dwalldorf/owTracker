<?php

namespace OverwatchBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
use OverwatchBundle\Document\Verdict;
use OverwatchBundle\Document\UserScore;
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

        $this->calculateUserScores();

        $output->writeln(sprintf('Calculated %d user scores in %f seconds', $this->processed, microtime(true) - $start));
    }

    protected function initServices() {
        $this->userService = $this->container->get(UserService::ID);
        $this->overwatchService = $this->container->get(OverwatchService::ID);
        $this->userScoreService = $this->container->get(UserScoreService::ID);
    }

    private function calculateUserScores() {
        $periods = $this->userScoreService->getAvailablePeriods();
        $users = $this->userService->getAllActiveUsers();

        foreach ($users as $user) {
            $verdicts = $this->overwatchService->getByUserId($user->getId());

            if ($verdicts) {
                foreach ($periods as $period) {
                    $userScore = $this->getUserScore($period, $user, $verdicts);
                    $this->userScoreService->save($userScore);
                }
            }
        }
    }

    /**
     * @param int $period
     * @param User $user
     * @param Verdict[] $verdicts
     * @return UserScore
     */
    private function getUserScore($period, User $user, array $verdicts) {
        $start = microtime(true);

        $userScore = new UserScore();
        $userScore->setPeriod($period);
        $userScore->setUserId($userScore->getId());

        if ($period === 0) {
            $userScore->setVerdicts(count($verdicts));
        } else {
            foreach ($verdicts as $verdict) {
                $until = strtotime(sprintf('-%d days', $period));
                $verdictTimestamp = $verdict->getOverwatchDate()->getTimestamp();

                if ($verdictTimestamp > $until) {
                    $userScore->addOverwatch();
                }
            }
        }

        $userScore->setCalculated(new \DateTime());
        $userScore->setCalculatedInMs(microtime(true) - $start);

        $this->processed++;
        return $userScore;
    }
}
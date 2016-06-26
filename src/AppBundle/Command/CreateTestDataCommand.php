<?php

namespace AppBundle\Command;

use AppBundle\Util\RandomUtil;
use AppBundle\Util\StopWatch;
use DemoBundle\Document\Demo;
use DemoBundle\Document\RoundEventKill;
use DemoBundle\Document\MatchRound;
use DemoBundle\Document\MatchInfo;
use DemoBundle\Document\MatchPlayer;
use DemoBundle\Document\MatchTeam;
use DemoBundle\Document\RoundEvents;
use DemoBundle\Service\DemoService;
use FeedbackBundle\Document\Feedback;
use FeedbackBundle\Service\FeedbackService;
use OverwatchBundle\Document\Verdict;
use OverwatchBundle\Service\OverwatchService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Document\User;
use UserBundle\Service\UserService;

class CreateTestDataCommand extends BaseContainerAwareCommand {

    const PROBABILITY_LENGTH = 100000;

    const POWER_USER_RATE = 15;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var OverwatchService
     */
    private $overwatchService;

    /**
     * @var FeedbackService
     */
    private $feedbackService;

    /**
     * @var DemoService
     */
    private $demoService;

    /**
     * @var string
     */
    private $specificUser;

    /**
     * @var bool
     */
    private $verbose = false;

    /**
     * @var int
     */
    private $verdictAmount;

    /**
     * @var bool
     */
    private $includePowerUsers = false;

    /**
     * @var int
     */
    private $userAmount;

    /**
     * @var int
     */
    private $feedbackAmount;

    /**
     * @var int
     */
    private $demoAmount;

    /**
     * @var int
     */
    private $createdUsers = 0;

    /**
     * @var int
     */
    private $createdVerdicts = 0;

    /**
     * @var int
     */
    private $createdVerdictsUniqueUsers = 0;

    /**
     * @var int
     */
    private $createdFeedback = 0;

    /**
     * @var int
     */
    private $createdFeedbackUniqueUsers = 0;

    /**
     * @var int
     */
    private $createdPowerUsers = 0;

    /**
     * @var int
     */
    private $createdDemos = 0;

    /**
     * @var int
     */
    private $createdDemosUniqueUsers = 0;

    const OPT_USER_NAME = 'user';

    const OPT_VERDICT_AMOUNT_NAME = 'verdicts';

    const OPT_VERDICT_AMOUNT_DEFAULT = 20;

    const OPT_USER_AMOUNT_NAME = 'amount';

    const OPT_USER_AMOUNT_DEFAULT = 20;

    const OPT_FEEDBACK_AMOUNT_NAME = 'feedback';

    const OPT_DEMOS_AMOUNT_NAME = 'demos';

    const OPT_POWER_USER = 'powerUser';

    protected function configure() {
        $this->setName('owt:createTestData')
            ->addOption(
                self::OPT_USER_NAME,
                'u',
                InputArgument::OPTIONAL,
                'User\'s mongo id or email address - take a look at options when specifying user'
            )
            ->addOption(
                self::OPT_USER_AMOUNT_NAME,
                'a',
                InputArgument::OPTIONAL,
                'Amount of users to generate (20 if not set)'
            )
            ->addOption(
                self::OPT_VERDICT_AMOUNT_NAME,
                'o',
                InputArgument::OPTIONAL,
                'Only if user specified - amount of overwatch verdicts to generate (0 by default)'
            )
            ->addOption(
                self::OPT_FEEDBACK_AMOUNT_NAME,
                'f',
                InputArgument::OPTIONAL,
                'Only if user specified - amount of feedback entries to generate (0 by default)'
            )
            ->addOption(
                self::OPT_DEMOS_AMOUNT_NAME,
                'd',
                InputArgument::OPTIONAL,
                'Only if user specified - amount of demos to generate (0 by default)'
            )
            ->addOption(
                self::OPT_POWER_USER,
                'p',
                InputArgument::OPTIONAL,
                'Include power users. Will generate user with 10% chance of being a power user with 800 - 5000 verdicts. Useful when working on score calculation.',
                false
            );
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $sw = new StopWatch();
        $sw->start();

        $this->verbose = $input->getOption('verbose');
        $this->specificUser = $input->getOption(self::OPT_USER_NAME);
        $this->verdictAmount = $input->getOption(self::OPT_VERDICT_AMOUNT_NAME);
        $this->includePowerUsers = $input->getOption(self::OPT_POWER_USER);
        $this->feedbackAmount = $input->getOption(self::OPT_FEEDBACK_AMOUNT_NAME);
        $this->demoAmount = $input->getOption(self::OPT_DEMOS_AMOUNT_NAME);

        $this->userAmount = $input->getOption(self::OPT_USER_AMOUNT_NAME);

        if ($this->specificUser) {
            $user = $this->userService->findById($this->specificUser);
            if (!$user) {
                $user = $this->userService->findByUsernameOrEmail($this->specificUser);
            }

            if (!$user) {
                $this->error(sprintf('user not found.'));
                die(1);
            }

            if ($this->verdictAmount) {
                if ($this->verbose) {
                    $this->debug(sprintf('creating %d verdict(s) for user %s', $this->verdictAmount, $user->getEmail()));
                }
                $this->createVerdicts($this->verdictAmount, $user);
            }

            if ($this->feedbackAmount) {
                if ($this->verbose) {
                    $this->debug(sprintf('creating %d feedback entrie(s) for user %s', $this->feedbackAmount, $user->getUsername()));
                }
                while ($this->createdFeedback < $this->feedbackAmount) {
                    $this->createFeedback($user);
                }
            }

            if ($this->demoAmount) {
                if ($this->verbose) {
                    $this->debug(sprintf('creating %d demo(s) for %s', $this->demoAmount, $user->getEmail()));
                }
                $this->createDemos($this->demoAmount, $user);
            }
        } else {
            if (!$this->userAmount) {
                $this->userAmount = self::OPT_USER_AMOUNT_DEFAULT;
                $this->info(sprintf('amount of users to generate not set. using default of %d', $this->userAmount));
            }

            $this->createTestData();
        }

        $powerUsersInfo = '';
        if ($this->includePowerUsers) {
            $powerUsersInfo = sprintf(
                '
    %d power users',
                $this->createdPowerUsers
            );
        }

        $sw->stop();
        $this->info(
            sprintf(
                'Finished: 
    %d users 
    %d verdicts of %d unique users
    %d feedback entries of %d unique users
    %d demos of %d unique user %s

    Runtime: %s seconds',
                $this->createdUsers,
                $this->createdVerdicts,
                $this->createdVerdictsUniqueUsers,
                $this->createdFeedback,
                $this->createdFeedbackUniqueUsers,
                $this->createdDemos,
                $this->createdDemosUniqueUsers,
                $powerUsersInfo,
                $sw->getRuntimeStringInS()
            )
        );
    }

    protected function initServices() {
        $this->userService = $this->container->get(UserService::ID);
        $this->overwatchService = $this->container->get(OverwatchService::ID);
        $this->feedbackService = $this->container->get(FeedbackService::ID);
        $this->demoService = $this->container->get(DemoService::ID);
    }

    /**
     * @return int
     */
    private function createTestData() {
        $powerUsersToCreate = 0;

        if ($this->includePowerUsers) {
            $powerUsersToCreate = $this->userAmount % self::POWER_USER_RATE;
        }

        for ($i = 0; $i < $this->userAmount; $i++) {
            $username = 'owtTestUser_' . $this->getRandomString();
            $email = $username . '@' . $this->getRandomString(5) . '.com';

            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($this->getRandomString());
            $user->setRegistered($this->getRandomDate()->getTimestamp());

            $this->userService->register($user);

            if ($powerUsersToCreate > 0 && $this->createdPowerUsers < $powerUsersToCreate) {
                $amountOfOverwatches = mt_rand(1000, 5000);
            } else if ($this->getRandomBoolWithProbability(20)) {
                $amountOfOverwatches = mt_rand(40, 100);
            } else {
                $amountOfOverwatches = mt_rand(0, 20);
            }
            $this->createVerdicts($amountOfOverwatches, $user);

            if ($this->getRandomBoolWithProbability(0.2)) {
                $this->createFeedback($user);
            }

            if ($this->verbose) {
                $this->debug(sprintf('created user %s', $user->getEmail()));
                $this->debug(sprintf('created %d verdicts', $amountOfOverwatches));
                $this->debug();
            }

            $this->createdUsers++;
            $user = null;
        }
    }

    /**
     * @param int $amount
     * @param User $user
     */
    private function createVerdicts($amount, User $user) {
        if ($this->verbose) {
            $this->debug('aim | vision | other | griefing | map');
        }

        for ($i = 0; $i < $amount; $i++) {
            $verdict = $this->getRandomVerdict($user);
            $this->overwatchService->save($verdict);

            if ($this->verbose) {
                $this->debug(
                    sprintf(
                        ' %s   |  %s  |   %s    |   %s       | %s',
                        $this->xIf($verdict->isAimAssist()),
                        $this->xIf($verdict->isVisionAssist()),
                        $this->xIf($verdict->isOtherAssist()),
                        $this->xIf($verdict->isGriefing()),
                        $verdict->getMap()
                    )
                );
            }

            $this->createdVerdicts++;
            $verdict = null;
        }
        if ($this->verbose) {
            $this->debug();
        }
        $this->createdVerdictsUniqueUsers++;
    }

    private function createDemos($amount, User $user) {
        for ($demoCounter = 0; $demoCounter < $amount; $demoCounter++) {
            $team1Rounds = null;
            $team2Rounds = null;
            $totalRounds = null;
            $rounds = [];

            if ($this->getRandomBool()) {
                $team1Rounds = 16;
                $team2Rounds = mt_rand(1, 14);
            } else {
                $team1Rounds = mt_rand(1, 14);
                $team2Rounds = 16;
            }
            $totalRounds = $team1Rounds + $team2Rounds;

            $team1 = $this->createTeam($user);
            $team2 = $this->createTeam();

            $matchInfo = new MatchInfo(
                $this->getRandomMap(),
                $team1,
                $team2,
                $team1Rounds,
                $team2Rounds
            );

            /*
             * round end scenarios (winner)
             * - bomb plant and explosion (T)
             * - all CT's eliminated (T)
             * - all T's eliminated (CT)
             * - bomb planted and defused (CT)
             * - round time over without bomb plant (CT)
             *
             * we only end rounds with all players of one team killed
             */
            $roundCounter = 1;
            while ($roundCounter < $totalRounds + 1) {
                for ($team1RoundCounter = 0; $team1RoundCounter < $team1Rounds; $team1RoundCounter++) {
                    $rounds[] = $this->createDemoRound($roundCounter, $team1, $team2);
                    $roundCounter++;
                }
                for ($team2RoundCounter = 0; $team2RoundCounter < $team2Rounds; $team2RoundCounter++) {
                    $rounds[] = $this->createDemoRound($roundCounter, $team2, $team1);
                    $roundCounter++;
                }
            }
            $demo = new Demo(null, $user->getId(), $matchInfo, $rounds);
            $this->demoService->save($demo);

            if ($this->verbose) {
                $this->debug(
                    sprintf(
                        'demo: %s VS %s - %d:%d',
                        $team1->getTeamName(),
                        $team2->getTeamName(),
                        $team1Rounds,
                        $team2Rounds
                    )
                );
            }

            $this->createdDemos++;
            $demo = null;
        }
        $this->createdDemosUniqueUsers++;
    }

    /**
     * @param User|null $user
     * @return MatchTeam
     */
    public static function createTeam(User $user = null) {
        $teamName = null;
        if ($user) {
            $teamName = 'team_' . $user->getUsername();
        } else {
            $teamName = 'team_' . RandomUtil::getRandomString(5);
        }

        $players = [];
        for ($i = 0; $i < 5; $i++) {
            if ($i == 0 && $user) {
                $players[] = new MatchPlayer($user->getId(), $user->getUsername());
            } else {
                $players[] = new MatchPlayer(RandomUtil::getRandomString(), 'testPlayer_' . RandomUtil::getRandomString(3));
            }
        }

        return new MatchTeam($teamName, $players);
    }

    public static function createDemoRound($roundNumber, MatchTeam $winner, MatchTeam $loser) {
        $kills = [];
        $winnerTeamPlayersAlive = $winner->getPlayers();
        $loserTeamPlayersAlive = $loser->getPlayers();

        foreach ($loserTeamPlayersAlive as $victim) {
            $killer = $winnerTeamPlayersAlive[mt_rand(0, count($winnerTeamPlayersAlive) - 1)];
            $kills[] = new RoundEventKill(
                $killer->getSteamId(), $victim->getSteamId(), null, RandomUtil::getRandomBoolWithProbability(0.3)
            );
        }

        return new MatchRound($roundNumber, mt_rand(30, 110), new RoundEvents($kills));
    }

    /**
     * @param User $user
     * @return Verdict
     */
    private function getRandomVerdict(User $user) {
        $verdict = new Verdict();
        $verdict->setUserId($user->getId());
        $verdict->setMap($this->getRandomMap());
        $verdict->setAimAssist($this->getRandomBool());
        $verdict->setVisionAssist($this->getRandomBool());
        $verdict->setOtherAssist($this->getRandomBool());
        $verdict->setGriefing($this->getRandomBool());

        $date = $this->getRandomDate();
        $verdict->setCreationDate($date);
        $verdict->setOverwatchDate($date);

        return $verdict;
    }

    /**
     * @param User $user
     */
    private function createFeedback(User $user) {
        $feedback1 = $this->getRandomFeedback($user);
        $this->feedbackService->save($feedback1);

        $this->createdFeedback++;
        $this->createdFeedbackUniqueUsers++;

        while ($this->getRandomBool()) {
            $anotherFeedback = $this->getRandomFeedback($user);
            $this->feedbackService->save($anotherFeedback);
            $this->createdFeedback++;

            unset($anotherFeedback);
        }
    }

    /**
     * @param User $user
     * @return Feedback
     */
    private function getRandomFeedback(User $user) {
        $feedback = new Feedback();
        $feedback->setCreatedBy($user->getId());
        $feedback->setCreated($this->getRandomDate());

        $feedbackHash = [
            'like'          => $this->getRandomBool(),
            'fixplease'     => $this->getRandomString(mt_rand(200, 2000), true),
            'featureplease' => $this->getRandomString(mt_rand(200, 2000), true),
            'freetext'      => $this->getRandomString(mt_rand(200, 2000), true),
        ];
        $feedback->setFeedback($feedbackHash);

        return $feedback;
    }

    /**
     * @param int $length
     * @param bool $withWhitespaces
     * @return string
     */
    private function getRandomString($length = 10, $withWhitespaces = false) {
        $allowedCharacters = '0123456789abcdefghijklmnopqrstuvwxyz';
        if ($withWhitespaces) {
            $allowedCharacters .= '        ';
        }

        $charactersLength = strlen($allowedCharacters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $allowedCharacters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @return \DateTime
     */
    private function getRandomDate() {
        $from = strtotime('-60 days');
        $to = time();

        $random = new \DateTime();
        $random->setTimestamp(mt_rand($from, $to));
        return $random;
    }

    /**
     * @return bool
     */
    private function getRandomBool() {
        return $this->getRandomBoolWithProbability(0.5);
    }

    /**
     * @param float $probability
     * @return bool
     */
    private function getRandomBoolWithProbability($probability) {
        return mt_rand(1, self::PROBABILITY_LENGTH) <= $probability * self::PROBABILITY_LENGTH;
    }

    /**
     * @return array
     */
    private function getRandomMap() {
        $mapPool = $this->overwatchService->getMapPool();
        $max = count($mapPool) - 1;

        return $mapPool[mt_rand(0, $max)];
    }

    /**
     * @param bool $bool
     * @return string
     */
    private function xIf($bool) {
        if ($bool) {
            return 'x';
        }
        return '-';
    }
}
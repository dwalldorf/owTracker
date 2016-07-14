<?php

namespace AppBundle\Command;

use AppBundle\Util\RandomUtil;
use DemoBundle\Service\DemoService;
use FeedbackBundle\Service\FeedbackService;
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
                    $this->debug(sprintf('creating %d feedback entries for user %s', $this->feedbackAmount, $user->getUsername()));
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

        $this->info(
            sprintf(
                'Finished: 
    %d users 
    %d verdicts of %d unique users
    %d feedback entries of %d unique users
    %d demos of %d unique user %s',
                $this->createdUsers,
                $this->createdVerdicts,
                $this->createdVerdictsUniqueUsers,
                $this->createdFeedback,
                $this->createdFeedbackUniqueUsers,
                $this->createdDemos,
                $this->createdDemosUniqueUsers,
                $powerUsersInfo
            )
        );
    }

    protected function initServices() {
        $this->userService = $this->getService(UserService::ID);
        $this->overwatchService = $this->getService(OverwatchService::ID);
        $this->feedbackService = $this->getService(FeedbackService::ID);
        $this->demoService = $this->getService(DemoService::ID);
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
            $username = 'owtTestUser_' . RandomUtil::getRandomString();
            $email = $username . '@' . RandomUtil::getRandomString(5) . '.com';

            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword(RandomUtil::getRandomString());
            $user->setRegistered(RandomUtil::getRandomDate()->getTimestamp());

            $this->userService->register($user);

            if ($powerUsersToCreate > 0 && $this->createdPowerUsers < $powerUsersToCreate) {
                $amountOfOverwatches = mt_rand(1000, 5000);
            } else if (RandomUtil::getRandomBoolWithProbability(20)) {
                $amountOfOverwatches = mt_rand(40, 100);
            } else {
                $amountOfOverwatches = mt_rand(0, 20);
            }
            $this->createVerdicts($amountOfOverwatches, $user);

            if (RandomUtil::getRandomBoolWithProbability(0.2)) {
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
            $verdict = RandomUtil::getRandomVerdict($user);
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
            $demo = RandomUtil::getRandomDemo($user);
            $this->demoService->save($demo);

            if ($this->verbose) {
                $this->debug(
                    sprintf(
                        'demo: %s VS %s - %d:%d',
                        $demo->getMatchInfo()->getTeam1()->getTeamName(),
                        $demo->getMatchInfo()->getTeam2()->getTeamName(),
                        $demo->getMatchInfo()->getTotalRoundsTeam1(),
                        $demo->getMatchInfo()->getTotalRoundsTeam2()
                    )
                );
            }

            $this->createdDemos++;
            $demo = null;
        }
        $this->createdDemosUniqueUsers++;
    }


    /**
     * @param User $user
     */
    private function createFeedback(User $user) {
        $feedback1 = RandomUtil::getRandomFeedback($user);
        $this->feedbackService->save($feedback1);

        $this->createdFeedback++;
        $this->createdFeedbackUniqueUsers++;

        while (RandomUtil::getRandomBool()) {
            $anotherFeedback = RandomUtil::getRandomFeedback($user);
            $this->feedbackService->save($anotherFeedback);
            $this->createdFeedback++;

            unset($anotherFeedback);
        }
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
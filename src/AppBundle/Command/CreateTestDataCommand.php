<?php

namespace AppBundle\Command;

use AppBundle\Command\BaseContainerAwareCommand;
use OverwatchBundle\Document\Verdict;
use OverwatchBundle\Service\OverwatchService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Document\User;
use UserBundle\Service\UserService;

class CreateTestDataCommand extends BaseContainerAwareCommand {

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var OverwatchService
     */
    private $overwatchService;

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
     * @var int
     */
    private $userAmount;

    /**
     * @var int
     */
    private $createdUsers = 0;

    /**
     * @var int
     */
    private $createdVerdicts = 0;

    const OPT_USER_NAME = 'user';

    const OPT_VERDICT_AMOUNT_NAME = 'verdicts';

    const OPT_VERDICT_AMOUNT_DEFAULT = 20;

    const OPT_USER_AMOUNT_NAME = 'amount';

    const OPT_USER_AMOUNT_DEFAULT = 20;

    protected function configure() {
        $this->setName('owt:createTestData')
            ->addOption(
                self::OPT_USER_NAME,
                'u',
                InputArgument::OPTIONAL,
                'user\'s mongo id or email address'
            )
            ->addOption(
                self::OPT_USER_AMOUNT_NAME,
                'a',
                InputArgument::OPTIONAL,
                'amount of users to generate (20 if not set)'
            )
            ->addOption(
                self::OPT_VERDICT_AMOUNT_NAME,
                'o',
                InputArgument::OPTIONAL,
                'only if user specified - amount of overwatch verdicts to generate (20 if not set)'
            );
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output) {
        $start = microtime(true);

        $this->verbose = $input->getOption('verbose');
        $this->specificUser = $input->getOption(self::OPT_USER_NAME);
        $this->verdictAmount = $input->getOption(self::OPT_VERDICT_AMOUNT_NAME);

        $this->userAmount = $input->getOption(self::OPT_USER_AMOUNT_NAME);

        if ($this->specificUser) {
            if (!$this->verdictAmount) {
                $this->verdictAmount = self::OPT_VERDICT_AMOUNT_DEFAULT;
                $this->info(sprintf('amount of verdicts to generate not set. using default of %d', $this->verdictAmount));
            }

            $user = $this->userService->findById($this->specificUser);
            if (!$user) {
                $user = $this->userService->findByUsernameOrEmail($this->specificUser);
            }

            if (!$user) {
                $this->error(sprintf('user not found.'));
                die(1);
            }

            if ($this->verbose) {
                $this->info(
                    sprintf(
                        'creating %d verdicts for user with email %s and id %s',
                        $this->verdictAmount,
                        $user->getEmail(),
                        $user->getId()
                    )
                );
            }

            $this->createVerdicts($this->verdictAmount, $user);
        } else {
            if (!$this->userAmount) {
                $this->userAmount = self::OPT_USER_AMOUNT_DEFAULT;
                $this->info(sprintf('amount of users to generate not set. using default of %d', $this->userAmount));
            }

            $this->createTestData();
        }

        $output->writeln(
            sprintf(
                'Created %d users and %d verdicts in %f second',
                $this->createdUsers,
                $this->createdVerdicts,
                microtime(true) - $start
            )
        );
    }

    protected function initServices() {
        $this->userService = $this->container->get(UserService::ID);
        $this->overwatchService = $this->container->get(OverwatchService::ID);
    }

    /**
     * @return int
     */
    private function createTestData() {
        for ($i = 0; $i < $this->userAmount; $i++) {
            $user = new User();

            $username = 'owtTestUser_' . $this->getRandomString();
            $email = $username . '@' . $this->getRandomString(5) . '.com';

            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($this->getRandomString());

            $this->userService->register($user);

            $dice = mt_rand(0, 100);

            if ($dice < 25) {
                $amountOfOverwatches = mt_rand(100, 150);
            } else {
                $amountOfOverwatches = mt_rand(0, 40);
            }

            $this->createVerdicts($amountOfOverwatches, $user);

            if ($this->verbose) {
                $this->info(sprintf('created user %s', $user->getEmail()));
                $this->info(sprintf('created %d verdicts', $amountOfOverwatches));
                $this->info();
            }

            $this->createdUsers++;
            unset($user);
        }
    }

    /**
     * @param int $amount
     * @param User $user
     */
    private function createVerdicts($amount, User $user) {
        if ($this->verbose) {
            $this->info();
            $this->info('aim | vision | other | griefing | map');
        }

        for ($i = 0; $i < $amount; $i++) {
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

            $this->overwatchService->save($verdict);

            if ($this->verbose) {
                $this->info(
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
            unset($verdict);
        }
    }

    /**
     * @param int $length
     * @return string
     */
    private function getRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
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
        return rand(0, 1) == 1;
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
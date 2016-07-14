<?php

namespace AppBundle\Util;

use DemoBundle\Document\Demo;
use DemoBundle\Document\MatchInfo;
use DemoBundle\Document\MatchPlayer;
use DemoBundle\Document\MatchRound;
use DemoBundle\Document\MatchTeam;
use DemoBundle\Document\RoundEventKill;
use DemoBundle\Document\RoundEvents;
use FeedbackBundle\Document\Feedback;
use OverwatchBundle\Document\Verdict;
use OverwatchBundle\Service\OverwatchService;
use UserBundle\Document\User;

class RandomUtil {

    const PROBABILITY_LENGTH = 100000;

    /**
     * @param int $length
     * @param bool $withWhitespaces
     * @return string
     */
    public static function getRandomString($length = 10, $withWhitespaces = false) {
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
    public static function getRandomDate() {
        $from = strtotime('-60 days');
        $to = time();

        $random = new \DateTime();
        $random->setTimestamp(mt_rand($from, $to));
        return $random;
    }

    /**
     * @return bool
     */
    public static function getRandomBool() {
        return self::getRandomBoolWithProbability(0.5);
    }

    /**
     * @param float $probability
     * @return bool
     */
    public static function getRandomBoolWithProbability($probability) {
        return mt_rand(1, self::PROBABILITY_LENGTH) <= $probability * self::PROBABILITY_LENGTH;
    }

    /**
     * @param User $user
     * @return Feedback
     */
    public static function getRandomFeedback(User $user) {
        $feedback = new Feedback();
        $feedback->setCreatedBy($user->getId());
        $feedback->setCreated(self::getRandomDate());

        $feedbackHash = [
            'like'          => self::getRandomBool(),
            'fixplease'     => self::getRandomString(mt_rand(200, 2000), true),
            'featureplease' => self::getRandomString(mt_rand(200, 2000), true),
            'freetext'      => self::getRandomString(mt_rand(200, 2000), true),
        ];
        $feedback->setFeedback($feedbackHash);

        return $feedback;
    }

    /**
     * @return array
     */
    public static function getRandomMap() {
        $mapPool = OverwatchService::getMapPool();
        $max = count($mapPool) - 1;

        return $mapPool[mt_rand(0, $max)];
    }

    /**
     * @param User $user
     * @return Verdict
     */
    public static function getRandomVerdict(User $user) {
        $verdict = new Verdict();
        $verdict->setUserId($user->getId());
        $verdict->setMap(self::getRandomMap());
        $verdict->setAimAssist(self::getRandomBool());
        $verdict->setVisionAssist(self::getRandomBool());
        $verdict->setOtherAssist(self::getRandomBool());
        $verdict->setGriefing(self::getRandomBool());

        $date = self::getRandomDate();
        $verdict->setCreationDate($date);
        $verdict->setOverwatchDate($date);

        return $verdict;
    }

    /**
     * @param User $user
     * @return Demo
     */
    public static function getRandomDemo(User $user) {
        $team1Rounds = null;
        $team2Rounds = null;
        $totalRounds = null;
        $rounds = [];

        if (self::getRandomBool()) {
            $team1Rounds = 16;
            $team2Rounds = mt_rand(1, 14);
        } else {
            $team1Rounds = mt_rand(1, 14);
            $team2Rounds = 16;
        }
        $totalRounds = $team1Rounds + $team2Rounds;

        $team1 = self::getRandomTeam($user);
        $team2 = self::getRandomTeam();

        $matchInfo = new MatchInfo(
            self::getRandomMap(),
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
                $rounds[] = self::getRandomDemoRound($roundCounter, $team1, $team2);
                $roundCounter++;
            }
            for ($team2RoundCounter = 0; $team2RoundCounter < $team2Rounds; $team2RoundCounter++) {
                $rounds[] = self::getRandomDemoRound($roundCounter, $team2, $team1);
                $roundCounter++;
            }
        }
        return new Demo(null, $user->getId(), $matchInfo, $rounds);
    }

    /**
     * @param User|null $user
     * @return MatchTeam
     */
    public static function getRandomTeam(User $user = null) {
        $teamName = null;
        if ($user) {
            $teamName = 'team_' . $user->getUsername();
        } else {
            $teamName = 'team_' . self::getRandomString(5);
        }

        $players = [];
        for ($i = 0; $i < 5; $i++) {
            if ($i == 0 && $user) {
                $players[] = new MatchPlayer($user->getId(), $user->getUsername());
            } else {
                $players[] = new MatchPlayer(self::getRandomString(), 'testPlayer_' . self::getRandomString(3));
            }
        }

        return new MatchTeam($teamName, $players);
    }

    /**
     * @param $roundNumber
     * @param MatchTeam $winner
     * @param MatchTeam $loser
     * @return MatchRound
     */
    public static function getRandomDemoRound($roundNumber, MatchTeam $winner, MatchTeam $loser) {
        $kills = [];
        $winnerTeamPlayersAlive = $winner->getPlayers();
        $loserTeamPlayersAlive = $loser->getPlayers();

        /*
         * TODO: more randomness pls
         */
        foreach ($loserTeamPlayersAlive as $victim) {
            $killer = $winnerTeamPlayersAlive[mt_rand(0, count($winnerTeamPlayersAlive) - 1)];
            $kills[] = new RoundEventKill(
                $killer->getSteamId(), $victim->getSteamId(), null, self::getRandomBoolWithProbability(0.3)
            );
        }

        return new MatchRound($roundNumber, mt_rand(30, 110), new RoundEvents($kills));
    }
}
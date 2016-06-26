<?php

namespace AppBundle\Util;

class RandomUtil {

    private static $PROBABILITY_LENGTH = 100000;

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
     * @param int $daysBack
     * @return \DateTime
     */
    public static function getRandomDate($daysBack = 60) {
        $from = strtotime(sprintf('-%d days', $daysBack));
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
        return mt_rand(1, self::$PROBABILITY_LENGTH) <= $probability * self::$PROBABILITY_LENGTH;
    }
}
<?php

namespace AppBundle\Util;

class NumberUtil {

    /**
     * @param float $number
     * @param int $decimals
     * @return string
     */
    public static function thousandsSeparator($number, $decimals = 0) {
        return number_format($number, $decimals, ',', '.');
    }
}
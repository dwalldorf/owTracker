<?php

namespace AppBundle\Util;

class NumberUtil {

    /**
     * @param float $number
     * @param int $decimals
     * @param string $dec_point
     * @param string $thousands_sep
     * @return string
     */
    public static function thousandsSeparator($number, $decimals = 0, $dec_point = ',', $thousands_sep = '.') {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }
}
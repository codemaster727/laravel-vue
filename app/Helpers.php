<?php

/**
 * bladeで使用するヘルパー
 */
if (!function_exists('calcMonth')) {
    function calcMonth($month, $add)
    {
        $result = $month + $add;
        if ($result > 12) {
            $result -= 12;
        } elseif ($result < 1) {
            $result += 12;
        }
        return $result;
    }
}

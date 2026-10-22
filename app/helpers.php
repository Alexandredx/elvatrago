<?php

if (!function_exists('format_price')) {
    function format_price($amount) {
        $currency = session('currency', 'PEN');
        if ($currency === 'USD') {
            return '$' . number_format((float)$amount, 2);
        }
        $soles = (float)$amount * 3.75;
        return 'S/. ' . number_format($soles, 2);
    }
}

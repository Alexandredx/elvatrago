<?php

if (!function_exists('format_price')) {
    function format_price($amount) {
        $currency = session('currency', 'USD');
        if ($currency === 'PEN') {
            $soles = (float)$amount * 3.75;
            return 'S/. ' . number_format($soles, 2);
        }
        return '$' . number_format((float)$amount, 2);
    }
}

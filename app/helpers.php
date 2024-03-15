<?php

use Carbon\Carbon;

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'Y-m-d'){
        if (!$date) { return null; }

        $formattedDate = Carbon::createFromFormat('d/m/Y', $date);

        return $formattedDate ? $formattedDate->format($format) : null;
    }
}
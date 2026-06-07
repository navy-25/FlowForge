<?php

use Carbon\Carbon;

if (! function_exists('diffForHuman')) {
    function diffForHuman($date): string
    {
        if (!$date) {
            return '-';
        }

        return Carbon::parse($date)
            ->locale('id')
            ->diffForHumans();
    }
}

if (! function_exists('formatDateTime')) {
    function formatDateTime($date, string $format = 'd M Y H:i'): string
    {
        if (!$date) {
            return '-';
        }

        return Carbon::parse($date)
            ->locale('id')
            ->translatedFormat($format);
    }
}

if (! function_exists('formatDate')) {
    function formatDate($date, string $format = 'd M Y'): string
    {
        if (!$date) {
            return '-';
        }

        return Carbon::parse($date)
            ->locale('id')
            ->translatedFormat($format);
    }
}

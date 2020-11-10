<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

    function generateUniqueId()
    {
        return STR::random(1) . date('Y') . STR::random(1) . date('mdhi') . STR::random(1);
    }

    function generateLargeUniqueId()
    {
        return STR::random(2) . date('Ym') . STR::random(1) . date('Ymdhis') . STR::random(2);
    }

    function logError($message)
    {
        Log::error($message);
    }

    function logInfo($message)
    {
        Log::info($message);
    }

    function generateSlug($text, $encoding = 'UTF-8')
    {
        return strtolower(str_replace(" ", "-", mb_strtolower($text,  $encoding)));
    }

    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
?>

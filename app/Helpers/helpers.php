<?php


if (!function_exists('translation')) {
    function translationStudySelection($key, $replace = [], $locale = null)
    {
        return __($key, $replace, $locale);
    }
}

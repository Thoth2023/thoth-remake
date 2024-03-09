<?php
if (!function_exists('convert_language_name')) {
    function convert_language_name($language_id)
    {
        if ($language_id == 1) {
            return 'Portuguese';
        } elseif ($language_id == 2) {
            return 'English';
        } elseif ($language_id == 3) {
            return 'Spanish';
        } elseif ($language_id == 4) {
            return 'French';
        } elseif ($language_id == 5) {
            return 'Russian';
        } else {
            return 'Not Found';
        }
    }
}

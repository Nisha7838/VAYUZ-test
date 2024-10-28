<?php 

if (!function_exists('format_last_login')) {
    function format_last_login($dateTime)
    {
        return date('d M Y, H:i:s', strtotime($dateTime));
    }
}

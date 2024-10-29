<?php 

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


if (!function_exists('format_last_login')) {
    function format_last_login($dateTime)
    {
        return date('d M Y, H:i:s', strtotime($dateTime));
    }
}



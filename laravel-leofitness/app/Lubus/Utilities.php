<?php

namespace App\Lubus;

use Carbon\Carbon;
class Utilities {
public static function getGreeting() {
    //$time = date("H");
    $time = Carbon::now()->hour;
    /* If the time is less than 1200 hours, show good morning */
    if ($time < '12') {
        echo 'Good morning';
    } elseif /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
        ($time >= '12' && $time < '17') {
        echo 'Good afternoon';
    } elseif /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
        ($time >= '17' && $time < '22') {
        echo 'Good evening';
    } elseif /* Finally, show good night if the time is greater than or equal to 2200 hours */
        ($time >= '22') {
        echo 'Good night';
    }
}

}



<?php

namespace App\Lubus;

use Carbon\Carbon;
class Utilities {
public static function getGreeting() {
    //$time = date("H");
    $time = Carbon::now()->hour;
    /* If the time is less than 1200 hours, show good morning */
    if ($time < '12') {
        echo 'Buenos dias';
    } elseif /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
        ($time >= '12' && $time < '17') {
        echo 'Buenas tardes';
    } elseif /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
        ($time >= '17' && $time < '22') {
        echo 'Buenas noches';
    } elseif /* Finally, show good night if the time is greater than or equal to 2200 hours */
        ($time >= '22') {
        echo 'Feliz noche';
    }
}

public static function setActiveMenu($uri, $isParent = false)
    {
        $class = ($isParent) ? 'active open' : 'active';

        return \Request::is($uri) ? $class : '';
        //return \Request::is($uri);
    }

    // Get Setting
    public static function getSetting($key)
    {
        $settingValue = Setting::where('key', '=', $key)->pluck('value');

        return $settingValue;
    }

     //get Settings
     public static function getSettings()
     {
         $settings = Setting::all();
         $settings_array = [];
 
         foreach ($settings as $setting) {
             $settings_array[$setting->key] = $setting->value;
         }
 
         return $settings_array;
     }



}



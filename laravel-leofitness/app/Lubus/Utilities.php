<?php

namespace App\Lubus;

use Carbon\Carbon;
use App\Models\Setting;
use BaconQrCode\Encoder\QrCode;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Image\Png;
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

// Set invoice status
public static function setInvoiceStatus($amount_due, $invoice_total)
{
    if ($amount_due == 0) {
        $paymentStatus = Constants::Paid;
    } elseif ($amount_due > 0 && $amount_due < $invoice_total) {
        $paymentStatus = Constants::Partial;
    } elseif ($amount_due == $invoice_total) {
        $paymentStatus = Constants::Unpaid;
    } else {
        $paymentStatus = Constants::Overpaid;
    }

    return $paymentStatus;
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
        $settingValue = Setting::where('key', '=', $key)->pluck('value')->first();

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

      //Get invoice display name type
    public static function getDisplay($display)
    {
        switch ($display) {
        case 'gym_logo':
            return 'Gym Logo';
            break;

        default:
            return 'Gym Name';
            break;
    }
    }

     // Get Numbering mode
     public static function getMode($mode)
     {
         switch ($mode) {
         case '0':
             return 'Manual';
             break;
 
         default:
             return 'Automatic';
             break;
     }
     }

     //Active-Inactive Labels
    public static function getActiveInactive($status)
    {
        switch ($status) {
        case '0':
            return 'label label-danger';
            break;

        default:
            return 'label label-primary';
            break;
    }
    }

        // Member Status
        public static function getStatusValue($status)
        {
            switch ($status) {
            case '0':
                return 'Inactive';
                break;
    
            case '2':
                return 'Archived';
                break;
    
            default:
                return 'Active';
                break;
        }
        }

     // Get Gender
     public static function getGender($gender)
     {
         switch ($gender) {
         case 'm':
             return 'Male';
             break;
 
         case 'f':
             return 'Female';
             break;
     }
    }

    public static function generateQRCode($data)
    {
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $writer->writeFile('Hello World!', 'qrcode.png');
    }

     
}
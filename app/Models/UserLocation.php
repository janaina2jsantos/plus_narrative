<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Notifications\UserLogin;
use App\Events\NotificationSaved;

class UserLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country', 
        'country_code', 
        'region', 
        'region_name', 
        'city', 
        'zip', 
        'timezone', 
        'ip', 
        'user_agent', 
        'first_entry'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function trackUserLocation()
    {
        $user = Auth::user();
        $location = optional($user->location);
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $date = now()->format('M-d-Y H:i');

        // request to API that tracks the user's IP
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://ip-api.com/json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json; charset=utf-8"
            ),
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json(['error' => $error], 500);
        }

        curl_close($curl);
        $data = json_decode($response);

        if ($location->exists()) {
            if (($location->ip != $data->query) || ($location->user_agent != $userAgent)) {
                $locationInfo = ["Date" => $date, "IP" => $data->query, "City" => $data->city, "State" => $data->regionName, "FU" => $data->region, "Country" => $data->country];
                // send out notification email
                $user->notify(new UserLogin("New login", $locationInfo));
            }
        } 
        // if it is user's first entry
        else {
            $this::create([
                'user_id' => $user->id,
                'country' => $data->country,
                'country_code' => $data->countryCode,
                'region' => $data->region,
                'region_name' => $data->regionName,
                'city' => $data->city,
                'zip' => $data->zip,
                'timezone' => $data->timezone,
                'ip' => $data->query,
                'user_agent' => $userAgent,
                'first_entry' => 1
            ]);
        }
    
        $user->increment('login_count');
    }

    public function getEntries()
    {
        return $this->entries;
    }
}


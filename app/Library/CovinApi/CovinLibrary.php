<?php

namespace App\Library\CovinAPi;

// use Carbon\Carbon;
// use DateTime;
// use DateTimeZone;


class CovinLibrary 
{
    const API_URL = 'https://cdn-api.co-vin.in/api/v2/';

	public static function getState() {
        $client = new \GuzzleHttp\Client(
            [
                'headers' => [
                    'User-Agent'   => 'curl/7.65.3',
                ],
            ]
        );
        $request = $client->get(self::API_URL . 'admin/location/states');
        $response = $request->getBody();
        $states = json_decode($response)->states;
        return $states;
    }

    public static function getDistricts($state_id) {
        $client = new \GuzzleHttp\Client();
        $request = $client->get(self::API_URL . 'admin/location/districts/'. $state_id);
        $response = $request->getBody();
        $districts = json_decode($response)->districts;
        return $districts;
    }

    public static function getCentreData($data) {
        $url = self::API_URL .'appointment/sessions/public/calendarByDistrict?district_id='.$data['districtId'].'&date='.$data['date'];
        $client = new \GuzzleHttp\Client();
        $request = $client->get($url);
        $response = $request->getBody();
        $data = json_decode($response)->centers;
        return $data;
    }
}

<?php

namespace App\Helpers;

class Helper
{
  const PROVIDER_OPEN_WEATHER = 'open-weather';

    public static function sendMessage($data = []): bool
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,'https://api.telegram.org/bot6415703228:AAGu0xQ_EWs76bsnORNTwxUDENoXO57sKCA/sendMessage');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_exec($ch);
        return true;
    }

    public static function getWeather($city){

        $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=a3b366f1d7430f2ae8fd2b7fa5c08bb4&units=metric";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response,1);

        if (!array_key_exists('main',$data)){
            echo "Error! City not found!!!!!!!!\n";
            exit();
        }

        return $data['main']['temp'];
    }

}

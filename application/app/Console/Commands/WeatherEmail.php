<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Mail\SendWeatherMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WeatherEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:email {provider} {city} {item*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weather data delivery service!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $provider = $this->argument('provider');
        $city = $this->argument('city');
        $items = $this->argument('item');

        if ($provider == Helper::PROVIDER_OPEN_WEATHER){
            $weather = Helper::getWeather($city);
            $sendWeather = $this->sendEmail($items,$city,$weather);
            if ($sendWeather){
                echo "Success\n";
                return 0;
            }
            echo "Error!\n";
            return 0;
        }


        echo "Error! Provider not found!!!!!!!!\n";
        return 0;
    }



    private function sendEmail($items,$city,$weather): true
    {

        foreach ($items as $item){
            Mail::to($item)->send(new SendWeatherMail([
                'city' => $city,
                'weather' => $weather
            ]));
        }
        return true;
    }


}

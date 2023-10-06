<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use Illuminate\Console\Command;

class WeatherTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:telegram {provider} {city} {item*}';

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
        $chat_ids = $this->argument('item');

        if ($provider == Helper::PROVIDER_OPEN_WEATHER){
            $weather = Helper::getWeather($city);
            $sendWeather = $this->sendWeather($chat_ids,$weather,$city,$provider);
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

    private function sendWeather($chat_ids,$weather,$city,$provider)
    {
        foreach ($chat_ids as $chat_id){
            Helper::sendMessage([
                'chat_id' => $chat_id,
                'text' => $city.': '.$weather.' ⛅️'."\n Provider: ".$provider
            ]);
        }
        return true;
    }


}

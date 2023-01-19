<?php

namespace App\Console\Commands;

use App\Models\Weather;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class WeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert weather data in db';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();

        $response = $client->get('https://api.openweathermap.org/data/2.5/weather?q='.env('COUNTRY').'&appid='.env('API_KEY'));
        $data = json_decode($response->getBody()->getContents());

        Weather::create([
            'country' => $data->name,
            'weather' => $data->weather[0]->main,
            'temp' => $data->main->temp,
            'wind_speed' => $data->wind->speed
        ]);

        return Command::SUCCESS;
    }
}

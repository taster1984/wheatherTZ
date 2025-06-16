<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    //В контруктор отримаэмо через DI необхідні залежності та ключ
    public function __construct(private HttpClientInterface $client, private string $apiKey, private LoggerInterface $logger)
    {
    }

    public function getWeather(string $city): array
    {
        try {
            $response = $this->client->request('GET', 'https://api.weatherapi.com/v1/current.json', [
                'query' => [
                    'key' => $this->apiKey,
                    'q' => $city
                ]
            ]);
            $data = $response->toArray();
            if (isset($data['error'])) {
                return ['error' => true, 'message' => $data['error']['message']];
            }

            $result = [
                'temperature' => $data['current']['temp_c'] ?? null,
                'condition' => $data['current']['condition']['text'] ?? null,
                'humidity' => $data['current']['humidity'] ?? null,
                'wind_speed' => $data['current']['wind_kph'] ?? null,
                'city' => $data['location']['name'] ?? null,
                'country' => $data['location']['country'] ?? null,
                'last_updated' => $data['current']['last_updated'] ?? null,

            ];
            //Формуємо лог строку як в завданні
            $logString = sprintf(
                "Погода в %s: %s°C, %s",
                $result['city'] ?? $city,
                $result['temperature'] ?? 'N/A',
                $result['condition'] ?? 'N/A'
            );
            $this->logger->info($logString);
            return $result;
        } catch (\Throwable $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}

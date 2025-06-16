<?php

namespace App\Tests\Service;

use App\Service\WeatherService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Psr\Log\LoggerInterface;

class WeatherServiceTest extends TestCase
{
    public function testGetWeatherReturnsCorrectData()
    {
        // Мокаємо відповідь від WeatherAPI
        $fakeApiResponse = [
            'current' => [
                'temp_c' => 25,
                'condition' => ['text' => 'Ясно'],
                'humidity' => 33,
                'wind_kph' => 5,
                'last_updated' => '2024-06-16 14:00'
            ],
            'location' => [
                'name' => 'Київ',
                'country' => 'Україна'
            ]
        ];

        // Мокаємо HttpClientInterface
        $httpClient = $this->createMock(HttpClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn($fakeApiResponse);
        $httpClient->method('request')->willReturn($response);

        // Мокаємо LoggerInterface (перевіряємо, що info був викликаний!)
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('info')->with(
            $this->stringContains('Погода в Київ: 25°C, Ясно')
        );

        $service = new WeatherService($httpClient, 'FAKE_KEY', $logger);

        $result = $service->getWeather('Київ');

        $this->assertEquals([
            'temperature' => 25,
            'condition' => 'Ясно',
            'humidity' => 33,
            'wind_speed' => 5,
            'city' => 'Київ',
            'country' => 'Україна',
            'last_updated' => '2024-06-16 14:00'
        ], $result);
    }
}

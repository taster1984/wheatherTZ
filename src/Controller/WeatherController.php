<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WeatherService;

class WeatherController extends AbstractController
{

    /*
     * Цього екшену не було в завданні, він для краси
     */
    #[Route('/weather', name: 'weather_home')]
    public function selectCity(Request $request): Response
    {
        //Список великих міст.
        $cities = [
            'Киев' => 'Kyiv',
            'Лондон' => 'London',
            'Париж' => 'Paris',
            'Нью-Йорк' => 'New York',
            'Токио' => 'Tokyo',
            'Шанхай' => 'Shanghai',
            'Стамбул' => 'Istanbul',
            'Берлин' => 'Berlin',
            'Мадрид' => 'Madrid',
            'Рим' => 'Rome',
            'Барселона' => 'Barcelona',
            'Дели' => 'Delhi',
            'Сеул' => 'Seoul',
            'Пекин' => 'Beijing',
            'Буэнос-Айрес' => 'Buenos Aires',
            'Лос-Анджелес' => 'Los Angeles',
            'Чикаго' => 'Chicago',
            'Сингапур' => 'Singapore'
        ];

        return $this->render('weather_select.html.twig', [
            'cities' => $cities,
        ]);
    }

    #[Route('/weather/{city}', name: 'weather')]
    public function weather(WeatherService $weatherService, string $city): Response
    {
        //Отримуємо погоду з сервісу
        $data = $weatherService->getWeather($city);

        //Передаємо на рендер twig шаблону параметри
        return $this->render('weather.html.twig', [
            'city' => $city,
            'temperature' => $data['temperature'] ?? 'N/A',
            'condition' => $data['condition'] ?? 'N/A',
            'humidity' => $data['humidity'] ?? 'N/A',
            'wind_speed' => $data['wind_speed'] ?? 'N/A',
            'country' => $data['country'] ?? 'N/A',
            'last_updated' => $data['last_updated'] ?? 'N/A',

            'error' => $data['error'] ?? null,
            'message' => $data['message'] ?? null,
        ]);
    }
}

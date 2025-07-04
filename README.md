
# Symfony Weather Mini-App

## Опис

Простий демонстраційний додаток на Symfony (last LTS 6.4.22), який показує поточну погоду для вибраних міст, використовуючи [weatherapi.com](https://www.weatherapi.com/).
Всі запити логуються у файл з використанням Monolog.

---

## Установка

1. **Встановити залежності:**

   ```
   composer install
   ```

2. **Додати ключ погодного API у файл `.env`:**

   ```
   WEATHER_API_KEY=your_weather_api_key
   ```

3. **Запустити сервер:**

   ```
   symfony server:start
   ```

   або

   ```
   php -S 127.0.0.1:8000 -t public
   ```

4. **Відкрити список міст:**

   ```
   http://localhost:8000/weather
   ```

   Там можна вибрати одне з популярних міст.

5. **Переглянути погоду для обраного міста:**

   ```
   http://localhost:8000/weather/Kyiv
   ```

   (де `Kyiv` — будь-яке місто зі списку)

---

## Документація

* **Сервіс погоди:**
  Логіка отримання даних та логування запитів реалізована у `App\Service\WeatherService`.
* **Логування:**
  Кожен запит до API логуються у файл `var/weather_log.txt` через Monolog із форматуванням дати і результату.
* **Стилі:**
  Сторінки стилізовані через `public/css/style.css`. Можна змінювати дизайн під себе.
* **Вибір міста:**
  На сторінці `/weather` доступний список найбільших міст для швидкого вибору.
* **Переклад/локалізація:**
  (Додати за потреби.)

---

## Тестування

* Для сервісу `WeatherService` написано модульний тест, який перевіряє правильність роботи сервісу із підміненою відповіддю від API.
* **Запуск тестів:**

  ```
  php vendor/bin/phpunit
  ```
* Тест знаходиться у `Tests/Service/WeatherServiceTest.php`.
* Тести не вимагають реального ключа і реальних запитів — HTTP-клієнт і логер підміняються на моки.

---

## Додатково

* Потрібно більше міст? Додайте їх у масив у контроллері.
* Можна легко підключити Bootstrap або іншу бібліотеку, змінивши `base.html.twig`.
---

**Питання, ідеї чи баги — створюйте issue або пишіть автору!**


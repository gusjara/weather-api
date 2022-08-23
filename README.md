
# Steps
- IMPORTANT to run this repo you need php 8.0 or superior.
- Clone this repo from gitlab ```git clone https://gitlab.com/gusjara/weather-api.git```
- Create a data base for this project on mysql. Ex: weather_api
- Run ```composer install```
- Copy with ```cp .env.example .env ```
- In .env add your database credentials and WEATHER_STACK_TOKEN= your token of weather stack
- Run ```php artisan key:generate```
- Run ```php artisan migrate``` to create structure database.
- Run ```php artisan serv``
- Enter in your browser on ```http://127.0.0.1:8000``` and you can see the laravel project page.

# Test local
**With postman or browser**
This repo only has a one functional endpoint

Endpoint ```http://127.0.0.1:8000/api/current?query={city}``` Ex: city = 'new york'

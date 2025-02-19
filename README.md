# Weather Alert App

## Prerequisites
Before setting up the application, ensure you have the following installed on your system:

- Docker
- Docker Compose

## Setup Instructions
Follow these steps to set up the project:

```sh
git clone git@github.com:elmirabalasanyan11/weather-alert-app.git
cd weather-alert-app
cp .env.example .env
docker-compose up -d --build
docker-compose exec app bash
composer install
npm install
npm run build
php artisan key:generate
php artisan migrate
php artisan db:seed --class=CitiesSeeder
```

## Accessing the Application
After completing the setup, the application should be accessible at:

[http://localhost:8000](http://localhost:8000)


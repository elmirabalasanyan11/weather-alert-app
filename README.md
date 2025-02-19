Before setting up the application, ensure you have the following installed on your system:

Docker
Docker Compose


Here are steps to set upthe project

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

After completing the setup, the application should be accessible at http://localhost:8000


Application - Find Person

# Steps to Run the application

## Step 1  (Docker Up with Build)

    $ docker-compose up --build
    
    Detached command/ Background Process
    $ docker-compose up -d --build

## Step 2 (copy env file form source sample)

    $ docker-compose run --rm php80-service cp .env.example .env

## Step 3 (composer install)

    $ docker-compose run --rm php80-service composer install

## Step 4 (Permission of Storage DIR)

    $ docker-compose run --rm php80-service chmod -R a+w storage

##  Step 5 ( Migrate  database )

    $ docker-compose run --rm php80-service php artisan migrate

    Or Refresh 
    $ docker-compose run --rm php80-service php artisan migrate:fresh

##  Step 6 (seed data from CSV - it will bit longer time for 100K data )

    $ docker-compose run --rm php80-service php artisan db:seed --class=PersonDataSeeder

##  Step 7 (Browse Site on 8080 port)

    http://localhost:8080/  -> there is a button to naviagte to persons list
    and for persons -> http://localhost:8080/persons

##  Unit Test  ( with active database | with data )

    $ docker-compose run --rm php80-service php artisan test

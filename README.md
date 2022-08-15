Application - Find Person

# Steps to Run the application

## Step 1  (Docker Up with Build)

    $ docker-compose up --build
    
    Detached command/ Background Process

    $ docker-compose up -d

## Step 2 (composer install)

    $ docker-compose run --rm php80-service composer install

##  Step 3 ( Migrate  database )

    $ docker-compose run --rm php80-service php artisan migrate

    Or Refresh 
    $ docker-compose run --rm php80-service php artisan migrate:fresh

##  Step 4 (seed data from CSV)

    $ docker-compose run --rm php80-service php artisan db:seed --class


##  Step 5 (Browse Site on 8080 port)

    http://localhost:8080/  -> there is a button to naviagte to persons list
    and for persons -> http://localhost:8080/persons

##  Unit Test 

    $ docker-compose run --rm php80-service php artisan test

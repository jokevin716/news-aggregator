# Laravel 11 Dockerized Application

This repository contains a Laravel 11 application that is dockerized for easy development and deployment. It uses SQLite as the database and includes a setup for Nginx as the web server.

## Prerequisites

Before you begin, ensure you have the following installed on your machine:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/)

## Project Structure

The project structure should look like this:
/news-aggregator
    ├── Dockerfile 
    ├── docker-compose.yml 
    ├── entrypoint.sh 
    ├── nginx.conf 
    ├── .env 
    └── database 
        └── database.sqlite


## Setup Instructions

1. **Clone the Repository**:

   ```bash
   git clone [https://github.com/jokevin716/news-aggregator.git](https://github.com/jokevin716/news-aggregator.git)
   cd news-aggregator
   ```

2. **Create the SQLite Database**:

Create an empty SQLite database file:

    ```bash
   touch database/database.sqlite
   ```

3. **Configure Environment Variables**:

Update the `.env` file to configure your application. Ensure the database connection is set to SQLite:

    ```bash
   DB_CONNECTION=sqlite
   DB_DATABASE=/var/www/database/database.sqlite
   ```

4. **Build and Start the Containers**:

Run the following command to build the Docker images and start the containers:

    ```bash
   docker-compose up --build -d
   ```

Access the application in your browser and navigate to [http://localhost:8080](http://localhost:8080) to access your Laravel application.

## Running Artisan Commands

1. Run Migrations:

    ```bash
    docker-compose exec app php artisan migrate
    ```

2. Seed the database:

    ```bash
    docker-compose exec app php artisan db:seed
    ```

3. Run scheduled tasks:

    ```bash
    docker-compose exec app php artisan schedule:run
    ```

## Stopping the Application

To stop the containers, run:

    ```bash
    docker-compose down
    ```

## Additional Notes

- The `entrypoint.sh` script runs migrations and seeds the database automatically when the app container starts.
- The `scheduler` service runs the `php artisan schedule:run` command every 5 minute to handle scheduled tasks.

## Troubleshooting

- If you encounter any issues, ensure that Docker and Docker Compose are installed correctly and that your `.env` file is configured properly.
- Check the logs of the containers for any errors:

    ```bash
    docker-compose logs
    ```

## web-servers-monitoring-system

All needed technologies covered with docker containers. So you need only docker.

Steps for run this project in your local computer:

- Clone this project
- Copy .env.example to .env
```shell
cp .env.example .env
```
- You may install the application's dependencies by navigating to the application's directory and executing the following command. This command uses a small Docker container containing PHP and Composer to install the application's dependencies:
```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
- Before starting project, you should ensure that no other web servers or databases are running on your local computer. To start all of the Docker containers defined in your application's docker-compose.yml file, you should execute the up command:
```shell
vendor/bin/sail up -d
```
- Run this command to init database tables:
```shell
vendor/bin/sail artisan migrate
```
- In project directory have file with name ***web-servers-monitoring-system.postman_collection.json***. You can import it to your Postman and check endpoints for CRUD webservers.
- To run queue worker you should run this command:
```shell
vendor/bin/sail artisan queue:work
```
- To run automated worker locally you may use the ***schedule:work*** Artisan command. This command will run in the foreground and invoke the scheduler every minute until you terminate the command:
```shell
vendor/bin/sail artisan schedule:work
```
- Administrators will receive an email when the server becomes unhealthy. To check this, you can open the email interface in your browser, which is available at this address: ***http://localhost:8025/***



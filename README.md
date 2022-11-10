## web-servers-monitoring-system

### Task description:
In this assignment you are requested to develop a system that will enable health monitoring of webservers in the cloud.
A Webserver data structure will include by minimum, the following fields:
- Name
- HTTP URL
(You can add any other field you find useful for the assignment)

#### Core Functionality
1. Ability to add / edit / delete / list webservers
2. Development of automated worker that will monitor the webservers status
    1. Each webserver should be sampled at least 1 time per minute
    2. Webserver success status is determined by two factors: (AND)
        1. Getting HTTP Response Code 2xx
        2. HTTP Response Latency < 60 seconds
    3. Every monitor request should be saved in a dedicated requests table for later use (History)
    4. Server is defined as “Healthy” in case 5 consecutive requests are considered “Success” as defined above
    5. Server is defined as “Unhealthy” in case 3 consecutive requests aren’t considered “Success” as defined above
3. Development of a REST API including the following endpoints:
    1. Create Webserver – Endpoint that will allow creating a new Web Server
    2. Read (Get) Webserver – Should include all basic webserver details, current health status and last 10 requests
objects
    3. Update Webserver – Endpoint that will allow updating Web Server
    4. Delete Webserver – Endpoint that will allow deleting Web Server
    5. Get list of all Web Servers and their current health-status
    6. Get list of a specific webserver requests history

#### Bonus
1. Learn and implement how the system should process non-success (!2xx) HTTP Response Codes, according to the
recommended HTTP Protocol standards (i.e., 3xx, Retry-After, etc.)
2. Send a notification e-mail to list of pre-defined admins once a server becomes unhealthy
3. Design the system that it’ll be extendable to support any potential protocol (i.e., FTP, SSH, etc.)
    1. You can use the following free FTP server for tests: https://dlptest.com/ftp-test/


### Usage

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



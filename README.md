# test-billets

## Description
Test technique pour Billets.ca

## Getting Started

### Dependencies

* Docker (runs on version 28.3.2)
* Docker Compose (runs on version v2.33.1)

### Starting project

In project root, run command 
```console
docker-compose up -d
```
This will download and start the necessary docker applications

### Running the tests

To run the tests, run command

```console
docker-compose run phpunit tests
```

The tests should then run in your terminal

### Stopping the project

```console
docker-compose down
```
This will stop the docker containers for the project, it is important to note that it will also delete the database. A new one will be created on project start.

### Project structure

## Root

This directory contains all the composer, git and docker files to run the project.

It also contains index.php and subscriptioni-view.php which are the 2 pages that can be accessed in the project

### index.php

Available at `https://localhost` or `https://localhost/index.php`

This page shows: 
* a form for adding new users
* a form to add a new subscription (select a duration, a user and a bundle).


### subscriptioni-view.php

Available at `https://localhost/subscriptioni-view`

This page allows the user to cancel or add 1 month to the subscriptions of the selected User.
This page shows: 
* a form for selecting the user
* a list of the subscriptions this user has, with buttons to either canced the subscription or add 1 month to a subscription (which also sets the subscription to active).

## classes

Contains the classes used by the site to function

## database

Contains the initial database once the projects is started.

## tests

Contains the tests for this project.

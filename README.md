tictactoe-symfony-ddd
==============

A Tic Tac Toe Game example built into complete stack solution for symfony DDD development environment with Nginx, PHP-FPM, MySQL, RedisDB, RabbitMQ-Stomp and ELK (ElasticSearch, Logstash and Kibana)  

# Prerequisites

First of all install docker-engine script with this commmand into repository directory:

```bash
$ brew install docker
```

# Installation

First, clone this repository:

```bash
$ https://github.com/gcheliz/tictactoe-symfony-ddd.git
```

Then, run:

```bash
$ docker-compose build
$ docker-compose up -d
```

Access to the PHP Docker Container

```bash
$ ./web.sh
```

Installing Symfony App
----------

Use Composer

	composer install

Create database schema (sf is an alias of php app/console)

	sf doctrine:schema:update --force
    
Execute the tests

    php bin/phpunit -c app/
    
Starting Tic Tac Toe Game
----------

Start the game

    sf tictactoe:game:start
    
    
Copyright
-----------

The command line game is based on command line ANNTicTacToe repo:
    
    https://github.com/PHPGames/FANNTicTacToe
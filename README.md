Symfony Demo DDD, CQRS + ES
===========================

This is a small demo application of a Symfony Application with DDD, CQRS and ES

Get started
-----------

Clone the project:

```sh
$ https://github.com/ajordi/symfony-demo-ddd-cqrs-es
$ cd symfony-demo-ddd-cqrs-es
```

Spin up containers
------------------

```bash
$ docker-compose up -d
```
* Wait until php service is ready to handle connections. Check using `docker-compose logs php` 

Setup The Queue
---------------

```sh
$ docker-compose exec -T php /usr/local/bin/php -d xdebug.remote_enable=0 -d xdebug.profiler_enable=0 -d xdebug.default_enable=0 bin/console queue:setup
```

Start The Consumer
-----------------------
```sh
$ docker-compose exec -T php /usr/local/bin/php -d xdebug.remote_enable=0 -d xdebug.profiler_enable=0 -d xdebug.default_enable=0 bin/console consumer:start notify_validation_on_user_registered
```


Create The Event
----------------

* Must be ran in another terminal tab since consumer is not detached (previous command)

```sh
$ docker-compose exec -T php /usr/local/bin/php -d xdebug.remote_enable=0 -d xdebug.profiler_enable=0 -d xdebug.default_enable=0 bin/console user:create test@test.test
```

Check The Event Was Successfully Processed
------------------------------------------

browser to `http://localhost:8025`

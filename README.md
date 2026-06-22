# Udemy task list
This is a learning project where I follow the instructions of [Symfony & PHP Mastery: Build a Social Web App](https://www.udemy.com/course/symfony-framework-hands-on)

This project make use of:
- PHP: 8.4
- composer
- Symfony: 7.4
- Mysql
- Docker

## Commands

**Start project**
```
docker compose up -d
```

**Install packages**
```
composer install
```

**Create controller**
```
docker exec symfony_app bin/console make:controller {{controller name}}
```

**Create entity**
Note: it's better to run this directly inside the container for the generation process.
```
docker exec symfony_app bin/console make:entity {{name}}
```

**Create new migration**
```
docker exec symfony_app bin/console make:migration
```

**Run Migration**
```
docker exec symfony_app bin/console doctrine:migrations:migrate
```

## Xdebug
In order to enable xdebug, install the xdebug plugin and add the following launch.json.
```
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html": "${workspaceFolder}"
            },
            "log": true,
            "hostname": "0.0.0.0"
        }
    ]
}
```


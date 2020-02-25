## HulaHop

### Requirements

- PHP >= 7.4
- [composer](https://getcomposer.org/)
- [yarn](https://classic.yarnpkg.com/en/docs/install/#mac-stable)


### How to use it ?

To launch the project for dev purpose, you have to launch these commands : 

- Launch PHP server :
```
composer i
symfony serve
```

- Launch yarn server (front) : 
```
yarn
yarn run encore dev --watch
```

- (**only once**) Create database :
```
php bin/console doctrine:create:database
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load //To populate database with 20 games and 1 category
``` 

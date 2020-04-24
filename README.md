## HulaHop

HulaHop is a website dedicated to board games. It represents a fictitious company that allows you to borrow board games 
and receive them directly at home. The user returns the game at the end of the borrowing period. He can also find 
players near his home on a card and add them as friends to play board games.

#### Why *"HulaHop"* ?

*Hula* is the hawaian term for *play*. So we made a link between playing game and the famous toy *HulaHoop*.

### Requirements

- PHP >= 7.4
- [composer](https://getcomposer.org/)
- [yarn](https://classic.yarnpkg.com/en/docs/install/#mac-stable)


### How to use it ?

To launch the project for dev purpose, you have to launch these commands : 

#### With Docker

```
docker-compose up
```

#### Without Docker

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

### Photon API

This project use [the Photon API](https://photon.komoot.de/) to transform postal address to geocoordinates. The API is free and doesn't require any key.

### Board Games API

This project use [the Board Game API](https://www.boardgameatlas.com/api/docs/) to get games list with prices. This API require to create a free account and an application to get a CLIENT_ID.
You need to set the `BOARD_GAMES_CLIENT_ID` env var with.
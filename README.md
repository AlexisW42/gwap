# GWAP

Welcome to GWAP<br />

A Game With A Purpose<br />

The game consists of describing with a single word the characteristics of the image presented.
Some rules of this game are:<br />
1. To start playing you need 3 players in the room.
2. The game lasts 3 minutes.
3. Each image will last 1 minute to describe it.
4. The word you enter must be greater than or equal to 4 letters.
5. The player with the highest score will be the winner.

## Installation
To install GWAP you need install the necessary dependencies

To install dependencies PHP of Laravel you use [composer](https://getcomposer.org/):
```bash
composer install
```
Some dependencies are installed from npm of node:
```bash
npm install
```
You need make a copy of .env.example, rename as .env and generate the key:
```bash
php artisan generate:key
```
Generate the database:
```bash
php artisan migrate
```
Run the seeder, this will give you a user admin with the username "adminUser" and 3 players users:
"playerUser", "martinPlayer" and "alexPlayer", they have "password" as password:
```bash
composer dump-autoload
php artisan db:seed
```
You must generate the symlinks used for the storage of images
```bash
php artisan storage:link
```

## Running
You need to have 2 servers running, therefore, you need 2 consoles:</br>
one with:
```bash
php artisan serve
```
and the other with:
```bash
npm run dev 
```

# AD//MIN//CRAFT
## A php based minecraft server control backend

## Requirements:
 - PHP 8.2+
 - Composer 2.7.1+

## Installation:
Run:
```sh
cp .env.example .env && composer install && php artisan migrate:fresh && php artisan key:generate
```

Create an account with
```sh
php artisan register-user
```

Login, go to Settings Put in the MCLocation the absolute path for your minecraft server.
To validate your setting for the path, open the Filemanager, you should see your minecraft server folder opened up there.

To use the Console Input, You need to setup RCON, but make sure you keep the ports for RCON closed to the internet, due to safety risks RCON has.


## License

The Laravel framework: MIT license

This Project:  MPL-2.0 license

ACE (Texteditor):  BSD license
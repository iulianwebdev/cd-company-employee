# Steps to setup the app

After cloning the git repo with 
```git clone [repo] .```

### Installation

The app uses Laravel 5.7 so it needs php 7.1 to run

Install the dependencies and devDependencies and start the server.

```sh
$ composer install
$ composer dumpautoload -o
$ php artisan config:cache
$ php artisan route:cache
```
this step should also create a symlink for the ```storage/app/public >> public/storage``` folder
```sh
$ npm install -d
$ npm run dev
```

create an image in the storage/app/public folder and make sure the permissions are set on the storage folder (recursively)
```$
mkdir storage/app/public/images
chomd 775 -R /storage
```
and create an .env file from the .env.example and fill in DB details
```$
$ cp .env.example .env
```

Now we're ready to run the migrations. (With an optional --seed flag to seed some dummy data)
```$
$ php artisan migrate --seed
```
or even 
```$
$ php artisan migrate:refresh --seed
```

Also check that the app key has been generated in your .env or generate it via artisan
```$
$ php artisan key:generate --show
```
(if there is existing data this command will erase both data and structure)

At this point you should be able to run the tests and see the login page


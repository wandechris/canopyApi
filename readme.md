## Canopy API

Canopy API is a web application built using the Laravel framework to introduce students of Bells University into web api development. Laravel was chosen because of the relative ease of setup and the reduced cognitive dependency needed to have a fully functional service.

Prerequisites
-------------

- [Mysql or Postgresql](https://www.mysql.com/ or http://www.postgresql.org/)
- [PHP 5.4+](http://php.net/)
- Command Line Tools
 - <img src="http://deluge-torrent.org/images/apple-logo.gif" height="17">&nbsp;**Mac OS X:** [Xcode](https://itunes.apple.com/us/app/xcode/id497799835?mt=12) (or **OS X 10.9+**: `xcode-select --install`)
 - <img src="http://dc942d419843af05523b-ff74ae13537a01be6cfec5927837dcfe.r14.cf1.rackcdn.com/wp-content/uploads/windows-8-50x50.jpg" height="17">&nbsp;**Windows:** [Visual Studio](https://www.visualstudio.com/products/visual-studio-community-vs)
 - <img src="https://lh5.googleusercontent.com/-2YS1ceHWyys/AAAAAAAAAAI/AAAAAAAAAAc/0LCb_tsTvmU/s46-c-k/photo.jpg" height="17">&nbsp;**Ubuntu** / <img src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Logo_Linux_Mint.png" height="17">&nbsp;**Linux Mint:** `sudo apt-get install build-essential`
 - <img src="http://i1-news.softpedia-static.com/images/extra/LINUX/small/slw218news1.png" height="17">&nbsp;**Fedora**: `sudo dnf groupinstall "Development Tools"`
 - <img src="https://en.opensuse.org/images/b/be/Logo-geeko_head.png" height="17">&nbsp;**OpenSUSE:** `sudo zypper install --type pattern devel_basis`

Getting Started
---------------

#### Via Cloning The Repository:

```bash
# Get the project
git clone https://github.com/wandechris/canopyapi.git 

# Change directory
cd canopyapi

# Rename env.example to .env and fill in all the keys and secrets and also generate a secure key for the app using `php artisan key:generate`

# Install Composer dependencies
composer install

# Run your migrations
php artisan migrate

php artisan serve
```

## Hosting on Heroku
I leave this for @wandechris to complete

## Laravel's Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

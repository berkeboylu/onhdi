## About onHDI

onHDI is a web application that works for making diagrams of our inhouse app system.

This repo is totally free — PRs and issues welcome!

### Uses

 - [Vis.js](https://visjs.org/) 
 - [EasyUI](https://www.jeasyui.com/) 
 - [Laravel](https://laravel.com/) 
 - [MySQL](https://www.mysql.com/) 

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git clone git@github.com:berkeboylu/onhdi.git

Switch to the repo folder

    cd onhdi

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

**TL;DR command list**

    git clone git@github.com:gothinkster/laravel-realworld-example-app.git
    cd laravel-realworld-example-app
    composer install
    cp .env.example .env



    

The onHDI is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). 
"made with love" 

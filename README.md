# Sensor
The sensor project is a fully automated card reader combined to a PHP API build to restrict user access in real industry environment.

## Features
* **Secure access management**
* **Easy monitoring through dashboard**
* **Handle HTTPS secure requests**
* **Restricted access from X hour to Y hour**
* **Database UID encryption handled in code**
* **Automatic logs creation in Database**

## Prerequisites
To use the sensor, here is the required things :
* ESP 32 ////////////// TO CHANGE
* requests ////////////// TO CHANGE
* psycopg2-binary ////////////// TO CHANGE
* watchdog ////////////// TO CHANGE

## Installation

Clone this repository to your local machine.

Deploy the C script on your ESP IDE, flash it //////////////// TO CHANGE

Move **all** the PHP files inside of your web server **root** directory (ex: /var/www/html).

Edit the `config.php` file with your DB credential.

Change the request URL inside the **C script**, have to be accorded with your **local/VPS** web server address,

Now the setup is **fully completed**.

## Usage
**Sensor** can be used to easily **restict acces to a physical area**, all security features are **enabled** and **natively active**, all-in-one acccess management tool fully **open-source** and free.

## Author
* [@natekali](https://github.com/natekali)
* [@Oliancem](https://github.com/Oliancem)
* [@Piairlika](https://github.com/Piairlika)
* [@amxUK](https://github.com/amxUK)

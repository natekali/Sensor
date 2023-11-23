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

### ARDUINO CODE

```Board
  Boards manager --> esp32
```

```Library
  Library manager --> MFRC22
```


First thing you need to do is to include everything for use the librairies.


```include
  #include <SPI.h>
  #include <MFRC522.h>
  #include "WiFi.h"
  #include "HTTPClient.h" 
```

After you will create a code for connecting your **ESP32-C3** in internet or use mine 

Next steps is to create the code to read a **RFID** or **NFC** tag with your **ESP32-C3**. You will use some :

```like
  (rfid.PICC_IsNewCardPresent())
  sprintf(uidString, "%02X%02X%02X%02X", 
              rfid.uid.uidByte[0], rfid.uid.uidByte[1], rfid.uid.uidByte[2],
              rfid.uid.uidByte[3]);
```

### PHP CODE

```Web server
  Used here --> Apache 2
```

```Database
  Used here --> PostgreSQL
```

## Installation

Clone this repository to your local machine.

Deploy the Arduino script on your Arduino IDE or select your board and run it

Move **all** the PHP files inside of your web server **root** directory (ex: /var/www/html).

Edit the `config.php` file with your DB credential.

Change the request URL inside the **C script**, have to be accorded with your **local/VPS** web server address,

Now the setup is **fully completed**.

## Files details
- **index.php** : Endpoint used by the card reader when requesting API, main file
- **dashboard.php** : Dashboard web to easily add or delete user
- **deletion.php** : PHP script used to delete user
- **creation.php** : PHP script used to create user
- **config.php** : DB credentials config
- **ARDUINO** :  //////// TO CHANGE

## Portfolio

### Dashboard
<img width="296" alt="Capture d’écran 2023-11-23 à 09 45 19" src="https://github.com/natekali/sensor/assets/117448792/bc2866b6-3ed5-432e-86b0-e5dca5f56d77">

### Logs
<img width="901" alt="Capture d’écran 2023-11-23 à 09 46 32" src="https://github.com/natekali/sensor/assets/117448792/3276ae83-5546-49a3-8f5b-05b169bd847e">

### Allowed User
<img width="901" alt="Capture d’écran 2023-11-23 à 09 48 08" src="https://github.com/natekali/sensor/assets/117448792/c1717506-629b-4c2f-8874-4c15040b3fd6">

## Author
* [@natekali](https://github.com/natekali)
* [@Oliancem](https://github.com/Oliancem)
* [@Piairlika](https://github.com/Piairlika)
* [@amxUK](https://github.com/amxUK)

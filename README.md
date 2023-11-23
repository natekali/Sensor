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

Next steps is to create the code to read a **RFID** or **NFC** tag with your **ESP32-C3**.

Me i have choose to read my users with a **PHP API** so you will need to connect the **API** with your **ESP32-C3**. You can obviously use something else like a Raspberry pi or everything else.
For this i have :

-Initialize with http.

-Checking for the presence of a new RFID card: The code checks if a new RFID card is present using the rfid.PICC_IsNewCardPresent() function.

-Reading RFID card data: If a new card is present, the card data is read with rfid.PICC_ReadCardSerial().

-Identification of the card type: The type of RFID card is determined using rfid.PICC_GetType(rfid.uid.sak), and the result is displayed on the serial port.

-Displaying the RFID card UID: The UID (Unique Identifier) of the card is converted to a hexadecimal string and displayed on the serial port.

-Construction of the URL: A URL is constructed by appending the UID to a base address, forming an HTTP request.

-Initialization of the HTTP connection: The HTTPClient object is configured with the constructed URL using http.begin(url).

-Sending an HTTP GET request: An HTTP GET request is made using http.GET(). The code then checks the server response.

-Processing the server response: If the request is successful (HTTP code > 0), the server response is displayed on the serial port. Otherwise, a failure message is displayed.

-Closing the HTTP connection: The HTTP connection is closed with http.end().

-Deactivating the RFID card: The functions rfid.PICC_HaltA() and rfid.PCD_StopCrypto1() are called to deactivate the RFID card.

### PHP CODE

```Web server
  Used here --> Apache 2
```

```Database
  Used here --> PostgreSQL
```

## Installation

Clone this repository to your local machine.

Deploy the **Arduino** script on your **Arduino IDE** then select your board and run it.

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
- **schema_hardW1.png** : First schema of hardware configuration 
- **schema_hardW2.png** :  Second schema of hardware configuration

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

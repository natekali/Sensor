#include <SPI.h>
#include <MFRC522.h>
#include "WiFi.h"
#include "HTTPClient.h"

#define SSID    "dLonelyPrince"
#define PASSWD  "prince44"

#define SS_PIN  4
#define RST_PIN 27 

#define RED_LED_PIN  3
#define GREEN_LED_PIN 2

MFRC522 rfid(SS_PIN, RST_PIN);

void setup() {
  Serial.begin(115200);
  SPI.begin();
  rfid.PCD_Init();

  pinMode(RED_LED_PIN, OUTPUT);
  pinMode(GREEN_LED_PIN, OUTPUT);

  digitalWrite(RED_LED_PIN, HIGH); 

  WiFi.begin(SSID, PASSWD);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");


  Serial.println("Tap an RFID/NFC tag on the RFID-RC522 reader : ");
}

void loop() {
  HTTPClient http;

  if (rfid.PICC_IsNewCardPresent()) { 
    if (rfid.PICC_ReadCardSerial()) { 
      MFRC522::PICC_Type piccType = rfid.PICC_GetType(rfid.uid.sak);
      Serial.print("RFID/NFC Tag Type: ");
      Serial.println(rfid.PICC_GetTypeName(piccType));

      Serial.print("UID: ");
      char uidString[25];  

      // Create a String that contains "AABBCCFF"
      sprintf(uidString, "%02X%02X%02X%02X", 
              rfid.uid.uidByte[0], rfid.uid.uidByte[1], rfid.uid.uidByte[2],
              rfid.uid.uidByte[3]);
      
      Serial.println(uidString);

      String url = "https://134.209.84.201/index.php?uid=" + String(uidString);

      Serial.println("Constructed URL: " + url);

      http.begin(url);  

      int httpCode = http.GET();  

      if (httpCode > 0) {
        String payload = http.getString();  
        Serial.println("Server response: " + payload);

        // The API returns "ACCESS GRANTED" or "ACCESS DENIED"
        if (payload.indexOf("ACCESS GRANTED") != -1) {
          digitalWrite(GREEN_LED_PIN, HIGH);  
          digitalWrite(RED_LED_PIN, LOW);    
        } else {
          digitalWrite(RED_LED_PIN, HIGH);   
          digitalWrite(GREEN_LED_PIN, LOW);  
        }
      } else {
        Serial.println("HTTP request failed");

        digitalWrite(RED_LED_PIN, LOW);
        delay(100);  
        digitalWrite(RED_LED_PIN, HIGH);  
      }

      http.end();  

      rfid.PICC_HaltA(); 
      rfid.PCD_StopCrypto1(); 
    }
  }
}

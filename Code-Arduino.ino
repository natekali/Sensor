#include <SPI.h>
#include <MFRC522.h>
#include "WiFi.h"
#include "HTTPClient.h"

#define SSID    "GAMINGCAMPUS_ELEVES"
#define PASSWD  "Gam1nG69007"

#define SS_PIN  3
#define RST_PIN 27 

MFRC522 rfid(SS_PIN, RST_PIN);

void setup() {
  Serial.begin(115200);
  SPI.begin();
  rfid.PCD_Init(); 
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
      } else {
        Serial.println("HTTP request failed");
      }

      http.end();  

      rfid.PICC_HaltA(); 
      rfid.PCD_StopCrypto1(); 
    }
  }
} 

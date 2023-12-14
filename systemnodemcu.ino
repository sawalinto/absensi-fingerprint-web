#include <LiquidCrystal_I2C.h>
#include <stdlib.h>
#include <Wire.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <SPI.h>

#include <stdio.h>
#include <iostream>
#include <cmath>
using namespace std;
//LiquidCrystal_I2C lcd(0X3F, 16, 2);
LiquidCrystal_I2C lcd(0X27, 16, 2);

#include <Adafruit_Fingerprint.h>
#if (defined(__AVR__) || defined(ESP8266)) && !defined(__AVR_ATmega2560__)
SoftwareSerial mySerial(0, 2);
#else
#define mySerial Serial1
#endif
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

const char* ssid[] = {"rfid", "www.hadiryaa.com"} ;
const char* pass[] = {"12345566", "222222223"};
const int   ssid_count = sizeof(ssid) / sizeof(ssid[0]); // number of known networks
const char* host = "192.168.43.41";

WiFiClient client;

//String id;
String data;
uint8_t id, acak;
int nbVisibleNetworks;
int buttonState = 16, angka = 0;
int spek = 15;

int i, n, jari = 0;


void setup() {
  boolean wifiFound = false;
  Serial.begin(9600);
  SPI.begin();
  pinMode(spek, OUTPUT);

  lcd.init();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("DEVICE OK");
  WiFi.mode(WIFI_STA);
  WiFi.disconnect();
  delay(100);
  Serial.println("Setup done");

  nbVisibleNetworks = WiFi.scanNetworks();
  Serial.println("scan done");
  if (nbVisibleNetworks == 0) {
    Serial.println(F("no ntwrk found"));
    while (true); // no need to go further, hang in there, will auto launch the Soft WDT reset
  }
  for (i = 0; i < nbVisibleNetworks; ++i) {
    Serial.println(WiFi.SSID(i)); // Print current SSID
    for (n = 0; n < ssid_count; n++) { // walk through the list of known SSID and check for a match
      if (strcmp(ssid[n], WiFi.SSID(i).c_str())) {
        Serial.print(F("\tNot matching "));
        Serial.println(ssid[n]);
      } else { // we got a match
        wifiFound = true;
        break; // n is the network index we found
      }
    } // end for each known wifi SSID
    if (wifiFound) break; // break from the "for each visible network" loop
  } // end for each visible network
  WiFi.begin(ssid[n], pass[n]);
  while ((!(WiFi.status() == WL_CONNECTED))) {
    Serial.print(".");
    lcd.print("Menghubungkan ...");
    delay(300);
    lcd.clear();
  }
  if (WiFi.status() == WL_CONNECTED)
  {
    Serial.println("Wifi Terhubung");
    delay(500);
    digitalWrite(spek, HIGH);
    delay(500);
    digitalWrite(spek, LOW);
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("WIFI CONNECT");
    lcd.setCursor(0, 1);
    lcd.print("Loading ....");
    delay(1000);
    lcd.clear();
  }
  //==================Finger====================
  while (!Serial);  // For Yun/Leo/Micro/Zero/...
  delay(100);
  Serial.println("\n\nAdafruit finger detect test");

  // set the data rate for the sensor serial port
  finger.begin(57600);
  delay(5);
  if (finger.verifyPassword()) {
    Serial.println("Found fingerprint sensor!");
  } else {
    Serial.println("Did not find fingerprint sensor :(");
    while (1) {
      delay(1);
    }
  }

  Serial.println(F("Reading sensor parameters"));
  finger.getParameters();
  Serial.print(F("Status: 0x")); Serial.println(finger.status_reg, HEX);
  Serial.print(F("Sys ID: 0x")); Serial.println(finger.system_id, HEX);
  Serial.print(F("Capacity: ")); Serial.println(finger.capacity);
  Serial.print(F("Security level: ")); Serial.println(finger.security_level);
  Serial.print(F("Device address: ")); Serial.println(finger.device_addr, HEX);
  Serial.print(F("Packet len: ")); Serial.println(finger.packet_len);
  Serial.print(F("Baud rate: ")); Serial.println(finger.baud_rate);

  finger.getTemplateCount();

  if (finger.templateCount == 0) {
    Serial.print("Sensor doesn't contain any fingerprint data. Please run the 'enroll' example.");
  }
  else {
    Serial.println("Waiting for valid finger...");
    Serial.print("Sensor contains "); Serial.print(finger.templateCount); Serial.println(" templates");
  }
}


void loop() {


  buttonState = digitalRead(16);
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Finger Print");
//  lcd.setCursor(0, 1);
//  lcd.print("");
  //  ---Delete---
  koneksi_database();
  String Unlink;
  HTTPClient http;
  Unlink = "http://" + String(host) + ":8080" + "/tele/config/delete.php";
  http.begin(client, Unlink);
  http.GET();
  String hapus = http.getString();

  Serial.print("ID : ");
  Serial.println(hapus);


  int a = hapus.toInt();
  if (a > 0 )
  {
    Serial.print("Deleting ID #");
    Serial.println(hapus);

    deleteFingerprint(a);

  }
  delay(500);
  http.end();

  // ===========Register
  if (buttonState == HIGH)
  {
    acak = 127;
    angka = rand() % acak;
    Serial.print("Enrolling ID #");
    Serial.println(angka);
    if (angka > 0 )
    {
      while (! getFingerprintEnroll());
    }
  }


  //  =====Finger Print
  finger.fingerID = 0;
  getFingerprintID();
  jari =  finger.fingerID;
  if (jari > 0)
  {
    koneksi_database();
    String Link;
    HTTPClient http;
    Link = "http://" + String(host) + ":8080" + "/tele/config/sensor.php?idfinger=" + String(jari);
    http.begin(client, Link);
    http.GET();
    String responWeb = http.getString();
    digitalWrite(spek, HIGH);
    delay(500);
    digitalWrite(spek, LOW);
    Serial.println(responWeb);
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Terimah Kasih");
    lcd.setCursor(0, 1);
    lcd.print(responWeb);
    delay(500);
    lcd.clear();
    
    delay(2000);
    http.end();
  }
  jari = 0;

}


//==========Finger ==============
uint8_t getFingerprintID() {
  uint8_t p = finger.getImage();
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image taken");
      break;
    case FINGERPRINT_NOFINGER:
      Serial.println("No finger detected");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_IMAGEFAIL:
      Serial.println("Imaging error");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  // OK success!

  p = finger.image2Tz();
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  // OK converted!
  p = finger.fingerSearch();
  if (p == FINGERPRINT_OK) {
    Serial.println("Found a print match!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_NOTFOUND) {
    Serial.println("Did not find a match");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }
  return finger.fingerID;
  // found a match!
  Serial.print("Found ID #"); Serial.print(finger.fingerID);
  Serial.print(" with confidence of "); Serial.println(finger.confidence);



}
//====END FINGER===============

//===========Enroll Finger=================
uint8_t getFingerprintEnroll() {

  int p = -1;
  Serial.print("Waiting for valid finger to enroll as #"); Serial.println(angka);
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image taken");
        break;
      case FINGERPRINT_NOFINGER:
        Serial.println(".");
        break;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        break;
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Imaging error");
        break;
      default:
        Serial.println("Unknown error");
        break;
    }
  }

  // OK success!

  p = finger.image2Tz(1);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  Serial.println("Remove finger");
  delay(2000);
  p = 0;
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
  }
  Serial.print("ID "); Serial.println(angka);
  p = -1;
  Serial.println("Place same finger again");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image taken");
        break;
      case FINGERPRINT_NOFINGER:
        Serial.print(".");
        break;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        break;
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Imaging error");
        break;
      default:
        Serial.println("Unknown error");
        break;
    }
  }

  // OK success!

  p = finger.image2Tz(2);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  // OK converted!
  Serial.print("Creating model for #");  Serial.println(angka);

  p = finger.createModel();
  if (p == FINGERPRINT_OK) {
    Serial.println("Prints matched!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_ENROLLMISMATCH) {
    Serial.println("Fingerprints did not match");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  Serial.print("ID "); Serial.println(angka);
  p = finger.storeModel(angka);
  if (p == FINGERPRINT_OK) {
    Serial.println("Stored!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    Serial.println("Could not store in that location");
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    Serial.println("Error writing to flash");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  return true;
}

//============DELETE FINGER================


uint8_t deleteFingerprint(int a) {
  uint8_t p = -1;

  p = finger.deleteModel(a);

  if (p == FINGERPRINT_OK) {
    Serial.println("Deleted!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
  } else if (p == FINGERPRINT_BADLOCATION) {
    Serial.println("Could not delete in that location");
  } else if (p == FINGERPRINT_FLASHERR) {
    Serial.println("Error writing to flash");
  } else {
    Serial.print("Unknown error: 0x"); Serial.println(p, HEX);
  }

  return p;
}




void koneksi_database()
{
  if (!client.connect(host, 8080)) {
    Serial.println("Gagal Konek");
    return;
  }
  else {
    Serial.println("Berhasil Konek");
    return;
  }
}

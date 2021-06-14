#include <Wire.h>
#include <SPI.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>

#define BME_SCK 13
#define BME_MISO 12
#define BME_MOSI 11
#define BME_CS 10

#define SEALEVELPRESSURE_HPA (1013.25)
Adafruit_BME280 bme(BME_CS); 

const int lightSensor = A1;
int lightVal = 0;
 
int chk;
float hum;  
float temp;
char incomingData[30];
int serialCharCount = 0;

void setup() {
  Serial.begin(115200);
  Serial.println("READY");
  unsigned status;
  status = bme.begin();
  if (!status) {
        Serial.println("Could not find a valid BME280 sensor, check wiring, address, sensor ID!");
        Serial.print("SensorID was: 0x"); Serial.println(bme.sensorID(),16);
        Serial.print("        ID of 0xFF probably means a bad address, a BMP 180 or BMP 085\n");
        Serial.print("   ID of 0x56-0x58 represents a BMP 280,\n");
        Serial.print("        ID of 0x60 represents a BME 280.\n");
        Serial.print("        ID of 0x61 represents a BME 680.\n");
        while (1) delay(10);
    }
    
}

void loop()
{

  while (Serial.available() > 0) {

    char character = Serial.read();
    if (character != '\n') {
      incomingData[serialCharCount] = character;
      serialCharCount++;
    }
    String test = String(incomingData);
    
    delay(100);
  
    if (test == "TEMP") {
      temp = bme.readTemperature();
      Serial.println(String(temp));
      clearChar();  
    }
    if (test == "HUMI") {
      hum = bme.readHumidity()
      Serial.println(String(hum));
      clearChar();  
    }
    if (test == "PRESS"){
      press = (bme.readPressure() / 100.0F);
      Serial.println(String(press);
      clearChar();
    }
    if (test == "LIGHT") {
      Serial.println(checkLight());
      clearChar();  
    }
  }
}

String checkLight() {
  lightVal = map(analogRead(lightSensor), 100, 1000, 0, 100);
  if (lightVal > 100) {
    lightVal = 100;
  }
  if (lightVal < 0) {
    lightVal = 0;
  }
  return String(lightVal);
}
void clearChar(){
  serialCharCount = 0;
      for ( int i = 0; i < sizeof(incomingData);  ++i ){
        incomingData[i] = (char)0;
      }
}

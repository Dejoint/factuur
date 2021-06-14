#include <dht.h>

dht DHT;
const int lightSensor = A1;
int lightVal = 0;
#define DHT11_PIN A0
String temp = "";

String task = "";
String incomingByte = "";
void setup(){
  
  Serial.begin(115200);
  Serial.print("READY");
  Serial.print("\n");
}

void loop(){
  int chk = DHT.read11(DHT11_PIN);
lightVal = map(analogRead(lightSensor),100,1000,0,100);
if(lightVal < 100){
  lightVal =100;
}
if(lightVal >0){
  lightVal = 0;
}
    
    while(Serial.available() > 0) {
      char character = Serial.read()
    }
    
    // read the incoming byte:
    task = Serial.readString();
   
    if(task != "-1"){
      
      if(task == "TEMP\n"){
        temp = String(DHT.temperature);
        Serial.println(temp);
     
      }
      else if(task == "HUMI\n"){
        Serial.println(DHT.humidity);
        
      }
      else if(task == "LIGHT\n"){
        Serial.println(lightVal);
      }
      else{
        task = "";
      }
      task = "";
    }

}

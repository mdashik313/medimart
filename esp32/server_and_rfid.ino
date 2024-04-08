//Include libraries
#include <HTTPClient.h>               //Download: https://electronoobs.com/eng_arduino_httpclient.php
#include <WiFi.h>                     //Download: https://electronoobs.com/eng_arduino_wifi.php

//rfid
#include <SPI.h>
#include <MFRC522.h>
#include <string>


#define RST_PIN        22          // Configurable, see typical pin layout above
#define SS_PIN         5         // Configurable, see typical pin layout above

#define m1 13
#define m2 14
#define quantity 27

byte readCard[4];
byte a = 0;
MFRC522 mfrc522(SS_PIN, RST_PIN);  // Create MFRC522 instance

//server
//Add WIFI data
const char* ssid = "****";              //Add your WIFI network name 
const char* password =  "****";           //Add WIFI password




//Variables used in the code
String data_to_send = "";             //Text data to send to the server  
bool toggle_pressed = false;          //Each time we press the push button   
unsigned int Actual_Millis, Previous_Millis;
int refresh_time = 200;


void setup() {
  delay(10);
  Serial.begin(115200);                   //Start monitor

  //rfid setup
  while (!Serial);		// Do nothing if no serial port is opened (added for Arduinos based on ATMEGA32U4)
	SPI.begin();			// Init SPI bus
	mfrc522.PCD_Init();		// Init MFRC522
	delay(4);				// Optional delay. Some board do need more time after init to be ready, see Readme
	mfrc522.PCD_DumpVersionToSerial();	// Show details of PCD - MFRC522 Card Reader details
	Serial.println(F("Scan PICC ..."));

  //server setup
  pinMode(m1,OUTPUT);
  pinMode(m2,OUTPUT);
  pinMode(quantity,OUTPUT);
  
  
  
  WiFi.begin(ssid, password);             //Start wifi connection
  Serial.print("Connecting...");
  while (WiFi.status() != WL_CONNECTED) { //Check for the connection
    delay(500);
    Serial.print(".");
  }

  Serial.print("Connected, my IP: ");
  Serial.println(WiFi.localIP());
  Actual_Millis = millis();               //Save time for refresh loop
  Previous_Millis = Actual_Millis; 
}

void loop() {  
  digitalWrite(m2,LOW);
  digitalWrite(m1,LOW);
  Actual_Millis = millis();
  if(Actual_Millis - Previous_Millis > refresh_time){
    Previous_Millis = Actual_Millis; 

    
    
    //server
    if(WiFi.status()== WL_CONNECTED){                   //Check WiFi connection status  
      HTTPClient http;                                  //Create new client
      
      int flag = readRFID1();
      Serial.println(flag);
      if(flag == 3){
         Serial.println("Unothorized RFID"); 
         data_to_send = "check_medicine_status=" + LED_id;
      }
      else if(flag == 1){
        data_to_send = "rfid=1";  
      }
      else if(flag == 2){
        data_to_send = "rfid=2";  
      }
      else data_to_send = "check_medicine_status=" + "";    
      
      
      //Begin new connection to website       
      http.begin("https://medimartuiu.000webhostapp.com/server.php");   //Indicate the destination webpage 
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");         //Prepare the header
      
      int response_code = http.POST(data_to_send);                                //Send the POST. This will giveg us a response code
      
      //If the code is higher than 0, it means we received a response
      if(response_code > 0){
        Serial.println("HTTP code " + String(response_code));                     //Print return code
  
        if(response_code == 200){                                                 //If code is 200, we received a good response and we can read the echo data
          String response_body = http.getString();                                //Save the data comming from the website
          Serial.print("Server reply: ");                                         //Print data to the monitor for debug
          Serial.println(response_body);

          
          if(response_body == "11"){
              digitalWrite(m1,HIGH);
              digitalWrite(quantity,LOW);

              int v1 = digitalRead(m1);
              int v2 = digitalRead(quantity);
              
              Serial.print("m1 = ");
              Serial.print(v1);  
              Serial.print("quantity = ");
              Serial.println(v2);
                
          }
          else if(response_body == "12"){
              digitalWrite(m1,HIGH);
              digitalWrite(quantity,HIGH);

              int v1 = digitalRead(m1);
              int v2 = digitalRead(quantity);
              
              Serial.print("m1 = ");
              Serial.print(v1);  
              Serial.print("quantity = ");
              Serial.println(v2);
          }
           else if(response_body == "21"){
              digitalWrite(m2,HIGH);
              digitalWrite(quantity,LOW);

              int v1 = digitalRead(m2);
              int v2 = digitalRead(quantity);
              
              Serial.print("m2 = ");
              Serial.print(v1);  
              Serial.print("quantity = ");
              Serial.println(v2);
          }
          else if(response_body == "22"){
              digitalWrite(m2,HIGH);
              digitalWrite(quantity,HIGH);

              int v1 = digitalRead(m2);
              int v2 = digitalRead(quantity);
              
              Serial.print("m2 = ");
              Serial.print(v1);  
              Serial.print("quantity = ");
              Serial.println(v2);
          }
          else {            
            
          }  
        }//End of response_code = 200
      }//END of response_code > 0
      
      else{
       Serial.print("Error sending POST, code: ");
       Serial.println(response_code);
      }
      http.end();                                                                 //End the connection
    }//END of WIFI connected
    else{
      Serial.println("WIFI connection error");
    }
    delay(200);
    digitalWrite(m2,LOW);
    digitalWrite(m1,LOW);
    digitalWrite(quantity,LOW);
    
  }
}

int readRFID1(){
  // Reset the loop if no new card present on the sensor/reader. This saves the entire process when idle.
	if ( ! mfrc522.PICC_IsNewCardPresent()) {
		return 0;
	}

	// Select one of the cards
	if ( ! mfrc522.PICC_ReadCardSerial()) {
		return 0;
	}

	// Dump debug info about the card; PICC_HaltA() is automatically called
	//mfrc522.PICC_DumpToSerial(&(mfrc522.uid));
  String rfid = "";
  for(uint8_t i = 0; i<4; i++){
    readCard[i] = mfrc522.uid.uidByte[i];
    Serial.print(readCard[i], HEX);
     rfid = rfid + readCard[i];
    Serial.print(" ");
    delay(500);
    a +=3;
  }
  Serial.println("");
  Serial.println(rfid);


    
  mfrc522.PICC_HaltA();  
 // mfrc522.PCD_StopCrypto1();
  if(rfid == "163243150149"){ //A3 F3
    return 1;
  }
  else if(rfid == "2182402511"){ //DA F0
    return 2;
  }
  else {
    return 3;
  }
  //rfid end
}

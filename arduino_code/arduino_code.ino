#include <Servo.h>
int myInt, chooice;
Servo mServo, mServo1, myservo, myServo;


// Sanitizer
const int trPin = 6;
const int ecPin = 5;

// Dustbin
const int trigPin = 10;
const int echoPin = 11;

// Website
const int x1 = 3;  //m-1=13
const int x2 = 4;  //m-2=14

const int y1 = 13;  //quantity=27


// defines variables
// Sanitozer
long dur;
int dis;

// dustbin
long duration;
int distance;

void setup() {
  Serial.begin(9600);
  mServo.attach(9);
  mServo1.attach(8);

  pinMode(x1, INPUT);  //esp32-13
  pinMode(x2, INPUT);  //esp32-14
  pinMode(y1, INPUT);  //esp32-27

  // sanitizer
  pinMode(trPin, OUTPUT);  // Sets the trigPin as an Output
  pinMode(ecPin, INPUT);   // Sets the echoPin as an Input
  myServo.attach(12);

  // dustbin
  pinMode(trigPin, OUTPUT);  // Sets the trigPin as an Output
  pinMode(echoPin, INPUT);   // Sets the echoPin as an Input
  myservo.attach(7);
}
void loop() {
  mServo.write(30);
  mServo1.write(30);
  for (int i = 0; i <= 10; i++) {
    // dustbin
    digitalWrite(trigPin, HIGH);
    delayMicroseconds(10);
    digitalWrite(trigPin, LOW);/////////////////////////
    // Reads the echoPin, returns the sound wave travel time in microseconds
    duration = pulseIn(echoPin, HIGH);
    // Calculating the distance///////////
    distance = duration * 0.034 / 2;
    // Prints the distance on the Serial Monitor


    Serial.print("Dustbin Distance: ");
    Serial.println(distance);
   
    // Dustbin
    if (distance <= 4 && distance > 0) {
      m_servo_open();
    } else {
      m_servo_close();
    }
    delay(300);
  }
///

  for (int i = 0; i <= 10; i++) {

    // sanitizer
    digitalWrite(trPin, HIGH);
    delayMicroseconds(10);
    digitalWrite(trPin, LOW);
    // Reads the echoPin, returns the sound wave travel time in microseconds
    dur = pulseIn(ecPin, HIGH);////////////////////////////////////////////////////////////////////
    // Calculating the distance
    dis = dur * 0.034 / 2;
    // Prints the distance on the Serial Monitor//////////
    if (dis <= 6 && dis > 0) {
      m_servo();
    } else {
      myServo.write(180);
    }
    Serial.println(dis);
    delay(300);
  }
  delay(50);
  for (int i = 0; i <= 35; i++) {
    chooiceMedicine();
  }
}

void chooiceMedicine() {

  int m1 = digitalRead(x1);
  int m2 = digitalRead(x2);
  int quantity = digitalRead(y1);


  Serial.print("x1: ");
  Serial.print(m1);
  Serial.print(" \tx2: ");
  Serial.print(m2);
  Serial.print(" \tQuantity: ");
  Serial.println(quantity);

  if (m1 == 1) {
    pushNapaMedicine(quantity + 1);
  }
  if (m2 == 1) {
    pushMonasMedicine(quantity + 1);
  }
  delay(200);
}



void pushNapaMedicine(int n) {
  for (int i = 0; i < n; i++) {
    mServo.write(30);
    delay(1000);
   
    mServo.write(120);
    delay(1500);
    mServo.write(30);
    delay(2000);
  }
}


void pushMonasMedicine(int n) {
  for (int i = 0; i < n; i++) {
    mServo1.write(30);
    delay(1000);


    mServo1.write(120);
    delay(1500);
    mServo1.write(30);
    delay(1000);
  }
}


void m_servo_close() {
  myservo.write(0);  // tell servo to go to position in variable 'pos'
}
void m_servo_open() {
  myservo.write(60);  // tell servo to go to position in variable 'pos'
  delay(3000);
}

void m_servo() {
  myServo.write(100);
  delay(1500);
}

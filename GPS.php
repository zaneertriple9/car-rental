<?php
session_start();
include('includes/config.php');
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Display Tracksolid</title>

<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-social.css">
<link rel="stylesheet" href="css/bootstrap-select.css">
<link rel="stylesheet" href="css/fileinput.min.css">
<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include('includes/header.php');?>

<div class="ts-main-content">
    <?php include('includes/leftbar.php');?>

    <?php
session_start();
include('includes/config.php');
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Display Tracksolid</title>

<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-social.css">
<link rel="stylesheet" href="css/bootstrap-select.css">
<link rel="stylesheet" href="css/fileinput.min.css">
<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>
<?php include('includes/header.php');?>

<div class="ts-main-content">
    <?php include('includes/leftbar.php');?>

</div>

<div style="height: 80%; width: 80%; position: absolute; right: 1%; top: 100px;
    border-radius: 12px;
    border: 1px solid #fff;
">
    <div id="map" style="width: 100%; height: 100%;"></div>
</div>

<script>
    var map = L.map('map'); 
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Center the map on the user's location
            map.setView([latitude, longitude], 13);

            // Add a marker at the user's location
            L.marker([latitude, longitude]).addTo(map)
                .bindPopup('You are here!')
                .openPopup();
        }, function() {
            alert("Geolocation failed. Please enable location services.");
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
</script>

<script>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <Wire.h>
#include <HardwareSerial.h>

// OLED setup
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64
#define OLED_RESET -1 // Reset pin (not used for I2C)
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);

// Hardware Serial for A9G
HardwareSerial mySerial(1);
const int RXD2 = 16;
const int TXD2 = 17;

void setup() {
  // Initialize Serial and A9G
  Serial.begin(115200);
  mySerial.begin(9600, SERIAL_8N1, RXD2, TXD2);

  // Initialize OLED
  if (!display.begin(SSD1306_PAGEADDR, 0x3C)) {
    Serial.println("OLED initialization failed.");
    while (true); // Halt execution
  }

  display.clearDisplay();
  display.setTextSize(1);
  display.setTextColor(SSD1306_WHITE);
  display.setCursor(0, 0);
  display.println("Initializing ESP32...");
  display.display();

  // Check A9G Module
  while (!sendCommand("AT", 10000)) {
    display.clearDisplay();
    display.println("A9G not responding.");
    display.display();
  }
  display.clearDisplay();
  display.println("A9G detected!");
  display.display();

  delay(1000);  // Delay after A9G detection

  // Enable GPS
  while (!sendCommand("AT+GPS=1", 2000)) {
    display.println("Failed to enable GPS.");
    display.display();
  }
  display.println("GPS enabled.");
  display.display();

  delay(1000); // Wait before starting GPS data reporting

  // Start GPS data reporting
  while (!sendCommand("AT+GPSRD=1", 2000)) {
    display.println("Failed to start GPS.");
    display.display();
  }
  display.println("GPS reporting started.");
  display.display();

  delay(1000);
}

void loop() {
  try {
    if (mySerial.available()) {
      String gpsData = readGPSData();

      // Debugging: Print raw data to Serial Monitor
      Serial.println("Raw Data: " + gpsData);

      if (gpsData.startsWith("$GPRMC")) {
        display.clearDisplay();
        display.setCursor(0, 0);

        if (gpsData.indexOf(",A,") > 0) {
          display.println("GPS Fix Acquired");
          parseGPSData(gpsData);
        } else {
          display.println("No GPS Fix Yet");
          display.display();
        }
      } else {
        display.clearDisplay();
        display.setCursor(0, 0);
        display.println("Waiting for GPS data...");
        display.display();
      }
    } else {
      // No data available from the A9G module
      display.clearDisplay();
      display.setCursor(0, 0);
      display.println("Error: No Data");
      display.println("Check GPS Module");
      display.display();

      // Debugging: Print error message to Serial Monitor
      Serial.println("Error: No data available from A9G.");
    }
  } catch (const std::exception &e) {
    // Display exception message on OLED
    display.clearDisplay();
    display.setCursor(0, 0);
    display.println("Exception Occurred:");
    display.println(e.what());
    display.display();

    // Log exception to Serial Monitor
    Serial.print("Exception: ");
    Serial.println(e.what());
  } catch (...) {
    // Catch-all for unknown errors
    display.clearDisplay();
    display.setCursor(0, 0);
    display.println("Unknown Error Occurred");
    display.display();

    // Log unknown error to Serial Monitor
    Serial.println("Unknown error occurred in loop.");
  }

  delay(1000); // Wait for 1 second before next read
}

// Function to send AT commands
bool sendCommand(String command, int timeout) {
  Serial.println("Sending Command: " + command);
  mySerial.println(command);
  long int time = millis();
  String response = "";

  while ((millis() - time) < timeout) {
    while (mySerial.available()) {
      char c = mySerial.read();
      response += c;
    }
  }

  if (response.length() > 0) {
    Serial.println("Response: " + response);
    delay(500);  // Delay after sending command (500ms)
    return true;
  } else {
    Serial.println("No response received.");
    return false;
  }
}

// Function to read raw GPS data
String readGPSData() {
  String gpsData = "";
  while (mySerial.available()) {
    char c = mySerial.read();
    gpsData += c;
  }
  return gpsData;
}

// Function to parse GPRMC data and display on OLED
void parseGPSData(String data) {
  try {
    // Split the GPS data
    int commaIndex = 0;
    int fieldIndex = 0;
    String fields[12];

    while ((commaIndex = data.indexOf(',')) >= 0) {
      fields[fieldIndex++] = data.substring(0, commaIndex);
      data = data.substring(commaIndex + 1);
    }
    fields[fieldIndex] = data; // Last field

    // Parse latitude and longitude
    if (fields[2] == "A") { // GPS data is valid
      String latitude = fields[3];
      String latitudeDir = fields[4];
      String longitude = fields[5];
      String longitudeDir = fields[6];

      float lat = convertToDecimal(latitude, latitudeDir);
      float lon = convertToDecimal(longitude, longitudeDir);

      display.println("Latitude: " + String(lat, 6));
      display.println("Longitude: " + String(lon, 6));
      display.display();

      Serial.println("Latitude: " + String(lat, 6));
      Serial.println("Longitude: " + String(lon, 6));

      delay(2000);  // Add delay after displaying data (2 seconds)
    } else {
      display.println("GPS data not valid.");
      display.display();
      Serial.println("GPS data not valid.");
    }
  } catch (...) {
    Serial.println("Error: Failed to parse GPS data.");
    display.println("Error parsing data");
    display.display();
  }
}

// Function to convert raw latitude/longitude to decimal format
float convertToDecimal(String rawValue, String direction) {
  try {
    float decimal = rawValue.substring(0, 2).toFloat() + (rawValue.substring(2).toFloat() / 60);
    if (direction == "S" || direction == "W") {
      decimal = -decimal;
    }
    return decimal;
  } catch (...) {
    Serial.println("Error: Failed to convert GPS coordinates to decimal.");
    return 0.0;
  }
}

</script>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

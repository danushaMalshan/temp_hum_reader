<?php

include 'connect.php';

// Get the temperature and humidity values sent by the ESP32 board
$temperature = $_POST["temperature"];
$humidity = $_POST["humidity"];
$humidity = $_POST["humidity"];


// Prepare an SQL query to insert the temperature and humidity values into a table
$sql = "INSERT INTO temp (temp, humidity) VALUES (Now(),'$temperature', '$humidity')";

// Execute the SQL query
if ($con->query($sql) === TRUE) {
    echo "Dhhfhta inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}

// Close the MySQL connection
$con->close();

?>
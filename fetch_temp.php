<?php
include 'connect.php';

$date = $_POST["date"]; 



$sql = "Select * from `temp` WHERE day > '$date'";
$result = mysqli_query($con, $sql);

$rows = array();
while ($row = mysqli_fetch_assoc($result)) {

  $datetimeStr = $row['day'];
  $datetime = new DateTime($datetimeStr);

  // Get the time portion of the datetime
  $time = $datetime->format('d/H:i');

  $day = $time;
  $temp = floatval($row['temp']);
  $humidity = floatval($row['humidity']);
  $rows[] = array($day, $temp, $humidity);
}

echo json_encode($rows);

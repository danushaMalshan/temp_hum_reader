<?php
include 'connect.php';
// Get the POST data
$bulb_id = $_POST["id"];
$status = $_POST["status"];

// Update the bulb status in the database
$sql = "UPDATE bulb SET status=$status WHERE id=$bulb_id";
if ($con->query($sql) === TRUE) {
  echo $status;
} else {
  echo "Error: " . $sql . "<br>" . $con->error;
}

// Close the database connection
$con->close();
?>

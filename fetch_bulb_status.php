<?php
include 'connect.php';



$sql = "Select * from `bulb` WHERE id = 1";
$result = mysqli_query($con, $sql);

$rows = array();
while ($row = mysqli_fetch_assoc($result)) {

 $state=$row['status'];

  
  
  
}

echo json_encode($state);

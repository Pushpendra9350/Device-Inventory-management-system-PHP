<?php
// this is for connection to Database
require_once 'db_configuration.php';

// This is a query to update status issued to returned
$sql= "UPDATE issued_device_data SET status='returned' WHERE sno=".$_COOKIE["changeStatusId"]."";
$result = mysqli_query($connection,$sql);

$sql = "SELECT device_id FROM issued_device_data where sno=".$_COOKIE["changeStatusId"]."";
$result = mysqli_query($connection,$sql);
$data=mysqli_fetch_array($result,MYSQLI_ASSOC);
$deviceId = $data["device_id"];

$sql = "SELECT available_inventory FROM device_data where sno=".$deviceId."";
$result = mysqli_query($connection,$sql);
$data=mysqli_fetch_array($result,MYSQLI_ASSOC);
$current_inventory = $data["available_inventory"]+1;

$sql= "UPDATE device_data SET available_inventory=".$current_inventory." WHERE sno=".$deviceId."";
$result = mysqli_query($connection,$sql);

mysqli_close($connection);
header("location:dims_home_page.php");

?>
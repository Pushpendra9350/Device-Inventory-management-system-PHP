<?php
require_once "db_configuration.php";

$sql = "SELECT available_inventory FROM device_data where sno=".$_COOKIE["totalInventoryEditId"]."";
$result = mysqli_query($connection,$sql);
$data=mysqli_fetch_array($result,MYSQLI_ASSOC);
$noOfAvailInventory = $data["available_inventory"];

if($noOfAvailInventory<=$_COOKIE["totalInventoryData"])
{
$sql ="UPDATE device_data SET total_inventory=".$_COOKIE["totalInventoryData"]." WHERE sno=".$_COOKIE["totalInventoryEditId"]."";
$result = mysqli_query($connection,$sql);
}

mysqli_close($connection);
header("location:device_list.php");
?>

<?php
require_once "db_configuration.php";

$sql = "SELECT count(*) as counter FROM issued_device_data where device_id=".$_COOKIE['deleteDeviceId']."";
$result = mysqli_query($connection,$sql);
$data=mysqli_fetch_array($result,MYSQLI_ASSOC);
$rowCounts = $data["counter"];
echo $rowCounts;

if ($rowCounts==0)
{
    $sql="DELETE FROM device_data WHERE sno=".$_COOKIE['deleteDeviceId']."";
    $result = mysqli_query($connection,$sql);
    header("location:device_list.php");
}
else{
    
    header("location:device_list.php");
}
mysqli_close($connection);
?>

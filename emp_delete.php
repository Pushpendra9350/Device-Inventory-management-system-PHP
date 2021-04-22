<?php
require_once "db_configuration.php";
$sql = "SELECT count(*) as counter FROM issued_device_data where employee_id=".$_COOKIE['deleteEmployeeId']."";
$result = mysqli_query($connection,$sql);
$data=mysqli_fetch_array($result,MYSQLI_ASSOC);
$rowCounts = $data["counter"];
echo $rowCounts;
if ($rowCounts==0)
{
    $sql="DELETE FROM employees WHERE employee_id=".$_COOKIE['deleteEmployeeId']."";
    $result = mysqli_query($connection,$sql);
    header("location:employee_list.php");
}
else{
    
    header("location:employee_list.php");
}
mysqli_close($connection);
?>

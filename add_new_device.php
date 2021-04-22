<?php
session_start();
if ( !isset( $_SESSION['loggedin'] ) ) {
    header( 'location:login.php' );
    exit;
}
// Importing database configuration to connect with database
require_once 'db_configuration.php';

// define variables and set to empty values and error values for validation
$deviceNameErr = $totalInventoryErr = '';
$deviceName = $totalInventory = '';

// This will run when we submit form with post method
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

  // This will check weather input field is emplty or not
  if ( empty( trim( $_POST['deviceName'] ) ) ) {
      $deviceNameErr = 'Device Name is required';
    } 
  else{
      $deviceName = input_cleaner( $_POST['deviceName'] );
    }

  // This will check weather input field is emplty or not
  if ( empty( trim( $_POST['totalInventory'] ) ) ) {
      $totalInventoryErr = 'Total Inventory is required';
    } 
  else {
      $totalInventory = trim( $_POST['totalInventory'] );
    }
  
  // If Both of the input fields having valid inputs then process next
  if ( empty( $deviceNameErr ) && empty( $totalInventoryErr ) ){

      //  This is a query for inserting data into database
      $sql = "INSERT INTO device_data (device_name, total_inventory, available_inventory) VALUES (?,?,?)";
      
      // Prepare a statement 
      $stmt = mysqli_prepare( $connection, $sql );
      if($stmt)
      {
        mysqli_stmt_bind_param($stmt,"sii",$param_deviceName,$param_totalInventory,$param_availableInventory);
        $param_deviceName = $deviceName;
        $param_totalInventory = $totalInventory;
        $param_availableInventory = $totalInventory;
        if(mysqli_stmt_execute($stmt))
        {
          header("location:device_list.php");
        }
        else
        {
          echo "Something went wrong";
        }
      }

      // Now close the statement
      mysqli_stmt_close($stmt);
    }
  // Close the connection with database
  mysqli_close($connection);
}

// this function is for cleaning the input
function input_cleaner( $data ) {
    $data = trim( $data );
    $data = stripslashes( $data );
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" 
      crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="style.css">
      <title>Add A Device</title>
  </head>
  <body>
      <img style=position:relative;left:670px; src="logoll.jpg" alt="LogoImage" width="200" height="120">
      <div style=position:absolute;top:20px;right:50px; class=" d-flex justify-content-between">
        <a style=margin:5px; class="btn btn-primary btn-sm" href="./device_list.php">Device List</a>
        <a style=margin:5px; class="btn btn-primary btn-sm" href="dims_home_page.php">Home Page</a>
        <a style=margin:5px; class="btn btn-danger btn-sm" href="./logout.php">Logout</a>
      </div>
      <div style=margin-left:auto;margin-right:auto; auto; class="card">
        <h3  style=color:gray;text-align:center;margin-bottom:80px;>New Device Addition Form</h3>
          <form action="" method="post">
            <div style=width:400px; class="form-group">
              <label>Device Name</label>
              <input type="text" class="form-control" name="deviceName" placeholder="Enter device name">
              <small style = color:red;><?php echo $deviceNameErr; ?></small>
            </div>
            <div class="form-group">
              <label>Total Inventory</label>
              <input type="text" class="form-control" name="totalInventory" placeholder="Enter total inventory">
              <small style = color:red;><?php echo $totalInventoryErr; ?></small>
            </div>
            <div class="submitbtn">
              <input  type="submit" name="submit" class="btn btn-primary" value="submit">
            </div>
          </form>
      </div>

  </body>
</html>
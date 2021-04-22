<?php
session_start();
if ( !isset( $_SESSION['loggedin'] ) ) {
    header( 'location:login.php' );
    exit;
}
// for connecting to database
require_once 'db_configuration.php';

// define variables and set to empty values
$employeeIdErr = $nameErr = $emailIdErr ='';
$employeeId = $name = $emailId = '';

// this is for post method in form
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

    if ( empty( trim( $_POST['employeeId'] ) ) ) {
        $employeeIdErr = 'Employee Id is required';
    } else {
        
          $employeeId = trim( $_POST['employeeId'] );
    }

    if ( empty( trim( $_POST['name'] ) ) ) {
      $nameErr = 'Name is required';
    } 
    else {
      $name = input_cleaner( $_POST['name'] );
    }

    if ( empty( trim( $_POST['emailId'] ) ) ) {
      $emailIdErr = 'Email is required';
    } 
    else {
      $emailId = input_cleaner( $_POST['emailId'] );
    }

    if ( empty( $nameErr ) && empty( $emailIdErr ) && empty( $employeeIdErr ) ){
      $sql = "INSERT INTO employees (employee_id,name,email_id) VALUES (?,?,?)";
      $stmt = mysqli_prepare( $connection, $sql );
      if($stmt)
      {
        mysqli_stmt_bind_param($stmt,"iss",$param_employeeId,$param_name,$param_emailId);
        $param_employeeId = $employeeId;
        $param_name = $name;
        if(email_validation($emailId)){
          $param_emailId = $emailId;
          if(mysqli_stmt_execute($stmt)){
            header("location:employee_list.php");
          }
          else{
            echo "<p style=color:red;position:relative;left:700px;top:10px;>Something went wrong</p>";
          }
        }
        else{
          $emailIdErr = "Please enter valid email";
        }
      }
    mysqli_stmt_close($stmt);
  }
  mysqli_close($connection);
}

function input_cleaner( $data ) {
  $data = trim( $data );
  $data = stripslashes( $data );
  return $data;
}

// This is for validate email
function email_validation($str) { 
  return (!preg_match( "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) 
      ? FALSE : TRUE; 
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
      <title>Add New Employee</title>
  </head>
  <body>
      <img style=position:relative;left:670px; src="logoll.jpg" alt="LogoImage" wwidth="200" height="120">
      <div style=position:absolute;top:20px;right:50px; class=" d-flex justify-content-between">
        <a style=margin:5px; class="btn btn-primary btn-sm" href="./employee_list.php">Employee List</a>
        <a style=margin:5px; class="btn btn-primary btn-sm" href="dims_home_page.php">Home Page</a>
        <a style=margin:5px; class="btn btn-danger btn-sm" href="./logout.php">Logout</a>
      </div>
      <div style=margin-left:auto;margin-right:auto; auto; class="card">
        <h3 style=color:gray;text-align:center;margin-bottom:40px;>New Employee Addition Form</h3>
        <form action="" method="post">
          <div style=width:400px; class="form-group">
            <label>Employee Id</label>
            <input type="text" class="form-control" name="employeeId" placeholder="Enter employee id" require>
            <small style = color:red;><?php echo $employeeIdErr; ?></small>  
          </div>
          <div class="form-group">
            <label >Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter name" require>
            <small style = color:red;><?php echo $nameErr; ?></small>
          </div>
          <div class="form-group">
            <label>Email Id</label>
            <input type="email" name="emailId" class="form-control" placeholder="Enter email" require>
            <small style = color:red;><?php echo $emailIdErr; ?></small>
          </div>
          <div class="submitbtn">
            <input  type="submit" name="submit" class="btn btn-primary" value="submit">
          </div>
        </form>
    </div>
  </body>
</html>
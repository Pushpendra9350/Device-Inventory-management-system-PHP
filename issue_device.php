<?php
session_start();
if ( !isset( $_SESSION['loggedin'] ) ) {
    header( 'location:login.php' );
    exit;
}

require_once 'db_configuration.php';

// define variables and set to empty values
$deviceNameErr = $employeeNameErr = $returnDateErr ='';
$deviceName = $employeeName = $returndate = '';
$err = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
  if ( empty($_POST['devicename']) ) {
      $deviceNameErr = 'Select a device';
    } 
  else {
          $deviceName = $_POST['devicename'];
       }

    if ( empty($_POST['employeename'] ) ) {
      $employeeNameErr = 'Select an employee';
    } else {
        $employeeName = $_POST['employeename'];
        
  }

    if ( empty( $_POST['returndate'] ) ) {
      $returnDateErr = 'Select date';
    } 
    else{
          $lst = $_POST['returndate'];
          $returnDate = "".$lst[6]."".$lst[7]."".$lst[8]."".$lst[9]."-".$lst[0]."".$lst[1]."-".$lst[3]."".$lst[4];   
    }


    if ( empty( $deviceNameErr ) && empty( $employeeNameErr ) && empty( $returnDateErr ) )
    {
        $sql = "SELECT name FROM employees where employee_id=".$employeeName."";
        $result = mysqli_query($connection,$sql);
        $data=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $employeeRealName = $data["name"];

        $sql = "SELECT device_name,available_inventory FROM device_data where sno=".$deviceName."";
        $result = mysqli_query($connection,$sql);
        $data=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $deviceRealName = $data["device_name"];
  
  
        $sql = "INSERT INTO issued_device_data (device_name,employee_name,employee_id,device_id,return_date) VALUES (?,?,?,?,?)";
        $stmt = mysqli_prepare( $connection, $sql );
        if($stmt)
        {
          mysqli_stmt_bind_param($stmt,"ssiis",$param_deviceRealName,$param_employeeRealName,$param_employeeName,$param_deviceName,$param_returnDate);
          $param_deviceRealName = $deviceRealName;
          $param_employeeRealName = $employeeRealName;
          $param_employeeName = $employeeName;
          $param_deviceName = $deviceName;
          $param_returnDate = $returnDate;
          if(mysqli_stmt_execute($stmt))
          {
            $current_inventory = $data['available_inventory']-1;
            $sql1 = "UPDATE device_data SET available_inventory=".$current_inventory." WHERE sno=".$deviceName."";
            $result = mysqli_query($connection,$sql1);
          }
          else{
               echo "<p style=color:red;position:relative;left:700px;top:10px;>Something went wrong</p>";
          }         
        }
        mysqli_stmt_close($stmt);   
      }
    mysqli_close($connection);
    header("location:dims_home_page.php");
  }
  

  


function input_cleaner( $data ) {
    $data = trim( $data );
    $data = stripslashes( $data );
    return $data;
}

function email_validation($str) { 
  return (!preg_match( 
"^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) 
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
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  	<script>
	  		$( function() {
	   			$( "#returndate" ).datepicker({
	   				minDate: 0
	   			});
	  		});
	  	</script>
    <title>Issue Device</title>
</head>
<body>
<img style=position:relative;left:670px; src="logoll.jpg" alt="LogoImage" width="200" height="120">
<div style=position:absolute;top:20px;right:50px; class=" d-flex justify-content-between">
    <a style=margin:5px; class="btn btn-primary btn-sm" href="dims_home_page.php">Home Page</a>
    <a style=margin:5px; class="btn btn-danger btn-sm" href="./logout.php">Logout</a>
    </div> 
    <div style=margin-left:auto;margin-right:auto; auto; class="card">
    <h3 style=color:gray;text-align:center;margin-bottom:40px;>Issue Device</h3>
    
<form action="" method="post">
  <div style=width:400px; class="form-group">
    <label>Select Device</label>
    <select class="form-control" name="devicename" required>
      <option disabled selected>--Select Device--</option>
      <?php
     
      $sql1 = "SELECT * FROM device_data where available_inventory>0";
      $result1 = mysqli_query($connection,$sql1);
      while($data1 = mysqli_fetch_array($result1,MYSQLI_ASSOC))
      {
          echo $data["device_name"];
          echo '<option value='.$data1["sno"].'>'.$data1["device_name"].'</option>';
      }
    ?>
      </select>
      <small style = color:red;><?php echo $deviceNameErr; ?></small>
  </div>
  <div class="form-group">
    <label>Select Employee</label>
    <select class="form-control" name="employeename" required>
      <option selected disabled>--Select Employee--</option>
      <?php
      
      $sql2 = "SELECT * FROM employees";
      $result2 = mysqli_query($connection,$sql2);
      while($data2 = mysqli_fetch_array($result2,MYSQLI_ASSOC))
      {
          echo '<option value='.$data2["employee_id"].'>'.$data2["name"].'</option>';
      }
    ?>
    </select>
    <small style = color:red;><?php echo $employeeNameErr; ?></small>
  </div>
<br>
  <label>Return Date:</label>
        <input required type="text" name="returndate" id="returndate" title="return date" />
        <small style = color:red;><?php echo $returnDateErr; ?></small>
  <div style=left:320px; class="submitbtn">
  <input  type="submit" name="submit" class="btn btn-primary" value="Submit">
  </div>
</form>
</div>

</body>
</html>
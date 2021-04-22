<?php
session_start();
if ( !isset( $_SESSION['loggedin'] ) ) {
    header( 'location:login.php' );
    exit;
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
     <script>
      function filters()
      {
        document.cookie = "filterByData="+document.getElementById("filterby").value;
      }
     </script>
    <title>Home Page</title>
</head>
<body>
    <img style=position:relative;left:670px; src="logoll.jpg" alt="LogoImage" width="200" height="120">
    <div class="btndiv d-flex justify-content-around">
      <a class="btn btn-primary btn-sm" href="./issue_device.php">Issue A Device</a>
      <a class="btn btn-primary btn-sm" href="./add_new_device.php">Add New Device</a>
      <a class="btn btn-primary btn-sm" href="./add_new_employee.php">Add New Employee</a>
      <a class="btn btn-primary btn-sm" href="./device_list.php">Device List</a>
      <a class="btn btn-primary btn-sm" href="./employee_list.php">Employee List</a>
    <form action="" method="post">
    <span>
    <select id="filterby">
      <option selected disabled>--Filter By--</option>
      <option value="Issued">Issued</option>
      <option Value="returned">Returned</option>
    </select>
    <a class="btn btn-primary btn-sm" onclick="filters()" href="./filter_flow.php">Filter</a>
    </span>
    </form>
    <a class="btn btn-danger btn-sm" href="./logout.php">Logout</a>
    </div>
      <div  class="container" >
        <ul style=width:900px; class="list-group">
          <script type="text/javascript">
            function reply_click(click_id)
            {
              document.cookie = "changeStatusId="+click_id; 
            }
          </script>
    <?php 
      
      require_once 'db_configuration.php';
      if($_SESSION["filterByData"] == "Issued")
      {
        $sql = "SELECT sno,device_name,employee_name,status,return_date FROM issued_device_data where status='Issued'";
        $result = mysqli_query($connection,$sql);
        $_COOKIE["filterByData"] = 'Issued';
        $_SESSION["filterByData"]="";
      }
      if($_COOKIE["filterByData"]=="returned")
      {
        $sql = "SELECT sno,device_name,employee_name,status,return_date FROM issued_device_data where status='returned'";
        $result = mysqli_query($connection,$sql);
        while($data=mysqli_fetch_array($result,MYSQLI_ASSOC))
          {
            echo '<li class="list-group-item d-flex justify-content-around"><span><strong>Device Name:-</strong>'
              . $data["device_name"].'</span><span><strong id="empname">Employee Name:-</strong>'.$data["employee_name"].'</span><span><strong id="empname">Status:-</strong>'
              .$data["status"].'</span><span><strong id="empname">Return Date:-</strong>'.$data["return_date"].'</span>
              </li>';
          }
        $_COOKIE["filterByData"] = 'Issued';
        }
        else{
          $sql = "SELECT sno,device_name,employee_name,status,return_date FROM issued_device_data where status='Issued'";
          $result = mysqli_query($connection,$sql);
          while($data=mysqli_fetch_array($result,MYSQLI_ASSOC))
            {
              if(strtotime($data["return_date"])<strtotime(date("Y-m-d")))
              {
              echo '<li class="listcolor list-group-item d-flex justify-content-around"><span><strong>Device Name:-</strong>'
                . $data["device_name"] .'</span><span><strong id="empname">Employee Name:-</strong>'.$data["employee_name"].'</span><span><strong id="empname">Status:-</strong>'
                .$data["status"].'</span><span><strong id="empname">Return Date:-</strong>'.$data["return_date"].'</span>
                </li><a id='.$data["sno"].' onclick="reply_click(this.id)" class="returnbtn btn btn-outline-success btn-sm"
                href="./change_status.php" disabled >Returned</a>';
              }
              else{
                echo '<li class="list-group-item d-flex justify-content-around"><span><strong>Device Name:-</strong>'
                . $data["device_name"] .'</span><span><strong id="empname">Employee Name:-</strong>'.$data["employee_name"].'</span><span><strong id="empname">Status:-</strong>'
                .$data["status"].'</span><span><strong id="empname">Return Date:-</strong>'.$data["return_date"].'</span>
                </li><a id='.$data["sno"].' onclick="reply_click(this.id)" class="returnbtn btn btn-outline-success btn-sm"
                href="./change_status.php" disabled >Returned</a>';
              }
            }
          }
  ?>
</ul>
</div>
</body>
</html>
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
    <title>Employee List</title>
</head>
<body>
    <img style=position:relative;left:670px; src="logoll.jpg" alt="LogoImage" width="200" height="120">
    <div style=position:absolute;top:20px;right:50px; class=" d-flex justify-content-between">
    <a style=margin:5px; class="btn btn-primary btn-sm" href="./add_new_employee.php">Add New Employee</a>
    <a style=margin:5px; class="btn btn-primary btn-sm" href="dims_home_page.php">Home Page</a>
    <a style=margin:5px; class="btn btn-danger btn-sm" href="./logout.php">Logout</a>
    </div>
    <div  class="container" >
    
    <ul style=width:700px; class="list-group">
    <li class="list-group-item d-flex justify-content-between list-group-item-primary">
        <strong>Employee Id</strong> <span><strong>Employee Name</strong></span><span><strong>Email Id</strong></span></li>
        <small style=color:blue;>----------------------------------------------------------------------------------------------------------------------------------------</small>
        <script type="text/javascript">
  function replye_click(click_id)
  {
    var y = confirm("Press Ok To Confirm Delete");
    if(y==true)
    {
    document.cookie = "deleteEmployeeId="+click_id;
    }
    else{
      document.cookie = "deleteEmployeeId="+0;
    }
  }
  
</script>
        <?php 
        require_once 'db_configuration.php';
        $sql = "SELECT * FROM employees";
        $result = mysqli_query($connection,$sql);
        
while($data=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
  echo '<li class="list-group-item d-flex justify-content-between align-items-center">'
    . $data["employee_id"] .'<span>'. $data["name"].'</span><span> '.$data["email_id"].
    '</span></li><a id='.$data["employee_id"].' onclick="replye_click(this.id)" style=position:relative;left:710px;width:70px;bottom:40px; 
    class="btn btn-outline-danger btn-sm" href="./emp_delete.php">Delete</a>';
  
}
mysqli_close($connection);
  ?>
</ul>
</div>
</body>
</html>
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
    <title>Device List</title>
</head>
<body>
    <img style=position:relative;left:670px; src="logoll.jpg" alt="LogoImage" width="200" height="120">
    <div style=position:absolute;top:20px;right:50px; class=" d-flex justify-content-between">
    <a style=margin:5px; class="btn btn-primary btn-sm" href="./add_new_device.php">Add New Device</a>
    <a style=margin:5px; class="btn btn-primary btn-sm" href="dims_home_page.php">Home Page</a>
    <a style=margin:5px; class="btn btn-danger btn-sm" href="./logout.php">Logout</a>
    </div>
    <div  class="container" >
    
    <ul style=width:600px; class="list-group">
    <li class="list-group-item d-flex justify-content-between list-group-item-primary">
        <strong>Device Name</strong> <span><strong>Total Inventory</strong></span><span><strong>Available Inventory</strong></span></li>
        <small style=color:blue;>---------------------------------------------------------------------------------------------------------------------</small>
<script type="text/javascript">
  function reply_click(clicked_id)
  {
    var x = confirm("Press Ok To Confirm Delete");
    if(x==true)
    {
    document.cookie = "deleteDeviceId="+clicked_id;
    }
    else{
      document.cookie = "deleteDeviceId="+0;
    }
    
  }
  function edit_total_inventory(click_id)
  {
    document.cookie = "totalInventoryData="+document.getElementById("editId"+click_id).value;
    document.cookie = "totalInventoryEditId="+click_id;
  }
  
</script>

  <?php 
    require_once 'db_configuration.php';
    $sql = "SELECT * FROM device_data";
    $result = mysqli_query($connection,$sql);
    if(isset($_COOKIE["deleteId"]))
while($data=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
  echo '<li class="list-group-item d-flex justify-content-between align-items-center">'
    . $data["device_name"] .'<h5><span class="badge badge-success badge-pill">'. $data["total_inventory"] .'</span></h5>
    <h5><span class="badge badge-primary badge-pill">'. $data["available_inventory"] .'</span></h5>
    </li><a id='.$data["sno"].' onclick="reply_click(this.id)" style=position:relative;width:70px; 
    class="btn btn-outline-danger btn-sm" href="./device_delete.php">Delete</a>
    <input style=position:relative;width:115px;left:400px;bottom:28px; type="text" id=editId'.$data["sno"].' name="edit" placeholder="Edit Inventory">
    <a id='.$data["sno"].' onclick="edit_total_inventory(this.id)"
    class="devicedelbtn btn btn-dark btn-sm" style=position:relative;width:70px;left:530px;bottom:58px; href="./change_total_inventory.php">Edit</a>';
  
}
mysqli_close($connection);
  ?>
</ul>
</div>

</body>
</html>
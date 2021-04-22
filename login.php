<?php
session_start();
if ( isset( $_SESSION['email_id'] ) ) {
    header( 'location:dims_home_page.php' );
    exit;
}
require_once 'db_configuration.php';

// define variables and set to empty values
$email_idErr = $passcodeErr = '';
$email_id = $passcode = '';
$err = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if ( empty( trim( $_POST['email_id'] ) ) ) {
        $email_idErr = 'Email is required';
    } else {
        
          $email_id = input_cleaner( $_POST['email_id'] );
    }

    if ( empty( trim( $_POST['passcode'] ) ) ) {
        $passcodeErr = 'password is required';
    } else {
        $passcode = input_cleaner( $_POST['passcode'] );
    }

    if ( empty( $email_idErr ) && empty( $passcodeErr ) )
 {
        $sql = "SELECT email_id,passcode FROM admin_login_details where email_id=?";
        $stmt = mysqli_prepare( $connection, $sql );
        if($stmt)
        {
        mysqli_stmt_bind_param($stmt,"s",$param_email_id);
        if(email_validation($email_id))
        {
        $param_email_id = $email_id;
        }
        else{
          $email_idErr = "Please Enter a valid email";
          $err = "";
        }
        if ( mysqli_stmt_execute($stmt) )
          {
            mysqli_stmt_store_result( $stmt );
            if ( mysqli_stmt_num_rows( $stmt ) == 1 ) {
              
                mysqli_stmt_bind_result( $stmt, $email_id, $hashed_passcode );
                if ( mysqli_stmt_fetch( $stmt ) )
                  {
                    $pass = md5($passcode);
                    if ($pass===$hashed_passcode)
                      {
                        
                        echo 'password is correct';
                        session_start();
                        $_SESSION['email_id'] = $email_id;
                        $_SESSION['loggedin'] = true;
                        $_SESSION["filterByData"] = 'Issued';
                        header( 'location:dims_home_page.php' );
                    }
                    else{
                      $err = "Please check your email and password";
                    }
                }
            }
            else{
              $err = "Please check your email and password";
            }
            
        }
    }
    mysqli_stmt_close($stmt);
  }
  mysqli_close($connection);
}

function email_validation($str) { 
  return (!preg_match( 
"^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) 
      ? FALSE : TRUE; 
} 

function input_cleaner( $data ) {
    $data = trim( $data );
    $data = stripslashes( $data );
    $data = htmlspecialchars( $data );
    return $data;
}
?>
<!DOCTYPE html>
<html lang = 'en'>
  <head>
    <meta charset = 'UTF-8'>
    <meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
    <link rel = 'stylesheet' type = 'text/css' href = 'style.css'>
    <link rel = 'stylesheet'
    href = 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'
    integrity = 'sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z'
    crossorigin = 'anonymous'>
    <title>Login DIMS</title>
  </head>
  <body>
    <h3 style = color:gray;text-align:center;margin:20px;>Admin Login Portal</h3>
    <div class = 'container'>
      <div class = 'card'>
        <div class = 'logoimg'><img src = 'logoll.jpg' alt = 'LogoImage' width = '200' height = '120'></div>
        
        <div style=color:red;position:relative;top:60px;><?php echo $err ?></div>
        <form action = '' method = 'post'>
          <div class = 'form-group' style = margin-top:80px;width:400px;>
            <label>Email address</label>
            <input  type = 'email' name = 'email_id' class = 'form-control' placeholder = 'Enter email'>
            <small style = color:red;><?php echo $GLOBALS['email_idErr']; ?></small>
          </div>
          <div class = 'form-group'>
            <label>password</label>
            <input type = 'password' name = 'passcode' class = 'form-control'  placeholder = 'password' >
            <small style = color:red;><?php echo $GLOBALS['passcodeErr'];?></small>
          </div>
          <div class="submitbtn">
          <input type = 'submit' class="btn btn-primary" name = 'submit' value = 'Login'>
</div>
        </form>
      </div>
    </div>
  </body>
</html>
<?php 
        //Initializing the session
        session_start(); 

        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
            header('location: index.php');
            exit();
        }

        require_once "config/db.php";
        $new_password=$confirm_password='';
        $new_password_err=$confirm_password_err='';

        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            // Validating new password
            if(empty(trim($_POST['new_password'])))
            {
                $new_password_err="Please enter your new password";
                echo $new_password_err;
                exit();
            }
            else if(strlen(trim($_POST['new_password']))<8)
            {
                $new_password_err="Password must be at least 8 characters";
                echo $new_password_err;
                exit();
            }
            else{
                $new_password=$_POST['new_password'];
            }

            //Validating Confirm Password 

            if(empty(trim($_POST['confirm_password'])))
            {
                $confirm_password_err= "Please confirm your new password";
                echo $confirm_password_err;
                exit();
            }
            else{
                $confirm_password = $_POST['confirm_password'];
                if($new_password!= $confirm_password && empty($new_password_err))
                {
                    $confirm_password_err="Passwords didn't match";
                    echo $confirm_password_err;
                    exit();
                }
            }

            if(empty($new_password_err) && empty($confirm_password_err))
            {
                $sql= "UPDATE users SET usersPwd = ? where usersID= ? ";
                $stmt= mysqli_prepare($mysql_db,$sql);
                if($stmt)
                {
                    $param_new_password = password_hash($new_password,PASSWORD_DEFAULT);
                    $param_id=$_SESSION["id"];

                    mysqli_stmt_bind_param($stmt,"si",$param_new_password,$param_id);

                    if(mysqli_stmt_execute($stmt))
                    {
                        session_destroy();
                        $success="Password changed successfully";
                        echo $success;
                        header("location: index.php");
                        exit();
                    }
                    else{
                        $err= "Something went wrong";
                        echo $err;
                        exit();
                    }
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($mysql_db);
            }
        }
        

?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device, initial-scale=1">
        <title> </title>
        <link rel="stylesheet" type="text/css" href="forgotpass.css">
    </head>
    <body>
        <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form-wrap">
            <h2>Forgot Password</h2>
            <div class="form-box">
                <input type="password" name="new_password" placeholder="Enter your new password"/><br>
                <input type="password" name="confirm_password" placeholder="Confirm your new password"/><br>
            </div>
            <div class="form-submit"></div>
            <button type="submit" class="submit_button">Reset Password</button>

       </form>
    </div>
</body>



</html>
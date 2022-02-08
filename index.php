<?php
    session_start();
    // check if user is already logged in 
    if(isset($_SESSION['username'])) 
    {
        header("location: home.php");  //if yes redirect them to home page of website
        exit();
    }

    //If not then :-

    require_once "config/db.php";
    $username=$password="";
    $err="";

    //if request method is POST 
    if($_SERVER['REQUEST_METHOD'] == "POST")
{
        if(empty(trim($_POST['name'])) || empty(trim($_POST['password']))) //Check if username and password is empty or not
        {
            $err = "Username or Password cannot be empty";
            echo $err;
            exit();
        }
        else{  //If not then  
            $username = trim($_POST['name']);  // insert into variables
            $password = trim($_POST['password']);
        }
    
    
    if(empty($err))  //If no errors are encountered then 
    {
        $sql = "SELECT usersID, usersName, usersPwd FROM users WHERE usersName = ?";
        $stmt = mysqli_prepare($mysql_db, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        
        
        // Try to execute this statement
        if(mysqli_stmt_execute($stmt)){       //Try to check if username exists in database or not 
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1)
            {
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        if(mysqli_stmt_fetch($stmt))
                        {
                            if(password_verify($password, $hashed_password)) // compare with hashed password 
                            {
                                // this means the password is corrct and username also exists . Allow user to login
                                $status="Active Now";  // Setting the status of user
                                $sql2 = mysqli_query($mysql_db, "UPDATE users SET userStatus = '{$status}' WHERE usersName ='{$username}'");
                                session_start();
                                $_SESSION['status']=$status;
                                $_SESSION["username"] = $username;
                                $_SESSION["id"] = $id;
                                $_SESSION["loggedin"] = true;
    
                                //Redirect user to welcome page
                                header("location: home.php");
                                
                            }
                            else{  
                                $pwd_error="Incorrect Password"; 
                                echo $pwd_error;
                                exit();
                            }
                        }
            }
            else{
                $username_error="Username does not exist";
                echo $username_error;
                exit();
            }
    
        }
    }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kibitz</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="background">
        <div class="main_box">
            <form class="input_grp" id="register" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <input type="text" name="name" class="input" placeholder="Enter username">
                <input type="password" name="password" class="input" placeholder="Password">
                <button type="submit" class="submit_button">Login</button>
            </form>

            <div class="forlogin">
                <p>&nbsp;&nbsp;&nbsp;New user ?&nbsp;</p>
                <a href="signup.php"><p>Sign up</p></a>
                
            </div>

        </div>
    </div>

</body>
</html>
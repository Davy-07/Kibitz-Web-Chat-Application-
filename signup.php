<?php 
        require_once "config/db.php";

        $username = $password = $confirm_password = $email = "";
        $username_err = $password_err = $confirm_password_err =$email_err= "";
        
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
        
            // Check if username is empty
            if(empty(trim($_POST["name"])) || empty(trim($_POST["email"])) ){
                $username_err = "Username or Email cannot be empty";
                echo $username_err;
                exit();
            }
            else{     //Trying to check if username and email already exists 
                $sql = "SELECT usersId FROM users WHERE usersName = ? ";
                $stmt = mysqli_prepare($mysql_db, $sql);
                if($stmt)
                {
                    mysqli_stmt_bind_param($stmt, "s", $param_username);
        
                    // Set the value of param username
                    $param_username = trim($_POST['name']);
                    

        
                    // Try to execute this statement
                    if(mysqli_stmt_execute($stmt)){
                        mysqli_stmt_store_result($stmt);
                        if(mysqli_stmt_num_rows($stmt) == 1)
                        {
                            $username_err = "This username  is already taken";
                            echo $username_err;
                            exit();
                        }
                        else{
                            $username = trim($_POST['name']);
                        }
                    }
                    else{
                        echo "Something went wrong";
                    }
                }
                mysqli_stmt_close($stmt);

                $sql = "SELECT usersId FROM users WHERE usersEmail = ? ";
                $stmt = mysqli_prepare($mysql_db, $sql);
                if($stmt)  //Trying to check if email already exists 
                {
                    mysqli_stmt_bind_param($stmt, "s", $param_email);
        
                    // Set the value of param email
                    $param_email = trim($_POST['email']);
                    

        
                    // Try to execute this statement
                    if(mysqli_stmt_execute($stmt)){
                        mysqli_stmt_store_result($stmt);
                        if(mysqli_stmt_num_rows($stmt) == 1)
                        {
                            $email_err = "This email is already registered";
                            echo $email_err;
                            exit();
                        }
                        else{
                            $email = trim($_POST['email']);
                        }
                    }
                    else{
                        echo "Something went wrong";
                    }
                }
                
            }
            mysqli_stmt_close($stmt);
            
        
        
        // Check for password
        if(empty(trim($_POST['password']))){    // Checking if password field is empty or not
            $password_err = "Password cannot be blank";
            echo $password_err;
            exit();
        }
        elseif(strlen(trim($_POST['password'])) <8){   // Checking if password's length is less than 8 or not 
            $password_err = "Password cannot be less than 8 characters";
            echo $password_err;
            exit();
        }
        else{                                  // if satisfies both the condition above then insert it in variable 
            $password = trim($_POST['password']);
        }
        
        // Check for confirm password field
        if(trim($_POST['password']) !=  trim($_POST['pwdrepeat'])){
            $confirm_password_err = "Passwords should match";
            echo $confirm_password_err;
            exit();
        }
        
        
        // If there were no errors, go ahead and insert into the database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err))
        {
            $sql = "INSERT INTO users (unique_id,usersName, usersEmail, usersPwd) VALUES (?, ?, ?,?)";
            $stmt = mysqli_prepare($mysql_db, $sql);
            if ($stmt)
            {
                $param_unique_id=rand(time(), 100000000);
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                $param_email=$email;

                mysqli_stmt_bind_param($stmt, "ssss", $param_unique_id, $param_username, $param_email, $param_password);
        
               
               
        
                // Try to execute the query
                if (mysqli_stmt_execute($stmt))
                {
                    header("location: index.php");
                }
                else{
                    echo "Something went wrong... cannot redirect!";
                }
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($mysql_db);
        }
        
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <style> * {
    margin: 0;
    padding: 0;
    font-family: sans-serif;
}

.background{
    height: 100%;
    width: 100%;
    background-image: url(backImg2.jpg);
    background-position:center ;
    background-size: cover;
    position: absolute;

}

.main_box{
    width: 400px;
    height: 450px;
    position: absolute;
    top: 10%;
    color: white;
    left: 59%;
    margin: 6% auto;
    background: rgb(0, 0, 0);
    padding: 5px;
    border-radius: 30px;

}   


.input_grp{
    top: 120px;
    width: 280px;
    margin-top: 50px;
    margin-right: auto;
    margin-left: auto;
    line-height: 50px;
}

.input{
    width: 100%;
    padding: 8px 5px;
    margin: 5px 0;
    border-left:  1px solid rgb(177, 18, 240);
    border-right: 1px solid rgb(177, 18, 240);
    border-top: 1px solid rgb(177, 18, 240);
    border-bottom: 1px solid rgb(177, 18, 240);
    border-radius: 30px ;
    outline: none;
    background: transparent;
    color: aliceblue;
}

.submit_button{
    width: 65%;
    padding: 10px 30px;

    cursor:pointer;
    display: block;
    margin-top: 30px;
    margin-left: auto;
    margin-right: auto;
    background-color: #1fd1f9;
    background-image: linear-gradient(315deg, #1fd1f9 0%, #b621fe 74%);    
    border:0;
    color: white;
    outline: none;
    border-radius: 30px;
}

.forlogin{
    display: flex;
    justify-content: center;
    margin: 0 auto;
    margin-top:2em;
}

span {
    color: #777;
    font-size: 12px;
    bottom: 68px;
    position: absolute;
} 
</style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kibitz</title>
</head>
<body>
    <div class="background">
        <div class="main_box">
            <div class="button_box">
                

            <form class="input_grp" id="register" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="post">
                <input type="text" name="name" class="input" placeholder="Name" >
                <input type="email" name="email" class="input" placeholder="Email" >
                <input type="password" name="password" class="input" placeholder="Password" >
                <input type="password" name="pwdrepeat" class="input" placeholder="Confirm Password">
                
                <button type="submit" class="submit_button">Register</button>
            </form>
            <div class="forlogin">
                <p>Already a user?&nbsp;</p>
                <a href="index.php">Login</a>
            </div>
        </div>
    </div>
</body>
</html>
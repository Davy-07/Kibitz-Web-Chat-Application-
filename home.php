<?php
	// Initialize session
	session_start();

	if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== false) {
		header('location: index.php');
		exit;
	}
    require_once 'config/db.php';
    $active_user=$_SESSION['username'];
    $status='Active Now';
    $sql="SELECT * FROM users WHERE usersName!='{$active_user}' AND userStatus ='{$status}' ORDER BY usersID DESC"; 
    $query=mysqli_query($mysql_db,$sql);
    $output="";
    if(mysqli_num_rows($query) == 0)
    {
        $output.="No Users are availabe to chat";
    }
    else{
        while($row=mysqli_fetch_assoc($query))
        {
            $sql2="SELECT * FROM message WHERE (reciever='{$row['usersName']}' 
                    AND sender='{$active_user}') OR ( sender='{$row['usersName']}' 
                    AND reciever='{$active_user}') ORDER BY msg_id DESC LIMIT 1";
            $query2=mysqli_query($mysql_db,$sql2);
            if(mysqli_num_rows($query2)>0)
            {
                $row2=mysqli_fetch_assoc($query2);
                $result=$row2['msg'];
            }
            else{
                $result="No chat available";
            }


            if(strlen($result)>28)
            {
                $msg=substr($result,0,28).'...';
            }
            else{
                $msg=$result;
            }

            if(isset($row2['sender']))
            {
                if($active_user==$row2['sender'])
                {
                    $you="You: ";
                }
                else{
                    $you="";
                }
            }
            else{
                $you="";
            }

            $output.= '<a href="chat.php?user_name='.$row['usersName'].'">
                      <div class="content">
                      <div class="details">
                      <span>'.$row['usersName'].'</span>
                      <p>'.$you. $msg.'</p>
                      </div>
                      </div>'; 
        }  
    }
    
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Kibitz.com</title>
        <link rel="stylesheet" href="home.css">


    </head>
    <body>
        <div class="wrapper">
            <section class="users">
                <header>
                <div class="content">
					
                    <img src="icon.png" alt="*">
                    <div class="details">
                        <span><?php echo $_SESSION['username'];?></span>
                        <p><?php echo $_SESSION['status'];?></p>
                    </div>
                </div> 
                <a href="logout.php" class="logout">Logout</a>
                </header>
                <div class="users-list">
                    <span class="text"><?php echo $output ?></span>
                </div>
            </section>
        </div>
    </body>
</html>
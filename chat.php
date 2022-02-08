<?php 
        session_start();
        require_once "config/db.php";
        if(!isset($_SESSION['username']))
        {
            header("index.php");
        }
        $output='';
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
                // Proccedure to insert the chat in database
                $sender=$_SESSION['username'];
                $reciever=mysqli_real_escape_string($mysql_db,$_POST['incoming_name']);
                $message=mysqli_real_escape_string($mysql_db,$_POST['message']);
                if(!empty($message))
                {
                    $sql="INSERT INTO message (reciever, sender, msg) VALUES ('{$reciever}','{$sender}','{$message}')";
                    $query=mysqli_query($mysql_db,$sql);
                    if($query)
                    {
                        echo "Message inserted successfully";    
                    }
                    else{
                        echo "Something went wrong";
                    }
                }
                else{
                    header("Location: home.php");
                }
        }
        
        //Proccedure to display the messages on screen
        $sender=$_SESSION['username'];
        $reciever=mysqli_real_escape_string($mysql_db,$_GET['user_name']);
        $sql2="SELECT * FROM message LEFT JOIN users ON message.sender= users.usersName 
               WHERE (sender='{$sender}' AND reciever='{$reciever}') OR  (sender='{$reciever}' AND reciever='{$sender}')
               ORDER BY msg_id;";
        $query2=mysqli_query($mysql_db,$sql2);
        if(mysqli_num_rows($query2)>0)
        {
            while($row=mysqli_fetch_array($query2))
            {
                if($row['sender']==$sender)
                {
                    $output.='<div class="outgoing-chats">
                               <div class="outgoing-chats-msg">
                                     <p>'. $row['msg'] .'</p>
                                </div>
                                <div class="outgoing-chats-img">
                                <img src="Icon.png" alt="">
                                </div>
                                </div>';
                }
                else{
                    $output.= '<div class="received-chats">
                                <div class="received-chats-img">
                                    <img src="Icon.png" alt="">
                                </div> 
                                <div class="received-msg">
                                <div class="receieved-msg-inbox">
                                    <p>'.$row['msg'].'</p>
                                </div>
                                </div>
                            </div>';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="chat.css">
</head>
<body>
    <div class="container">
        <div class="msg-head">
            <div class="msg-head-img">
                <img src="Icon.png" >
            </div>
            <div class="name">
            <?php 
                  $user_name = mysqli_real_escape_string($mysql_db,$_GET['user_name']);
                  $sql="SELECT * FROM users WHERE usersName='{$user_name}'";
                  $query=mysqli_query($mysql_db,$sql);
                  if(mysqli_num_rows($query)>0)
                  {
                     
                      $row=mysqli_fetch_assoc($query);
                  }
                  else{
                      echo "Something went wrong";
                      header("location: home.php");
                      exit();
                  }
            ?>
                <h4><?php echo $row['usersName'] ?></h4>
            </div>
        </div>

        <div class="chat-page">
            <div class="msg-inbox">
                <div class="chats">
                    <div class="msg-page">
                    <span class="text"><?php echo $output; ?></span>
                    </div>
                </div>
            </div>
    </div>
    </div> 
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST"> 
    <div class="msg-bottom">
            
            <div class="input-group">
            <input type="text" class="form-control" name="incoming_name" value="<?php echo $user_name; ?>" hidden> 
            <input type="text" class="form-control" name="message" placeholder="type message.......">
                <div class="input-group-append">
                    <span class="input-group-text"><button><i class="fa fa-paper-plane"></i></button></span>
                </div>
            </form>
            </div>
        </div>
    </div>
   
</body>
</html>
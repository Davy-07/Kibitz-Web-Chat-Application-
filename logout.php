<?php
	
	session_start();
	require_once "config/db.php";
    if($_SESSION['username'])
	{
		$status="Offline";
		$sql2 = mysqli_query($mysql_db, "UPDATE users SET userStatus = '{$status}' WHERE usersName ='{$_SESSION['username']}'");
		if($sql2)
		{
			session_destroy();
			header("Location: index.php");
		}
		else{
			echo "Something went wrong.";
		}
	}
?>

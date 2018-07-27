<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
	require('conn.php');
	$errors=array();
	if(empty($_POST['url']))
	{
		$errors['url']='No Friend Choosen.';
	}
	else
	{
    $url=trim($_POST['url']);
	}
	if(empty($_POST['message']))
	{
		$errors['message']='No Friend Choosen.';
	}
	else
	{
    $message=trim($_POST['message']);
	}
	if(empty($_POST['sender']))
	{
		$errors['sender']='Enter Your Email Address.';
	}
	else
	{
    $sender_id=trim($_POST['sender']);
  }
	if(empty($_POST['reciever']))
	{
		$errors['reciever']='Enter Your Date of Birth.';
	}
	else
	{
    $reciever_id=$_POST['reciever'];
	}
	if(empty($errors))
	{
		if(!$conn)
		{
			die("Connection failed" .mysqli_connect_error());
        }
        else{
          $sql="INSERT INTO chats VALUES('','$message','$sender_id','$reciever_id', NOW())";
          if(mysqli_query($conn,$sql))
          {
            echo'hii';
            header('location:'.$url);
          }
		    else
            {
                echo"Error" .$sql ."<br>" . mysqli_error($conn);
            }
		    mysqli_close($conn);
        }		
	}
}			
?>  
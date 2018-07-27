<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!--Import Google Icon Font-->
    <link href="css/icon.css" rel="stylesheet">
    <!--Import Google Materialize CSS-->
    <link rel="stylesheet" href="css/materialize.css">
    <link rel="stylesheet" href="css/style.css">
<?php
session_start();
$email=$_SESSION['email'];
$userid=$_SESSION['userid'];
$username=$_SESSION['username'];
?>
</head>
<body>
<?php 
if($_SERVER['REQUEST_METHOD']=='POST')
{ 
	if(isset($_POST['ans']))
	{
		$answer=trim($_POST['ans']);
		
	require('conn.php');
		if(!$conn)
		{
			die("Connection failed" .mysqli_connect_error());
		}
		
			$sql="SELECT * FROM quest WHERE userid='$userid'";
			$result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0)
			{
				$row=mysqli_fetch_array($result);
			 $answ=$row[2];
			mysqli_close($conn);
			}
		if($answer==$answ)
		{
		$password=substr(hash('sha512',rand()),0,8);
 		$pwd1=$password;
		$pwd=sha1($password);
			
			require('conn.php');
			if(!$conn)
			{
				die("Connection failed" .mysqli_connect_error());
			}
			$sql="UPDATE users SET password='$pwd' WHERE userid='$userid'";
			if(mysqli_query($conn,$sql))
			{echo $pwd1;
					$msg='Your password is <strong style="background-color:#ff0;"> '.$pwd1.'</strong> <br> Don\'t Try Copy Paste , Type manually.	';			
			}		
						
							
			
				mysqli_close($conn);
		}
						
		
	}
}
?>
<div class="form-container">
<?php
if(!empty($msg))
{
	
	echo '<form method="POST" action="login.php">';
}
else
{
echo '
	<form method="POST" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'"> ';
}
?>
	<div class="msg">
	<?php 
	if(isset($msg))
	{
		echo $msg; 
	}
	
?>
	</div>
	<?php
	require('conn.php');
		if(!$conn)
		{
			die("Connection failed" .mysqli_connect_error());
		}
		
			$sql="SELECT * FROM quest WHERE userid='$userid'";
			$result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0)
			{
				$row=mysqli_fetch_array($result);
			 $que=$row[1];
			mysqli_close($conn);
			}
	?>
	<?php
	if(!empty($msg))
	{
		echo '
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">email_circle</i>
                <input type="email" class="validate" name="email" id="email" required  autofocus>
                <label for="email" class="active">Email</label>
            </div>
        </div>';
	echo '
    <div class="row">
        <div class="input-field col s12">
            <i class="material-icons prefix">lockpassword_circle</i>
            <input type="password"  name="password" id="password" required >
            <label for="password" class="active">Password</label>
        </div>
    </div>
	';
	echo'<input type="submit" value="LogIn" name="login" class="btn">';
	}
	else
	{
        echo '
    <div class="row">
    <div class="input-field col s12">
        <i class="material-icons prefix">email_circle</i>
        <input type="text" name="que" id="que" value="'.$que.'" readonly title="Enter Your Security Question." placeholder="Enter Your Security Question." required  />
        <label for="que" class="active">Question</label>
    </div>
    </div>';
		echo '
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">email_circle</i>
                <input type="text" name="ans" id="ans" title="Enter Your Security Answer." autofocus placeholder="Enter Your Security Answer." required />
                <label for="ans" class="active">Answer</label>
            </div>
        </div>';
	echo '
	<input type="submit" class="btn" name="reset_pwd" Value="Reset Password"   />';
	}
	
	?>
	
	</form>

		<a class="register" href="register.php" title="Sign up" >Sign up</a>
		</div>
        
</div>
</body>
</html>
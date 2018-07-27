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
</head>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
	$email=$_POST['email'];
	require('conn.php');
		if(!$conn)
		{
			die("Connection failed" .mysqli_connect_error());
		}
		
			$sql="SELECT * FROM users WHERE email='$email'";
			$result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0)
			{
				$row=mysqli_fetch_array($result);
				 $userid=$row[0];
				 $username=$row[1];
				session_start();
				$_SESSION['email']=$email;
				$_SESSION['userid']=$userid;
				$_SESSION['username']=$username;
				header('location:reset_password.php');
				exit();
				mysqli_close($conn);
			}
			else
			{
				$msg="Account Not found";
			}
}
?>
<body>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
	<div class="msg">
    <?php
    if(!empty($msg)) {
        echo'<p>'.$msg.'</p>';
    }?>
	</div>
    <div class="row">
        <div class="input-field col s12">
            <i class="material-icons prefix">email_circle</i>
            <input type="email" name="email" id="email" title="Enter Your EmailAddress." placeholder="Enter Your Email Address." required autofocus  />
            <label for="email" class="active">Email Address</label>
        </div>
    </div>
	<input type="submit" class="btn" name="chng_pwd" Value="Next"   />
	</form>
</body>
</html>

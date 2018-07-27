<?php
if(isset($_POST['login']))
{   $errors=array();
	if(empty($_POST['email']))
	{
		$errors['name']='Enter Your Email.';
	}
	else
	{
		$email=trim($_POST['email']);
	}
	$email=$_POST['email'];
    $pwd=$_POST['password'];
    $pwd=sha1($pwd);
	require('conn.php');
	if(!$conn)
    {
        die("Connection failed" .mysqli_connect_error());
    }
    else{
        $sql="SELECT * FROM users WHERE email='$email'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            $row=mysqli_fetch_array($result);
            $userid=$row[0];
            $username=$row[1];
            if($email!=$row[2] || $pwd!=$row[3]){
                $errors['incorrect']="Incorrect Email/Password Combination.Please Try again...";
            }
            else{
                session_start();
				$_SESSION['email']=$email;
				$_SESSION['username']=$username;
				$_SESSION['userid']=$userid;
				header('location:welcome.php');
				exit();
            }
        }
        else{
                $errors['notfouund']="No account associated with this email Try Register";
        }
    } 
}	
?>
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
<body>
<div class="navbar-fixed">
    <nav>
    <div class="nav-wrapper black">
        <a href="#!" class="brand-logo"> &nbsp;Chat:Beta</a>
        <div class="right hide-on-med-and-down">
            <div class="input-field inline">
                <i class="material-icons prefix">email_circle</i>
                <input type="email" class="validate" title="Enter Your Email Address" id="email" name="email"  />
                <label for="email">Email Address</label>
            </div>
            <div class="input-field inline">
                <i class="material-icons prefix">lock_circle</i>
                <input type="password" class="validate" title="Enter Your Password" id="password" name="password"  />
                <label for="password">Password</label>
            </div>
            <input type="submit" class="btn" value="Log In" name="login">
        </div>
    </div>
    </nav>
</div>
<div class="row">
    <div class="col s12 l6 offset-l3 ">
        <div class="form-container z-depth-2 _pulse cardpanel white">
            <div class="img-container center">
                <img src="assets/img/avatar.jpeg" width="150px" height="150px" alt="Avatar" class="center circle">
            </div>
            <form action="" method="post">
                
            <?php if(!empty($errors))
                    {
                        echo'
                        <div class="card red error_msg">';
                        foreach($errors as $msg)
                        {
                            echo'<div class="white-text" >'.$msg.'</div>';
                        } 
                        echo'</div>';
                    }
	                ?>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">email_circle</i>
                        <input type="email" class="validate" name="email" id="email" required  autofocus>
                        <label for="email" class="active">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">lockpassword_circle</i>
                        <input type="password"  name="password" id="password" required >
                        <label for="password" class="active">Password</label>
                    </div>
                </div>
                <input type="submit" value="LogIn" name="login" class="btn">
            </form>
            <a href="forgot_password.php" class="align-left">Forgot Password</a>
            <div class="divider"></div>
            <a href="forgot_password.php" class="align-left">Sign Up</a>
        </div>
    </div>
</div>
</body>
</html>

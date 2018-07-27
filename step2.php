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
	
$username=$_SESSION['username'];
$email=$_SESSION['email'];
	
?>
	<?php
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		require('conn.php');
		$errors=array();
		if(empty($_POST['que']))
		{
			$errors['que']='Enter Your Security Question';
		}
		else
		{
			$que=trim($_POST['que']);
		}
		if(empty($_POST['ans']))
		{
			$errors['email']='Enter Your Security Answer.';
		}
		else
		{
			$ans=trim($_POST['ans']);
		}
		if(empty($errors))
		{
		if(!$conn)
		{
			die("Connection failed" .mysqli_connect_error());
		}
		$sql="SELECT * FROM users WHERE email='$email'";
		$result=mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0)
		{
		 $row=mysqli_fetch_array($result);
		 $userid=$row['0'];	
		}
		$sql="INSERT INTO quest VALUES('$userid','$que','$ans', NOW())";
		if(mysqli_query($conn,$sql))
		{
			echo'<p class="success_msg">Account Created Successfully.</p>';
			$fn='';
			$email='';
			$pwd='';
			$gender='';
			$dob='';
			header('location:welcome.php');	
			exit();
		}
		else
		{
			echo"Error" .$sql ."<br>" . mysqli_error($conn);
		}
					
				mysqli_close($conn);
						
		}	
	}
	
	
	?>
</head>
<body>
<div class="navbar-fixed">
    <nav>
    <div class="nav-wrapper black">
        <a href="#!" class="brand-logo"> &nbsp;Chat:Beta</a>
    </div>
    </nav>
</div>

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
            <input type="text" name="que" id="que" title="Enter Your Security Question." placeholder="Enter Your Security Question." required autofocus  />
            <label for="que" class="active">Question</label>
            <span class="helper_text" data-error="Valid" data-success="Invalid">This is used for recovering your account incase you forgot your password.</span>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <i class="material-icons prefix">email_circle</i>
            <input type="text" name="ans" id="ans" title="Enter Your Security Answer." placeholder="Enter Your Security Answer." required />
            <label for="ans" class="active">Answer</label>
        </div>
    </div>
	<input type="submit" class="btn" name="addques" Value="Complete"   />
	</form>
</body>
</html>

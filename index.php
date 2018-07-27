
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
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
	require('conn.php');
	$errors=array();
	if(empty($_POST['fullname']))
	{
		$errors['name']='Enter Your Name.';
	}
	else
	{
		$fn=trim($_POST['fullname']);
	}
	if(empty($_POST['email']))
	{
		$errors['email']='Enter Your Email Address.';
	}
	else
	{
		$email=trim($_POST['email']);
	}
	if(empty($_POST['password']))
	{   
		$errors['pwd']='Enter your Password.';
	}
	else
	{
		$pwd=trim($_POST['password']);
		$pwd=sha1($pwd);
	}
	if(empty($_POST['dob']))
	{
		$errors['dob']='Enter Your Date of Birth.';
	}
	else
	{
		$dob=$_POST['dob'];
	}
	if(empty($_POST['gender']))
	{
		$errors['gender']='Select Your Gender.';
	}
	else
	{
		$gender=$_POST['gender'];
	}
	
	if(empty($errors))
	{
		if(!$conn)
		{
			die("Connection failed" .mysqli_connect_error());
        }
        else{
            $sql="SELECT * FROM users WHERE email='$email'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0)
            {
                $errors['exist']='Email already Registered try <a style=" href="welcome.php">Log In</a>';	
                mysqli_close($conn);
            }
        }
        
	}
	if(empty($errors))
	{
		if(!$conn)
		{
			die("Connection failed" .mysqli_connect_error());
        }
        else{
            $sql="INSERT INTO users VALUES('','$fn','$email','$pwd','$gender','$dob', NOW())";
		    if(mysqli_query($conn,$sql))
		    {
                session_start();
                $_SESSION['email']=$email;
                $_SESSION['username']=$fn;
                header('location:step2.php');
                exit();
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
<div class="navbar-fixed">
    <nav>
    <div class="nav-wrapper black">
        <a href="#!" class="brand-logo"> &nbsp;Chat:Beta</a>
        <div class="right hide-on-med-and-down">
            <form action="login.php" method="post">
            <div class="input-field inline">
                <i class="material-icons prefix">email_circle</i>
                <input type="email" class="validate" title="Enter Your Email Address" id="email" name="email" required />
                <label  class="active" for="email">Email Address</label>
            </div>
            <div class="input-field inline">
                <i class="material-icons prefix">lock_circle</i>
                <input type="password" class="validate" title="Enter Your Password" id="password" name="password" required />
                <label class="active" for="password">Password</label>
            </div>
            <input type="submit" class="btn" value="Log In" name="login">
            </form>
        </div>
    </div>
    </nav>
</div>
<div class="row">
          <div class="col s12 l8">
              Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim rem, ab libero iusto quas veniam explicabo magni culpa eveniet exercitationem cumque optio debitis ullam ex est quisquam at voluptates voluptatum in iste ipsam mollitia nam minus nulla. Quo hic, accusantium minus inventore dolores, culpa eum enim, totam ex repellendus tempora obcaecati delectus. Vero quam temporibus, nostrum autem doloremque inventore aperiam ad cum possimus dolores magni? Rem, beatae! Quo, possimus. Quas nesciunt rerum voluptatum! Ullam eveniet maiores sunt harum doloribus aperiam repellat, expedita tenetur numquam vero saepe accusamus dolor a laboriosam nesciunt voluptatibus sed dignissimos animi quaerat, aliquam nemo. Veniam, atque?
          </div>

          <div class="col s12 l4">
              <div class="form-container">
                  <h3 class="center">  Register</h3>
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
                      <i class="material-icons prefix">account_circle</i>
                      <?php
                      if(empty($_POST['fullname'])){
                      echo'  <input type="text" class="validate" title="Enter Your Full Name" id="fullname" name="fullname" required autofocus >';
                      }
                      else{
                        echo'  <input type="text" class="validate" title="Enter Your Full Name" id="fullname" value="'.$fn.'" name="fullname" required autofocus >';
                      }
                      ?>
                       <label  class="active" for="fullname">Full Name</label>
                  </div>
              <div class="row">
                  <div class="input-field col s12">
                      <i class="material-icons prefix">email_circle</i> <?php
                      if(empty($_POST['email'])){
                      echo'
                      <input type="email" class="validate" title="Enter Your Valid Email Address " id="email" name="email" required >
                      ';
                      }
                      else{
                        echo'
                        <input type="email" class="validate" title="Enter Your Valid Email Address " value="'.$email.'" id="email" name="email" required >';
                      }
                      ?>
                      <label  class="active" for="email">Email</label>
                  </div>
              </div>
              <div class="row">
                  <div class="input-field col s12">
                      <i class="material-icons prefix">lock_circle</i>
                      <input type="password" class="validate" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="password" name="password" required >
                      <label  class="active" for="password">Password</label>
                      <span class="helper_text" data-error="Valid" data-success="Invalid">Password must contain 8 or more characters and have least one number, and one uppercase and lowercase letter</span>
                  </div>
              </div>
              <div class="row">
                  <div class="input-field col s12">
                      <i class="material-icons prefix">calendar_today</i>
                      <?php
                      if(empty($_POST['dob'])){
                      echo'<input type="date" class="validate" title="Enter Your Date of Birth" id="dob" name="dob" required >';
                      }
                      else{
                        echo'<input type="date" class="validate" title="Enter Your Date of Birth" value="'.$dob.'" id="dob" name="dob" required >';
                      }
                      ?>
                      <label class="active"  for="dob">Date of Birth</label>
                  </div>
              </div>
              <div class="row">
                  <div class="center">
                  <input class="with-gap" type="radio" name="gender" id="male" checked ><label for="male" >Male</label>
                  <input class="with-gap" type="radio" name="gender" id="female"><label for="female">Female</label>
                  <input class="with-gap" type="radio" name="gender" id="others"><label for="others">Others</label>
                  </div>
              </div>
              <div class="row">
                  <input type="submit" class="btn center" value="Register">
              </div>
                </form>
            <a href="login.php" class="btn center">Log In</a>
              </div>
          </div>
      </div>
      </div>
      <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script>
    $(".button-collapse").sideNav();
    </script>
    
    <?php
    include('footer.php');
    ?>
</body>
</html>
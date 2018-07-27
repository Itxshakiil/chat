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
session_start();
?>
<body>
    <div class="navbar-fixed">
    <nav>
    <div class="nav-wrapper"><!-- 
      <a href="#!" class="hide-on-med-and-higher left brand-logo"> &nbsp; Logo</a> -->
      <ul class="right ">
      <li>
        <form action="welcome.php" method="get">
        <div class="input-field inline">
            <input type="text" name="search" id="search" title="Search..." placeholder="Search friend..." required />
            <label for="search" class="active">Search</label>
        </div>
        <input class="inline btn" type="submit" value="Search">
        </form></li>
      </ul>
    </div>
    </nav>
    </div>
<div class="container">
      <?php
      if($_SERVER['REQUEST_METHOD']=='GET')
      {
        require('conn.php');
        if(empty($_GET['search']))
        {
          $msg="Please enter Name or Email to Search...";
        }
        else{
          $str=trim($_GET['search']);
          if(!$conn){
            die("Connection failed".mysqli_connect_error());
          }
          else{
            $sql="SELECT * FROM users WHERE email='$str' OR name='$str' ";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0)
            {
              while($row=mysqli_fetch_array($result))
              {
                $username=$row[1];
                $email=$row[2];
                $result_userid=$row[0];
                echo '<div class="result-wrapper"><div class="name">'.$username.'</div><div class="email">'.$email.'</div>';
                echo '<a href="chat.php?friend='.$result_userid.'" class="btn">Click to Chat</a></div>';
                // echo '<a class="black white-text card-panel" a href="chat.php?friend='.$result_userid.'">Name:'.$username.'Email:'.$email.'</a> ';
              }
            }
            else{
              $msg="No Result found Sahi Se type kar be.";
            }
          }
        }
      }
      else{
        $msg='';
      }
      ?>
      <div id="snackbar">
        Welcome <?php  echo $_SESSION['username']; ?>
      </div>
      <?php
        if(!empty($msg)){
          echo '<div class="error">'.$msg.'</div>';
        }
      ?>
    </div>
    
<!-- Fixed Button -->
<div class="fixed-action-btn">
<a href="logout.php"><i class="material-icons btn-floating red btn-large">EXIT</i></a>
</div>
   <!--Import jQuery before materialize.js-->
   <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script>
    $(".button-collapse").sideNav();
    </script>
    
</body>
</html>
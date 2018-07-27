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
    include('url.php');
    $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?friend='.$_GET['friend'];
    session_start();
    if(empty($_SESSION['userid'])){
      header('location:login.php');
    }
    ?>
</head>
<body>    
<div class="navbar-fixed">
    <nav>
    <div class="nav-wrapper">
      <a href="#!" class="brand-logo"> &nbsp; Logo</a>
      <ul class="right hide-on-med-and-down">
        <form action="welcome.php" method="get">
        <li class="input-field inline">
            <input type="text" name="search" id="search" title="Search..." placeholder="Search..." required />
            <label for="search" class="active">Search</label>
        </li>
        <input class="inline btn" type="submit" value="Search">
        <a class="inline" href="logout.php">Log Out</a>
        </form>
    </ul>
    </div>
    </nav>
</div>
<div class="container chat-wrapper">
<div class="chat-container">
<?php
      if($_SERVER['REQUEST_METHOD']=='GET')
      { 
        $userid=$_SESSION['userid'];
        require('conn.php');
        if(empty($_GET['friend']))
        {
          $msg="Please Select friend to Chat.";
        }
        else{
          $friend_id=$_GET['friend'];
          if(!$conn){
            die("Connection failed".mysqli_connect_error());
          }
          else{
              
            $sql2="SELECT * FROM users WHERE userid='$friend_id'";
            $result2=mysqli_query($conn,$sql2);
            if(mysqli_num_rows($result2)>0){
            $row2=mysqli_fetch_array($result2);
            $friend_name=$row2[1];
            echo '<div class="light-blue fixed center white-text"><b>'.$friend_name.'</b></div>';
            }
            $sql="SELECT * FROM chats WHERE sender_id='$userid' AND reciever_id='$friend_id' OR sender_id='$friend_id' AND reciever_id='$userid'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0)
            { 
              while($row=mysqli_fetch_array($result))
              {
                $message=$row[1];
                $time=$row[4];
                $sender=$row[2];
                $reciever=$row[3];
                if($sender==$userid){
                echo '<div class="right card light-blue white-text chat self">'.$message.'<div class="time">'.$time.'</div></div><div class="clearfix"></div><div class="divider"></div>';
                }
                else{
                echo '<div class="left card white-text black chat">'.$message.'<div class="time">'.$time.'</div></div><div class="clearfix"></div><div class="divider"></div>';
                }
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
</div>
    
<form method='post' action="add_msg.php"  id="my_form" name="my_form">
<div id="form-container message-form">
	<div class="form-text">
    <input type="hidden" id="url" name="url" value="<?php echo $url; ?>">
    <input type="hidden" id="sender" name="sender" value="<?php echo $_SESSION['userid']; ?>">
    <input type="hidden" id="reciever" name="reciever" value="<?php echo $friend_id; ?>">
    <textarea class="message" placeholder="Enter Message" name="message"></textarea>
  </div>
    <div class="form-btn">
    	<input type="submit" value="Send" id="send_btn" name="send_btn"/>
    </div>
</div>
</form>
</div><!-- Fixed Button -->
<div class="fixed-action-btn">
<a href="logout.php"><i class="material-icons btn-floating red btn-large">Exit</i></a>
</div>
<!--
<div id="snackbar">
    Welcome <?php  echo $_SESSION['username']; ?>
</div>-->
      <?php
        if(!empty($msg)){
          echo '<div class="error">'.$msg.'</div>';
        }
      ?>
      
    <?php
    include('footer.php');
    ?>
</body>
</html>
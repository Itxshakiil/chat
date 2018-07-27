<?php
      if($_SERVER['REQUEST_METHOD']=='GET')
      { 
        session_start();
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
            echo '<div class="light-blue fixed center white-text">'.$friend_name.'</div>';
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
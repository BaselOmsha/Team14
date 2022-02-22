<?php
  session_start();
  $user=$_SESSION['user'];
  $initials=parse_ini_file("../.ht.asetukset.ini");
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  try{
      $yhteys=mysqli_connect($initials["databaseserver"], $initials["username"], $initials["password"], $initials["database"]);
  }
  catch(Exception $e){
      header("Location:../html/connectionError.html");
      exit;
  }

  $target_dir = "../profilepics/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
  
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          $path_parts = pathinfo($target_file);
          $extension = $path_parts['extension'];
          $username=$_SESSION['user'];
          $newpath="$target_dir$username.$extension";
          rename($target_file, $newpath);
          
          $select= "select * from users where uname='$user'";
          $sql = mysqli_query($yhteys,$select);
          $row = mysqli_fetch_assoc($sql);
          $res= $row['uname'];
          if($res === $user)
          {
              
              $update = "update users set profpic='$newpath' where uname='$user'";
              $sql2=mysqli_query($yhteys,$update);
              header('location:profile.php');
          }
          else
          {
              header('location:profile.php');
          }
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }
  }
?>
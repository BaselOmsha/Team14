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
  
  //Set target directory and target file
  $target_dir = "../profilepics/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  //Save file extension in a variable in lowercase
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  //Check if file is an image
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
      }
  
  //Check if the file is flagged as okay to upload (uploadOk = 1)
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  } else {
      //Move the file
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          //Get path info of the uploaded file and rename file with username (ex. username.jpg)
          $path_parts = pathinfo($target_file);
          $extension = $path_parts['extension'];
          $username=$_SESSION['user'];
          $newpath="$target_dir$username.$extension";
          rename($target_file, $newpath);
          
          //Select current user's row on the users table and update the profile picture path
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
?>
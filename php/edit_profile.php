<?php
 
session_start();
$initials=parse_ini_file("../.ht.asetukset.ini");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try{
    $yhteys=mysqli_connect($initials["databaseserver"], $initials["username"], $initials["password"], $initials["database"]);
}
catch(Exception $e){
    header("Location:../html/connectionError.html");
    exit;
}

if(isset($_POST['edit']))
{
   //Insert values from the form into variables
   $user=$_SESSION['user'];
   $fname=$_POST['fname'];
   $lname=$_POST['lname'];
   $email=$_POST['email'];
   
   //Select current user's row on the users table and update with values inputted in the form
   $select= "select * from users where uname='$user'";
   $sql = mysqli_query($yhteys,$select);
   $row = mysqli_fetch_assoc($sql);
   $res= $row['uname'];
   if($res === $user)
   {
      $update = "update users set fname='$fname',lname='$lname',email='$email' where uname='$user'";
      $sql2=mysqli_query($yhteys,$update);
      header('location:profile.php');
   }
   else
   {
       header('location:profile.php');
   }
}
?>
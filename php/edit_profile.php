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
   $id=$_SESSION['id'];
   $fname=$_POST['fname'];
   $lname=$_POST['lname'];
   $email=$_POST['email'];
   $select= "select * from users where id='$id'";
   $sql = mysqli_query($yhteys,$select);
   $row = mysqli_fetch_assoc($sql);
   $res= $row['id'];
   if($res === $id)
   {
   
      $update = "update users set fname='$fname',lname='$lname',email='$email' where id='$id'";
      $sql2=mysqli_query($yhteys,$update);
if($sql2)
      { 
          header('location:profile.php');
      }
      else
      {
          header('location:profile.php');
      }
   }
   else
   {
       header('location:profile.php');
   }
}
?>
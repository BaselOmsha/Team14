<?php
session_start();
if (!isset($_SESSION["admin"])){
    $_SESSION["returnSite"]="/php/admin.php";
    header("Location:../html/admin_login.html");
    exit;
}
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$initials=parse_ini_file("../.ht.asetukset.ini");
try {
    $connection=mysqli_connect($initials["databaseserver"],
                               $initials["username"],
                               $initials["password"],
                               $initials["database"]
                                );
} catch (Exception $e) {
    header("Location:../html/connectionError.html");
    exit;
}
?>
<?php
    print "<h2 style='font-size:35px'>Welcome, ".$_SESSION["admin"]."!</h2>";
    print "<a style='font-size:30px' href='admin_logout.php'>Log out</a>";
    include "../html/admin_header.html";
?>

 <?php
 //getting result from database
 $print=mysqli_query($connection, "SELECT * FROM users");
 echo "<div class='block'>";
     echo "<table>";
     echo "<tr>";
     echo "<th><h2>ID</h2></th>";
     echo "<th><h2>First Name</h2></th>";
     echo "<th><h2>last Name</h2></th>";
     echo "<th><h2>User Name</h2></th>";
     echo "<th><h2>Email</h2></th>";
     echo "<th><h2>Password</h2></th>";
     echo "<th><h2>Description</h2></th>";
     echo "<th><h2>Delete</h2></th>";
     echo "<th><h2>Edit</h2></th>";
     echo "</tr>";
 while ($row=mysqli_fetch_object($print)) {
    echo "<tr>";
    echo "<td><h3>$row->id</h3></td>";
    echo "<td><h3>$row->fname</h3></td>";
    echo "<td><h3>$row->lname</h3></td>";
    echo "<td><h3>$row->uname</h3></td>";
    echo "<td><h3>$row->email</h3></td>";
    echo "<td><h3>$row->paswd</h3></td>";
    echo "<td><h3>$row->descrip</h3></td>";
    echo "<td><h3><a href='./admin_remove.php?deletable=
            $row->id'>Delete</a></h3></td>";
    echo "<td><h3><a href='./admin_edit.php?editable=
            $row->id'>Edit</a></h3></td>";
    echo "</tr>";
 } 
    echo "</table>";
    echo "</div>";
    mysqli_close($connection);
?>

<?php
    include "../html/admin_footer.html";
?>

<?php
session_start();
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$initials=parse_ini_file("../.ht.asetukset.ini");
try {
    $connection=mysqli_connect($initials["databaseserver"],
        $initials["username"],
        $initials["password"],
        $initials["database"]
        );
} catch (Exception $e) {
    header("Location:../html/yhteysvirhe.html");
    exit;
}
?>
<?php
    include "../html/admin_header.html";
?>
 <?php
 //getting result from database
 $print=mysqli_query($connection, "SELECT * FROM users");
     echo "<table>";
     echo "<tr>";
     echo "<th>ID</th>";
     echo "<th>First Name</th>";
     echo "<th>last Name</th>";
     echo "<th>User Name</th>";
     echo "<th>Email</th>";
     echo "<th>Password</th>";
     echo "<th>Description</th>";
     echo "<th>Delete</th>";
     echo "<th>Edit</th>";
     echo "</tr>";
 while ($row=mysqli_fetch_object($print)) {
    echo "<tr>";
    echo "<td><h2>$row->id</h2></td>";
    echo "<td><h2>$row->fname</h2></td>";
    echo "<td><h2>$row->lname</h2></td>";
    echo "<td><h2>$row->uname</h2></td>";
    echo "<td><h2>$row->email</h2></td>";
    echo "<td><h2>$row->paswd</h2></td>";
    echo "<td><h2>$row->descrip</h2></td>";
    echo "<td><h2><a href='./admin_remove.php?poistettava=
            $row->id'>Delete</a></h2></td>";
    echo "<td><h2><a href='./admin_edit.php?editable=
            $row->id'>Edit</a></h2></td>";
    echo "</tr>";
 } 
    echo "</table>";
    mysqli_close($connection);
?>

<?php
    include "../html/admin_footer.html";
?>
<?php
// new session to save users' info on the server
session_start();
$json = isset($_POST["admin"]) ? $_POST["admin"] : "";
if (!($admin = checkJson($json))) { // if checkjason function returns false print the below
    print "Fill up all the fields";
    exit();
}
// connecting to the database
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
try {
    $initials = parse_ini_file("../.ht.asetukset.ini");
    $connection = mysqli_connect($initials["databaseserver"], $initials["username"], $initials["password"], $initials["database"]);
} catch (Exception $e) {
    header("Location:../html/connectionError.html");
    exit();
}
// select from database user's username and passowrd
$sql = "select * from admin where uname=? and paswd=SHA2(?, 256)";
try {
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $admin->uname, $admin->paswd);
    mysqli_stmt_execute($stmt);
    $print = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_object($print)) { //return the row of result as an object
        $_SESSION["admin"] = "$row->uname"; //show user's username when logged in 
        print $_SESSION["returnSite"];
        exit();
    } else
        print "Invalid username or password!";
    mysqli_close($connection);
    print "Logging in...";
} catch (Exception $e) {
    print "Error";
}
?>
<?php
// if username and/or password are not provided return false
function checkJson($json)
{
    if (empty($json)) {
        return false;
    }
    $admin = json_decode($json, false);
    if (empty($admin->uname) || empty($admin->paswd)
        ) {
        return false;
    }
    return $admin;
}
?>

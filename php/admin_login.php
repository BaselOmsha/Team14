<?php
session_start();
$json = isset($_POST["admin"]) ? $_POST["admin"] : "";
if (!($admin = checkJson($json))) {
    print "Fill up all the fields";
    exit();
}
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
try {
    $initials = parse_ini_file("../.ht.asetukset.ini");
    $connection = mysqli_connect($initials["databaseserver"],
        $initials["username"], $initials["password"], $initials["database"]);
} catch (Exception $e) {
    header("Location:../html/connectionError.html");
    exit();
}
// Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
// joihin laitetaan muuttujien arvoja
$sql="select * from admin where paswd=SHA2(?, 256) and uname=?";
try {
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ss',  $admin->paswd, $admin->uname);
    mysqli_stmt_execute($stmt);
    $print=mysqli_stmt_get_result($stmt);
    if ($row=mysqli_fetch_object($print)){
        $_SESSION["admin"]="$row->uname- $row->fname $row->lname";
        print $_SESSION["returnSite"];
        exit;
    }
    mysqli_close($connection);
    print "Login in...";
} catch (Exception $e) {
    print
    "Error!";
}
?>
<?php
    function checkJson($json)
    {
        if (empty($json)) {
            return false;
        }
        $admin = json_decode($json, false);
        if (
            empty($admin->uname) || empty($admin->paswd)
            ) {
            return false;
        }
        return $admin;
    }
?>

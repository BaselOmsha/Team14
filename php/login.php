<?php 
session_start();
$json=isset($_POST["user"]) ? $_POST["user"] : "";

if (!($user=tarkistaJson($json))){
    print "Fill all forms";
    exit;
}

mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

    $initials=parse_ini_file("../.ht.asetukset.ini");
    try {
        $yhteys=mysqli_connect($initials["databaseserver"],
            $initials["username"],
            $initials["password"],
            $initials["database"]
            );
        
    } catch (Exception $e) {
        header("Location:../html/connectionError.html");
        exit;
    }


$sql="select * from users where uname=? and paswd=SHA2(?, 256)";
try{
    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $user->uname, $user->paswd);
    mysqli_stmt_execute($stmt);
    $tulos=mysqli_stmt_get_result($stmt);
    if ($rivi=mysqli_fetch_object($tulos)){
        $_SESSION["user"]="$rivi->uname";
        print "ok";
        exit;
    }
    
    mysqli_close($yhteys);
    print $json;
}
catch(Exception $e){
    print "Some error!";
}
?>


<?php
function tarkistaJson($json){
    if (empty($json)){
        return false;
    }
    $user=json_decode($json, false);
    if (empty($user->uname) || empty($user->paswd)){
        return false;
    }
    return $user;
}
?>
<?php 


mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$json=isset($_POST["user"]) ? $_POST["user"] : "";

if (!($user=tarkistaJson($json))){
    print "Täytä kaikki kentät";
    exit; 
    
}
session_start();
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


$sql="insert into users(fname, lname, email, paswd, uname) values(?,?,?, SHA2(?, 256),?)";//sama kuin SHA2(?, 0)
try{
    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $user->fname, $user->lname, $user->email, $user->paswd,$user->uname);
    mysqli_stmt_execute($stmt);
    mysqli_close($yhteys);
    print "Rekisteröinti onnistui";
}
catch(Exception $e){
    print "Tunnus jo olemassa tai muu virhe!";
}
?>


<?php
function tarkistaJson($json){
    if (empty($json)){
        return false;
    }
    $user=json_decode($json, false);
    if (empty( $user->fname)|| empty($user->lname) ||empty($user->paswd) ||empty($user->uname)){
        return false;
    }
    return $user;
}
?>



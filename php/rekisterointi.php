
<?php
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$json=isset($_POST["users"]) ? $_POST["users"] : "";

if (!($users=tarkistaJson($json))){
    print "Täytä kaikki kentät";
    exit;
}

try{
    $initials=parse_ini_file("../.ht.asetukset.ini");
    $yhteys=mysqli_connect($initials["databaseserver"],
        $initials["username"],
        $initials["password"],
        $initials["database"]
        );
    
} catch (Exception $e) {
    header("Location:../html/yhteysvirhe.html");
    exit;
}

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
//joihin laitetaan muuttujien arvoja
$sql="insert into users(fname, lname, email, uname, paswd) values(?,?,?,?, SHA2(?, 256))";//sama kuin SHA2(?, 0)
try{
    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $users->fname, $users->lname,  $users->email, $users ->uname, $users->paswd);
    mysqli_stmt_execute($stmt);
    mysqli_close($yhteys);
    print $json;
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
    if (empty($users->fname  || $users->lname ||  $users->email || $users->uname || $users->paswd)){
        return false;
    }
    return $users;
}
?>
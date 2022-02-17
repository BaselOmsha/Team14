
<?php
$initials=parse_ini_file("../.ht.asetukset.ini");
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$json=isset($_POST["users"]) ? $_POST["users"] : "";

if (!($users=tarkistaJson($json))){
    print "Täytä kaikki kentät";
    exit;
}

try{
   
    $yhteys=mysqli_connect($initials["databaseserver"],
        $initials["username"],
        $initials["password"],
        $initials["database"]
        );
    
} catch (Exception $e) {
    header("Location:../html/connectionError.html");
    exit;
}

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
//joihin laitetaan muuttujien arvoja
$sql="insert into users(id, fname, lname, email, paswd, descrip, uname) values(?,?,?, SHA2(?, 256), ?, ?)";//sama kuin SHA2(?, 0)
try{
    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $users->fname, $users->lname,  $users->email, $users->paswd, $users->descrip, $users ->uname, $users ->id);
    mysqli_stmt_execute($stmt);
    mysqli_close($yhteys);
    #print $json;
    print "Thank you for signin up with us!";
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
    $users=json_decode($json, false);
    if (empty($users->fname  || $users->lname ||  $users->email || $users->paswd) ||  $users->uname){
        return false;
    }
    return $users;
}
?>
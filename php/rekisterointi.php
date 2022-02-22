<?php 

mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

//Jos ohjelma saa syötteen "user", annetaan sen arvoksi $json, muussa tapauksessa muuttuja saa arvoksi tyhjän merkkijonon.
$json=isset($_POST["user"]) ? $_POST["user"] : "";

// Jos ohjelma ei ole saanut pyydettyjä tietoja, tulostetaan virheilmoitus ja ohjelman suoritus päättyy.
if (!($user=tarkistaJson($json))){
    print "Please complete all required fields.";
    exit; 
    
}
// Muodostetaan yhteys tietokantaan 
session_start();
$initials=parse_ini_file("../.ht.asetukset.ini");
try {
    $yhteys=mysqli_connect($initials["databaseserver"],
                               $initials["username"],
                               $initials["password"],
                               $initials["database"]
                                );
    
   // Jos yhteyden luominen tietokantaan ei onnistu, siirrytään virheilmoitukseen
} catch (Exception $e) {
    header("Location:../html/connectionError.html");
    exit;
}

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat joihin laitetaan muuttujien arvoja
//Lisätään salasana kryptattuna tietokantaan MYSQL-funktiolla SHA2
$sql="insert into users(fname, lname, email, paswd, uname) values(?,?,?, SHA2(?, 256),?)";
try{
    //Valmistellaan sql-lause
    $stmt=mysqli_prepare($yhteys, $sql);
    //Sijoitetaan muuttujat oikeisiin paikkoihin
    mysqli_stmt_bind_param($stmt, 'sssss', $user->fname, $user->lname, $user->email, $user->paswd,$user->uname);
    //Suoritetaan sql-lause
    mysqli_stmt_execute($stmt);
    //Suljetaan tietokantayhteys
    mysqli_close($yhteys);
    print "Thanks for signing up.";
    
    
}
catch(Exception $e){
    print "Username is already taken.";
}

?>


<?php
//Tarkistaa onko pyydetyt tiedot annettu
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



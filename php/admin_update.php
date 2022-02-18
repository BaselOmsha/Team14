<?php
    $initials=parse_ini_file("../.ht.asetukset.ini");
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    //Luetaan lomakkeelta tulleet tiedot funktiolla $_POST
    //jos syötteet ovat olemassa
    $id=isset($_POST["id"]) ? $_POST["id"] : "";
    $fname=isset($_POST["fname"]) ? $_POST["fname"] : "";
    $lname=isset($_POST["lname"]) ? $_POST["lname"] : "";
    $email=isset($_POST["email"]) ? $_POST["email"] : "";
    $paswd=isset($_POST["paswd"]) ? $_POST["paswd"] : "";
    $descrip=isset($_POST["descrip"]) ? $_POST["descrip"] : "";
    $uname=isset($_POST["uname"]) ? $_POST["uname"] : 0;
    //Jos ei jompaa kumpaa tai kumpaakaan tietoa ole annettu
    //ohjataan pyyntö takaisin lomakkeelle
    if (empty($id) || empty($fname) || empty($lname)
        || empty($paswd) || empty($uname)
        ){
        header("Location:../html/noData.html");
        exit;
    }
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
    try {
    //Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
    //joihin laitetaan muuttujien arvoja
    $sql="update users set fname=?, lname=?,  email=?, 
            paswd=?, descrip=?, uname=? where id=?";
    //Valmistellaan sql-lause
    $stmt=mysqli_prepare($connection, $sql);
    //Sijoitetaan muuttujat oikeisiin paikkoihin
    mysqli_stmt_bind_param($stmt, 'ssssssi', $fname, $lname, 
        $email, $paswd, $descrip, $uname, $id);
    //Suoritetaan sql-lause
    mysqli_stmt_execute($stmt);
    //Suljetaan tietokantayhteys
    mysqli_close($connection);
    header("Refresh:3.5; url=./admin.php");
    include "../html/admin_header.html";
    echo "<div class='sec' style='color: green'>";
    echo "<h1>The profile selected is being updated...</h1><br>";
    echo "<br>";
    echo "<h1>Please wait!</h1>";
    echo "</div>";
    include "../html/admin_footer.html";
     } catch (Exception $e) {
         header("Refresh:3.5; url=./admin.php");
         include "../html/admin_header.html";
         echo "<div class='sec' style='color: red'>";
         echo "<h1>'$uname' Username is already in use!</h1><br>";
         echo "<br>";
         echo "<h1>Taking you back. Please wait...</h1>";
         echo "</div>";
         include "../html/admin_footer.html";
         
     }
?>
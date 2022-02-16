<?php
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    //Luetaan lomakkeelta tulleet tiedot funktiolla $_POST
    //jos syötteet ovat olemassa
    $id=isset($_POST["id"]) ? $_POST["id"] : "";
    $nimi=isset($_POST["nimi"]) ? $_POST["nimi"] : "";
    $sivulkm=isset($_POST["sivulkm"]) ? $_POST["sivulkm"] : 0;
    //Jos ei jompaa kumpaa tai kumpaakaan tietoa ole annettu
    //ohjataan pyyntö takaisin lomakkeelle
    if (empty($id) || empty($nimi) || empty($sivulkm)){
        header("Location:../html/tietuettaeiloydy.html");
        exit;
    }
    try{
        $connection=mysqli_connect("db", "root", "password", "kirjakanta");
    }
    catch(Exception $e){
        header("Location:../html/yhteysvirhe.html");
        exit;
    }
    //Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
    //joihin laitetaan muuttujien arvoja
    $sql="update kirja set nimi=?, sivulkm=? where id=?";
    //Valmistellaan sql-lause
    $stmt=mysqli_prepare($connection, $sql);
    //Sijoitetaan muuttujat oikeisiin paikkoihin
    mysqli_stmt_bind_param($stmt, 'sii', $nimi, $sivulkm, $id);
    //Suoritetaan sql-lause
    mysqli_stmt_execute($stmt);
    //Suljetaan tietokantayhteys
    mysqli_close($connection);
    header("Location:./listakirja.php");
?>
<?php
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$poistettava=isset($_GET["poistettava"]) ? $_GET["poistettava"] : 0;
if (empty($poistettava)) {
    header("Location:./listakirja.php");
    exit;
}
try {
    $connection=mysqli_connect("db", "root",
        "password", "kirjakanta");
} catch (Exception $e) {
    header("Location:../html/yhteysvirhe.html");
    exit;
}
$sql="delete from kirja where id=?";
//Valmistellaan sql-lause
$stmt=mysqli_prepare($connection, $sql);
//Sijoitetaan muuttujat oikeisiin paikkoihin
mysqli_stmt_bind_param($stmt, 'i', $poistettava);
//Suoritetaan sql-lause
mysqli_stmt_execute($stmt);
mysqli_close($connection);
header("Location:./listakirja.php")
?>
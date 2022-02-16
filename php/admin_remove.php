<?php
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    $deletable=isset($_GET["deletable"]) ? $_GET["deletable"] : 0;
    $initials=parse_ini_file("../.ht.asetukset.ini");
    if (empty($deletable)) {
        header("Location:./admin.php");
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
    $sql="delete from users where id=?";
    //Valmistellaan sql-lause
    $stmt=mysqli_prepare($connection, $sql);
    //Sijoitetaan muuttujat oikeisiin paikkoihin
    mysqli_stmt_bind_param($stmt, 'i', $deletable);
    //Suoritetaan sql-lause
    mysqli_stmt_execute($stmt);
    mysqli_close($connection);
    header("Refresh:3; url=./admin.php");
    include "../html/admin_header.html";
    echo "<div class='sec'>";
    echo "<h1>The profile selected is being deleted...</h1><br>";
    echo "<br>";
    echo "<h1>Please wait!</h1>";
    echo "</div>";
    include "../html/admin_footer.html";
?>
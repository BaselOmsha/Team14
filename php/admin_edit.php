<?php
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    $editable = isset($_GET["editable"]) ? $_GET["editable"] : 0;
    if (empty($editable)) {
        header("Location:./listakirja.php");
        exit();
    }
    try {
        $connection = mysqli_connect("db", "root", "password", "kirjakanta");
    } catch (Exception $e) {
        header("Location:../html/yhteysvirhe.html");
        exit();
    }
    $sql = "select * from kirja where id=?";
    // Valmistellaan sql-lause
    $stmt = mysqli_prepare($connection, $sql);
    // Sijoitetaan muuttujat oikeisiin paikkoihin
    mysqli_stmt_bind_param($stmt, 'i', $editable);
    // Suoritetaan sql-lause
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$row = mysqli_fetch_object($result)) {
        header("Location:./listakirja.php");
        exit();
    }
    include "../html/header.html";
?>
    <main class="main">
    	<form method='post' action='./paivita.php'>
    		<h3>ID:</h3>
    		<input type='text' name='id' value='<?php print $row->id;?>' readonly><br>
    		<h3>Nimi:</h3>
    		<input type='text' name='nimi' value='<?php print $row->nimi;?>'><br>
    		<h3>Sivu lkm:</h3>
    		<input type='text' name='sivulkm' value='<?php print $row->sivulkm;?>'><br>
    		<br> <input
    			style='font-size: 20px; background-color: green; width: 100px'
    			type='submit' name='ok' value='OK'><br>
    	</form>
    </main>
<?php
    mysqli_close($connection);
    include "../html/footer.html";
?>

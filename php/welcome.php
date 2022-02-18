<?php
session_start();
if (!isset($_SESSION["user"])){
    header("Location:../html/login.html");
    exit;
}
include "../html/header.html";
print "<h2>Tervetuloa, ".$_SESSION["user"]."!</h2>";
?>
<a href='kirjauduulos.php'>Kirjaudu ulos</a>
<?php
include "../html/footer.html";
?>
<?php
session_start();
if (!isset($_SESSION["admin"])){
    $_SESSION["returnSite"]="/php/adminRenewSession.php";
    header("Location:../html/admin_login.html");
    exit;
}
include "../html/admin_header.html";
print "<main class='main'>";
print "<h2 style='font-size:35px'>You need to signin agian ".$_SESSION["admin"]."!</h2>";
print "<a style='font-size:30px' href='admin_logout.php'>Sign in</a>";
print "</main>";
?>
<?php
    include "../html/admin_footer.html";
?>
<?php
session_start();
unset($_SESSION["admin"]);
unset($_SESSION["returnSite"]);
header("Location:../html/admin_login.html");
?>
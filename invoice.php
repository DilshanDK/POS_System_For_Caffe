<?php
session_start();

if (!isset($_SESSION["userName"]) && $_SESSION["userName"] == $row["uName"]) {
    header("Location:index.php");
}

include("headerAdmin.php");
?>

<?php
include ("foot.php");
?>
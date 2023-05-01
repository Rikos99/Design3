<?php
include ("init.php");
$title="Test Loginu";
include("html_top.phtml");
include("nav.phtml");

var_dump($_SESSION);

echo "<br>ID_U = ".$_SESSION["id"];
echo "<br>loggedin = ".$_SESSION["loggedin"];
echo "<br>nickname = ".$_SESSION["nickname"];
echo "<br>administrator = ".$_SESSION["administrator"];


//TODO Po uvedení stránky do provozu VYMAZAT - TEMPORARY FILE
?>

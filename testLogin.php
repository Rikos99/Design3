<?php
include ("init.php");
$title="Test Loginu";
include("html_top.phtml");
include("nav.phtml");

var_dump($_SESSION);
echo "<br>";
var_dump($_SESSION["administrator"]);
//TODO Po uvedení stránky do provozu VYMAZAT - TEMPORARY FILE
?>

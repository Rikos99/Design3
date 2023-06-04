<?php
include ("init.php");
require ("createPage.php");
$title="Hlavní stránka";
include("html_top.phtml");
/*
tady vložit custom věci do <head>
*/
include("nav.phtml");

echo $unhashedPassword = "rikos99";
echo "<br>".$hashedPassword = password_hash($unhashedPassword, PASSWORD_DEFAULT);





?>

<p>Stránka pro sdílení 3D modelů<br>Work in Progress</p>

<?php
include("html_bottom.phtml");
?>
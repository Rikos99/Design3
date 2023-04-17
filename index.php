<?php
include ("init.php");
$title="Hlavní stránka";
include("html_top.phtml");
/*
tady vložit custom věci do <head>
*/
include("nav.phtml");

?>

<p>Lorem ipsum dolor sit amet</p>
<?php
var_dump($_SESSION);
?>
<!--UZIVATELE -->


<?php
include("html_bottom.phtml");
?>
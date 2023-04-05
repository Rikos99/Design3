<?php
$title="Hlavní stránka";
include("html_top.phtml");
/*
tady vložit custom věci do <head>
*/
include("nav.phtml");

?>

<p>Lorem ipsum dolor sit amet</p>
<?php
$sql = '
    SELECT *
    FROM Uzivatel;
';
$content = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
var_dump($content);
?>
<!--UZIVATELE -->


<?php
include("html_bottom.phtml");
?>
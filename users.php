<?php
include ("init.php");
$title="Uživatelé";
include ("html_top.phtml");
include ("nav.phtml");
echo "<h2>Seznam uživatelů</h2>";
$sql = "
SELECT Nickname
FROM Uzivatel;
";

$uzivatele = $dbconnect -> query($sql) -> fetch_all(MYSQLI_ASSOC);

foreach($uzivatele as $uzivatel)
{
    echo "<a href=users/".$uzivatel["Nickname"].'/mainPage.php>'.$uzivatel["Nickname"]."</a>";
}

?>






<?php
include("html_bottom.phtml");
?>
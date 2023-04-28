<?php
include ("init.php");
$title="Uživatelé";
include ("html_top.phtml");
include ("nav.phtml");

$sql = "
SELECT Nickname
FROM Uzivatel
WHERE Administrator<>1;
";

$uzivatele = $dbconnect -> query($sql) -> fetch_all(MYSQLI_ASSOC);

foreach($uzivatele as $uzivatel)
{
    echo "<a href=users/".$uzivatel["Nickname"].'.php>'.$uzivatel["Nickname"]."</a>";
}

?>






<?php
include("html_bottom.phtml");
?>
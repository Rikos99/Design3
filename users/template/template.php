<?php
include("../../init.php");

$nickname = basename(dirname($_SERVER["PHP_SELF"]));

$title=$nickname;
include("../../html_top.phtml");
include("../../nav.phtml");

$nickname = 'rikos99'; //TODO Po zprovozneni odstranit!!!!
$sql = "
SELECT ProfilePicture
FROM Uzivatel
WHERE Nickname="."'$nickname'";

$uzivatele = $dbconnect -> query($sql) -> fetch_all(MYSQLI_ASSOC);
foreach($uzivatele as $uzivatel)
$uzivatel["ProfilePicture"];

/*
    echo "<img src='/users/default/1.png' alt='Profile Picture'>";
 */
echo "<div>";
echo "<img src='".$uzivatel["ProfilePicture"]."' alt='Profilový obrázek' class='profilePicture'>";
echo $nickname;
echo "</div>";
?>











<?php
include("../../html_bottom.phtml");
?>
<?php
include("../../init.php");

$nickname = basename(dirname($_SERVER["PHP_SELF"]));

$title=$nickname;
include("../../html_top.phtml");
include("../../nav.phtml");

$sql = "
SELECT *
FROM Uzivatel
WHERE Nickname="."'$nickname'";

$uzivatel = $dbconnect -> query($sql) -> fetch_array(MYSQLI_ASSOC);
/*
    echo "<img src='/users/default/1.png' alt='Profile Picture'>";
 */
echo "<div>";
echo "<img src='".$uzivatel["ProfilePicture"]."' alt='Profilový obrázek' class='profilePicture'>";
echo "<br>".$nickname;
echo "<br>".$uzivatel["ProfileDescription"];
echo "</div>";
?>











<?php
include("../../html_bottom.phtml");
?>
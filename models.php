<?php
include ("init.php");
$title="Uživatelé";
include ("html_top.phtml");
include ("nav.phtml");
echo "<h2>Seznam modelů</h2>";
$sql = "
SELECT M.Nazev_Modelu, M.Nazev_Souboru, M.Soubor_Renderu,U.Nickname
FROM Model as M, Uzivatel as U
WHERE M.ID_U = U.ID_U;
";

$modely = $dbconnect -> query($sql) -> fetch_all(MYSQLI_ASSOC);
echo "<ul class='model-ul'>";
foreach($modely as $model) //Vypsani vsech modelů
{
    if(empty($model["Soubor_Renderu"]))
        $cestaKImg = "/users/default/defaultRender.png";
    else
        $cestaKImg = $model["Soubor_Renderu"];
    $cestaKPHP = "/users/".$model["Nickname"]."/models/".$model["Nazev_Modelu"]."/".$model["Nazev_Modelu"].".php";
    $Nickname = $model["Nickname"];


    echo "<li class='model-Li'><a href=".$cestaKPHP.">"."<img height='100' src='".$cestaKImg."'><span class='textInLi'>".$model["Nazev_Modelu"]."</span></a><a href='/users/$Nickname/mainPage.php'><span class='textInLi'>".$Nickname."</span></a></li>";
}
echo "</ul>";
?>






<?php
include("html_bottom.phtml");
?>
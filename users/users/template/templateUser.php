<?php
include("../../init.php");

$nickname = basename(dirname($_SERVER["PHP_SELF"]));

$title=$nickname;
include("../../html_top.phtml");
include("../../nav.phtml");

$sqlUzivatel = "
SELECT U.*
FROM Uzivatel U 
WHERE Nickname='$nickname';";

$uzivatel = $dbconnect -> query($sqlUzivatel) -> fetch_array(MYSQLI_ASSOC);
/*
    echo "<img src='/users/default/1.png' alt='Profile Picture'>";
*/
echo "<div>";
echo "<img src='".$uzivatel["ProfilePicture"]."' alt='Profilový obrázek' class='profilePicture'>";
echo "<br>".$nickname;
echo "<br>".$uzivatel["ProfileDescription"];
echo "</div>";

$sqlModely = "
SELECT M.*,U.Nickname
FROM Model as M, Uzivatel as U
WHERE M.ID_U = U.ID_U AND U.Nickname = '$nickname';
";

$modely = $dbconnect -> query($sqlModely) -> fetch_all(MYSQLI_ASSOC);


echo "<ul class='model-ul'>";
foreach($modely as $model) //Vypsani vsech modelů
{
    if(empty($model["Soubor_Renderu"]))
        $cestaKImg = "/users/default/defaultRender.png";
    else
        $cestaKImg = $model["Soubor_Renderu"];
    $cestaKPHP = "/users/".$model["Nickname"]."/models/".$model["Nazev_Modelu"]."/".$model["Nazev_Modelu"].".php";
    $Nickname = $model["Nickname"];
    $ID_M = $model["ID_M"];


    echo "<li class='model-Li'><a href=".$cestaKPHP.">"."<img height='100' src='".$cestaKImg."'><span class='textInLi'>".$model["Nazev_Modelu"]."</span></a><a href='/users/$Nickname/mainPage.php'><span class='textInLi'>".$Nickname."</span></a>";

    if($_SESSION["id"]==$model["ID_U"] || $_SESSION["administrator"]===1)
    {
        echo "<span class='textInLi'>ID_M: $ID_M</span><br>";

        echo "<form method='post'><input type='hidden' name='deleteModel' value='$ID_M'><input type='submit' value='Smazat model'></form>";

        if(isset($_POST["deleteModel"]))
        {
            $sqlModelDelete = "
            DELETE FROM Model
            WHERE ID_M = '".$_POST["deleteModel"]."';
            ";
            $success = $dbconnect -> query($sqlModelDelete);
        }
        if($success)
        {
            $currentFile = $_SERVER["SCRIPT_NAME"];
            $currentFile = substr($currentFile,1);
            $currentFile = "/".$currentFile;
            header("Location: $currentFile");
        }
    }

    echo "</li>";
}
echo "</ul>";
?>











<?php
include("../../html_bottom.phtml");
?>
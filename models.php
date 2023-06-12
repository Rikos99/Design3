<?php
include ("init.php");
$title="Uživatelé";
include ("html_top.phtml");
include ("nav.phtml");
echo "<h2>Seznam modelů</h2>";
$sql = "
SELECT M.Nazev_Modelu, M.Nazev_Souboru, M.Soubor_Renderu, M.ID_M,U.Nickname
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
    $ID_M = $model["ID_M"];


    echo "<li class='model-Li'><a href=".$cestaKPHP.">"."<img height='100' src='".$cestaKImg."'><span class='textInLi'>".$model["Nazev_Modelu"]."</span></a><a href='/users/$Nickname/mainPage.php'><span class='textInLi'>".$Nickname."</span></a>";

    if($_SESSION["administrator"]===1)
    {
        echo "<span class='textInLi'>ID_M: $ID_M</span><br>";

        echo "<form method='post'><input type='hidden' name='deleteModel' value='$ID_M'><input type='submit' value='Smazat model'></form>";

        if(isset($_POST["deleteModel"]))
        {
            $modelDirectory = "/users/".$model["Nickname"]."/models/".$model["Nazev_Modelu"]."/";

            //deleteFolder($modelDirectory);

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

function deleteFolder($folderPath) {
    if (!is_dir($folderPath)) {
        return;
    }

    $files = glob($folderPath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        } elseif (is_dir($file)) {
            deleteFolder($file);
        }
    }

    rmdir($folderPath);
}

include("html_bottom.phtml");
?>
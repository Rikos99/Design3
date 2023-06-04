<?php
include ("init.php");
include ("notLoggedin.php");
require ("createPage.php");

$ModelNameMaxCharacterSize = 20;
$ModelMaxFileSize = 32 * 1024 * 1024; //Max velikost 32 MB
function clean($string)
{
    $string = str_replace(' ', '-', $string);
    $string = mb_strtolower($string);
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

require("createModel.phtml");

//Nazev Modelu
if(isset($_FILES["Nazev_Souboru"]))
{
    if(strlen($_POST["Nazev_Modelu"]) <= $ModelNameMaxCharacterSize)
    {
        if($_FILES["Nazev_Souboru"]["size"] <= $ModelMaxFileSize)
        {
            if($_FILES["Nazev_Souboru"]["type"]==="model/gltf-binary")
            {
                mkdir("./users/".$_SESSION["nickname"]."/models/".clean($_POST["Nazev_Modelu"]));
                $upload = "./users/".$_SESSION["nickname"]."/models/".clean($_POST["Nazev_Modelu"])."/";
                move_uploaded_file($_FILES["Nazev_Souboru"]["tmp_name"],$upload.$_FILES["Nazev_Souboru"]["name"]);

                $ID_U = $_SESSION["id"];
                $Nazev_Souboru = "/users/".$_SESSION["nickname"]."/models/".clean($_POST["Nazev_Modelu"])."/".$_FILES["Nazev_Souboru"]["name"];
                $Nazev_Modelu = clean($_POST["Nazev_Modelu"]);
                $Popis=NULL;
                if(isset($_POST["Popis"]))
                    $Popis = $_POST["Popis"];

                $SQLModel = "
                    INSERT INTO Model(ID_U, Nazev_Souboru, Nazev_Modelu, Popis)
                    VALUES('$ID_U', '$Nazev_Souboru', '$Nazev_Modelu', '$Popis');
                ";

                $dbconnect -> query($SQLModel);
                echo "<p>Model byl nahrán.</p>";

                $Nazev_Modelu_BezPripony = clean($_POST["Nazev_Modelu"]);

                createModel($_SESSION["nickname"], $Nazev_Modelu_BezPripony);

                echo $modelLINK = "users/".$_SESSION["nickname"]."/models/".basename($_FILES["Nazev_Souboru"]["name"],".glb")."/".basename($_FILES["Nazev_Souboru"]["name"],".glb").".php";
                echo "<a href='".$modelLINK."'>Přejít na model</a>";
            }
            else
                echo "<p>Soubor {$_FILES["Nazev_Souboru"]["name"]} má špatný formát.</p>";
        }
        else
            echo "<p>Soubor {$_FILES["Nazev_Souboru"]["name"]} je moc velký. Maximální povolená velikost je 32 MB.</p>";
    }
    else
        echo "<p>Název modelu je moc dlouhý. Maximální povolená délka je 20 znaků.</p>";
}

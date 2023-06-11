<?php
include ("init.php");
include ("notLoggedin.php");
require ("createPage.php");

$ModelNameMaxCharacterSize = 20;
$ModelMaxFileSize = 32 * 1024 * 1024; //Max velikost modelu - 32 MB
$RenderMaxFileSize = 8 * 1024 * 1024; //Max velikost renderu - 8 MB
$allowedTypesRender = [
    "image/png","image/jpeg"
];

function clean($string)
{
    $string = str_replace(' ', '-', $string);
    $string = mb_strtolower($string);
    $string = str_replace('ě', 'e', $string);
    $string = str_replace('š', 's', $string);
    $string = str_replace('č', 'c', $string);
    $string = str_replace('ř', 'r', $string);
    $string = str_replace('ž', 'z', $string);
    $string = str_replace('ý', 'y', $string);
    $string = str_replace('í', 'i', $string);
    $string = str_replace('é', 'e', $string);
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

require("createModel.phtml");

//Nazev Modelu
if(isset($_FILES["Nazev_Souboru"]) && isset($_FILES["Soubor_Renderu"]))
{
    if(strlen($_POST["Nazev_Modelu"]) <= $ModelNameMaxCharacterSize)
    {
        if($_FILES["Nazev_Souboru"]["size"] <= $ModelMaxFileSize && $_FILES["Soubor_Renderu"]["size"] <= $ModelMaxFileSize)
        {
            if($_FILES["Nazev_Souboru"]["type"]==="model/gltf-binary" && in_array($_FILES["Soubor_Renderu"]["type"], $allowedTypesRender))
            {
                mkdir("./users/".$_SESSION["nickname"]."/models/".clean($_POST["Nazev_Modelu"]));
                $upload = "./users/".$_SESSION["nickname"]."/models/".clean($_POST["Nazev_Modelu"])."/";
                move_uploaded_file($_FILES["Nazev_Souboru"]["tmp_name"],$upload.$_FILES["Nazev_Souboru"]["name"]);
                move_uploaded_file($_FILES["Soubor_Renderu"]["tmp_name"],$upload.$_FILES["Soubor_Renderu"]["name"]);

                $ID_U = $_SESSION["id"];
                $Nazev_Souboru = "/users/".$_SESSION["nickname"]."/models/".clean($_POST["Nazev_Modelu"])."/".$_FILES["Nazev_Souboru"]["name"];
                $Nazev_Modelu = clean($_POST["Nazev_Modelu"]);
                $Soubor_Renderu = "/users/".$_SESSION["nickname"]."/models/".clean($_POST["Nazev_Modelu"])."/".$_FILES["Soubor_Renderu"]["name"];
                $Popis=NULL;
                if(isset($_POST["Popis"]))
                    $Popis = $_POST["Popis"];

                $SQLModel = "
                    INSERT INTO Model(ID_U, Nazev_Souboru, Nazev_Modelu, Soubor_Renderu, Popis)
                    VALUES('$ID_U', '$Nazev_Souboru', '$Nazev_Modelu', '$Soubor_Renderu', '$Popis');
                ";

                $dbconnect -> query($SQLModel);
                echo "<p>Model byl nahrán.</p>";

                $Nazev_Modelu_BezPripony = clean($_POST["Nazev_Modelu"]);

                createModel($_SESSION["nickname"], $Nazev_Modelu_BezPripony);

                echo $modelLINK = "users/".$_SESSION["nickname"]."/models/".$Nazev_Modelu."/".$Nazev_Modelu.".php";
                echo "<a href='".$modelLINK."'>Přejít na model</a>";
            }
            else
                echo "<p>Soubor {$_FILES["Nazev_Souboru"]["name"]} má špatný formát.</p>";
        }
        else
            echo "<p>Soubor {$_FILES["Nazev_Souboru"]["name"]}, {$_FILES["Soubor_Renderu"]["name"]} nebo je moc velký. Maximální povolená velikost je 32 MB a 8 MB.</p>";
    }
    else
        echo "<p>Název modelu je moc dlouhý. Maximální povolená délka je 20 znaků.</p>";
}

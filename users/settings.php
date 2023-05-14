<?php
include("../init.php");

//include ('../notLoggedin.php');
$pocetSouboru = count(scandir("./default/"))-2;
$cestaKPFP="";
$PFPmaxFileSize = 3 * 1024 * 1024; //Max velikost 3 MB
echo $PFPfile = "{$_FILES["uploadPFP"]["name"]}";
echo "<br>upload = " . $upload = "./".$_SESSION["nickname"]."/";
$allowedTypes = [
    "image/png","image/jpeg"
];

//TODO
//Změna PFP

//PODMINKA PRO ZVOLENI JINE MOZNOSTI A UPLOADU -> VYMAZANI $cestaKPFP


//Změna Hesla
echo "<br>".$pocetSouboru;
echo "<br>defaultPFP = ".$_POST["defaultPFP"];
require("settings.phtml");


if(isset($_POST["defaultPFP"]))
{
    if ($_POST["defaultPFP"] != $pocetSouboru)
    {
        $cestaKPFP = "/users/default/" . $_POST["defaultPFP"] . ".png";
    } //PFP Mnou vytvořené
    else //PFP Uploadnuté uživatelem
    {
        if(!file_exists($upload))
        {
            mkdir($upload);
        }



        if(isset($_FILES["uploadPFP"])){
            if($_FILES["uploadPFP"]["size"] <= $PFPmaxFileSize){
                if(in_array($_FILES["uploadPFP"]["type"],$allowedTypes)){
                        echo "Profilový obrázek změněn.";
                        move_uploaded_file($_FILES["uploadPFP"]["tmp_name"],$upload."uploadedPFP.png");
                        $cestaKPFP = "/users/".$_SESSION["nickname"]."/uploadedPFP.png";
                }
                else
                    echo "<p>Soubor {$_FILES["uploadPFP"]["name"]} má špatný formát.</p>";
            }
            else
                echo "<p>Soubor {$_FILES["uploadPFP"]["name"]} je moc velký</p>";



            $sqlPFP = "
        UPDATE Uzivatel
        SET ProfilePicture = '$cestaKPFP'
        WHERE ID_U=".$_SESSION["id"];


            $dbconnect -> query($sqlPFP);
        }
    }
}














$dbconnect -> close();
?>


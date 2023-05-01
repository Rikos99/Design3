<?php
include("../init.php");
//include ('../notLoggedin.php');
$pocetSouboru = count(scandir("./default/"))-2;

$PFPmaxFileSize = 3 * 1024 * 1024; //Max velikost 3 MB
$allowedTypes = [
    "image/png","image/jpeg"
];

//TODO
//Změna PFP
if(isset($_POST["defaultPFP"]))
{
    if ($_POST["defaultPFP"] != $pocetSouboru)
    {
        $cestaKPFP = "/users/default/" . $_POST["defaultPFP"] . ".png";
    } else
    {
        $cestaKPFP = ""; //TODO Dostat cestu k uploadnuté fotce z uploadu
    }
    $sqlPFP = "
        UPDATE Uzivatel
        SET ProfilePicture = '$cestaKPFP'
        WHERE ID_U=".$_SESSION["id"];

    $dbconnect -> query($sqlPFP);
}
//PODMINKA PRO ZVOLENI JINE MOZNOSTI A UPLOADU -> VYMAZANI $cestaKPFP


//Změna Hesla





















require("settings.phtml");
?>













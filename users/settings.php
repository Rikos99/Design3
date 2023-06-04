<?php
include("../init.php");

include ('../notLoggedin.php');
$pocetSouboru = count(scandir("./default/"))-2;
$cestaKPFP="";
$PFPmaxFileSize = 3 * 1024 * 1024; //Max velikost 3 MB
$PFPfile = "{$_FILES["uploadPFP"]["name"]}";
$upload = "./".$_SESSION["nickname"]."/";
$allowedTypes = [
    "image/png","image/jpeg"
];
$maxDescriptionCharacters = 32;
/*
$newPassword = $confirm_newPassword = "";
$newPassword_err = $confirm_newPassword_err = $oldPassword_err= "";
*/

require("settings.phtml");

//Změna popisu na profilu

if(isset($_POST["description"]))
    if(strlen(trim($_POST["description"]))<=$maxDescriptionCharacters)
    {
        $description = $_POST["description"];

        $sqlDescription = "
        UPDATE Uzivatel
        SET ProfileDescription='$description'
        WHERE ID_U=".$_SESSION["id"];

        $dbconnect -> query($sqlDescription);
    }


/*
//Změna Hesla
//TODO Kontrolu hesla vzít z registru!!!!!

if(empty(trim($_POST["newPassword"])))
{
    $newPassword_err = "Prosím zadejte heslo.";
}
elseif(strlen(trim($_POST["newPassword"]))<6)
{
    $newPassword_err = "Heslo musí obsahovat alespoň 6 znaků.";
}
else
{
    echo $newPassword = trim($_POST["newPassword"]);
}

if(empty(trim($_POST["confirm_newPassword"])))
{
    $confirm_newPassword_err = "Prosím zopakujte heslo.";
}
else
{
    echo $confirm_newPassword = trim($_POST["confirm_password"]);
}
if(empty($newPassword_err) && ($newPassword != $confirm_newPassword))
{
    $confirm_newPassword_err = "Hesla se neshodují.";
}
$sqlGetOldPassword = "
    SELECT Password
    FROM Uzivatel
    WHERE ID_U = '".$_SESSION["ID_U"].";';
";

$result = $dbconnect -> query($sqlGetOldPassword);
$oldPasswordSQL = mysqli_fetch_assoc($result);

if(password_hash(trim($_POST["oldPassword"]), PASSWORD_DEFAULT) != $oldPasswordSQL["Password"])
{
    $oldPassword_err = "Staré heslo se neshoduje.";
}

if(empty($newPassword_err) && empty($confirm_newPassword_err) && empty($oldPassword_err))
{
    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $sqlChangePassword = "
    UPDATE Uzivatel
    SET Password = '".$hashedNewPassword."'
    WHERE ID_U = ".$_SESSION["ID_U"].";";

    $dbconnect -> query($sqlChangePassword);
}
*/

//Změna PFP


if(isset($_POST["defaultPFP"]))
{
    if ($_POST["defaultPFP"] != $pocetSouboru) //PFP Mnou vytvořené
    {
        $cestaKPFP = "/users/default/" . $_POST["defaultPFP"] . ".png";
    }
    else //PFP Uploadnuté uživatelem
    {
        //TODO Odstranění předchozí verze PFP kvůli Cache browseru

        if(isset($_FILES["uploadPFP"])){
            if($_FILES["uploadPFP"]["size"] <= $PFPmaxFileSize){
                if(in_array($_FILES["uploadPFP"]["type"],$allowedTypes)){
                        echo "<p>Profilový obrázek byl změněn.</p>";
                        move_uploaded_file($_FILES["uploadPFP"]["tmp_name"],$upload."uploadedPFP.png");
                        $cestaKPFP = "/users/".$_SESSION["nickname"]."/uploadedPFP.png";
                }
                else
                    echo "<p>Soubor {$_FILES["uploadPFP"]["name"]} má špatný formát.</p>";
            }
            else
                echo "<p>Soubor {$_FILES["uploadPFP"]["name"]} je moc velký</p>";
        }
    }
    $sqlPFP = "
        UPDATE Uzivatel
        SET ProfilePicture = '$cestaKPFP'
        WHERE ID_U=".$_SESSION["id"];


    $dbconnect -> query($sqlPFP);
}














$dbconnect -> close();
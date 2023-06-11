<?php
include ("init.php");
$title="Uživatelé";
include ("html_top.phtml");
include ("nav.phtml");
echo "<h2>Seznam uživatelů</h2>";
$sql = "
SELECT ID_U, Nickname, Administrator
FROM Uzivatel;
";

$uzivatele = $dbconnect -> query($sql) -> fetch_all(MYSQLI_ASSOC);

echo "<ul>";
foreach($uzivatele as $uzivatel)
{
    $ID_U = $uzivatel["ID_U"];
    echo "<li><a href=users/".$uzivatel["Nickname"].'/mainPage.php>';
    echo $uzivatel["Nickname"]."</a><br>";
    if($_SESSION["administrator"]===1)
    {
        echo "ID_U: $ID_U<br>";
        echo "Administrator: ".$uzivatel['Administrator']."<br>";

        if($uzivatel["Administrator"]==="0")
            echo "<form method='post'><input type='hidden' name='makeAdministrator' value='$ID_U'><input type='submit' value='Administrátor'></form>";
        elseif($uzivatel["Administrator"]==="1")
            echo "<form method='post'><input type='hidden' name='makeUser' value='$ID_U'><input type='submit' value='Uživatel'></form>";
        echo "<form method='post'><input type='hidden' name='deleteUser' value='$ID_U'><input type='submit' value='Smazat uživatele'></form>";

        if(isset($_POST["makeAdministrator"]))
        {
            $sqlUserToAdministrator = "
                UPDATE Uzivatel
                SET Administrator = 1
                WHERE ID_U = '".$_POST["makeAdministrator"]."';
            ";
            $success = $dbconnect -> query($sqlUserToAdministrator);
        }
        if(isset($_POST["makeUser"]))
        {
            $sqlUserToUser = "
                UPDATE Uzivatel
                SET Administrator = 0
                WHERE ID_U = '".$_POST["makeUser"]."';
            ";
            $success = $dbconnect -> query($sqlUserToUser);
        }
        if(isset($_POST["deleteUser"]))
        {
            $sqlUserDelete = "
            DELETE FROM Uzivatel
            WHERE ID_U = '".$_POST["deleteUser"]."';
            ";
            $success = $dbconnect -> query($sqlUserDelete);
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
echo "<ul>";





?>






<?php
include("html_bottom.phtml");
?>
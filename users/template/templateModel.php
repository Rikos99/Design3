<?php
$title = basename(dirname($_SERVER["PHP_SELF"]));
include("../../../../init.php");
include("../../../../html_top.phtml");
?>
<style>
    model-viewer {
        width: 75vw;
        height: 25vw;
        border: 1px solid black;
    }
</style>
<?php
include("../../../../nav.phtml");
$NazevModelu = $title;

$sqlModel = "
    SELECT M.*, U.Nickname, U.ProfilePicture, U.ID_U
    FROM Model M, Uzivatel U 
    WHERE U.ID_U = M.ID_U AND M.Nazev_Modelu ='$NazevModelu'
";
$model = $dbconnect -> query($sqlModel) -> fetch_array(MYSQLI_ASSOC);
echo "<h2>$NazevModelu</h2>";
echo "<p>Vytvořil: <a href='/users/".$model["Nickname"]."/mainPage.php'>".$model["Nickname"]."</a></p>";
?>
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.1.1/model-viewer.min.js"></script>
<model-viewer alt="Model" src="<?=$model['Nazev_Souboru']?>" ar environment-image="/users/default/default.hdr" shadow-intensity="1" camera-controls touch-action="pan-y"></model-viewer>

<?php
$ID_M = $model["ID_M"];
$ID_U = $_SESSION["id"];
echo "<p> Popis modelu:<br>".$model['Popis']."</p>";
if(!empty($model["Soubor_Renderu"]))
    echo "<img class='renderModelu' src='".$model['Soubor_Renderu']."'>";
?>
<h2>Hodnocení</h2>
<?php
if($_SESSION["loggedin"]) {
    $sqlHodnoceniUzivatele = "
    SELECT Pocet_Hvezd
    FROM Hodnoceni
    WHERE ID_U = $ID_U AND ID_M = $ID_M;
";

$hodnoceniUzivatele = $dbconnect -> query($sqlHodnoceniUzivatele) -> fetch_assoc();



if(empty($hodnoceniUzivatele["Pocet_Hvezd"]))
    $existuje = 0;
else
    $existuje = 1;

if($existuje===0)
    echo "<h3>Přidat hodnocení</h3>";
else
    echo "<h3>Upravit hodnocení</h3>";
for($i=1;$i<=5;$i++)
{
    echo "<a href='?funkce$i'><img src='/images/star.png'></a>";
}
}
$sqlHodnoceni = "
    SELECT AVG(Pocet_Hvezd) as Hodnoceni
    FROM Hodnoceni
    WHERE ID_M = $ID_M;
";

$hodnoceniResult = $dbconnect -> query($sqlHodnoceni);
$hodnoceni = mysqli_fetch_assoc($hodnoceniResult);

if($_SESSION["loggedin"])
    echo "<br><br>";

if(empty($hodnoceni["Hodnoceni"]))
    echo "-";
else
    echo $hodnoceni["Hodnoceni"]*20;
echo "%";

?>





<h2>Komentáře</h2>
<?php
if($_SESSION["loggedin"])
{
    echo '<form class="Komentar" method="post">
              <label for="Komentar"><h3>Přidat komentář</h3></label><br>
              <input type="text" name="Komentar" id="komentar"><br>
              <input type="submit" value="Přidat komentář">
          </form>';

    if(isset($_POST["Komentar"])) {
        $Komentar = $_POST["Komentar"];

        $sqlPridatKomentar = "
            INSERT INTO Komentar(ID_M, ID_U, Komentar)
            VALUES('$ID_M','$ID_U','$Komentar');
        ";
        $dbconnect -> query($sqlPridatKomentar);
    }
}
$sqlKomentare = "
    SELECT K.*, U.Nickname
    FROM Komentar K, Uzivatel U
    WHERE K.ID_M = $ID_M AND K.ID_U = U.ID_U
    ORDER BY ID_K DESC;
";

$komentare = $dbconnect -> query($sqlKomentare) -> fetch_all(MYSQLI_ASSOC);


echo "<ul class='komentare-ul'>";
foreach ($komentare as $komentar)
{
    echo "<li>";
    $Nickname = $komentar["Nickname"];
    $KomentarContent = $komentar["Komentar"];

    echo "<a href='/users/$Nickname/mainPage.php'>".$Nickname."</a><br>";
    echo "<span class='komentarContent'>".$KomentarContent."</span>";
    echo "</li>";
}
echo "</ul>";



if(isset($_GET["funkce1"]))
    hodnoceni(1,$existuje, $ID_M, $ID_U, $dbconnect);
if(isset($_GET["funkce2"]))
    hodnoceni(2,$existuje, $ID_M, $ID_U, $dbconnect);
if(isset($_GET["funkce3"]))
    hodnoceni(3,$existuje, $ID_M, $ID_U, $dbconnect);
if(isset($_GET["funkce4"]))
    hodnoceni(4,$existuje, $ID_M, $ID_U, $dbconnect);
if(isset($_GET["funkce5"]))
    hodnoceni(5,$existuje, $ID_M, $ID_U, $dbconnect);
function hodnoceni($pocetHvezd, $existuje, $ID_M, $ID_U, $dbconnect)
{
    if ($existuje===1) {
        $sql = "
            UPDATE Hodnoceni
            SET Pocet_Hvezd = $pocetHvezd
            WHERE ID_M = $ID_M AND ID_U = $ID_U
        ";
    }
    elseif($existuje===0) {
        $sql = "
            INSERT INTO Hodnoceni(ID_M, ID_U, Pocet_Hvezd)
            VALUES('$ID_M','$ID_U','$pocetHvezd');
        ";
    }
    $dbconnect -> query($sql);
    $currentFile = $_SERVER["SCRIPT_NAME"];
    $currentFile = substr($currentFile,1);
    $currentFile = "/".$currentFile;
    header("Location: $currentFile");

}


include("../../../../html_bottom.phtml");
?>

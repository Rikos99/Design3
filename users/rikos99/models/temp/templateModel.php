<?php
//$title = basename(dirname($_SERVER["PHP_SELF"]));
$title = "pickaxe";
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

$sql = "
    SELECT M.*, U.Nickname, U.ProfilePicture
    FROM Model as M, Uzivatel as U 
    WHERE U.ID_U = M.ID_U AND M.Nazev_Modelu ='$NazevModelu'
";
$model = $dbconnect -> query($sql) -> fetch_array(MYSQLI_ASSOC);
echo "<h2>$NazevModelu</h2>";
echo "<p>Vytvořil: <a href='/users/".$model["Nickname"]."/mainPage.php'>".$model["Nickname"]."</a></p>";
?>
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.1.1/model-viewer.min.js"></script>
<model-viewer alt="Model" src="<?=$model['Nazev_Souboru']?>" ar environment-image="/users/default/default.hdr" shadow-intensity="1" camera-controls touch-action="pan-y"></model-viewer>

<?php
    echo "<p> Popis modelu:<br>".$model['Popis']."</p>";



include("../../../../html_bottom.phtml");
?>

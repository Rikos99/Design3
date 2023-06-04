<?php
$title = basename(dirname($_SERVER["PHP_SELF"]));
include("../../init.php");
include("../../html_top.phtml");
?>
<style>
    model-viewer {
        width: 75vw;
        height: 25vw;
        border: 1px solid black;
    }
</style>
<?php
include("../../nav.phtml");
$NazevModelu = "Pickaxe";
echo "<h2>$NazevModelu</h2>"
?>
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.1.1/model-viewer.min.js"></script>
<model-viewer alt="Model" src="/users/rikos99/models/pickaxe/pickaxe.glb" ar environment-image="/users/default/default.hdr" shadow-intensity="1" camera-controls touch-action="pan-y"></model-viewer>


<?php
include("../../html_bottom.phtml");
?>

<?php
include ("init.php");
function createPage($nickname)
{

    $file = fopen("./users/$nickname/$nickname.php","w");

    $filePath = "./users/template.txt";
    $template = file_get_contents($filePath,1);

    fwrite($file,$template);
    fclose($file);

    header("location:users/$nickname/mainPage.php");
}
?>
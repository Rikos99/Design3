<?php
function createPage($nickname)
{
    mkdir("./users/".$nickname, 0777, true);

    $file = fopen("./users/".$nickname."/"."mainPage.php","w");


    $filePath = "./users/template/template.txt";
    $template = file_get_contents($filePath);


    fwrite($file,$template);
    fclose($file);
}

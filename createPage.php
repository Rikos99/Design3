<?php
function createPage($nickname)
{
    mkdir("./users/".$nickname."/models", 0777, true);

    $file = fopen("./users/".$nickname."/"."mainPage.php","w");

    $filePath = "./users/template/templateUser.txt";
    $template = file_get_contents($filePath);

    fwrite($file,$template);
    fclose($file);
}
function createModel($nickname,$modelName)
{
    $file = fopen("./users/".$nickname."/models/".$modelName."/".$modelName.".php", "w");

    $filePath = "./users/template/templateModel.txt";
    $template = file_get_contents($filePath);

    fwrite($file, $template);
    fclose($file);
}
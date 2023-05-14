<?php
if($_SESSION["loggedin"]!=true)
{
    header("Location: /index.php");
    exit();
}

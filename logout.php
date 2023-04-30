<?php
session_start();
$_SESSION["loggedin"]=false;
$_SESSION["id"]=NULL;
$_SESSION["nickname"]=NULL;
$_SESSION["administrator"]=NULL;
header("Location: index.php");
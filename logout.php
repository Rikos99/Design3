<?php
session_start();
$_SESSION["loggedin"]=false;
$_SESSION["id"]=NULL;
$_SESSION["nickname"]=NULL;
header("Location: index.php");
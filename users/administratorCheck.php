<?php
/*
$sqlAdministrator = '
    SELECT Administrator
    FROM Uzivatel
    WHERE ID_U='.$_SESSION["id"];

$result = mysqli_query($dbconnect, $sqlAdministrator);
$administrator = mysqli_fetch_assoc($result);
foreach($administrator as $admin)
    echo $admin;
*/
echo $_SESSION["administrator"];
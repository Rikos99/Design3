<?php
include ("init.php");
$title="Register";
include ("html_top.phtml");
include ("nav.phtml");
/*
if($dbconnect)
{
    echo 'connected';
}
else
{
    echo 'not connected';
}
*/ //Test připojení

$nickname = $password = $confirm_password = "";
$nickname_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(empty(trim($_POST["nickname"])))
    {
        $nickname_err="Prosím zadejte přezdívku.";
    }
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/',trim($_POST["nickname"])))
    {
        $nickname_err = "Přezdívka může obsahovat jen písmena, čísla a podtržítka.";
    }
    else
    {
        $sql="
        SELECT ID_U
        FROM Uzivatel
        WHERE Nickname = ?
        ";
        if($stmt=mysqli_prepare($dbconnect,$sql))
        {
            mysqli_stmt_bind_param($stmt, "s", $param_nickname);

            $param_nickname = trim($_POST["nickname"]);

            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt)==1)
                    $nickname_err= "Tato přezdívka již existuje.";
                else
                    $nickname = trim($_POST["nickname"]);
            }
            else
            {
                echo "Ups! Něco se pokazilo. Zkuste prosím znovu později.";
            }

        mysqli_stmt_close($stmt);
        }
    }

if(empty(trim($_POST["password"])))
{
    $password_err = "Prosím zadejte heslo.";
}
elseif(strlen(trim($_POST["password"]))<6)
{
    $password_err = "Heslo musí obsahovat alespoň 6 znaků.";
}
else
{
    $password = trim($_POST["password"]);
}

if(empty(trim($_POST["confirm_password"])))
{
    $confirm_password_err = "Please confirm password.";
}
else
{
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password))
    {
        $confirm_password_err = "Hesla se neshodují.";
    }
}

if(empty($nickname_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "
        INSERT INTO Uzivatel (Nickname,Password,Administrator)
        VALUES (?,?,0);
    ";

    if($stmt=mysqli_prepare($dbconnect,$sql))
    {
        mysqli_stmt_bind_param($stmt,"ss",$param_nickname,$param_password);



        $param_nickname = $nickname;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        if(mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else
        {
            echo "Ups! Něco se pokazilo. Zkuste prosím znovu později.";
        }
        mysqli_stmt_close();

    }
    mysqli_close($dbconnect);
    }
}

require ("register.phtml");
?>

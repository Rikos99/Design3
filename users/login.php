<?php
include ("init.php");

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
{
    header("location: index.php");
    exit;
}
$nickname = $password = $administrator = "";
$nickname_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"]=="POST")
{
        if(empty(trim($_POST["nickname"])))
        {
            $nickname_err="Prosím, zadejte přezdívku.";
        }
        else
        {
            $nickname=trim($_POST["nickname"]);
        }


    if(empty(trim($_POST["password"])))
    {
        $password_err="Prosím, zadejte heslo.";
    }
    else
    {
        $password=trim($_POST["password"]);
    }

    if(empty($nickname_err)&&empty($password_err))
    {
        $sql = "
        SELECT ID_U,Nickname,Password,Administrator
        FROM Uzivatel
        WHERE Nickname=?;
        ";
        if($stmt=mysqli_prepare($dbconnect,$sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_nickname);

            $param_nickname = $nickname;

            if (mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt)==1)
                {
                    mysqli_stmt_bind_result($stmt,$id,$username,$hashed_password,$administrator);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password,$hashed_password))
                        {
                            session_start();

                            $_SESSION["loggedin"]=true;
                            $_SESSION["id"]=$id;
                            $_SESSION["nickname"]=$nickname;
                            $_SESSION["administrator"]=$administrator;

                            header("location: index.php");
                            exit();
                        }
                        else
                        {
                            $login_err="Neplatná přezdívka, nebo heslo.";
                        }
                    }
                }
                else
                {
                    $login_err="Neplatná přezdívka, nebo heslo.";
                }
            }
            else
            {
                echo "Ups! Něco se pokazilo. Zkuste prosím znovu později.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($dbconnect);
}
require("login.phtml");
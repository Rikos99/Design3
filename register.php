<?php
include ("init.php");
require("createPage.php");

 //Test připojení

$nickname = $password = $email = $confirm_password = "";
$nickname_err = $password_err = $email_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"]=="POST")
{
/*

    KONTROLA PREZDIVKY

*/
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

/*

    KONTROLA EMAILU

*/

    if(empty(trim($_POST["email"])))
    {
        $email_err="Prosím zadejte E-Mail.";
    }
    /*
    elseif(filter_var(trim($_POST["email"],FILTER_VALIDATE_EMAIL)))
    {
        $email_err="Prosím zadejte validní E-Mail.";
    }
    */
    else
    {
        $email=trim($_POST["email"]);
    }


/*

    KONTROLA HESLA

*/
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
        $confirm_password_err = "Prosím zopakujte heslo.";
    }
    else
    {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password))
        {
            $confirm_password_err = "Hesla se neshodují.";
        }
    }

    if(empty($nickname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err))
    {
        $sql = "
            INSERT INTO Uzivatel(Nickname,Email,Password,Administrator)
            VALUES (?, ?, ?, 0)
        ";

        createPage($nickname); //Vytvoreni stranky uzivateli

        if($stmt=mysqli_prepare($dbconnect,$sql))
        {

            $param_nickname = $nickname;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt,"sss",$param_nickname, $param_email, $param_password);

            if(mysqli_stmt_execute($stmt))
            {
                header("location: login.php");
                exit();
            }
            else
            {
                echo "Ups! Něco se pokazilo. Zkuste prosím znovu později.";
            }
            mysqli_stmt_close($stmt);

        }
    mysqli_close($dbconnect);
    }
}

require ("register.phtml");
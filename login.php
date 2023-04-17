<?php
session_start();

$title="Login";
include ("html_top.phtml");
include ("nav.phtml");






function login($dbconnect, $udajeUzivatele)
{
    $hashHesla = sha1($udajeUzivatele["heslo"]);
    $sql = "
        SELECT *
        FROM Uzivatel
        WHERE login = '{$udajeUzivatele["login"]}' 
          AND heslo = '$hashHesla';
    ";
    $vysledek = mysqli_query($dbconnect,$sql);
    $uzivatel = mysqli_fetch_assoc($vysledek);
    if($uzivatel)
    {
        $_SESSION["uzivatel"] = $uzivatel;
        return 1;
    }
    return 0;
}
if(isset($_POST["login"]))
{
    if(login($dbconnect,$_POST))
    {
        header("Location: index.php");
        exit;
    }
}
else
{
    echo "<p>Přihlášení bylo neúspěšné</p>";
}

?>
<form id="login">
    <label for="nickname">Přezdívka</label><br><input type="text" name="nickname" id="username" placeholder="Přezdívka" required><br>
    <label for="password">Heslo</label><br><input type="password" name="password" id="password" placeholder="Heslo" required><br>
    <input type="submit" value="Přihlásit se">
</form>

<p>Nemáte ještě účet? <a href="register.php">Registrujte se</a></p>

<?php
include("html_bottom.phtml");
?>

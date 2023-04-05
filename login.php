<?php
ob_start();
session_start();

$title="Login";
include ("html_top.phtml");
include ("nav.phtml");

?>
<form id="login">
    <label for="email">E-Mail</label><br><input type="text" name="email" id="email" placeholder="E-Mail" required><br>
    <label for="password">Heslo</label><br><input type="password" name="password" id="password" placeholder="Heslo" required><br>
    <input type="submit" value="Přihlásit se">
</form>

<p>Nemáte ještě účet? <a href="register.php">Registrujte se</a></p>

<?php
function login($dbconnect, $udajeUzivatele)
{

}


include("html_bottom.phtml");
?>

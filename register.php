<?php
$title="Register";
include ("html_top.phtml");
include ("nav.phtml");
?>
    <form id="register">
        <label for="nickname">Přezdívka</label><br><input type="text" name="nickname" id="nickname" placeholder="Přezdívka" required><br>
        <label for="email">E-Mail</label><br><input type="text" name="email" id="email" placeholder="E-Mail" required><br>
        <label for="password">Heslo</label><br><input type="password" name="password" id="password" placeholder="Heslo" required><br>
        <label for="password2">Opakovat heslo</label><br><input type="password" name="password2" id="password2" placeholder="Opakovat heslo" required>
        <input type="submit" value="Registrovat se">
    </form>

    <p>Již máte účet? <a href="login.php">Přihlásit se</a></p>
<?php

function register($dbconnect, $udajeUzivatele)
{

}


include("html_bottom.phtml");
?>
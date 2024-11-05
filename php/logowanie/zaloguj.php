<?php
$login = null;
$pass = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
	$sql = "SELECT role,imie,nazwisko,uzytkownik_id FROM uzytkownicy WHERE login='". $login ."' AND haslo='".$pass."';";
	$idd = mysqli_query($idp,$sql);
	$user = mysqli_fetch_assoc($idd);
	mysqli_close($idp);
	if ($user) {
		$_SESSION['login'] = $user['imie'] . " " . $user['nazwisko'];
		$_SESSION['id'] = $user['uzytkownik_id'];
		$_SESSION['start_sesji'] = time();
		$_SESSION['is_admin'] = (bool)($user['role'] == "admin");
		header("Location:../../index.php");
        exit();
	} else{
		echo "Nie istnieje taki użytkownik.";
		NoLogin();
	}
} else{
	NoLogin();
}
function NoLogin() {
	global $user, $pass;
	echo '<form action="login.php" method="POST">
                <label>Login</label>
                <input type="text" name="login" id="login" value="'.(($user != null)?$user:'').'" required>
                <label>Hasło</label>
                <input type="password" name="pass" id="pass" value="'.(($pass != null)?$pass:'').'" required>
                <input type="submit" value="Zaloguj">
            </form>';
}

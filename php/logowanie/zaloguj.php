<?php
$user = null;
$pass = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user = $_POST['login'];
	$pass = $_POST['pass'];
	$idp = mysqli_connect("localhost","website","mySmGZ@04d5*J85o","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
	$idd = mysqli_query($idp,"SELECT * FROM uzytkownicy WHERE Login='". $user ."' AND Haslo='".$pass."';");
	$user = mysqli_fetch_assoc($idd);
	mysqli_close($idp);
	if ($user) {
		$_SESSION['login'] = $user['Login'];
		$_SESSION['start_sesji'] = time();
		$_SESSION['is_admin'] = $user['isAdmin'];
		header("Location:../../index.php");
	} else{
		echo "Nie istnieje taki użytkownik.";
		NoLogin();
	}
} else{
	NoLogin();
}
function NoLogin() {
	global $user;
	global $pass;
	echo '<form action="login.php" method="POST">
                <label>Login</label>
                <input type="text" name="login" id="login" value="'.(($user != null)?$user:'').'" required>
                <label>Hasło</label>
                <input type="password" name="pass" id="pass" value="'.(($pass != null)?$pass:'').'" required>
                <input type="submit" value="Zaloguj">
            </form>';
}

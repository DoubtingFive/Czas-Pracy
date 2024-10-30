<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$idp = mysqli_connect("localhost","website","mySmGZ@04d5*J85o","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
	$idd = mysqli_query($idp,"SELECT * FROM uzytkownicy WHERE Login='".$_POST['login']."' AND Haslo='".$_POST['pass']."';");
	$user = mysqli_fetch_assoc($idd);
	mysqli_close($idp);
	if ($user) {
		$_SESSION['login'] = $user['Login'];
		$_SESSION['start_sesji'] = time();
		header("Location:../../index.php");
	} else{
		echo "Nie istnieje taki użytkownik.";
		NoLogin();
	}
} else{
	NoLogin();
}
function NoLogin() {
	echo '<form action="login.php" method="POST">
		<input type="text" name="login" id="login" required><br><br>
		<input type="password" name="pass" id="pass" required><br><br>
		<input type="submit" value="Zaloguj">
	</form>';
}
?>

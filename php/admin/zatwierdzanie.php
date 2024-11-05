<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['id'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
	header("Location: ../logowanie/login.php");
    exit();
}
if (!(bool)$_SESSION['is_admin']) {die("Nie masz dostępu");}

$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
$sql = "SELECT u.imie, u.nazwisko, w.data, w.godzina_rozpoczecia, w.godzina_zakonczenia, w.godzin, w.pozycja_id FROM uzytkownicy AS u JOIN wpisy_pracy AS w ON w.uzytkownik_id=u.uzytkownik_id WHERE zatwierdzone=0;";
$idd = mysqli_query($idp,$sql);
$code = "<table><tr><th>
	Imie</th><th>
	Nazwisko</th><th>
	Data</th><th>
	Godzina rozpoczęcia</th><th>
	Godzina zakończenia</th><th>
	Godzin pracy</th><th>
	Zatwierdzone</th></tr>";
while ($row= mysqli_fetch_row($idd)) {
	$code .= "<tr>
	<td>$row[0]</td>
	<td>$row[1]</td>
	<td>$row[2]</td>
	<td>$row[3]</td>
	<td>$row[4]</td>
	<td>$row[5]</td>
	<td><form action='zatwierdz.php' method='POST'>
        <button name='id' id='id' value='$row[6]' style='background-color:lime;border:1px solid black;border-radius: 5px;cursor:pointer'>Zatwierdź</button>
        <label>Komentarz:</label><input name='kom' id='kom' type='text'>
    </form</td>
	</tr>";
}
$code .= "</table>";
echo '
<title>Zatwierdzanie Wpisów</title>
<link rel="stylesheet" href="../../style/styl.css">';
echo $code;
mysqli_close($idp);
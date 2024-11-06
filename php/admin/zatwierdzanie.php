<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['id'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
	header("Location: ../logowanie/login.php");
    exit();
}
if (!(bool)$_SESSION['is_admin']) {die("Nie masz dostępu");}

echo "<a href='../../index.php'>Powrót</a>
<input type='date' onchange='FilterDate(this.value)'>
<button id='tabela-toggle' onclick='TableToggle();'></button>";
$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
$sql = "SELECT u.imie, u.nazwisko, w.data, w.godzina_rozpoczecia, w.godzina_zakonczenia, w.godzin, w.pozycja_id, w.zatwierdzone
FROM uzytkownicy AS u
JOIN wpisy_pracy AS w ON w.uzytkownik_id=u.uzytkownik_id
ORDER BY w.zatwierdzone,w.data, u.nazwisko, u.imie;";
$idd = mysqli_query($idp,$sql);
$sql = "SELECT u.imie,u.nazwisko,n.data_nieobecnosci, n.przyczyna, n.zatwierdzone
FROM uzytkownicy AS u 
JOIN nieobecnosci AS n ON n.uzytkownik_id=u.uzytkownik_id
ORDER BY n.zatwierdzone ASC, u.nazwisko,u.imie,n.data_nieobecnosci;";
$idd2 = mysqli_query($idp,$sql);
mysqli_close($idp);
$code = "<div style='background-color:rgba(0,0,0,0.5)' id='lista-pracownikow'><table><tr><th>
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
	<td>
	<form action='zatwierdz.php' method='POST' name='form$row[6]' id='form$row[6]''>
		<input type='hidden' name='id' id='id' value='$row[6];".($row[7]=="0"?"1":"0")."'>
        <input type='submit' name='wyslij' id='wyslij' value='".($row[7]=="0"?"Zatwierdź":"Cofnij")."' style='background-color:".($row[7]=="0"?"lime":"red").";border:1px solid black;border-radius: 5px;cursor:pointer'>
        <label>Komentarz:</label><input name='kom' id='kom' type='text'>
    </form></td>
	</tr>";
}
$code .= "</table></div>";
$code2 = "<div id='lista-usprawiedliwien' style='background-color:rgba(0,0,0,0);display:none'><table><tr><th>
	Imie</th><th>
	Nazwisko</th><th>
	Data</th><th>
	Godzina rozpoczęcia</th><th>
	Godzina zakończenia</th><th>
	Godzin pracy</th><th>
	Zatwierdzone</th></tr>";
while ($row= mysqli_fetch_row($idd2)) {
	$code2 .= "<tr>
	<td>$row[0]</td>
	<td>$row[1]</td>
	<td>$row[2]</td>
	<td>$row[3]</td>
	<td>$row[4]</td>
	<td>$row[5]</td>
	<td>
	<form action='zatwierdzNieob.php' method='POST' name='form$row[6]' id='form$row[6]''>
		<input type='hidden' name='id' id='id' value='$row[6];".($row[7]=="0"?"1":"0")."'>
        <input type='submit' name='wyslij' id='wyslij' value='".($row[7]=="0"?"Zatwierdź":"Cofnij")."' style='background-color:".($row[7]=="0"?"lime":"red").";border:1px solid black;border-radius: 5px;cursor:pointer'>
        <label>Komentarz:</label><input name='kom' id='kom' type='text'>
    </form></td>
	</tr>";
}
$code2 .= "</table></div>";
echo '
<title>Zatwierdzanie Wpisów</title>
<link rel="stylesheet" href="../../style/styl.css">
<style> body{overflow:auto;}</style>';
echo $code;
echo $code2;
echo "
<script src='../../javascript/przelaczTabele.js'></script>
<script>
const table = document.getElementsByTagName('table')[0];
const tableValue = table.innerHTML;
function FilterDate(filter){
    let _tableValue = tableValue.split('</tr>');

    let filteredValue = _tableValue[0] + '</tr>';

    for (i=1;i<_tableValue.length-1;i++) {
        if (_tableValue[i].search('<td>') == -1) break;
        if (_tableValue[i].split('<td>')[3].search(filter) != -1) {
            filteredValue += _tableValue[i] + '</tr>';
        }
    }
    filteredValue += _tableValue[_tableValue.length-1];
    table.innerHTML = filteredValue;
}
</script>";
<?php
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy")
	or die("Nie udalo sie polaczyc z baza danych pracownicy");

	$sql = "SELECT u.imie, u.nazwisko, w.data, w.godzina_rozpoczecia, w.godzina_zakonczenia, w.godzin, w.zatwierdzone FROM uzytkownicy AS u JOIN wpisy_pracy AS w ON w.uzytkownik_id=u.uzytkownik_id;";
	$idd = mysqli_query($idp,$sql);
	$code = "<table><tr><th>
		Imie</th><th>
		Nazwisko</th><th>
		Data</th></tr>
		Godzina rozpoczęcia</th></tr>
		Godzina zakończenia</th></tr>
		Godzin pracy</th></tr>
		Zatwierdzone</th></tr>";
	while ($row= mysqli_fetch_row($idd)) {
		$code .= "<tr>
		<td>$row[0]</td>
		<td>$row[1]</td>
		<td>$row[2]</td>
		<td>$row[3]</td>
		<td>$row[4]</td>
		<td>$row[5]</td>
		<td><span class='circle ".(($row[6])?"filled":"empty")."'></span></td>
		</tr>";
	}
	$code .= "</table>";
	echo $code;
	mysqli_close($idp);

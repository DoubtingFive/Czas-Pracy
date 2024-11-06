<?php
echo "<div style='background-color:rgba(0,0,0,0)' id='lista-pracownikow'><h2>Lista Czasu Pracy Pracowników</h2>";
	$isUser = (bool)$_SESSION['is_admin'];
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy")
	or die("Nie udalo sie polaczyc z baza danych pracownicy");
	
	$sql = "";
	if ($isUser){
		$sql = "SELECT u.imie, u.nazwisko, w.data, w.godzina_rozpoczecia, w.godzina_zakonczenia, w.godzin, w.zatwierdzone
		FROM uzytkownicy AS u 
		JOIN wpisy_pracy AS w ON w.uzytkownik_id=u.uzytkownik_id
		ORDER BY w.zatwierdzone DESC, w.data DESC,u.nazwisko,u.imie;";
	} else {
		$sql = "SELECT w.data, w.godzina_rozpoczecia, w.godzina_zakonczenia, w.godzin, w.zatwierdzone
		FROM uzytkownicy AS u 
		JOIN wpisy_pracy AS w ON w.uzytkownik_id=u.uzytkownik_id 
		WHERE u.uzytkownik_id='".$_SESSION['id']."'
		ORDER BY w.zatwierdzone DESC,u.nazwisko,u.imie,w.data;";
	}
	$idd = mysqli_query($idp,$sql);
	mysqli_close($idp);
	$code = "<table><tr><th>";
	if ($isUser) $code .="Imie</th><th>Nazwisko</th><th>";
	$code.= "Data</th><th>
		Godzina rozpoczęcia</th><th>
		Godzina zakończenia</th><th>
		Godzin pracy</th><th>
		Zatwierdzone</th></tr>";
	while ($row= mysqli_fetch_row($idd)) {
		if ($isUser) {
			$code .= "<tr>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			<td>$row[4]</td>
			<td>$row[5]</td>
			<td><span class='circle ".(($row[6])?"filled":"empty")."'></span></td>
			</tr>";
		} else {
			$code .= "<tr>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			<td><span class='circle ".(($row[4])?"filled":"empty")."'></span></td>
			</tr>";
		}
	}
	$code .= "</table></div>";
	echo $code;
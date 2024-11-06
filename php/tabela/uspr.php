<?php
echo "<div id='lista-usprawiedliwien' style='background-color:rgba(0,0,0,0);display:none'><h2>Lista Usprawiedliwień Pracowników</h2>";
	$isUser = (bool)$_SESSION['is_admin'];
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy")
	or die("Nie udalo sie polaczyc z baza danych pracownicy");
	
	$sql = "";
	if ($isUser){
		$sql = "SELECT u.imie,u.nazwisko,n.data_nieobecnosci, n.przyczyna, n.zatwierdzone
		FROM uzytkownicy AS u 
		JOIN nieobecnosci AS n ON n.uzytkownik_id=u.uzytkownik_id
		ORDER BY n.zatwierdzone ASC, u.nazwisko,u.imie,n.data_nieobecnosci;";
	} else {
		$sql = "SELECT n.data_nieobecnosci, n.przyczyna, n.zatwierdzone
		FROM uzytkownicy AS u 
		JOIN nieobecnosci AS n ON n.uzytkownik_id=u.uzytkownik_id
		WHERE u.uzytkownik_id='".$_SESSION['id']."'
		ORDER BY u.nazwisko,u.imie,n.data_nieobecnosci;";
	}
	$idd = mysqli_query($idp,$sql);
	mysqli_close($idp);
	$code = "<table><tr><th>";
	if ($isUser) $code .="Imie</th><th>Nazwisko</th><th>";
	$code.= "Data</th><th>
		Przyczyna</th><th>
		Zatwierdzone</th><th></tr>";
	while ($row= mysqli_fetch_row($idd)) {
		if ($isUser) {
			$code .= "<tr>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			<td><span class='circle ".(($row[4])?"filled":"empty")."'></span></td>
			</tr>";
		} else {
			$code .= "<tr>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td><span class='circle ".(($row[2])?"filled":"empty")."'></span></td>
			</tr>";
		}
	}
	$code .= "</table></div>";
	echo $code;
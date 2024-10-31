<?php
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");

	$idd = mysqli_query($idp,"SELECT * FROM pracownicy");
	$code = "<table><tr><th>
		ID</th><th>
		Imie</th><th>
		Nazwisko</th><th>
		Godziny pracy</th></tr>";
	while ($row= mysqli_fetch_row($idd)) {
		$code .= "<tr><td>$row[3]</td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
	}
	$code .= "</table>";
	echo $code;
	mysqli_close($idp);
?>

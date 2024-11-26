<?php
function TabelaWpisy($order_by = "w.zatwierdzone", $order_id = 6, $sort_direction = "DESC") {
	echo "<div style='background-color:rgba(0,0,0,0)' id='lista-pracownikow'><h2>Lista Czasu Pracy Pracowników</h2>";
	$isUser = (bool)$_SESSION['is_admin'];
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy")
	or die("Nie udalo sie polaczyc z baza danych pracownicy");

	$sql = "";
	if ($isUser){
		$sql = "SELECT u.imie, u.nazwisko, w.data, w.godzina_rozpoczecia, w.godzina_zakonczenia, w.godzin, w.zatwierdzone, w.pozycja_id
		FROM uzytkownicy AS u 
		JOIN wpisy_pracy AS w ON w.uzytkownik_id=u.uzytkownik_id
		ORDER BY $order_by $sort_direction;";
		// w.zatwierdzone DESC, w.data DESC,u.nazwisko,u.imie
	} else {
		$sql = "SELECT w.data, w.godzina_rozpoczecia, w.godzina_zakonczenia, w.godzin, w.zatwierdzone
		FROM uzytkownicy AS u 
		JOIN wpisy_pracy AS w ON w.uzytkownik_id=u.uzytkownik_id 
		WHERE u.uzytkownik_id='".$_SESSION['id']."'
		ORDER BY $order_by $sort_direction;";
	}
	$idd = mysqli_query($idp,$sql);
	mysqli_close($idp);

	$arrow = "<span>";
	$arrow .= $sort_direction == "ASC"?"\/":"/\\";
	$arrow .= "</span>";

	$code = "<table><tr>";

	if ($isUser)  {
		$code .="<th onclick='SortWpisy(\"wpisy\",\"u.imie\",0);'>Imie ";
		$code .= ($order_id == 0)?$arrow:'';
		$code .= "</th><th onclick='SortWpisy(\"wpisy\",\"u.nazwisko\",1);'>Nazwisko ";
		$code .= ($order_id == 1)?$arrow:'';
		$code .= "</th>";
	}

	$code.= "
		<th onclick='SortWpisy(\"wpisy\",\"w.data\",2);'>Data ";
		$code .= ($order_id == 2)?$arrow:'';
		$code .= "</th>
		<th onclick='SortWpisy(\"wpisy\",\"w.godzina_rozpoczecia\",3);'>Godzina rozpoczęcia ";
		$code .= ($order_id == 3)?$arrow:'';
		$code .= "</th>
		<th onclick='SortWpisy(\"wpisy\",\"w.godzina_zakonczenia\",4);'>Godzina zakończenia ";
		$code .= ($order_id == 4)?$arrow:'';
		$code .= "</th>
		<th onclick='SortWpisy(\"wpisy\",\"w.godzin\",5);'>Godzin pracy ";
		$code .= ($order_id == 5)?$arrow:'';
		$code .= "</th>
		<th onclick='SortWpisy(\"wpisy\",\"w.zatwierdzone\",6);'>Zatwierdzone ";
		$code .= ($order_id == 6)?$arrow:'';
		$code .= "</th></tr>";
	while ($row= mysqli_fetch_row($idd)) {
		if ($isUser) {
			$code .= "<tr>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			<td>$row[4]</td>
			<td>$row[5]</td>
			<td onclick='zatwierdzWpis($row[7], \"$row[6]\", this)'><span class='circle ".(($row[6])?"filled":"empty")."'></span></td>
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
		// echo "<br>zakonczono petle o identyfikatorze: ".$row[7];
	}
	$code .= "</table>
	
	<script>
		const zatwierdzonePrzez = ".json_encode($_SESSION['id']).";\n";
		$code .= <<< EOF
		wlaczKomentarz = true;
		function zatwierdzWpis(pozycja_id, zatwierdzone,x) {
			let komentarz = "";
			if (wlaczKomentarz) {
				komentarz = prompt('Podaj komentarz:', '');
			} else {
				komentarz = 'Zatwierdzono przez funckję "Zatwierdź wszystko"';
			}
			if (komentarz == null) {
				return;
			}
			const formData = new FormData();
			formData.append('operacja', "w");
			formData.append('pozycja_id', pozycja_id);
			formData.append('zatwierdzone_przez', zatwierdzonePrzez);
			formData.append('zatwierdzone', (x.firstElementChild.className=="circle empty"?1:0));
			formData.append('komentarz', komentarz);
			fetch('php/admin/zatwierdz.php', {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					x.firstElementChild.className = 'circle '+(x.firstElementChild.className=="circle empty"?"filled":"empty");
					CalculateConfirms();
				} else {
					alert('Wystąpił błąd: ' + data.message);
				}
			})
			.catch(error => console.error('Błąd:', error));
		}
	</script></div>
	EOF;
	echo $code;
}
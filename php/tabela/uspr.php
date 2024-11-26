<?php
function TabelaUspr($order_by = "n.zatwierdzone", $order_id = 6, $sort_direction = "DESC",$isUspr = false) {
	$display_status = (bool)$isUspr?"display":"none";
	echo "<div id='lista-usprawiedliwien' style='background-color:rgba(0,0,0,0);display:$display_status'><h2>Lista Usprawiedliwień Pracowników</h2>";
	$isUser = (bool)$_SESSION['is_admin'];
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy")
	or die("Nie udalo sie polaczyc z baza danych pracownicy");

	$sql = "";
	if ($isUser){
		$sql = "SELECT u.imie,u.nazwisko,n.data_nieobecnosci, n.przyczyna, n.zatwierdzone, n.nieobecnosc_id
		FROM uzytkownicy AS u 
		JOIN nieobecnosci AS n ON n.uzytkownik_id=u.uzytkownik_id
		ORDER BY $order_by $sort_direction;";
		// n.zatwierdzone ASC, u.nazwisko,u.imie,n.data_nieobecnosci
	} else {
		$sql = "SELECT n.data_nieobecnosci, n.przyczyna, n.zatwierdzone
		FROM uzytkownicy AS u 
		JOIN nieobecnosci AS n ON n.uzytkownik_id=u.uzytkownik_id
		WHERE u.uzytkownik_id='".$_SESSION['id']."'
		ORDER BY $order_by $sort_direction;";
	}
	$idd = mysqli_query($idp,$sql);
	mysqli_close($idp);

	$arrow = "<span>";
	$arrow .= $sort_direction == "ASC"?"\/":"/\\";
	$arrow .= "</span>";

	$code = "<table><tr>";
	if ($isUser) {
		$code .="<th onclick='SortWpisy(\"uspr\",\"u.imie\",0)'>Imie ";
		$code .= ($order_id == 0)?$arrow:'';
		$code .= "</th><th onclick='SortWpisy(\"uspr\",\"u.nazwisko\",1)'>Nazwisko ";
		$code .= ($order_id == 1)?$arrow:'';
		$code .= "</th>";
	}
	$code.= "
	<th onclick='SortWpisy(\"uspr\",\"n.data_nieobecnosci\",2)'>Data ";
	$code .= ($order_id == 2)?$arrow:'';
	$code .= "</th>
	<th onclick='SortWpisy(\"uspr\",\"n.przyczyna\",3)'>Przyczyna ";
	$code .= ($order_id == 3)?$arrow:'';
	$code .= "</th>
	<th onclick='SortWpisy(\"uspr\",\"n.zatwierdzone\",4)'>Zatwierdzone ";
	$code .= ($order_id == 4)?$arrow:'';
	$code .= "</th>";
	while ($row= mysqli_fetch_row($idd)) {
		if ($isUser) {
			$code .= "<tr>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			<td onclick='zatwierdzNieobecnosc($row[5], \"$row[4]\", this)'><span class='circle ".(($row[4])?"filled":"empty")."'></span></td>
			</tr>";
		} else {
			$code .= "<tr>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td><span class='circle ".(($row[2])?"filled":"empty")."'></span></td>
			</tr>";
		}
	}
	$code .= "</table>
	
	<script>
	function zatwierdzNieobecnosc(pozycja_id, zatwierdzone, x) {
		const zatwierdzonePrzez = ". json_encode($_SESSION['id']) .";\n";
	$code .= <<< EOF
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
		formData.append('operacja', "n");
		formData.append('pozycja_id', pozycja_id);
		formData.append('zatwierdzone_przez', zatwierdzonePrzez);
		formData.append('zatwierdzone', (x.firstElementChild.className=="circle empty"?1:0));
		formData.append('komentarz', 'Nieobecność. ' + komentarz);
		fetch('php/admin/zatwierdzUspr.php', {
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
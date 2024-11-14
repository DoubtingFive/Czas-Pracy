<?php
echo "<div style='background-color:rgba(0,0,0,0)' id='lista-pracownikow'><h2>Lista Czasu Pracy Pracowników</h2>";
$isUser = (bool)$_SESSION['is_admin'];
$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy")
or die("Nie udalo sie polaczyc z baza danych pracownicy");

$sql = "";
if ($isUser){
	$sql = "SELECT u.imie, u.nazwisko, w.data, w.godzina_rozpoczecia, w.godzina_zakonczenia, w.godzin, w.zatwierdzone, w.pozycja_id
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
$code = "<table><tr>";
if ($isUser) $code .="<th onclick='Sort(\"u.imie\")'>Imie</th><th onclick='Sort(\"u.nazwisko\")'>Nazwisko</th>";
$code.= "<th onclick='Sort(\"w.data\")'>Data</th><th onclick='Sort(\"w.godzina_rozpoczecia\")'>
	Godzina rozpoczęcia</th><th onclick='Sort(\"w.godzina_zakonczenia\")'>
	Godzina zakończenia</th><th onclick='Sort(\"w.godzin\")'>
	Godzin pracy</th><th onclick='Sort(\"w.zatwierdzone\")'>
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
}
$code .= "</table></div>";
echo $code;
?>
<script>
	function Sort(x) {
		
	}

	wlaczKomentarz = true;
	function zatwierdzWpis(pozycja_id, zatwierdzone,x) {
    const zatwierdzonePrzez = <?php echo json_encode($_SESSION['id']); ?>;
	let komentarz = "";
	if (wlaczKomentarz) {
    	komentarz = prompt('Podaj komentarz:', '');
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
        } else {
            alert('Wystąpił błąd: ' + data.message);
        }
    })
    .catch(error => console.error('Błąd:', error));
}
</script>
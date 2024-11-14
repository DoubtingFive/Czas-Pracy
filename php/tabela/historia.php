<?php
$historia = null;
if (isset($_GET['historia'])) {
    $historia = $_GET['historia'];
}
if ((bool)$_SESSION['is_admin'] && $historia == 1) {
    $idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy")
    or die("Nie udalo sie polaczyc z baza danych pracownicy");
    $sql = "SELECT u.imie, u.nazwisko, uz.imie, uz.nazwisko, w.data, w.godzina_rozpoczecia, w.godzina_zakonczenia, w.godzin, w.zatwierdzone, w.pozycja_id, z.zatwierdzenie_data, z.zatwierdzono, z.komentarz
    FROM zatwierdzenia AS z
    JOIN uzytkownicy AS u ON u.uzytkownik_id=z.zatwierdzone_przez
    JOIN wpisy_pracy AS w ON w.pozycja_id=z.pozycja_id
    JOIN uzytkownicy AS uz ON uz.uzytkownik_id=w.uzytkownik_id;";
    //  WHERE z.komentarz NOT LIKE 'Komentarz. %'
    $idd = mysqli_query($idp,$sql);
    mysqli_close($idp);
    $code = "<table id='zatwierdzenia-lista'><tr><th>
        Zatwierdzone przez</th><th>
        Rekord</th><th>
        Data</th><th>
        Czy To Było Zatwierdzenie</th><th>
        Komentarz</th>";
    while ($row= mysqli_fetch_row($idd)) {
            $code .= "<tr id=\"base\">
            <td id=\"base1\">$row[0] $row[1]</td>
            <td id=\"base1\">
            <table><tr>
            <th>Imie</th>
            <th>Nazwisko</th>
            <th>Data</th>
            <th>Godzina rozpoczęcia</th>
            <th>Godzina zakończenia</th>
            <th>Godzin pracy</th>
            <th>Zatwierdzone</td>
            </tr><tr>
            <td id=\"table\">$row[2]</td>
            <td id=\"table\">$row[3]</td>
            <td id=\"table\">$row[4]</td>
            <td id=\"table\">$row[5]</td>
            <td id=\"table\">$row[6]</td>
            <td id=\"table\">$row[7]</td>
            <td id=\"table\" onclick='zatwierdzWpis($row[9], \"$row[8]\", this)'><span class='circle ".(($row[8])?"filled":"empty")."'></span></td>
            </tr></table></td>
            <td id=\"base1\">$row[10]</td>
            <td id=\"base1\"><span class='circle ".(($row[11])?"filled":"empty")."'></span></td>
            <td id=\"base1\">$row[12]</td>
            </tr id=\"base\">";
    }
    $code .= "</table></div>";
    echo $code;
}
?>
<script>
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
<?php
function TabelaHistoria($order_by = "u.nazwisko", $order_id = 0, $sort_direction = "DESC") {
    if ((bool)$_SESSION['is_admin']) {
        $idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy")
        or die("Nie udalo sie polaczyc z baza danych pracownicy");
        $sql = "SELECT u.imie, u.nazwisko, uz.imie, uz.nazwisko, w.data, w.godzina_rozpoczecia, w.godzina_zakonczenia, w.godzin, w.zatwierdzone, w.pozycja_id, z.zatwierdzenie_data, z.zatwierdzono, z.komentarz
        FROM zatwierdzenia AS z
        JOIN uzytkownicy AS u ON u.uzytkownik_id=z.zatwierdzone_przez
        JOIN wpisy_pracy AS w ON w.pozycja_id=z.pozycja_id
        JOIN uzytkownicy AS uz ON uz.uzytkownik_id=w.uzytkownik_id
        ORDER BY $order_by $sort_direction;";
        //  WHERE z.komentarz NOT LIKE 'Komentarz. %'
        $idd = mysqli_query($idp,$sql);
        mysqli_close($idp);

        $arrow = "<span>";
        $arrow .= $sort_direction == "ASC"?"\/":"/\\";
        $arrow .= "</span>";

        $code = "<table id='zatwierdzenia-lista'>
            <tr>
                <th onclick='SortWpisy(\"historia\",\"u.nazwisko\",0)'>Zatwierdzone przez ";
                $code .= ($order_id == 0)?$arrow:'';
                $code .= "</th>
                <th>Rekord</th>
                <th onclick='SortWpisy(\"historia\",\"z.zatwierdzenie_data\",8)'>Data ";
                $code .= ($order_id == 8)?$arrow:'';
                $code .= "</th>
                <th onclick='SortWpisy(\"historia\",\"z.zatwierdzono\",9)'>Czy To Było Zatwierdzenie ";
                $code .= ($order_id == 9)?$arrow:'';
                $code .= "</th>
                <th onclick='SortWpisy(\"historia\",\"z.komentarz\",10)'>Komentarz ";
                $code .= ($order_id == 10)?$arrow:'';
                $code .= "</th>
            </tr>";
        while ($row= mysqli_fetch_row($idd)) {
                $code .= "<tr id=\"base\">
                <td id=\"base1\">$row[0] $row[1]</td>
                <td id=\"base1\">
                <table><tr>
                <th onclick='SortWpisy(\"historia\",\"uz.imie\",1)'>Imie ";
                $code .= ($order_id == 1)?$arrow:'';
                $code .= "</th>
                <th onclick='SortWpisy(\"historia\",\"uz.nazwisko\",2)'>Nazwisko ";
                $code .= ($order_id == 2)?$arrow:'';
                $code .= "</th>
                <th onclick='SortWpisy(\"historia\",\"w.data\",3)'>Data ";
                $code .= ($order_id == 3)?$arrow:'';
                $code .= "</th>
                <th onclick='SortWpisy(\"historia\",\"w.godzina_rozpoczecia\",4)'>Godzina rozpoczęcia ";
                $code .= ($order_id == 4)?$arrow:'';
                $code .= "</th>
                <th onclick='SortWpisy(\"historia\",\"w.godzina_zakonczenia\",5)'>Godzina zakończenia ";
                $code .= ($order_id == 5)?$arrow:'';
                $code .= "</th>
                <th onclick='SortWpisy(\"historia\",\"w.godzin\",6)'>Godzin pracy ";
                $code .= ($order_id == 6)?$arrow:'';
                $code .= "</th>
                <th onclick='SortWpisy(\"historia\",\"w.zatwierdzone\",7)'>Zatwierdzone ";
                $code .= ($order_id == 7)?$arrow:'';
                $code .= "</th>
                </tr><tr>
                <td id=\"table\">$row[2]</td>
                <td id=\"table\">$row[3]</td>
                <td id=\"table\">$row[4]</td>
                <td id=\"table\">$row[5]</td>
                <td id=\"table\">$row[6]</td>
                <td id=\"table\">$row[7]</td>
                <td id=\"table\" onclick='zatwierdzWpis2($row[9], \"$row[8]\", this)'><span class='circle ".(($row[8])?"filled":"empty")."'></span></td>
                </tr></table></td>
                <td id=\"base1\">$row[10]</td>
                <td id=\"base1\"><span class='circle ".(($row[11])?"filled":"empty")."'></span></td>
                <td id=\"base1\">$row[12]</td>
                </tr id=\"base\">";
        }
        $code .= "</table>

        <script>
        wlaczKomentarz = true;
        function zatwierdzWpis2(pozycja_id, zatwierdzone,x) {
            const zatwierdzonePrzez = ".json_encode($_SESSION['id']).";\n";
        $code .= <<< EOF
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
        </script></div>
        EOF;
        echo $code;
    }
}
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wybór Dni</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 10px; }
        th, td { text-align: center; padding: 10px; }
        a { text-decoration: none; color: black; }
        a:hover { color: blue; }
    </style>
</head>
<body>

<?php
function wyslMiesiac($rok) {
    $miesiace = [
        1 => "Styczeń", 2 => "Luty", 3 => "Marzec", 4 => "Kwiecień",
        5 => "Maj", 6 => "Czerwiec", 7 => "Lipiec", 8 => "Sierpień",
        9 => "Wrzesień", 10 => "Październik", 11 => "Listopad", 12 => "Grudzień"
    ];

    echo "<h2>Wybierz miesiąc roku $rok</h2>";
    echo "<table><tr>";
    foreach ($miesiace as $num => $name) {
        if (($num - 1) % 4 == 0 && $num > 1) echo "</tr><tr>";
        echo "<td><a href='kalendarz.php?miesiac=$num&rok=$rok'>$name</a></td>";
    }
    echo "</tr></table>";
}

function wyslDni($miesiac, $rok) {
    $dniWMiesiacu = cal_days_in_month(CAL_GREGORIAN, $miesiac, $rok);

    echo "<h2>Dni w miesiącu " . str_pad($miesiac, 2, "0", STR_PAD_LEFT) . ", rok: $rok</h2>";
    echo "<table><tr>";
    for ($dzien = 1; $dzien <= $dniWMiesiacu; $dzien++) {
        if (($dzien - 1) % 7 == 0 && $dzien > 1) echo "</tr><tr>";
        $dataLink = "kalendarz.php?dzien=$dzien&miesiac=$miesiac&rok=$rok";
        echo "<td><a href='$dataLink'>$dzien</a></td>";
    }
    echo "</tr></table>";
    echo "<a href='kalendarz.php?rok=$rok'>Wróć do wyboru miesiąca</a>";
}

function wyswietlSzczegolyDnia($dzien, $miesiac, $rok) {
    $data = sprintf('%04d-%02d-%02d', $rok, $miesiac, $dzien);
    echo "<h2>Szczegóły dnia: $dzien-$miesiac-$rok</h2>";
    
    // Polaczenie z baza danych

    echo "<a href='kalendarz.php?miesiac=$miesiac&rok=$rok'>Wróć do listy dni</a>";
}


$rok = date('Y');
if (isset($_GET['rok'])) $rok = (int)$_GET['rok'];

if (isset($_GET['miesiac']) && isset($_GET['rok'])) {
    wyslDni((int)$_GET['miesiac'], (int)$_GET['rok']);
} elseif (isset($_GET['dzien']) && isset($_GET['miesiac']) && isset($_GET['rok'])) {
    wyswietlSzczegolyDnia((int)$_GET['dzien'], (int)$_GET['miesiac'], (int)$_GET['rok']);
} else {
    wyslMiesiac($rok);
}
?>

</body>
</html>

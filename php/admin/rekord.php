<?php
$status = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = $_POST['imie'];
    $naz = $_POST['naz'];
    $haslo = $_POST['haslo'];
    $rola = $_POST['rola'];
    if (!(isset($imie) && isset($naz) && isset($rola) && isset($haslo))) die("Nie udało się utworzyć użytkownika <a href='../../index.php>Wróć</a>'");
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
    $sql = "INSERT INTO uzytkownicy(`imie`,`nazwisko`,`haslo`,`role`) VALUES ('$imie','$naz','$haslo','$rola')";
	$status=mysqli_query($idp,$sql);
    mysqli_close($idp);
}
header("location:../../index.php?status=".($status?'sukces':'blad'));
exit();
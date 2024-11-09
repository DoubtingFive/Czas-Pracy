<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['id'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
	header("Location: ../logowanie/login.php");
    exit();
}
if (!(bool)$_SESSION['is_admin']) {die("Nie masz dostępu");}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $operacja = $_POST['operacja'];
    $pozycja_id = $_POST['pozycja_id'];
    $zatwierdzone_przez = $_POST['zatwierdzone_przez'];
    $zatwierdzone = $_POST['zatwierdzone'];
    $komentarz = $_POST['komentarz'];

    $idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
	$sql = "INSERT INTO zatwierdzenia(`pozycja_id`, `zatwierdzone_przez`, `zatwierdzono`, `zatwierdzenie_data`, `komentarz`) 
            VALUES ('$pozycja_id', '$zatwierdzone_przez', '$zatwierdzone', '" . date("Y-m-d H:i:s") . "', '$komentarz')";

    if (mysqli_query($idp, $sql)) {
        if ($operacja == "n") $sqlUpdate = "UPDATE nieobecnosci SET zatwierdzone='$zatwierdzone' WHERE nieobecnosc_id='$pozycja_id'";
        else if ($operacja == "w") $sqlUpdate = "UPDATE wpisy_pracy SET zatwierdzone='$zatwierdzone' WHERE pozycja_id='$pozycja_id'";
        if (mysqli_query($idp, $sqlUpdate)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Błąd podczas aktualizacji nieobecności.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Błąd podczas zapisywania zatwierdzenia.']);
    }
	mysqli_close($idp);
}

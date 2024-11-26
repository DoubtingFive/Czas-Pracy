<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['id'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
	header("Location: ../logowanie/login.php");
    exit();
}
if (!(bool)$_SESSION['is_admin']) { 
    header("Location: ../logowanie/login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = mysqli_connect("localhost", "root", "*G(EjzAR!KEsUzoO", "pracownicy")
    or die("Błąd połączenia z bazą danych");
	
    mysqli_query($conn,"DELETE FROM zatwierdzenia");
    mysqli_query($conn,"DELETE FROM wpisy_pracy");
    mysqli_query($conn,"DELETE FROM nieobecnosci");
    mysqli_query($conn,"DELETE FROM zmiany");
    mysqli_query($conn,"DELETE FROM uzytkownicy");

    if (isset($_FILES['sql_file']) && $_FILES['sql_file']['error'] == UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['sql_file']['tmp_name'];
        $sql = file_get_contents($uploadedFile);

        if ($sql === false) {
            die("Nie można odczytać zawartości pliku.");
        }

        if (mysqli_multi_query($conn, $sql)) {
            do {
                if ($result = mysqli_store_result($conn)) {
                    mysqli_free_result($result);
                }
            } while (mysqli_next_result($conn));
            echo "Import zakończony pomyślnie. <a href='narzedzia.php'>Powrót</a>'";
        } else {
            echo "Błąd podczas importu: " . mysqli_error($conn);
        }
    } else {
        echo "Błąd podczas przesyłania pliku.";
    }
    mysqli_close($conn);
} else {
    header("Location: ../logowanie/login.php");
    exit();
}

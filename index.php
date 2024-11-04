<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
	header("Location: php/logowanie/login.php");
}
$x = $_SESSION['start_sesji'];
$y = $_SESSION['login'];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Czas pracy</title>
    <link rel="stylesheet" href="style/styl.css?v=1.4">
</head>
<body>
	<button id="logout" onclick="Logout();">Wyloguj się</button>
	<p class="czas" id="czas">Czas sesji: 00:00</p>
    <img src="grafika/logopoprw.png" alt="logo">
    <div id="calosc">
        <div id="baner">
            <h1 id="tytul">Czas pracy</h1>
        </div>
        <div id="nawigacja">
	<fieldset>
                <legend>Nawigacja</legend>
                <br>
                <a href="#strona_glowna">Strona Główna</a><br>
                <br>
                <a href="#pracownicy">Pracownicy</a><br>
                <br>
                <a href="#raporty">Raporty</a><br>
                <br>
                <a href="#ustawienia">Ustawienia</a><br>
            </fieldset>
        </div>
        <div id="kontent">
            <h2>Lista Pracowników i Czas Pracy</h2>
            <!-- Liczenie czasu -->
            <script>
                const startCzasu = <?php echo $x; ?>;
                const nazwaUzytkownika = "<?php echo $y; ?>";
            </script>
            <script src="javascript/licznikCzasu.js"></script>
    
            <!-- Tabela -->
            <?php include 'php/tabela.php';?>
        </div>
        <div id="filtry">
	        <fieldset>
                <legend>Filtry</legend>
                <form name="filtry">
                    <label>Wyświetlanych rekordów:</label>
                    <select name="rec" id="rec" onchange="RecordLimit(this.value);">
                        <option>10</option>
                        <option selected>25</option>
                        <option>50</option>
                        <option>100</option>
                        <option>250</option>
                        <option>500</option>
                    </select>
                    <label>Godziny pracy:</label>
                    <input type="number" oninput="FilterHours(this.value);">
                </form>
            </fieldset>
        </div>
        <script src="javascript/filtry.js"></script>
        <?php include 'php/admin.php';?>
    </div>
</body>
</html>

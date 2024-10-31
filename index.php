<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['start_sesji'])) {
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
    <link rel="stylesheet" href="style/styl.css?v=1.1">
</head>
<body>
	<p style="position:absolute;" id="czas">Czas sesji: 00:00</p>
	<button id="logout" style="position:absolute;right:0px;" onclick="Logout();">Wyloguj się</button>
    <img src="" alt="logo">
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
        <div id="ustawienia">
			<fieldset>
                <legend>Ustawienia</legend>
            </fieldset>
        </div>
        <div id="administracja"></div>
    </div>
</body>
</html>

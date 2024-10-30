<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['start_sesji'])) {
	header("Location: php/logowanie/login.php");
}
$x = $_SESSION['start_sesji'];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/styl.css">
    <title>Czas Pracy Pracowników</title>
</head>
<body>
	<p style="position:absolute;" id="czas">Czas sesji: 00:00</p>
	<button id="logout" style="position:absolute;right:0px;" onclick="Logout();">Wyloguj się</button>
    <header>
        <h1>Czas Pracy Pracowników</h1>
    </header>
    <nav>
        <a href="#strona_glowna">Strona Główna</a>
        <a href="#pracownicy">Pracownicy</a>
        <a href="#raporty">Raporty</a>
        <a href="#ustawienia">Ustawienia</a>
    </nav>
	<main>
        <h2>Lista Pracowników i Czas Pracy</h2>
        <!-- Liczenie czasu -->
		<script>
			const startCzasu = <?php echo $x; ?>;
		</script>
		<script src="javascript/licznikCzasu.js"></script>

        <!-- Tabela -->
		<?php include 'php/tabela.php';?>
    </main>
</body>
</html>

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
    <link rel="stylesheet" href="style/styl.css?v=1.2">
</head>
<body>
	<button id="logout" onclick="Logout();">Wyloguj się</button>
	<p class="czas" id="czas">Czas sesji: 00:00</p>
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

        <div>
            <!-- <?php include 'php/admin.php';?> -->
            <button id="adminPanel" onclick="RozwinPanelAdmina(this);"></button>
            <div id="administracja">
                <form action="admin/rekord.php" method="POST">
                    <label>Login</label>
                    <input type="text" name="login" id="login" required>
                    <label>Hasło</label>
                    <input type="password" name="pass" id="pass" required>
                    <input type="submit" value="Zaloguj">
                </form>
            </div>
            <script>
                const panel = document.getElementById('administracja');
                const calosc = document.getElementById('calosc');
                function RozwinPanelAdmina(x) {
                    if (panel.style.bottom === '-30vh') {
                        panel.style.bottom = '0';
                        x.style.bottom = "30.5vh";
                    } else {
                        panel.style.bottom = '-30vh';
                        x.style.bottom = ".5vh";
                    }
                }
                RozwinPanelAdmina(document.getElementById("adminPanel"))
            </script>
        </div>
    </div>
</body>
</html>

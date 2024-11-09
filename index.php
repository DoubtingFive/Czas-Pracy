<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['id'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
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
    <link rel="stylesheet" href="style/styl.css">
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
                <legend>Dodaj Wpis</legend>
                <br>
                <h1>Dzień Pracy</h1><br>
                <form name="wpis" method="POST" action="php/wpisy/wpis.php">
                    <label>Data: </label><input type="date" name="data1" id="data1" required><br>
                    <label>Godzina Rozpoczęcia: </label><input type="number" name="roz" id="roz" required><br>
                    <label>Godzina Zakończenia: </label><input type="number" name="zak" id="zak" required><br>
                    <input type="submit" name="wyslij1" id="wyslij1" value="Wyślij">
                </form><br>
                <h1>Usprawiedliwienie</h1><br>
                <form name="uspr" method="POST" action="php/wpisy/usprawiedliwienie.php">
                    <label>Data: </label><input type="date" name="data2" id="data2" required><br>
                    <label>Przyczyna: </label><input type="text" name="przyczyna" id="przyczyna" required><br>
                    <input type="submit" name="wyslij2" id="wyslij2" value="Wyślij">
                </form><br>
                <h1>Zmień Hasło</h1><br>
                <?php
                if(isset($_GET['passwd'])) {
                    $passwd = $_GET['passwd'];
                    if ($passwd == 'success') {
                        echo "<p style='color:lime'>Udało się zmienić hasło</p>";
                    } else if ($passwd == 'wrong') {
                        echo "<p style='color:red'>Nie poprawne hasło</p>";
                    } else {
                        echo "<p style='color:red'>Nie udało się zmienić hasła</p>";
                    }
                }
                ?>
                <form name="haslo" method="POST" action="php/haslo.php">
                    <label>Aktualne hasło: </label><input type="password" name="password" id="password" required><br>
                    <label>Nowe hasło: </label><input type="password" name="newPassword" id="newPassword" required><br>
                    <input type="submit" name="wyslij3" id="wyslij3" value="Wyślij">
                </form>
            </fieldset>
        </div>
        <div id="kontent">
            <!-- Liczenie czasu -->
            <script>
                const startCzasu = <?php echo $x; ?>;
                const nazwaUzytkownika = "<?php echo $y; ?>";
            </script>
            <script src="javascript/licznikCzasu.js"></script>
    
            <!-- Tabela -->
            <button id="tabela-toggle" onclick="TableToggle();"></button>
            <button id="confirm-all" onclick="ConfirmAll();" title="Zatwierdź wszystkie widoczne rekordy">Zatwierdź wszystko</button>
            <?php include 'php/tabela/wpisy.php';?>
            <?php include 'php/tabela/uspr.php';?>
        </div>
        <div id="filtry">
	        <fieldset>
                <legend>Filtry</legend>
                <label>Wyświetlanych rekordów:</label>
                <select name="rec" id="rec" onchange="RecordLimit(this.value);">
                    <option>10</option>
                    <option selected>25</option>
                    <option>50</option>
                    <option>100</option>
                    <option>250</option>
                    <option>500</option>
                </select><br>
                <label>Godziny pracy:</label>
                <input type="number" name="hours" id="hours" oninput="Filter(this.value,6,'.00');"><br>
                <label>Godzina rozpoczęcia pracy:</label>
                <input type="number" name="godzina_rozpoczecia" id="godzina_rozpoczecia" oninput="Filter(this.value,4,':00:00');"><br>
                <label>Godzina zakończenia pracy:</label>
                <input type="number" name="godzina_zakonczenia" id="godzina_zakonczenia" oninput="Filter(this.value,5,':00:00');"><br>
                <input type="date" name="dataOd" id="dataOd" onchange="FilterDate();"> -
                <input type="date" name="dataDo" id="dataDo" onchange="FilterDate();"><br>
                <br>
                <button name="pageDown" id="pageDown" onclick="ChangePage(-1)"><-</button>
                <select name="page" id="page" onchange="ChangePage(this.value,true)"></select>
                <button name="pageUp" id="pageUp" onclick="ChangePage(1)">-></button><br>
                <label>Tylko zatwierdzone (<span id="confirmed"></span>):</label>
                <input type="checkbox" name="checkedOnly" id="checkedOnly" checked onchange='
                Filter((this.checked?"<span class=\"circle filled\"></span>":""),7);
                document.getElementById("notCheckedOnly").checked = false'><br>

                <label>Tylko niezatwierdzone (<span id="notConfirmed"></span>):</label>
                <input type="checkbox" name="notCheckedOnly" id="notCheckedOnly" onchange='
                Filter((this.checked?"<span class=\"circle empty\"></span>":""),7);
                document.getElementById("checkedOnly").checked = false'>

                <p>Znaleziono <span style="color:aqua" id="founded">0</span> rekordów</p>
                <button id="clear-filers" onclick="ClearFilters()">Wyczyść filtry</button>
            </fieldset>
        </div>
        <script src="javascript/filtry.js"></script>
        <script src="javascript/przyciski.js"></script>
        <?php include 'php/admin/admin.php';?>
    </div>
</body>
</html>
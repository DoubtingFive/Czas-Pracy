<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['id'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
	header("Location: php/logowanie/login.php");
}
$x = $_SESSION['start_sesji'];
$y = $_SESSION['login'];
if (isset($_GET["historia"])) {
    if ($_GET["historia"] == 0) {
        unset($_GET["historia"]);
    }
}
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
                <?php
                    if (isset($_GET["historia"])) {
                        echo "<a href='?historia=0'>Powróć</a>";
                    }
                ?>
                <legend>Dodaj Wpis</legend>
                <br>
                <h1>Dzień Pracy</h1><br>
                <?php
                    if (isset($_GET['wpis'])) {
                        unset($_GET['wpis']);
                        echo "<p style='color:lime'>Udało się dodać wpis</p>";
                    }
                ?>
                <form name="wpis" method="POST" action="php/wpisy/wpis.php">
                    <label>Data: </label><input type="date" name="data1" id="data1" required><br>
                    <label>Godzina Rozpoczęcia: </label><input type="number" name="roz" id="roz" required><br>
                    <label>Godzina Zakończenia: </label><input type="number" name="zak" id="zak" required><br>
                    <input type="submit" name="wyslij1" id="wyslij1" value="Wyślij">
                </form><br>
                <h1>Usprawiedliwienie</h1><br>
                <?php
                    if (isset($_GET['uspr'])) {
                        unset($_GET['uspr']);
                        echo "<p style='color:lime'>Udało się dodać usprawiedliwienie</p>";
                    }
                ?>
                <form name="uspr" method="POST" action="php/wpisy/usprawiedliwienie.php">
                    <label>Data: </label><input type="date" name="data2" id="data2" required><br>
                    <label>Przyczyna: </label><input type="text" name="przyczyna" id="przyczyna" required><br>
                    <input type="submit" name="wyslij2" id="wyslij2" value="Wyślij">
                </form><br>
                <h1>Zmień Hasło</h1><br>
                <?php
                if(isset($_GET['passwd'])) {
                    $passwd = $_GET['passwd'];
                    unset($_GET['passwd']);
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
            <?php
            if (!isset($_GET["narzedzia"])) {
                echo '<script src="javascript/sortowanie.js"></script>';
            }
            ?>

            <?php
            if (isset($_GET["historia"])) { 
                include 'php/tabela/historia.php';
                TabelaHistoria();
            // } else if(isset($_GET["narzedzia"])) {
            //     include 'php/narzedzia/narzedzia.php';
            } else {
                echo '<button id="tabela-toggle" onclick="TableToggle();"></button>';
                // <!-- Only admin -->
                if ((bool)$_SESSION['is_admin']) {
                    echo '<button id="confirm-all" onclick="ConfirmAll();" title="Zatwierdź wszystkie widoczne rekordy">Zatwierdź wszystko</button>';
                }

                // <!-- Tabela -->
                include 'php/tabela/wpisy.php';
                include 'php/tabela/uspr.php';
                TabelaWpisy();
                TabelaUspr();
            }
            ?>
        </div>
        <?php
        if (isset($_GET["historia"])) {
            include 'php/filtry/historia.php';
        } else { include 'php/filtry/default.php';}

        include 'php/admin/admin.php';
        ?>
    </div>
</body>
</html>
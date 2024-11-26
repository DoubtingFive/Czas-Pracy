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
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/styl.css">
    <title>Import bazy danych</title>
</head>
<body>
    <div style="width:100vw;height:100vh;margin: 0;padding: 30px;">
    <a href="../../index.php">Powrót</a>
    <h1>Import bazy danych</h1>
    <form action="importBazy.php" method="post" enctype="multipart/form-data">
        <label for="sql_file">Wybierz plik .sql:</label>
        <input type="file" name="sql_file" id="sql_file" accept=".sql" required>
        <br><br>
        <button type="submit">Importuj</button>
    </form><br><br>
    <button onclick="Exportuj();">Exportuj</button>
    </div>
</body>
</html>

<script>
function Exportuj() {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.location = 'backup.sql';
        }
    };
    const url = `exportBazy.php`;
    xhttp.open("GET", url, true);
    xhttp.send();
}
</script>
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

$conn = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy");

$tables = ['uzytkownicy','wpisy_pracy','nieobecnosci','zmiany','zatwierdzenia'];
$tables_insert = '';
for ($i = 0; $i < count($tables); $i++) {
    $sql = "SELECT * FROM ".$tables[$i];
    $idd = mysqli_query($conn, $sql);
    $_insert = "INSERT INTO ".$tables[$i]." VALUES ";
    $start = true;
    while ($row = mysqli_fetch_array($idd)) {
        if ($start) {$start = false;} else 
        {$_insert .= ",\n";}
        $_insert .= "(";
        for ($j = 0; $j < count($row)/2; $j++) {
            $_insert .= "'".$row[$j]."'";
            if ($j+1 != count($row)/2) $_insert .= ",";
        }
        $_insert .= ")";
    }
    if ($_insert == "INSERT INTO ".$tables[$i]." VALUES ") continue;
    $_insert .= ";" . "\n";
    $tables_insert .= $_insert . "\n";
}
mysqli_close($conn);

file_put_contents("backup.sql", $tables_insert);
echo "<a id='pobierz' href='backup.sql'>Pobierz plik</a>
<script>
    document.getElementById('pobierz').click();
</script>";

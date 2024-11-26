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

$file = <<< EOF
CREATE TABLE uzytkownicy (
    uzytkownik_id INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(100) UNIQUE,
    haslo VARCHAR(255) NOT NULL,
    imie VARCHAR(50) NOT NULL,
    nazwisko VARCHAR(50) NOT NULL,
    role ENUM('admin', 'pracownik') DEFAULT 'pracownik'
);
CREATE TABLE wpisy_pracy (
    pozycja_id INT PRIMARY KEY AUTO_INCREMENT,
    uzytkownik_id INT NOT NULL,
    data DATE NOT NULL,
    godzina_rozpoczecia TIME NOT NULL,
    godzina_zakonczenia TIME NOT NULL,
    godzin DECIMAL(5,2) AS (TIMESTAMPDIFF(MINUTE, godzina_rozpoczecia, godzina_zakonczenia) / 60) PERSISTENT,
    zatwierdzone BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (uzytkownik_id) REFERENCES uzytkownicy(uzytkownik_id) ON DELETE CASCADE
);

CREATE TABLE nieobecnosci (
    nieobecnosc_id INT PRIMARY KEY AUTO_INCREMENT,
    uzytkownik_id INT NOT NULL,
    data_nieobecnosci DATE NOT NULL,
    przyczyna TEXT,
    zatwierdzone BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (uzytkownik_id) REFERENCES uzytkownicy(uzytkownik_id) ON DELETE CASCADE
);

CREATE TABLE zmiany (
    zmiana_id INT PRIMARY KEY AUTO_INCREMENT,
    nazwa VARCHAR(50) NOT NULL,
    godzina_rozpoczecia TIME NOT NULL,
    godzina_zakonczenia TIME NOT NULL
);

CREATE TABLE zatwierdzenia (
    zatwierdzenie_id INT PRIMARY KEY AUTO_INCREMENT,
    pozycja_id INT,
    zatwierdzone_przez INT NULL,
    zatwierdzono BOOLEAN NOT NULL,
    zatwierdzenie_data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    komentarz TEXT,
    FOREIGN KEY (pozycja_id) REFERENCES wpisy_pracy(pozycja_id) ON DELETE CASCADE,
    FOREIGN KEY (zatwierdzone_przez) REFERENCES uzytkownicy(uzytkownik_id) ON DELETE SET NULL
);

CREATE INDEX idx_uzytkownik_data ON wpisy_pracy(uzytkownik_id, data);
CREATE INDEX idx_uzytkownik_data_nieobecnosci ON nieobecnosci(uzytkownik_id, data_nieobecnosci);

DELIMITER $$
CREATE TRIGGER before_user_insert
BEFORE INSERT ON uzytkownicy
FOR EACH ROW
BEGIN
    SET NEW.login = LOWER(CONCAT(NEW.imie, '.', NEW.nazwisko));
END $$
DELIMITER;

EOF;

$file .= "\n";
$file .= $tables_insert;

file_put_contents("backup.sql", $file);
echo "<a id='pobierz' href='backup.sql'>Pobierz plik</a>
<script>
    document.getElementById('pobierz').click();
</script>";

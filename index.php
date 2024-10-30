<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['start_sesji'])) {
	header("Location: login.php");
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
			var d = new Date();
			const startCzasu = <?php echo $x; ?>;
			const czasObj = document.getElementById("czas");
			czasNieaktywnosci = d.getTime();

			LiczCzas();
			const xddd = setInterval(LiczCzas, 1000);

			function LiczCzas() {
                d = new Date();
                const czasTeraz = d.getTime();
                const roznica = czasTeraz - czasNieaktywnosci;

				// nieaktywnosc
                console.log(`d.getTime(): ${d.getTime()} | czasNieaktywnosci: ${czasNieaktywnosci} | diff: ${d.getTime() -= czasNieaktywnosci}`);
				if (roznica >= 600*1000) {
                    console.log(`nastepuje wylogowywanie`);
					clearInterval(xddd);
                    setTimeout(Logout,1000);
				}

				// czas
				let czas = Math.floor(d.getTime()/1000) - startCzasu;
				let h = Math.floor(czas/60/60);
				let m = Math.floor(czas/60%60);
				let s = czas%60;
				czasObj.innerHTML = "Czas sesji: "+ 
				((h >= 1)?h+":":"") +
				((m < 10)?(m == 0)?"00":"0"+m:m) + ":" + 
				((s < 10)?(s == 0)?"00":"0"+s:s);
			}

			document.addEventListener("mousemove",ResetNieaktywnosci)
			function ResetNieaktywnosci() {
                d = new Date();
				czasNieaktywnosci = d.getTime();
			}
			
			function Logout() {
				location.replace("logout.php");
			}
		</script>

        <!-- Tabela -->
		<?php
			$idp = mysqli_connect("localhost","website","mySmGZ@04d5*J85o","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");

			$idd = mysqli_query($idp,"SELECT * FROM pracownicy");
			$code = "<table><tr><th>
				ID</th><th>
				Imie</th><th>
				Nazwisko</th><th>
				Godziny pracy</th></tr>";
			while ($row= mysqli_fetch_row($idd)) {
				$code .= "<tr><td>$row[3]</td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
			}
			$code .= "</table>";
			echo $code;
			mysqli_close($idp);
		?>
    </main>
</body>
</html>

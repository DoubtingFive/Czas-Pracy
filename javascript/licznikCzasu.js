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
	if (roznica >= 600*1000) {
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
	location.replace("php/logowanie/wyloguj.php");
}

<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['id'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
	header("Location: ../logowanie/login.php");
    exit();
}
if (!(bool)$_SESSION['is_admin']) {die("Nie masz dostępu");}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['id'],$_POST['kom']))
	$id = $_POST['id'];
	$kom = $_POST['kom'];
	$id = explode(";",$id);
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
	$sql = "INSERT INTO zatwierdzenia(`pozycja_id`,	`zatwierdzone_przez`,`zatwierdzono` , `zatwierdzenie_data`, `komentarz`) VALUES ($id[0],'".$_SESSION['id']."','$id[1]','".date("Y-m-d H:i:s")."','Nieobecność. $kom');";
	echo $sql;
	$idd = mysqli_query($idp,$sql);
	echo "\n$idd\n";
	$sql = "UPDATE nieobecnosci SET zatwierdzone=$id[1] WHERE nieobecnosc_id='$id[0]';";
	echo $sql;
	$idd = mysqli_query($idp,$sql);
	echo "\n$idd";
	mysqli_close($idp);
	header("location: zatwierdzanie.php");
}

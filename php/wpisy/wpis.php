<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['id'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
	header("Location: ../logowanie/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['data1'],$_POST['roz'],$_POST['zak']))
	$dzien = $_POST['data1'];
	$roz = $_POST['roz'];
	$zak = $_POST['zak'];
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
	$sql = "INSERT INTO wpisy_pracy(`uzytkownik_id`,`data`, `godzina_rozpoczecia`,`godzina_zakonczenia`) VALUES ('".$_SESSION['id']."','$dzien','".$roz."0000','".$zak."0000');";
	$idd = mysqli_query($idp,$sql);
	mysqli_close($idp);
	header("location: ../../index.php");
}

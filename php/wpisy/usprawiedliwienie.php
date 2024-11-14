<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['id'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
	header("Location: ../logowanie/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['data2'],$_POST['przyczyna']))
	$dzien = $_POST['data2'];
	$roz = $_POST['przyczyna'];
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
	$sql = "INSERT INTO nieobecnosci(`uzytkownik_id`,`data_nieobecnosci`, `przyczyna`) VALUES ('".$_SESSION['id']."','$dzien','$przyczyna');";
	$idd = mysqli_query($idp,$sql);
	mysqli_close($idp);
	header("location: ../../index.php?uspr=success");
}
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
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
	$sql = "INSERT INTO zatwierdzenia(`pozycja_id`,	`zatwierdzone_przez`, `zatwierdzenie_data`, `komentarz`) VALUES ($id,'".$_SESSION['id']."','".date("Y-m-d h:m:s")."','$kom');";
	mysqli_query($idp,$sql);
	$sql = "UPDATE wpisy_pracy SET zatwierdzone=1 WHERE pozycja_id='$id';";
	mysqli_query($idp,$sql);
	mysqli_close($idp);
	header("location: zatwierdzanie.php");
}

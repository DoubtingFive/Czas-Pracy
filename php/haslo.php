<?php
session_start();
if (!isset($_SESSION['login'], $_SESSION['id'], $_SESSION['start_sesji'], $_SESSION['is_admin'])) {
	header("Location: ../logowanie/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['password'],$_POST['newPassword']))
	$old = $_POST['password'];
	$new = $_POST['newPassword'];
	$idp = mysqli_connect("localhost","website","5mu4fDGv_Q58NbXV","pracownicy") or die("Nie udalo sie polaczyc z baza danych pracownicy");
	$sql = "SELECT haslo FROM uzytkownicy WHERE uzytkownik_id=".$_SESSION['id'];
	echo $sql;
	$idd = mysqli_query($idp,$sql);
	$idd = mysqli_fetch_array($idd);
	if ($idd[0] == $old) {
		$sql = "UPDATE uzytkownicy SET haslo='$new' WHERE uzytkownik_id=".$_SESSION['id'];
		echo $sql;
		$idd = mysqli_query($idp,$sql);
		mysqli_close($idp);
		if ($idd==1) header("location: ../index.php?passwd=success");
		else header("location: ../index.php?passwd=error");
	} else {
		mysqli_close($idp);
		header("location: ../index.php?passwd=wrong");
	}
}

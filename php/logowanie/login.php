<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/styl.css?v=1.1">
    <link rel="stylesheet" href="../../style/login.css?v=1.1">
    <title>Czas Pracy Pracowników</title>
</head>
<body>
    <div id="baner">
        <h1>Czas Pracy Pracowników</h1>
    </div>
	<div id="kontent">
        <fieldset>
            <legend>Logowanie</legend>
		<?php include 'zaloguj.php';?>
        </fieldset>
    </div id="kontent">
</body>
</html>

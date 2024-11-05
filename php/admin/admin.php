<?php
$status = null;
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}
if ((bool)$_SESSION['is_admin']) {
    echo '
    <div>
        <button id="adminPanel" onclick="RozwinPanelAdmina();">Panel Administracyjny</button>
        <div id="administracja" style="position: fixed; bottom: -30vh; transition: bottom 0.3s;">
            <form action="php/admin/rekord.php" method="POST">
                <label>Imie</label>
                <input type="text" name="imie" id="imie" required>
                <label>Nazwisko</label>
                <input type="text" name="naz" id="naz" required>
                <label>Hasło</label>
                <input type="password" name="haslo" id="haslo" required>
                <label>Rola</label>
                <select name="rola" id="rola">
                    <option value="admin">Admin</option>
                    <option value="pracownik" selected>Pracownik</option>
                </select>
                <input type="submit" value="Dodaj">
            </form>
            ';
            if ($status == 'sukces') {
                echo "<p style='color: lime;'>Użytkownik został pomyślnie dodany.</p>";
            } elseif ($status == 'blad') {
                echo "<p style='color: red;'>Nie udało się dodać użytkownika.</p>";
            }
            echo '
        </div>
        <script>
            const panel = document.getElementById("administracja");
            const button = document.getElementById("adminPanel");
            function RozwinPanelAdmina() {
                if (panel.style.bottom === "-30vh") {
                    panel.style.bottom = "0";
                    button.style.bottom = "30.5vh"; // Move button when panel is shown
                } else {
                    panel.style.bottom = "-30vh";
                    button.style.bottom = ".5vh"; // Reset button position when hidden
                }
            }
            ';
            if ($status != null) {
                echo "RozwinPanelAdmina()";
            }
            echo '
        </script>
    </div>';
}

<?php
if ((bool)$_SESSION['is_admin']) {
    echo '
    <div>
        <button id="adminPanel" onclick="RozwinPanelAdmina(this);">Panel Administracyjny</button>
        <div id="administracja" style="position: fixed; bottom: -30vh; transition: bottom 0.3s;">
            <form action="admin/rekord.php" method="POST">
                <label>Login</label>
                <input type="text" name="login" id="login" required>
                <label>Hasło</label>
                <input type="password" name="pass" id="pass" required>
                <input type="submit" value="Zaloguj">
            </form>
        </div>
        <script>
            const panel = document.getElementById("administracja");
            function RozwinPanelAdmina(button) {
                if (panel.style.bottom === "-30vh") {
                    panel.style.bottom = "0";
                    button.style.bottom = "30.5vh"; // Move button when panel is shown
                } else {
                    panel.style.bottom = "-30vh";
                    button.style.bottom = ".5vh"; // Reset button position when hidden
                }
            }
        </script>
    </div>';
}

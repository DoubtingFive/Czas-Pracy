<?php
if ($_SESSION['is_admin'] === '1') {
    echo `
    <div>
        <button id="adminPanel" onclick="RozwinPanelAdmina(this);"></button>
        <div id="administracja">
            <form action="admin/rekord.php" method="POST">
                <label>Login</label>
                <input type="text" name="login" id="login" required>
                <label>Hasło</label>
                <input type="password" name="pass" id="pass" required>
                <input type="submit" value="Zaloguj">
            </form>
        </div>
        <script>
            const panel = document.getElementById('administracja');
            const calosc = document.getElementById('calosc');
            function RozwinPanelAdmina(x) {
                if (panel.style.bottom === '-30vh') {
                    panel.style.bottom = '0';
                    x.style.bottom = "30.5vh";
                } else {
                    panel.style.bottom = '-30vh';
                    x.style.bottom = ".5vh";
                }
            }
            RozwinPanelAdmina(document.getElementById("adminPanel"))
        </script>
    </div>`;
}

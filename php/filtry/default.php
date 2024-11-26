<?php
echo '<div id="filtry">
<fieldset>
    <legend>Filtry</legend>
        <label>Wyświetlanych rekordów:</label>
        <select name="rec" id="rec" onchange="RecordLimit(this.value);">
            <option>10</option>
            <option selected>25</option>
            <option>50</option>
            <option>100</option>
            <option>250</option>
            <option>500</option>
        </select><br>';
        if ((bool)$_SESSION['is_admin']) {
            echo '<label>Imie:</label>
            <input type="text" name="imie2" id="imie2" oninput="Filter(this.value,1);"><br>
            <label>Nazwisko:</label>
            <input type="text" name="naz2" id="naz2" oninput="Filter(this.value,2);"><br>';
        }
        echo <<<'EOT'
        <label>Godziny pracy:</label>
        <input type="number" name="hours" id="hours" oninput="Filter(this.value,6);"><br>
        <label>Godzina rozpoczęcia pracy:</label>
        <input type="number" name="godzina_rozpoczecia" id="godzina_rozpoczecia" oninput="Filter(this.value,4,':00:00');"><br>
        <label>Godzina zakończenia pracy:</label>
        <input type="number" name="godzina_zakonczenia" id="godzina_zakonczenia" oninput="Filter(this.value,5,':00:00');"><br>
        <input type="date" name="dataOd" id="dataOd" onchange="FilterDate();"> -
        <input type="date" name="dataDo" id="dataDo" onchange="FilterDate();"><br>
        <br>
        <button name="pageDown" id="pageDown" onclick="ChangePage(-1)"><-</button>
        <select name="page" id="page" onchange="ChangePage(this.value,true)"></select>
        <button name="pageUp" id="pageUp" onclick="ChangePage(1)">-></button><br>
        <label>Tylko zatwierdzone (<span id="confirmed"></span>):</label>
        <input type="checkbox" name="checkedOnly" id="checkedOnly" onchange='
        Filter((this.checked?"<span class=\"circle filled\"></span>":""),7);
        document.getElementById("notCheckedOnly").checked = false'><br>

        <label>Tylko niezatwierdzone (<span id="notConfirmed"></span>):</label>
        <input type="checkbox" name="notCheckedOnly" id="notCheckedOnly" onchange='
        Filter((this.checked?"<span class=\"circle empty\"></span>":""),7);
        document.getElementById("checkedOnly").checked = false'>

    <p>Znaleziono <span style="color:aqua" id="founded">0</span> rekordów</p>
    <button id="clear-filers" onclick="ClearFilters()">Wyczyść filtry</button>
</fieldset>
</div>
<script src="javascript/filtry.js"></script>
<script src="javascript/przyciski.js"></script>
EOT;
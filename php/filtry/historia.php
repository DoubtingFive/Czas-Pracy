<?php
if (!(bool)$_SESSION['is_admin']) {exit();}
echo <<<'EOT'
<div id="filtry">
    <fieldset>
        <legend>Filtry</legend>
        <label>Wyświetlanych rekordów:</label>
        <select name="rec" id="rec" onchange="RecordLimit(this.value);">
            <option>5</option>
            <option>10</option>
            <option selected>25</option>
            <option>50</option>
            <option>100</option>
            <option>250</option>
            <option>500</option>
        </select><br>
        <fieldset>
            <legend>Rekord</legend>
            <!-- Only admin -->
            <label>Imie:</label>
            <input type="text" name="imie2" id="imie2" oninput="Filter(this.value,2,'',1);"><br>
            <label>Nazwisko:</label>
            <input type="text" name="naz2" id="naz2" oninput="Filter(this.value,2,'',2);"><br>
            <label>Godziny pracy:</label>
            <input type="number" name="hours" id="hours" oninput="Filter(this.value,2,'',6);"><br>
            <label>Godzina rozpoczęcia pracy:</label>
            <input type="number" name="godzina_rozpoczecia" id="godzina_rozpoczecia" oninput="Filter(this.value,2,':00:00',4);"><br>
            <label>Godzina zakończenia pracy:</label>
            <input type="number" name="godzina_zakonczenia" id="godzina_zakonczenia" oninput="Filter(this.value,2,':00:00',5);"><br>
            <input type="date" name="dataOd1" id="dataOd1" onchange="FilterDateTable();"> -
            <input type="date" name="dataDo1" id="dataDo1" onchange="FilterDateTable();"><br>
            <br>
            <label>Tylko zatwierdzone (<span id="confirmed"></span>):</label>
            <input type="checkbox" name="checkedOnly" id="checkedOnly" onchange='
            Filter((this.checked?"<span class=\"circle filled\"></span>":""),2,'',7);
            document.getElementById("notCheckedOnly").checked = false'><br>

            <label>Tylko niezatwierdzone (<span id="notConfirmed"></span>):</label>
            <input type="checkbox" name="notCheckedOnly" id="notCheckedOnly" onchange='
            Filter((this.checked?"<span class=\"circle empty\"></span>":""),2,'',7);
            document.getElementById("checkedOnly").checked = false'>
        </fieldset><br>
        
        <input type="date" name="dataOd" id="dataOd" onchange="FilterDate();"> -
        <input type="date" name="dataDo" id="dataDo" onchange="FilterDate();"><br>

        <label>Zatwierdzenia (<span id="confirmed"></span>):</label>
        <input type="checkbox" name="conf" id="conf" onchange='
        Filter((this.checked?"<span class=\"circle filled\"></span>":""),4);
        document.getElementById("notconf").checked = false'><br>

        <label>Cofniecie zatwierdzenia (<span id="notConfirmed"></span>):</label>
        <input type="checkbox" name="notconf" id="notconf" onchange='
        Filter((this.checked?"<span class=\"circle empty\"></span>":""),4);
        document.getElementById("conf").checked = false'><br>

        <label>Komentarz:</label>
        <input type="text" name="komentarz" id="komentarz" oninput="Filter(this.value,5);"><br>

        <br>
        <button name="pageDown" id="pageDown" onclick="ChangePage(-1)"><-</button>
        <select name="page" id="page" onchange="ChangePage(this.value,true)"></select>
        <button name="pageUp" id="pageUp" onclick="ChangePage(1)">-></button><br>
        
        <p>Znaleziono <span style="color:aqua" id="founded">0</span> rekordów</p>
        <button id="clear-filers" onclick="ClearFilters()">Wyczyść filtry</button>
    </fieldset>
</div>
<script src='javascript/historiaFiltry.js'></script>
EOT;
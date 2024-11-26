const tableToggleBtn = document.getElementById('tabela-toggle');
const notConf = document.getElementById('notConfirmed');
const conf = document.getElementById('confirmed');
let isUspr = false;
function TableToggle() {
    isUspr = !isUspr;
    table = isUspr?usprTable:wpisyTable;
    wpisyTable.style.display = isUspr?'none':'block';
    usprTable.style.display = isUspr?'block':'none';
    CalculateConfirms();
}
function CalculateConfirms() {
    tableToggleBtn.innerText = isUspr?'Wpisy':'Usprawiedliwienia';
    tableValue = isUspr?usprVal:wpisyVal;
    sum = 0;
    _tableValue = tableValue.split("<tr>");
    if (!_tableValue) return;
    for (i=1;i<_tableValue.length-1;i++) {
        if (_tableValue[i].search("<td") == -1)
            continue;
        if (_tableValue[i].split("<td")[isUspr?4:7].search("filled") != -1) {
            sum++;
        }
    }
    conf.innerText = sum;
    notConf.innerText = (isUspr?ileUspr:ileWpisow)-sum;
    founded.innerText = (isUspr?ileUspr:ileWpisow);
}
function ConfirmAll() {
    if (!confirm("Na pewno chcesz zatwierdzić wszystkie widoczne rekordy?")) return;
    const empty = document.getElementsByClassName("circle empty");
	wlaczKomentarz = false;
    tableValue = wpisyVal;
    
    for (i=0;i<empty.length;i++) {
        empty[i].parentElement.click()
    }
	wlaczKomentarz = true;
    alert(`Pomyślnie zatwierdzono ${empty.length} rekordów.`)
    document.location.reload();
}
function ClearFilters() {
    document.location.reload();
}
CalculateConfirms()
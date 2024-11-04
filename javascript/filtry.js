const table = document.getElementsByTagName("table")[0];
const pageDropdown = document.getElementById("page");
const tableValue = table.innerHTML;
var filteredValue = tableValue;
var recordLimit = 25;
var page = 0;
var pagesCount = 0;
var pagesModulo = 0;
function RecordLimit(records) {
    if (recordLimit != records) {
        page *= recordLimit/records;
    }
    pagesCount = 0;
    pagesModulo = 0;

    recordLimit = showRecords = records;
    _tableValue = filteredValue.split("</tr>");

    if (records > _tableValue.length-2) showRecords = _tableValue.length-2;
    if (records == _tableValue.length-2) page = 0; pagesCount = 1; pagesModulo = 0; pageDropdown.style.display = "none";
    if (records < _tableValue.length-2) {
        pagesCount = Math.floor((_tableValue.length-2)/records)
        pagesModulo = (_tableValue.length-2)%records
        code = ""
        for (i=1;i<pagesCount+1;i++) {
            code += "<option>"+i+"</option>";
        }
        pageDropdown.style.display = "block";
        pageDropdown.innerHTML = code;
        pageDropdown.value = Math.round(page+1);
    }
    
    tableScore = _tableValue[0];
    for (i=Math.round(page*records)+1;i<=Math.round(parseInt(showRecords)+(page*records));i++) {
        if (_tableValue[i] != undefined)
            tableScore +=_tableValue[i] + "</tr>";
    }

    table.innerHTML = tableScore;
}
function FilterHours(filter) {
    _tableValue = tableValue.split("</tr>");

    filteredValue = _tableValue[0];

    for (i=1;i<_tableValue.length-1;i++) {
        if (_tableValue[i].search("<td>") == -1) break;
        if (_tableValue[i].split("<td>")[4].search(filter) != -1) {
            filteredValue += _tableValue[i] + "</tr>";
        }
    }
    filteredValue += _tableValue[_tableValue.length-1];
    RecordLimit(recordLimit)
}
function ChangePage(change,force=false) {
    if (force)
        page = change-1;
    else{
        page += change;
        if(page < 0) page = 0
        if(page >= pagesCount) {
            if (pagesModulo > 0)
                page = pagesCount
            else page = pagesCount-1
        }
    }
    pageDropdown.value = Math.round(page+1);
    RecordLimit(recordLimit);
}
RecordLimit(recordLimit);

const table = document.getElementsByTagName("table")[0];
const tableValue = table.innerHTML;
var filteredValue = tableValue;
var recordLimit = 25;
function RecordLimit(records) {
    recordLimit = records;
    _tableValue = filteredValue.split("</tr>");
    if (records > _tableValue.length-2) records = _tableValue.length-2
    tableScore = "";
    for (i=0;i<=records;i++) {
        tableScore +=_tableValue[i] + "</tr>";
    }
    table.innerHTML = tableScore;
}
function FilterHours(filter) {
    _tableValue = tableValue.split("</tr>");
    
    filteredValue = _tableValue[0];

    console.log("##################")

    for (i=1;i<tableValue.length-1;i++) {
        if (_tableValue[i].search("<td>") == -1) break;
        if (_tableValue[i].split("<td>")[4].search(filter) != -1) {
            filteredValue += _tableValue[i] + "</tr>";
        }
    }
    filteredValue += _tableValue[tableValue.length-1];
    RecordLimit(recordLimit)
}
RecordLimit(25);

const table = document.getElementsByTagName("table")[0];
const tableValue = table.innerHTML;
var recordLimit = 25
function RecordLimit(records) {
    recordLimit = records
    _tableValue = tableValue.split("</tr>");
    tableScore = "";
    for (i=0;i<=records;i++) {
        tableScore +=_tableValue[i] + "</tr>";
    }
    table.innerHTML = tableScore;
}
RecordLimit(25)
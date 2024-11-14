const wpisyTable = document.getElementById('lista-pracownikow');
const usprTable = document.getElementById('lista-usprawiedliwien');
const pageDropdown = document.getElementById("page");
const dataFrom = document.getElementById("dataOd");
const dataTo = document.getElementById("dataDo");
const founded = document.getElementById("founded");
const ileWpisow = wpisyTable.innerHTML.split("<tr>").length-2;
const ileUspr = usprTable.innerHTML.split("<tr>").length-2;
let wpisyVal = wpisyTable.innerHTML;
let usprVal = usprTable.innerHTML;
var table = wpisyTable;
var tableValue = wpisyVal;
var filteredValue = tableValue;
var recordLimit = 25;
var page = 0;
var pagesCount = 0;
var pagesModulo = 0;
var filters = []
var types = []
var dates = ['']
function RecordLimit(records) {
    if (recordLimit != records) {
        page *= recordLimit/records;
    }
    pagesCount = 0;
    pagesModulo = 0;

    let showRecords = recordLimit = records;
    _tableValue = filteredValue.split("</tr>");

    if (records >= _tableValue.length-2) {
        showRecords = _tableValue.length-2;
        page = 0;
        pagesCount = 1;
        pagesModulo = 0;
        pageDropdown.style.display = "none";
    }
    else if (records < _tableValue.length-2) {
        pagesCount = Math.floor((_tableValue.length-2)/records)
        pagesModulo = (_tableValue.length-2)%records
        let code = ""
        for (i=1;i<pagesCount+1+(pagesModulo>0)?1:0;i++) {
            code += "<option>"+i+"</option>";
        }
        pageDropdown.style.display = "block";
        pageDropdown.innerHTML = code;
        pageDropdown.value = Math.round(page+1);
    }
    
    let tableScore = _tableValue[0] + "</tr>";
    for (i=Math.round(page*records)+1;i<=Math.round(parseInt(showRecords)+(page*records));i++) {
        if (_tableValue[i] != undefined)
            tableScore +=_tableValue[i] + "</tr>";
    }

    table.innerHTML = tableScore;
    founded.innerText = filteredValue.split("<tr>").length-2;
}
function Filter(filter,type,force = "") {
    const index = types.indexOf(type);
    if (index > -1) {
        filters.splice(index, 1);
        types.splice(index, 1);
    }
    if (filter != null && filter != "") {
        filter += force;
        filters.push(filter);
        types.push(type);
    }
    let _tableValue = tableValue.split("</tr>");

    filteredValue = _tableValue[0] + "</tr>";

    for (i=1;i<_tableValue.length-1;i++) {
        if (_tableValue[i].search("<td") == -1) continue;
        isFiltred = false
        for (j=0;j<filters.length;j++) {
            // if (types[j] <= 3) {
            //     console.log(`j: ${j}`);
            //     console.log(`types[j]: ${types[j]}`);
            //     console.log(`filters[j]: ${filters[j]}`);
            //     console.log(`_tableValue[i]: ${_tableValue[i]}`);
            //     console.log(`_tableValue[i].split("<td"): ${_tableValue[i].split("<td")}`);
            //     console.log(`_tableValue[i].split("<td")[types[j]]: ${_tableValue[i].split("<td")[types[j]]}`);
            //     console.log(`_tableValue[i].split("<td")[types[j]].toLowerCase(): ${_tableValue[i].split("<td")[types[j]].toLowerCase()}`);
            //     console.log(`_tableValue[i].split("<td")[types[j]].toLowerCase().search(filters[j]): ${_tableValue[i].split("<td")[types[j]].toLowerCase().search(filters[j])}`);
            //     console.log(`_tableValue[i].split("<td")[types[j]].toLowerCase().search(filters[j].toLowerCase()): ${_tableValue[i].split("<td")[types[j]].toLowerCase().search(filters[j].toLowerCase())}`);
            // }
            if (_tableValue[i].split("<td")[types[j]].toLowerCase().search(filters[j].toLowerCase()) != -1) {
                continue;
            }
            isFiltred = true;
        }
        if (isFiltred) continue;
        if (dates) isFiltred = true
        for (j=0;j<dates.length;j++) {
            if (_tableValue[i].split("<td")[3].search(dates[j]) != -1) {
                isFiltred = false
                break;
            }
        }
        if (isFiltred) continue;
        filteredValue += _tableValue[i] + "</tr>";
    }
    filteredValue += _tableValue[_tableValue.length-1];
    RecordLimit(recordLimit)
}
function FilterDate() {
    dates = []
    if (dataFrom.value != '' && dataTo.value != '') {
        fromValue = dataFrom.value;
        toValue = dataTo.value;
        if (fromValue==toValue) dates = [fromValue];
        else {
            let dataToDays = new Date(dataTo.value).getDate()-new Date(dataFrom.value).getDate();
            for (i=0;i<dataToDays+1;i++){
                let d = new Date(dataFrom.value);
                let y = d.getFullYear();
                let m = parseInt(d.getMonth()+1+(i/31%12));
                let day = parseInt(d.getDate()+(i%31));

                dates.push(`${y}-${(m<10?`0${m}`:m)}-${(day<10?`0${day}`:day)}`);
            }
        }
    } else dates = [(dataFrom.value != ''?dataFrom.value:dataTo.value)]

    let _tableValue = tableValue.split("</tr>");

    filteredValue = _tableValue[0] + "</tr>";

    for (i=1;i<_tableValue.length-1;i++) {
        if (_tableValue[i].search("<td") == -1) break;
        isFiltred = false
        for (j=0;j<filters.length;j++) {
            if (_tableValue[i].split("<td")[types[j]].search(filters[j]) != -1) {
                continue;
            }
            isFiltred = true;
        }
        if (isFiltred) continue;
        if (dates) isFiltred = true
        for (j=0;j<dates.length;j++) {
            if (_tableValue[i].split("<td")[3].search(dates[j]) != -1) {
                isFiltred = false
                break;
            }
        }
        if (isFiltred) continue;
        filteredValue += _tableValue[i] + "</tr>";
    }
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
Filter("<span class=\"circle filled\"></span>",7)
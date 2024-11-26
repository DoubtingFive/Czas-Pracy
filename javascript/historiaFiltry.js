var tableConst = document.getElementById('zatwierdzenia-lista');
const pageDropdown = document.getElementById("page");
const dataFrom = document.getElementById("dataOd");
const dataTo = document.getElementById("dataDo");
const dataTableFrom = document.getElementById("dataOd1");
const dataTableTo = document.getElementById("dataDo1");
const founded = document.getElementById("founded");
let tableVal = tableConst.innerHTML;
var table = tableConst;
var tableValue = tableVal;
var filteredValue = tableValue;
var recordLimit = 25;
var page = 0;
var pagesCount = 0;
var pagesModulo = 0;
var filters = []
var types = []
var typesTable = []
var dates = []
var datesTable = []

function Initalization() {
    tableConst = document.getElementById('zatwierdzenia-lista');
    tableVal = tableConst.innerHTML;
    table = tableConst;
    tableValue = tableVal;
    filteredValue = tableValue;
    Filter("",1);
}

function RecordLimit(records) {
    if (recordLimit != records) {
        page *= recordLimit/records;
    }
    pagesCount = 0;
    pagesModulo = 0;

    let showRecords = recordLimit = records;
    let _tableValue = filteredValue.split("<tr id=\"base\">");

    if (records >= _tableValue.length-1) {
        showRecords = _tableValue.length-1;
        page = 0;
        pagesCount = 1;
        pagesModulo = 0;
        pageDropdown.style.display = "none";
    }
    else if (records < _tableValue.length-1) {
        pagesCount = Math.floor((_tableValue.length-1)/records)
        pagesModulo = (_tableValue.length-1)%records
        let code = ""
        for (let i=1;i<pagesCount+1+(pagesModulo>0)?1:0;i++) {
            code += "<option>"+i+"</option>";
        }
        pageDropdown.style.display = "block";
        pageDropdown.innerHTML = code;
        pageDropdown.value = Math.round(page+1);
        if (page >= pagesCount) page = pagesCount-1
    }
    
    _tableValue.splice(0,1)

    let tableScore = "<tr id=\"base\">"+ _tableValue[0];
    let j = Math.round(parseInt(showRecords)+(page*records))
    for (i=Math.round(page*records)+1;i<=j;i++) {
        if (_tableValue[i] != undefined) {
            tableScore += "<tr id=\"base\">" + _tableValue[i];
        }
    }

    table.innerHTML = tableScore;
    founded.innerText = filteredValue.split("<tr id=\"base\">").length-2;
}
function Filter(filter,type,force = "",typeTable = -1) {
    let index = -1;
    if (typeTable != -1) {
        index = typesTable.indexOf(typeTable);
    } else {
        index = types.indexOf(type);
    }
    if (index > -1) {
        filters.splice(index, 1);
        types.splice(index, 1);
        typesTable.splice(index, 1);
    }
    if (filter != null && filter != "") {
        filter += force;
        filters.push(filter);
        types.push(type);
        typesTable.push(typeTable);
    }
    FiltersCheck()
    // let _tableValue = tableValue.split("<tr id=\"base\">");
    // _tableValue.push("")

    // filteredValue = "<tr id=\"base\">" + _tableValue[0];
    // for (let i=1;i<_tableValue.length;i++) {
    //     if (_tableValue[i] == undefined) continue;
    //     if (_tableValue[i].search("<td") == -1) continue;
    //     isFiltred = false
    //     for (let j=0;j<filters.length;j++) {
    //         // console.log(`j: ${j}`);
    //         // console.log(`types[j]: ${types[j]}`);
    //         // console.log(`filters[j]: ${filters[j]}`);
    //         // console.log(`_tableValue[i]: ${_tableValue[i]}`);
    //         // console.log(`_tableValue[i].split("<td"): ${_tableValue[i].split("<td")}`);
    //         // console.log(`_tableValue[i].split("<td")[types[j]]: ${_tableValue[i].split("<td")[types[j]]}`);
    //         // console.log(`_tableValue[i].split("<td")[types[j]].toLowerCase(): ${_tableValue[i].split("<td")[types[j]].toLowerCase()}`);
    //         // console.log(`_tableValue[i].split("<td")[types[j]].toLowerCase().search(filters[j]): ${_tableValue[i].split("<td")[types[j]].toLowerCase().search(filters[j])}`);
    //         // console.log(`_tableValue[i].split("<td")[types[j]].toLowerCase().search(filters[j].toLowerCase()): ${_tableValue[i].split("<td")[types[j]].toLowerCase().search(filters[j].toLowerCase())}`);
    //         if (types[j] == 2) {
    //             if (_tableValue[i].split("<td id=\"base1\"")[types[j]].split("<tr>")[2].split("<td id=\"table\"")[typesTable[j]].toLowerCase().search(filters[j].toLowerCase()) != -1) {
    //                 continue;
    //             }
    //         }
    //         else if (_tableValue[i].split("<td id=\"base1\"")[types[j]].toLowerCase().search(filters[j].toLowerCase()) != -1) {
    //             continue;
    //         }
    //         isFiltred = true;
    //     }
    //     if (isFiltred) continue;
    //     if (dates) isFiltred = true
    //     for (let j=0;j<datesTable.length;j++) {
    //         if (_tableValue[i].split("<td id=\"base1\"")[2].split("<tr>")[2].split("<td id=\"table\"")[3].search(datesTable[j]) != -1) {
    //             isFiltred = false
    //             break;
    //         }
    //     }
    //     if (isFiltred) {
    //         for (let j=0;j<dates.length;j++) {
    //             if (_tableValue[i].split("<td id=\"base1\"")[3].search(dates[j]) != -1) {
    //                 isFiltred = false
    //                 break;
    //             }
    //         }
    //     }
    //     if (isFiltred) continue;
    //     filteredValue += "<tr id=\"base\">" + _tableValue[i];
    // }
    // filteredValue += _tableValue[_tableValue.length-1];
    // RecordLimit(recordLimit)
}
function FilterDate() {
    dates = []
    if (dataFrom.value != '' && dataTo.value != '') {
        let fromValue = dataFrom.value;
        let toValue = dataTo.value;
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
    FiltersCheck()
}
function FiltersCheck() {
    let _tableValue = tableValue.split("<tr id=\"base\">");
    _tableValue.push("")

    filteredValue = "<tr id=\"base\">" + _tableValue[0];
    for (let i=1;i<_tableValue.length;i++) {
        if (_tableValue[i] == undefined) continue;
        if (_tableValue[i].search("<td") == -1) continue;
        let isFiltred = false
        for (let j=0;j<filters.length;j++) {
            if (types[j] == 2) {
                if (_tableValue[i].split("<td id=\"base1\"")[types[j]].split("<tr>")[2].split("<td id=\"table\"")[typesTable[j]].toLowerCase().search(filters[j].toLowerCase()) != -1) {
                    continue;
                }
            }
            else if (_tableValue[i].split("<td id=\"base1\"")[types[j]].toLowerCase().search(filters[j].toLowerCase()) != -1) {
                continue;
            }
            isFiltred = true;
        }
        if (isFiltred) continue;
        if (datesTable.length > 0) {
            isFiltred = false
            for (let j=0;j<datesTable.length;j++) {
                if (_tableValue[i].split("<td id=\"base1\"")[2].split("<tr>")[2].split("<td id=\"table\"")[3].search(datesTable[j]) != -1) {
                    isFiltred = true
                    break;
                }
            }
            if (!isFiltred) continue;
        }
        if (dates.length > 0) {
            console.log("if (dates.length > 0) { = true")
            isFiltred = true
            for (let j=0;j<dates.length;j++) {
                if (_tableValue[i].split("<td id=\"base1\"")[3].search(dates[j]) != -1) {
                    isFiltred = false
                    break;
                }
            }
            if (isFiltred) continue;
        }
        filteredValue += "<tr id=\"base\">" + _tableValue[i];
    }
    RecordLimit(recordLimit)
}

function FilterDateTable() {
    datesTable = []
    if (dataTableFrom.value != '' && dataTableTo.value != '') {
        let fromTableValue = dataTableFrom.value;
        let toTableValue = dataTableTo.value;
        if (fromTableValue==toTableValue) datesTable = [fromTableValue];
        else {
            let dataToDays = new Date(dataTableTo.value).getDate()-new Date(dataTableFrom.value).getDate();
            for (i=0;i<dataToDays+1;i++){
                let d = new Date(dataTableFrom.value);
                let y = d.getFullYear();
                let m = parseInt(d.getMonth()+1+(i/31%12));
                let day = parseInt(d.getDate()+(i%31));
                
                datesTable.push(`${y}-${(m<10?`0${m}`:m)}-${(day<10?`0${day}`:day)}`);
            }
        }
    } else datesTable = [(dataTableFrom.value != ''?dataTableFrom.value:dataTableTo.value)]
    FiltersCheck()
    // let _tableValue = tableValue.split("<tr id=\"base\">");

    // filteredValue = "<tr id=\"base\">" + _tableValue[0];

    // for (let i=1;i<_tableValue.length-2;i++) {
    //     if (_tableValue[i].search("<td") == -1) break;
    //     isFiltred = false
    //     for (let j=0;j<filters.length;j++) {
    //         if (_tableValue[i].split("<td")[types[j]].search(filters[j]) != -1) {
    //             continue;
    //         }
    //         isFiltred = true;
    //     }
    //     if (isFiltred) continue;
    //     if (dates) isFiltred = true
    //     for (let j=0;j<datesTable.length;j++) {
    //         if (_tableValue[i].split("<td id=\"base1\"")[2].split("<tr>")[2].split("<td id=\"table\"")[3].search(datesTable[j]) != -1) {
    //             isFiltred = false
    //             break;
    //         }
    //     }
    //     if (isFiltred) {
    //         for (let j=0;j<dates.length;j++) {
    //             if (_tableValue[i].split("<td id=\"base1\"")[3].search(dates[j]) != -1) {
    //                 isFiltred = false
    //                 break;
    //             }
    //         }
    //     }
    //     if (isFiltred) continue;
    //     filteredValue += "<tr id=\"base\">" + _tableValue[i];
    // }
    // RecordLimit(recordLimit)
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
Initalization();
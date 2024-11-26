var prev = "";
var prevDirection = "ASC";

function SortWpisy(table, order_by, order_id) {
    let sort_direction;
    if (prev === order_by) {
        sort_direction = prevDirection === "ASC" ? "DESC" : "ASC";
        prevDirection = sort_direction;
    } else {
        prev = order_by;
        sort_direction = "ASC";
        prevDirection = sort_direction;
    }
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (table == 'wpisy') {
                wpisyTable.remove();
            } else if (table == 'uspr') {
                usprTable.remove();
            } else if (table == 'historia') {
                tableConst.remove();
            }
            const _content = document.getElementById("kontent");
            _content.innerHTML += this.responseText;
            if (this.responseText) Initalization();
        }
    };
    const url = `php/tabela/sortowanie.php?table=${table}&order_by=${order_by}&order_id=${order_id}&sort_direction=${sort_direction}${(table == 'uspr'?"&isUspr="+isUspr:"")}`;
    console.log(url)
    xhttp.open("GET", url, true);
    xhttp.send();
}

// function showHint(str) {
//   var xhttp;
//   if (str.length == 0) { 
//     document.getElementById("txtHint").innerHTML = "";
//     return;
//   }
//   xhttp = new XMLHttpRequest();
//   xhttp.onreadystatechange = function() {
//     if (this.readyState == 4 && this.status == 200) {
//       document.getElementById("txtHint").innerHTML = this.responseText;
//     }
//   };
//   xhttp.open("GET", "gethint.php?q="+str, true);
//   xhttp.send();   
// }
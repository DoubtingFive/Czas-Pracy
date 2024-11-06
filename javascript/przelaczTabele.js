const tableToggleBtn = document.getElementById('tabela-toggle');
const wpisyTable = document.getElementById('lista-pracownikow');
const usprTable = document.getElementById('lista-usprawiedliwien');
let isWpisy = true;
function TableToggle() {
    isWpisy = !isWpisy;
    tableToggleBtn.innerText = !isWpisy?'Usprawiedliwienia':'Wpisy';
    wpisyTable.style.display = isWpisy?'none':'block';
    usprTable.style.display = isWpisy?'block':'none';
}
TableToggle();
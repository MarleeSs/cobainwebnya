const divClipboard = document.querySelector('.divClipboard');
const btnClipboard = document.getElementById('btnClipboard');
const columnId = document.querySelectorAll('input');
const button = document.querySelectorAll('button');

btnClipboard.onclick = function () {
    const input = divClipboard.querySelector("input#columnId");
    document.execCommand("copy");
    button[0].classList.add('bg-success');
    columnId[0].classList.add('is-valid');
    setTimeout(function () {
        button[0].classList.remove("bg-success");
        columnId[0].classList.remove("is-valid");
    }, 2500);
}
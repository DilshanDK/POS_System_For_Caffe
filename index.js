

let x = document.getElementById("log");
let y = document.getElementById("reg");
let z = document.getElementById("logfrm");
let a = document.getElementById("regfrm");
let b = document.getElementById("frm");

function reg() {

    x.style.left = "-440px";
    y.style.left = "50px";
    a.style.color = "black";
    a.style.backgroundColor = "#16a085";
    z.style.backgroundColor = "white";
    z.style.color = "black";
    b.style.height = "535px";

}
function log() {

    x.style.left = "50px";
    y.style.left = "440px";
    z.style.backgroundColor = "#16a085";
    a.style.color = "black";
    a.style.backgroundColor = "white";
    b.style.height = "350px";
}

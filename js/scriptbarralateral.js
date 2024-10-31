function mostrarpopup() {
    var popup = document.querySelector("#popup");
    var contenedordepopup = document.querySelector(".contenedordepopup");
    contenedordepopup.setAttribute("style","backdrop-filter: blur(7px) opacity(8) grayscale(40%); ")
    popup.setAttribute("Style", "transform: scale(1);");
}
function ocultarpopup() {
    var popup = document.querySelector("#popup");
    var contenedordepopup = document.querySelector(".contenedordepopup");
    contenedordepopup.setAttribute("style","z-index:-1;") // le saca el fondo borroso y lo manda hacía el fondo de la página.
    popup.setAttribute("Style", "transform: scale(0);"); // encoje el popup
}



function mostrarmenu() {
    var slidebar = document.querySelector(".barralateral");
    var boton = document.querySelector(".botonbarralateral");
    var botoncerrar = document.querySelector(".cerrarbarralateral");
    botoncerrar.setAttribute("Style", "transform:scale(1)")
    slidebar.setAttribute("Style", "transform : translateX(0);");
    boton.setAttribute("Style", "transform:scale(0)");
}


function ocultarmenu() {
    var slidebar = document.querySelector(".barralateral");
    var boton = document.querySelector(".botonbarralateral");
    var botoncerrar = document.querySelector(".cerrarbarralateral");
    botoncerrar.setAttribute("Style", "transform: scale(0)")
    slidebar.setAttribute("Style", "transform : translateX(-100%);");
    boton.setAttribute("Style", "transform: scale(1)"); // vuelve a mostrar el boton
}
function alternar() {
    var español = document.querySelector(".español");
    var ingles = document.querySelector(".ingles");
    var boton = document.querySelector(".alternar")
    if (español.getAttribute("visible") == "si") {
        español.setAttribute("style", "display:none");
        ingles.setAttribute("style", "");
        español.setAttribute("visible", "no");
        boton.innerHTML = "Español";
    } else {
        español.setAttribute("style", "");
        ingles.setAttribute("style", "display:none");
        español.setAttribute("visible", "si");
        boton.innerHTML = "English";
    }

}
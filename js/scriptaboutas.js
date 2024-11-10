function alternar() {
    var español = document.querySelector(".español");
    var ingles = document.querySelector(".ingles");
    var boton = document.querySelector(".alternar")
    var infoespañol = document.querySelector(".infoespañol")
    var infoingles = document.querySelector(".infoingles")
    if (español.getAttribute("visible") == "si") {
        español.setAttribute("style", "display:none");
        infoespañol.setAttribute("style", "display:none");
        ingles.setAttribute("style", "");
        infoingles.setAttribute("style", "");
        español.setAttribute("visible", "no");
        boton.innerHTML = "Español";
    } else {
        español.setAttribute("style", "");
        infoespañol.setAttribute("style", "");
        ingles.setAttribute("style", "display:none");
        infoingles.setAttribute("style", "display:none");
        español.setAttribute("visible", "si");
        boton.innerHTML = "English";
    }

}
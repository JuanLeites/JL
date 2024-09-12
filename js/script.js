window.onload = function(){

    //declaramos cada ojo para ver contraseñas y le agregamos el evento
    var inputcontraseñaindex = document.querySelector(".contraseñadeindex");
    var ojoindex = document.querySelector(".ojoindex")
    ojoindex.addEventListener("click",()=>{alternar(inputcontraseñaindex,ojoindex)})

    var inputcontraseña
  }






  function alternar(inputdecontraseña, imagen) {
    if (inputdecontraseña.type == 'password') {
        inputdecontraseña.setAttribute('type', 'text')
        imagen.setAttribute('src', 'imagenes/ojoabierto.png')
    } else {
        inputdecontraseña.setAttribute('type', 'password')
        imagen.setAttribute('src', 'imagenes/ojocerrado.png')
    }
}
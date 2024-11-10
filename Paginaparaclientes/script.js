function cargarproductosparavender(filtro, pagina) {
    var contenedordetarjetas = document.querySelector(".contenedordeproductos");

    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apideproductos.php?filtro=' + filtro + '&pagina=' + pagina)
    //console.log('apideproductos.php?filtro='+filtro+'&pagina='+pagina);
    cargaDatos.send()
    cargaDatos.onload = function () {
        contenedordetarjetas.innerHTML = "";
        const productos = JSON.parse(this.responseText);
        if (productos.length < 20) {
            contenedordetarjetas.setAttribute("pagina", "ultima")
        }else{
            contenedordetarjetas.setAttribute("pagina", "")
        }

        productos.forEach(cadaproducto => {
            var tarjeta = document.createElement("div");
            tarjeta.setAttribute("class", "producto");
            
            var imagen = document.createElement("img");
            if (cadaproducto.Imagen.includes("IMAGENESSOFTWARE")) {
                imagen.setAttribute("src", "../" + cadaproducto.Imagen);
            } else if (cadaproducto.Imagen.includes("sinfoto.jpg")) {
                imagen.setAttribute("src", "../" + cadaproducto.Imagen);
            } else {
                imagen.setAttribute("src", cadaproducto.Imagen);
            }
            imagen.onerror = () => { imagen.src = "../imagenes/sinfoto.jpg" } // si la imagen llega a dar error, se le estableserá en la ruta. la foto por defecto

            tarjeta.appendChild(imagen);

            var titulo = document.createElement("h2");
            titulo.innerHTML = cadaproducto.Nombre;

            tarjeta.appendChild(titulo);

            var descripcion = document.createElement("p");
            descripcion.innerHTML = cadaproducto.Descripción;

            tarjeta.appendChild(descripcion);

            var spanconprecio = document.createElement("span")
            spanconprecio.setAttribute("class", "precio")
            let preciototal = parseInt(cadaproducto.Precio_Venta) + (parseInt(cadaproducto.Precio_Venta) / 100) * parseInt(cadaproducto.Valor);
            spanconprecio.innerHTML = "$" + Math.round(preciototal);

            tarjeta.appendChild(spanconprecio);
            contenedordetarjetas.appendChild(tarjeta);
        })
        var botonsiguiente = document.querySelector(".botonsiguiente");
        if (botonsiguiente && contenedordetarjetas.getAttribute("pagina") == "ultima") {
            botonsiguiente.setAttribute("style", "display:none;")
        }else{
            botonsiguiente.setAttribute("style", "")
        }
    }
}

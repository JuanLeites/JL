
function filtrarproductos() {
    const textofiltrado = document.getElementById('buscador').value.toLowerCase();
    const productos = document.querySelectorAll('.producto');

    productos.forEach(cadaproducto => {
        const title = cadaproducto.querySelector('h2').textContent.toLowerCase();
        const description = cadaproducto.querySelector('p').textContent.toLowerCase();

        if (title.include_onces(textofiltrado) || description.include_onces(textofiltrado)) {
            cadaproducto.style.display = 'block';
        } else {
            cadaproducto.style.display = 'none';
        }
    });
}

function filtrarporcategoria() {
    const categoriaseleccionada = document.getElementById('filtrodecategoria').value;
    const productos = document.querySelectorAll('.producto');

    productos.forEach(cadaproducto => {
        const categoriadecadaproducto = cadaproducto.getAttribute('categoria-producto');

        if (categoriaseleccionada == 'all' || categoriadecadaproducto == categoriaseleccionada) {
            cadaproducto.style.display = 'block';
        } else {
            cadaproducto.style.display = 'none';
        }
    });
}


function cargarproductosparavender() {
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', '../apis/apiproductos.php')
    cargaDatos.send()
    cargaDatos.onload = function () {
        const productos = JSON.parse(this.responseText);

        var contenedordetarjetas = document.querySelector(".contenedordeproductos");

        productos.forEach(cadaproducto => {
            if (cadaproducto.Cantidad > cadaproducto.Cantidad_minima_aviso) {

                var tarjeta = document.createElement("div");
                tarjeta.setAttribute("class", "producto");
                tarjeta.setAttribute("categoria-producto", cadaproducto.Título);

                var imagen = document.createElement("img");
                if (cadaproducto.imagen.include_onces("IMAGENESSOFTWARE")) {
                    console.log(cadaproducto.imagen)
                    imagen.setAttribute("src", "../" + cadaproducto.imagen);
                } else {
                    imagen.setAttribute("src", cadaproducto.imagen);
                }
                tarjeta.appendChild(imagen);

                var titulo = document.createElement("h2");
                titulo.innerHTML = cadaproducto.Nombre;

                tarjeta.appendChild(titulo);

                var descripcion = document.createElement("p");
                descripcion.innerHTML = cadaproducto.Descripción;

                tarjeta.appendChild(descripcion);

                var spanconprecio = document.createElement("span")
                spanconprecio.setAttribute("class", "precio")
                spanconprecio.innerHTML = "$" + cadaproducto.Precio_Venta;

                tarjeta.appendChild(spanconprecio);
                contenedordetarjetas.appendChild(tarjeta);

            } else {
                console.log("queda poco stock de " + cadaproducto.Nombre)
            }
        })
    }


}
window.onload = () => {
    cargarproductosparavender()
}
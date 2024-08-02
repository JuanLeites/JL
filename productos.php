<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Productos</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="buscador">
        <input type="text" placeholder="Buscar Productos">
    </div>
    <div class="contenedordemenu">
        <table>
            <tbody>
            </tbody>
        </table>
        <a href="agregarproductos.php" class="agregardato">+</a>
    </div>

    <?php include("barralateral.html") ?>
</body>
<script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
<link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
<script>
    window.onload = () => {
        cargarproductos()
        setInterval(() => {
            cargarproductos()
        }, 2000);
    }

    function asignar() {
    var eliminarproductos = document.querySelectorAll(".eliminarprod");// un querryselector all ya que hay muchos elementos con esta clase
    eliminarproductos.forEach(eliminarproducto => {// este foeeach recorre cada elemento que obtiene el query selector
        eliminarproducto.addEventListener("click", (evento) => {//al hacer click en el elemento
            evento.preventDefault();//prevenimos el evento por defecto, en este caso redirigirnos a el enlace href
            Swal.fire({
                title: "Estas Seguro?",
                text: "No podrás volver esta acción hacia atras!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "SI, Eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    /* 
                    accion para borrar el producto
                    eliminarproducto.href// la ruta, eliminar con esto
                    */
                   
                    Swal.fire({
                        title: "Eliminado!",
                        text: "El archivo a sido eliminado.",
                        icon: "success"
                    });
                }
            });
        });
    });
}


    function cargarproductos() {
        var tabla = document.querySelector("tbody");
        var cantidaddeelementosantes = tabla.children.length;
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproductos.php');
        cargaDatos.send()
        cargaDatos.onload = function() {
            const productos = JSON.parse(this.responseText);

            if (cantidaddeelementosantes - 1 != productos.length) {
                tabla.innerHTML = "<tr><th>ID</th><th>nombre</th><th>Precio Neto</th><th>codigo de barras</th><th>descripcion</th><th>marca</th><th>cantidad</th><th>cantidad de aviso</th><th>imagen</th><th>iva</th><th>medida</th><th>categoria</th><th>accion</th></tr>"
                productos.forEach(cadaproducto => {

                    var linea = document.createElement("tr");

                    function agregaralinea(dato) {
                        var objeto = document.createElement("td");
                        objeto.innerHTML = dato;
                        linea.appendChild(objeto);
                    }

                    agregaralinea(cadaproducto.ID_Producto);
                    agregaralinea(cadaproducto.Nombre);
                    agregaralinea(cadaproducto.Precio_Neto);
                    agregaralinea(cadaproducto.Código_de_Barras);
                    agregaralinea(cadaproducto.Descripción);
                    agregaralinea(cadaproducto.Marca);
                    agregaralinea(cadaproducto.Cantidad);
                    agregaralinea(cadaproducto.Cantidad_minima_aviso);

                    var imagen = document.createElement("img")
                    imagen.setAttribute("src", "IMAGENESSOFTWARE/" + cadaproducto.imagen)
                    imagen.setAttribute("id", "prod");
                    var objeto = document.createElement("td")
                    objeto.appendChild(imagen);
                    linea.appendChild(objeto);
                    agregaralinea(cadaproducto.ID_IVA);
                    agregaralinea(cadaproducto.ID_UNIDAD);
                    agregaralinea(cadaproducto.ID_CATEGORIA);
                    agregaralinea('<a href="eliminarproducto?id=' + cadaproducto.ID_Producto + '"><img src="imagenes/acciones/borrar.png" class="accion eliminarprod"></a><a href="modificarproducto?id=' + cadaproducto.ID_Producto + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')
                    tabla.appendChild(linea);

                })
                asignar()// luego de cargar todos los elementos, les asignamos los eventos
            }


        }
    }
</script>

</html>
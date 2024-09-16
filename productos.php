<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imagenes/icons/modproductos.png" type="image/x-icon">
</head>

<body>

    <div class="buscador">
        <input type="text" placeholder="Buscar Productos">
        <a href="agregarproductos.php" class="agregardato">+</a>
    </div>
    <div class="contenedordemenu">
        <table>
            <tbody>
            </tbody>
        </table>
    </div>
    

    <?php include("barralateral.html") ?>

</body>

<script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
<link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
<script type="module">
    import {asignarbotoneliminar} from "./js/funciones.js"
    window.onload = () => {
        cargarproductos()
        setInterval(() => {
            cargarproductos()
        }, 2000);
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

                    function agregaralinea(dato) {//funcion creada para agregar una linea a la tabla(columna)
                        var objeto = document.createElement("td");//crea el elemento td(columna)
                        objeto.innerHTML = dato;//le introduce el valor pasado por parametros
                        linea.appendChild(objeto);//le agrega a la fila(linea) el elemento creado por la funcion
                    }

                    agregaralinea(cadaproducto.ID_Producto);
                    agregaralinea(cadaproducto.Nombre);
                    agregaralinea(cadaproducto.Precio_Neto);
                    agregaralinea(cadaproducto.Código_de_Barras);
                    agregaralinea(cadaproducto.Descripción);
                    agregaralinea(cadaproducto.Marca);
                    agregaralinea(cadaproducto.Cantidad);
                    agregaralinea(cadaproducto.Cantidad_minima_aviso);

                    var imagen = document.createElement("img")//crea elemento imagen
                    imagen.setAttribute("src", "IMAGENESSOFTWARE/" + cadaproducto.imagen)//le setea el atriguto de la ruta el elemento que obtuvo de la base de datos(LARUTA)
                    imagen.setAttribute("id", "prod");// seteamos un id para  la imagen
                    var objeto = document.createElement("td")//creamos una columna
                    objeto.appendChild(imagen);//le agregamos la imagen a la columna
                    linea.appendChild(objeto);//agregamos la columna a la fila
                    agregaralinea(cadaproducto.Tipo);
                    agregaralinea(cadaproducto.Unidad);
                    agregaralinea(cadaproducto.Título);
                    agregaralinea('<img ruta="eliminar.php?tipo=producto&id=' + cadaproducto.ID_Producto + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificar/modificarproducto.php?id=' + cadaproducto.ID_Producto + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                    tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

                })
                asignarbotoneliminar();//llamamos a la funcion luego de haber cargado todos las filas que asignará para cada boton eliminar una funcion de confirmación.
            }


        }
    }

</script>

</html>
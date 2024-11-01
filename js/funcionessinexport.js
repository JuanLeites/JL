//función utilizada para eliminar cualquier elemento. dentro mostrará una alerta, la cual contiene una promesa, si esta es correcta, ejecuta una funcion que ejecuta una petición a una api por metodo GET la cual eliminará lo que se le pase por la ruta
function eliminarobjeto(ruta) {
    function eliminar(ruta) { //funcion que ejecuta archivo de eliminar el cual se le pasan dos parametros(el tipo de objeto que vamos a borrar y la id) con esto el archivo ejecuta una consulta en la base de datos la cual elimina el archivo
        const CONSULTA = new XMLHttpRequest();
        CONSULTA.open('GET', 'apis/' + ruta); //consulta a la api
        CONSULTA.send()
    }
    Swal.fire({//elemento de libreria(ALERTA PERSONALIZADA) 
        title: "Estas Seguro?",
        text: "No podrás volver esta acción hacia atras!",//elementos de la libreria
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        customClass: {
            popup: "alertas"  //le establecemos la clase alertas para poder personalizarlas
        },
        confirmButtonText: "SI, Eliminar!",
        toast: true, //toast para que aparezcan como notificacion (position:fixed)
    }).then((result) => {
        if (result.isConfirmed) {
            eliminar(ruta) //llamamos a la funcion eliminar y le pasamos como parametro lo que habiamos guardado en el elemento imagen con el nombre de "ruta" en la cual está guardada el tipo de elemento que es el que vamos a borrar y un id
            Swal.fire({
                title: "Eliminado!",
                text: "El Objeto a sido eliminado.",
                icon: "success",
                customClass: {
                    popup: "alertas"  //le establecemos la clase alertas para poder personalizarlas
                },
                toast: true

            });
        }
    });
}
function mostraravisosorteo() {
    Swal.fire({ //va a mostrar un objeto de la libreria(sweetalert)
        position: "center",
        title: "Al Realizar el sorteo todos los ticketes se estableceran en 0!!",
        icon: "info",
        customClass: {
            popup: "alertas"  // Añadimos una clase personalizada para poder mostrar bordes ya que la alerta no lo permite
        },
        toast: true,
        showConfirmButton: false
    })
}

function ocultaravisodesorteo() {
    setTimeout(() => { Swal.close() }, 1000);
}


function agregaraventa(id_producto, nombre, Precio_Neto, cantidaddisponible) {//recive 4 parametros, cantidad disponible es para que no pueda agregar mas productos de los que hay
    var inputdeenviar = document.querySelector(".botonenviar");
    inputdeenviar.disabled = false; // habilitamos el boton para poder enviar formulario para la venta
    var tabla = document.querySelector(".tabladeprductosagregados");//obtiene la tabla de productos agregados

    if (tabla.children.length == 0) { // cuenta los hijos de la tabla si son 0 agrega el encabezado esto lo hacemos dentro de la funcion agregar para que agregue la tabla al cargar un producto
        tabla.innerHTML = "<tr class='encabezadodeproductosseleccionados'><th>Nombre</th><th>Cantidad</th><th>Precio Neto</th><th>acción</th></tr>"
    }

    for (var i = 0; i < tabla.children.length; i++) {//recorre todos los elementos de la tabla en "tabla.children[i]" (los cuales serian todas las filas horizontales, las cuales tienen 5 elementos cada una)   (usamos for normal y no un foreach para poder interrumpirlo y que no sume repetidas veces)
        if (tabla.children[i].children[0].getAttribute("ID_PRODUCTO") == id_producto) { //compara todos los hijos[0] de cada fila de la tabla con la id del producto pasado por parametro a la funcion, si llegase a encontrar entra en el if
            if (parseInt(tabla.children[i].children[1].children[0].value) < parseInt(cantidaddisponible)) { //si el texto de cantidad es menor a la cantidad que queda disponible
                tabla.children[i].children[1].children[0].value = parseInt(tabla.children[i].children[1].children[0].value) + 1 // al entrar le va a sumar uno al valor del hijo
                return // al suman uno en la cantidad termina la función termuna la función aca
            } else {//si la cantidad disponible es menor a la cantidad que se va a usar en la compra
                mostrarmensaje("no queda mas stock de ese producto")
                return
            }
        }
    }
    //si no encuentra ninguno sigue con la función y carga el elemento:
    var linea = document.createElement("tr");
    function agregaralinea(dato) {//funcion creada para agregar una linea a la tabla(columna)
        var objeto = document.createElement("td");//crea el elemento td(columna)
        objeto.innerHTML = dato;//le introduce el valor pasado por parametros
        linea.appendChild(objeto);//le agrega a la fila(linea) el elemento creado por la funcion
    }

    var objeto = document.createElement("td");//crea el elemento td(columna)
    objeto.innerHTML = nombre;//le introduce el valor pasado por parametros
    objeto.setAttribute("ID_PRODUCTO", id_producto)
    linea.appendChild(objeto);//le agrega a la fila(linea) el elemento creado por la funcion

    agregaralinea("<input class='inputdecantidadesdeproductos' name='CANTIDAD[]' type='number' name='cantidad' min='1' value='1' max='" + cantidaddisponible + "' required>");
    agregaralinea(Precio_Neto)
    agregaralinea("<img src='imagenes/acciones/borrar.png' class='accion borrar'> </img> <img src='imagenes/acciones/agregar.png' class='accion sumar'></img><img src='imagenes/acciones/restar.png' class='accion restar' ></img>")
    var inputparalaid = document.createElement("input")
    inputparalaid.setAttribute("type", "hidden")
    inputparalaid.setAttribute("name", "IDPRODUCTOS[]")
    inputparalaid.setAttribute("value", id_producto)
    linea.appendChild(inputparalaid)

    tabla.appendChild(linea);
    linea.children[3].children[0].addEventListener("click", () => { eliminar(id_producto) })//le agregamos el evento a el hijo 0(en este caso la imagen de borrar) dentro del 4to hijo de la linea(la cual contiene las acciones)
    linea.children[3].children[1].addEventListener("click", () => { sumarenventa(id_producto, cantidaddisponible) })
    linea.children[3].children[2].addEventListener("click", () => { restar(id_producto) })
    //en el caso de arriba (linea.children[4] seria la celda numero 5 de la linea y los otros serian los hijos de esa linea)
}

function agregaracompra(id_producto, nombre, Precio_Neto) {
    var inputdeenviar = document.querySelector(".botonenviar");
    inputdeenviar.disabled = false; // habilitamos el boton para poder enviar formulario para la venta
    var tabla = document.querySelector(".tabladeprductosagregados");//obtiene la tabla de productos agregados

    if (tabla.children.length == 0) { // cuenta los hijos de la tabla si son 0 agrega el encabezado esto lo hacemos dentro de la funcion agregar para que agregue la tabla al cargar un producto
        tabla.innerHTML = "<tr class='encabezadodeproductosseleccionados'><th>Nombre</th><th>Cantidad</th><th>Precio Neto</th><th>acción</th></tr>"
    }

    for (var i = 0; i < tabla.children.length; i++) {//recorre todos los elementos de la tabla en "tabla.children[i]" (los cuales serian todas las filas horizontales, las cuales tienen 4 elementos cada una)   (usamos for normal y no un foreach para poder interrumpirlo y que no sume repetidas veces)
        if (tabla.children[i].children[0].getAttribute("ID_PRODUCTO") == id_producto) { //compara todos los atributos ID_PRODUCTO que se encuentran en el nombre de cada fila de la tabla , si llegase a encontrar entra en el if
            tabla.children[i].children[1].children[0].value = parseInt(tabla.children[i].children[1].children[0].value) + 1 // al entrar le va a sumar uno al valor del hijo
            return // al suman uno en la cantidad termina la función termuna la función aca
        }
    }

    //si no encuentra ninguno sigue con la función y carga el elemento:
    var linea = document.createElement("tr");
    function agregaralinea(dato) {//funcion creada para agregar una linea a la tabla(columna)
        var objeto = document.createElement("td");//crea el elemento td(columna)
        objeto.innerHTML = dato;//le introduce el valor pasado por parametros
        linea.appendChild(objeto);//le agrega a la fila(linea) el elemento creado por la funcion
    }

    var objeto = document.createElement("td");//crea el elemento td(columna)
    objeto.innerHTML = nombre;//le introduce el valor del nombre
    objeto.setAttribute("ID_PRODUCTO", id_producto) //le agregae el atributo id producto a la celda
    linea.appendChild(objeto);//le agrega a la fila(linea) la celda

    agregaralinea("<input class='inputdecantidadesdeproductos' name='CANTIDAD[]' min='1' type='number' name='cantidad' value='1'>");
    agregaralinea(Precio_Neto)
    agregaralinea("<img src='imagenes/acciones/borrar.png' class='accion borrar'> </img> <img src='imagenes/acciones/agregar.png' class='accion sumar'></img><img src='imagenes/acciones/restar.png' class='accion restar' ></img>")
    var inputparalaid = document.createElement("input")
    inputparalaid.setAttribute("type", "hidden")
    inputparalaid.setAttribute("name", "IDPRODUCTOS[]")
    inputparalaid.setAttribute("value", id_producto)
    linea.appendChild(inputparalaid)

    tabla.appendChild(linea);
    linea.children[3].children[0].addEventListener("click", () => { eliminar(id_producto) })//le agregamos el evento a el hijo 0(en este caso la imagen de borrar) dentro del 4to hijo de la linea(la cual contiene las acciones)
    linea.children[3].children[1].addEventListener("click", () => { sumar(id_producto) })
    linea.children[3].children[2].addEventListener("click", () => { restar(id_producto) })
    //en el caso de arriba (linea.children[4] seria la celda numero 5 de la linea y los otros serian los hijos de esa linea)
}


//funciones utilizadas dentro de la función agregarventa y agregarcompra: 
function restar(id_producto) {
    var tabla = document.querySelector(".tabladeprductosagregados");//obtiene la tabla de productos agregados
    for (var i = 0; i < tabla.children.length; i++) {//recorre todos los elementos de la tabla en "tabla.children[i]" (los cuales serian todas las filas horizontales, las cuales tienen 5 elementos cada una)   (usamos for normal y no un foreach para poder interrumpirlo y que no sume repetidas veces)
        if (tabla.children[i].children[0].getAttribute("ID_PRODUCTO") == id_producto) { //compara todos los hijos[0] de cada fila de la tabla con la id del producto pasado por parametro a la funcion, si llegase a encontrar entra en el if
            if (parseInt(tabla.children[i].children[1].children[0].value) == 1) { // si el contenido de children[2] que en este caso es lo que está dentro de "cantidad" es igual a 1 y fue llamada la función lo eliminamos
                eliminar(id_producto);
                return
            }
            tabla.children[i].children[1].children[0].value = parseInt(tabla.children[i].children[1].children[0].value) - 1 // al entrar le va a restar uno al valor del hijo
            return // al suman uno en la cantidad termina la función termuna la función aca
        }
    }
}
function eliminar(id_producto) {
    var tabla = document.querySelector(".tabladeprductosagregados");//obtiene la tabla de productos agregados
    for (var i = 0; i < tabla.children.length; i++) {//recorre todos los elementos de la tabla en "tabla.children[i]" (los cuales serian todas las filas horizontales, las cuales tienen 5 elementos cada una)   (usamos for normal y no un foreach para poder interrumpirlo y que no sume repetidas veces)
        if (tabla.children[i].children[0].getAttribute("ID_PRODUCTO") == id_producto) { //compara todos los hijos[0] de cada fila de la tabla con la id del producto pasado por parametro a la funcion, si llegase a encontrar entra en el if
            tabla.children[i].remove(); // elimina el elemento que tenga la id igual al producto
            if (tabla.children.length == 1) {
                tabla.innerHTML = "";
            }
            return //termina la función
        }
    }
}
function sumar(id_producto) {
    var tabla = document.querySelector(".tabladeprductosagregados");//obtiene la tabla de productos agregados
    for (var i = 0; i < tabla.children.length; i++) {//recorre todos los elementos de la tabla en "tabla.children[i]" (los cuales serian todas las filas horizontales, las cuales tienen 5 elementos cada una)   (usamos for normal y no un foreach para poder interrumpirlo y que no sume repetidas veces)
        if (tabla.children[i].children[0].getAttribute("ID_PRODUCTO") == id_producto) { //compara todos los hijos[0] de cada fila de la tabla con la id del producto pasado por parametro a la funcion, si llegase a encontrar entra en el if
            tabla.children[i].children[1].children[0].value = parseInt(tabla.children[i].children[1].children[0].value) + 1 // al entrar le va a sumar uno al valor del hijo
            return //termina la función
        }

    }
}
function sumarenventa(id_producto, cantidaddisponible) {
    //console.log("cantidadmaxima= " + cantidaddisponible);
    var tabla = document.querySelector(".tabladeprductosagregados");//obtiene la tabla de productos agregados
    for (var i = 0; i < tabla.children.length; i++) {//recorre todos los elementos de la tabla en "tabla.children[i]" (los cuales serian todas las filas horizontales, las cuales tienen 5 elementos cada una)   (usamos for normal y no un foreach para poder interrumpirlo y que no sume repetidas veces)
        if (tabla.children[i].children[0].getAttribute("ID_PRODUCTO") == id_producto) { //compara todos los hijos[0] de cada fila de la tabla con la id del producto pasado por parametro a la funcion, si llegase a encontrar entra en el if
            if (parseInt(tabla.children[i].children[1].children[0].value) < parseInt(cantidaddisponible)) {//parse int ya que toma el dato como string
                tabla.children[i].children[1].children[0].value = parseInt(tabla.children[i].children[1].children[0].value) + 1 // al entrar le va a sumar uno al valor del hijo
                return //termina la función
            } else {
                //console.log("has llegado al limite de productos");
                mostrarmensaje("no queda mas stock de ese producto")
                return
            }

        }
    }
}

//función utilizada dentro de sumarventa y agregaraventa.
function mostrarmensaje(mensaje) {
    const colores = new XMLHttpRequest();
    colores.open('GET', 'apis/apidecolores.php');
    colores.send();

    colores.onload = function () {
        // Obtenemos los datos en formato JSON
        const datos = JSON.parse(this.responseText);
        const colorPrincipal = datos.color_principal;
        const colorFondo = datos.color_fondo;

        Swal.fire({
            position: "center",
            title: mensaje,
            icon: "warning",
            background: colorFondo,
            color: colorPrincipal,
            customClass: {
                popup: "alertaconbordes"  // Añadimos una clase personalizada para poder mostrar bordes ya que la alerta no lo permite
            },
            toast: true,
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        });
    }
}
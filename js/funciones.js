export function asignarbotoneliminar() {
    function eliminar(ruta) { //funcion que ejecuta archivo de eliminar el cual se le pasan dos parametros(el tipo de objeto que vamos a borrar y la id) con esto el archivo ejecuta una consulta en la base de datos la cual elimina el archivo
        const CONSULTA = new XMLHttpRequest();
        CONSULTA.open('GET', 'apis/' + ruta); //consulta a la api
        CONSULTA.send()
    }

    var BOTONESELIMINAR = document.querySelectorAll(".eliminar"); // un querryselector all ya que hay muchos elementos con esta clase
    BOTONESELIMINAR.forEach(CADABOTON => { // este foeeach recorre cada elemento que obtiene el query selector
        CADABOTON.addEventListener("click", () => { //al hacer click en el elemento
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
                    eliminar(CADABOTON.getAttribute("ruta")) //llamamos a la funcion eliminar y le pasamos como parametro lo que habiamos guardado en el elemento imagen con el nombre de "ruta" en la cual está guardada el tipo de elemento que es el que vamos a borrar y un id
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
        });
    });

}
function asignarbotonsortear() {
    var BOTONESSORTEAR = document.querySelectorAll(".sortear");
    BOTONESSORTEAR.forEach(CADABOTON => {
        CADABOTON.addEventListener("mouseenter", () => {
            // al ingresar al botón de adveretencia 
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
        })
        CADABOTON.addEventListener("mouseleave", () => {
            Swal.close()
        })

    })
}



/* Funciones de carga de datos  */
export function cargarclientes(filtro) {
    var tabla = document.querySelector("tbody");
    var cantidaddeelementosantes = tabla.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiclientes.php?filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const clientes = JSON.parse(this.responseText);

        if (cantidaddeelementosantes - 1 != clientes.length) {

            tabla.innerHTML = "<tr><th>Cedula</th><th>Nombre</th><th>Deuda</th><th>Fecha de Nacimiento</th><th>Tickets</th><th>Contacto</th><th>RUT</th><th>Acción</th></tr>"
            clientes.forEach(cadacliente => {

                var linea = document.createElement("tr");

                function agregaralinea(dato) {
                    var objeto = document.createElement("td");
                    objeto.innerHTML = dato;
                    linea.appendChild(objeto);
                }
                agregaralinea(cadacliente.Cédula);
                agregaralinea(cadacliente.Nombre);
                agregaralinea(cadacliente.Deuda);
                agregaralinea(cadacliente.Fecha_de_Nacimiento);
                agregaralinea(cadacliente.Tickets_de_Sorteo);
                agregaralinea(cadacliente.Contacto);
                if (cadacliente.RUT == null) {
                    agregaralinea("no tiene");
                } else {
                    agregaralinea(cadacliente.RUT);
                }

                agregaralinea('<img ruta="eliminar.php?tipo=cliente&id=' + cadacliente.ID_CLIENTE + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarcliente.php?id=' + cadacliente.ID_CLIENTE + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                tabla.appendChild(linea);

            })
            asignarbotoneliminar();//llamamos a la funcion luego de haber cargado todos las filas.
        }


    }

}
export function cargarproductos(filtro) {
    var tabla = document.querySelector("tbody");
    var cantidaddeelementosantes = tabla.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const productos = JSON.parse(this.responseText);

        if (cantidaddeelementosantes - 1 != productos.length) {
            tabla.innerHTML = "<tr><th>nombre</th><th>Precio Compra</th><th>Precio Venta</th><th>Código de barras</th><th>Descripcion</th><th>Marca</th><th>Cantidad</th><th>Cantidad de aviso</th><th>imagen</th><th>iva</th><th>medida</th><th>categoria</th><th>accion</th></tr>"
            productos.forEach(cadaproducto => {

                var linea = document.createElement("tr");

                function agregaralinea(dato) {//funcion creada para agregar una celda a "linea" la cual es una fila de una tabla (tr)
                    var objeto = document.createElement("td");//crea el elemento td(celda)
                    objeto.innerHTML = dato;//le introduce el valor pasado por parametros a la celda
                    linea.appendChild(objeto);//le agrega a la fila(linea) el elemento creado por la funcion(la celda)
                }

                agregaralinea(cadaproducto.Nombre);
                agregaralinea(cadaproducto.Precio_Compra);
                agregaralinea(cadaproducto.Precio_Venta);
                agregaralinea(cadaproducto.Código_de_Barras);
                agregaralinea(cadaproducto.Descripción);
                agregaralinea(cadaproducto.Marca);
                agregaralinea(cadaproducto.Cantidad);
                agregaralinea(cadaproducto.Cantidad_minima_aviso);

                var imagen = document.createElement("img")//crea elemento imagen
                imagen.setAttribute("src", cadaproducto.imagen)//le setea el atriguto de la ruta el elemento que obtuvo de la base de datos(LARUTA)
                imagen.setAttribute("id", "prod");// seteamos un id para  la imagen
                imagen.setAttribute("alt", "Imágen de " + cadaproducto.Nombre)
                var objeto = document.createElement("td")//creamos una celda
                objeto.appendChild(imagen);//le agregamos la imagen a la celda
                linea.appendChild(objeto);//agregamos la celda a la fila
                agregaralinea(cadaproducto.Tipo);
                agregaralinea(cadaproducto.Unidad);
                agregaralinea(cadaproducto.Título);
                agregaralinea('<img ruta="eliminar.php?tipo=producto&id=' + cadaproducto.ID_Producto + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarproducto.php?id=' + cadaproducto.ID_Producto + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })
            asignarbotoneliminar();//llamamos a la funcion luego de haber cargado todos las filas que asignará para cada boton eliminar una funcion de confirmación.
        }
    }
}
export function cargarproveedores(filtro) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var cantidaddeelementosantes = tabla.children.length; // guanta en la variable la cantidad de elementos "hijos" tiene la tabla

    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproveedores.php?filtro=' + filtro); //consulta a la api
    cargaDatos.send()
    cargaDatos.onload = function () {
        const proveedores = JSON.parse(this.responseText);

        if (cantidaddeelementosantes - 1 != proveedores.length) { // compara los elementos de la tabla con los resultados de la api, si hay una cantidad distinta, cargará todos los proveedores
            tabla.innerHTML = "<tr><th>Razón social</th><th>RUT</th><th>Contacto</th><th>Deuda</th><th>Acción</th></tr>"; // carga la primera fila de la tabla
            proveedores.forEach(cadaproveedor => {

                var linea = document.createElement("tr");

                function agregaralinea(dato) {
                    var objeto = document.createElement("td");
                    objeto.innerHTML = dato;
                    linea.appendChild(objeto);
                }
                agregaralinea(cadaproveedor.Razón_Social);
                agregaralinea(cadaproveedor.RUT);
                agregaralinea(cadaproveedor.Contacto);
                agregaralinea(cadaproveedor.Deuda);
                agregaralinea('<img ruta="eliminar.php?tipo=proveedor&id=' + cadaproveedor.ID_PROVEEDOR + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarproveedor.php?id=' + cadaproveedor.ID_PROVEEDOR + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                tabla.appendChild(linea);

            })
            asignarbotoneliminar();//llamamos a la funcion luego de haber cargado todos las filas.
        }


    }
}

export function cargarcobros(filtro) {
    var tabla = document.querySelector("tbody");
    var cantidaddeelementosantes = tabla.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apicobros.php?filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const cobros = JSON.parse(this.responseText);

        if (cantidaddeelementosantes - 1 != cobros.length) {
            tabla.innerHTML = "<tr><th>Responsable</th><th>Cliente</th><th>Monto Abonado</th><th>Fecha de Cobro</th><th>VENTA</th></tr>"
            cobros.forEach(cadacobro => {

                var linea = document.createElement("tr");

                function agregaralinea(dato) {//funcion creada para agregar una linea a la tabla(columna)
                    var objeto = document.createElement("td");//crea el elemento td(columna)
                    objeto.innerHTML = dato;//le introduce el valor pasado por parametros
                    linea.appendChild(objeto);//le agrega a la fila(linea) el elemento creado por la funcion
                }

                agregaralinea(cadacobro.NombreUsuario);
                agregaralinea(cadacobro.Nombre + " - " + cadacobro.Cédula);
                agregaralinea(cadacobro.Monto);
                agregaralinea(cadacobro.Fecha_Cobro);
                if (cadacobro.ID_VENTA) { // si tiene un valor entra, sino no carga un valor por defecto de "Sin datos"
                    agregaralinea("<a href='verventa.php?id=" + cadacobro.ID_VENTA + "'>--Ver Venta--<a>")//carga un enlace a la página verventa.php la cual mostrará la venta segun el parametro id pasado por get
                } else {
                    agregaralinea("Sin Datos");
                }
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })
        }
    }
}
export function cargarpagos(filtro) {
    var tabla = document.querySelector("tbody");
    var cantidaddeelementosantes = tabla.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apipagos.php?filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const pagos = JSON.parse(this.responseText);

        if (cantidaddeelementosantes - 1 != pagos.length) {
            tabla.innerHTML = "<tr><th>Responsable</th><th>Proveedor</th><th>Monto</th><th>Fecha de Pago</th><th>Vencimiento Factura</th><th>Compra</th></tr>"
            pagos.forEach(cadapago => {

                var linea = document.createElement("tr");

                function agregaralinea(dato) {//funcion creada para agregar una linea a la tabla(columna)
                    var objeto = document.createElement("td");//crea el elemento td(columna)
                    objeto.innerHTML = dato;//le introduce el valor pasado por parametros
                    linea.appendChild(objeto);//le agrega a la fila(linea) el elemento creado por la funcion
                }

                agregaralinea(cadapago.NombreUsuario);
                agregaralinea(cadapago.Razón_Social + " - " + cadapago.RUT);
                agregaralinea(cadapago.Monto);
                agregaralinea(cadapago.Fecha_Pago);
                if (cadapago.Vencimiento_Factura) {//si llega a estár seteado el vencimiento de la factura
                    var hoy = new Date()//creamos un elemento tipo fecha, se establece la fecha actual
                    if (Date.parse(cadapago.Vencimiento_Factura) > Date.parse(hoy)) {//si el vencimiento de la factura es mayor que el dia actual (el vencimiento está en el futuro es decir que todavia no pasó )
                        agregaralinea(cadapago.Vencimiento_Factura)//carga la fecha
                    } else {//sino va a cargar un texto por defecto de que ya venció la factura
                        agregaralinea("Ya venció")
                    }
                } else {//si no está seteado, es porque fué al contado
                    agregaralinea("Contado");
                }

                if (cadapago.ID_COMPRA) { // si tiene un valor entra, sino no carga un valor por defecto de "Sin datos"
                    agregaralinea("<a href='vercompra.php?id=" + cadapago.ID_COMPRA + "'>-Ver Compra-<a>")
                } else {
                    agregaralinea("Sin Datos");
                }
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })
        }
    }
}

export function cargarsorteos(filtro) {
    var tabla = document.querySelector("tbody");
    var cantidaddeelementosantes = tabla.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apisorteos.php?filtro=' + filtro)
    cargaDatos.send()
    cargaDatos.onload = function () {
        const sorteos = JSON.parse(this.responseText);

        if (cantidaddeelementosantes - 1 != sorteos.length) {
            tabla.innerHTML = "<tr><th>Premio</th><th>Cantidad</th><th>Fecha de realización</th><th>Acción</th></tr>"
            sorteos.forEach(cadaSorteo => {
                var linea = document.createElement("tr");

                function agregaralinea(dato) {
                    var objeto = document.createElement("td");
                    objeto.innerHTML = dato;
                    linea.appendChild(objeto);
                }

                agregaralinea(cadaSorteo.Premio);
                agregaralinea(cadaSorteo.Cantidad);
                if (cadaSorteo.Fecha_realización == null) {//si no fue realizado, su fecha de realización es null. si el sorteo ya fue realizado lo cargamos con el botón para sortear y el boton eliminar con el atributo ruta tipo sorteo(esto lo podra eliminar con la api ya que el sorteo no fue realizado)
                    agregaralinea("todavia no realizado");
                    agregaralinea('<img ruta="eliminar.php?tipo=sorteo&id=' + cadaSorteo.ID_SORTEO + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarsorteo.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/editar.png" class="accion"></a><a href="concretarsorteo.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/sortear.png" class="accion sortear"></a>');
                } else {//si ya fue realizado cargará otro botón que no será sortear sino que será ver datos del sorteo y el botón de eliminar tendra otra ruta para la api eliminar ya que este sorteo ya tiene ganadores, y no hay que eliminarlo para dejar el registro del sorteo. el botón modificar tampoco está
                    agregaralinea(cadaSorteo.Fecha_realización);
                    agregaralinea('<img ruta="eliminar.php?tipo=sorteorealizado&id=' + cadaSorteo.ID_SORTEO + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="verganadores.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/ganador.png" class="accion"></a>');
                }

                tabla.appendChild(linea);
            })
            asignarbotoneliminar();
            asignarbotonsortear();
        }


    }
}
















//funciones para cargar datos en los select(para filtrar dentro de estos, en apartados ingresarventa.php e ingresarcompra.php)
export function cargarproveedoresenselect(filtro) {
    var select = document.querySelector(".selectdeproveedores");
    var cantidaddeelementosantes = select.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproveedores.php?filtro=' + filtro); // consultamos a la api
    cargaDatos.send()
    cargaDatos.onload = function () {
        const proveedores = JSON.parse(this.responseText);
        if (cantidaddeelementosantes - 1 != proveedores.length) { // la primera vez siempre va a entrar....comparamos la cantidad anterior(la cantidad de hijos del select -1 (usamos el -1 pq en un futuro cuando esté cargado. se carga con todos los proveedores y con un option sin value el cual sirve para que muestre algo. pero debemos de poner el -1 para que no lo cuente))
            select.innerHTML = "<option value=''>proveedor</option>" //seteamos el contenido del select en la opcion de proveedor con un value "" , la cual no podrá ser seleccionada pero sirva para poder identificar de que es el select
            proveedores.forEach(cadaproveedor => { // foreach que recorre la respuesta de la api
                var option = document.createElement("option"); // creamos un elemento opcion
                option.setAttribute("value", cadaproveedor.ID_PROVEEDOR); // le seteamos el atributo value en la id del proveedor actual
                option.innerHTML = cadaproveedor.Razón_Social + " - " + cadaproveedor.RUT// y le damos el contenido al option con la razón social y el rut
                select.appendChild(option); // luego le agregamos el option al select.

            })
        }
    }
}
export function cargarclientesenselect(filtro) {
    var select = document.querySelector(".selectdeclientes");
    var cantidaddeelementosantes = select.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiclientes.php?filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const clientes = JSON.parse(this.responseText);
        if (cantidaddeelementosantes - 1 != clientes.length) {
            select.innerHTML = "<option value=''>cliente</option>"
            clientes.forEach(cadacliente => {
                var option = document.createElement("option");
                option.setAttribute("value", cadacliente.ID_CLIENTE);
                option.innerHTML = cadacliente.Nombre + " - " + cadacliente.Cédula
                select.appendChild(option);

            })
        }
    }
}





//funciones que son llamadas dentro  de las funciones "cargarbotonparasumarproductoparavender()" y "cargarbotonparasumarproductoparacomprar()"
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
            if(tabla.children.length == 1){
                tabla.innerHTML="";
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

//funciones utilizadas unicamente para agregarle las funciones a los botones de vender y comprar productos
function cargarbotonparasumarproductoparavender() {//funcion utilizada en la funcion de cargar productos para vender, la cual se utiliza en el archivo ingresarventa.php - La funcion acutal se encarga de obtener todos los botones con cierta clase y les agrega un evento click, que llamen a una función agregar() la cual los va a agregar en una nueva tabla de productos agregados.
    function agregaraventa(id_producto, nombre, Precio_Neto, cantidaddisponible) {//recive 4 parametros cantidad disponible es para que o pueda agregar mas productos de los que hay
        var inputdeenviar = document.querySelector(".botonenviar");
        inputdeenviar.disabled = false; // habilitamos el boton para poder enviar formulario para la venta
        var tabla = document.querySelector(".tabladeprductosagregados");//obtiene la tabla de productos agregados

        if (tabla.children.length == 0) { // cuenta los hijos de la tabla si son 0 agrega el encabezado esto lo hacemos dentro de la funcion agregar para que agregue la tabla al cargar un producto
            tabla.innerHTML = "<tr><th>Nombre</th><th>Cantidad</th><th>Precio Neto</th><th>acción</th></tr>"
        }

        for (var i = 0; i < tabla.children.length; i++) {//recorre todos los elementos de la tabla en "tabla.children[i]" (los cuales serian todas las filas horizontales, las cuales tienen 5 elementos cada una)   (usamos for normal y no un foreach para poder interrumpirlo y que no sume repetidas veces)
            if (tabla.children[i].children[0].getAttribute("ID_PRODUCTO") == id_producto) { //compara todos los hijos[0] de cada fila de la tabla con la id del producto pasado por parametro a la funcion, si llegase a encontrar entra en el if
                if (parseInt(tabla.children[i].children[1].children[0].value) < parseInt(cantidaddisponible)) { //si el texto de cantidad es menor a la cantidad que queda disponible
                    tabla.children[i].children[1].children[0].value = parseInt(tabla.children[i].children[1].children[0].value) + 1 // al entrar le va a sumar uno al valor del hijo
                    return // al suman uno en la cantidad termina la función termuna la función aca
                } else {//si la cantidad disponible es menor a la cantidad que se va a usar en la compra
                    console.log("no queda mas stock");
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
        objeto.setAttribute("ID_PRODUCTO",id_producto)
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
        linea.children[3].children[1].addEventListener("click", () => { sumar(id_producto, cantidaddisponible) })
        linea.children[3].children[2].addEventListener("click", () => { restar(id_producto) })
        //en el caso de arriba (linea.children[4] seria la celda numero 5 de la linea y los otros serian los hijos de esa linea)
    }
    //lo que hace la función es esto
    var BOTONESAGREGAR = document.querySelectorAll(".agregarproducto"); // un querryselector all ya que hay muchos botones con esa clase
    BOTONESAGREGAR.forEach(CADABOTON => { // este foeeach recorre cada elemento que obtiene el querryselector y les agrega el evento que al hacer click llaman a la funcion agregar con 3 parametros que los obtiene de atributos del boton que fueron agregados al cargarlos
        CADABOTON.addEventListener("click", () => {
            agregaraventa(CADABOTON.getAttribute("id_producto"), CADABOTON.getAttribute("nombre"), CADABOTON.getAttribute("precio_neto"), CADABOTON.getAttribute("cantidaddisponible"));
        });
    });
};



function cargarbotonparasumarproductoparacomprar() {//funcion utilizada en la funcion "cargarproductosparacomprar()", la cual se utiliza en el archivo ingresarcompra.php - La funcion acutal se encarga de obtener todos los botones con cierta clase y les agrega un evento click, que llamen a una función agregar() la cual los va a agregar en una nueva tabla de productos agregados.
    function agregaracompra(id_producto, nombre, Precio_Neto) {//recive 4 parametros cantidad disponible es para que o pueda agregar mas productos de los que hay
        var inputdeenviar = document.querySelector(".botonenviar");
        inputdeenviar.disabled = false; // habilitamos el boton para poder enviar formulario para la venta
        var tabla = document.querySelector(".tabladeprductosagregados");//obtiene la tabla de productos agregados

        if (tabla.children.length == 0) { // cuenta los hijos de la tabla si son 0 agrega el encabezado esto lo hacemos dentro de la funcion agregar para que agregue la tabla al cargar un producto
            tabla.innerHTML = "<tr><th>Nombre</th><th>Cantidad</th><th>Precio Neto</th><th>acción</th></tr>"
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
        objeto.setAttribute("ID_PRODUCTO",id_producto) //le agregae el atributo id producto a la celda
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
    //lo que hace la función es esto
    var BOTONESAGREGAR = document.querySelectorAll(".agregarproducto"); // un querryselector all ya que hay muchos botones con esa clase
    BOTONESAGREGAR.forEach(CADABOTON => { // este foeeach recorre cada elemento que obtiene el querryselector y les agrega el evento que al hacer click llaman a la funcion agregar con 3 parametros que los obtiene de atributos del boton que fueron agregados al cargarlos
        CADABOTON.addEventListener("click", () => {
            agregaracompra(CADABOTON.getAttribute("id_producto"), CADABOTON.getAttribute("nombre"), CADABOTON.getAttribute("precio_compra"));
        });
    });
};





//funciones que cargar las tablas con productos para comprar y vender
export function cargarproductosparacomprar(filtro) {
    var tabla = document.querySelector("tbody");
    var cantidaddeelementosantes = tabla.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const productos = JSON.parse(this.responseText);
        if (cantidaddeelementosantes - 1 != productos.length) {
            tabla.innerHTML = "<tr><th>nombre</th><th>Código de barras</th><th>Precio de Compra</th><th>Descripcion</th><th>acción</th></tr>"
            productos.forEach(cadaproducto => {
                var linea = document.createElement("tr");
                function agregaralinea(dato) {//funcion creada para agregar una linea a la tabla(columna)
                    var objeto = document.createElement("td");//crea el elemento td(columna)
                    objeto.innerHTML = dato;//le introduce el valor pasado por parametros
                    linea.appendChild(objeto);//le agrega a la fila(linea) el elemento creado por la funcion
                }
                agregaralinea(cadaproducto.Nombre);
                agregaralinea(cadaproducto.Código_de_Barras);
                agregaralinea(cadaproducto.Precio_Compra); // cargamos unicamente el precio de compra ya que es para comprar
                agregaralinea(cadaproducto.Descripción);
                agregaralinea("<button class='agregarproducto'nombre='" + cadaproducto.Nombre + "' precio_Compra='" + cadaproducto.Precio_Compra + "' id_producto='" + cadaproducto.ID_Producto + "' onclick='agregarcompra('" + cadaproducto.Nombre + "','" + cadaproducto.Precio_Compra + "','" + cadaproducto.ID_Producto + "')'>+</button>")
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })
            cargarbotonparasumarproductoparacomprar()//esta funcion les agregará funciones a todos los botones una vez agregados
        }
    }
}
export function cargarproductosparavender(filtro) {
    var tabla = document.querySelector("tbody");
    var cantidaddeelementosantes = tabla.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const productos = JSON.parse(this.responseText);
        if (cantidaddeelementosantes - 1 != productos.length) {
            tabla.innerHTML = "<tr><th>nombre</th><th>Código de barras</th><th>Precio de Venta</th><th>Descripcion</th><th>acción</th></tr>"
            productos.forEach(cadaproducto => {
                if (cadaproducto.Cantidad > 0) {//si el producto tiene por lo menos uno lo carga
                    var linea = document.createElement("tr");
                    function agregaralinea(dato) {//funcion creada para agregar una linea a la tabla(columna)
                        var objeto = document.createElement("td");//crea el elemento td(columna)
                        objeto.innerHTML = dato;//le introduce el valor pasado por parametros
                        linea.appendChild(objeto);//le agrega a la fila(linea) el elemento creado por la funcion
                    }
                    agregaralinea(cadaproducto.Nombre);
                    agregaralinea(cadaproducto.Código_de_Barras);
                    agregaralinea(cadaproducto.Precio_Venta); // cargamos unicamente el precio de venta ya que vamos a vender
                    agregaralinea(cadaproducto.Descripción);
                    agregaralinea("<button class='agregarproducto'nombre='" + cadaproducto.Nombre + "' precio_neto='" + cadaproducto.Precio_Venta + "' cantidaddisponible='" + cadaproducto.Cantidad + "' id_producto='" + cadaproducto.ID_Producto + "'>+</button>")//se le agrega atributos al boton para poder ser utilizados en la funcion cargarbotonparasumarproductoparavender la cual recibe 4 parametros.
                    tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

                }

            })
            cargarbotonparasumarproductoparavender()//esta funcion le agrega a todos los botones con la clase 'agregarproducto' la funcion agregar() que recibe cuatro parametros para agregar cada producto
        }
    }

}











//funciones utilizadas en menuprincipal.php
export function actualizarfecha(fechadecumpleaños) {
    var hoy = new Date()
    var titulo = document.querySelector("#titulo_con_fecha")
    var diasemana
    var diames
    switch (hoy.getDay()) {
        case 0:
            diasemana = "Domingo ";
            break;
        case 1:
            diasemana = "Lunes ";
            break;
        case 2:
            diasemana = "Martes ";
            break;
        case 3:
            diasemana = "Miercoles ";
            break;
        case 4:
            diasemana = "Jueves ";
            break;
        case 5:
            diasemana = "Viernes ";
            break;
        case 6:
            diasemana = "Sabado ";

    }
    switch (hoy.getMonth()) {
        case 0:
            diames = "Enero"
            break;
        case 1:
            diames = "Febrero"
            break;
        case 2:
            diames = "Marzo"
            break;
        case 3:
            diames = "Abril"
            break;
        case 4:
            diames = "Mayo"
            break;
        case 5:
            diames = "Junio"
            break;
        case 6:
            diames = "Julio"
            break;
        case 7:
            diames = "Agosto"
            break;
        case 8:
            diames = "Septiembre"
            break;
        case 9:
            diames = "Octubre"
            break;
        case 10:
            diames = "Noviembre"
            break;
        case 11:
            diames = "Diciembre"
            break;


    }

    if (titulo.innerHTML != ("Hoy es " + diasemana + hoy.getDate() + " de " + diames + " de " + hoy.getFullYear() || titulo.innerHTML != ("Hoy es " + diasemana + hoy.getDate() + " de " + diames + " de " + hoy.getFullYear() + "<br> Muy Feliz Cumpleaños!!"))) { //si el contenido de el titulo es distinto a los datos del dia de hoy, lo carga
        var dia = new Date(fechadecumpleaños); // guardamos el cumpleaños del usuario que será pasado por parametros en el dato tipo fecha "dia"
        //console.log(fechadecumpleaños)
        if (dia.getMonth() == hoy.getMonth() && dia.getDate() + 1 == hoy.getDate()) {// si llegase a ser el cumpleaños del cliente
            titulo.innerHTML = "Hoy es " + diasemana + hoy.getDate() + " de " + diames + " de " + hoy.getFullYear() + "<br> Muy Feliz Cumpleaños!!";
        } else {
            titulo.innerHTML = "Hoy es " + diasemana + hoy.getDate() + " de " + diames + " de " + hoy.getFullYear();
        }
    }

}

export function cargarclientesdecumpleaños() {
    var contenedordecumpleañeros = document.querySelector(".contenedordecumpleañeros");
    var cantidaddecumpleañeros = contenedordecumpleañeros.children.length - 1; // cuenta cuantos hijos tiene el elementos menos el titulo (cuenta los cumplañeros ya cargados)
    var cantidadactual = 0

    const cargaCumpleañeros = new XMLHttpRequest();
    cargaCumpleañeros.open('GET', 'apis/apiclientes.php');
    cargaCumpleañeros.send()
    cargaCumpleañeros.onload = function () {
        const clientes = JSON.parse(this.responseText);
        clientes.forEach(cadacliente => { //for each con todos los clientes
            var hoy = new Date() //guardamos la fecha de hoy en un dato tipo fecha
            var dia = new Date(cadacliente.Fecha_de_Nacimiento); // guardamos el cumpleaños del cliente como un dato tipo fecha
            if (dia.getMonth() == hoy.getMonth() && dia.getDate() + 1 == hoy.getDate()) { //si el dia y el mes coinciden con el actual
                cantidadactual++ // cuenta cuantos cumpleañeros hay el dia de hoy
            }
        }) //luego del foreach que solamente cuenta
        if (cantidaddecumpleañeros != cantidadactual) { // chequemos si hay menos o mas clientes de cumpleaños el dia de hoy// si llega a haber carga todos los cumpleañeros el dia de hoy // la primera vez entra en este if. si o si ya que compara -1 con 0 o la cantidad de clientes que haya de cumpleaños que nunca va a ser negativo y estos son distintos
            contenedordecumpleañeros.innerHTML = "<h2>Clientes de cumpleaños 🍰</h2>" // la primera vez carga el titulo si o si
            clientes.forEach(cadacliente => {
                var hoy = new Date() //guardamos la fecha de hoy en un dato tipo fecha
                var dia = new Date(cadacliente.Fecha_de_Nacimiento); // guardamos el cumpleaños del cliente como un dato tipo fecha
                if (dia.getMonth() == hoy.getMonth() && dia.getDate() + 1 == hoy.getDate()) { //si el dia y el mes coinciden con el actual
                    contenedordecumpleañeros.innerHTML += "<h3>" + cadacliente.Nombre + " - " + cadacliente.Cédula + "</h3>"; // carga el cliente con su cédula para identificarlo
                }
            })
        }
        if (contenedordecumpleañeros.childElementCount == 1) { // si solamente se cargó el titulo( osea que no hay ningun cumpleañero) carga un texto diciendo que no hay cumpleañeros
            contenedordecumpleañeros.innerHTML += "<h3>No hay cumpleañeros el dia de hoy</h3>"
        }
    }
}

export function cargarfacturasavencer() {
    var contenedordefacturas = document.querySelector(".contenedordefacturas");
    var cantidaddefacturas = contenedordefacturas.children.length - 1; // cuenta cuantos hijos tiene el elementos menos el titulo (cuenta los cumplañeros ya cargados)
    var cantidadactual = 0

    const cargaFacturas = new XMLHttpRequest();
    cargaFacturas.open('GET', 'apis/apipagos.php');
    cargaFacturas.send()
    cargaFacturas.onload = function () {
        const pagos = JSON.parse(this.responseText);
        pagos.forEach(cadapago => { //for each que cuanta los pagos
            if (cadapago.Vencimiento_Factura) {
                cantidadactual++;
            }
        }) //luego del foreach que solamente cuenta
        if (cantidaddefacturas != cantidadactual) { // chequemos si hay menos o mas clientes de cumpleaños el dia de hoy// si llega a haber carga todos los cumpleañeros el dia de hoy // la primera vez entra en este if. si o si ya que compara -1 con 0 o la cantidad de clientes que haya de cumpleaños que nunca va a ser negativo y estos son distintos
            contenedordefacturas.innerHTML = "<h2>Futuras Facturas a vencer</h2>" // la primera vez carga el titulo si o si
            pagos.forEach(cadapago => {
                var hoy = new Date()//creamos un elemento tipo fecha, se establece la fecha actual
                if (cadapago.Vencimiento_Factura && Date.parse(cadapago.Vencimiento_Factura) > Date.parse(hoy)) { // si hay seteada una fecha de vencimiento de la factura y el dia del vencimiento de la factura es mayor(está en el futuro) es decir todavía no venció, la carga. si ya venció no la carga
                    contenedordefacturas.innerHTML += "<h3>$" + (parseInt(cadapago.DeberíaPagar) - parseInt(cadapago.Monto)) + " a " + cadapago.Razón_Social + " y vence el " + cadapago.Vencimiento_Factura + "</h3>"
                }
            })
        }
        if (contenedordefacturas.childElementCount == 1) { // si solamente se cargó el titulo( osea que no hay ningun cumpleañero) carga un texto diciendo que no hay cumpleañeros
            contenedordefacturas.innerHTML += "<h3>No hay Facturas por vencer</h3>"
        }
    }
}
export function cargarproductosconpocostock() {
    var contenedordeproductos = document.querySelector(".contenedordeproductos");
    var cantidaddeproductos = contenedordeproductos.children.length - 1; // cuenta cuantos hijos tiene el elementos menos el titulo (cuenta los productos ya cargados)
    var cantidadactual = 0

    const cargaproductos = new XMLHttpRequest();
    cargaproductos.open('GET', 'apis/apiproductos.php');
    cargaproductos.send()
    cargaproductos.onload = function () {
        const productos = JSON.parse(this.responseText);
        productos.forEach(cadaProducto => {
            if (parseInt(cadaProducto.Cantidad) <= parseInt(cadaProducto.Cantidad_minima_aviso)) { //si la cantidad es menor o igual a la cantidad de aviso lo carga como un h3, utilizamos parseint ya que comparabas datos tipo string.
                cantidadactual++
            }
        })
        if (cantidaddeproductos != cantidadactual) {
            contenedordeproductos.innerHTML = "<h2>Productos con poco Stock</h2>";
            productos.forEach(cadaProducto => {
                if (parseInt(cadaProducto.Cantidad) <= parseInt(cadaProducto.Cantidad_minima_aviso)) { //si la cantidad es menor o igual a la cantidad de aviso lo carga como un h3, utilizamos parseint ya que comparabas datos tipo string.
                    if (parseInt(cadaProducto.Cantidad) == 0) {
                        contenedordeproductos.innerHTML += "<h3 class='productoconpocostock' >" + cadaProducto.Nombre + " - " + cadaProducto.Código_de_Barras + " - quedan: " + cadaProducto.Cantidad + " " + cadaProducto.Símbolo + "</h3>";
                    } else {
                        contenedordeproductos.innerHTML += "<h3>" + cadaProducto.Nombre + " - " + cadaProducto.Código_de_Barras + " - quedan: " + cadaProducto.Cantidad + " " + cadaProducto.Símbolo + "</h3>";
                    }

                }
            })
        }

        if (contenedordeproductos.childElementCount == 1) { // si no han nada(1 por el titulo(h2))
            contenedordeproductos.innerHTML += "<h3>Todos los productos se encuentran con stock</h3>"
        }
    }
}









function alternar(inputdecontraseña, imagen, ruta) {// funcion utilizada para alternar ojitos de contraseñas
    if (inputdecontraseña.type == 'password') {
        inputdecontraseña.setAttribute('type', 'text')
        imagen.setAttribute('src', ruta + '/ojoabierto.png')
    } else {
        inputdecontraseña.setAttribute('type', 'password')
        imagen.setAttribute('src', ruta + '/ojocerrado.png')
    }
}

window.onload = function () {
    //declaramos cada ojo para ver contraseñas y le agregamos el evento
    var inputcontraseñaindex = document.querySelector(".contraseñadeindex");
    var ojoindex = document.querySelector(".ojoindex")
    if (inputcontraseñaindex && ojoindex) {
        ojoindex.addEventListener("click", () => { alternar(inputcontraseñaindex, ojoindex, "imagenes") })
    }

    var inputcontraseñaregister1 = document.querySelector(".contraseña1register");
    var ojo1register = document.querySelector(".ojo1register");
    if (inputcontraseñaregister1 && ojo1register) {
        ojo1register.addEventListener("click", () => { alternar(inputcontraseñaregister1, ojo1register, "imagenes") })
    }


    var inputcontraseñaregister2 = document.querySelector(".contraseña2register");
    var ojo2register = document.querySelector(".ojo2register");
    if (inputcontraseñaregister2 && ojo2register) {
        ojo2register.addEventListener("click", () => { alternar(inputcontraseñaregister2, ojo2register, "imagenes") });
    }


    var inputcontraseña1 = document.querySelector(".inputpass1");
    var ojo1 = document.querySelector(".ojo1");
    if (inputcontraseña1 && ojo1) {
        ojo1.addEventListener("click", () => { alternar(inputcontraseña1, ojo1, "../imagenes") })
    }

    var inputcontraseña2 = document.querySelector(".inputpass2");
    var ojo2 = document.querySelector(".ojo2");
    if (inputcontraseña2 && ojo2) {
        ojo2.addEventListener("click", () => { alternar(inputcontraseña2, ojo2, "../imagenes") })
    }

    var inputcontraseña3 = document.querySelector(".inputpass3");
    var ojo3 = document.querySelector(".ojo3");
    if (inputcontraseña3 && ojo3) {
        ojo3.addEventListener("click", () => { alternar(inputcontraseña3, ojo3, "../imagenes") })
    }

    var boton = document.querySelector("#botoncreditocontado");
    var inputdate = document.querySelector('#inputdate');
    if (boton && inputdate) {
        boton.addEventListener("click", () => {
            if (inputdate.type == "date") {
                inputdate.type = "hidden";
                inputdate.value = "";
                boton.value = "Contado";
            } else {
                inputdate.type = "date";
                inputdate.required = true;
                boton.value = "Crédito";
            }
        })
    }

}


/* Funciones de carga de datos  */
export function cargarclientes(filtro, pagina) {//esta funcion es llamada siempre
    var tabla = document.querySelector("tbody");
    if (tabla.getAttribute("actualizar") == "si" || pagina == 1) { //si está en la primer pagina o debe de actualizaarse
        if (tabla.getAttribute("actualizar") == "si") {
            tabla.setAttribute("actualizar", "no");
            tabla.setAttribute("pagina", "1")
        }
        pagina = 1 // por si llegase a entrar por la condición de actualizar=si 
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiclientes.php?pagina=' + pagina + '&filtro=' + filtro);
        cargaDatos.send()
        cargaDatos.onload = function () {
            const clientes = JSON.parse(this.responseText);

            tabla.innerHTML = "<tr class='encabezado'><th>Cedula</th><th>Nombre</th><th>Deuda</th><th>Fecha de Nacimiento</th><th>Tickets</th><th>Contacto</th><th>RUT</th><th>Acción</th></tr>"
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
                if (!cadacliente.RUT) {
                    agregaralinea("no tiene");
                } else {
                    agregaralinea(cadacliente.RUT);
                }
                agregaralinea('<img onclick="eliminarobjeto(' + "'" + 'eliminar.php?tipo=cliente&id=' + cadacliente.ID_CLIENTE + "'" + ')"  src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarcliente.php?id=' + cadacliente.ID_CLIENTE + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                tabla.appendChild(linea);
            })
        }
        //luego de cargar todos los elementos en la pagina
        tabla.setAttribute("actualizar", "no")//seteamos en no. para que no se actualice todo el rato igual entrará en el if ya que está en la página 1
        var contenedordelatabla = document.querySelector(".contenedordemenu");
        if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {//entrará en este if solamente si hay scroll en el contenedor de la tabla
            if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) {//si el scroll está llegando al final
                //console.log("está en la página "+pagina+" y el scroll está bajo, el filtro es: "+filtro)
                cargarmasclientes(filtro, pagina);
            }
        }

    } else { // si no tiene el atributo actualizar en si
        if (pagina != "ultima") {
            var contenedordelatabla = document.querySelector(".contenedordemenu");
            if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
                if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                    cargarmasclientes(filtro, pagina);
                }
            }
        }
    }
    cargarcantidades("cliente");//funcion que recarga el numero de la cantidad de elementos que aparece arriba de la tabla. tambien recarga el atributo cantidad de la tabla y si hay que actualizarla.
}
function cargarmasclientes(filtro, pagina) {//función que no reescribirá la tabla, sino que le agregará mas elementos. le agrega los elementos de la proxima página
    var tabla = document.querySelector("tbody");
    //console.log("parametro recibido en funcion "+pagina)
    var paginaactual = parseInt(pagina) + 1;
    //console.log("la nueva pagina es "+paginaactual)
    //console.log("cargando mas productos... actualmente estas en la página "+pagina+" has pasado a la pagina "+paginaactual)
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiclientes.php?pagina=' + paginaactual + '&filtro=' + filtro); //cargamos desde la nueva página
    cargaDatos.send()
    cargaDatos.onload = function () {
        const clientes = JSON.parse(this.responseText);
        if (clientes.length < 30) {//si la respuesta es menor a 30. 30 es el limite de la cosnulta. significará que está en la ultima página
            tabla.setAttribute("pagina", "ultima")//le seteamos a página el texto ultima, para no seguir cargando productos.
            //console.log("ultima pagina")
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
            clientes.forEach(cadacliente => {//carga los datos 

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
                if (!cadacliente.RUT) {
                    agregaralinea("no tiene");
                } else {
                    agregaralinea(cadacliente.RUT);
                }
                agregaralinea('<img onclick="eliminarobjeto(' + "'" + 'eliminar.php?tipo=cliente&id=' + cadacliente.ID_CLIENTE + "'" + ')"  src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarcliente.php?id=' + cadacliente.ID_CLIENTE + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                tabla.appendChild(linea);
            })
        }, 100)
    }
}


export function cargarproductos(filtro, pagina) {
    var tabla = document.querySelector("tbody");
    if (tabla.getAttribute("actualizar") == "si" || pagina == 1) { //si está en la primer pagina o debe de actualizaarse
        if (tabla.getAttribute("actualizar") == "si") {
            tabla.setAttribute("actualizar", "no");
            tabla.setAttribute("pagina", "1")
        }
        pagina = 1 // por si llegase a entrar por la condición de actualizar=si 
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproductos.php?pagina=' + pagina + '&filtro=' + filtro);
        cargaDatos.send()
        cargaDatos.onload = function () {
            const productos = JSON.parse(this.responseText);
            tabla.innerHTML = "<tr class='encabezado'><th>nombre</th><th>Precio Compra</th><th>Precio Venta</th><th>Código de barras</th><th>Descripcion</th><th>Marca</th><th>Cantidad</th><th>Cantidad de aviso</th><th>imagen</th><th>iva</th><th>medida</th><th>categoria</th><th>accion</th></tr>"
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
                agregaralinea('<img  onclick="eliminarobjeto(\'eliminar.php?tipo=producto&id=' + cadaproducto.ID_Producto + '\')" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarproducto.php?id=' + cadaproducto.ID_Producto + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })

        }
        var contenedordelatabla = document.querySelector(".contenedordemenu");
        if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {//si hay scroll disponible en la página
            if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                cargarmasproductos(filtro, pagina); // llamamos a la funcion cargar más productos
            }
        }

    } else { // si no tiene el atributo actualizar en si
        if (pagina != "ultima") {
            var contenedordelatabla = document.querySelector(".contenedordemenu");
            if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
                if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                    cargarmasproductos(filtro, pagina);
                }
            }
        }
    }
    cargarcantidades("producto");
}
function cargarmasproductos(filtro, pagina) {//función que no reescribirá la tabla, sino que le agregará mas elementos. le agrega los elementos de la proxima página
    var tabla = document.querySelector("tbody");
    //console.log("parametro recibido en funcion "+pagina)
    var paginaactual = parseInt(pagina) + 1;
    //console.log("la nueva pagina es "+paginaactual)
    //console.log("cargando mas productos... actualmente estas en la página "+pagina+" has pasado a la pagina "+paginaactual)
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?pagina=' + paginaactual + '&filtro=' + filtro);
    //console.log('apis/apiproductos.php?pagina=' + paginaactual + '&filtro=' + filtro)
    cargaDatos.send()
    cargaDatos.onload = function () {
        const productos = JSON.parse(this.responseText);
        //console.log("se cargaron " + productos.length + " productos")
        if (productos.length < 20) {
            tabla.setAttribute("pagina", "ultima")//le seteamos a página el texto ultima, para no seguir cargando productos.
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
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
                agregaralinea('<img  onclick="eliminarobjeto(\'eliminar.php?tipo=producto&id=' + cadaproducto.ID_Producto + '\')" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarproducto.php?id=' + cadaproducto.ID_Producto + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })
        }, 100)

    }
}


export function cargarproveedores(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    if (tabla.getAttribute("actualizar") == "si" || pagina == 1) { //si está en la primer pagina o debe de actualizaarse
        if (tabla.getAttribute("actualizar") == "si") {
            tabla.setAttribute("actualizar", "no");
            tabla.setAttribute("pagina", "1")
        }
        pagina = 1 // por si llegase a entrar por la condición de actualizar=si 
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproveedores.php?filtro=' + filtro); //consulta a la api
        cargaDatos.send()
        cargaDatos.onload = function () {
            const proveedores = JSON.parse(this.responseText);
            tabla.innerHTML = "<tr class='encabezado'><th>Razón social</th><th>RUT</th><th>Contacto</th><th>Deuda</th><th>Acción</th></tr>"; // carga la primera fila de la tabla
            proveedores.forEach(cadaproveedor => {
                var linea = document.createElement("tr");
                function agregaralinea(dato) {
                    var objeto = document.createElement("td");
                    objeto.innerHTML = dato;
                    linea.appendChild(objeto);
                }
                agregaralinea(cadaproveedor.Razón_Social);
                if (cadaproveedor.RUT) {
                    agregaralinea(cadaproveedor.RUT);
                } else {
                    agregaralinea("no tiene");
                }
                agregaralinea(cadaproveedor.Contacto);
                agregaralinea(cadaproveedor.Deuda);
                agregaralinea('<img onclick="eliminarobjeto(\'eliminar.php?tipo=proveedor&id=' + cadaproveedor.ID_PROVEEDOR + '\')" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarproveedor.php?id=' + cadaproveedor.ID_PROVEEDOR + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                tabla.appendChild(linea);
            })
        }
        var contenedordelatabla = document.querySelector(".contenedordemenu");
        if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
            if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                cargarmasproveedores(filtro, pagina);
            }
        }
    } else {
        if (pagina != "ultima") {
            var contenedordelatabla = document.querySelector(".contenedordemenu");
            if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
                if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                    cargarmasproveedores(filtro, pagina);
                }
            }
        }
    }
    cargarcantidades("proveedor");
}
function cargarmasproveedores(filtro, pagina) {
    //console.log("se llamó a función de cargar más proveedores en la página " + pagina +" con el filtro " +filtro);
    var tabla = document.querySelector("tbody");
    var paginaactual = parseInt(pagina) + 1;
    tabla.setAttribute("pagina", paginaactual);
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open("GET", "apis/apiproveedores.php?pagina=" + paginaactual + "&filtro=" + filtro);
    cargaDatos.send();
    cargaDatos.onload = function () {
        const proveedores = JSON.parse(this.responseText);
        if (proveedores.length < 30) { //30 es el limite de la api por página
            tabla.setAttribute("pagina", "ultima"); //le seteamos a página el texto ultima, para no seguir cargando proveedores.
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
            proveedores.forEach(cadaproveedor => {
                var linea = document.createElement("tr");
                function agregaralinea(dato) {
                    var objeto = document.createElement("td");
                    objeto.innerHTML = dato;
                    linea.appendChild(objeto);
                }
                agregaralinea(cadaproveedor.Razón_Social);
                if (cadaproveedor.RUT) {
                    agregaralinea(cadaproveedor.RUT);
                } else {
                    agregaralinea("no tiene");
                }
                agregaralinea(cadaproveedor.Contacto);
                agregaralinea(cadaproveedor.Deuda);
                agregaralinea('<img onclick="eliminarobjeto(\'eliminar.php?tipo=proveedor&id=' + cadaproveedor.ID_PROVEEDOR + '\')" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarproveedor.php?id=' + cadaproveedor.ID_PROVEEDOR + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                tabla.appendChild(linea);
            })
        }, 100)
    };
}


export function cargarcobros(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var contenedordelatabla = document.querySelector(".contenedordemenu");

    if (tabla.getAttribute("actualizar") == "si" || pagina == 1) { //si está en la primer pagina o debe de actualizaarse
        if (tabla.getAttribute("actualizar") == "si") {
            tabla.setAttribute("actualizar", "no");
            tabla.setAttribute("pagina", "1")
        }
        pagina = 1 // por si llegase a entrar por la condición de actualizar=si 
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apicobros.php?pagina=' + pagina + '&filtro=' + filtro);
        cargaDatos.send()
        cargaDatos.onload = function () {
            const cobros = JSON.parse(this.responseText);
            tabla.innerHTML = "<tr class='encabezado'><th>Responsable</th><th>Cliente</th><th>Monto Abonado</th><th>Fecha de Cobro</th><th>VENTA</th></tr>"
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
        if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
            if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                cargarmascobros(filtro, pagina);
            }
        }
    } else {
        if (pagina != "ultima") {
            if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
                if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                    cargarmascobros(filtro, pagina);
                }
            }
        }
    }
    cargarcantidades("cobro");
}
function cargarmascobros(filtro, pagina) {
    var tabla = document.querySelector("tbody");
    var paginaactual = parseInt(pagina) + 1;
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apicobros.php?pagina=' + paginaactual + '&filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const cobros = JSON.parse(this.responseText);
        console.log(cobros.length)
        if (cobros.length < 40) {
            tabla.setAttribute("pagina", "ultima")
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
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
        }, 100)

    }
}



export function cargarpagos(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    if (tabla.getAttribute("actualizar") == "si" || pagina == 1) { //si está en la primer pagina o debe de actualizaarse
        if (tabla.getAttribute("actualizar") == "si") {
            tabla.setAttribute("actualizar", "no");
            tabla.setAttribute("pagina", "1")
        }
        pagina = 1 // por si llegase a entrar por la condición de actualizar=si 
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apipagos.php?pagina=' + pagina + '&filtro=' + filtro);
        cargaDatos.send()
        cargaDatos.onload = function () {
            const pagos = JSON.parse(this.responseText);

            tabla.innerHTML = "<tr class='encabezado'><th>Responsable</th><th>Proveedor</th><th>Monto</th><th>Fecha de Pago</th><th>Vencimiento Factura</th><th>Compra</th></tr>"
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
        var contenedordelatabla = document.querySelector(".contenedordemenu");
        if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
            if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                cargarmaspagos(filtro, pagina);
            }
        }


    } else {
        if (pagina != "ultima") {
            var contenedordelatabla = document.querySelector(".contenedordemenu");
            if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
                if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                    cargarmaspagos(filtro, pagina);
                }
            }
        }
    }
    cargarcantidades("pago");
}
function cargarmaspagos(filtro, pagina) {
    var tabla = document.querySelector("tbody");
    var paginaactual = parseInt(pagina) + 1;
    console.log("la pagina pasada por parametro es " + pagina + " y la pagina actual es " + paginaactual + " el filtro es " + filtro)
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apipagos.php?pagina=' + paginaactual + '&filtro=' + filtro);
    console.log('apis/apipagos.php?pagina=' + paginaactual + '&filtro=' + filtro)
    cargaDatos.send()
    cargaDatos.onload = function () {
        const pagos = JSON.parse(this.responseText);
        console.log(pagos)
        console.log(pagos.length)
        if (pagos.length < 40) {
            tabla.setAttribute("pagina", "ultima")
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
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
        }, 100)

    }
}


//faltan cambiar estas funciones:::
export function cargarsorteos(filtro,pagina) {
    var tabla = document.querySelector("tbody");
    var cantidaddeelementosantes = tabla.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apisorteos.php?filtro=' + filtro)
    cargaDatos.send()
    cargaDatos.onload = function () {
        const sorteos = JSON.parse(this.responseText);

        if (cantidaddeelementosantes - 1 != sorteos.length) {
            tabla.innerHTML = "<tr class='encabezado'><th>Premio</th><th>Cantidad</th><th>Fecha de realización</th><th>Acción</th></tr>"
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
                    agregaralinea('<img ruta="eliminar.php?tipo=sorteo&id=' + cadaSorteo.ID_SORTEO + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarsorteo.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/editar.png" class="accion"></a><a href="concretarsorteo.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/sortear.png" class="accion sortear" onmouseleave="ocultaravisodesorteo()" onmouseenter="mostraravisosorteo()"></a>');
                } else {//si ya fue realizado cargará otro botón que no será sortear sino que será ver datos del sorteo y el botón de eliminar tendra otra ruta para la api eliminar ya que este sorteo ya tiene ganadores, y no hay que eliminarlo para dejar el registro del sorteo. el botón modificar tampoco está
                    agregaralinea(cadaSorteo.Fecha_realización);
                    agregaralinea('<img onclick="eliminarobjeto(' + "'" + 'eliminar.php?tipo=sorteorealizado&id=' + cadaSorteo.ID_SORTEO + "'" + ')"  src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="verganadores.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/ganador.png" class="accion"></a>');
                }
                tabla.appendChild(linea);
            })
        }
    }
    cargarcantidades("sorteo");
}
function cargarmassorteos(filtro,pagina){

}


function cargarcantidadesentabla(tipo) {
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apidecantidades.php?tipo=' + tipo);
    cargaDatos.send()
    cargaDatos.onload = function () {
        var tabla = document.querySelector("tbody")
        tabla.setAttribute("cantidad", JSON.parse(this.responseText))
    }
}
function cargarcantidades(tipo) {//es utilizada por las 6 de arriba
    var contenedordecantidaddeelementos = document.querySelector(".cantidaddeelementos")
    var tabla = document.querySelector("tbody");
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apidecantidades.php?tipo=' + tipo);
    cargaDatos.send()
    cargaDatos.onload = function () {
        if (tabla.getAttribute("cantidad") != JSON.parse(this.responseText)) {//si hay cambios, se le setea un atributo a la tabla, que se llamará actualizar en si.
            tabla.setAttribute("actualizar", "si");
        }
        contenedordecantidaddeelementos.innerHTML = JSON.parse(this.responseText); // la respuesta será la cantidad depende del tipo.

        switch (tipo) {
            case "cliente":
                if (contenedordecantidaddeelementos.innerHTML == 1) {
                    contenedordecantidaddeelementos.innerHTML += " Cliente";
                } else {
                    contenedordecantidaddeelementos.innerHTML += " Clientes";
                }
                break;
            case "producto":
                if (contenedordecantidaddeelementos.innerHTML == 1) {
                    contenedordecantidaddeelementos.innerHTML += " Producto";
                } else {
                    contenedordecantidaddeelementos.innerHTML += " Productos";
                }
                break;
            case "proveedor":
                if (contenedordecantidaddeelementos.innerHTML == 1) {
                    contenedordecantidaddeelementos.innerHTML += " Proveedor";
                } else {
                    contenedordecantidaddeelementos.innerHTML += " Proveedores";
                }
                break;
            case "sorteo":
                if (contenedordecantidaddeelementos.innerHTML == 1) {
                    contenedordecantidaddeelementos.innerHTML += " Sorteo";
                } else {
                    contenedordecantidaddeelementos.innerHTML += " Sorteos";
                }
                break;
            case "pago":
                if (contenedordecantidaddeelementos.innerHTML == 1) {
                    contenedordecantidaddeelementos.innerHTML += " Pago";
                } else {
                    contenedordecantidaddeelementos.innerHTML += " Pagos";
                }
                break;
            case "cobro":
                if (contenedordecantidaddeelementos.innerHTML == 1) {
                    contenedordecantidaddeelementos.innerHTML += " Cobro";
                } else {
                    contenedordecantidaddeelementos.innerHTML += " Cobros";
                }
                break;
        }
    }
    cargarcantidadesentabla(tipo)
}

//funciones para cargar datos en los select(para filtrar dentro de estos, en apartados ingresarventa.php e ingresarcompra.php)
export function cargarproveedoresenselect(filtro) {
    var select = document.querySelector(".selectdeproveedores");
    var cantidaddeelementosantes = select.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproveedores.php?limite=50&filtro=' + filtro); // consultamos a la api
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
    cargaDatos.open('GET', 'apis/apiclientes.php?limite=50&filtro=' + filtro);
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
            tabla.innerHTML = "<tr class='encabezado'><th>Nombre</th><th>Código de barras</th><th>Precio de Compra</th><th>Descripcion</th><th>Acción</th></tr>"
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
                agregaralinea('<button onclick="agregaracompra(\'' + cadaproducto.ID_Producto + '\',\'' + cadaproducto.Nombre + '\',\'' + cadaproducto.Precio_Compra + '\')" class="agregarproducto">Agregar</button>');
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })
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
            tabla.innerHTML = "<tr class='encabezado'><th>Nombre</th><th>Código de barras</th><th>Precio de Venta</th><th>Descripcion</th><th>Acción</th></tr>"
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
                    agregaralinea('<button onclick="agregaraventa(\'' + cadaproducto.ID_Producto + '\',\'' + cadaproducto.Nombre + '\',\'' + cadaproducto.Precio_Compra + '\',\'' + cadaproducto.Cantidad + '\')" class="agregarproducto">Agregar</button>');
                    tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

                }

            })
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
    cargaCumpleañeros.open('GET', 'apis/apiclientes.php?limite=sin');
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
            contenedordecumpleañeros.innerHTML = "<h2 class='encabezadoprincipal'>Clientes de cumpleaños 🍰</h2>" // la primera vez carga el titulo si o si
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
    cargaFacturas.open('GET', 'apis/apipagos.php?limite=sin'); //hacemos las consultas sin limite, ya que deberá cargar todos los procutos con poco stock
    cargaFacturas.send()
    cargaFacturas.onload = function () {
        const pagos = JSON.parse(this.responseText);
        pagos.forEach(cadapago => { //for each que cuanta los pagos
            if (cadapago.Vencimiento_Factura) {
                cantidadactual++;
            }
        }) //luego del foreach que solamente cuenta
        if (cantidaddefacturas != cantidadactual) { // chequemos si hay menos o mas clientes de cumpleaños el dia de hoy// si llega a haber carga todos los cumpleañeros el dia de hoy // la primera vez entra en este if. si o si ya que compara -1 con 0 o la cantidad de clientes que haya de cumpleaños que nunca va a ser negativo y estos son distintos
            contenedordefacturas.innerHTML = "<h2 class='encabezadoprincipal'>Futuras Facturas a vencer</h2>" // la primera vez carga el titulo si o si
            pagos.forEach(cadapago => {
                var hoy = new Date()//creamos un elemento tipo fecha, se establece la fecha actual
                if (cadapago.Vencimiento_Factura && Date.parse(cadapago.Vencimiento_Factura) > Date.parse(hoy)) { // si hay seteada una fecha de vencimiento de la factura y el dia del vencimiento de la factura es mayor(está en el futuro) es decir todavía no venció, la carga. si ya venció no la carga
                    contenedordefacturas.innerHTML += "<h3>$" + (parseInt(cadapago.DeberíaPagar) - parseInt(cadapago.Monto)) + " a " + cadapago.Razón_Social + " y vence el " + cadapago.Vencimiento_Factura + "</h3>"
                }
            })
        }
        if (contenedordefacturas.childElementCount == 1) { // si solamente se cargó el titulo( osea que no hay ningun cumpleañero) carga un texto diciendo que no hay cumpleañeros
            contenedordefacturas.innerHTML += "<h3 class='encabezadoprincipal'>No hay Facturas por vencer</h3>"
        }
    }
}
export function cargarproductosconpocostock() {
    var contenedordeproductos = document.querySelector(".contenedordeproductos");
    var cantidaddeproductos = contenedordeproductos.children.length - 1; // cuenta cuantos hijos tiene el elementos menos el titulo (cuenta los productos ya cargados)
    var cantidadactual = 0

    const cargaproductos = new XMLHttpRequest();
    cargaproductos.open('GET', 'apis/apiproductos.php?limite=sin');
    cargaproductos.send()
    cargaproductos.onload = function () {
        const productos = JSON.parse(this.responseText);
        productos.forEach(cadaProducto => {
            if (parseInt(cadaProducto.Cantidad) <= parseInt(cadaProducto.Cantidad_minima_aviso)) { //si la cantidad es menor o igual a la cantidad de aviso lo carga como un h3, utilizamos parseint ya que comparabas datos tipo string.
                cantidadactual++
            }
        })
        if (cantidaddeproductos != cantidadactual) {
            contenedordeproductos.innerHTML = "<h2 class='encabezadoprincipal'>Productos con poco Stock</h2>";
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
        ojo1.addEventListener("click", () => { alternar(inputcontraseña1, ojo1, "imagenes") })
    }

    var inputcontraseña2 = document.querySelector(".inputpass2");
    var ojo2 = document.querySelector(".ojo2");
    if (inputcontraseña2 && ojo2) {
        ojo2.addEventListener("click", () => { alternar(inputcontraseña2, ojo2, "imagenes") })
    }

    var inputcontraseña3 = document.querySelector(".inputpass3");
    var ojo3 = document.querySelector(".ojo3");
    if (inputcontraseña3 && ojo3) {
        ojo3.addEventListener("click", () => { alternar(inputcontraseña3, ojo3, "imagenes") })
    }

    var inputmeolvide1 = document.querySelector("#contraseñameolvide")
    var ojo1meolvide = document.querySelector(".ojo1meolvide");
    if (inputmeolvide1 && ojo1meolvide) {
        ojo1meolvide.addEventListener("click", () => { alternar(inputmeolvide1, ojo1meolvide, "../imagenes") })
    }

    var inputmeolvide2 = document.querySelector("#contraseñameolvide2")
    var ojo2meolvide = document.querySelector(".ojo2meolvide");
    if (inputmeolvide2, ojo2meolvide) {
        ojo2meolvide.addEventListener("click", () => { alternar(inputmeolvide2, ojo2meolvide, "../imagenes") })
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




    var contenedordelatabla = document.querySelector(".contenedordemenu");
    console.log(contenedordelatabla)
}

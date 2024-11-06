///////FUNCIONES PARA CARGAR DATOSSSSSS ////////////////
const retraso = 200;
function cargarcobros(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var valoractualizar = tabla.getAttribute("actualizar")
    var contenedordelatabla = document.querySelector(".contenedordemenu");
    var limite = tabla.getAttribute("limite");
    if (valoractualizar == "si") { //si está en la primer pagina o debe de actualizaarse
        tabla.setAttribute("actualizar", "no");
        tabla.setAttribute("pagina", "1")
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apicobros.php?pagina=1&filtro=' + filtro + '&limite=' + limite);
        //console.log("la ruta es: " + 'apis/apicobros.php?pagina=1&filtro=' + filtro + '&limite=' + limite)
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
                    agregaralinea("<a class='botonenlace' href='verventa.php?id=" + cadacobro.ID_VENTA + "'>Ver Venta<a>")//carga un enlace a la página verventa.php la cual mostrará la venta segun el parametro id pasado por get
                } else {
                    agregaralinea("Sin Datos");
                }
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })

        }
    } else {
        if (valoractualizar == "maselementos") {
            mostrarinfo("Hay nuevos cobros!")
        }
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
    var limite = tabla.getAttribute("limite");
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apicobros.php?limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const cobros = JSON.parse(this.responseText);
        if (cobros.length < limite) {
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
                    agregaralinea("<a class='botonenlace' href='verventa.php?id=" + cadacobro.ID_VENTA + "'>Ver Venta<a>")//carga un enlace a la página verventa.php la cual mostrará la venta segun el parametro id pasado por get
                } else {
                    agregaralinea("Sin Datos");
                }
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })
        }, retraso)

    }
}


function cargarpagos(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var valoractualizar = tabla.getAttribute("actualizar")
    var contenedordelatabla = document.querySelector(".contenedordemenu");
    var limite = tabla.getAttribute("limite");
    if (valoractualizar == "si") { //si está en la primer pagina o debe de actualizaarse
        tabla.setAttribute("actualizar", "no");
        tabla.setAttribute("pagina", "1")
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apipagos.php?pagina=1&filtro=' + filtro + '&limite=' + limite);
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
                    agregaralinea("<a class='botonenlace' href='vercompra.php?id=" + cadapago.ID_COMPRA + "'>Ver Compra<a>")
                } else {
                    agregaralinea("Sin Datos");
                }
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })
        }
    } else {
        if (pagina != "ultima") {
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
    var limite = tabla.getAttribute("limite");
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apipagos.php?limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const pagos = JSON.parse(this.responseText);
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
                    agregaralinea("<a class='botonenlace' href='vercompra.php?id=" + cadapago.ID_COMPRA + "'>Ver Compra<a>")
                } else {
                    agregaralinea("Sin Datos");
                }
                tabla.appendChild(linea);//agregamos a la tabla toda la fila creada anteriromente

            })
        }, retraso)

    }
}


function cargarproveedores(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var valoractualizar = tabla.getAttribute("actualizar")
    var contenedordelatabla = document.querySelector(".contenedordemenu");
    var limite = tabla.getAttribute("limite");
    if (valoractualizar == "si") { //si está en la primer pagina o debe de actualizaarse
        tabla.setAttribute("actualizar", "no");
        tabla.setAttribute("pagina", "1")
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproveedores.php?pagina=1&filtro=' + filtro + '&limite=' + limite); //consulta a la api
        cargaDatos.send()
        cargaDatos.onload = function () {
            const proveedores = JSON.parse(this.responseText);
            tabla.innerHTML = "<tr class='encabezado'><th>Razón social</th><th>RUT</th><th>Contacto</th><th>Deuda</th><th>Acción</th></tr>"; // carga la primera fila de la tabla
            proveedores.forEach(cadaproveedor => {
                var linea = document.createElement("tr");
                linea.setAttribute("id", cadaproveedor.ID_PROVEEDOR)
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
    } else {
        if (valoractualizar == "menoselementos") {
            eliminarlosproveedoressobrantes(filtro, pagina);// si hay menos elementos llamamos a la función que consultará todos los elementos de la tabla y de la base de datos, los compara, y elimina el elemento que está en la tabla, pero que no está en la consulta
        } else if (valoractualizar == "maselementos") {
            mostrarinfo("Hay nuevos Proveedores!") // unicamente, mostrará un mensaje que hay nuevos clientes. si el usuario desea recargar la página para ver esos nuevos clientes será su opción.
        } else if (pagina != "ultima") {
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
    var tabla = document.querySelector("tbody");
    var limite = tabla.getAttribute("limite");
    var paginaactual = parseInt(pagina) + 1;
    tabla.setAttribute("pagina", paginaactual);
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open("GET", "apis/apiproveedores.php?limite=" + limite + "&pagina=" + paginaactual + "&filtro=" + filtro);
    cargaDatos.send();
    cargaDatos.onload = function () {
        const proveedores = JSON.parse(this.responseText);
        if (proveedores.length < limite) { // si la consulta devuelve menos cantidad de elementos que el limite, significa que está en la ultima página.
            tabla.setAttribute("pagina", "ultima"); //le seteamos a página el texto ultima, para no seguir cargando proveedores.
        }
        setTimeout(() => {
            proveedores.forEach(cadaproveedor => {
                var linea = document.createElement("tr");
                linea.setAttribute("id", cadaproveedor.ID_PROVEEDOR)
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
        }, retraso)
    };
}
function eliminarlosproveedoressobrantes(filtro, pagina) {
    var tabla = document.querySelector("tbody");
    var limite = tabla.getAttribute("limite")

    if (pagina == "ultima") {
        var cantidaddeelementos = "sin";
    } else {
        var cantidaddeelementos = limite * pagina;
    }
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproveedores.php?pagina=1&filtro=' + filtro + '&limite=' + cantidaddeelementos) //obtenemos en una sola consulta todos los datos ya cargados
    //console.log('apis/apiproveedores.php?pagina=1&filtro='+filtro+'&limite=' + cantidaddeelementos)
    cargaDatos.send()
    cargaDatos.onload = function () {

        const proveedores = JSON.parse(this.responseText);//guardamos la respuesta de la api en una variable
        let filastabla = tabla.children; // obtenemos todas las filas de la tabla en una variable

        for (let i = 1; i < filastabla.length; i++) { // recorremos cada fila de la tabla
            let fila = filastabla[i]; // guardmos cadafila en la variable fila
            let proveedorexistente = proveedores.some((cadaelementodelarreglo) => cadaelementodelarreglo.ID_PROVEEDOR == fila.getAttribute("id"));//some es una función para arreglos que devolverá true si es que se cumple la condición al menos una vez, si no se cumple con ningun elemento, retoranará false
            if (!proveedorexistente) {//si es false(no encontró la fila en la respuesta a la api) entrará acá.
                console.log("se removió la fila con el id " + fila.getAttribute("id"))
                fila.remove();// eliminamos la fila.

            }
        }
    }
}


function cargarproductos(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var valoractualizar = tabla.getAttribute("actualizar")
    var contenedordelatabla = document.querySelector(".contenedordemenu");
    var limite = tabla.getAttribute("limite");

    if (valoractualizar == "si") { //si está en la primer pagina o debe de actualizaarse
        tabla.setAttribute("actualizar", "no");
        tabla.setAttribute("pagina", "1");//se le setea para evitar errores.
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproductos.php?pagina1&filtro=' + filtro + "&limite=" + limite);
        cargaDatos.send()
        cargaDatos.onload = function () {
            const productos = JSON.parse(this.responseText);
            tabla.innerHTML = "<tr class='encabezado'><th>nombre</th><th>Precio Compra</th><th>Precio Venta</th><th>Código de barras</th><th>Descripcion</th><th>Marca</th><th>Cantidad</th><th>Cantidad de aviso</th><th>imagen</th><th>iva</th><th>medida</th><th>categoria</th><th>accion</th></tr>"
            productos.forEach(cadaproducto => {
                var linea = document.createElement("tr");
                linea.setAttribute("id", cadaproducto.ID_Producto);
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
                imagen.onerror = () => { imagen.src = "imagenes/sinfoto.jpg" } // si la imagen llega a dar error, se le estableserá en la ruta. la foto por defecto
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
    } else { // si valoractualizar no es "si"
        if (valoractualizar == "menoselementos") {
            eliminarlosproductossobrantes(filtro, pagina);// si hay menos elementos llamamos a la función que consultará todos los elementos de la tabla y de la base de datos, los compara, y elimina el elemento que está en la tabla, pero que no está en la consulta
        } else if (valoractualizar == "maselementos") {
            mostrarinfo("Hay nuevos Productos!") // unicamente, mostrará un mensaje que hay nuevos productos. si el usuario desea recargar la página para ver esos nuevos clientes será su opción.
        } else if (pagina != "ultima") {
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
    var paginaactual = parseInt(pagina) + 1;
    var limite = tabla.getAttribute("limite");
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const productos = JSON.parse(this.responseText);
        if (productos.length < limite) {
            tabla.setAttribute("pagina", "ultima")//le seteamos a página el texto ultima, para no seguir cargando productos.
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
            productos.forEach(cadaproducto => {
                var linea = document.createElement("tr");
                linea.setAttribute("id", cadaproducto.ID_Producto);
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
        }, retraso)

    }
}
function eliminarlosproductossobrantes(filtro, pagina) {
    var tabla = document.querySelector("tbody");
    var limite = tabla.getAttribute("limite")

    if (pagina == "ultima") {
        var cantidaddeelementos = "sin";
    } else {
        var cantidaddeelementos = limite * pagina;
    }
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?pagina=1&filtro=' + filtro + '&limite=' + cantidaddeelementos) //obtenemos en una sola consulta todos los datos ya cargados
    cargaDatos.send()
    cargaDatos.onload = function () {

        const productos = JSON.parse(this.responseText);//guardamos la respuesta de la api en una variable
        let filastabla = tabla.children; // obtenemos todas las filas de la tabla en una variable

        for (let i = 1; i < filastabla.length; i++) { // recorremos cada fila de la tabla
            let fila = filastabla[i]; // guardmos cadafila en la variable fila
            console.log(fila)
            let productoexistente = productos.some((cadaelementodelarreglo) => cadaelementodelarreglo.ID_Producto == fila.getAttribute("id"));//some es una función para arreglos que devolverá true si es que se cumple la condición al menos una vez, si no se cumple con ningun elemento, retoranará false
            if (!productoexistente) {//si es false(no encontró la fila en la respuesta a la api) entrará acá.
                //console.log("se removió la fila con el id " + fila.getAttribute("id"))
                fila.remove();// eliminamos la fila.
            }
        }
    }
}


function cargarclientes(filtro, pagina) {//esta funcion es llamada siempre
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var valoractualizar = tabla.getAttribute("actualizar")
    var contenedordelatabla = document.querySelector(".contenedordemenu");
    var limite = tabla.getAttribute("limite");
    if (valoractualizar == "si") { // es realizado la primer vez unicamente
        tabla.setAttribute("actualizar", "no");
        tabla.setAttribute("pagina", "1");//se le setea para evitar errores.
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiclientes.php?filtro=' + filtro + '&pagina=1&limite=' + limite);
        cargaDatos.send()
        cargaDatos.onload = function () {
            const clientes = JSON.parse(this.responseText);
            tabla.innerHTML = "<tr class='encabezado'><th>Cedula</th><th>Nombre</th><th>Deuda</th><th>Fecha de Nacimiento</th><th>Tickets</th><th>Contacto</th><th>RUT</th><th>Acción</th></tr>"

            clientes.forEach(cadacliente => {

                var linea = document.createElement("tr");
                linea.setAttribute("id", cadacliente.ID_CLIENTE)
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
    } else { // si no tiene el atributo actualizar en si
        if (valoractualizar == "menoselementos") {
            eliminarlosclientessobrantes(filtro, pagina);// si hay menos elementos llamamos a la función que consultará todos los elementos de la tabla y de la base de datos, los compara, y elimina el elemento que está en la tabla, pero que no está en la consulta
        } else if (valoractualizar == "maselementos") {
            mostrarinfo("Hay nuevos clientes") // unicamente, mostrará un mensaje que hay nuevos clientes. si el usuario desea recargar la página para ver esos nuevos clientes será su opción.
        } else if (pagina != "ultima") {
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
    var paginaactual = parseInt(pagina) + 1;
    var limite = tabla.getAttribute("limite");
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiclientes.php?limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro); //cargamos desde la nueva página
    cargaDatos.send()
    cargaDatos.onload = function () {
        const clientes = JSON.parse(this.responseText);
        if (clientes.length < limite) {//si la respuesta es menor a 30. 30 es el limite de la cosnulta. significará que está en la ultima página
            tabla.setAttribute("pagina", "ultima")//le seteamos a página el texto ultima, para no seguir cargando productos.
            //console.log("ultima pagina")
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
            clientes.forEach(cadacliente => {//carga los datos 

                var linea = document.createElement("tr");
                linea.setAttribute("id", cadacliente.ID_CLIENTE)
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
        }, retraso)
    }
}
function eliminarlosclientessobrantes(filtro, pagina) {
    var tabla = document.querySelector("tbody");
    var limite = tabla.getAttribute("limite")

    if (pagina == "ultima") {
        var cantidaddeelementos = "sin";
    } else {
        var cantidaddeelementos = limite * pagina;
    }
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiclientes.php?filtro=' + filtro + '&pagina=1&limite=' + cantidaddeelementos) //obtenemos en una sola consulta todos los datos ya cargados
    cargaDatos.send()
    cargaDatos.onload = function () {

        const clientes = JSON.parse(this.responseText);//guardamos la respuesta de la api en una variable
        let filastabla = tabla.children; // obtenemos todas las filas de la tabla en una variable

        for (let i = 1; i < filastabla.length; i++) { // recorremos cada fila de la tabla
            let fila = filastabla[i]; // guardmos cadafila en la variable fila
            let clienteExistente = clientes.some((cadaelementodelarreglo) => cadaelementodelarreglo.ID_CLIENTE == fila.getAttribute("id"));//some es una función para arreglos que devolverá true si es que se cumple la condición al menos una vez, si no se cumple con ningun elemento, retoranará false
            if (!clienteExistente) {//si es false(no encontró la fila en la respuesta a la api) entrará acá.
                //console.log("Cliente no encontrado en el arreglo:", fila.getAttribute("id"));
                fila.remove();// eliminamos la fila.
            }
        }
    }
}


function cargarsorteos(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var valoractualizar = tabla.getAttribute("actualizar")
    var contenedordelatabla = document.querySelector(".contenedordemenu");
    var limite = tabla.getAttribute("limite");

    if (valoractualizar == "si") { //si está en la primer pagina o debe de actualizaarse
        tabla.setAttribute("actualizar", "no");
        tabla.setAttribute("pagina", "1");//se le setea para evitar errores. 
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apisorteos.php?pagina=1&filtro=' + filtro + '&limite=' + limite)
        cargaDatos.send()
        cargaDatos.onload = function () {
            const sorteos = JSON.parse(this.responseText);
            tabla.innerHTML = "<tr class='encabezado'><th>Premio</th><th>Cantidad</th><th>Fecha de realización</th><th>Acción</th></tr>"
            sorteos.forEach(cadaSorteo => {
                var linea = document.createElement("tr");
                linea.setAttribute("id", cadaSorteo.ID_SORTEO);
                function agregaralinea(dato) {
                    var objeto = document.createElement("td");
                    objeto.innerHTML = dato;
                    linea.appendChild(objeto);
                }

                agregaralinea(cadaSorteo.Premio);
                agregaralinea(cadaSorteo.Cantidad);
                if (cadaSorteo.Fecha_realización == null) {//si no fue realizado, su fecha de realización es null. si el sorteo ya fue realizado lo cargamos con el botón para sortear y el boton eliminar con el atributo ruta tipo sorteo(esto lo podra eliminar con la api ya que el sorteo no fue realizado)
                    agregaralinea("todavia no realizado");
                    agregaralinea('<img onclick="eliminarobjeto(' + "'" + 'eliminar.php?tipo=sorteo&id=' + cadaSorteo.ID_SORTEO + "'" + ')" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarsorteo.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/editar.png" class="accion"></a><a href="concretarsorteo.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/sortear.png" class="accion sortear" onmouseleave="ocultaravisodesorteo()" onmouseenter="mostraravisosorteo()"></a>');
                } else {//si ya fue realizado cargará otro botón que no será sortear sino que será ver datos del sorteo y el botón de eliminar tendra otra ruta para la api eliminar ya que este sorteo ya tiene ganadores, y no hay que eliminarlo para dejar el registro del sorteo. el botón modificar tampoco está
                    agregaralinea(cadaSorteo.Fecha_realización);
                    agregaralinea('<img onclick="eliminarobjeto(' + "'" + 'eliminar.php?tipo=sorteorealizado&id=' + cadaSorteo.ID_SORTEO + "'" + ')"  src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="verganadores.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/ganador.png" class="accion"></a>');
                }
                tabla.appendChild(linea);
            })
        }

    } else {
        if (valoractualizar == "menoselementos") {
            eliminarlossorteossobrantes(filtro, pagina);// si hay menos elementos llamamos a la función que consultará todos los elementos de la tabla y de la base de datos, los compara, y elimina el elemento que está en la tabla, pero que no está en la consulta
        } else if (valoractualizar == "maselementos") {
            mostrarinfo("Hay nuevos sorteos!") // unicamente, mostrará un mensaje que hay nuevos clientes. si el usuario desea recargar la página para ver esos nuevos clientes será su opción.
        } else if (pagina != "ultima") {
            if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
                if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                    cargarmassorteos(filtro, pagina);
                }
            }
        }
    }
    cargarcantidades("sorteo");
}
function cargarmassorteos(filtro, pagina) {
    var tabla = document.querySelector("tbody");
    var paginaactual = parseInt(pagina) + 1;
    var limite = tabla.getAttribute("limite");
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apisorteos.php?limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const sorteos = JSON.parse(this.responseText);
        if (sorteos.length < limite) {
            tabla.setAttribute("pagina", "ultima")
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
            sorteos.forEach(cadaSorteo => {
                var linea = document.createElement("tr");
                linea.setAttribute("id", cadaSorteo.ID_SORTEO)
                function agregaralinea(dato) {
                    var objeto = document.createElement("td");
                    objeto.innerHTML = dato;
                    linea.appendChild(objeto);
                }

                agregaralinea(cadaSorteo.Premio);
                agregaralinea(cadaSorteo.Cantidad);
                if (cadaSorteo.Fecha_realización == null) {//si no fue realizado, su fecha de realización es null. si el sorteo ya fue realizado lo cargamos con el botón para sortear y el boton eliminar con el atributo ruta tipo sorteo(esto lo podra eliminar con la api ya que el sorteo no fue realizado)
                    agregaralinea("todavia no realizado");
                    agregaralinea('<img onclick="eliminarobjeto(' + "'" + 'eliminar.php?tipo=sorteo&id=' + cadaSorteo.ID_SORTEO + "'" + ')" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificarsorteo.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/editar.png" class="accion"></a><a href="concretarsorteo.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/sortear.png" class="accion sortear" onmouseleave="ocultaravisodesorteo()" onmouseenter="mostraravisosorteo()"></a>');
                } else {//si ya fue realizado cargará otro botón que no será sortear sino que será ver datos del sorteo y el botón de eliminar tendra otra ruta para la api eliminar ya que este sorteo ya tiene ganadores, y no hay que eliminarlo para dejar el registro del sorteo. el botón modificar tampoco está
                    agregaralinea(cadaSorteo.Fecha_realización);
                    agregaralinea('<img onclick="eliminarobjeto(' + "'" + 'eliminar.php?tipo=sorteorealizado&id=' + cadaSorteo.ID_SORTEO + "'" + ')"  src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="verganadores.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/ganador.png" class="accion"></a>');
                }
                tabla.appendChild(linea);
            })
        }, retraso)

    }
}
function eliminarlossorteossobrantes(filtro, pagina) {
    var tabla = document.querySelector("tbody");
    var limite = tabla.getAttribute("limite")

    if (pagina == "ultima") {
        var cantidaddeelementos = "sin";
    } else {
        var cantidaddeelementos = limite * pagina;
    }
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apisorteos.php?filtro=' + filtro + '&pagina=1&limite=' + cantidaddeelementos) //obtenemos en una sola consulta todos los datos ya cargados

    //console.log('apis/apisorteos.php?filtro=' + filtro + '&pagina=1&limite=' + cantidaddeelementos)
    cargaDatos.send()
    cargaDatos.onload = function () {

        const sorteos = JSON.parse(this.responseText);
        let filastabla = tabla.children; // obtenemos todas las filas de la tabla en una variable

        for (let i = 1; i < filastabla.length; i++) { // recorremos cada fila de la tabla. 1 para que no tome el encabezado (0)
            let fila = filastabla[i]; // guardmos cadafila en la variable fila

            let sorteoexistente = sorteos.some((cadaelementodelarreglo) => cadaelementodelarreglo.ID_SORTEO == fila.getAttribute("id"));//some es una función para arreglos que devolverá true si es que se cumple la condición al menos una vez, si no se cumple con ningun elemento, retoranará false
            if (!sorteoexistente) {//si es false(no encontró la fila en la respuesta a la api) entrará acá.
                //console.log("sorteo no encontrado en la consulta :"+fila.getAttribute("id"));
                fila.remove();// eliminamos la fila.
            }
        }
    }
}



///funciones para carga de datos en select para poder filtrar los proveedores y productos
function cargarproveedoresenselect(filtro) {
    var select = document.querySelector(".selectdeproveedores");
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproveedores.php?limite=100&filtro=' + filtro); // consultamos a la api
    cargaDatos.send()
    cargaDatos.onload = function () {
        const proveedores = JSON.parse(this.responseText);
        select.innerHTML = "<option value=''>proveedor</option>" //seteamos el contenido del select en la opcion de proveedor con un value "" , la cual no podrá ser seleccionada pero sirva para poder identificar de que es el select
        proveedores.forEach(cadaproveedor => { // foreach que recorre la respuesta de la api
            var option = document.createElement("option"); // creamos un elemento opcion
            option.setAttribute("value", cadaproveedor.ID_PROVEEDOR); // le seteamos el atributo value en la id del proveedor actual
            option.innerHTML = cadaproveedor.Razón_Social + " - " + cadaproveedor.RUT// y le damos el contenido al option con la razón social y el rut
            select.appendChild(option); // luego le agregamos el option al select.

        })

    }
}
function cargarclientesenselect(filtro) {
    var select = document.querySelector(".selectdeclientes");
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiclientes.php?limite=100&filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const clientes = JSON.parse(this.responseText);
        select.innerHTML = "<option value=''>cliente</option>"
        clientes.forEach(cadacliente => {
            var option = document.createElement("option");
            option.setAttribute("value", cadacliente.ID_CLIENTE);
            option.innerHTML = cadacliente.Nombre + " - " + cadacliente.Cédula
            select.appendChild(option);

        })

    }
}


//funcion utilizada para cargar cantidades en tablas: 
function cargarcantidadesentabla(tipo) {//función que establece a la tabla el atributo de cantidad en lo que obtiene de la respuesta
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
        if (tabla.getAttribute("cantidad")) {//si está seteado el atributo cantidad
            //console.log(tabla.getAttribute("cantidad")+" cantidad en tabla")
            //console.log(JSON.parse(this.responseText)+" respuesta")
            if (tabla.getAttribute("cantidad") > JSON.parse(this.responseText)) {//si en la respuesta hay menos elementos, significa que se borró un elemento
                tabla.setAttribute("actualizar", "menoselementos");
                console.log("hay menos elementos y se a actualizado el atrbuto de la tabla")
            } else if (tabla.getAttribute("cantidad") < JSON.parse(this.responseText)) {
                tabla.setAttribute("actualizar", "maselementos");
            } else if (tabla.getAttribute("cantidad") == JSON.parse(this.responseText)) {
                tabla.setAttribute("actualizar", "no");
            }
            //console.log(tabla.getAttribute("actualizar"));
        }

        contenedordecantidaddeelementos.innerHTML = JSON.parse(this.responseText); // la respuesta será la cantidad depende del tipo.

        switch (tipo) {
            case "productoconstock":
                if (contenedordecantidaddeelementos.innerHTML == 1) {
                    contenedordecantidaddeelementos.innerHTML += " Producto en stock";
                } else {
                    contenedordecantidaddeelementos.innerHTML += " Productos en stock";
                }
                break;
            case "cliente":
                if (contenedordecantidaddeelementos.innerHTML == 1) {
                    contenedordecantidaddeelementos.innerHTML += " Cliente";
                } else {
                    contenedordecantidaddeelementos.innerHTML += " Clientes";
                }
                break;
            case "producto" || "productoparavender":
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





//funciones utilizadas para cargar los productos en la tabla para vender.
function cargarproductosparavender(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var valoractualizar = tabla.getAttribute("actualizar")
    var contenedordelatabla = document.querySelector(".agregarproductos");
    var limite = tabla.getAttribute("limite");

    if (valoractualizar == "si") { //si está en la primer pagina o debe de actualizaarse
        tabla.setAttribute("actualizar", "no");
        tabla.setAttribute("pagina", "1")
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproductos.php?productosdisponibles=true&pagina=1&limite=' + limite + '&filtro=' + filtro);
        cargaDatos.send()
        cargaDatos.onload = function () {
            const productos = JSON.parse(this.responseText);
            tabla.innerHTML = "<tr class='encabezado'><th>Nombre</th><th>Código de barras</th><th>Precio de Venta</th><th>Descripcion</th><th>Acción</th></tr>"
            productos.forEach(cadaproducto => {
                var linea = document.createElement("tr");
                linea.setAttribute("id", cadaproducto.ID_Producto)
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
                comprobarstockdearticulosvendidos(cadaproducto.ID_Producto, cadaproducto.Cantidad);//funcion que recorre todos los elementos de la tabla productos agregados, si encuentra el que fue pasado por parametro, se le setea la cantidad pasada por parametro.
                //la función de arriba la recorre con cada producto.
            })
        }

    } else {
        if (valoractualizar == "menoselementos") {
            eliminarlosproductossobrantesparavender(filtro, pagina);// si hay menos elementos llamamos a la función que consultará todos los elementos de la tabla y de la base de datos, los compara, y elimina el elemento que está en la tabla, pero que no está en la consulta
        } else if (valoractualizar == "maselementos") {
            mostrarinfo("Hay nuevos Productos!") // unicamente, mostrará un mensaje que hay nuevos productos. si el usuario desea recargar la página para ver esos nuevos clientes será su opción.
        } else if (pagina != "ultima") {
            if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
                if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 10) { // si se acerca el scrol a la parte inferior de la pantalla
                    cargarmasproductosparavender(filtro, pagina);
                }
            }
        }
    }
    cargarcantidades("productoconstock");
}
function cargarmasproductosparavender(filtro, pagina) {
    var tabla = document.querySelector("tbody");
    var paginaactual = parseInt(pagina) + 1;
    var limite = tabla.getAttribute("limite");
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?productosdisponibles=true&limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const productos = JSON.parse(this.responseText);
        if (productos.length < limite) {
            tabla.setAttribute("pagina", "ultima")
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
            productos.forEach(cadaproducto => {
                var linea = document.createElement("tr");
                linea.setAttribute("id", cadaproducto.ID_Producto)
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
                comprobarstockdearticulosvendidos(cadaproducto.ID_Producto, cadaproducto.Cantidad); //funcion que recorre todos los elementos de la tabla productos agregados, si encuentra el que fue pasado por parametro, se le setea la cantidad pasada por parametro.
                //la función de arriba la recorre con cada producto.

            })

        }, retraso)
    }
}
function eliminarlosproductossobrantesparavender(filtro, pagina) {
    var tabla = document.querySelector("tbody");
    var limite = tabla.getAttribute("limite")

    if (pagina == "ultima") {
        var cantidaddeelementos = "sin";
    } else {
        var cantidaddeelementos = limite * pagina;
    }
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?productosdisponibles=true&filtro=' + filtro + '&pagina=1&limite=' + cantidaddeelementos) //obtenemos en una sola consulta todos los datos ya cargados
    cargaDatos.send()
    cargaDatos.onload = function () {

        const productosparavender = JSON.parse(this.responseText);
        let filastabla = tabla.children; // obtenemos todas las filas de la tabla en una variable

        for (let i = 1; i < filastabla.length; i++) { // recorremos cada fila de la tabla. 1 para que no tome el encabezado (0)
            let fila = filastabla[i]; // guardmos cadafila en la variable fila

            let seencuentraenelaconsulta = productosparavender.some((cadaelementodelarreglo) => cadaelementodelarreglo.ID_Producto == fila.getAttribute("id"));//some es una función para arreglos que devolverá true si es que se cumple la condición al menos una vez, si no se cumple con ningun elemento, retoranará false
            if (!seencuentraenelaconsulta) {//si es false(no encontró la fila en la respuesta a la api) entrará acá.
                fila.remove();// eliminamos la fila.
            }
        }
    }
}
function comprobarstockdearticulosvendidos(id_producto, cantidaddisponible) {//funcion que recorre todos los elementos de la tabla productos agregados, si encuentra el que fue pasado por parametro, se le setea la cantidad pasada por parametro.
    var tabla = document.querySelector(".tabladeprductosagregados");
    for (var i = 0; i < tabla.children.length; i++) {//recorre todos los elementos de la tabla en "tabla.children[i]" (los cuales serian todas las filas horizontales, las cuales tienen 5 elementos cada una)   (usamos for normal y no un foreach para poder interrumpirlo y que no sume repetidas veces)
        if (tabla.children[i].children[0].getAttribute("ID_PRODUCTO") == id_producto) {
            //console.log("el producto con la id "+id_producto+" se encontró y se le seteo un máximo de "+cantidaddisponible);
            tabla.children[i].children[1].children[0].setAttribute("max", cantidaddisponible) // le seteamos al input de dentro de la tabla un maximo, depende la cantidad de productos que hayan al momento de llamar la función.
            tabla.children[i].children[3].children[1].setAttribute("onclick", "sumarenventa(" + id_producto + "," + cantidaddisponible + ")")
            if (tabla.children[i].children[1].children[0].value > cantidaddisponible) {
                //console.log("el valor de antes era "+tabla.children[i].children[1].children[0].value+" y se actualizó a "+cantidaddisponible)
                tabla.children[i].children[1].children[0].value = cantidaddisponible
            }
        }
    }
}





function cargarproductosparacomprar(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var valoractualizar = tabla.getAttribute("actualizar")
    var contenedordelatabla = document.querySelector(".agregarproductos");
    var limite = tabla.getAttribute("limite");
    if (valoractualizar == "si") { //si está en la primer pagina o debe de actualizaarse
        tabla.setAttribute("actualizar", "no");
        tabla.setAttribute("pagina", "1")
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproductos.php?pagina=1&limite=' + limite + '&filtro=' + filtro);
        console.log('apis/apiproductos.php?pagina=1&limite=' + limite + '&filtro=' + filtro);
        cargaDatos.send()
        cargaDatos.onload = function () {
            const productos = JSON.parse(this.responseText);
            tabla.innerHTML = "<tr class='encabezado'><th>Nombre</th><th>Código de barras</th><th>Precio de Compra</th><th>Descripcion</th><th>Acción</th></tr>"
            productos.forEach(cadaproducto => {
                var linea = document.createElement("tr");
                linea.setAttribute("id", cadaproducto.ID_Producto);
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
    } else {
        if (valoractualizar == "menoselementos") {
            eliminarlosproductossobrantes(filtro, pagina);// si hay menos elementos llamamos a la función que consultará todos los elementos de la tabla y de la base de datos, los compara, y elimina el elemento que está en la tabla, pero que no está en la consulta
        } else if (valoractualizar == "maselementos") {
            mostrarinfo("Hay nuevos Productos!") // unicamente, mostrará un mensaje que hay nuevos productos. si el usuario desea recargar la página para ver esos nuevos clientes será su opción.
        } else if (pagina != "ultima") {
            if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
                if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                    cargarmasproductosparacomprar(filtro, pagina);
                }
            }
        }
    }
    cargarcantidades("producto");
}
function cargarmasproductosparacomprar(filtro, pagina) {//funcion que agrega más productos sin sobre escribir la tabla.
    var tabla = document.querySelector("tbody");
    var paginaactual = parseInt(pagina) + 1;
    var limite = tabla.getAttribute("limite");
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro);
    cargaDatos.send()
    cargaDatos.onload = function () {
        const procutos = JSON.parse(this.responseText);
        if (procutos.length < limite) {
            tabla.setAttribute("pagina", "ultima")
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
            procutos.forEach(cadaproducto => {
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

        }, retraso)
    }
}






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
        icon: "warning",
        customClass: {
            popup: "alertas"  // Añadimos una clase personalizada para poder mostrar bordes ya que la alerta no lo permite
        },
        toast: true,
        showConfirmButton: false,
        timer: 1700,
        timerProgressBar: true,
    })
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
    linea.children[3].children[1].setAttribute("onclick", "sumarenventa(" + id_producto + "," + cantidaddisponible + ")")//lo agregamos como atributo onclick para luego podermodificarlo.
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


//función que cargan un elemento de sweetalert, debe estar agregado el archivo de sweetalert para evitar errores
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
function mostrarinfo(mensaje) {
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
            icon: "info",
            background: colorFondo,
            color: colorPrincipal,
            customClass: {
                popup: "alertaconbordes"  // Añadimos una clase personalizada para poder mostrar bordes ya que la alerta no lo permite
            },
            toast: true,
            showConfirmButton: false,
            timer: 1800,
            timerProgressBar: true,
        });
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




window.onload = () => {
    var milisegundosentrerepeticiones = 500;


    var botonpararecargarlatabla = document.querySelector(".recargartabla");
    if (botonpararecargarlatabla) {
        botonpararecargarlatabla.addEventListener("click", () => {
            document.querySelector('tbody').setAttribute('actualizar', 'si')
        })
    }


    var inputdecobros = document.querySelector(".inputdebusquedadecobro");
    if (inputdecobros) {
        inputdecobros.addEventListener("keyup", () => {
            document.querySelector('tbody').setAttribute('actualizar', 'si')//seteamos el actualizar en si y llamamos a la función
            cargarcobros(inputdecobros.value)
        })

        cargarcobros();
        setInterval(() => {
            var cantidaddepaginascargadasenlatabla = document.querySelector("tbody").getAttribute("pagina")
            if (inputdecobros.value == "") {
                cargarcobros("", cantidaddepaginascargadasenlatabla);
            } else {
                cargarcobros(inputdecobros.value, cantidaddepaginascargadasenlatabla);
            }
        }, milisegundosentrerepeticiones);
    }


    var inputdepagos = document.querySelector(".inputdebusquedadepago");
    if (inputdepagos) {
        inputdepagos.addEventListener("keyup", () => {
            document.querySelector('tbody').setAttribute('actualizar', 'si')//seteamos el actualizar en si y llamamos a la función
            cargarpagos(inputdepagos.value)
        })

        cargarpagos();
        setInterval(() => {
            var cantidaddepaginascargadasenlatabla = document.querySelector("tbody").getAttribute("pagina")
            if (inputdepagos.value == "") {
                cargarpagos("", cantidaddepaginascargadasenlatabla);
            } else {
                cargarpagos(inputdepagos.value, cantidaddepaginascargadasenlatabla);
            }
        }, milisegundosentrerepeticiones);
    }


    var inputdeproveedores = document.querySelector(".inputdeproveedores");
    if (inputdeproveedores) {
        inputdeproveedores.addEventListener("keyup", () => {
            document.querySelector('tbody').setAttribute('actualizar', 'si')//seteamos el actualizar en si y llamamos a la función
            cargarproveedores(inputdeproveedores.value)
        }) //keyup porque toma el valor al levantar la tecla, se lo pasa a la funcion cargar proveedores la cual recive un parametro "filtro" con el cual hará la consulta a la api, en la api chequeamos que filtro esté seteada( distinto de undefined, porque al no estar seteada queda "undefined") y hacemos una consulta personalizada con la propiedad LIKE

        cargarproveedores()
        setInterval(() => {
            var cantidaddepaginascargadasenlatabla = document.querySelector("tbody").getAttribute("pagina")
            if (inputdeproveedores.value == "") {
                cargarproveedores("", cantidaddepaginascargadasenlatabla)
            } else {
                cargarproveedores(inputdeproveedores.value, cantidaddepaginascargadasenlatabla)
            }
        }, milisegundosentrerepeticiones);
    }

    var inputdeproductos = document.querySelector(".inputdeproductos");
    if (inputdeproductos) {
        inputdeproductos.addEventListener("keyup", () => {
            document.querySelector('tbody').setAttribute('actualizar', 'si')//seteamos el actualizar en si y llamamos a la función
            cargarproductos(inputdeproductos.value)
        }) //keyup porque toma el valor al levantar la tecla, se lo pasa a la funcion cargar proveedores la cual recive un parametro "filtro" con el cual hará la consulta a la api, en la api chequeamos que filtro esté seteada( distinto de undefined, porque al no estar seteada queda "undefined") y hacemos una consulta personalizada con la propiedad LIKE

        cargarproductos();
        setInterval(() => {
            var cantidaddepaginascargadasenlatabla = document.querySelector("tbody").getAttribute("pagina")
            if (inputdeproductos.value == "") {
                cargarproductos("", cantidaddepaginascargadasenlatabla);
            } else {
                cargarproductos(inputdeproductos.value, cantidaddepaginascargadasenlatabla);
            }
        }, milisegundosentrerepeticiones);

    }

    var inputdeclientes = document.querySelector(".inputdeclientes")
    if (inputdeclientes) {
        inputdeclientes.addEventListener("keyup", () => { //al escribir algo
            document.querySelector('tbody').setAttribute('actualizar', 'si')//seteamos el actualizar en si y llamamos a la función
            cargarclientes(inputdeclientes.value)
        }) //keyup porque toma el valor al levantar la tecla, se lo pasa a la funcion cargar proveedores la cual recive un parametro "filtro" con el cual hará la consulta a la api, en la api chequeamos que filtro esté seteada( distinto de undefined, porque al no estar seteada queda "undefined") y hacemos una consulta personalizada con la propiedad LIKE

        cargarclientes();//lamamos la función al cargar la pagina
        setInterval(() => {
            var cantidaddepaginascargadasenlatabla = document.querySelector("tbody").getAttribute("pagina")
            if (inputdeclientes.value == "") { // si el contenido del buscador está vacío.
                cargarclientes("", cantidaddepaginascargadasenlatabla);
            } else {
                cargarclientes(inputdeclientes.value, cantidaddepaginascargadasenlatabla)
            }
        }, milisegundosentrerepeticiones);


    }

    var inputdesorteos = document.querySelector(".inputparabuscarsorteos");
    if (inputdesorteos) {
        inputdesorteos.addEventListener("keyup", () => {
            document.querySelector('tbody').setAttribute('actualizar', 'si')//seteamos el actualizar en si y llamamos a la función
            cargarsorteos(inputdesorteos.value, 1)
        })
        cargarsorteos()
        setInterval(() => {
            var cantidaddepaginascargadasenlatabla = document.querySelector("tbody").getAttribute("pagina")

            if (inputdesorteos.value == "") { //si el input está vacío recarga, esto es para que no interrumpa la funcion cuando está filtrando
                cargarsorteos("", cantidaddepaginascargadasenlatabla)
            } else {
                cargarsorteos(inputdesorteos.value, cantidaddepaginascargadasenlatabla)
            }
        }, milisegundosentrerepeticiones);
    }


    var inputdeproductosparavender = document.querySelector(".filtroproductosparavender")
    if (inputdeproductosparavender) {
        inputdeproductosparavender.addEventListener("keyup", () => {
            document.querySelector("tbody").setAttribute("actualizar", "si")
            cargarproductosparavender(inputdeproductosparavender.value, 1)
        })

        cargarproductosparavender("", 1)
        setInterval(() => {
            var cantidaddepaginascargadasenlatabla = document.querySelector("tbody").getAttribute("pagina")
            if (inputdeproductosparavender.value == "") {
                cargarproductosparavender("", cantidaddepaginascargadasenlatabla)
            } else {
                cargarproductosparavender(inputdeproductosparavender.value, cantidaddepaginascargadasenlatabla)
            }
        }, milisegundosentrerepeticiones);
    }



    var inputparafiltrarclientes = document.querySelector(".filtroclientesparaselect")
    if (inputparafiltrarclientes) {
        cargarclientesenselect("", 1)
        inputparafiltrarclientes.addEventListener("keyup", () => {
            cargarclientesenselect(inputparafiltrarclientes.value)
        })
    }



    var inputdeproductosparacomprar = document.querySelector(".filtroproductos")
    if (inputdeproductosparacomprar) {
        inputdeproductosparacomprar.addEventListener("keyup", () => {
            document.querySelector("tbody").setAttribute("actualizar", "si")
            cargarproductosparacomprar(inputdeproductosparacomprar.value, 1)
        })
        cargarproductosparacomprar();
        setInterval(() => {
            var cantidaddepaginascargadasenlatabla = document.querySelector("tbody").getAttribute("pagina")
            if (inputdeproductosparacomprar.value == "") {
                cargarproductosparacomprar("", cantidaddepaginascargadasenlatabla)
            } else {
                cargarproductosparacomprar(inputdeproductosparacomprar.value, cantidaddepaginascargadasenlatabla)
            }
        }, milisegundosentrerepeticiones);
    }

    var inputparafiltrarproveedores = document.querySelector(".filtroproveedoreparaselect")
    if (inputparafiltrarproveedores) {
        cargarproveedoresenselect(inputparafiltrarproveedores.value)
        inputparafiltrarproveedores.addEventListener("keyup", () => {
            cargarproveedoresenselect(inputparafiltrarproveedores.value)
        })
    }





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



    //función para hacer aparecer input tipo fecha para ingresar compra al contado
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


    //para acer aparecer boton de subir el scroll: 
    var botonsubirscrol = document.querySelector(".button")
    if (botonsubirscrol) {
        var contenedordemenu = document.querySelector(".contenedordemenu")
        if (!contenedordemenu) {
            contenedordemenu = document.querySelector(".agregarproductos")
        }
        contenedordemenu.addEventListener('scroll', function () {
            if (contenedordemenu.scrollTop > 200) {
                botonsubirscrol.setAttribute("style", "transform:scale(1)")
            } else {
                botonsubirscrol.setAttribute("style", "transform:scale(0);")

            }
        });
    }
}
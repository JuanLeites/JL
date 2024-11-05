const retraso = 200;
/* Funciones de carga de datos  */



//funciones para cargar datos en los select(para filtrar dentro de estos, en apartados ingresarventa.php e ingresarcompra.php)
export function cargarproveedoresenselect(filtro) {
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
export function cargarclientesenselect(filtro) {
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



//funciones que cargar las tablas con productos para comprar y vender
export function cargarproductosparacomprar(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var contenedordelatabla = document.querySelector(".agregarproductos");
    var limite = 20;
    if (tabla.getAttribute("actualizar") == "si" || pagina == 1) { //si está en la primer pagina o debe de actualizaarse
        if (tabla.getAttribute("actualizar") == "si") {
            tabla.setAttribute("actualizar", "no");
            tabla.setAttribute("pagina", "1")
        }
        pagina = 1 // por si llegase a entrar por la condición de actualizar=si 
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproductos.php?limite=' + limite + '&filtro=' + filtro);
        cargaDatos.send()
        cargaDatos.onload = function () {
            const productos = JSON.parse(this.responseText);

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
        if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
            if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                cargarmasproductosparacomprar(filtro, pagina);
            }
        }
    } else {
        if (pagina != "ultima") {
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
    var limite = 20;
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro);
    //console.log('apis/apiproductos.php?limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro)
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
export function cargarproductosparavender(filtro, pagina) {
    var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
    var contenedordelatabla = document.querySelector(".agregarproductos");
    var limite = 20;
    if (tabla.getAttribute("actualizar") == "si" || pagina == 1) { //si está en la primer pagina o debe de actualizaarse
        if (tabla.getAttribute("actualizar") == "si") {
            tabla.setAttribute("actualizar", "no");
            tabla.setAttribute("pagina", "1")
        }
        pagina = 1 // por si llegase a entrar por la condición de actualizar=si 
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproductos.php?productosdisponibles=true&limite=' + limite + '&filtro=' + filtro);
        cargaDatos.send()
        cargaDatos.onload = function () {
            const productos = JSON.parse(this.responseText);

            tabla.innerHTML = "<tr class='encabezado'><th>Nombre</th><th>Código de barras</th><th>Precio de Venta</th><th>Descripcion</th><th>Acción</th></tr>"
            productos.forEach(cadaproducto => {
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
                comprobarstockdearticulosvendidos(cadaproducto.ID_Producto, cadaproducto.Cantidad);//funcion que recorre todos los elementos de la tabla productos agregados, si encuentra el que fue pasado por parametro, se le setea la cantidad pasada por parametro.
                //la función de arriba la recorre con cada producto.
            })
        }

        if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
            if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
                cargarmasproductosparavender(filtro, pagina);
            }
        }
    } else {
        if (pagina != "ultima") {
            if (contenedordelatabla.scrollHeight > contenedordelatabla.clientHeight) {
                if (((contenedordelatabla.scrollHeight - contenedordelatabla.clientHeight) - contenedordelatabla.scrollTop) < 20) { // si se acerca el scrol a la parte inferior de la pantalla
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
    var limite = 20;
    tabla.setAttribute("pagina", paginaactual)
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php?productosdisponibles=true&limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro);
    //console.log('apis/apiproductos.php?productosdisponibles=true&limite=' + limite + '&pagina=' + paginaactual + '&filtro=' + filtro)
    cargaDatos.send()
    cargaDatos.onload = function () {
        const productos = JSON.parse(this.responseText);
        if (productos.length < limite) {
            tabla.setAttribute("pagina", "ultima")
        }
        setTimeout(() => { // esperamos 100 milesimas ya que sino no se agregan más proveedores y la tabla queda con los primeros datos y el en el atributo página queda la ultima
            productos.forEach(cadaproducto => {
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
                comprobarstockdearticulosvendidos(cadaproducto.ID_Producto, cadaproducto.Cantidad); //funcion que recorre todos los elementos de la tabla productos agregados, si encuentra el que fue pasado por parametro, se le setea la cantidad pasada por parametro.
                //la función de arriba la recorre con cada producto.

            })

        }, retraso)
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





}

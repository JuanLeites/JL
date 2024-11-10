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
            diasemana = "Miércoles ";
            break;
        case 4:
            diasemana = "Jueves ";
            break;
        case 5:
            diasemana = "Viernes ";
            break;
        case 6:
            diasemana = "Sábado ";

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
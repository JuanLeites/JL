
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
                confirmButtonText: "SI, Eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminar(CADABOTON.getAttribute("ruta")) //llamamos a la funcion eliminar y le pasamos como parametro lo que habiamos guardado en el elemento imagen con el nombre de "ruta" en la cual está guardada el tipo de elemento que es el que vamos a borrar y un id
                    Swal.fire({
                        title: "Eliminado!",
                        text: "El Objeto a sido eliminado.",
                        icon: "success"
                    });

                }
            });
        });
    });
}


export function alternar(inputdecontraseña, imagen, ruta) {
    if (inputdecontraseña.type == 'password') {
        inputdecontraseña.setAttribute('type', 'text')
        imagen.setAttribute('src', ruta + '/ojoabierto.png')
    } else {
        inputdecontraseña.setAttribute('type', 'password')
        imagen.setAttribute('src', ruta + '/ojocerrado.png')
    }
}

/* Funciones de carga de datos  */
export function cargarclientes() {
    var tabla = document.querySelector("tbody");
    var cantidaddeelementosantes = tabla.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiclientes.php');
    cargaDatos.send()
    cargaDatos.onload = function () {
        const clientes = JSON.parse(this.responseText);

        if (cantidaddeelementosantes - 1 != clientes.length) {

            tabla.innerHTML = "<tr><th>ID</th><th>Cedula</th><th>Nombre</th><th>Deuda</th><th>Fecha de Nacimiento</th><th>Bouchers</th><th>Contacto</th><th>RUT</th><th>Acción</th></tr>"
            clientes.forEach(cadacliente => {

                var linea = document.createElement("tr");

                function agregaralinea(dato) {
                    var objeto = document.createElement("td");
                    objeto.innerHTML = dato;
                    linea.appendChild(objeto);
                }

                agregaralinea(cadacliente.ID_CLIENTE);
                agregaralinea(cadacliente.Cédula);
                agregaralinea(cadacliente.Nombre);
                agregaralinea(cadacliente.Deuda);
                agregaralinea(cadacliente.Fecha_de_Nacimiento);
                agregaralinea(cadacliente.Tickets_de_Sorteo);
                agregaralinea(cadacliente.Contacto);
                agregaralinea(cadacliente.RUT);
                agregaralinea('<img ruta="eliminar.php?tipo=cliente&id=' + cadacliente.ID_CLIENTE + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificar/modificarcliente.php?id=' + cadacliente.ID_CLIENTE + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                tabla.appendChild(linea);

            })
            asignarbotoneliminar();//llamamos a la funcion luego de haber cargado todos las filas.
        }


    }

}

export function cargarproductos() {
    var tabla = document.querySelector("tbody");
    var cantidaddeelementosantes = tabla.children.length;
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiproductos.php');
    cargaDatos.send()
    cargaDatos.onload = function() {
        const productos = JSON.parse(this.responseText);

        if (cantidaddeelementosantes - 1 != productos.length) {
            tabla.innerHTML = "<tr><th>ID</th><th>nombre</th><th>Precio Neto</th><th>Código de barras</th><th>Descripcion</th><th>Marca</th><th>Cantidad</th><th>Cantidad de aviso</th><th>imagen</th><th>iva</th><th>medida</th><th>categoria</th><th>accion</th></tr>"
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

export function cargarproveedores() {
     var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
     var cantidaddeelementosantes = tabla.children.length; // guanta en la variable la cantidad de elementos "hijos" tiene la tabla

     const cargaDatos = new XMLHttpRequest();
     cargaDatos.open('GET', 'apis/apiproveedores.php'); //consulta a la api
     cargaDatos.send()
     cargaDatos.onload = function() {
         const proveedores = JSON.parse(this.responseText);

         if (cantidaddeelementosantes - 1 != proveedores.length) { // compara los elementos de la tabla con los resultados de la api, si hay una cantidad distinta, cargará todos los proveedores
             tabla.innerHTML = "<tr><th>ID</th><th>Razón social</th><th>RUT</th><th>Contacto</th><th>Acción</th></tr>"; // carga la primera fila de la tabla
             proveedores.forEach(cadaproveedor => {

                 var linea = document.createElement("tr");

                 function agregaralinea(dato) {
                     var objeto = document.createElement("td");
                     objeto.innerHTML = dato;
                     linea.appendChild(objeto);
                 }
                 agregaralinea(cadaproveedor.ID_PROVEEDOR)
                 agregaralinea(cadaproveedor.Razón_Social);
                 agregaralinea(cadaproveedor.RUT);
                 agregaralinea(cadaproveedor.Contacto);
                 agregaralinea('<img ruta="eliminar.php?tipo=proveedor&id=' + cadaproveedor.ID_PROVEEDOR + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificar/modificarproveedor.php?id=' + cadaproveedor.ID_PROVEEDOR + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                 tabla.appendChild(linea);

             })
             asignarbotoneliminar();//llamamos a la funcion luego de haber cargado todos las filas.
         }


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
}
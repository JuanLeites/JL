
export function asignarbotoneliminar() {

    function eliminar(ruta){ //funcion que ejecuta archivo de eliminar el cual se le pasan dos parametros(el tipo de objeto que vamos a borrar y la id) con esto el archivo ejecuta una consulta en la base de datos la cual elimina el archivo
        const CONSULTA = new XMLHttpRequest();
        CONSULTA.open('GET', 'apis/'+ruta); //consulta a la api
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

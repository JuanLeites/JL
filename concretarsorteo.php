<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");

if (!isset($_GET["id"])) {
    header("LOCATION:sorteos.php?causa=idnoseteada");
}

$consultadesorteo = mysqli_fetch_array(mysqli_query($basededatos, 'Select * FROM Sorteo WHERE ID_SORTEO ="' . $_GET["id"] . '"'));
if ($consultadesorteo["Fecha_realización"] == null) { // si el sorteo todavia no fue realizado

    $consultadeclientes = mysqli_query($basededatos, 'SELECT * FROM Cliente WHERE ACTIVO=TRUE and Tickets_de_Sorteo>=1;'); //obtenemos todos los clientes que tienen por lo menos un tiket del sorteo o más
    if (mysqli_num_rows($consultadeclientes) > 0) { //si por lo menos hay un ciente con tikets
        if (mysqli_num_rows($consultadeclientes) >= $consultadesorteo["Cantidad"]) { //si hay cantidad de clientes superior a la cantidad de premios
            foreach ($consultadeclientes as $cadacliente) { //un foreach que recorre todos los clientes
                for ($i = 0; $i < $cadacliente["Tickets_de_Sorteo"]; $i++) { //for que sera recorrido depende de la cantidad de tickets del sorteo que el cliente tenga
                    $arraydeparticipantes[] = $cadacliente["ID_CLIENTE"]; // lo ingresa en el array de participantes las veces que recorra el for osea depende de la cantidad de tickets que tenga
                }
            }
            shuffle($arraydeparticipantes); //shuffle es una funcion que mezcla todos los elementos del array pasado por parametros

            if ($consultadesorteo["Cantidad"] == 1) { //si es un solo elemento forzamos que sea un array de ganadores para poder hacer el foreach mas abajo
                $ganadores[] = array_rand($arraydeparticipantes, $consultadesorteo["Cantidad"]); //array_rand recive dos parametros, un array y un numero que será la cantidad de elementos que devuelva de forma aleatoria(devuelve los indices de forma aleatora).
            } else {
                $ganadores[] = array_rand($arraydeparticipantes, $consultadesorteo["Cantidad"]); //array_rand recive dos parametros, un array y un numero que será la cantidad de elementos que devuelva de forma aleatoria(devuelve los indices de forma aleatora).
            }

        } else {
            header("Location:sorteos.php?causa=maspremiosqueclientes");
            die(); //el die lo que hace es corta el codigo para que se cumpla la redirección sin ejecutar el resto del codigo
        }
    } else {
        header("Location:sorteos.php?causa=clientessintickets");
        die();
    }
} else {
    header("Location:sorteos.php?causa=sorteoyarealizado");
    die();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Sorteo</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="imagenes/icons/sorteo.png" type="image/x-icon">


</head>

<body>
    <div class="formularios" style="display: none;">

        <?php
        if ($consultadesorteo["Cantidad"] > 1) {
            echo "<h1>Ganadores/ras</h1>";
        } else {
            echo "<h1>Ganador/a</h1>";
        }
        ?>
        <div class='contenedordeganadores'>
            <?php

            foreach ($ganadores as $cadaganador) { // ganadoores es el array con los indices ganadores lo separamos en el idice de cada ganado
                mysqli_query($basededatos, 'INSERT INTO Ganador (ID_CLIENTE,ID_SORTEO) values ("' . $arraydeparticipantes[$cadaganador] . '","' . $_GET["id"] . '");');
                $datosdelclienteganador = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT * FROM Cliente WHERE ACTIVO=TRUE and ID_CLIENTE="' . $arraydeparticipantes[$cadaganador] . '"')); //obtenemos los datos del cliente ganador
                echo "<p class='ganadores'>" . $datosdelclienteganador["Nombre"] . " - " . $datosdelclienteganador["Cédula"] . "</p>";
                $ganadoresJS[] = $datosdelclienteganador["Nombre"] . " - " . $datosdelclienteganador["Cédula"]; // guardamos el nombre y la cédula de cada ganador en un array
            }

             mysqli_query($basededatos, 'UPDATE Sorteo SET Fecha_realización ="' . date("Y-m-d") . '" WHERE ID_SORTEO ="' . $_GET["id"] . '"');
             mysqli_query($basededatos, 'UPDATE Cliente SET Tickets_de_Sorteo="0"');
            ?>
        </div>
    </div>
    <a href="sorteos.php" id="reg">Regresar</a>
    <script>
        const ganadores = <?php echo json_encode($ganadoresJS); ?>; // le seteamos a ganadores en formato json el array de ganadores

        const colores = new XMLHttpRequest();
        colores.open('GET', 'apis/apidecolores.php');
        colores.send();

        colores.onload = function() {
            const datos = JSON.parse(this.responseText);
            const colorPrincipal = datos.color_principal;
            const colorFondo = datos.color_fondo;

            let delay = 0;

            ganadores.forEach((cadaganador, indice) => { //foreach que recorre el array de ganadores en cadaganador
                setTimeout(() => { // cada vez que recorra el array, va a establecer un tiempo entre alertas
                    Swal.fire({
                        title: `🎉 ¡Ganador ${indice + 1}! 🎉`, // indice+1 pq el indice comienza en 0
                        background: colorFondo,
                        color: colorPrincipal,
                        text: cadaganador,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000,
                    });
                }, delay); // la primera vez será 0, cada alerta se ejecutará 500ms luego que termine la otra
                delay += 2500; //se hace un incremento de tiempo para poder diferenciar las alertas, 2000 que durará mas 500ms de separación entre alertas
            });

            setTimeout(() => {//este set time out se ejecutará una vez finalicen todas las alertas y seteará el formulario visible.
                document.querySelector(".formularios").setAttribute("style", "display:flex")
            }, delay)
        }

    </script>
</body>



</html>
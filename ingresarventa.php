<?php
include("chequeodelogin.php");
include("coneccionBD.php");
include("funciones.php");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Venta</title>

    <link rel="stylesheet" href="css/style.css">
    <?php include("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="./imagenes/icons/carrito.png" type="image/x-icon">
</head>

<body>
    <div class="compra-venta">
        <div class="formularios">
            <div>
                <input type="search" id="filtro" class="filtroproductos" placeholder="Buscar Productos">

            </div>

            <div class="agregarproductos">
                <table>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <form method="POST" class="formularios" action="confirmarventa.php">
            <h1>Ingresar Venta</h1>
            <label for="filtro">Buscar o <a style="text-decoration: none; color:<?php echo $colorprincipal; ?>;" target="_blank" href="agregarclientes.php">agregar clientes</a> </label>
            <input id="filtro" type="search" placeholder="Buscar" class="filtroclientes">

            <select name="ID_CLIENTE" class="selectdeclientes" required></select>
            <div class="contenedordeproductos">
                <table class="agregarproductos">
                    <tbody class="tabladeprductosagregados">

                    </tbody>
                </table>
            </div>
            <input class="botonenviar" type="submit" value="Recibir Pago" disabled> <!-- le ponemos disabled para que el boton esté desabilitado al cargar la pagina, pero al presionar unos de los botones de agregar un producto, llama a la funcion agregar la cual habilita el botón  -->
        </form>
    </div>


    <?php include("barralateral.html"); ?>
</body>
<script type="module">
    import {
        cargarclientesenselect,
        cargarproductosparavender
    } from "./js/funciones.js"
    var inputdeclientes = document.querySelector(".filtroclientes")
    var inputdeproductos = document.querySelector(".filtroproductos")
    inputdeclientes.addEventListener("keyup", () => {
        cargarclientesenselect(inputdeclientes.value)
    })
    inputdeproductos.addEventListener("keyup", () => {
        cargarproductosparavender(inputdeproductos.value)
    })

    window.onload = () => {
        cargarclientesenselect();
        cargarproductosparavender()
        setInterval(() => {
            if (inputdeclientes.value == "") {
                cargarclientesenselect();
            }
            if (inputdeproductos.value == "") {
                cargarproductosparavender()
            }

        }, 2000);
    }
</script>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["monto"]) && isset($_POST["ID_CLIENTE"]) && isset($_POST["ID_VENTA"])) {
        mysqli_query($basededatos, 'INSERT INTO cobro (Monto,ID_CLIENTE, Fecha_Cobro,ID_Venta) VALUES ("' . $_POST["monto"] . '","' . $_POST["ID_CLIENTE"] . '","' . date("Y-m-d") . '","' . $_POST["ID_VENTA"] . '");');
        $cliente = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Deuda,Tickets_de_Sorteo from cliente WHERE ID_CLIENTE="' . $_POST["ID_CLIENTE"] . '";')); //obtenemos los datos del cliente
        $Tiketsanteriores = $cliente["Tickets_de_Sorteo"];
        $PrecioFinaldelaventa = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Precio_Final from venta WHERE ID_VENTA="' . $_POST["ID_VENTA"] . '";')); // obtenemos el precio final de la venta

        //sabiendo que $_POST["monto"] es lo que pagó podemos calcular la deuda que se le debe de sumar y también calular los tikets que generó

        $generacióndetikets = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Precio_por_Tickets from usuario WHERE Usuario="' . $_SESSION["usuario"] . '";'));
        $tiketsgenerados = floor($_POST["monto"] / $generacióndetikets["Precio_por_Tickets"]); //calculamos los tickets generados por la compra dividiendo el motno por el precio del tiket y lo redondeamos con el floor. dividimos lo que pagó por lo que saldria generar un tiket según la condiguración del usuario
        $deudadeventa = $PrecioFinaldelaventa["Precio_Final"] - $_POST["monto"]; // calculamos lo que salió la venta menos lo que pagó el cliente. se genera la deuda (lo que faltó por pagar)
        $deudaactual = $cliente["Deuda"] + $deudadeventa; // establecemos en la variable deudaactual el valor de la deuda anterior del cliente + la deuda de la vanta actual. 
        $tiketsactuales = $Tiketsanteriores + $tiketsgenerados;


        mysqli_query($basededatos, 'UPDATE `cliente` SET `Tickets_de_Sorteo`="' . $tiketsactuales . '",`Deuda`="' . $deudaactual . '"  WHERE `ID_CLIENTE`="' . $_POST["ID_CLIENTE"] . '";'); // lo actualizamos en la base de datos


        mostraraviso("Venta concretada con éxito, y deuda del cliente actualizada", $colorfondo, $colorsecundario);
    }
}

?>
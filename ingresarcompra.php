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
    <title>Ingresar Compra</title>

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

        <form method="POST" class="formularios" action="confirmarcompra.php">
            <h1>Ingresar Compra</h1>
            <label for="filtro">Buscar o <a style="text-decoration: none; color:<?php echo $colorprincipal; ?>;" target="_blank" href="agregarproveedores.php">agregar proveedores</a> </label>
            <input id="filtro" type="search" placeholder="Buscar" class="filtroproveedores">

            <select name="ID_PROVEEDOR" class="selectdeproveedores" required></select>
            <div class="contenedordeproductos">
                <table class="agregarproductos">
                    <tbody class="tabladeprductosagregados">

                    </tbody>
                </table>
            </div>
            <input class="botonenviar" type="submit" value="Proceder al Pago" disabled> <!-- le ponemos disabled para que el boton esté desabilitado al cargar la pagina, pero al presionar unos de los botones de agregar un producto, llama a la funcion agregar la cual habilita el botón  -->
        </form>
    </div>


    <?php include("barralateral.html"); ?>
</body>
<script type="module">
    import {
        cargarproveedoresenselect,
        cargarproductosparacomprar
    } from "./js/funciones.js"
    var inputdeproveedores = document.querySelector(".filtroproveedores")
    var inputdeproductos = document.querySelector(".filtroproductos")
    inputdeproveedores.addEventListener("keyup", () => {
        cargarproveedoresenselect(inputdeproveedores.value)
    })
    inputdeproductos.addEventListener("keyup", () => {
        cargarproductosparacomprar(inputdeproductos.value)
    })

    window.onload = () => {
        cargarproveedoresenselect();
        cargarproductosparacomprar()
        setInterval(() => {
            if (inputdeproveedores.value == "") {
                cargarproveedoresenselect();
            }
            if (inputdeproductos.value == "") {
                cargarproductosparacomprar()
            }

        }, 2000);
    }
</script>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["monto"]) && isset($_POST["ID_PROVEEDOR"]) && isset($_POST["ID_COMPRA"])) {
        mysqli_query($basededatos, 'INSERT INTO pago (Monto,ID_PROVEEDOR, Fecha_Pago,ID_COMPRA) VALUES ("' . $_POST["monto"] . '","' . $_POST["ID_PROVEEDOR"] . '","' . date("Y-m-d") . '","' . $_POST["ID_COMPRA"] . '");');
        $proveedor = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Deuda from proveedor WHERE ID_PROVEEDOR="' . $_POST["ID_PROVEEDOR"] . '";')); //obtenemos los datos del proveedor
        $PrecioFinaldelacompra = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Precio_Final from compra WHERE ID_COMPRA="' . $_POST["ID_COMPRA"] . '";')); // obtenemos el precio final de la compra

        //sabiendo que $_POST["monto"] es lo que se pagó podemos calcular la deuda que se le debe de sumar

        $deudadecompra = $PrecioFinaldelacompra["Precio_Final"] - $_POST["monto"]; // calculamos lo que salió la compra menos lo que le pagamos al proveedor. se genera la deuda (lo que faltó por pagar) en otra palabras lo que le quedamos debiendo
        $deudaactual = $proveedor["Deuda"] - $deudadecompra; // establecemos en la variable deudaactual el valor de la deuda anterior del proveedor menos la deuda de la compra
        // la deuda deberia de aumentar si es que yo pago de más 
        //pero si llegase a pagar de menos, esta deberia de restar. ya que le estamos debiendo mas al cliente(si tiene una deuda negativa es lo que le debemos)


        mysqli_query($basededatos, 'UPDATE `proveedor` SET `Deuda`="' . $deudaactual . '"  WHERE `ID_PROVEEDOR`="' . $_POST["ID_PROVEEDOR"] . '";'); // lo actualizamos en la base de datos


        mostraraviso("Compra concretada con éxito, y deuda del proveedor actualizada", $colorfondo, $colorsecundario);
    }
}

?>
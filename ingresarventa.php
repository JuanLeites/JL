<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["monto"]) && isset($_POST["ID_CLIENTE"]) && isset($_POST["IDPRODUCTOS"]) && isset($_POST["CANTIDAD"])) {
        //ingresamos la venta
        mysqli_query($basededatos, 'INSERT INTO Venta (Precio_Final,Fecha_Venta,ID_Cliente,Sub_Total) values ("' . $_POST["precio_final"] . '","' . date("Y-m-d") . '","' . $_POST["ID_CLIENTE"] . '","' . $_POST["subtotal"] . '");'); //ingresamos la venta con lso datos pasados por metodo post de la pagina "confirmarventa.php" en el cual son calculados
        $iddeventa = mysqli_insert_id($basededatos); // guardamos en la variable $iddeventa la clave principal de la ultima insercción en la base de datos(la venta ingresada);

        //cargamos todos los productos en la tabla productos_vendidos con la id de la venta y los datos de la venta
        foreach ($_POST["IDPRODUCTOS"] as $indice => $cadaID) {
            $productoconprecio = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Valor, Nombre, Precio_Venta,Cantidad From Producto p, IVA i WHERE i.ID_IVA= p.ID_IVA and ID_PRODUCTO="' . $cadaID . '";'));
            //actualizamos la cantidad de cada producto dependiendo a lo que vendió:
            $cantidadactualizada = floatval($productoconprecio["Cantidad"]) - floatval($_POST["CANTIDAD"][$indice]); //obtenemos la cantidad actualizada de cada producto
            mysqli_query($basededatos, 'UPDATE Producto SET Cantidad="' . $cantidadactualizada . '" WHERE ID_PRODUCTO="' . $cadaID . '" ');

            mysqli_query($basededatos, 'INSERT INTO Productos_Vendidos (ID_VENTA,ID_PRODUCTO, Cantidad_de_Venta, Precio_de_Venta, Iva_de_Venta) values ("' . $iddeventa . '","' . $cadaID . '","' . $_POST["CANTIDAD"][$indice] . '","' . floatval($productoconprecio["Precio_Venta"]) . '","' . $productoconprecio["Valor"] . '");'); //ingresamos cada producto a la tabla productos vendidos
        }

        //ingresamos el cobro con el cliente, la id de venta y el usuario que la realizó
        mysqli_query($basededatos, 'INSERT INTO Cobro (Monto, ID_CLIENTE, Fecha_Cobro, ID_Venta, Usuario) VALUES ("' . $_POST["monto"] . '","' . $_POST["ID_CLIENTE"] . '","' . date("Y-m-d") . '","' . $iddeventa . '","' . $_SESSION["usuario"] . '");');
        $cliente = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT RUT,Deuda,Tickets_de_Sorteo from Cliente WHERE ID_CLIENTE="' . $_POST["ID_CLIENTE"] . '";')); //obtenemos los datos del cliente
        $Tiketsanteriores = $cliente["Tickets_de_Sorteo"];
        $Deduaanterior = $cliente["Deuda"];
        $PrecioFinaldelaventa = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Precio_Final from Venta WHERE ID_VENTA="' . $iddeventa . '";')); // obtenemos el precio final de la venta

        //sabiendo que $_POST["monto"]  es lo que se pagó  y $_POST["precio_final"] es lo que debería de haberse pagado. podemos calcular la deuda que se le debe de sumar al cliente.
        $generacióndetikets = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Precio_por_Tickets from Configuración')); //obtenemos el valor de generación de generacion por tickets
        $tiketsgenerados = floor($_POST["monto"] / $generacióndetikets["Precio_por_Tickets"]); //calculamos los tickets generados por la compra dividiendo el motno por el precio del tiket y lo redondeamos con el floor. dividimos lo que pagó por lo que saldria generar un tiket según la condiguración del usuario
        $tiketsactuales = $Tiketsanteriores + $tiketsgenerados;

        $deudadeventa = $PrecioFinaldelaventa["Precio_Final"] - $_POST["monto"]; // calculamos lo que deberia de haber pagado por la venta menos lo que pagó el cliente. se genera la deuda (lo que faltó por pagar)
        $deudaactual = $Deduaanterior + $deudadeventa; // establecemos en la variable deudaactual el valor de la deuda anterior del cliente + la deuda de la vanta actual. 


        mysqli_query($basededatos, 'UPDATE `Cliente` SET `Tickets_de_Sorteo`="' . $tiketsactuales . '",`Deuda`="' . $deudaactual . '"  WHERE `ID_CLIENTE`="' . $_POST["ID_CLIENTE"] . '";'); // actualizamos la deuda y los tikets del cliente

        if ($cliente["RUT"] != "") {
            header("Location:ingresarventa.php?causa=ventaconcretadarut&id=" . $iddeventa); //redirigimos a la misma página pero con una causa y una id de venta.
        } else {
            header("Location:ingresarventa.php?causa=ventaconcretada&id=" . $iddeventa); //redirigimos a la misma página pero con una causa y una id de venta.
        }
        die();
    }
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Venta</title>

    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="imagenes/icons/cobros.png" type="image/x-icon">
</head>

<body>
    <div class="compra-venta">
        <div class="formularios primerformulario">
            <div class="contenedordebuscadoryboton">
                <input type="search" id="filtro" class="filtroproductos" placeholder="Buscar Productos">
                <a href="agregarproductos.php" target="_blank" class="agregardato">+</a>
            </div>

            <div class="agregarproductos">
                <table>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <form method="POST" class="formularios segundoformulario" action="confirmarventa.php">
            <h1>Ingresar Venta</h1>
            <label for="filtro">Buscar o <a class="enlace" target="_blank" href="agregarclientes.php">agregar clientes</a> </label>
            <input id="filtro" type="search" placeholder="Buscar" class="filtroclientes">

            <select name="ID_CLIENTE" class="selectdeclientes" required></select>
            <div class="contenedordeproductos">
                <table class="agregarproductos">
                    <tbody class="tabladeprductosagregados">
                    </tbody>
                </table>
            </div>
            <input class="botonenviar" type="submit" value="Proceder al cobro" disabled> <!-- le ponemos disabled para que el boton esté desabilitado al cargar la pagina, pero al presionar unos de los botones de agregar un producto, llama a la funcion agregar la cual habilita el botón  -->
        </form>
    </div>


    <?php include_once("barralateral.html"); ?>
</body>
<script src="js/funcionessinexport.js"></script>
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
if (isset($_GET["causa"])) {
    switch ($_GET['causa']) {
        case "sinproductos":
            mostraralerta("No puedes realizar una venta sin productos", $colorfondo, $colorprincipal);
            break;
        case "ventaconcretada":
            mostraraviso("Venta concretada con éxito, y deuda del cliente actualizada", $colorfondo, $colorsecundario);
            imprimirPDF("venta", $_GET["id"]);
            break;
        case "ventaconcretadarut":
            mostraraviso("Venta a cliente con RUT concretada con éxito, y deuda del cliente actualizada", $colorfondo, $colorsecundario);
            imprimirPDF("factura", $_GET["id"]);
            break;
    }
}

?>
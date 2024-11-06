<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["monto"]) && isset($_POST["ID_PROVEEDOR"]) && isset($_POST["IDPRODUCTOS"]) && isset($_POST["CANTIDAD"]) && isset($_POST["precio_final"])) {
        if ($_POST["monto"] != "") {
            //chequeamos si es a crédito o contado:
            if ($_POST["fechacredito"] != "") { //si es a credito, la fecha de crédito se debe de setear
                mysqli_query($basededatos, 'INSERT INTO Compra (Precio_Final,Fecha_COMPRA,ID_Proveedor,sub_total,Vencimiento_Factura) values ("' .  $_POST["precio_final"] . '","' . date("Y-m-d") . '","' . $_POST["ID_PROVEEDOR"] . '","' . $_POST["subtotal"] . '","' . $_POST["fechacredito"] . '");'); //insertamos la compra antes del cobro ya que el cobro es algo que va por separado ya que le puede pagar menos de lo que sale
                $esacredito = true;
            } else { //si llegase a ser al contado
                mysqli_query($basededatos, 'INSERT INTO Compra (Precio_Final,Fecha_COMPRA,ID_Proveedor,sub_total) values ("' .  $_POST["precio_final"] . '","' . date("Y-m-d") . '","' . $_POST["ID_PROVEEDOR"] . '","' . $_POST["subtotal"] . '");'); //insertamos la compra antes del cobro ya que el cobro es algo que va por separado ya que le puede pagar menos de lo que sale
            }
            $iddecompra = mysqli_insert_id($basededatos); // guardamos en la variable $iddecompra la clave principal de la ultima insercción en la base de datos(la compra ingresada);


            foreach ($_POST["IDPRODUCTOS"] as $indice => $cadaID) {
                $productoconprecio = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Valor, Nombre, Precio_Compra, Cantidad From Producto p, IVA i WHERE i.ID_IVA= p.ID_IVA and ID_PRODUCTO="' . $cadaID . '";'));
                //actualizamos la cantidad de cada producto dependiendo a lo que compró:
                $cantidadactualizada = floatval($productoconprecio["Cantidad"]) + floatval($_POST["CANTIDAD"][$indice]); //obtenemos la cantidad actualizada de cada producto
                mysqli_query($basededatos, 'UPDATE Producto SET Cantidad="' . $cantidadactualizada . '" WHERE ID_PRODUCTO="' . $cadaID . '" ');
                mysqli_query($basededatos, 'INSERT INTO Productos_Comprados (ID_COMPRA,ID_PRODUCTO, Cantidad_de_Compra, Precio_de_Compra,Iva_de_Compra) values ("' . $iddecompra . '","' . $cadaID . '","' . $_POST["CANTIDAD"][$indice] . '","' . floatval($productoconprecio["Precio_Compra"]) . '","' . $productoconprecio["Valor"] . '");'); //ingresamos cada producto a la tabla productos vendidos
            }

            mysqli_query($basededatos, 'INSERT INTO Pago (Monto, ID_PROVEEDOR, Fecha_Pago, ID_COMPRA, Usuario) VALUES ("' . $_POST["monto"] . '","' . $_POST["ID_PROVEEDOR"] . '","' . date("Y-m-d") . '","' . $iddecompra . '","' . $_SESSION["usuario"] . '");');
            $proveedor = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Deuda from Proveedor WHERE ID_PROVEEDOR="' . $_POST["ID_PROVEEDOR"] . '";')); //obtenemos los datos del proveedor

            //sabiendo que $_POST["monto"]  es lo que se pagó  y $_POST["precio_final"] es lo que debería de haberse pagado. podemos calcular la deuda que se le debe de sumar al proveedor.
            $deudadecompra = $_POST["precio_final"] - $_POST["monto"]; //calculamos la deuda que generó el proveedor.
            $deudaactual = $proveedor["Deuda"] - $deudadecompra; // establecemos en la variable deudaactual el valor de la deuda anterior del proveedor menos la deuda de la compra
            // la deuda deberia de aumentar si es que yo pago de más. ya que se calcula depende lo que yo le pago al proveedor
            //pero si llegase a pagar de menos, esta deberia de restar. ya que el proveedor nos estaria debiendo menos (si tiene una deuda negativa es lo que se le quedó debiendo al proveedor)

            mysqli_query($basededatos, 'UPDATE `Proveedor` SET `Deuda`="' . $deudaactual . '"  WHERE `ID_PROVEEDOR`="' . $_POST["ID_PROVEEDOR"] . '";'); // lo actualizamos en la base de datos

            imprimirPDF("compra", $iddecompra);
            if (isset($esacredito)) {
                header("Location:ingresarcompra.php?causa=compraacreditook&id=" . $iddecompra); //redirigimos a la misma página pero con una causa y una id de compra.
                die();
            } else {
                header("Location:ingresarcompra.php?causa=compraacontadook&id=" . $iddecompra); //redirigimos a la misma página pero con una causa y una id de compra.
                die();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Compra</title>

    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="imagenes/icons/pagos.png" type="image/x-icon">
</head>

<body>
    <div class="compra-venta">
        <div class="formularios primerformulario">
            <div class="contenedordebuscadoryboton">
                <input type="search" id="filtro" class="filtroproductos" placeholder="Buscar Productos">
                <a href="agregarproductos.php" target="_blank" class="agregardato">+</a>
                <a href="#top" class="button agregadordeproductos" style="transform:scale(0);">
                    <svg class="svgIcon" viewBox="0 0 384 512">
                        <path
                            d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z"></path>
                    </svg>
                </a>
            </div>

            <div class="agregarproductos">
                <div class="contenedordedatos" id="top">
                    <div class="cantidaddeelementos"></div>
                    <div class="recargartabla">recargar</div>
                </div>
                <table class="agregarproductos">
                    <tbody pagina="1" actualizar="si" limite="12">
                    </tbody>
                </table>
            </div>
        </div>

        <form method="POST" class="formularios segundoformulario" action="confirmarcompra.php">
            <h1>Ingresar Compra</h1>
            <label for="filtro">Buscar o <a class="enlace" target="_blank" href="agregarproveedores.php">agregar proveedores</a> </label>
            <input id="filtro" type="search" placeholder="Buscar" class="filtroproveedoreparaselect">
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


    <?php include_once("barralateral.html"); ?>
</body>
<script src="js/funcionessinexport.js"></script>
</html>
<?php
if (isset($_GET["causa"])) {
    switch ($_GET['causa']) {
        case "sinproductos":
            mostraralerta("No puedes realizar una compra sin productos", $colorfondo, $colorprincipal);
            break;
        case 'compraacreditook':
            mostraraviso("Compra a crédito concretada con éxito, y deuda del proveedor actualizada", $colorfondo, $colorsecundario);
            imprimirPDF("compra", $_GET["id"]);
            break;
        case 'compraacontadook':
            mostraraviso("Compra al contado concretada con éxito, y deuda del proveedor actualizada", $colorfondo, $colorsecundario);
            imprimirPDF("compra", $_GET["id"]);
            break;
    }
}
?>
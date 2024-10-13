<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar el pago de la Compra</title>

    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="imagenes/icons/pagos.png" type="image/x-icon">
</head>

<body>

    <div class="compra-venta">
        <div class="agregarproductos">
            <table>
                <tbody>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio por Unidad</th>
                        <th>iva</th>
                        <th>Monto</th>
                    </tr>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if(!isset($_POST["IDPRODUCTOS"])){//si no está seteado ningun producto
                            header("Location:ingresarcompra.php?causa=sinproductos"); // nos manda a ingresar compra con la variable causa seteada con un error especifico
                            die();
                        }
                        $total = 0; //contador que sumara el precio del producto por la cantidad mas el iva
                        $subtotal = 0; //se guardará en cada reiteración del for el Precio_Compra(sin iva) por la cantidad de compra (de cada producto)
                        $contadordeiva10 = 0;
                        $contadordeiva22 = 0;
                        $contadordesubtotal = 0; // contador que sumara todos los subtotales de cada producto
                        $proveedor = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT * From proveedor WHERE ID_PROVEEDOR="' . $_POST["ID_PROVEEDOR"] . '";'));

                        foreach ($_POST["IDPRODUCTOS"] as $indice => $cadaID) {
                            $productoconprecio = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Valor, Nombre, Precio_Compra, Cantidad From Producto p, iva i WHERE i.ID_IVA= p.ID_IVA and ID_PRODUCTO="' . $cadaID . '";'));//obtenemos el producto y su precio
                            $subtotal = floatval($productoconprecio["Precio_Compra"]) * floatval($_POST["CANTIDAD"][$indice]); // el precio de cada producto por la cantidad pero sin el iva
                            
                            //calculamos depende su iva: 
                            if ($productoconprecio["Valor"] == 10) { // si el iva es del 10 
                                $contadordeiva10 += (($subtotal / 100) * $productoconprecio["Valor"]); // le sumamos a la variable que tiene la funcion de contador el iva dependiendo del subtotal
                            }
                            if ($productoconprecio["Valor"] == 22) { // si el iva es del 22
                                $contadordeiva22 += (($subtotal / 100) * $productoconprecio["Valor"]); // le sumamos a la variable que tiene la funcion de contador el iva dependiendo del subtotal
                            }
                            $preciototalconiva = $subtotal + (($subtotal / 100) * $productoconprecio["Valor"]); // le sumamos al subtotal el iva
                            
                            $contadordesubtotal += $subtotal;

                            $preciototalconiva = $subtotal + (($subtotal / 100) * $productoconprecio["Valor"]); // le sumamos al subtotal el iva
                            $total += $preciototalconiva;

                            echo "<tr><th>" . $productoconprecio["Nombre"] . "</th><th>" . $_POST["CANTIDAD"][$indice] . "</th><th>" . $productoconprecio["Precio_Compra"] . "</th><th>" . $productoconprecio["Valor"] . "%</th><th>" . $subtotal . "</th></tr>";
                        
                        }
                        if ($contadordeiva10 != 0) {
                            echo "<tr><th colspan='3'></th><th>Iva 10%</th><th>" . $contadordeiva10 . "</th></tr>";
                        }
                        if ($contadordeiva22 != 0) {
                            echo "<tr><th colspan='3'></th></th><th>Iva 22%</th><th>" . $contadordeiva22 . "</th></tr>";
                        }
                        
                        echo "<tr><th colspan='3'></th><th>Subtotal</th><th>" . $contadordesubtotal . "</th></tr>";
                        echo "<tr><th colspan='3'></th><th>Total</th><th>" . $total . "</th></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <form method="POST" class="formularios" action="ingresarcompra.php">
        <?php
            //para mandar los datos de la compra por post al siguiente formulario para cargar todo en la pagina "ingresarcompra.php".
            echo "<input type='hidden' name='precio_final' value='" . $total . "'>";
            echo "<input type='hidden' name='ID_PROVEEDOR' value='" . $_POST["ID_PROVEEDOR"] . "' >";
            echo "<input type='hidden' name='subtotal' value='" . $contadordesubtotal . "'>";

            foreach ($_POST["IDPRODUCTOS"] as $indice => $cadaID) {
                //$productoconprecio = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Nombre,Valor, Precio_Venta, Cantidad From Producto p, iva i WHERE i.ID_IVA= p.ID_IVA and ID_PRODUCTO="' . $cadaID . '";')); // consulta la cual obtiene el valor del iva que le corresponde y el precio de venta del producto
                echo "<input type='hidden' name='IDPRODUCTOS[]' value='" . $cadaID . "'>"; //carga un input escondido con el valor de la id de el producto agregado con un nombre con parentesis para poder pasar un arreglo
                echo "<input type='hidden' name='CANTIDAD[]' value='" . $_POST["CANTIDAD"][$indice] . "'>";
            }
            ?>
            <h1>Compra a <?php echo  $proveedor["Razón_Social"] . " - " . $proveedor["RUT"];  ?>
            </h1>
            <label for="cuantopaga">Ingrese el dinero pagado </label>
            <input id="cuantopaga" type="number" placeholder="Dinero Pagado" name="monto" min="0"  required>
            <input type="submit" value="Concretar Compra">
        </form>
    </div>
    <?php include_once("barralateral.html");
    ?>
</body>
<script type="module">

</script>

</html>
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
    <title>Ingresar el pago de la venta</title>

    <link rel="stylesheet" href="css/style.css">
    <?php include("css/colorespersonalizados.php"); ?>


    <link rel="shortcut icon" href="/LUPF/imagenes/icons/carrito.png" type="image/x-icon">
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
                        $total = 0; //contador que sumara el precio del producto por la cantidad mas el iva
                        $subtotal = 0; //se guardará en cada reiteración del for el Precio_Venta(sin iva) por la cantidad de compra (de cada producto)
                        $contadordeiva10 = 0;
                        $contadordeiva22 = 0;
                        $contadordesubtotal = 0; // contador que sumara todos los subtotales de cada producto
                        $cliente = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT * From cliente WHERE ID_CLIENTE="' . $_POST["ID_CLIENTE"] . '";'));

                        foreach ($_POST["IDPRODUCTOS"] as $indice => $cadaID) { // foreach al array de ID_PRODUCTOS pasado por post // hacemos primero este for para obtener los datos para poder ingresar primero la venta
                            $productoconprecio = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Valor, Precio_Venta,Cantidad From Producto p, iva i WHERE i.ID_IVA= p.ID_IVA and ID_PRODUCTO="' . $cadaID . '";')); // consulta la cual obtiene el valor del iva que le corresponde y el precio de venta del producto
                            //junto a esto una consulta que ingresa el producto con la venta a la tabla ProductosVendidos
                            $subtotal = floatval($productoconprecio["Precio_Venta"]) * floatval($_POST["CANTIDAD"][$indice]); // el precio de cada producto por la cantidad pero sin el iva
                            $contadordesubtotal += $subtotal;

                            $preciototalconiva = $subtotal + (($subtotal / 100) * $productoconprecio["Valor"]); // le sumamos al subtotal el iva
                            $total += $preciototalconiva;
                        }
                        mysqli_query($basededatos, 'INSERT INTO Venta (Precio_Final,Fecha_Venta,ID_Cliente,sub_total) values ("' . $total . '","' . date("Y-m-d") . '","' . $_POST["ID_CLIENTE"] . '","' . $contadordesubtotal . '");'); //insertamos la venta antes del cobro ya que el cobro es algo que va por separado ya que le puede pagar menos de lo que sale
                        $iddeventa = mysqli_insert_id($basededatos); // guardamos en la variable $iddeventa la clave principal de la ultima insercción en la base de datos(la venta ingresada);

                        foreach ($_POST["IDPRODUCTOS"] as $indice => $cadaID) {
                            $productoconprecio = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Valor, Nombre, Precio_Venta,Cantidad From Producto p, iva i WHERE i.ID_IVA= p.ID_IVA and ID_PRODUCTO="' . $cadaID . '";'));
                            //actualizamos la cantidad de cada producto dependiendo a lo que compró:
                            $cantidadactualizada=floatval($productoconprecio["Cantidad"])-floatval($_POST["CANTIDAD"][$indice]);//obtenemos la cantidad actualizada de cada producto
                            mysqli_query($basededatos,'UPDATE producto SET Cantidad="'.$cantidadactualizada.'" WHERE ID_PRODUCTO="'.$cadaID.'" ');

                            $subtotal = floatval($productoconprecio["Precio_Venta"]) * floatval($_POST["CANTIDAD"][$indice]); // el precio de cada producto por la cantidad pero sin el iva
                            mysqli_query($basededatos, 'INSERT INTO productos_vendidos (ID_VENTA,ID_PRODUCTO,Cantidad_de_Venta,Precio_de_Venta) values ("' . $iddeventa . '","' . $cadaID . '","' . $_POST["CANTIDAD"][$indice] . '","' . $subtotal . '");'); //ingresamos cada producto a la tabla productos vendidos

                            if ($productoconprecio["Valor"] == 10) { // si el iva es del 10 
                                $contadordeiva10 += (($subtotal / 100) * $productoconprecio["Valor"]); // le sumamos a la variable que tiene la funcion de contador el iva dependiendo del subtotal
                            }
                            if ($productoconprecio["Valor"] == 22) { // si el iva es del 10 
                                $contadordeiva22 += (($subtotal / 100) * $productoconprecio["Valor"]); // le sumamos a la variable que tiene la funcion de contador el iva dependiendo del subtotal
                            }
                            $preciototalconiva = $subtotal + (($subtotal / 100) * $productoconprecio["Valor"]); // le sumamos al subtotal el iva


                            echo "<tr><th>" . $productoconprecio["Nombre"] . "</th><th>" . $_POST["CANTIDAD"][$indice] . "</th><th>" . $productoconprecio["Precio_Venta"] . "</th><th>" . $productoconprecio["Valor"] . "%</th><th>" . $subtotal . "</th></tr>";
                        }
                        if ($contadordeiva10 != 0) {
                            echo "<tr><th></th><th></th><th></th><th>Iva 10%</th><th>" . $contadordeiva10 . "</th></tr>";
                        }
                        if ($contadordeiva22 != 0) {
                            echo "<tr><th></th><th></th><th></th><th>Iva 22%</th><th>" . $contadordeiva22 . "</th></tr>";
                        }
                        echo "<tr><th></th><th></th><th></th><th>Subtotal</th><th>" . $contadordesubtotal . "</th></tr>";
                        echo "<tr><th></th><th></th><th></th><th>Total</th><th>" . $total . "</th></tr>";
                    }



                    ?>
                </tbody>
            </table>
        </div>
        <form method="POST" class="formularios" action="ingresarventa.php">
            <h1>Venta a <?php echo  $cliente["Nombre"] . " - " . $cliente["Cédula"];  ?>
            </h1>
            <?php echo "<input type='hidden' name='ID_VENTA' value='" . $iddeventa . "'> <input type='hidden' name='ID_CLIENTE' value='" . $_POST["ID_CLIENTE"] . "' ";  ?>
            <label for="cuantopaga">Ingrese el dinero recibido </label>
            <input id="cuantopaga" tpye="number" placeholder="Dinero Recibido" name="monto" min="1" required>
            <input type="submit" value="Concretar Venta">
            <?php if($cliente["RUT"]!="no tiene"){ echo "<input type='button' value='Solicitar Boleta'></input>"; }//solamente carga el botón solicitar boleta si el cliente tiene rut  ?>
        </form>
    </div>
    <?php include("barralateral.html");
    ?>
</body>
<script type="module">

</script>

</html>
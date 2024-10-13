<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver datos de la Compra</title>

    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>

    <link rel="shortcut icon" href="imagenes/icons/cobros.png" type="image/x-icon">
</head>

<body>
    <div class="compra-venta">
        <div class="formularios">
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
                        //sumar los precio
                        if (isset($_GET["id"])) {
                            $datosdecompra = mysqli_fetch_array(mysqli_query($basededatos, 'SELECT Razón_Social,RUT,Fecha_Compra,Monto,Precio_Final, Sub_Total, u.Nombre"NombreUsuario" from compra c,proveedor pr,pago pa,usuario u WHERE u.Usuario=pa.Usuario and c.ID_COMPRA = pa.ID_COMPRA and c.ID_PROVEEDOR = pr.ID_PROVEEDOR and c.ID_COMPRA="' . $_GET["id"] . ';"'));
                            $productos = mysqli_query($basededatos, 'SELECT p.Nombre, pc.Cantidad_de_Compra, i.Valor, pc.Precio_de_Compra From iva i,producto p ,compra c,productos_comprados pc WHERE i.ID_IVA = p.ID_IVA and pc.ID_PRODUCTO= p.ID_PRODUCTO and c.ID_COMPRA=pc.ID_COMPRA and c.ID_COMPRA="' . $_GET["id"] . '";');

                            foreach ($productos as $indice => $cadaproducto) {
                                echo "<tr><th>" . $cadaproducto["Nombre"] . "</th><th>" . $cadaproducto["Cantidad_de_Compra"] . "</th><th>" . $cadaproducto["Precio_de_Compra"] . "</th><th>" . $cadaproducto["Valor"] . "</th><th>" . $cadaproducto["Precio_de_Compra"] * $cadaproducto["Cantidad_de_Compra"] . "</th></tr>";
                            }
                            echo "<tr><th colspan='3'></th><th>Subtotal</th><th>" . $datosdecompra["Sub_Total"] . "</th></tr>";
                            echo "<tr><th colspan='3'></th><th>Total</th><th>" . $datosdecompra["Precio_Final"] . "</th></tr>";
                        } else {
                            header("Location:compras.php?causa=ningunidseteado"); // arreglar this
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="formularios">
            <h1>Datos de la Compra</h1>
            <p>Proveedor : <?php echo $datosdecompra["Razón_Social"] . " - " . $datosdecompra["RUT"]; ?> </p>
            <p>Fecha de la compra : <?php echo $datosdecompra["Fecha_Compra"]; ?> </p>
            <?php if ($datosdecompra["Vencimiento_Factura"] != "") {
                echo "<p>La compra fué a credito, vence : " . $datosdecompra["Vencimiento_Factura"] . "</p>";
            } ?>
            <p>Se le pagó al proveedor : <?php echo $datosdecompra["Monto"]; ?></p>
            <p>Generó una deuda de : <?php echo $datosdecompra["Monto"] - $datosdecompra["Precio_Final"]; // siendo monto el dinero que se le pagó al proveedor y precio final lo que se deberia de haber pagado 
                                        ?></p>
            <p>Compra ingresada por: <?php echo $datosdecompra["NombreUsuario"]; ?> </p>
        </div>
    </div>
    <?php include_once("barralateral.html");
    ?>
</body>
<script type="module">

</script>

</html>
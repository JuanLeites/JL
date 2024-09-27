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
    <title>Ver datos de la Venta</title>

    <link rel="stylesheet" href="css/style.css">
    <?php include("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="./imagenes/icons/carrito.png" type="image/x-icon">
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
                            $datosdeventa = mysqli_fetch_array(mysqli_query($basededatos, 'SELECT cl.Nombre, cl.Cédula, v.Fecha_Venta, co.Monto, v.Precio_Final, v.Sub_Total from venta v,cliente cl,cobro co WHERE co.ID_VENTA=v.ID_VENTA and v.ID_CLIENTE = cl.ID_CLIENTE and v.ID_VENTA="' . $_GET["id"] . ';"'));
                            $productos = mysqli_query($basededatos, 'SELECT p.Nombre, pv.Cantidad_de_Venta,i.Valor,pv.Precio_de_venta From iva i,producto p ,venta v,productos_vendidos pv WHERE i.ID_IVA = p.ID_IVA and pv.ID_PRODUCTO= p.ID_PRODUCTO and v.ID_VENTA=pv.ID_VENTA and v.ID_VENTA="' . $_GET["id"] . '";');
                            
                            foreach ($productos as $indice => $cadaproducto) {
                                echo "<tr><th>" . $cadaproducto["Nombre"] . "</th><th>" . $cadaproducto["Cantidad_de_Venta"] . "</th><th>" . $cadaproducto["Precio_de_venta"] . "</th><th>" . $cadaproducto["Valor"] . "</th><th>" . $cadaproducto["Precio_de_venta"]*$cadaproducto["Cantidad_de_Venta"] . "</th></tr>";//cargamos cada fila de productos calculando el monto sin el iva, de el precio de venta por la cantidad q se vendió
                            }
                            echo "<tr><th colspan='3'></th><th>Subtotal</th><th>" . $datosdeventa["Sub_Total"] . "</th></tr>";
                            echo "<tr><th colspan='3'></th><th>Total</th><th>" . $datosdeventa["Precio_Final"] . "</th></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="formularios">
            <h1>Datos de la venta</h1>
            <p>Cliente : <?php echo $datosdeventa["Nombre"]." - ".$datosdeventa["Cédula"]; ?> </p>
            <p>Fecha de la Venta : <?php echo $datosdeventa["Fecha_Venta"]; ?> </p>
            <p>El Cliente pagó : <?php echo $datosdeventa["Monto"]; ?></p>
            <p>Generó una deuda de : <?php echo $datosdeventa["Precio_Final"]-$datosdeventa["Monto"]; ?></p>
        </div>
    </div>
        <?php include("barralateral.html");
        ?>
</body>
<script type="module">

</script>

</html>
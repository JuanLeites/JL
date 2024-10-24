<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver datos de la Venta</title>

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
                            $datosdeventa = mysqli_fetch_array(mysqli_query($basededatos, 'SELECT cl.Nombre, cl.Cédula,cl.RUT, v.Fecha_Venta, co.Monto, v.Precio_Final, v.Sub_Total,u.Nombre"NombreUsuario" from Venta v, Cliente cl, Cobro co, Usuario u WHERE u.Usuario = co.Usuario and co.ID_VENTA=v.ID_VENTA and v.ID_CLIENTE = cl.ID_CLIENTE and v.ID_VENTA="' . $_GET["id"] . ';"'));
                            $productos = mysqli_query($basededatos, 'SELECT p.Nombre, pv.Cantidad_de_Venta,pv.Iva_de_Venta,pv.Precio_de_venta From Producto p , Venta v, Productos_Vendidos pv WHERE  pv.ID_PRODUCTO= p.ID_PRODUCTO and v.ID_VENTA=pv.ID_VENTA and v.ID_VENTA="' . $_GET["id"] . '";');

                            $contadordeiva10=0;
                            $contadordeiva22=0;
                            
                            foreach ($productos as $indice => $cadaproducto) {
                                echo "<tr><th>" . $cadaproducto["Nombre"] . "</th><th>" . $cadaproducto["Cantidad_de_Venta"] . "</th><th>" . $cadaproducto["Precio_de_venta"] . "</th><th>" . $cadaproducto["Iva_de_Venta"] . "</th><th>" . $cadaproducto["Precio_de_venta"] * $cadaproducto["Cantidad_de_Venta"] . "</th></tr>"; //cargamos cada fila de productos calculando el monto sin el iva, de el precio de venta por la cantidad q se vendió
                                
                                $subtotal = intval($cadaproducto["Precio_de_venta"])*intval($cadaproducto["Cantidad_de_Venta"]);
                                if ($cadaproducto["Iva_de_Venta"] == 10) { // si el iva es del 10 
                                    $contadordeiva10 += (($subtotal / 100) * $cadaproducto["Iva_de_Venta"]); // le sumamos a la variable que tiene la funcion de contador el iva dependiendo del subtotal
                                }
                                if ($cadaproducto["Iva_de_Venta"] == 22) { // si el iva es del 22
                                    $contadordeiva22 += (($subtotal / 100) * $cadaproducto["Iva_de_Venta"]); // le sumamos a la variable que tiene la funcion de contador el iva dependiendo del subtotal
                                }


                            }
                            if($contadordeiva10!=0){echo "<tr><th colspan='3'></th><th>Iva 10%</th><th>" . $contadordeiva10 . "</th></tr>";}
                            if($contadordeiva22!=0){echo "<tr><th colspan='3'></th><th>Iva 22%</th><th>" . $contadordeiva22  . "</th></tr>";}
                            echo "<tr><th colspan='3'></th><th>Subtotal</th><th>" . $datosdeventa["Sub_Total"] . "</th></tr>";
                            echo "<tr><th colspan='3'></th><th>Total</th><th>" . $datosdeventa["Precio_Final"] . "</th></tr>";
                        }else{
                            header("Location:menuprincipal.php");
                            die();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="formularios">
            <h1>Datos de la venta</h1>
            <p>Cliente : <?php echo $datosdeventa["Nombre"] . " - " . $datosdeventa["Cédula"]; ?> </p>
            <p>Fecha de la Venta : <?php echo $datosdeventa["Fecha_Venta"]; ?> </p>
            <p>El Cliente pagó : <?php echo $datosdeventa["Monto"]; ?></p>
            <p>Generó una deuda de : <?php echo $datosdeventa["Precio_Final"] - $datosdeventa["Monto"]; ?></p>
            <p>Venta ingresada por: <?php echo $datosdeventa["NombreUsuario"] ?></p>
            <?php if($datosdeventa["RUT"]==""){
                echo '<a class="linkdedescarga" href="imprimir/imprimir.php?tipo=venta&id='.$_GET["id"].'" target="_blank">Descargar comprobante</a>';
            }else{
                echo '<a class="linkdedescarga" href="imprimir/imprimir.php?tipo=factura&id='.$_GET["id"].'" target="_blank">Descargar Factura</a>';
            }  ?>
            
        </div>
    </div>
    <?php include_once("barralateral.html");
    ?>
</body>
<script type="module">

</script>

</html>
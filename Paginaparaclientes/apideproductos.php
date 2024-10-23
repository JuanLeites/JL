<?php
try {
    $basededatos = mysqli_connect("localhost", "clientes", "clientes2024") or die("error al conectar con base de datos"); //accedemos a la BD en la variable basededatos
    mysqli_select_db($basededatos, "mana") or die("error al seleccionar la base de datos");
} catch (throwable $error) {
    echo 'error: ' . $error->getMessage();
}
$productosconsulta = mysqli_query($basededatos, 'SELECT `ID_Producto`, `Nombre`, `Precio_Compra`,`Precio_Venta`, `Código_de_Barras`, p.Descripción, `Marca`, `Cantidad`, `Cantidad_minima_aviso`, `imagen`, `Tipo`, `Unidad`, `Título` FROM Producto p, IVA i, Medida m, Categoría c WHERE i.ID_IVA = p.ID_IVA and m.ID_UNIDAD = p.ID_UNIDAD and c.ID_CATEGORIA=p.ID_CATEGORIA and Activo=TRUE and Cantidad>=Cantidad_minima_aviso;');

$producto = array();
foreach ($productosconsulta as $cadaproducto) {
    $producto[] = $cadaproducto;
}
json_encode($producto);
echo json_encode($producto);

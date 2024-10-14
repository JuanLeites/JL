<?php
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");
if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") { // si el parametro filtro está seteado y si es distinto a "undefined"(valor que se pasa al no haber nada en el input)
    $_GET["filtro"] = str_replace('"', '´', $_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $productosconsulta = mysqli_query($basededatos, 'SELECT `ID_Producto`, `Nombre`, `Precio_Compra`,`Precio_Venta`, `Código_de_Barras`, p.Descripción, `Marca`, `Cantidad`, `Cantidad_minima_aviso`, `imagen`, `Tipo`, `Unidad`,`Símbolo`, `Título` FROM producto p,iva i,medida m,categoría c WHERE i.ID_IVA = p.ID_IVA and m.ID_UNIDAD = p.ID_UNIDAD and c.ID_CATEGORIA=p.ID_CATEGORIA and Activo=TRUE and (ID_PRODUCTO LIKE "%' . $_GET["filtro"] . '%" or Nombre LIKE "%' . $_GET["filtro"] . '%" or Precio_Compra LIKE "%' . $_GET["filtro"] . '%" or Precio_Venta LIKE "%' . $_GET["filtro"] . '%" or Código_de_barras LIKE "%' . $_GET["filtro"] . '%" or p.Descripción LIKE "%' . $_GET["filtro"] . '%" or Marca LIKE "%' . $_GET["filtro"] . '%" or Cantidad LIKE "%' . $_GET["filtro"] . '%" or i.Tipo LIKE "%' . $_GET["filtro"] . '%" or m.Unidad LIKE "%' . $_GET["filtro"] . '%" or c.Título LIKE "%' . $_GET["filtro"] . '%")');
} else { //sino consulta normal
    $productosconsulta = mysqli_query($basededatos, 'SELECT `ID_Producto`, `Nombre`, `Precio_Compra`,`Precio_Venta`, `Código_de_Barras`, p.Descripción, `Marca`, `Cantidad`, `Cantidad_minima_aviso`, `imagen`, `Tipo`, `Unidad`,`Símbolo`, `Título` FROM producto p,iva i,medida m,categoría c WHERE i.ID_IVA = p.ID_IVA and m.ID_UNIDAD = p.ID_UNIDAD and c.ID_CATEGORIA=p.ID_CATEGORIA and Activo=TRUE;');
}
$producto = array();
foreach ($productosconsulta as $cadaproducto) {
    $producto[] = $cadaproducto;
}
json_encode($producto);
echo json_encode($producto);

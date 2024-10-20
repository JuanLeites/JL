<?php
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");
if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") { // si el parametro filtro está seteado y si es distinto a "undefined"(valor que se pasa al no haber nada en el input)
    $_GET["filtro"] = str_replace('"', '´', $_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT pg.Monto, pg.Fecha_Pago, p.Razón_Social, p.RUT, pg.ID_COMPRA,  u.Nombre "NombreUsuario", c.Vencimiento_Factura, c.Precio_Final "DeberíaPagar" FROM proveedor p JOIN pago pg ON pg.ID_PROVEEDOR = p.ID_PROVEEDOR JOIN usuario u ON u.Usuario = pg.Usuario LEFT JOIN compra c ON pg.ID_COMPRA = c.ID_COMPRA WHERE u.Usuario=pg.Usuario and pg.ID_PROVEEDOR = p.ID_PROVEEDOR and (pg.ID_COMPRA = c.ID_COMPRA OR pg.ID_COMPRA IS NULL) and (ID_PAGO LIKE "%' . $_GET["filtro"] . '%" or Monto LIKE "%' . $_GET["filtro"] . '%" or Fecha_PAGO LIKE "%' . $_GET["filtro"] . '%" or Razón_Social  LIKE "%' . $_GET["filtro"] . '%" or RUT  LIKE "%' . $_GET["filtro"] . '%" or pg.ID_COMPRA  LIKE "%' . $_GET["filtro"] . '%" )ORDER BY Fecha_Pago');
} else {
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT pg.Monto, pg.Fecha_Pago, p.Razón_Social, p.RUT, pg.ID_COMPRA,  u.Nombre "NombreUsuario", c.Vencimiento_Factura, c.Precio_Final "DeberíaPagar" FROM proveedor p JOIN pago pg ON pg.ID_PROVEEDOR = p.ID_PROVEEDOR JOIN usuario u ON u.Usuario = pg.Usuario LEFT JOIN compra c ON pg.ID_COMPRA = c.ID_COMPRA ORDER BY pg.Fecha_Pago  DESC');
}

$cobros = array();
foreach ($cobrosconsulta as $cadacobro) {
    $cobros[] = $cadacobro;
}
json_encode($cobros);
echo json_encode($cobros);

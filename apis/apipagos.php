<?php
include("../coneccionBD.php");
include("../chequeodelogin.php");
if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") { // si el parametro filtro está seteado y si es distinto a "undefined"(valor que se pasa al no haber nada en el input)
    $_GET["filtro"] = str_replace('"', '´', $_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT ID_PAGO,Monto,Fecha_Pago,Razón_Social,RUT,ID_COMPRA FROM proveedor p,pago pg WHERE pg.ID_PROVEEDOR = p.ID_PROVEEDOR and (ID_PAGO LIKE "%' . $_GET["filtro"] . '%" or Monto LIKE "%' . $_GET["filtro"] . '%" or Fecha_PAGO LIKE "%' . $_GET["filtro"] . '%" or Razón_Social  LIKE "%' . $_GET["filtro"] . '%" or RUT  LIKE "%' . $_GET["filtro"] . '%" or ID_COMPRA  LIKE "%' . $_GET["filtro"] . '%")');
} else {
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT ID_PAGO,Monto,Fecha_Pago,Razón_Social,RUT,ID_COMPRA FROM proveedor p,pago pg WHERE pg.ID_PROVEEDOR = p.ID_PROVEEDOR');
}

$cobros = array();
foreach ($cobrosconsulta as $cadacobro) {
    $cobros[] = $cadacobro;
}
json_encode($cobros);
echo json_encode($cobros);

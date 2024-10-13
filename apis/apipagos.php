<?php
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");
if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") { // si el parametro filtro está seteado y si es distinto a "undefined"(valor que se pasa al no haber nada en el input)
    $_GET["filtro"] = str_replace('"', '´', $_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT Monto,Fecha_Pago,p.Razón_Social,p.RUT,ID_COMPRA,u.Nombre"NombreUsuario" FROM proveedor p,pago pg,usuario u WHERE u.Usuario=pg.Usuario and pg.ID_PROVEEDOR = p.ID_PROVEEDOR and (ID_PAGO LIKE "%' . $_GET["filtro"] . '%" or Monto LIKE "%' . $_GET["filtro"] . '%" or Fecha_PAGO LIKE "%' . $_GET["filtro"] . '%" or Razón_Social  LIKE "%' . $_GET["filtro"] . '%" or RUT  LIKE "%' . $_GET["filtro"] . '%" or ID_COMPRA  LIKE "%' . $_GET["filtro"] . '%")');
} else {
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT Monto,Fecha_Pago,p.Razón_Social,p.RUT,ID_COMPRA,u.Nombre"NombreUsuario" FROM proveedor p,pago pg,usuario u WHERE u.Usuario=pg.Usuario and pg.ID_PROVEEDOR = p.ID_PROVEEDOR');
}

$cobros = array();
foreach ($cobrosconsulta as $cadacobro) {
    $cobros[] = $cadacobro;
}
json_encode($cobros);
echo json_encode($cobros);

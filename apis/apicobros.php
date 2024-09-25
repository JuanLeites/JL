<?php
include("../coneccionBD.php");
include("../chequeodelogin.php");
if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") { // si el parametro filtro está seteado y si es distinto a "undefined"(valor que se pasa al no haber nada en el input)
    $_GET["filtro"] = str_replace('"', '´', $_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT ID_COBRO,Monto,Fecha_Cobro,Nombre,Cédula,ID_VENTA FROM cobro co,cliente cl WHERE co.ID_CLIENTE = cl.ID_CLIENTE and (ID_COBRO LIKE "%' . $_GET["filtro"] . '%" or Monto LIKE "%' . $_GET["filtro"] . '%" or Fecha_Cobro LIKE "%' . $_GET["filtro"] . '%" or Nombre  LIKE "%' . $_GET["filtro"] . '%" or Cédula  LIKE "%' . $_GET["filtro"] . '%" or ID_VENTA  LIKE "%' . $_GET["filtro"] . '%")');
} else {
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT ID_COBRO,Monto,Fecha_Cobro,Nombre,Cédula,ID_VENTA FROM cobro co,cliente cl WHERE co.ID_CLIENTE = cl.ID_CLIENTE');
}

$cobros = array();
foreach ($cobrosconsulta as $cadacobro) {
    $cobros[] = $cadacobro;
}
json_encode($cobros);
echo json_encode($cobros);

<?php
include("../coneccionBD.php");
include("../chequeodelogin.php");
if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") {// si el parametro filtro está seteado y si es distinto a "undefined"(valor que se pasa al no haber nada en el input)
    $_GET["filtro"]= str_replace('"','´',$_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $proveedoresconsulta = mysqli_query($basededatos, 'SELECT * FROM proveedor WHERE Activo=TRUE and (ID_PROVEEDOR LIKE "%' . $_GET["filtro"] . '%" or Contacto LIKE "%' . $_GET["filtro"] . '%" or Razón_Social LIKE "%' . $_GET["filtro"] . '%" or RUT LIKE "%' . $_GET["filtro"] . '%" )');
} else {
    $proveedoresconsulta = mysqli_query($basededatos, 'SELECT * FROM proveedor WHERE Activo=TRUE');
}
$proveedor = array();
foreach ($proveedoresconsulta as $cadaproveedor) {
    $proveedor[] = $cadaproveedor;
}
json_encode($proveedor);
echo json_encode($proveedor);

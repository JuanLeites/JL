<?php
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");
if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") { // si el parametro filtro está seteado y si es distinto a "undefined"(valor que se pasa al no haber nada en el input)
    $_GET["filtro"] = str_replace('"', '´', $_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $clientesconsulta = mysqli_query($basededatos, 'SELECT * FROM Cliente WHERE Activo=TRUE and (ID_CLIENTE LIKE "%' . $_GET["filtro"] . '%" or ID_CLIENTE LIKE "%' . $_GET["filtro"] . '%" or Cédula LIKE "%' . $_GET["filtro"] . '%" or Nombre  LIKE "%' . $_GET["filtro"] . '%" or Deuda  LIKE "%' . $_GET["filtro"] . '%" or Fecha_de_Nacimiento  LIKE "%' . $_GET["filtro"] . '%" or Contacto  LIKE "%' . $_GET["filtro"] . '%" or RUT  LIKE "%' . $_GET["filtro"] . '%") ORDER BY Nombre');
} else {
    $clientesconsulta = mysqli_query($basededatos, 'SELECT * FROM Cliente WHERE Activo=TRUE ORDER BY Nombre');
}

$clientes = array();
foreach ($clientesconsulta as $cadacliente) {
    $clientes[] = $cadacliente;
}
json_encode($clientes);
echo json_encode($clientes);

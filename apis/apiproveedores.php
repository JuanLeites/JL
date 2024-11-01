<?php
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");

if(!isset($_GET["limite"])){
    $limite = 20;
}else{
    $limite = $_GET["limite"];
}

if(!isset($_GET["pagina"])){
    $pagina = 1;
}else{
    $pagina = isset($_GET["pagina"]);
}
$desdequeelemento = ($pagina-1)*$limite;


if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") {// si el parametro filtro está seteado y si es distinto a "undefined"(valor que se pasa al no haber nada en el input)
    $_GET["filtro"]= str_replace('"','´',$_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $proveedoresconsulta = mysqli_query($basededatos, 'SELECT * FROM Proveedor WHERE Activo=TRUE and (ID_PROVEEDOR LIKE "%' . $_GET["filtro"] . '%" or Contacto LIKE "%' . $_GET["filtro"] . '%" or Razón_Social LIKE "%' . $_GET["filtro"] . '%" or RUT LIKE "%' . $_GET["filtro"] . '%" ) ORDER BY Razón_Social LIMIT '.$limite.' OFFSET '.$desdequeelemento.' ;');
} else {
    $proveedoresconsulta = mysqli_query($basededatos, 'SELECT * FROM Proveedor WHERE Activo=TRUE ORDER BY Razón_Social LIMIT '.$limite.' OFFSET '.$desdequeelemento.' ;');
}
$proveedor = array();
foreach ($proveedoresconsulta as $cadaproveedor) {
    $proveedor[] = $cadaproveedor;
}
header('Content-Type: application/json', true, 200);
json_encode($proveedor);
echo json_encode($proveedor);

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


if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") { // si el parametro filtro está seteado y si es distinto a "undefined"(valor que se pasa al no haber nada en el input)
    $_GET["filtro"] = str_replace('"', '´', $_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT Monto,Fecha_Cobro,cl.Nombre,cl.Cédula,ID_VENTA,u.Nombre"NombreUsuario" FROM Cobro co, Cliente cl, Usuario u WHERE u.Usuario = co.Usuario and co.ID_CLIENTE = cl.ID_CLIENTE and (ID_COBRO LIKE "%' . $_GET["filtro"] . '%" or Monto LIKE "%' . $_GET["filtro"] . '%" or Fecha_Cobro LIKE "%' . $_GET["filtro"] . '%" or cl.Nombre  LIKE "%' . $_GET["filtro"] . '%" or Cédula  LIKE "%' . $_GET["filtro"] . '%" or ID_VENTA  LIKE "%' . $_GET["filtro"] . '%")ORDER BY Fecha_Cobro DESC');
} else {
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT Monto,Fecha_Cobro,cl.Nombre,cl.Cédula,ID_VENTA,u.Nombre"NombreUsuario" FROM Cobro co, Cliente cl, Usuario u WHERE u.Usuario = co.Usuario and co.ID_CLIENTE = cl.ID_CLIENTE ORDER BY Fecha_Cobro  DESC');
}

$cobros = array();
foreach ($cobrosconsulta as $cadacobro) {
    $cobros[] = $cadacobro;
}
header('Content-Type: application/json', true, 200);
json_encode($cobros);
echo json_encode($cobros);

<?php
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");

if(!isset($_GET["limite"])){
    $limite = 40;
}else{
    if($_GET["limite"]=="sin"){//hacemos esto ya que al utilizar la api desde el menu principal necesitamos obtener TODOS los datos, sin limites
        $limite = "99999999999999";
    }else{
        $limite = $_GET["limite"];
    }
}

if(!isset($_GET["pagina"])){
    $pagina = 1;
}else{
    $pagina = $_GET["pagina"];
}
$desdequeelemento = ($pagina-1)*$limite;


if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") { // si el parametro filtro está seteado y si es distinto a "undefined"(valor que se pasa al no haber nada en el input)
    $_GET["filtro"] = str_replace('"', '´', $_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT pg.Monto, pg.Fecha_Pago, p.Razón_Social, p.RUT, pg.ID_COMPRA,  u.Nombre "NombreUsuario", c.Vencimiento_Factura, c.Precio_Final "DeberíaPagar" FROM Proveedor p JOIN Pago pg ON pg.ID_PROVEEDOR = p.ID_PROVEEDOR JOIN Usuario u ON u.Usuario = pg.Usuario LEFT JOIN Compra c ON pg.ID_COMPRA = c.ID_COMPRA WHERE u.Usuario=pg.Usuario and pg.ID_PROVEEDOR = p.ID_PROVEEDOR and (pg.ID_COMPRA = c.ID_COMPRA OR pg.ID_COMPRA IS NULL) and (ID_PAGO LIKE "%' . $_GET["filtro"] . '%" or u.Nombre LIKE "%'.$_GET["filtro"].'%" or Monto LIKE "%' . $_GET["filtro"] . '%" or Fecha_PAGO LIKE "%' . $_GET["filtro"] . '%" or Razón_Social  LIKE "%' . $_GET["filtro"] . '%" or RUT  LIKE "%' . $_GET["filtro"] . '%" or pg.ID_COMPRA  LIKE "%' . $_GET["filtro"] . '%") ORDER BY Fecha_Pago  DESC LIMIT '.$limite.' OFFSET '.$desdequeelemento.' ;');
} else {
    $cobrosconsulta = mysqli_query($basededatos, 'SELECT pg.Monto, pg.Fecha_Pago, p.Razón_Social, p.RUT, pg.ID_COMPRA,  u.Nombre "NombreUsuario", c.Vencimiento_Factura, c.Precio_Final "DeberíaPagar" FROM Proveedor p JOIN Pago pg ON pg.ID_PROVEEDOR = p.ID_PROVEEDOR JOIN Usuario u ON u.Usuario = pg.Usuario LEFT JOIN Compra c ON pg.ID_COMPRA = c.ID_COMPRA ORDER BY pg.Fecha_Pago  DESC LIMIT '.$limite.' OFFSET '.$desdequeelemento.' ;');
}

$cobros = array();
foreach ($cobrosconsulta as $cadacobro) {
    $cobros[] = $cadacobro;
}
header('Content-Type: application/json', true, 200);
json_encode($cobros);
echo json_encode($cobros);

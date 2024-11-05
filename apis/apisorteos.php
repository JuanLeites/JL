<?php 
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");

if(!isset($_GET["limite"])){
    $limite = 30;
}else{
    $limite = $_GET["limite"];
}

if(!isset($_GET["pagina"])){
    $pagina = 1;
}else{
    $pagina = $_GET["pagina"];
}
$desdequeelemento = ($pagina-1)*$limite;


if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") {
    $_GET["filtro"] = str_replace('"', '´', $_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $sorteosconsulta = mysqli_query($basededatos, 'SELECT * FROM Sorteo WHERE (ID_SORTEO LIKE "%' . $_GET["filtro"] . '%" or Premio LIKE "%' . $_GET["filtro"] . '%" or Cantidad LIKE "%' . $_GET["filtro"] . '%" or Fecha_Realización LIKE "%' . $_GET["filtro"] . '%" ) and ACTIVO=TRUE  ORDER BY Fecha_realización DESC LIMIT '.$limite.' OFFSET '.$desdequeelemento.' ;');
}else{ 
    $sorteosconsulta = mysqli_query($basededatos,'SELECT * FROM Sorteo WHERE ACTIVO = TRUE ORDER BY Fecha_realización DESC LIMIT '.$limite.' OFFSET '.$desdequeelemento.' ;'); 
}
    $sorteo=array();
    foreach($sorteosconsulta as $cadasorteo){
        $sorteo[]=$cadasorteo;
    }
    json_encode($sorteo);
    echo json_encode($sorteo);
    header('Content-Type: application/json', true, 200);
?>


<?php 
include("../coneccionBD.php");
include("../chequeodelogin.php");
    $productosconsulta = mysqli_query($basededatos,'SELECT * FROM producto');
    $producto=array();
    foreach($productosconsulta as $cadaproducto){
        $producto[]=$cadaproducto;
    }
    json_encode($producto);
    echo json_encode($producto);

?>
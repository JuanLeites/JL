<?php 
include("../coneccionBD.php");
include("../chequeodelogin.php");
    $sorteosconsulta = mysqli_query($basededatos,'SELECT * FROM sorteo');
    $sorteo=array();
    foreach($sorteosconsulta as $cadasorteo){
        $sorteo[]=$cadasorteo;
    }
    json_encode($sorteo);
    echo json_encode($sorteo);
?>
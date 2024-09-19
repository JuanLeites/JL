<?php 
include("../coneccionBD.php");
include("../chequeodelogin.php");
    $clientesconsulta = mysqli_query($basededatos,'SELECT * FROM cliente WHERE Activo=TRUE');
    $clientes=array();
    foreach($clientesconsulta as $cadacliente){
        $clientes[]=$cadacliente;
    }
    json_encode($clientes);
    echo json_encode($clientes);

?>
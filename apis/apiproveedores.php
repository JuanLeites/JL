<?php 
include("../coneccionBD.php");
include("../chequeodelogin.php");
    $proveedoresconsulta = mysqli_query($basededatos,'SELECT * FROM proveedor');
    $proveedor=array();
    foreach($proveedoresconsulta as $cadaproveedor){
        $proveedor[]=$cadaproveedor;
    }
    json_encode($proveedor);
    echo json_encode($proveedor);
?>
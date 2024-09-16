<?php 
include("../coneccionBD.php");
include("../chequeodelogin.php");
    $productosconsulta = mysqli_query($basededatos,'SELECT `ID_Producto`, `Nombre`, `Precio_Neto`, `Código_de_Barras`, p.Descripción, `Marca`, `Cantidad`, `Cantidad_minima_aviso`, `imagen`, `Tipo`, `Unidad`, `Título` FROM producto p,iva i,medida m,categoría c WHERE i.ID_IVA = p.ID_IVA and m.ID_UNIDAD = p.ID_UNIDAD and c.ID_CATEGORIA=p.ID_CATEGORIA;');
    $producto=array();
    foreach($productosconsulta as $cadaproducto){
        $producto[]=$cadaproducto;
    }
    json_encode($producto);
    echo json_encode($producto);

?>
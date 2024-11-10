<?php
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");

if(!isset($_GET["limite"])){
    $limite = 20;
}else{
    if($_GET["limite"]=="sin"){
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


if(isset($_GET["productosdisponibles"])){
    if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined"){
        $filtro = str_replace('"', '´', $_GET["filtro"]);
        $productosconsulta = mysqli_query($basededatos, 'SELECT `ID_Producto`, `Nombre`, `Precio_Compra`,`Precio_Venta`, `Código_de_Barras`, p.Descripción, `Marca`, `Cantidad`, `Cantidad_minima_aviso`, `Imagen`, `Tipo`, `Unidad`,`Símbolo`, `Título` FROM Producto p, IVA i, Medida m, Categoría c WHERE i.ID_IVA = p.ID_IVA and m.ID_UNIDAD = p.ID_UNIDAD and c.ID_CATEGORIA=p.ID_CATEGORIA and Activo=TRUE and (ID_PRODUCTO LIKE "%$filtro%" or Nombre LIKE "%'.$filtro.'%" or Precio_Compra LIKE "%'.$filtro.'%" or c.Descripción LIKE "%'.$filtro.'%" or Precio_Venta LIKE "%'.$filtro.'%" or Código_de_barras LIKE "%'.$filtro.'%" or p.Descripción LIKE "%'.$filtro.'%" or Marca LIKE "%'.$filtro.'%" or Cantidad LIKE "%'.$filtro.'%" or i.Tipo LIKE "%'.$filtro.'%" or m.Unidad LIKE "%'.$filtro.'%" or c.Título LIKE "%'.$filtro.'%") and Cantidad > 0 ORDER BY Nombre LIMIT '.$limite.' OFFSET '.$desdequeelemento.' ;');
    } else { //sino consulta normal
        $productosconsulta = mysqli_query($basededatos, 'SELECT `ID_Producto`, `Nombre`, `Precio_Compra`,`Precio_Venta`, `Código_de_Barras`, p.Descripción, `Marca`, `Cantidad`, `Cantidad_minima_aviso`, `Imagen`, `Tipo`, `Unidad`,`Símbolo`, `Título` FROM Producto p, IVA i, Medida m, Categoría c WHERE i.ID_IVA = p.ID_IVA and m.ID_UNIDAD = p.ID_UNIDAD and c.ID_CATEGORIA=p.ID_CATEGORIA and Activo=TRUE and Cantidad > 0 ORDER BY Nombre LIMIT '.$limite.' OFFSET '.$desdequeelemento.' ;');
    }
}else{
    if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined"){
        $filtro = str_replace('"', '´', $_GET["filtro"]);
        $productosconsulta = mysqli_query($basededatos, 'SELECT `ID_Producto`, `Nombre`, `Precio_Compra`,`Precio_Venta`, `Código_de_Barras`, p.Descripción, `Marca`, `Cantidad`, `Cantidad_minima_aviso`, `Imagen`, `Tipo`, `Unidad`,`Símbolo`, `Título` FROM Producto p, IVA i, Medida m, Categoría c WHERE i.ID_IVA = p.ID_IVA and m.ID_UNIDAD = p.ID_UNIDAD and c.ID_CATEGORIA=p.ID_CATEGORIA and Activo=TRUE and (ID_PRODUCTO LIKE "%$filtro%" or Nombre LIKE "%'.$filtro.'%" or Precio_Compra LIKE "%'.$filtro.'%" or c.Descripción LIKE "%'.$filtro.'%" or Precio_Venta LIKE "%'.$filtro.'%" or Código_de_barras LIKE "%'.$filtro.'%" or p.Descripción LIKE "%'.$filtro.'%" or Marca LIKE "%'.$filtro.'%" or Cantidad LIKE "%'.$filtro.'%" or i.Tipo LIKE "%'.$filtro.'%" or m.Unidad LIKE "%'.$filtro.'%" or c.Título LIKE "%'.$filtro.'%") ORDER BY Nombre LIMIT '.$limite.' OFFSET '.$desdequeelemento.' ;');
    } else { //sino consulta normal
        $productosconsulta = mysqli_query($basededatos, 'SELECT `ID_Producto`, `Nombre`, `Precio_Compra`,`Precio_Venta`, `Código_de_Barras`, p.Descripción, `Marca`, `Cantidad`, `Cantidad_minima_aviso`, `Imagen`, `Tipo`, `Unidad`,`Símbolo`, `Título` FROM Producto p, IVA i, Medida m, Categoría c WHERE i.ID_IVA = p.ID_IVA and m.ID_UNIDAD = p.ID_UNIDAD and c.ID_CATEGORIA=p.ID_CATEGORIA and Activo=TRUE ORDER BY Nombre LIMIT '.$limite.' OFFSET '.$desdequeelemento.' ;');
    }
}


$producto = array();
foreach ($productosconsulta as $cadaproducto) {
    $producto[] = $cadaproducto;
}
header('Content-Type: application/json', true, 200);
json_encode($producto);
echo json_encode($producto);

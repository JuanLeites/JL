<?php
$nombrebd = "mana";
$usuariobd = "clientes";
$contraseñabd = "clientes2024";
try {
    $basededatos = mysqli_connect("localhost", $usuariobd, $contraseñabd) or die("error al conectar con base de datos"); //accedemos a la BD en la variable basededatos
    mysqli_select_db($basededatos, $nombrebd) or die("error al seleccionar la base de datos");
} catch (throwable $error) {
    echo 'error: ' . $error->getMessage();
}

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




if (isset($_GET["filtro"]) && $_GET["filtro"] != "undefined") {
    $_GET["filtro"] = str_replace('"', '´', $_GET["filtro"]); // reemplazamos la comilla doble por una comilla simple para evitar errores
    $productosconsulta = mysqli_query($basededatos, 'SELECT  `Nombre`, `Precio_Venta`, p.Descripción, p.Marca, p.Imagen, c.Título"Categoria", i.Valor FROM Producto p, IVA i, Medida m, Categoría c WHERE i.ID_IVA = p.ID_IVA and m.ID_UNIDAD = p.ID_UNIDAD and c.ID_CATEGORIA=p.ID_CATEGORIA and Activo=TRUE and Cantidad>0 and ( `Nombre` LIKE "%'.$_GET["filtro"].'%" or p.Descripción LIKE "%'.$_GET["filtro"].'%" or p.Marca LIKE "%'.$_GET["filtro"].'%") ORDER BY p.Nombre LIMIT '.$limite.' OFFSET '.$desdequeelemento.';');
} else {
    $productosconsulta = mysqli_query($basededatos, 'SELECT  `Nombre`, `Precio_Venta`, p.Descripción, p.Marca, p.Imagen, c.Título"Categoria", i.Valor FROM Producto p, IVA i, Medida m, Categoría c WHERE i.ID_IVA = p.ID_IVA and m.ID_UNIDAD = p.ID_UNIDAD and c.ID_CATEGORIA=p.ID_CATEGORIA and Activo=TRUE and Cantidad>0 ORDER BY p.Nombre LIMIT '.$limite.' OFFSET '.$desdequeelemento. ';');
}
$producto = array();
foreach ($productosconsulta as $cadaproducto) {
    $producto[] = $cadaproducto;
}
json_encode($producto);
echo json_encode($producto);

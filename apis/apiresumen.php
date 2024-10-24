<?php
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");
if (isset($_GET["fecha_inicio"]) && isset($_GET["fecha_final"]) && isset($_GET["tipo"])) {
    if ($_GET["fecha_inicio"] != "" && $_GET["fecha_final"] != "") {
        switch ($_GET["tipo"]) {
            case 'productosmasvendidos';
                $consulta = mysqli_query($basededatos, 'SELECT * FROM (SELECT SUM(Cantidad_de_Venta)"Cantidad",Nombre FROM Productos_Vendidos pv,Producto p, Venta v WHERE v.Fecha_Venta>="' . $_GET["fecha_inicio"] . '" and v.Fecha_Venta<="' . $_GET["fecha_final"] . '" and pv.ID_VENTA=v.ID_VENTA and pv.ID_PRODUCTO = p.ID_PRODUCTO GROUP BY p.ID_PRODUCTO ORDER BY SUM(Cantidad_de_Venta) DESC LIMIT 10) subconsulta ORDER BY Nombre;');
                if (mysqli_num_rows($consulta) > 0) {
                    foreach ($consulta as $cadaconsulta) { // desglosamos la consulta en objetos indicituales
                        $cantidades[] = $cadaconsulta["Cantidad"]; // y los agregamos a arraylists
                        $Nombre[] = $cadaconsulta["Nombre"];
                    }
                    $datos[] = $cantidades; //agregamos los dos array a un solo array de datos
                    $datos[] = $Nombre;
                    echo json_encode($datos); // y lo pasamos por json
                } else {
                    echo json_encode(array(array(0), array("Ningún Producto"))); // devolvemos un array con dos arrays vacios para que no de errores ya que de donde obtenemos cargra con dos arreglos
                }


                break;
            case 'clientesmasfrecuentes';
                $consulta = mysqli_query($basededatos, 'SELECT * FROM(SELECT COUNT(*)"Cantidad de veces",Nombre,Cédula FROM Cliente c, Venta v WHERE v.ID_CLIENTE = c.ID_CLIENTE and Fecha_Venta>="' . $_GET["fecha_inicio"] . '" and Fecha_Venta<="' . $_GET["fecha_final"] . '" GROUP by v.ID_CLIENTE ORDER BY COUNT(*) DESC LIMIT 10)subconsulta ORDER BY Nombre;');
                if (mysqli_num_rows($consulta) > 0) {
                    foreach ($consulta as $cadaconsulta) { // desglosamos la consulta en objetos indicituales
                        $cantidades[] = $cadaconsulta["Cantidad de veces"]; // y los agregamos a arraylists
                        $Nombresconcedulas[] = $cadaconsulta["Nombre"] . " " . $cadaconsulta["Cédula"];
                    }
                    $datos[] = $cantidades; //agregamos los dos array a un solo array de datos
                    $datos[] = $Nombresconcedulas;
                    echo json_encode($datos); // y lo pasamos por json
                } else {
                    echo json_encode(array(array(0), array("Ningún Cliente")));
                }
                break;
            case 'cantidaddeventas';
                $consulta = mysqli_query($basededatos, 'SELECT * FROM (SELECT Fecha_Venta, Count(*)"cantidad" FROM Venta WHERE Fecha_Venta>="' . $_GET["fecha_inicio"] . '" and Fecha_Venta<="' . $_GET["fecha_final"] . '" GROUP BY Fecha_Venta ORDER BY Count(*) DESC LIMIT 10) subconsulta ORDER BY Fecha_Venta');//se hace una consulta con una subconsulta, la consulta "padre" unicamente sirve para ordenar lo que obtenga la otra consulta
                if (mysqli_num_rows($consulta) > 0) {
                    foreach ($consulta as $cadaconsulta) { // desglosamos la consulta en objetos indicituales
                        $fechas[] = $cadaconsulta["Fecha_Venta"]; // y los agregamos a arraylists
                        $cantidad[] = $cadaconsulta["cantidad"];
                    }
                    $datos[] = $fechas; //agregamos los dos array a un solo array de datos
                    $datos[] = $cantidad;
                    echo json_encode($datos); // y lo pasamos por json
                } else {
                    echo json_encode(array(array(0),array(0)));
                }
                break;

            case 'categorias';
            $consulta = mysqli_query($basededatos, 'SELECT * FROM(SELECT SUM(Cantidad_de_Venta)"Cantidad de venta",Título FROM Productos_Vendidos pv, Producto p, Categoría c, Venta v WHERE v.Fecha_Venta>="'.$_GET["fecha_inicio"].'" and v.Fecha_Venta<="'.$_GET["fecha_final"].'" and pv.ID_VENTA=v.ID_VENTA and c.ID_CATEGORIA=p.ID_CATEGORIA and pv.ID_PRODUCTO = p.ID_PRODUCTO GROUP BY c.ID_CATEGORIA ORDER BY SUM(Cantidad_de_Venta) DESC LIMIT 10) subconsulta ORDER BY Título;');
            if (mysqli_num_rows($consulta) > 0) {
                foreach ($consulta as $cadaconsulta) { // desglosamos la consulta en objetos indicituales
                    $categorias[] = $cadaconsulta["Título"];
                    $cantidades[] = $cadaconsulta["Cantidad de venta"];
                }
                $datos[] = $cantidades; //agregamos los dos array a un solo array de datos
                $datos[] = $categorias;
                echo json_encode($datos); // y lo pasamos por json
            } else {
                echo json_encode(array(array(0), array("ninguna venta")));
            }

                break;
        }
    }
} else {
    echo json_encode("Datos Necesarios");
}

<?php
try {
    $basededatos = mysqli_connect("localhost", "funcionario", "funcionario2024") or die("error al conectar con base de datos"); //accedemos a la BD en la variable basededatos
    mysqli_select_db($basededatos, "mana") or die("error al seleccionar la base de datos");
    date_default_timezone_set('America/Montevideo'); //establecemos la zona horaria en este archivo ya que será incluido en casi todo el software.
} catch (throwable $error) {
    echo 'error: ' . $error->getMessage();
}
?>
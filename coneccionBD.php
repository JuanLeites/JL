<?php
$basededatos = mysqli_connect("localhost","funcionario","funcionario2024") or die ("error al conectar con base de datos");//accedemos a la BD en la variable basededatos
mysqli_select_db($basededatos, "mana")or die ("error al seleccionar la base de datos");
?>
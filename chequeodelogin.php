<?php
session_start();
if (!isset($_SESSION["usuario"]) && !isset($_SESSION["contraseña"])){ //si no estan seteadas las variablas de session "user" y "pass" nos mandara al index con una causa "noreg"
    header("Location:/LUPF/index.php?causa=nolog");
}
?>

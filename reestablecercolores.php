<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
mysqli_query($basededatos, 'UPDATE `Usuario` SET `Color_Fondo`="#001F47",`Color_Principal` = "#4DBF38", `Color_Secundario` = "#80D12A" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
header('Location:menuprincipal.php');

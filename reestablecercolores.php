<?php
include("chequeodelogin.php");
include("coneccionBD.php");
mysqli_query($basededatos, 'UPDATE `usuario` SET `Color_Fondo`="#001F47",`Color_Principal` = "#4DBF38", `Color_Secundario` = "#80D12A" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
header('Location:menuprincipal.php');

<?php 
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");

if(isset($_SESSION["usuario"])){
    $configuraciondecolores = mysqli_fetch_assoc(mysqli_query($basededatos,'SELECT Color_Principal,Color_Secundario,Color_Fondo FROM Usuario WHERE Usuario ="' . $_SESSION["usuario"] . '";'));
    
    $colorprincipal =$configuraciondecolores["Color_Principal"];
    $colorsecundario = $configuraciondecolores["Color_Secundario"];
    $colorfondo = $configuraciondecolores["Color_Fondo"];

}else{
    $colorprincipal="#4DBF38";
    $colorsecundario="#80D12A";
    $colorfondo="#001F47";
}
$colores = [
    "color_principal" => $colorprincipal,
    "color_secundario" => $colorsecundario,
    "color_fondo" => $colorfondo
];
json_encode($colores);
echo json_encode($colores);

?>
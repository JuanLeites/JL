<style>
    <?php
    if(!isset($basededatos)){
        include("coneccionBD.php");
    }
    if(isset($_SESSION["usuario"])){
        $colorprincipal = mysqli_fetch_assoc(mysqli_query($basededatos,'SELECT Color_Principal FROM usuario  WHERE Usuario ="' . $_SESSION["usuario"] . '";'));
        $colorsecundario = mysqli_fetch_assoc(mysqli_query($basededatos,'SELECT Color_Secundario FROM usuario  WHERE Usuario ="' . $_SESSION["usuario"] . '";'));
        $colorfondo = mysqli_fetch_assoc(mysqli_query($basededatos,'SELECT Color_Fondo FROM usuario  WHERE Usuario ="' . $_SESSION["usuario"] . '";'));
        
        $colorprincipal =$colorprincipal["Color_Principal"];
        $colorsecundario = $colorsecundario["Color_Secundario"];
        $colorfondo = $colorfondo["Color_Fondo"];

    }else{
        $colorprincipal="#4DBF38";
        $colorsecundario="#80D12A";
        $colorfondo="#001F47";
    }
 //las variables $colorfondo, $colorprincipal salen de este archivo
    ?>
    :root{
        --color-principal:<?php echo $colorprincipal ?>;
        --color-secundario:<?php echo $colorsecundario ?>;
        --color-fondo:<?php echo $colorfondo ?>;
    }
    
</style>
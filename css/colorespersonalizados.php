<style>
    <?php
    if(!isset($basededatos)){
        include_once("coneccionBD.php");
    }
    if(isset($_SESSION["usuario"])){
        $configuraciondecolores = mysqli_fetch_assoc(mysqli_query($basededatos,'SELECT Color_Principal,Color_Secundario,Color_Fondo FROM usuario  WHERE Usuario ="' . $_SESSION["usuario"] . '";'));
        
        $colorprincipal =$configuraciondecolores["Color_Principal"];
        $colorsecundario = $configuraciondecolores["Color_Secundario"];
        $colorfondo = $configuraciondecolores["Color_Fondo"];

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
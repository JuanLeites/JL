<style>
    <?php
    $colorprincipal = mysqli_query($basededatos,'SELECT colorprincipal FROM config');
    $colorsecundario = mysqli_query($basededatos,'SELECT colorsecundario FROM config');
    $colorfondo = mysqli_query($basededatos,'SELECT colordefondo FROM config');
    
    ?>
    :root{
        --color-principal:<?php echo $colorprincipal ?>;
        --color-secundario:<?php echo $colorsecundario ?>;
        --color-fondo:<?php echo $colorfondo ?>;
    }
</style>
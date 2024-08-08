<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cobros</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    
    <?php
    session_start();
    include("barralateral.html")
     ?>
    <div class="seleccioncobro">
        <h1>seleccione tipo de cobro</h1>
        <button id="deuda">
            <h2> deuda de cliente</h2>
        </button>
        <div id="linksdeuda" style="display: none;">
            <a href="deudadecliente.php">
                <h2>cobrar deuda</h2>
            </a>
          
              <a href="consultadeuda.php">
                
                  <h2>consultar deuda</h2>
               
            </a>
         
        </div>
        <script>
        //Script para mostrar/ocultar los enlaces
        document.getElementById('deuda').addEventListener('click', function() {
            var cobro = document.getElementById('linksdeuda');
            var venta = document.getElementById('linksventa');
            if (cobro.style.display === "none" || cobro.style.display === "") {
                cobro.style.display = "block";
                venta.style.display = "none";
            } else {
                cobro.style.display = "none";
                venta.style.display = "block";
            }
        });
    </script>
        <a href="ventacliente.php" id="linksventa" style="display: block;">
             <button>
                <h2>vender a cliente</h2>
            </button>
        </a>
    </div>
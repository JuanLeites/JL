<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Productos</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="buscador">
        <input type="text" placeholder="Buscar Productos">
    </div>
    <div class="contenedordemenu">
        <table>
            <tr>
                <th>ID</th>
                <th>nombre</th>
                <th>Precio Neto</th>
                <th>codigo de barras</th>
                <th>descripcion</th>
                <th>marca</th>
                <th>cantidad</th>
                <th>cantidad de aviso</th>
                <th>imagen</th>
                <th>iva</th>
                <th>medida</th>
                <th>categoria</th>
                <th>accion</th>
            </tr>
            <?php
            include("coneccionBD.php");
            $consultaproductos = mysqli_query($basededatos, 'SELECT * FROM producto');

            foreach ($consultaproductos as $cadaproducto) {
                foreach ($cadaproducto as $indice => $dato) {
                    if ($indice == "ID_Producto") {
                        $id = $dato;
                    }
                    if ($indice == "Nombre") {
                        $nombre = $dato;
                    }
                    if ($indice == "Precio_Neto") {
                        $precio = $dato;
                    }
                    if ($indice == "Código_de_Barras") {
                        $codbarras = $dato;
                    }
                    if ($indice == "Descripción") {
                        $desc = $dato;
                    }
                    if ($indice == "Marca") {
                        $marca = $dato;
                    }
                    if ($indice == "Cantidad") {
                        $cantidad = $dato;
                    }
                    if ($indice == "Cantidad_minima_aviso") {
                        $cantminima = $dato;
                    }
                    if ($indice == "imagen") {
                        $img = $dato;
                    }
                    if ($indice == "ID_IVA") {
                        $iva = $dato;
                    }
                    if ($indice == "ID_UNIDAD") {
                        $unidad = $dato;
                    }
                    if ($indice == "ID_CATEGORIA") {
                        $cat = $dato;
                    }
                }
                echo "<tr><td>$id</td><td>$nombre</td><td>$precio</td><td>$codbarras</td><td>$desc</td><td>$marca</td><td>$cantidad</td><td>$cantminima</td><td><img src='IMAGENESSOFTWARE/$img' id='prod'></td><td>$iva</td><td>$unidad</td><td>$cat</td><td><a href='eliminar'><img src='imagenes/acciones/borrar.png' class='accion'></a><a href='modificar'><img src='imagenes/acciones/editar.png' class='accion'></a></td></tr>";
            }




            ?>
            <tr>
                <td>1</td>
                <td>jabon</td>
                <td>20</td>
                <td>110031211</td>
                <td>jabon con olor a tuco color verde</td>
                <td>Rexona</td>
                <td>4</td>
                <td>2</td>
                <td><img id="prod" src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAJQArAMBIgACEQEDEQH/xAAcAAEAAQUBAQAAAAAAAAAAAAAABwEEBQYIAwL/xABHEAABAwMBBAUHCAcGBwAAAAABAAIDBAURIQYSMUEHE1FhcRQiQlKBkbEyMzVicqHB8BUWIySCktElNpSywuEmNERTVWRz/8QAGQEBAAMBAQAAAAAAAAAAAAAAAAMEBQEC/8QAKBEBAAEDAwMCBwEAAAAAAAAAAAECAxEEEiExNHETQSIkUZGhweEF/9oADAMBAAIRAxEAPwCcUREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERARYe9bS2qyTRxXKp6l8jS5o3CcgeAWMZ0j7ImZ0Ul6ghkboRM1zPvIwvU01RGccPMV0zO2J5bWi147c7JjH/ABJateyrZ/VXtHtHYq7/AJK826o/+VUx3wK8vTKIvNk8UgzHIxw+q4FfeUFUREBFTKZQVRUTPcgqipleb6iFny5Y2+LgEHqix818tMGetuVI0jiDM3PxVi/bLZtgcX3mkbjiC/B93Ndw5mGeRag7pJ2V67qmXFz3cctgfj3kLY7Vcaa60MdbRvL4JM7pIxnBI4exd2zjdjhzdTnbnleIiLy9CoVVUKCJ+mHS70Jxxpna4+t2qC9o3k3WcA8Ha+5Tn0x/TFBnT93drj6ygraD6VqPt/gFoXe0oZ1mPm63zQVAEcnWkAN5819mqp5CB1RkJ4eZlZ22U1pp7DbJqqxTXKatfKHuincwsDXYGAB3rNGx1VorKqlpJrfFRw1RjpZq6XcdM5waSwe3AJ7vFZ7RaYy5eTgtjM8OOTSW49xXq3aCqb8m4XFvhVSD/Us3W7P3quomRSwUkUDS+SWdzz+7dWXb7HnHa84xx5LHS7E3OOjkl66idVxw9fLQtmBnZHjO8W+GuEHlHtTcIzmO6XMHvq5CP8yvIdt7g0jrK64Edral+fiqXHYG5UFLVSmroJpqWITzUsU2ZWRHHnluOGoVJtipIbTJdG3agqaSFodO6jcZTET8nIwNCdM8kGz2vbuepAZLWzy8M/tS1+Pfqtwt92iqaZz4rhI5rhk78rsx+OuQufAS1wIJBHMLL26+TwENnLpY+B11x39vgpabmIxMIa7WeaZxKVDU1lfLvCpqqena4h7xUuxJj1dfz3rIRTSjzI5Zw0c3TOOfv/OVg7Hf6e8MALo+u7NGh3DPt7lesmf1sbY2F9RvdVusx55B4bv4969xEYzCvvrztnqyrG1NS8xx9fKQNQHOK0q+/oqpeZKhkk850jjidx7NT+eK3zaCr/V2wSHrB5fVtMYe3iNNd3uaDx7SFc2GhGz2zFG2djmVlSeulcIes3M40PZgFo96z9frqdLRE7czVOIhYotTVPMoypPLqNjSJ2saR8wWl4b7cq5muL2wSPlbHHJuksc0kgjmSOz/AHUjvrJWxud5dMS/zmH9Hh+GtLg4adpI79FfUTaetpd2eATOZ5rnzU4Ad4exZ1f+9NmndNrjz/EsabfPVCdvrnSVroi8u3gXaldCdG/9zqHIwfP5Y9MrSNr7NaqW0y1VNbaOCcPYBJFA1rsE66gcFu/RuMbHUGmPnOWPTctrSa6nXaD1aYx8WPwqza9PWbZ+jaERFxbEREES9Mf0xQdvkzu31lBN/wDpao+3+AU7dMf0xQD/ANZ2mfrdigm//S1R9r8AtC72lDOsd3cbTs1eK23UVkmoqOqmZTmdtSGtw18b3Z0PaN069oWbpa7cgFtY28U0MNRI6CfyJkzpmvO8Wu3wcOBJ154Wu7MxbXVFnDLPQ9fQODoxndAOrs8XD1nLMNoukLrOsZZomyEAB46vOhJHF31nfzFZ7RVp7tHNBU22aiudQyvzNXVD4cSse7HVENGhwG4PAHVej7hSNrK3aSC33R93qKZ0TqUw/sWOLdwvDuJGGk4Rtk6R6eds7LQwulhjbgGPVrC7dB876x18F8Q7P9JFOWOZZR5jGtbvuiOgaG83dg18SgoL1ENqtoLwbfWvo621+RxNMJyZBHGMOHIfsn69yye1m0sdRs/eml12bFWsY2GjqKVrIqQhw80OB9nBYz9D9IcbHhtihaHb2SOr4OaQ70+wn3rVto75e5J6+33lkbJ5JWmoYGgEObjGoOEGtu4lAU4ntKki49G8Fws1LddkKiSqZNCHmnnc3eceB3XYAzkEFp58+SCPqaplppOsgcWu7ua6A6OLDUUdrZW3GJ0dXUjeELtepafgSNe7h2rTOivYKae4G73ukfHBSvxBBMzBkkHpEH0W/efBSJ0h3t2zuzMssEhZW1f7vTuB84OI1cPAZPjhMy5NMTy0/bu4x3isbBDSPjdSueyOeV+62QDBJaDzOPbosFAb5uiVtZUGGQajylwPHsJV5QXNt5onVdTJ+9wY60ZAxpo4dx5o+cNc4NJwNMfn2KzFumqI4yo5riqcsFdLrcupkiNdWRPZp8+8EEkADiqw3K4M3WMuNcGhowRUP1Omc6q5uVNHUhswwDG4Of8AWAz8M5WNkjeCHDGDrnH50XJs2560x9k0VThsBr6ualMU1XPKw4JD5XOGc95U0dG2P1NoNf8Audvru7VBFFLG6MtEgLiAQAp46NjnY2g1z85zz6blPdopo00RTGOf0gt86qfDZ0RFQaAiIgiXpjP9r0Gv/Tu5/WUE7QfS1R9r8Ap26Y9LvQHUDyd2unrKCdoAf0tUfa7O4LQu9rQzrHd3EhdHu3dksGz8FDcjUdYx7y4MjJGrsjVbizpZ2RdIzelq2gHU9Q4+1c94dyBXoyCZ2rYnH2LOaLpq8dKex1EIALmKlzhlvksZeGN7+w9yxL+mDZUkYnq/8OVz+2hqH+iB4le8dqkPy5GjuGq6Jxk6XNmHDHX1Z0wcxO7PyVCm1lfBddoq+vpd7qZ5S5m8MHGAveCzRZy7ff8AcFkIaCGDBaxjSOYGq4NcprfU1BG5GQ31naBS/wBDtY+mEtjq5Q8OzLTafJd6bR8fYVpW8APNGe8r7o6moo66nrYH7s9PI2Rju8H4IOjY4wwBzlB/SneTd9p308bs0tvHUs10L+Lz78D+FSddNqImbJPvdO752DMLTykdoAfB3HwKhGGjqax73QxSzPyN9zW51cdM+Jygt7dOaKsjmA3mgjeb6wz+T7Fn3ucdWP8AMc/eyOeeaxxs9fhrhRzODjgENznJIH3g+5UcKmkzTT70bmjG6eIBGVYsVc7UN2n3X1TVRUkRlqQ3dGg0848liamQS5EUrjAeDc4x3HCtLy50Ydq4jQHednRVyN4OBO4W5GBxPYp/fCOI4X9si3JiQW43eAOfguhejY52Nt+ufnOefTcoAt4zrzxgqf8Ao3/ubb854P449dy96jt48obXcz4bOiIs5oCIqIIo6Y2/2pb3dsDhw71DV0ZH5fMXStbl2ck9y6vrrVQXB7X1tHBO9ow10kYcQF4w7O2WF5fFaaJrzxd1Dc/BWa78VWYt46KtuxNN6q5niXLNFTQvB/ah29wDSCT4LMUuy9ZU6xWq5SDtFM8D4LpuGjpoHF0FPDGTzZGG/Be2FWWnOUOwl5cAWWOs/ibj4lX9P0ebQPYXC2uixwDnAE+7Kn5VSBz27YTaTgbRUewt1+9fP6h7R/8Ah6j3t/quhkQc/wBNsJew4+VWetLceaIizOe/JXq3YS6DO9Zrnjlh0eeA7/FT2iCCTsbejSMpTbLwYGEvERkj3A88wM6HVelNsrf6KJzKO3XePfwXNDot1zh2jmOH3qcsJhBCA2avbIpYxZ7sxr2kN3Hs80EOyMA4xl7v5lirvsxfqmsfPLaLm8O3cmRmXHAHHdXQiphdicTlyYy5gu9iqzDI6ptVdHw3t6mfgAcNcac/uWKhMckQEbmEtdu4BGV1oraago5yTPSU8hPEviafipvX5zh42cYcxUBxJu8Augejlu7sdbx2h5+Tj03K+l2WsMsnWPtFCX+sIGhZCio6ehp2U9JCyGFmd2NgwBzXq7qIrtRREIqLE03fUz7YXCIirLIiIgphVREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERB//9k=" alt="imagenprod1"></td>
                <td>Basico</td>
                <td>Undidad</td>
                <td>Limpieza</td>
                <td><a href="eliminar"><img src="imagenes/acciones/borrar.png" class="accion"></a><a href="modificar"><img src="imagenes/acciones/editar.png" class="accion"></a></td>
            </tr>

        </table>
        <a href="agregarproductos.php" class="agregardato">+</a>
    </div>

    <?php include("barralateral.html") ?>
</body>

</html>
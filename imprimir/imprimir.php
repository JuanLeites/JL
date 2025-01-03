<?php
require("../LIBRERIAS/fpdf/fpdf.php");
include("../coneccionBD.php");
$accion = "d";
$alturadeceldas = 7;
$cabecera = 60;
$pie = 40;
if (isset($_GET["tipo"]) && isset($_GET["id"])) {
    switch ($_GET['tipo']) {
        case "venta":
            $productosdelaventa = mysqli_query($basededatos, 'SELECT p.Nombre,pv.Cantidad_de_Venta,pv.Precio_de_Venta,pv.Iva_de_Venta FROM `Productos_Vendidos` pv,`Producto` p  WHERE p.ID_PRODUCTO = pv.ID_PRODUCTO and ID_VENTA="' . $_GET["id"] . '"');
            $datosdelaventa = mysqli_query($basededatos, 'SELECT c.Cédula,c.Nombre,v.Precio_Final,v.Sub_Total,v.Fecha_Venta,u.Nombre"Vendedor",co.Monto FROM `Venta`v,`Cliente`c,`Usuario`u,`Cobro`co WHERE u.Usuario=co.Usuario and co.ID_VENTA = v.ID_VENTA and v.ID_CLIENTE=c.ID_CLIENTE and  v.ID_VENTA="' . $_GET["id"] . '"');
            $datosdelaventa = mysqli_fetch_assoc($datosdelaventa);

            $titulo = "Orden de Venta";
            $altura = $pie + $cabecera + (mysqli_num_rows($productosdelaventa) * $alturadeceldas); //la canidada de productos por 10 que es el tamaño de la celda


            $pdf =  new FPDF();

            $pdf->SetAutoPageBreak(true, 5); // seteamos un pie inferior (distacia entre lo de arriba y lo de abajo.)
            $pdf->AddPage("P", array(80, $altura)); //para personalizar hoja, "altura de eje y","altura de eje x"
            $pdf->SetMargins(4, 0, 5);

            $pdf->SetFont('Arial', 'B', 6);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Image("../imagenes/logomana.jpg",60,0,20,0,"jpg","https://elmana.shop/Paginaparaclientes/");
            $pdf->SetY(2);
            $pdf->Write(3,mb_convert_encoding("Minimarket maná", "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(3,mb_convert_encoding("RUT: 160 297 850 016", "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(3,mb_convert_encoding("Dirección: Amorim 805 esq Charrúa.", "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(6,mb_convert_encoding("Fecha: ".$datosdelaventa["Fecha_Venta"], "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            
            $pdf->SetFont('Arial', 'B', 15); //I interlineado; B Negrita; U Interlineado;
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(((80 - $pdf->GetStringWidth($titulo)) / 2), 20); // seteamos y donde es necesario empezar para que el texto quede alineado
            $pdf->Write(5, mb_convert_encoding($titulo, "ISO-8859-1", "UTF-8"));
            $pdf->Ln(); //salto de linea


            $pdf->SetFont('Arial', 'I', 7);
            $pdf->Write(5, mb_convert_encoding("Cliente : " . $datosdelaventa["Nombre"], "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(5, mb_convert_encoding("Cédula : " . $datosdelaventa["Cédula"], "ISO-8859-1", "UTF-8"));

            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 7); //I de costado; B Negrita; U Subrayado;
            $pdf->SetTextColor(255, 255, 255); //texto en blanco
            $pdf->SetFillColor(100, 149, 237);

            $pdf->Cell(9, $alturadeceldas, mb_convert_encoding("Iva", "UTF-8"), true, false, "C", true);
            $pdf->Cell(36, $alturadeceldas, mb_convert_encoding("Producto", "ISO-8859-1", "UTF-8"), true, false, "C", true,); 
            $pdf->Cell(11, $alturadeceldas, mb_convert_encoding("Cántidad", "ISO-8859-1", "UTF-8"), true, false, "C", true);
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding("Precio c/u", "ISO-8859-1", "UTF-8"), true, true, "C", true);

            $pdf->SetTextColor(0, 0, 0); //texto en negro

            $contadordeiva10 = 0;
            $contadordeiva22 = 0;

            foreach ($productosdelaventa as $cadaproducto) {
                $subtotal = intval($cadaproducto["Precio_de_Venta"]) * intval($cadaproducto["Cantidad_de_Venta"]);

                if ($cadaproducto["Iva_de_Venta"] == 22) {
                    $contadordeiva22 += (($subtotal / 100) * 22);
                }
                if ($cadaproducto["Iva_de_Venta"] == 10) {
                    $contadordeiva10 += (($subtotal / 100) * 10);
                }

                //guardamos el texto con "..." al final y recortado si es que es mas largo que la celda
                $nombreProducto = $cadaproducto["Nombre"];

                while ($pdf->GetStringWidth($nombreProducto) > 35) { //mientras la meida del texto sea mayor a la de la celda
                    $nombreProducto = substr($nombreProducto, 0, -1); //le restaremos un caracter
                }

                if ($nombreProducto != $cadaproducto["Nombre"]) { //si el texto fue recortado
                    $nombreProducto = substr($nombreProducto, 0, -3) . '...'; //le quitamos los ultimos 3caracteres y le agregamos puntos suspensivos
                }

                $pdf->Cell(9, $alturadeceldas, mb_convert_encoding($cadaproducto["Iva_de_Venta"], "UTF-8"), true, false, "C", false); 
                $pdf->Cell(36, $alturadeceldas, mb_convert_encoding($nombreProducto, "ISO-8859-1", "UTF-8"), true, false, "C", false); 
                $pdf->Cell(11, $alturadeceldas, mb_convert_encoding($cadaproducto["Cantidad_de_Venta"], "UTF-8"), true, false, "C", false); 
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($cadaproducto["Precio_de_Venta"], 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false);

            }
            if ($contadordeiva10 != 0) {
                $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("IVA 10%", "UTF-8"), true, false, "R", false); 
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($contadordeiva10, 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false);
            }
            if ($contadordeiva22 != 0) {
                $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("IVA 22%", "UTF-8"), true, false, "R", false); 
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($contadordeiva22, 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); 
            }

            $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("Subtotal", "UTF-8"), true, false, "R", false); 
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($datosdelaventa["Sub_Total"], 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); 
            $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("Precio Final", "UTF-8"), true, false, "R", false); 
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($datosdelaventa["Precio_Final"], 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false);

            $pdf->Ln();
            $pdf->SetFont('Arial', '', 7);
            $texto = "Usuario que ingresó la venta : " . $datosdelaventa["Vendedor"]; //guardamos el texto que vamos a centrar en una variable
            $pdf->SetX((80 - $pdf->GetStringWidth($texto)) / 2); //seteamos el puntero en la pocición especifica donde deberia de comenzar el texto para que esté alineado. la funcion GetStringWidth obtiene lo largo que será el texto pasado por parametro
            $pdf->Write(5, mb_convert_encoding($texto, "ISO-8859-1", "UTF-8"));
            $pdf->Ln();

            $texto = "pagó: " . $datosdelaventa["Monto"]; //guardamos el texto que vamos a centrar en una variable
            $pdf->SetX((80 - $pdf->GetStringWidth($texto)) / 2); //seteamos el puntero en la pocición especifica donde deberia de comenzar el texto para que esté alineado. la funcion GetStringWidth obtiene lo largo que será el texto pasado por parametro
            $pdf->Write(5, mb_convert_encoding($texto, "ISO-8859-1", "UTF-8"));

            $pdf->output($accion, str_replace(" ", "", 'venta' . $datosdelaventa["Nombre"] . $datosdelaventa["Cédula"] . "-" . $datosdelaventa["Fecha_Venta"] . '.pdf'), TRUE); //la i lo muestra, la d li descarga
            break;

            //en caso de que sea una compra
        case 'compra':
            $productosdelacompra = mysqli_query($basededatos, 'SELECT p.Nombre,pc.Cantidad_de_Compra,pc.Precio_de_Compra,pc.Iva_de_Compra FROM `Productos_Comprados` pc,`Producto` p  WHERE p.ID_PRODUCTO = pc.ID_PRODUCTO and ID_COMPRA="' . $_GET["id"] . '"');
            $datosdelacompra = mysqli_query($basededatos, 'SELECT c.Sub_Total, c.Precio_Final, p.Razón_Social, p.RUT,c.Fecha_Compra,u.Nombre"Comprador",pa.Monto,c.Vencimiento_Factura   FROM `Compra`c,`Proveedor`p,`Usuario`u,`Pago`pa WHERE pa.ID_COMPRA=c.ID_COMPRA and pa.Usuario=u.Usuario and p.ID_PROVEEDOR=c.ID_PROVEEDOR and c.ID_Compra="' . $_GET["id"] . '"');
            $datosdelacompra = mysqli_fetch_assoc($datosdelacompra);


            $titulo = "Orden de Compra";
            $altura = $pie + $cabecera + (mysqli_num_rows($productosdelacompra) * $alturadeceldas); //la canidada de productos por 10 que es el tamaño de la celda


            $pdf =  new FPDF();

            $pdf->SetAutoPageBreak(true, 5); // seteamos un pie inferior (distacia entre lo de arriba y lo de abajo.)
            $pdf->AddPage("P", array(80, $altura)); //para personalizar hoja, "altura de eje y","altura de eje x"
            $pdf->SetMargins(4, 0, 5);

            $pdf->SetFont('Arial', 'B', 6);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Image("../imagenes/logomana.jpg",60,0,20,0,"jpg");
            $pdf->SetY(2);
            $pdf->Write(3,mb_convert_encoding("Minimarket maná", "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(3,mb_convert_encoding("RUT: 160 297 850 016", "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(3,mb_convert_encoding("Dirección: Amorim 805 esq Charrúa.", "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(6,mb_convert_encoding("Fecha: ".$datosdelacompra["Fecha_Compra"], "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            
            $pdf->SetFont('Arial', 'B', 15); //I interlineado; B Negrita; U Interlineado;
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(((80 - $pdf->GetStringWidth($titulo)) / 2), 20); // seteamos y donde es necesario empezar para que el texto quede alineado
            $pdf->Write(5, mb_convert_encoding($titulo, "ISO-8859-1", "UTF-8"));
            $pdf->Ln(); //salto de linea

            $pdf->SetFont('Arial', 'I', 7);
            $pdf->Write(5, mb_convert_encoding("Proveedor : " . $datosdelacompra["Razón_Social"], "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(5, mb_convert_encoding("RUT : " . $datosdelacompra["RUT"], "ISO-8859-1", "UTF-8"));

            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 7); //I de costado; B Negrita; U Subrayado;
            $pdf->SetTextColor(255, 255, 255); //texto en blanco
            $pdf->SetFillColor(100, 149, 237);

            $pdf->Cell(9, $alturadeceldas, mb_convert_encoding("Iva", "UTF-8"), true, false, "C", true);
            $pdf->Cell(36, $alturadeceldas, mb_convert_encoding("Producto", "ISO-8859-1", "UTF-8"), true, false, "C", true,);
            $pdf->Cell(11, $alturadeceldas, mb_convert_encoding("Cántidad", "ISO-8859-1", "UTF-8"), true, false, "C", true);
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding("Precio c/u", "ISO-8859-1", "UTF-8"), true, true, "C", true);

            $pdf->SetTextColor(0, 0, 0); //texto en negro

            $contadordeiva10 = 0;
            $contadordeiva22 = 0;
            foreach ($productosdelacompra as $cadaproducto) {
                $subtotal = intval($cadaproducto["Precio_de_Compra"]) * intval($cadaproducto["Cantidad_de_Compra"]);
                if ($cadaproducto["Iva_de_Compra"] == 22) {
                    $contadordeiva22 += (($subtotal / 100) * 22);
                }
                if ($cadaproducto["Iva_de_Compra"] == 10) {
                    $contadordeiva10 += (($subtotal / 100) * 10);
                }
                //guardamos el texto con "..." al final y recortado si es que es mas largo que la celda
                $nombreProducto = $cadaproducto["Nombre"];

                while ($pdf->GetStringWidth($nombreProducto) > 35) { //mientras la meida del texto sea mayor a la de la celda
                    $nombreProducto = substr($nombreProducto, 0, -1); //le restaremos un caracter
                }

                if ($nombreProducto != $cadaproducto["Nombre"]) { //si el texto fue recortado
                    $nombreProducto = substr($nombreProducto, 0, -3) . '...'; //le quitamos los ultimos 3caracteres y le agregamos puntos suspensivos
                }

                $pdf->Cell(9, $alturadeceldas, mb_convert_encoding($cadaproducto["Iva_de_Compra"], "UTF-8"), true, false, "C", false);
                $pdf->Cell(36, $alturadeceldas, mb_convert_encoding($nombreProducto, "ISO-8859-1", "UTF-8"), true, false, "C", false);
                $pdf->Cell(11, $alturadeceldas, mb_convert_encoding($cadaproducto["Cantidad_de_Compra"], "UTF-8"), true, false, "C", false); 
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($cadaproducto["Precio_de_Compra"], 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); 

            }
            if ($contadordeiva10 != 0) {
                $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("IVA 10%", "UTF-8"), true, false, "R", false);
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($contadordeiva10, 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); 
            }
            if ($contadordeiva22 != 0) {
                $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("IVA 22%", "UTF-8"), true, false, "R", false); 
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($contadordeiva22, 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); 
            }

            $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("Subtotal", "UTF-8"), true, false, "R", false);
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($datosdelacompra["Sub_Total"], 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); 
            $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("Precio Final", "UTF-8"), true, false, "R", false); 
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($datosdelacompra["Precio_Final"], 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); 


            $pdf->Ln();
            $pdf->SetFont('Arial', '', 7);
            $texto = "Usuario que ingresó la compra: " . $datosdelacompra["Comprador"]; //guardamos el texto que vamos a centrar en una variable
            $pdf->SetX((80 - $pdf->GetStringWidth($texto)) / 2); //seteamos el puntero en la pocición especifica donde deberia de comenzar el texto para que esté alineado. la funcion GetStringWidth obtiene lo largo que será el texto pasado por parametro
            $pdf->Write(5, mb_convert_encoding($texto, "ISO-8859-1", "UTF-8"));
            $pdf->Ln();

            if ($datosdelacompra["Vencimiento_Factura"] != "") { // si la compra fue a crédito, se obtendrá el valor
                $texto = "La Compra fue a crédito, Fecha Vencimiento: " . $datosdelacompra["Vencimiento_Factura"]; //guardamos el texto que vamos a centrar en una variable
                $pdf->SetX((80 - $pdf->GetStringWidth($texto)) / 2); //seteamos el puntero en la pocición especifica donde deberia de comenzar el texto para que esté alineado. la funcion GetStringWidth obtiene lo largo que será el texto pasado por parametro
                $pdf->Write(5, mb_convert_encoding($texto, "ISO-8859-1", "UTF-8"));
                $pdf->Ln();
            }
            $texto = "Se le pagó : " . $datosdelacompra["Monto"]; //guardamos el texto que vamos a centrar en una variable
            $pdf->SetX((80 - $pdf->GetStringWidth($texto)) / 2); //seteamos el puntero en la pocición especifica donde deberia de comenzar el texto para que esté alineado. la funcion GetStringWidth obtiene lo largo que será el texto pasado por parametro
            $pdf->Write(5, mb_convert_encoding($texto, "ISO-8859-1", "UTF-8"));

            $pdf->output($accion, str_replace(" ", "", 'compra' . $datosdelacompra["Razón_Social"] . $datosdelacompra["RUT"] . "-" . $datosdelacompra["Fecha_Compra"] . '.pdf'), TRUE); //la i lo muestra, la d li descarga
            break;

        case "factura":
            $productosdelaventa = mysqli_query($basededatos, 'SELECT p.Nombre,pv.Cantidad_de_Venta,pv.Precio_de_Venta,pv.Iva_de_Venta FROM `Productos_Vendidos` pv,`Producto` p  WHERE p.ID_PRODUCTO = pv.ID_PRODUCTO and ID_VENTA="' . $_GET["id"] . '"');
            $datosdelaventa = mysqli_query($basededatos, 'SELECT c.Cédula,c.RUT,c.Nombre,v.Precio_Final,v.Sub_Total,v.Fecha_Venta,u.Nombre"Vendedor",co.Monto FROM `Venta`v,`Cliente`c,`Usuario`u,`Cobro`co WHERE u.Usuario=co.Usuario and co.ID_VENTA = v.ID_VENTA and v.ID_CLIENTE=c.ID_CLIENTE and  v.ID_VENTA="' . $_GET["id"] . '"');
            $datosdelaventa = mysqli_fetch_assoc($datosdelaventa);


            $titulo = "Orden de Venta";
            $altura = $pie + $cabecera + (mysqli_num_rows($productosdelaventa) * $alturadeceldas); //la canidada de productos por la altura de la celda


            $pdf =  new FPDF();

            $pdf->SetAutoPageBreak(true, 2); // seteamos un pie inferior (distacia entre lo de arriba y lo de abajo.)
            $pdf->AddPage("P", array(80, $altura)); //para personalizar hoja, "altura de eje y","altura de eje x"
            $pdf->SetMargins(4, 0, 5);

            $pdf->SetFont('Arial', 'B', 6);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Image("../imagenes/logomana.jpg",60,0,20,0,"jpg");
            $pdf->SetY(2);
            $pdf->Write(3,mb_convert_encoding("Minimarket maná", "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(3,mb_convert_encoding("RUT: 160 297 850 016", "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(3,mb_convert_encoding("Dirección: Amorim 805 esq Charrúa.", "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(6,mb_convert_encoding("Fecha: ".$datosdelaventa["Fecha_Venta"], "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            
            $pdf->SetFont('Arial', 'B', 15); //I interlineado; B Negrita; U Interlineado;
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(((80 - $pdf->GetStringWidth($titulo)) / 2), 20); // seteamos y donde es necesario empezar para que el texto quede alineado
            $pdf->Write(5, mb_convert_encoding($titulo, "ISO-8859-1", "UTF-8"));
            $pdf->Ln(); //salto de linea

            $pdf->SetFont('Arial', 'I', 7);
            $pdf->Write(5, mb_convert_encoding("Cliente : " . $datosdelaventa["Nombre"], "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(5, mb_convert_encoding("Cédula : " . $datosdelaventa["Cédula"], "ISO-8859-1", "UTF-8"));
            $pdf->Ln();
            $pdf->Write(5, mb_convert_encoding("RUT : " . $datosdelaventa["RUT"], "ISO-8859-1", "UTF-8"));

            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 7); //I de costado; B Negrita; U Subrayado;
            $pdf->SetTextColor(255, 255, 255); //texto en blanco
            $pdf->SetFillColor(100, 149, 237);

            $pdf->Cell(9, $alturadeceldas, mb_convert_encoding("Iva", "UTF-8"), true, false, "C", true);
            $pdf->Cell(36, $alturadeceldas, mb_convert_encoding("Producto", "ISO-8859-1", "UTF-8"), true, false, "C", true,); 
            $pdf->Cell(11, $alturadeceldas, mb_convert_encoding("Cántidad", "ISO-8859-1", "UTF-8"), true, false, "C", true);
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding("Precio c/u", "ISO-8859-1", "UTF-8"), true, true, "C", true);

            $pdf->SetTextColor(0, 0, 0); //texto en negro

            $contadordeiva10 = 0;
            $contadordeiva22 = 0;

            foreach ($productosdelaventa as $cadaproducto) {
                $subtotal = intval($cadaproducto["Precio_de_Venta"]) * intval($cadaproducto["Cantidad_de_Venta"]);

                if ($cadaproducto["Iva_de_Venta"] == 22) {
                    $contadordeiva22 += (($subtotal / 100) * 22);
                }
                if ($cadaproducto["Iva_de_Venta"] == 10) {
                    $contadordeiva10 += (($subtotal / 100) * 10);
                }

                //guardamos el texto con "..." al final y recortado si es que es mas largo que la celda
                $nombreProducto = $cadaproducto["Nombre"];

                while ($pdf->GetStringWidth($nombreProducto) > 35) { //mientras la meida del texto sea mayor a la de la celda
                    $nombreProducto = substr($nombreProducto, 0, -1); //le restaremos un caracter
                }

                if ($nombreProducto != $cadaproducto["Nombre"]) { //si el texto fue recortado
                    $nombreProducto = substr($nombreProducto, 0, -3) . '...'; //le quitamos los ultimos 3caracteres y le agregamos puntos suspensivos
                }

                $pdf->Cell(9, $alturadeceldas, mb_convert_encoding($cadaproducto["Iva_de_Venta"], "UTF-8"), true, false, "C", false); 
                $pdf->Cell(36, $alturadeceldas, mb_convert_encoding($nombreProducto, "ISO-8859-1", "UTF-8"), true, false, "C", false); 
                $pdf->Cell(11, $alturadeceldas, mb_convert_encoding($cadaproducto["Cantidad_de_Venta"], "UTF-8"), true, false, "C", false); 
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($cadaproducto["Precio_de_Venta"], 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false);

            }



            if ($contadordeiva10 != 0) {    
                $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("IVA 10%", "UTF-8"), true, false, "R", false); //56 es la suma de las primeras 3 filas de arriba
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($contadordeiva10, 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); //16 lo que resta para llegar a 74 que es lo que mide la tabla
            }
            if ($contadordeiva22 != 0) {
                $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("IVA 22%", "UTF-8"), true, false, "R", false);
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($contadordeiva22, 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); 
            }

            $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("Subtotal", "UTF-8"), true, false, "R", false);
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($datosdelaventa["Sub_Total"], 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); 
            $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("Precio Final", "UTF-8"), true, false, "R", false); 
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding(number_format($datosdelaventa["Precio_Final"], 2, '.', ''), "ISO-8859-1", "UTF-8"), true, true, "R", false); 

            $pdf->Ln();
            $pdf->SetFont('Arial', '', 7);
            $texto = "Usuario que ingresó la venta : " . $datosdelaventa["Vendedor"]; //guardamos el texto que vamos a centrar en una variable
            $pdf->SetX((80 - $pdf->GetStringWidth($texto)) / 2); //seteamos el puntero en la pocición especifica donde deberia de comenzar el texto para que esté alineado. la funcion GetStringWidth obtiene lo largo que será el texto pasado por parametro
            $pdf->Write(5, mb_convert_encoding($texto, "ISO-8859-1", "UTF-8"));
            $pdf->Ln();

            $texto = "pagó: " . $datosdelaventa["Monto"]; //guardamos el texto que vamos a centrar en una variable
            $pdf->SetX((80 - $pdf->GetStringWidth($texto)) / 2); //seteamos el puntero en la pocición especifica donde deberia de comenzar el texto para que esté alineado. la funcion GetStringWidth obtiene lo largo que será el texto pasado por parametro
            $pdf->Write(5, mb_convert_encoding($texto, "ISO-8859-1", "UTF-8"));

            $pdf->output($accion, str_replace(" ", "", 'venta' . $datosdelaventa["Nombre"] . $datosdelaventa["Cédula"] . "-" . $datosdelaventa["Fecha_Venta"] . '.pdf'), TRUE); //la i lo muestra, la d li descarga
            break;
    }
} else {
    echo "faltan datos...";
}

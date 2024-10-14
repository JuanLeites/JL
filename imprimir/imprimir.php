<?php
require("../LIBRERIAS/fpdf/fpdf.php");
include("../coneccionBD.php");
if (isset($_GET["tipo"]) && isset($_GET["id"])) {
    switch ($_GET['tipo']) {
        case "venta":
        $productosdelaventa = mysqli_query($basededatos, 'SELECT p.Nombre,pv.Cantidad_de_Venta,pv.Precio_de_Venta,pv.Iva_de_Venta FROM `productos_vendidos` pv,`Producto` p  WHERE p.ID_PRODUCTO = PV.ID_PRODUCTO and ID_VENTA="' . $_GET["id"] . '"');
        $datosdelaventa = mysqli_query($basededatos, 'SELECT Cédula,Nombre,Precio_Final,Sub_Total,Fecha_Venta FROM `venta`v,`Cliente`c WHERE v.ID_CLIENTE=c.ID_CLIENTE and  ID_VENTA="' . $_GET["id"] . '"');
        $datosdelaventa = mysqli_fetch_assoc($datosdelaventa);
        $alturadeceldas = 7;
        $cabecera = 40;
        $pie = 50;
        $altura = $pie + $cabecera + (mysqli_num_rows($productosdelaventa) * $alturadeceldas); //la canidada de productos por 10 que es el tamaño de la celda


        $pdf =  new FPDF();

        //$pdf->AddPage('portrait','A4');
        $pdf->AddPage("P", array(80, $altura)); //para personalizar hoja, "altura de eje y","altura de eje x"
        $pdf->SetMargins(4, 0, 5);
        $pdf->SetFont('Arial', 'B', 15); //I interlineado; B Negrita; U Interlineado;
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Write(10, mb_convert_encoding("Comprobante de Venta", "ISO-8859-1", "UTF-8"));
        $pdf->Ln(); //salto de linea
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 7); //I de costado; B Negrita; U Subrayado;
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(150, 150, 200);

        $pdf->Cell(36, $alturadeceldas, mb_convert_encoding("Producto", "ISO-8859-1", "UTF-8"), true, false, "C", true,); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
        $pdf->Cell(11, $alturadeceldas, mb_convert_encoding("Cántidad", "ISO-8859-1", "UTF-8"), true, false, "C", true);
        $pdf->Cell(9, $alturadeceldas, mb_convert_encoding("Iva", "UTF-8"), true, false, "C", true); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
        $pdf->Cell(16, $alturadeceldas, mb_convert_encoding("Precio c/u", "ISO-8859-1", "UTF-8"), true, true, "C", true);


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
            $pdf->Cell(36, $alturadeceldas, mb_convert_encoding($cadaproducto["Nombre"], "ISO-8859-1", "UTF-8"), true, false, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            $pdf->Cell(11, $alturadeceldas, mb_convert_encoding($cadaproducto["Cantidad_de_Venta"], "UTF-8"), true, false, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            $pdf->Cell(9, $alturadeceldas, mb_convert_encoding($cadaproducto["Iva_de_Venta"], "UTF-8"), true, false, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding($cadaproducto["Precio_de_Venta"], "ISO-8859-1", "UTF-8"), true, true, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")

        }
        if ($contadordeiva10 != 0) {
            $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("IVA 10%", "UTF-8"), true, false, "R", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding($contadordeiva10, "ISO-8859-1", "UTF-8"), true, true, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
        }
        if ($contadordeiva22 != 0) {
            $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("IVA 22%", "UTF-8"), true, false, "R", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding($contadordeiva22, "ISO-8859-1", "UTF-8"), true, true, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
        }

        $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("Subtotal", "UTF-8"), true, false, "R", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
        $pdf->Cell(16, $alturadeceldas, mb_convert_encoding($datosdelaventa["Sub_Total"], "ISO-8859-1", "UTF-8"), true, true, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
        $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("Precio Final", "UTF-8"), true, false, "R", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
        $pdf->Cell(16, $alturadeceldas, mb_convert_encoding($datosdelaventa["Precio_Final"], "ISO-8859-1", "UTF-8"), true, true, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")


        $pdf->output('d', str_replace(" ","",'venta'.$datosdelaventa["Nombre"].$datosdelaventa["Cédula"]."-".$datosdelaventa["Fecha_Venta"].'.pdf'), TRUE); //la i lo muestra, la d li descarga
        break;

        case'compra':
            $productosdelacompra = mysqli_query($basededatos, 'SELECT p.Nombre,pc.Cantidad_de_Compra,pc.Precio_de_Compra,pc.Iva_de_Compra FROM `productos_comprados` pc,`Producto` p  WHERE p.ID_PRODUCTO = Pc.ID_PRODUCTO and ID_COMPRA="' . $_GET["id"] . '"');
            $datosdelacompra = mysqli_query($basededatos, 'SELECT c.Sub_Total, c.Precio_Final, p.Razón_Social, p.RUT,c.Fecha_Compra   FROM `compra`c,`proveedor`p WHERE p.ID_PROVEEDOR=c.ID_PROVEEDOR and ID_Compra="' . $_GET["id"] . '"');
            $datosdelacompra = mysqli_fetch_assoc($datosdelacompra);
            $alturadeceldas = 7;
            $cabecera = 40;
            $pie = 50;
            $altura = $pie + $cabecera + (mysqli_num_rows($productosdelacompra) * $alturadeceldas); //la canidada de productos por 10 que es el tamaño de la celda
    
    
            $pdf =  new FPDF();
    
            //$pdf->AddPage('portrait','A4');
            $pdf->AddPage("P", array(80, $altura)); //para personalizar hoja, "altura de eje y","altura de eje x"
            $pdf->SetMargins(4, 0, 5);
            $pdf->SetFont('Arial', 'B', 14); //I interlineado; B Negrita; U Interlineado;
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Write(10, mb_convert_encoding("Comprobante de Compra", "ISO-8859-1", "UTF-8"));
            $pdf->Ln(); //salto de linea
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 7); //I de costado; B Negrita; U Subrayado;
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFillColor(150, 150, 200);
    
            $pdf->Cell(36, $alturadeceldas, mb_convert_encoding("Producto", "ISO-8859-1", "UTF-8"), true, false, "C", true,); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            $pdf->Cell(11, $alturadeceldas, mb_convert_encoding("Cántidad", "ISO-8859-1", "UTF-8"), true, false, "C", true);
            $pdf->Cell(9, $alturadeceldas, mb_convert_encoding("Iva", "UTF-8"), true, false, "C", true); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding("Precio c/u", "ISO-8859-1", "UTF-8"), true, true, "C", true);
    
    
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
                $pdf->Cell(36, $alturadeceldas, mb_convert_encoding($cadaproducto["Nombre"], "ISO-8859-1", "UTF-8"), true, false, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
                $pdf->Cell(11, $alturadeceldas, mb_convert_encoding($cadaproducto["Cantidad_de_Compra"], "UTF-8"), true, false, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
                $pdf->Cell(9, $alturadeceldas, mb_convert_encoding($cadaproducto["Iva_de_Compra"], "UTF-8"), true, false, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding($cadaproducto["Precio_de_Compra"], "ISO-8859-1", "UTF-8"), true, true, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
    
            }
            if ($contadordeiva10 != 0) {
                $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("IVA 10%", "UTF-8"), true, false, "R", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding($contadordeiva10, "ISO-8859-1", "UTF-8"), true, true, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            }
            if ($contadordeiva22 != 0) {
                $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("IVA 22%", "UTF-8"), true, false, "R", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
                $pdf->Cell(16, $alturadeceldas, mb_convert_encoding($contadordeiva22, "ISO-8859-1", "UTF-8"), true, true, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            }
    
            $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("Subtotal", "UTF-8"), true, false, "R", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding($datosdelacompra["Sub_Total"], "ISO-8859-1", "UTF-8"), true, true, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            $pdf->Cell(56, $alturadeceldas, mb_convert_encoding("Precio Final", "UTF-8"), true, false, "R", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
            $pdf->Cell(16, $alturadeceldas, mb_convert_encoding($datosdelacompra["Precio_Final"], "ISO-8859-1", "UTF-8"), true, true, "C", false); //("ancho","alto","contendido",borde,"salto de linea","pocision del taxto","color de relleno","enlace que nos redireccionará al presionar el texto")
    
            $pdf->output('d', str_replace(" ","",'compra'.$datosdelacompra["Razón_Social"].$datosdelacompra["RUT"]."-".$datosdelacompra["Fecha_Compra"].'.pdf'), TRUE); //la i lo muestra, la d li descarga
            break;
            case'factura':
                echo "factura jaja";
                break;
    }
} else {
    echo "faltan datos...";
}

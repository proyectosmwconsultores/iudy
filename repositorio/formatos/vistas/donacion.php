<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();
$idToks = $_GET['idToks'];


$datos = $formx->obtener_donacion_id($idToks);
$user = $formx->usuario_id($datos[0]['IdAdmin']);

if(!isset($datos[0]['IdDonacion'])){
   header('Location: https://sciudy.com/');
}

$folio = str_pad($datos[0]['IdDonacion'], 5, "0", STR_PAD_LEFT);


?>


<!-- page define la hoja con los márgenes señalados -->
<page backtop="40mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	
	<img src="../../assets/images/campus/constancia.jpg" style="width: 100%;">	    

	
	</page_header>
	<page_footer>
		<table style="border-collapse: collapse; font-size: 11px; margin-left: 38px;">
			<tr>
				<td style="width: 533px;">
				    <p>
	        <div style='width: 350px;'>
	            <img src="../../assets/images/qr/<?php echo $datos[0]['Ruta']; ?>/<?php echo $datos[0]['Code']; ?>.png" style="width: 80px;"><br>	    
	            
	        Cadena Original de Sello Digital:<br>
	        ||<?php echo $datos[0]['Numero']; ?>|<?php echo $_GET['idToks']; ?>||
	        <br>
	        <p><b>C.c.p. Archivo</b></p>
	        <br><br>
	    </div>
	        
	    </p>
		</td>
				<td style="width: 160px; text-align: right;"><br><br><br><br><br><br><br></td>
			</tr>
		</table>
		<p style='text-align: right; font-size: 11px; margin-right: 35px;'>PÁGINA [[page_cu]] DE [[page_nb]]</p>
		<br><br><br><br><br>
	</page_footer><br>
	<p style='text-align: right;'>
        <table>
            <tr>
                <td style='text-align: center; width: 150px; border: 3px solid #254367; padding: 5px; border-radius: 5px; color: white; background: #1d3462;'><b> IUDY-BIB<?php echo $folio; ?></b></td>
                <td style='width: 510px;'>Villahermosa, Tabasco a <?php echo obtFechConst($datos[0]['FecCap']); ?>. </td>
            </tr>
        </table>
        </p><br>
        <p style="text-align: center; font-size: 23px;"><b>ENTREGA DE LIBROS</b></p>
        <p style="text-align: center; font-size: 15px; margin-top: -5px;"><b>DONACIÓN DE ESTUDIANTES A LA BIBLIOTECA</b></p>
        <br><br><br><br>
        <p style="text-align: left; font-size: 13px; margin-top: -10px;"><b>NOMBRE DEL ESTUDIANTE:</b> <?php echo $datos[0]['Nombre']; ?> <?php echo $datos[0]['APaterno']; ?> <?php echo $datos[0]['AMaterno']; ?> </p>
        <p style="text-align: left; font-size: 13px; margin-top: -10px;"><b>MATRÍCULA:</b> <?php echo $datos[0]['Usuario']; ?> </p>
        <p style="text-align: left; font-size: 15px; margin-top: 0px;"><b><?php echo $datos[0]['Educativa']; ?></b>  </p>
        
        <br>
        <p style="text-align: left; font-size: 13px; margin-top: -10px;">LIBROS A DONACIÓN: </p>
        <table style="border-collapse: collapse;">
            <tr style="color: white; background: #1d3462; text-align: center;">
                <td style="border: 1px solid back; width: 25px; padding: 5px;">No</td>
                <td style="border: 1px solid back; width: 375px;">DESCRIPCIÓN</td>
                <td style="border: 1px solid back; width: 150px;">FOLIO</td>
                <td style="border: 1px solid back; width: 100px;">MONTO</td>
            </tr>
            <tr style="text-align: center;">
                <td style="border: 1px solid back; padding: 5px;">1</td>
                <td style="border: 1px solid back; padding: 5px;">LIBERACIÓN DE LIBROS PARA LA TITULACIÓN</td>
                <td style="border: 1px solid back; padding: 5px;"><?php echo $datos[0]['Folio']; ?></td>
                <td style="border: 1px solid back; padding: 5px;">$ <?php echo number_format($datos[0]['Monto'], 2, '.', ','); ?> </td>
            </tr>
        </table>
        <p style="font-size: 10px;"><b>FOLIO:</b>||<?php echo $datos[0]['Numero']; ?>|<?php echo $_GET['idToks']; ?>||</p>
        
        <br><br><br><br><br><br><br><br><br>
        <p style="text-align: center;">
            <b>ATENTAMENTE.<br><br><br></b>
            <b><?php echo $user[0]['Nombre']; ?> <?php echo $user[0]['APaterno']; ?> <?php echo $user[0]['AMaterno']; ?></b>
        </p>
        
        
        
        
        
        
        
        
        
	
</page>
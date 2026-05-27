<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	$t=new Imprimir();
	$tienda=$t->get_acta($_GET["Id"]);
	$datos=$t->get_configuracion();
	$datosActa=$t->get_datosacta($_GET["Id"]);
	$datosEncabezado=$t->get_encabezado($_GET["Id"]);
	if(!$datosActa[0]["IdAsignacion"]){
		echo "<script type='text/javascript'>window.close();</script>";
	}
?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--
#encabezado {padding:10px 0; border-top: 1px solid; border-bottom: 1px solid; width:100%;}
#encabezado .fila #col_1 {width: 15%}
#encabezado .fila #col_2 {text-align:left; width: 70%}
#encabezado .fila #col_3 {width: 15%}
#encabezado .fila #col_4 {width: 15%}
#encabezado .fila #col_5 {width: 3%}
#encabezado .fila #col_6 {text-align:center; width: 100%}
#encabezado .fila #col_7 {width: 52%}
#encabezado .fila #col_8 {text-align:center; width: 50%}

#encabezado .fila td img {width:50%}
#encabezado .fila #col_2 #span1{font-size: 15px;}
#encabezado .fila #col_2 #span2{font-size: 12px; color: #4d9;}
#encabezado .fila #col_3 #span3{font-size: 12px; text-align: left;}
#encabezado .fila #col_2 #span4{font-size: 12px; color: black;}
#encabezado .fila #col_7 #span3{font-size: 12px; text-align: left;}


#footer {padding-top:5px 0; border-top: 2px solid #46d; width:100%;}
#footer .fila td {text-align:center; width:100%;}
#footer .fila td span {font-size: 10px; color: #000;}

#fecha {margin-top:70px; width:100%;}
#fecha tr td {text-align: right; width:100%;}

#central {margin-top:20px; text-align: justify;}
#central tr th {padding: 10px;}
#central tr td {padding: 10px; text-align: justify; width:100%;}

#datos {border:1px solid; margin-left:180px; width:50%;}
#datos tr {border:1px solid;}
#datos tr td{border:1px solid;}

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    padding: 8px;
}
#encabezado td, th {
    border: 1px solid #dddddd;
    padding: 1px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}
#texto1 { width: 100px;}
-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="40mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<div style= "width: 100%; position: absolute; ">
		<div style="float: left; width: 20%; margin-top:30px; margin-left: 50px;">

		</div>
		<div style="float: left; width: 100%; margin-top: -20px;">
		<table id="encabezado" style="border: none;">
			<tr class="fila">
				<td id="col_6" style="border: none">
					<span id="span1"><b><?php echo $datos[1]["Descripcion"] ?></b></span>
					<br>
					<span id="span1"><?php echo $datosActa[0]["Nombre"] ?></span>
					<br>
					<span id="span2">ACTA DE CALIFICACION FINAL</span>
				</td>
			</tr>
		</table>
		</div>
	</div>
	<table id="encabezado" style="border: none; font-weight:bold; ">
		<tr class="fila">
			<td id="col_5" style="border: none;"><span id="span3">&nbsp;</span></td>
			<td id="col_3" style="border: none;"><span id="span3">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $datosEncabezado[0]["Tipo"]; ?>:</span></td>
			<td colspan="3" id="col_2" style="border: none;"><span id="span4"><?php echo $datosEncabezado[0]["NomEducativa"]; ?></span></td>
		</tr>
		<tr class="fila">
			<td id="col_5" style="border: none;"><span id="span3">&nbsp;</span></td>
			<td id="col_3" style="border: none;"><span id="span3">&nbsp;&nbsp;&nbsp;&nbsp; Materia:</span></td>
			<td colspan="3" id="col_2" style="border: none;"><span id="span4"><?php echo $datosEncabezado[0]["NombreMod"]; ?></span></td>
		</tr>
		<tr class="fila">
			<td id="col_5" style="border: none;"><span id="span3">&nbsp;</span></td>
			<td id="col_3" style="border: none;"><span id="span3">&nbsp;&nbsp;&nbsp;&nbsp; Periodo:</span> </td>
			<td id="col_7" style="border: none;"><span id="span3"><?php echo $datosEncabezado[0]["mesIni"].'/'.$datosEncabezado[0]["mesFin"].' '.$datosEncabezado[0]["Anio"]; ?></span></td>
			<td id="col_3" style="border: none;"><span id="span3">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $datosEncabezado[0]["Ciclo"]; ?>:</span></td>
			<td id="col_3" style="border: none;"><span id="span3"><?php echo $datosEncabezado[0]["Grado"]; ?></span></td>
		</tr>

	</table>



	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<div style= "width: 100%; position: absolute; ">
		<div style="float: left; width: 100%;">
			<table id="encabezado" style="border: none;">
				<tr class="fila">
					<td id="col_6" style="border: none">
						<span id="span1"><b><u>MTRO. <?php echo $datosEncabezado[0]["Nombre"].' '.$datosEncabezado[0]["APaterno"].' '.$datosEncabezado[0]["AMaterno"] ?></u></b></span>
						<br>
						<span id="span1">Catedrático</span>
					</td>
				</tr>
			</table>
		</div><br><br>
		<div style="float: left; width: 100%;">
			<table id="encabezado" style="border: none;">
				<tr class="fila">
					<td id="col_8" style="border: none">
						<span id="span1"><b><u><?php //echo $datos[8]["Descripcion"] ?></u></b></span>
						<br>
						<span id="span1">Director Académico</span>
					</td>
					<td id="col_8" style="border: none">
						<span id="span1"><b><u><?php //echo $datos[9]["Descripcion"] ?></u></b></span>
						<br>
						<span id="span1">Servicios Escolares</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
		<table id="footer">
			<tr class="fila">
				<td style="border: none">
					<span><?php echo $datos[1]["Descripcion"] ?></span>
				</td>
			</tr>
		</table>
	</page_footer>

	<?php $x= 0; for ($i=0;$i< 2;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table style=" padding: 4px;">
		<tr style="background: #DDD3D3; padding: 4px;">
			<td style="width: 30px; font-size: 11px; ">No</td>
			<td style="width: 350px; font-size: 11px; ">NOMBRE</td>
			<td style="width: 80px; text-align: center; font-size: 11px; ">NÚMERO</td>
			<td style="width: 80px; text-align: center; font-size: 11px; ">LETRA</td>
		</tr>
		<?php   for ($i=0;$i< sizeof($tienda);$i++) {
		 ?>
		<tr>
	    <td style="width: 30px; font-size: 12px; "><?php echo $i + 1; ?></td>
	    <td style="width: 350px; font-size: 11px; "><?php echo $tienda[$i]["Nombre"].' '.$tienda[$i]["APaterno"].' '.$tienda[$i]["AMaterno"]; ?></td>
	    <td style="width: 80px; text-align: center; font-size: 12px; "><?php echo $tienda[$i]["Calificacion"]; ?></td>
			<td style="width: 80px; text-align: center; font-size: 12px; "><?php echo obtenerNumeroEnLetra(round($tienda[$i]["Calificacion"])); ?></td>
		</tr>
		<?php } ?>
	</table>
	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

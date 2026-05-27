<?php
session_start();
if($_SESSION['Permisos']){
	$tipo = $_GET["tok"];
	require_once'../classprint.php';
	include("hace.php");
	$t=new Imprimir();
	$usuariosX=$t->get_usuariosTx($tipo);
	$datos=$t->get_configuracion();


?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--
#encabezado {padding:10px 0; border-top: 1px solid; border-bottom: 1px solid; width:100%;}
#encabezado .fila #col_1 {width: 15%}
#encabezado .fila #col_2 {text-align:left; width: 50%}
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
<page backtop="45mm" backbottom="8mm" backleft="12mm" backright="13mm">
	<page_header> <!-- Define el header de la hoja -->
	<div style= "width: 150%; position: absolute; ">
		<div style="float: left; width: 20%; margin-top:30px; margin-left: 50px;">
			<img src="../../assets/images/campus/logo_inicio.png" style="width: 40%">
		</div>
		<div style="float: left; width: 100%; margin-top: -40px;">
		<table id="encabezado" style="border: none;">
			<tr class="fila">
				<td id="col_6" style="border: none">
					<span id="span1"><b>PLATAFORMA EDUCATIVA</b></span>
					<br>
					<span id="span2"><b>REPORTE DE USUARIOS ACTIVOS EN LA PLATAFORMA</b></span><br>
				</td>
			</tr>
		</table>
		</div>
	</div>
	<table id="encabezado" style="border: none; font-weight:bold; ">
		<tr class="fila">
			<td id="col_5" style="border: none;"><span id="span3">&nbsp;</span></td>
			<td id="col_3" style="border: none;"><span id="span3">&nbsp;&nbsp;&nbsp;&nbsp; Correspondiente a: </span></td>
			<td id="col_2" style="border: none;"><span id="span4"><?php echo obtenerFechaImpresion(date("Y-m-d")); ?></span></td>
		</tr>
		<tr class="fila">
			<td id="col_5" style="border: none;"><span id="span3">&nbsp;</span></td>
			<td id="col_3" style="border: none;"><span id="span3">&nbsp;&nbsp;&nbsp;&nbsp; Fecha de impresión: </span></td>
			<td id="col_2" style="border: none;"><span id="span4"><?php echo date("Y-m-d H:i:s"); ?></span></td>
		</tr>

	</table>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<div style= "width: 100%; position: absolute; ">
		<div style="float: left; width: 100%; text-align: right;">
			<table id="encabezado" style="border: none;">
				<tr class="fila">
					<td id="col_6" style="border: none; text-align: right; font-size:12px">
						<span id="span1">Hoja [[page_cu]] de [[page_nb]]
						 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					</td>
				</tr>
				<tr class="fila">
					<td id="col_6" style="border: none; text-align: right; font-size:12px">
						<span id="span1">FS: 062019/6bfe682cc10255e12ce0be7eae060ab0c4dbd50f417a6db371223a6a2a1db69ce1a396294e326449b676df457bb74207e4ac503e979267adcb411b1331687352
						 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->


	<table style=" padding: 4px;">
	<?php for ($x=0;$x< sizeof($usuariosX);$x++) { ?>
		<tr>
			<td colspan="1" style=" width: 630px; font-size: 14px; text-align: right;"><?php echo $usuariosX[$x]["Cargo"]; ?>:</td>
			<td colspan="1"style=" width: 230px;font-size: 14px; text-align: center; "><b><?php echo $usuariosX[$x]["Total"]; ?></b></td>
		</tr>
	<?php $total = $total + $usuariosX[$x]["Total"]; } ?>

		<tr>
			<td colspan="1" style=" width: 630px; font-size: 14px; text-align: right;"><b>Totales:</b></td>
			<td colspan="1"style=" width: 230px;font-size: 14px; text-align: center; "><b><?php echo $total; ?></b></td>
		</tr>
	</table>
	<br>
	<p style="font-size: 14px; text-align: center;">En el presente reporte del mes de <b><?php echo obtenerFechaImpresion(date("Y-m-d")); ?></b> de la <b>PLATAFORMA EDUCATIVA</b> <br>en donde se encuentran <b style='font-size:16px;'><?php echo $total; ?> usuarios activos</b>. </p>

	<p style="text-align: center;">
	Atentamente<br>
	___________________________________<br>
	RECTOR<br>
	

	</p>


	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

<?php

	require_once'../classprint.php';
	include("hace.php");
	include("numeros.php");
	include("importe.php");
	$t=new Imprimir();
	//cadena en el 48
	$id = substr($_GET["tokenId"], 46);
	$ciclo = substr($_GET["token"], 46);
	$IdAsi = $_GET["A"];
	$consulta=$t->get_datosConsulta($id);
	$datos=$t->get_datosUsuario($id);
	$calificacion=$t->get_calFinal($id,$ciclo);
	$cicloE=$t->get_CicloEsss($IdAsi);
	$config=$t->get_configuracion();
	$pie  = $config[12]["Descripcion"];
	$porciones = explode("CP", $pie);

	//$datosCiclo=$t->get_datosCiclo($consulta[0]["IdPago"]);

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
#encabezado .fila #col_6 {text-align:left; width: 100%;}
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
    padding: 4px;
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
<page backtop="20mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<div style= "width: 100%; position: absolute; ">

		<div style="float: left; width: 20%; margin-top:30px; margin-left: 50px;">
		</div>
		<div style="float: left; width: 100%; margin-top: -50px;">
		<table id="encabezado" style="border: none;">
			<tr class="fila">
				<td id="col_6" style="border: none">
					<span id="span1"><b style='color:#FE9900; '>
			  <img src="../../assets/images/campus/logo_inicio.png" style="width:100%";>
            </b></span>
				</td>
			</tr>
		</table>
		</div>
	</div>




	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<b style="font-size: 12px; margin-top: -145px; margin-left: 30px;"><?php echo $porciones[0]; ?></b><br>
	<b style="font-size: 12px; margin-left: 30px;"><?php echo 'CP'.$porciones[1]; ?></b>

	</page_footer>

	<div style="width: 100px; height: 120px; margin-left: -12px; text-align: justify; font-size: 15px; float: left; position: relative;">
		<img src="../../assets/perfil/<?php echo $datos[0]["Foto"]; ?>" style="width:80%";>
	</div>
	<div style="width: 615px; height: 120px; margin-left: 85px; margin-top: -120px; text-align: justify; font-size: 13px; float: left; position: relative;">
<br>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Al alumno (a) <b>C. <?php echo $datos[0]["APaterno"].' '.$datos[0]["AMaterno"].' '.$datos[0]["Nombre"]; ?></b> con número de control <b><?php echo $datos[0]["Matricula"]; ?>,</b>
	del <b><?php echo obtenerLetraN($datos[0]["SemCua"]); ?></b> Cuatrimestre de la <b><?php echo $datos[0]["NomEducativa"]; ?>. </b>

	</div>



	<div style="width: 727px; height: 110px; margin-left: -12px; text-align: justify; font-size: 15px;">
	<table>
		<tr>
			<td width="70px;" style="font-size: 10px;"><b>Clave</b></td>
			<td width="330px;" style="font-size: 10px;"><b>Asignatura</b></td>
			<td width="120px;" style="text-align: center; font-size: 10px;"><b>Calificación Final</b></td>
			<td width="120px;" style="text-align: center; font-size: 10px;"><b>Letra</b></td>
		</tr>
		<?php   for ($i=0;$i< 8;$i++) { $cal = $cal + $calificacion[$i]["Calificacion"];  ?>
			<tr>
				<td width="70px;" style="font-size: 10px;"><?php  if($calificacion[$i]["NoModulo"]){ echo "000".$calificacion[$i]["NoModulo"]; } else { ?>  <b style="color: white;">-</b> <?php } ?></td>
				<td width="330px;" style="font-size: 10px;"><?php echo $calificacion[$i]["NombreMod"]; ?></td>
				<td width="120px;" style="text-align: center; font-size: 10px;"><?php if($calificacion[$i]["Calificacion"]){ $mat = $mat + 1; echo $calificacion[$i]["Calificacion"]; } ?></td>
				<td width="120px;" style="text-align: center; font-size: 10px;"><?php if($calificacion[$i]["Calificacion"]) { echo obtenerNumeroEnLetra($calificacion[$i]["Calificacion"]); } ?></td>
			</tr>
		<?php
} ?>
<?php $promd = ($cal / $mat);
$xProm = number_format($promd, 1, '.', ',');

$porciones = explode(".", $xProm);
$num1 = $porciones[0]; // porción1
$num2 = $porciones[1]; // porción2
$promx = substr($num2, 0, 1);
 ?>
<tr>
	<td width="70px;" style="font-size: 10px;"></td>
	<td width="330px;" style="font-size: 10px;"><b>PROMEDIO:</b></td>
	<td width="120px;" style="text-align: center; font-size: 10px;"><?php echo number_format($promd, 1, '.', ','); ?></td>
	<td width="120px;" style="text-align: center; font-size: 10px;"><b><?php echo obtenerNumeroEnLetra($num1).' PUNTO '.obtenerNumeroEnLetra($promx); ?></b></td>
</tr>
	</table>

	</div>
<?php $fecha = date("Y-m-d"); ?>
	<div style="width: 727px; height: 150px; margin-left: -12px; margin-top: 80px; text-align: justify; font-size: 12px;"><br><br>
		La escala de calificaciones finales es de 5 a 10, la mínima para ser aprobada es de seis(6). <br><br>
		Observaciones: _____________________________________________________________________________________ <br><br><br>
		Se extiende la presente, en la ciudad de <?php echo $config[19]["Descripcion"]; ?> el dia: <?php echo substr($fecha,8,2); ?> de <?php echo obtenerMes(substr($fecha,5,2)); ?> del <?php echo substr($fecha,0,4); ?>.
	</div>




	<!-- Fin del cuerpo de la hoja -->




</page>

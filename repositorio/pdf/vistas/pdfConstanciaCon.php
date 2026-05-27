<?php

	require_once'../classprint.php';
	include("hace.php");
	include("numeros.php");
	include("importe.php");
	$t=new Imprimir();
	//cadena en el 48
	$id = substr($_GET["tokenId"], 46);
	$consulta=$t->get_datosConsulta($id);
	$datos=$t->get_datosUsuario($consulta[0]["IdUsua"]);
	$lstCalificaciones=$t->get_calificaciones($consulta[0]["IdUsua"],$datos[0]["SemCua"]);
	$config=$t->get_configuracion();
	$pie  = $config[12]["Descripcion"];
	$porciones = explode("CP", $pie);

?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--


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

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="70mm" backbottom="30mm" backleft="10mm" backright="10mm">
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

  <div style="width: 727px; height: 60px; margin-left: -12px; text-align: justify; font-size: 13.5px;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		EL (LA) SUSCRITO(A) DIRECTOR(A) DE LAS LICENCIATURAS EN LA MODALIDAD EN LINEA, INCORPORADO AL SISTEMA ESTATAL,
		 CLAVE <?php echo $config[20]["Descripcion"]; ?>.
	</div>


	<div style="width: 720px; height: 100px; margin-left: -12px; text-align: justify; font-size: 15px;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Por medio de la presente <b>HACE CONSTAR</b> que el (a) alumno (a) <b>C. <?php echo $datos[0]["APaterno"].' '.$datos[0]["AMaterno"].' '.$datos[0]["Nombre"]; ?></b> con número de control <b><?php echo $datos[0]["Matricula"]; ?>,</b>
		actualmente se encuentra inscrito en el <b><?php echo obtenerLetraN($datos[0]["SemCua"]); ?></b> Cuatrimestre de la <b><?php echo $datos[0]["NomEducativa"]; ?>,</b> con clave Incorporado al Sistema Estatal
		 <b><?php echo $config[20]["Descripcion"]; ?></b>, avalado en el acuerdo del día
		07/10/2010, obteniendo las calificaciones siguientes en los cuatrimestres anteriores:
	</div>

	<div style="width: 727px; height: auto; margin-left: -16px; text-align: justify; font-size: 15px;">
	<table style=" padding: 4px;">

		<?php $gradoIni = 0; $gradoFin = 0; $materias = 0; $inicio = 0; $mod = 0; $promedio = 0; $promGral = 0;
			for ($i=0;$i< sizeof($lstCalificaciones);$i++) {
				$promGral = $lstCalificaciones[$i]["Calificacion"] + $promGral;
				$cal = 0;
				$cal = $lstCalificaciones[$i]["Calificacion"];
				$gradoIni = $lstCalificaciones[$i]["Grado"];
		  	$materias =$materias + 1;
				$mod = $mod + 1;
        $promedio = $lstCalificaciones[$i]["Calificacion"] + $promedio;



			if($gradoIni != $gradoFin) {
				$division=$t->get_totalMaterias($consulta[0]["IdUsua"],$lstCalificaciones[$i]["Grado"]);
				$div = $division[0]["TotalMateria"];
				?>
				<tr style="padding: 2px;">
					<td colspan="5" style="width: 285px; font-size: 10px; text-align: center; "><b><?php echo obtenerLetraN($lstCalificaciones[$i]["Grado"]); ?> CUATRIMESTRE</b></td>
				</tr>
				<tr style="background: #DDD3D3; padding: 2px;">
					<td style="width: 285px; font-size: 10px; text-align: center;"><b>ASIGNATURA</b></td>
					<td style="width: 70px; font-size: 10px; text-align: center;"><b>CICLO</b></td>
					<td style="width: 70px; font-size: 10px; text-align: center;"><b>NÚMERO</b></td>
					<td style="width: 120px; font-size: 10px; text-align: center;"><b>LETRA</b></td>
					<td style="width: 85px; font-size: 10px; text-align: center;"><b>OBSERVACIONES</b></td>
				</tr>
			<?php } ?>
		<tr>
			<td style="width: 285px; font-size: 10px; "><?php echo $lstCalificaciones[$i]["NombreMod"]; ?></td>
			<td style="width: 70px; font-size: 10px; text-align: center;"><?php echo $lstCalificaciones[$i]["Ciclo"]; ?></td>
			<td style="width: 70px; font-size: 10px; text-align: center;"><?php echo $lstCalificaciones[$i]["Calificacion"]; ?></td>
			<td style="width: 120px; font-size: 10px; text-align: center;"><?php echo obtenerNumeroEnLetra($lstCalificaciones[$i]["Calificacion"]); ?></td>
			<td style="width: 85px; font-size: 10px; text-align: center;">ORDINARIO</td>

		</tr>
		<?php
		if($mod == $div) { $promd =  ($promedio / $mod);
			$xProm = number_format($promd, 2, '.', ',');

			$porciones = explode(".", $xProm);
			$num1 = $porciones[0]; // porción1
			$num2 = $porciones[1]; // porción2

			?>
			<tr style="background: #DDD3D3; padding: 2px;">
				<td style="width: 285px; font-size: 10px; text-align: center;"><b></b></td>
				<td style="width: 70px; font-size: 10px; text-align: center;"><b>PROM.</b></td>
				<td style="width: 70px; font-size: 10px; text-align: center;"><b><?php echo number_format($promd, 1, '.', ','); ?></b></td>
				<td style="width: 120px; font-size: 10px; text-align: center;"><b><?php echo obtenerNumeroEnLetra($num1).' PUNTO '.obtenerNumeroEnLetra(substr($num2, 1)); ?></b></td>
				<td style="width: 85px; font-size: 10px; text-align: center;"><b></b></td>
			</tr>
		<?php $mod = 0; $promedio = 0; }
		?>




		<?php

			$gradoFin = $lstCalificaciones[$i]["Grado"];  $inicio = $lstCalificaciones[$i]["Grado"];
		} ?>

	</table>

	</div>
<br><br>
<?php
$promdGralT =  ($promGral / $materias);
$proFRx = number_format($promdGralT, 1, '.', ',');
$porciones2 = explode(".", $proFRx);
$num11 = $porciones2[0]; // porción1
$num22 = $porciones2[1]; // porción2

?>
	<div style="width: 727px; height: 110px; margin-left: -12px; text-align: justify; font-size: 15px;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		A petición de la parte interesada y para los usos legales que mejor convengan, se
		extiende la presente Constancia de Estudios con Calificaciones que acredita que el alumno ha cursado <?php echo $materias; ?> asignaturas,
		a la fecha <?php echo substr($consulta[0]["Fecha"],8,2); ?> de <?php echo obtenerMes(substr($consulta[0]["Fecha"],5,2)); ?> del <?php echo substr($consulta[0]["Fecha"],0,4); ?>.
		<b>Promedio General <?php echo number_format($promdGralT, 1, '.', ','); ?>, Promedio con letras <?php echo obtenerNumeroEnLetra($num11).' PUNTO '.obtenerNumeroEnLetra($num22); ?>.</b>

	</div>

	<div style="width: 727px; height: 80px; margin-left: -12px; text-align: center; font-size: 14px; font-weight: bold;">
		ATENTAMENTE <br>
		"<?php echo $config[21]["Descripcion"]; ?>" <br><br><br>

		__________________________________ <br>
		<?php echo $config[17]["Descripcion"]; ?><br>
		<?php echo $config[17]["Nombre"]; ?>

	</div>
	<p style="font-size: 8px;">C.C.P. ARCHIVO</p>





	<!-- Fin del cuerpo de la hoja -->




</page>

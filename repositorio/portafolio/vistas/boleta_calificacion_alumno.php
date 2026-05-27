<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	include('../hace_fecha.php');
	require_once'../portafolio.php';

	$t=new Imprimir();
	$porciones = explode("_", $_GET["idToks"]);
	$IdUsua = $porciones[0]; // porción1
	$Grado=  $porciones[1]; // porción2
	$IdGrupo=  $porciones[2]; // porción2
	$IdAsignacion=  $porciones[3]; // porción2

	$lstDat=$t->get_enca_list($IdAsignacion);

	$lstMat=$t->get_lst_mat($IdGrupo, $Grado);
	$user=$t->get_usuario_id($IdUsua);

	$allMat=$t->get_all_mat($IdGrupo, $Grado);
	$_all = $allMat[0]['Total'];

?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
		font-size: 10px;
}

td, th {
    border: 0.5px solid black;
    padding: 4px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="90mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
		<tr>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/secretaria.png" style="width: 100%;" ></td>
			<td colspan="4" style="width: 290px; font-size: 12px;">Instituto Universitario de Yucatán<br><br><br><b style="font-size: 11px;">BOLETA DE CALIFICACIONES</b></td>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/iso.png" style="width: 120px;" ></td>
		</tr>
		<tr>
			<td colspan="2" style="width: 130px;">CÓDIGO:<br>SPC-ENPC-FO-PROCOES-05</td>
			<td colspan="2" style="width: 167px;">ÁREA:<br>Instituto Universitario de Yucatán</td>
			<td style="width: 56px;">REVISIÓN:<br>02</td>
			<td colspan="2" style="width: 141px;">FECHA DE IMPLEMENTACIÓN:<br>27/05/2020</td>
			<td style="width: 60px;">PÁGINA:<br>1 DE 1</td>
		</tr>
		<tr>
			<td colspan="8" style="border-left: none; border-right: none; border-bottom: none;"></td>
		</tr>
		<tr>
			<td style="width: 60px; border: none;"></td>
			<td style="width: 70px; border: none;"></td>
			<td style="width: 71px; border: none;"></td>
			<td style="width: 96px; border: none;"></td>
			<td style="width: 56px; border: none;"></td>
			<td style="width: 71px; border: none;"></td>
			<td style="width: 70px; border: none;"></td>
			<td style="width: 60px; border: none;"></td>
		</tr>
	</table><br><br>
	<table style='margin-left: 42px; font-size: 10px; margin-top: -10px;'>
		<tr>
			<td style=" border: none; width: 666px; text-align: left;">NOMBRE DEL ALUMNO: <b><?php echo $user[0]['APaterno'].' '.$user[0]['AMaterno'].' '.$user[0]['Nombre']; ?></b></td>
		</tr>
		<tr>
			<td style=" border: none; width: 666px; text-align: left;">MATRICULA: <b><?php echo $user[0]['Usuario']; ?></b></td>
		</tr>
		<tr>
			<td style=" border: none; width: 666px; text-align: left;">CARRERA: <b><?php echo $lstDat[0]['Educativa']; ?></b></td>
		</tr>
		<tr>
			<td style=" border: none; width: 666px; text-align: left;"><?php if($lstDat[0]['TipoCiclo'] == 'C'){ echo "CUATRIMESTRE"; } else { echo "SEMESTRE"; } ?>: <b><?php echo $lstDat[0]['Grado']; ?>°</b></td>
		</tr>
		<tr>
			<td style=" border: none; width: 666px; text-align: left;">CICLO ESCOLAR: <b><?php echo $lstDat[0]['Ciclo']; ?></b></td>
		</tr>
		<tr>
			<td style=" border: none; width: 666px; text-align: left;">FECHA: <b><?php echo obtenerFechaImpMAY($lstDat[0]['FFinal']); ?></b></td>
		</tr>
	</table><br>


	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table style="margin-left: 42px;">
		<tr>
			<td style="text-align: right; width: 200px; border: none;"></td>
			<td style="text-align: center; width: 233px; border: none; font-size: 12px;">
				<b>CAP. JUAN ANTONIO VARGAS REYES</b><br>
				DIRECTOR DE LA ESCUELA
			</td>
			<td style="text-align: right; width: 200px; border: none;"></td>
		</tr>
	</table><br><br>
	<p style="font-size: 10px; text-align: center;">Carretera Panamericana Tuxtla-Ocozocoautla, antiguo aeropuerto
	Llano San Juan, Ocozocoautla de Esponoza, Chiapas.</p>
	<p style="text-align: center; font-size: 9px;"><b>Nota:</b> en caso de que este documento presente de tachaduras, enmendaduras o correccciones perderá su validez.</p>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<table style="margin-left: 42px;">
		<tr>
			<td style="text-align: right; width: 200px; border: none;"></td>
			<td style="text-align: center; width: 233px; border: none;"></td>
			<td style="text-align: right; width: 200px; border: none;">SPC-ENPC-FO-PROCOES-05</td>
		</tr>
	</table>
	<br>
	</page_footer>
	<table style='margin-left: 4px; font-size: 10px;'>
		<tr style="background: #c1c1c1;">
			<td style="width: 40px;"><b>CLAVE</b></td>
			<td style="width: 300px;"><b>ASIGNATURA</b></td>
			<td style="width: 35px; text-align: center;"><b>1°<br>Parcial</b></td>
			<td style="width: 35px; text-align: center;"><b>2°<br>Parcial</b></td>
			<td style="width: 35px; text-align: center;"><b>3°<br>Parcial</b></td>
			<td style="width: 50px; text-align: center;"><b>Calificación final</b></td>
			<td style="width: 25px; text-align: center;"><b>Ext.</b></td>
			<td style="width: 25px; text-align: center;"><b>Rec.</b></td>
		</tr>
		<?php $c = 0; $sum = 0; for ($y=0;$y< sizeof($lstMat);$y++) {
			$cal=$t->get_cal_mat($IdUsua, $lstMat[$y]['IdModulo']);
			if(isset($cal[0]['Promedio'])){ if($cal[0]['E1']){ $prom1 = $cal[0]['E1']; }elseif($cal[0]['E2']){ $prom1 = $cal[0]['E2']; }else{ $prom1 = $cal[0]['Promedio']; } } else { echo $prom1 = 0; }
			?>
			<tr>
				<td style="width: 40px;"><?php echo $lstMat[$y]['CodeModulo']; ?></td>
				<td style="width: 300px;"><?php echo $lstMat[$y]['NombreMod']; ?></td>
				<?php if($lstMat[$y]['Tipo'] == '1'){ $c = ($c + 1); $sum = ($sum + $prom1); ?>
				<td style="width: 35px; text-align: center;"><?php if(isset($cal[0]['P1'])){ echo $cal[0]['P1']; } ?></td>
				<td style="width: 35px; text-align: center;"><?php if(isset($cal[0]['P2'])){ echo $cal[0]['P2']; } ?></td>
				<td style="width: 35px; text-align: center;"><?php if(isset($cal[0]['P3'])){ echo $cal[0]['P3']; } ?></td>
				<td style="width: 50px; text-align: center; <?php if((isset($cal[0]['Promedio']) && ($cal[0]['Promedio'] == '5'))){ echo "color: red; "; } ?>"><b><?php if(isset($cal[0]['Promedio'])){ echo $cal[0]['Promedio']; }  ?></b></td>
				<td style="width: 25px; text-align: center;"><?php if(isset($cal[0]['E1'])){ echo $cal[0]['E1']; } ?></td>
				<td style="width: 25px; text-align: center;"><?php if(isset($cal[0]['E2'])){ echo $cal[0]['E2']; } ?></td>
				<?php } else { ?>
				<td colspan="6" style="width: 155px; text-align: center;">
				<?php if(isset($cal[0]['Promedio'])){ if($cal[0]['Promedio'] == 'A'){ echo "Acreditada"; } else { echo "No acreditada"; } } ?>
				</td>
				<?php } ?>
			</tr>
		<?php }
		$prom = ($sum / $_all);
		?>
	</table><br>
	<table style='margin-left: 4px; font-size: 10px;'>
		<tr>
			<td style="width: 358px; border-top: none; border-left: none; border-bottom: none;"></td>
			<td style="width: 208px; text-align: right;">PROMEDIO GENERAL:</td>
			<td style="width: 68px; text-align: center;"><b>
			<?php
				echo round(($prom), 2)
			 ?></b></td>
		</tr>
	</table>
</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	include('../hace_fecha.php');
	require_once'../portafolio.php';

	$t=new Imprimir();
	$porciones = explode("_", $_GET["idToks"]);
	$IdCiclo = $porciones[0]; // porción1
	$IdGrupo=  $porciones[1]; // porción2
	$Grado=  $porciones[2]; // porción2
	$IdAsignacion=  $porciones[3]; // porción2
	// $IdUsua = substr($_GET["id"], 10, 10);
	// $IdCiclo = substr($_GET["idToks"], 10, 10);
	$lstDat=$t->get_enca_list($IdAsignacion);
	$lstUs=$t->get_lst_prom($IdAsignacion);


	$lstMat=$t->get_lst_mat($IdGrupo, $Grado);
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
<page backtop="69.1mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
		<tr>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/secretaria.png" style="width: 100%;" ></td>
			<td colspan="4" style="width: 290px; font-size: 12px;">Instituto Universitario de Yucatán<br><br><br><b style="font-size: 11px;">CONCENTRADO DE CALIFICACIONES</b></td>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/iso.png" style="width: 120px;" ></td>
		</tr>
		<tr>
			<td colspan="2" style="width: 130px;">CÓDIGO:<br>SPC-ENPC-FO-PROCOES-04</td>
			<td colspan="2" style="width: 167px;">ÁREA:<br>Instituto Universitario de Yucatán</td>
			<td style="width: 56px;">REVISIÓN:<br>02</td>
			<td colspan="2" style="width: 141px;">FECHA DE IMPLEMENTACIÓN:<br>20/02/2020</td>
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
	</table>
	<table style='margin-left: 42px; font-size: 10px; margin-top: -10px;'>
		<tr>
			<td style="width: 370px; text-align: left;">CARRERA: <b><?php echo $lstDat[0]['Educativa']; ?></b></td>
			<td style="width: 278px; text-align: left;">CLAVE DGP: </td>
		</tr>
		<tr>
			<td style="width: 370px; text-align: left;"><?php if($lstDat[0]['TipoCiclo'] == 'C'){ echo "CUATRIMESTRE"; } else { echo "SEMESTRE"; } ?>: <b><?php echo $lstDat[0]['Grado']; ?>°</b></td>
			<td style="width: 278px; text-align: left;">CICLO: <b><?php echo $lstDat[0]['Periodo']; ?></b></td>
		</tr>
		<tr>
			<td style="width: 370px; text-align: left;">GRUPO: <b><?php echo $lstDat[0]['Grupo']; ?></b></td>
			<td style="width: 278px; text-align: left;">PERIODO ESCOLAR: <b><?php echo $lstDat[0]['Ciclo']; ?></b></td>
		</tr>
		<tr>
			<td style="width: 370px; text-align: left;">CLAVE: <b><?php echo $lstDat[0]['CveGrupo']; ?></b></td>
			<td style="width: 278px; text-align: left;">PROMEDIO FINAL</td>
		</tr>
	</table>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table style="margin-left: 42px;">
		<tr>
			<td style="text-align: right; width: 200px; border: none;"></td>
			<td style="text-align: center; width: 233px; border-right: none; border-bottom: none;">FIRMA DEL DOCENTE</td>
			<td style="text-align: right; width: 200px; border: none;"></td>
		</tr>
		<tr>
			<td style="text-align: right; width: 200px; border: none;"></td>
			<td style="text-align: center; width: 233px; border: none;"></td>
			<td style="text-align: right; width: 200px; border: none;">SPC-ENPC-FO-PROCOES-04</td>
		</tr>
	</table>
	<br>
	</page_footer>
	<table style='margin-left: 4px; font-size: 10px;'>
		<tr>
			<td rowspan="2" style="width: 12px;"><b>NÚM</b></td>
			<td rowspan="2" style="width: 52px;"><b>LUMPS20012</b></td>
			<td rowspan="2" style="width: 272px;"><b>NOMBRE DEL ALUMNO</b></td>
			<td colspan="8" style="width: 150px; text-align: center; background: #dfd1d1; font-size: 9px;"><b>CLAVE DE ASIGNATURA</b></td>
			<td style="width: 16px; text-align: center; background: #dfd1d1; font-size: 9px;"><b>PROM</b></td>
		</tr>
		<tr>
			<td style="width: 15px; text-align: center;"><?php echo $lstMat[0]['Oferta']; ?> <?php echo $lstMat[0]['Code']; ?></td>
			<td style="width: 15px; text-align: center;"><?php echo $lstMat[1]['Oferta']; ?> <?php echo $lstMat[1]['Code']; ?></td>
			<td style="width: 15px; text-align: center;"><?php echo $lstMat[2]['Oferta']; ?> <?php echo $lstMat[2]['Code']; ?></td>
			<td style="width: 15px; text-align: center;"><?php echo $lstMat[3]['Oferta']; ?> <?php echo $lstMat[3]['Code']; ?></td>
			<td style="width: 15px; text-align: center;"><?php echo $lstMat[4]['Oferta']; ?> <?php echo $lstMat[4]['Code']; ?></td>
			<td style="width: 15px; text-align: center;"><?php echo $lstMat[5]['Oferta']; ?> <?php echo $lstMat[5]['Code']; ?></td>
			<td style="width: 15px; text-align: center;"><?php echo $lstMat[6]['Oferta']; ?> <?php echo $lstMat[6]['Code']; ?></td>
			<td style="width: 15px; text-align: center;"><?php echo $lstMat[7]['Oferta']; ?> <?php echo $lstMat[7]['Code']; ?></td>
			<td style="width: 16px; text-align: center;"></td>
		</tr>
		<?php $c = 0; for ($y=0;$y< sizeof($lstUs);$y++) {
			$cal1=$t->get_cal_mat($lstUs[$y]['IdUsua'], $lstMat[0]['IdModulo']);
			$cal2=$t->get_cal_mat($lstUs[$y]['IdUsua'], $lstMat[1]['IdModulo']);
			$cal3=$t->get_cal_mat($lstUs[$y]['IdUsua'], $lstMat[2]['IdModulo']);
			$cal4=$t->get_cal_mat($lstUs[$y]['IdUsua'], $lstMat[3]['IdModulo']);
			$cal5=$t->get_cal_mat($lstUs[$y]['IdUsua'], $lstMat[4]['IdModulo']);
			$cal6=$t->get_cal_mat($lstUs[$y]['IdUsua'], $lstMat[5]['IdModulo']);
			$cal7=$t->get_cal_mat($lstUs[$y]['IdUsua'], $lstMat[6]['IdModulo']);
			$cal8=$t->get_cal_mat($lstUs[$y]['IdUsua'], $lstMat[7]['IdModulo']);


			if(isset($cal1[0]['Promedio'])){ if($cal1[0]['E1']){ $prom1 = $cal1[0]['E1']; $_tx1 = 'E1'; }elseif($cal1[0]['E2']){ $prom1 = $cal1[0]['E2']; $_tx1 = 'E2'; }else{ $prom1 = $cal1[0]['Promedio']; $_tx1 = ''; } } else { $prom1 = '-'; $_tx1 = '';}
			if(isset($cal2[0]['Promedio'])){ if($cal2[0]['E1']){ $prom2 = $cal2[0]['E1']; $_tx2 = 'E1'; }elseif($cal2[0]['E2']){ $prom2 = $cal2[0]['E2']; $_tx2 = 'E2'; }else{ $prom2 = $cal2[0]['Promedio']; $_tx2 = ''; } } else { $prom2 = '-'; $_tx2 = '';}
			if(isset($cal3[0]['Promedio'])){ if($cal3[0]['E1']){ $prom3 = $cal3[0]['E1']; $_tx3 = 'E1'; }elseif($cal3[0]['E2']){ $prom3 = $cal3[0]['E2']; $_tx3 = 'E2'; }else{ $prom3 = $cal3[0]['Promedio']; $_tx3 = ''; } } else { $prom3 = '-'; $_tx3 = '';}
			if(isset($cal4[0]['Promedio'])){ if($cal4[0]['E1']){ $prom4 = $cal4[0]['E1']; $_tx4 = 'E1'; }elseif($cal4[0]['E2']){ $prom4 = $cal4[0]['E2']; $_tx4 = 'E2'; }else{ $prom4 = $cal4[0]['Promedio']; $_tx4 = ''; } } else { $prom4 = '-'; $_tx4 = '';}
			if(isset($cal5[0]['Promedio'])){ if($cal5[0]['E1']){ $prom5 = $cal5[0]['E1']; $_tx5 = 'E1'; }elseif($cal5[0]['E2']){ $prom5 = $cal5[0]['E2']; $_tx5 = 'E2'; }else{ $prom5 = $cal5[0]['Promedio']; $_tx5 = ''; } } else { $prom5 = '-'; $_tx5 = '';}
			if(isset($cal6[0]['Promedio'])){ if($cal6[0]['E1']){ $prom6 = $cal6[0]['E1']; $_tx6 = 'E1'; }elseif($cal6[0]['E2']){ $prom6 = $cal6[0]['E2']; $_tx6 = 'E2'; }else{ $prom6 = $cal6[0]['Promedio']; $_tx6 = ''; } } else { $prom6 = '-'; $_tx6 = '';}
			if(isset($cal7[0]['Promedio'])){ if($cal7[0]['E1']){ $prom7 = $cal7[0]['E1']; $_tx7 = 'E1'; }elseif($cal7[0]['E2']){ $prom7 = $cal7[0]['E2']; $_tx7 = 'E2'; }else{ $prom7 = $cal7[0]['Promedio']; $_tx7 = ''; } } else { $prom7 = '-'; $_tx7 = '';}
			if((isset($cal8[0]['Promedio'])) && ($lstMat[7]['Tipo'] == 1)){ if($cal8[0]['E1']){ $prom8 = $cal8[0]['E1']; $_tx8 = 'E1'; }elseif($cal8[0]['E2']){ $prom8 = $cal8[0]['E2']; $_tx8 = 'E2'; }else{ $prom8 = $cal8[0]['Promedio']; $_tx8 = ''; } } else { $prom8 = $cal8[0]['Promedio']; $_tx8 = '';}




			 ?>
			<tr>
				<td style="width: 12px;"><?php echo $c = ($c +1 ); ?>.- </td>
				<td style="width: 52px;"><?php echo $lstUs[$y]['Usuario']; ?></td>
				<td style="width: 272px;"><?php echo $lstUs[$y]['APaterno'].' '.$lstUs[$y]['AMaterno'].' '.$lstUs[$y]['Nombre']; ?></td>
				<td style="width: 15px; text-align: center;"><?php echo $prom1.$_tx1; ?></td>
				<td style="width: 15px; text-align: center;"><?php echo $prom2.$_tx2; ?></td>
				<td style="width: 15px; text-align: center;"><?php echo $prom3.$_tx3; ?></td>
				<td style="width: 15px; text-align: center;"><?php echo $prom4.$_tx4; ?></td>
				<td style="width: 15px; text-align: center;"><?php echo $prom5.$_tx5; ?></td>
				<td style="width: 15px; text-align: center;"><?php echo $prom6.$_tx6; ?></td>
				<td style="width: 15px; text-align: center;"><?php echo $prom7.$_tx7; ?></td>
				<td style="width: 15px; text-align: center;"><?php echo $prom8.$_tx8; ?></td>
				<?php
				if(is_numeric($prom1)){ $prom1 = $prom1; } else { $prom1 = 0; }
				if(is_numeric($prom2)){ $prom2 = $prom2; } else { $prom2 = 0; }
				if(is_numeric($prom3)){ $prom3 = $prom3; } else { $prom3 = 0; }
				if(is_numeric($prom4)){ $prom4 = $prom4; } else { $prom4 = 0; }
				if(is_numeric($prom5)){ $prom5 = $prom5; } else { $prom5 = 0; }
				if(is_numeric($prom6)){ $prom6 = $prom6; } else { $prom6 = 0; }
				if(is_numeric($prom7)){ $prom7 = $prom7; } else { $prom7 = 0; }
				if(is_numeric($prom8)){ $prom8 = $prom8; } else { $prom8 = 0; }

				$prx = ($prom1 + $prom2 + $prom3 + $prom4 + $prom5 + $prom6 + $prom7 + $prom8);

				 ?>
				<td style="width: 16px; text-align: center;"><?php echo $px = round(($prx / $_all), 2); ?></td>
			</tr>
		<?php } if($c <= 36) {  $num = (36 - $c); }
		for ($v=1;$v<=$num;$v++) { ?>
			<tr>
				<td style="width: 12px;"><?php echo $c = ($c +1 ); ?>.- </td>
				<td style="width: 52px;"></td>
				<td style="width: 272px;"></td>
				<td style="width: 15px; text-align: center;"></td>
				<td style="width: 15px; text-align: center;"></td>
				<td style="width: 15px; text-align: center;"></td>
				<td style="width: 15px; text-align: center;"></td>
				<td style="width: 15px; text-align: center;"></td>
				<td style="width: 15px; text-align: center;"></td>
				<td style="width: 15px; text-align: center;"></td>
				<td style="width: 15px; text-align: center;"></td>
				<td style="width: 16px; text-align: center;"></td>
			</tr><?php } ?>


	</table>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

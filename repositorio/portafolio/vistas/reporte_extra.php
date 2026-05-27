<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$idCiclo = substr($_GET["idCiclo"], 10,10);
	$idGrupo = substr($_GET["idGrupo"], 10,10);

	$mat=$t->get_mat_extra($idCiclo,$idGrupo);
	$alum=$t->get_alumn_extra($idCiclo,$idGrupo);

	$grp=$t->get_dat_grupo($idGrupo);
	$cic=$t->get_dat_cic($idCiclo);
	$campus=$t->get_campus_id($grp[0]['IdCampus']);

	$firma=$t->get_lstFir($grp[0]['IdCampus'],$grp[0]['IdGrado']);


?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
table {
    font-family: arial;
    border-collapse: collapse;
    width: 100%;
		font-size: 12px;

}
</style>


		<table style='width: 100%;'>
			<tr>
				<td style="width: 150px; border: none; "><img src="../../assets/images/campus/sep_chiapas.png" style="width: 100%; " ></td>
				<td style="width: 355px; text-align: center; border: none;">
					SECRETARÍA DE EDUCACIÓN<br>
					SUBSECRETARÍA DE EDUCACIÓN ESTATAL<br>
					DIRECCION DE EDUCACIÓN SUPERIOR<br>
					DEPARTAMENTO DE SERVICIOS ESCOLARES
				</td>
				<td style="width: 150px; border: none;"><img src="../../assets/images/campus/sep_uni.png" style="width: 100%; margin-left: 0px;" ></td>
			</tr>
		</table><br>
		<table style='width: 100%;'>
			<tr>
				<td colspan='2' style='width: 70px;'>NOMBRE DE LA ESCUELA:</td>
				<td colspan='6' style='width: 400px; text-align: center; border-bottom: 0.5px solid black;'><?php echo $campus[0]['Campus']; ?></td>
			</tr>
			<tr>
				<td style='width: 70px;'>UBICACIÓN:</td>
				<td colspan='6' style='width: 400px; text-align: center; border-bottom: 0.5px solid black;'><?php echo $campus[0]['Direccion']; ?></td>
			</tr>
			<tr>
				<td style='width: 75px;'>TURNO: </td>
				<td colspan='2' style='width: 80px; text-align: center; border-bottom: 0.5px solid black;'><?php echo $grp[0]['_Modalidad']; ?></td>
				<td style='width: 70px; text-align: right; '>CLAVE: </td>
				<td style='width: 45px; text-align: center; border-bottom: 0.5px solid black;'>4089</td>
				<td style='width: 120px; text-align: right; '>CICLO ESCOLAR: </td>
				<td style='width: 186px; text-align: center; border-bottom: 0.5px solid black;'><?php echo $cic[0]['Periodo']; ?></td>
			</tr>
			<tr>
				<td colspan='2' style='width: 100px;'>GRADO O CUATRIMESTRE: </td>
				<td style='width: 45px; text-align: center; border-bottom: 0.5px solid black;'><?php echo $_GET["Grado"]; ?>°</td>
				<td style='width: 70px; text-align: right; '>GRUPO: </td>
				<td style='width: 45px; text-align: center; border-bottom: 0.5px solid black;'><?php echo $grp[0]['Grupo']; ?></td>
				<td style='width: 120px; text-align: right; '>PERIODO: </td>
				<td style='width: 186px; text-align: center; border-bottom: 0.5px solid black;'><?php echo $cic[0]['Ciclo']; ?></td>
			</tr>
			<tr>
				<td style='width: 75px; '>ÁREA:</td>
				<td colspan="6" style='width: 590px; border-bottom: 0.5px solid black;'><?php echo $grp[0]['Nombre']; ?></td>
			</tr>
			<tr>
				<td style='width: 75px; '>EXAMEN:</td>
				<td colspan="6" style='width: 590px; border-bottom: 0.5px solid black;'>EXTRAORDINARIO</td>
			</tr>
		</table>
		<br>


		<table style="width: 100%; font-size: 12px; border: 0.5px solid black;">
				<tr>
					<td rowspan="5" style="border: 0.5px solid black; width: 20px; height: 180px; text-align: center; padding-right: 5px;">
						<p style=" text-align: center; height: 150px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">NÚMERO PROGRESIVO</p>
					</td>
					<td rowspan="5" style="border: 0.5px solid black; width: 80px; text-align: center;">NÚMERO<br><br><br>DE<br><br><br>CONTROL</td>
					<td style="border: 0.5px solid black; width: 280px; text-align: center; height: 10px">NOMBRE DEL ALUMNO</td>
					<td colspan="9" style="border: 0.5px solid black; width: 170px; text-align: center; height: 10px">MATERIAS</td>
				</tr>
				<tr>
					<td style="width: 280px; text-align: right; height: 5px">AÑO <?php echo substr($mat[0]['Fec_extra'],0,4); ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
				</tr>
				<tr>
					<td style="width: 280px; text-align: right; height: 5px">MES</td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[0]['Fec_extra'])){ echo substr($mat[0]['Fec_extra'],5,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[1]['Fec_extra'])){ echo substr($mat[1]['Fec_extra'],5,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[2]['Fec_extra'])){ echo substr($mat[2]['Fec_extra'],5,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[3]['Fec_extra'])){ echo substr($mat[3]['Fec_extra'],5,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[4]['Fec_extra'])){ echo substr($mat[4]['Fec_extra'],5,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[5]['Fec_extra'])){ echo substr($mat[5]['Fec_extra'],5,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[6]['Fec_extra'])){ echo substr($mat[6]['Fec_extra'],5,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[7]['Fec_extra'])){ echo substr($mat[7]['Fec_extra'],5,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[8]['Fec_extra'])){ echo substr($mat[8]['Fec_extra'],5,2); } ?></td>
				</tr>
				<tr>
					<td style="width: 280px; text-align: right; height: 5px">DÍA</td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[0]['Fec_extra'])){ echo substr($mat[0]['Fec_extra'],8,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[1]['Fec_extra'])){ echo substr($mat[1]['Fec_extra'],8,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[2]['Fec_extra'])){ echo substr($mat[2]['Fec_extra'],8,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[3]['Fec_extra'])){ echo substr($mat[3]['Fec_extra'],8,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[4]['Fec_extra'])){ echo substr($mat[4]['Fec_extra'],8,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[5]['Fec_extra'])){ echo substr($mat[5]['Fec_extra'],8,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[6]['Fec_extra'])){ echo substr($mat[6]['Fec_extra'],8,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[7]['Fec_extra'])){ echo substr($mat[7]['Fec_extra'],8,2); } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat[8]['Fec_extra'])){ echo substr($mat[8]['Fec_extra'],8,2); } ?></td>
				</tr>
				<tr>
					<td style="width: 280px; height: 200px"></td>
					<td style="border: 0.5px solid black; width: 25px; text-align: left; ">
						<?php if(isset($mat[0])){ ?>
						<p style="margin-bottom: -30px; margin-left: 0px; text-align: left; height: 150px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg);"><?php echo $mat[0]['NombreMod']; ?></p>
						<?php } ?>
					</td>
					<td style="border: 0.5px solid black; width: 25px; text-align: left;">
						<?php if(isset($mat[1])){ ?>
						<p style="margin-bottom: -30px; margin-left: 0px; text-align: left; height: 150px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg);"><?php echo $mat[1]['NombreMod']; ?></p>
						<?php } ?>
					</td>
					<td style="border: 0.5px solid black; width: 25px; text-align: left;">
						<?php if(isset($mat[2])){ ?>
						<p style="margin-bottom: -30px; text-align: left; height: 150px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg);"><?php echo $mat[2]['NombreMod']; ?></p>
						<?php } ?>
					</td>
					<td style="border: 0.5px solid black; width: 25px; text-align: left;">
						<?php if(isset($mat[3])){ ?>
						<p style="margin-bottom: -30px; text-align: left; height: 150px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg);"><?php echo $mat[3]['NombreMod']; ?></p>
						<?php } ?>
					</td>
					<td style="border: 0.5px solid black; width: 25px; text-align: left;">
						<?php if(isset($mat[4])){ ?>
						<p style="margin-bottom: -30px; text-align: left; height: 150px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg);"><?php echo $mat[4]['NombreMod']; ?></p>
						<?php } ?>
					</td>
					<td style="border: 0.5px solid black; width: 25px; text-align: left;">
						<?php if(isset($mat[5])){ ?>
						<p style="margin-bottom: -30px; text-align: left; height: 150px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg);"><?php echo $mat[5]['NombreMod']; ?></p>
						<?php } ?>
					</td>
					<td style="border: 0.5px solid black; width: 25px; text-align: left;">
						<?php if(isset($mat[6])){ ?>
						<p style="margin-bottom: -30px; text-align: left; height: 150px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg);"><?php echo $mat[6]['NombreMod']; ?></p>
						<?php } ?>
					</td>
					<td style="border: 0.5px solid black; width: 25px; text-align: left;">
						<?php if(isset($mat[7])){ ?>
						<p style="margin-bottom: -30px; text-align: left; height: 150px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg);"><?php echo $mat[7]['NombreMod']; ?></p>
						<?php } ?>
					</td>
					<td style="border: 0.5px solid black; width: 25px; text-align: left;">
						<?php if(isset($mat[8])){ ?>
						<p style="margin-bottom: -30px; text-align: left; height: 150px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg);"><?php echo $mat[8]['NombreMod']; ?></p>
						<?php } ?>
					</td>
				</tr>
				<?php $x=0; for ($y=0;$y< sizeof($alum);$y++) { $x = $x + 1;
					if(isset($mat[0])){ $mat1=$t->get_cal_extra1($idCiclo,$idGrupo,$alum[$y]['IdUsua'],$mat[0]['IdModulo']); }
					if(isset($mat[1])){ $mat2=$t->get_cal_extra1($idCiclo,$idGrupo,$alum[$y]['IdUsua'],$mat[1]['IdModulo']); }
					if(isset($mat[2])){ $mat3=$t->get_cal_extra1($idCiclo,$idGrupo,$alum[$y]['IdUsua'],$mat[2]['IdModulo']); }
					if(isset($mat[3])){ $mat4=$t->get_cal_extra1($idCiclo,$idGrupo,$alum[$y]['IdUsua'],$mat[3]['IdModulo']); }
					if(isset($mat[4])){ $mat5=$t->get_cal_extra1($idCiclo,$idGrupo,$alum[$y]['IdUsua'],$mat[4]['IdModulo']); }
					if(isset($mat[5])){ $mat6=$t->get_cal_extra1($idCiclo,$idGrupo,$alum[$y]['IdUsua'],$mat[5]['IdModulo']); }
					if(isset($mat[6])){ $mat7=$t->get_cal_extra1($idCiclo,$idGrupo,$alum[$y]['IdUsua'],$mat[6]['IdModulo']); }
					if(isset($mat[7])){ $mat8=$t->get_cal_extra1($idCiclo,$idGrupo,$alum[$y]['IdUsua'],$mat[7]['IdModulo']); }
					if(isset($mat[8])){ $mat9=$t->get_cal_extra1($idCiclo,$idGrupo,$alum[$y]['IdUsua'],$mat[8]['IdModulo']); }
					?>
				<tr>
					<td style="border: 0.5px solid black; text-align: center"><?php echo $x; ?></td>
					<td style="border: 0.5px solid black; text-align: center"><?php echo $alum[$y]['Usuario']; ?></td>
					<td style="border: 0.5px solid black; text-align: left"><?php echo $alum[$y]['APaterno'].' '.$alum[$y]['AMaterno'].' '.$alum[$y]['Nombre']; ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat1[0]['E1'])){ echo $mat1[0]['E1']; } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat2[0]['E1'])){ echo $mat2[0]['E1']; } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat3[0]['E1'])){ echo $mat3[0]['E1']; } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat4[0]['E1'])){ echo $mat4[0]['E1']; } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat5[0]['E1'])){ echo $mat5[0]['E1']; } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat6[0]['E1'])){ echo $mat6[0]['E1']; } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat7[0]['E1'])){ echo $mat7[0]['E1']; } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat8[0]['E1'])){ echo $mat8[0]['E1']; } ?></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"><?php if(isset($mat9[0]['E1'])){ echo $mat9[0]['E1']; } ?></td>
				</tr><?php } if($y < 6){ $n = 6 - $y; } $n; ?>
				<?php if($n >= 1){ for ($b=0;$b< $n;$b++) { $x = $x + 1; ?>
				<tr>
					<td style="border: 0.5px solid black; text-align: center"><?php echo $x; ?></td>
					<td style="border: 0.5px solid black; text-align: center"></td>
					<td style="border: 0.5px solid black; text-align: left"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
					<td style="border: 0.5px solid black; width: 20px; text-align: center;"></td>
				</tr><?php } } ?>




		</table><br><br>

	<table style="width: 100%;">
		<tr>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; ">ELABORÓ<br>EL RESPONSABLE DE SERVICIOS<br>ESCOLARES DEL PLANTEL</td>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; ">DIRECTOR DE LA ESCUELA</td>
			<td style="width: 80px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; "><br><br><br><?php echo $firma[0]['Elaboro']; ?></td>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; "><br><br><br><?php echo $firma[0]['Rector']; ?></td>
			<td style="width: 80px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td colspan='5' style="width: 80px; text-align: center; border: none; "><br><br></td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; ">JEFE DEL ÁREA</td>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; ">Vo.Bo.<br>JEFA DEL DEPARTAMENTO DE<br>SERVICIOS ESCOLARES</td>
			<td style="width: 80px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; "><br><br><br><?php echo $firma[0]['Oficina']; ?></td>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; "><br><br><br><?php echo $firma[0]['Departamento']; ?></td>
			<td style="width: 80px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td colspan='5' style="width: 400px; text-align: center; border: none; "><br><br>FECHA DE VALIDACIÓN</td>
		</tr>


	</table>


<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

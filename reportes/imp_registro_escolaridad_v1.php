<?php
session_start();
if($_SESSION['Permisos']){
	include("consultas.php");
	include("numeros.php");
	$rep = 0;
	$t=new Imprimir();
  $IdCiclo = substr($_GET["idCiclo"],10,10);
	$alumnos=$t->get_vacio_alumnos(substr($_GET["idGrupo"],10,10),$IdCiclo);
	$hi = 0; $mi = 0; $hf = 0; $mf = 0;
	for ($us=0;$us< sizeof($alumnos);$us++) {
		$sex = $alumnos[$us]['Sexo'];
		if($sex == 'M'){ $hi = ($hi + 1); } else { $mi = ($mi + 1); }
		if(($alumnos[$us]["IdEstatus"] <> 8) && ($alumnos[$us]["id_ciclo_fin"] == $IdCiclo)){
		 } else {
			 if($sex == 'M'){ $hf = ($hf + 1); } else { $mf = ($mf + 1); }
		 }
	}

	$datMen=$t->get_menDatos(substr($_GET["idGrupo"],10,10));
	$datCiclo=$t->get_datCiclo(substr($_GET["idCiclo"],10,10));
	$lstMaterias=$t->get_vacio_lstMateria($alumnos[0]['IdOferta'],$_GET["Grado"]);

  $oferta = $datMen[0]["Nombre"];

	$datPx=$t->get_dat_px($datCiclo[0]['IdPeriodo']);

	if(($alumnos[0]['Grado'] == 1) || ($alumnos[0]['Grado'] == 2)){
		$rep = 6;
	}
	if($alumnos[0]['Grado'] == 3){
		$rep = 5;
	}


?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    padding: 2px;
}
tr:nth-child(even) {
    /* background-color: #dddddd; */
}

</style>
<title>Registro de escolaridad</title>
<!-- page define la hoja con los márgenes señalados -->
<page backtop="20mm" backbottom="5mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<table style="margin-left:0px; width: 100%;">
		<tr style="padding: 4px; ">
			<td style="width: 282px; font-size: 11px; margin-top: -80px;"><img src="../assets/images/chiapasImg.png" style="width: 180px; margin-top: -25px;" ></td>
			<td style="width: 560px; font-size: 11px; text-align: center; font-weight: bold;">
				<label style='font-size: 14px;'>GOBIERNO CONSTITUCIONAL DEL ESTADO DE CHIAPAS<br>
				SECRETARÍA DE EDUCACIÓN</label><br>
				SUBSECRETARÍA DE EDUCACIÓN ESTATAL<br>
				DIRECCIÓN DE EDUCACIÓN SUPERIOR<br>
				DEPARTAMENTO DE SERVICIOS ESCOLARES<br>
				<b style="font-size: 14px;">REGISTRO DE ESCOLARIDAD</b>
			</td>
			<td style="width: 330px; font-size: 11px; ">
				<img src="../assets/images/campus/logo_inicio.png" style="width: 120px; margin-top: -30px; margin-left: 10px;">
				<table style="margin-left: 140px; width: 200px; margin-top: -60px; position: absolute;">
					<tr style="padding: 4px; ">
						<td style="width: 80px; font-size: 8px; border: 1px solid #000; text-align: center; "><b>CONCEPTO</b></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "><b>HOMBRES</b></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "><b>MUJERES</b></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "><b>TOTAL</b></td>
					</tr>
					<tr style="padding: 4px; ">
						<td style="width: 80px; font-size: 8px; border: 1px solid #000; text-align: center; ">INICIO DE CURSO</td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "> <?php echo $hi; ?></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "> <?php echo $mi; ?></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "> <?php  echo $s = $hi + $mi; ?></td>
					</tr>
					<tr style="padding: 4px; ">
						<td style="width: 80px; font-size: 8px; border: 1px solid #000; text-align: center; ">FIN DE  CURSO</td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table style="margin-top: 2px;">
		<tr>
			<td rowspan="4" style="width:100px; "> </td>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada;"><b>ESCUELA:</b></td>
			<td style="width:300px; font-size: 11px; border-bottom: 1px solid #000; "><?php echo $datMen[0]["Escuela"]; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada;"><b>CLAVE:</b></td>
			<td style="width:250px; font-size: 11px; border-bottom: 1px solid #000; "><?php echo $datMen[0]["Clave"]; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada; "><b>CICLO ESCOLAR:</b></td>
			<td style="width:200px; font-size: 11px; border-bottom: 1px solid #000; "><?php echo $datPx[0]['Periodo']; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:50px; font-size: 11px; "></td>
			<td style="width:20px; font-size: 11px; "></td>
			<td style="width:20px; font-size: 11px; "></td>
			<td style="width:20px; font-size: 11px; "></td>
		</tr>
		<tr>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada;"><b>LOCALIDAD:</b></td>
			<td style="width:300px; font-size: 11px; border-bottom: 1px solid #000; "><?php echo $datMen[0]["Localidad"]; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada;"><b>TURNO:</b></td>
			<td style="width:250px; font-size: 11px; border-bottom: 1px solid #000; "><?php echo $datMen[0]["Turno"]; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada;"><b>CUATRIMESTRE:</b></td>
			<td style="width:200px; font-size: 11px; border-bottom: 1px solid #000; "><?php echo obtenerCuat($_GET["Grado"]); ?> <?php echo $alumnos[0]['Grupo']; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:50px; font-size: 11px; "></td>
			<td style="width:20px; font-size: 11px; "></td>
			<td style="width:20px; font-size: 11px; "></td>
			<td style="width:20px; font-size: 11px; "></td>
		</tr>
		<tr>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada;"><b>CARRERA:</b></td>
			<td style="width:300px; font-size: 11px; border-bottom: 1px solid #000; "><?php echo $oferta; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada; "><b>RVOE:</b></td>
			<td style="width:250px; font-size: 11px; border-bottom: 1px solid #000; "><?php echo $datMen[0]["Rvoe"]; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada;"><b>PER.ESC:</b></td>
			<td style="width:200px; font-size: 11px; border-bottom: 1px solid #000; "><?php echo $datCiclo[0]["Ciclo"]; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:50px; font-size: 11px; text-align: center; "><b>HOJA:</b></td>
			<td style="width:20px; font-size: 11px; text-align: center; border-bottom: 1px solid #000; ">1</td>
			<td style="width:20px; font-size: 11px; text-align: center; ">DE</td>
			<td style="width:20px; font-size: 11px; text-align: center; border-bottom: 1px solid #000; "><?php if($s>=26){ echo "2"; } else { echo "1"; } ?></td>
		</tr>
		<tr>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada; "><b>MODALIDAD:</b></td>
			<td style="width:300px; font-size: 11px; border-bottom: 1px solid #000; "><?php echo $datMen[0]["Modalidad"]; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:100px; font-size: 11px; text-align: right; background: #dadada;"><b>VIGENCIA:</b></td>
			<td style="width:250px; font-size: 11px; border-bottom: 1px solid #000; font-size: 10px;"><?php echo $datMen[0]["Vigencia"]; ?></td>
			<td style="width:50px; "> </td>
			<td style="width:100px; font-size: 11px; text-align: right; "></td>
			<td style="width:200px; font-size: 11px; "></td>
			<td style="width:50px; "> </td>
			<td style="width:50px; font-size: 11px; text-align: center; "></td>
			<td style="width:20px; font-size: 11px; text-align: center; "></td>
			<td style="width:20px; font-size: 11px; text-align: center; "></td>
			<td style="width:20px; font-size: 11px; text-align: center; "></td>
		</tr>
	</table>


	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->


		<table style="margin-left:0px; margin-top: 10px;">
			<tr>
				<td colspan="4" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">ANTECEDENTES</td>
				<td style="width: 350px; font-size: 8px; border: 1px solid #000; text-align: center;"><b>NOMBRE DEL ALUMNO</b></td>
				<td rowspan="4" style="width: 10px; height: 130px; font-size: 8px; border: 1px solid #000; text-align: center;">
				<p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: 0px;">SEXO</p>
				</td>
				<td colspan="9" style="width: 135px; font-size: 8px; border: 1px solid #000; text-align: center; ">CALIFICACIONES FINALES</td>
				<td colspan="9" style="width: 135px; font-size: 8px; border: 1px solid #000; text-align: center;">CALIFICACIONES DE REGULARIZACION</td>
				<td rowspan="4" style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; height: 130px;">
					<p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">ASIGAT. NO ACREDITADAS</p>
				</td>
				<td rowspan="4" style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; height: 130px;">
					<p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">SIT. ESCOLAR</p>
				</td>
			</tr>
			<tr>
				<td rowspan="3" style="width: 15px; height: 130px; font-size: 8px; border: 1px solid #000; text-align: center; ">
				<p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">NUMERO PROGRESIVO</p>
				</td>
				<td rowspan="3" style="width: 15px; height: 130px; font-size: 8px; border: 1px solid #000; text-align: center;">
				<p style=" writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: 0px;">ASIGNATURAS<br>NO ASIGANADAS</p>
				</td>

				<td rowspan="3" style="width: 15px; height: 130px; font-size: 8px; border: 1px solid #000; text-align: center;">
				<p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">SITUACION ESCOLAR</p>
				</td>
				<td rowspan="3" style="width: 40px; font-size: 8px; border: 1px solid #000; text-align: center;">NUMERO<br>DE CONTROL</td>
				<td rowspan="2" style="width: 350px; font-size: 8px; border: 1px solid #000; text-align: center;"></td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">A</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">B</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">C</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">D</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">E</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">F</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">G</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">H</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">I</td>
				<td rowspan="3" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center; height: 100px; "><p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">CLAVE DE LA MATERIA</p></td>
				<td rowspan="3" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center; height: 100px;"><p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">CALIFICACION</p></td>
				<td rowspan="3" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center; height: 100px;"><p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">TIPO DE EXAMEN</p></td>
				<td rowspan="3" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center; height: 100px;"><p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">CLAVE DE LA MATERIA</p></td>
				<td rowspan="3" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center; height: 100px;"><p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">CALIFICACION</p></td>
				<td rowspan="3" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center; height: 100px;"><p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">TIPO DE EXAMEN</p></td>
				<td rowspan="3" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center; height: 100px;"><p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">CLAVE DE LA MATERIA</p></td>
				<td rowspan="3" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center; height: 100px;"><p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">CALIFICACION</p></td>
				<td rowspan="3" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center; height: 100px;"><p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">TIPO DE EXAMEN</p></td>
			</tr>
			<tr>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[0]['NombreMod'])){ echo $lstMaterias[0]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[1]['NombreMod'])){ echo $lstMaterias[1]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[2]['NombreMod'])){ echo $lstMaterias[2]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[3]['NombreMod'])){ echo $lstMaterias[3]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[4]['NombreMod'])){ echo $lstMaterias[4]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[5]['NombreMod'])){ echo $lstMaterias[5]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[6]['NombreMod'])){ echo $lstMaterias[6]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[7]['NombreMod'])){ echo $lstMaterias[7]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[8]['NombreMod'])){ echo $lstMaterias[8]['NombreMod']; } else { echo "----------"; } ?></p></td>
			</tr>
			<tr>
				<td style="width: 350px; font-size: 7px; border: 1px solid #000; text-align: center;"> APELLIDO PATERNO MATERNO NOMBRE(S)</td>
			</tr>
			<?php $m = 0; for ($i=0;$i< sizeof($alumnos);$i++) {

				if($i < 25) {
				$_p1=0; $_p2=0; $_p3=0; $_p4=0; $_p5=0; $_p6=0; $_p7=0; $_p8=0; $_p9=0; $sum = 0; $_x = 0;
				if(isset($lstMaterias[0]["IdModulo"])){ $lstP1=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[0]["IdModulo"]); }
				if(isset($lstMaterias[1]["IdModulo"])){ $lstP2=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[1]["IdModulo"]); }
				if(isset($lstMaterias[2]["IdModulo"])){ $lstP3=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[2]["IdModulo"]); }
				if(isset($lstMaterias[3]["IdModulo"])){ $lstP4=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[3]["IdModulo"]); }
				if(isset($lstMaterias[4]["IdModulo"])){ $lstP5=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[4]["IdModulo"]); }
				if(isset($lstMaterias[5]["IdModulo"])){ $lstP6=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[5]["IdModulo"]); }
				if(isset($lstMaterias[6]["IdModulo"])){ $lstP7=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[6]["IdModulo"]); }
				if(isset($lstMaterias[7]["IdModulo"])){ $lstP8=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[7]["IdModulo"]); }
				if(isset($lstMaterias[8]["IdModulo"])){ $lstP9=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[8]["IdModulo"]); }

				 ?>
			<tr>
				<td style="height: 16px; font-size: 10px; border: 1px solid #000; text-align: center; "><?php echo $m = ($m + 1); ?></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;">--</td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;">P</td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;"><?php echo $alumnos[$i]["Usuario"]; ?></td>
				<td style="width: 350px; font-size: 10px; border: 1px solid #000;"><?php echo $alumnos[$i]["APaterno"].' '.$alumnos[$i]["AMaterno"].' '.$alumnos[$i]["Nombre"]; ?></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;"><?php echo $alumnos[$i]["Sexo"]; ?></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center; "></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center; "></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center; "></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center; "></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center; "></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center; "></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center; "></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center; "></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center; "></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;">

				</td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;">

				</td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;">

				</td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;"></td>
				<td style="font-size: 9px; border: 1px solid #000; text-align: center;"></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;"></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;"></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;"></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;"></td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;">--</td>
				<td style="font-size: 10px; border: 1px solid #000; text-align: center;">P</td>
			</tr>
		<?php } } $num = (25 - $i); $_toc = (24 - $i); ?>
		<input type="hidden" name="Numero" id="Numero" value="<?php echo $num; ?>">
		<input type="hidden" name="_total" id="_total" value="<?php echo $_toc; ?>">


		<?php if( $i > 25) { $maxi = 25; } else { $maxi = 25; }  ?>
		<?php $v = 0;  for ($x=$i;$x< $maxi;$x++) { $v = ($v + 1); ?>
		<tr style="padding: 0px; margin-top: -5px; ">

			<td style="height: 16px; width: 30px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $x + 1;?> </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000; text-align: center; "><?php if($v == 1){ echo "**"; } ?></td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000; text-align: center; "><?php if($v == 1){ echo "**"; } ?></td>
			<td style="width: 80px; font-size: 10px; border: 1px solid #000; text-align: center; "><?php if($v == 1){ echo "********"; } ?></td>
			<td style="width: 350px; font-size: 10px; border: 1px solid #000;"><?php if($v == 2){ ?><canvas id="canv" style="position: absolute; margin-left:-2px; margin-top:-8px;"></canvas><?php } if($v == 1){ echo "********************************"; } ?></td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000; text-align: center; ">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 30px; font-size: 10px; border: 1px solid #000;">  </td>

		</tr><?php } ?>
		<script>

		var c = document.getElementById("canv");
		var Num = document.getElementById("Numero").value;
		var Total = document.getElementById("_total").value;
		var sum = 0;

		var mult = 0;

		if(Total == 1){ mult = 8; }
		if(Total == 2){ mult = 10.5; }
		if(Total == 3){ mult = 11.5; }
		if(Total == 4){ mult = 12.5; }
		if(Total == 5){ mult = 13.5; }
		if(Total == 6){ mult = 14; }
		if(Total == 7){ mult = 14; }
		if(Total == 8){ mult = 14; }
		if(Total == 9){ mult = 14.5; }
		if(Total == 10){ mult = 14.5; }
		if(Total == 11){ mult = 14.5; }
		if(Total == 12){ mult = 14.8; }
		if(Total == 13){ mult = 14.8; }
		if(Total == 14){ mult = 14.8; }
		if(Total == 15){ mult = 15; }
		if(Total == 16){ mult = 15; }
		if(Total == 17){ mult = 15; }
		if(Total == 18){ mult = 15.2; }
		if(Total == 19){ mult = 15.2; }
		if(Total == 20){ mult = 15.2; }
		if(Total == 21){ mult = 15.2; }
		if(Total == 22){ mult = 15.3; }
		if(Total == 23){ mult = 15.3; }
		sum = (mult * Num);

		var contexto = c.getContext("2d");
		var cw = c.width = 339,
			cx = cw / 2;
		var ch = c.height = sum,
			cy = ch / 2;
		var a = {
			x: 0,
			y: 0,
		}
		var b = {
			x: 339,
			y: sum,
		}

		contexto.moveTo(a.x, a.y);
		contexto.lineTo(b.x, b.y);
		contexto.stroke();
		</script>
		</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>
</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

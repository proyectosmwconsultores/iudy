<?php
session_start();
if($_SESSION['Permisos']){
	include("consultas.php");
	include("numeros.php");

	$t=new Imprimir();

  $IdCiclo = substr($_GET["idCiclo"],10,10);

	// $alumnos=$t->get_alumnos(substr($_GET["idGrupo"],10,10),$IdCiclo);
 $alumnos=$t->get_vacio_alumnos(substr($_GET["idGrupo"],10,10),$IdCiclo);
	//$alumnos=$t->get_alumnos(substr($_GET["idGrupo"],10,10));
	// $alumnosB=$t->get_alumnosB(substr($_GET["idGrupo"],10,10));

	$hombresI=$t->get_alumSx(substr($_GET["idGrupo"],10,10),'H',$IdCiclo);
	$mujeresI=$t->get_alumSx(substr($_GET["idGrupo"],10,10),'M',$IdCiclo);
	$hombresF=$t->get_alumSxF(substr($_GET["idGrupo"],10,10),'H',$IdCiclo);
	$mujeresF=$t->get_alumSxF(substr($_GET["idGrupo"],10,10),'M',$IdCiclo);

	$datMen=$t->get_menDatos(substr($_GET["idGrupo"],10,10));
	$datCiclo=$t->get_datCiclo(substr($_GET["idCiclo"],10,10));
	// $lstMaterias=$t->get_lstMateria(substr($_GET["idCiclo"],10,10),substr($_GET["idGrupo"],10,10));
	$lstMaterias=$t->get_vacio_lstMateria($alumnos[0]['IdOferta'],$_GET["Grado"]);

  $oferta = $datMen[0]["Nombre"];

	$datPx=$t->get_dat_px($datCiclo[0]['IdPeriodo']);

	$lstfir=$t->get_lstFir($datMen[0]["IdCampus"],$datMen[0]['IdGrado']);

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
	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->


		<table style="margin-left:0px; margin-top: 10px;">
			<tr>
				<td colspan="4" style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">ANTECEDENTES</td>
				<td style="width: 350px; font-size: 8px; border: 1px solid #000; text-align: center;"><b>NOMBRE DEL ALUMNO</b></td>
				<td rowspan="4" style="width: 10px; height: 130px; font-size: 8px; border: 1px solid #000; text-align: center;">
				<p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">SEXO</p>
				</td>
				<td colspan="9" style="width: 135px; font-size: 8px; border: 1px solid #000; text-align: center; ">CALIFICACIONES FINALES</td>
				<td colspan="9" style="width: 135px; font-size: 8px; border: 1px solid #000; text-align: center;">CALIFICACIONES DE REGULARIZACION</td>
				<td rowspan="4" style="width: 15px; height: 120px; font-size: 8px; border: 1px solid #000; text-align: center; height: 130px;">
					<p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">ASIGAT. NO ACREDITADAS</p>
				</td>
				<td rowspan="4" style="width: 15px; height: 120px; font-size: 8px; border: 1px solid #000; text-align: center; height: 130px;">
					<p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">SIT. ESCOLAR</p>
				</td>
			</tr>
			<tr>
				<td rowspan="3" style="width: 15px; height: 130px; font-size: 8px; border: 1px solid #000; text-align: center; ">
				<p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">NUMERO PROGRESIVO</p>
				</td>
				<td rowspan="3" style="width: 15px; height: 130px; font-size: 8px; border: 1px solid #000; text-align: center;">
				<p style=" writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">ASIGNATURAS<br>NO ASIGANADAS</p>
				</td>

				<td rowspan="3" style="width: 15px; height: 130px; font-size: 8px; border: 1px solid #000; text-align: center;">
				<p style="writing-mode: vertical-rl; display: inline; transform: rotate(180deg);">SITUACION ESCOLAR</p>
				</td>
				<td rowspan="2" style="width: 40px; font-size: 8px; border: 1px solid #000; text-align: center;">NUMERO<br>DE CONTROL</td>
				<td rowspan="2" style="width: 350px; font-size: 8px; border: 1px solid #000; text-align: center;"></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[0]['NombreMod'])){ echo $lstMaterias[0]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[1]['NombreMod'])){ echo $lstMaterias[1]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[2]['NombreMod'])){ echo $lstMaterias[2]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[3]['NombreMod'])){ echo $lstMaterias[3]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[4]['NombreMod'])){ echo $lstMaterias[4]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[5]['NombreMod'])){ echo $lstMaterias[5]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[6]['NombreMod'])){ echo $lstMaterias[6]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[7]['NombreMod'])){ echo $lstMaterias[7]['NombreMod']; } else { echo "----------"; } ?></p></td>
				<td rowspan="2" style="width: 30px; font-size: 7px; border: 1px solid #000; text-align: center;"><p style=" height: 100px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php if(isset($lstMaterias[8]['NombreMod'])){ echo $lstMaterias[8]['NombreMod']; } else { echo "----------"; } ?></p></td>


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
			</tr>
			<tr>
				<td style="width: 40px; font-size: 7px; border: 1px solid #000; text-align: center;"> CLAVE D.S.E.</td>
				<td style="width: 350px; font-size: 7px; border: 1px solid #000; text-align: center;"> APELLIDO PATERNO MATERNO NOMBRE(S)</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">A</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">B</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">C</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">D</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">E</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">F</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">G</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">H</td>
				<td style="width: 30px; font-size: 8px; border: 1px solid #000; text-align: center;">I</td>
			</tr>
			<tr>
				<td colspan="26" style="font-size: 10px; border: 1px solid #000; text-align: center; "><b>ALUMNOS QUE REPITEN CURSO Y DADOS DE ALTA</b></td>
			</tr>
			<tr>
				<td colspan="26" style="font-size: 16px; border: 1px solid #000; text-align: center; padding: 5px; border-left: none; border-right: none;"><b>ALUMNOS QUE REPITEN CURSO</b></td>
			</tr>
			<?php for ($i=0;$i< 4;$i++) {  ?>
				 <tr style="padding: 0px; ">
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "><?php echo $i + 1;?> </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
	 			<td style="width: 80px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
	 			<td style="width: 292px; font-size: 8px; border: 1px solid #000;"></td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "> </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
	 			</tr>
		<?php }   ?>
		<tr>
			<td colspan="26" style="font-size: 16px; border: 1px solid #000; text-align: center; padding: 5px; border-left: none; border-right: none;"><b>ALUMNOS DADOS DE ALTA</b></td>
		</tr>
		<?php for ($i=0;$i< 10;$i++) {  ?>
			 <tr style="padding: 0px; ">
			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "><?php echo $i + 1;?> </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
			<td style="width: 80px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
			<td style="width: 292px; font-size: 8px; border: 1px solid #000;"></td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "> </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
			</tr>
	<?php }   ?>
		</table>
		<br>
		<table style="margin-left:0px;">
			<tr style="padding: 0px; ">
				<td colspan="5" style="width: 300px; font-size: 12px; border-bottom: 1px solid #000; text-align: center; "> <b>INSCRIPCIÓN O REINSCRIPCIÓN</b> </td>
				<td style="width: 20px; font-size: 12px; text-align: center; "> </td>
				<td colspan="11" style="width: 220px; font-size: 12px; border-bottom: 1px solid #000; text-align: center; "> <b>ACREDITACIÓN Y REGULARIZACIÓN</b> </td>
				<td style="width: 20px; font-size: 12px; text-align: center; "> </td>
				<td colspan="10" style="width: 200px; font-size: 12px; border-bottom: 1px solid #000; text-align: center; "> <b>LEGALIZACIÓN DEL DOCUMENTO</b> </td>
			</tr>

			<tr style="padding: 0px; ">
				<td colspan="4" rowspan="4" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 250; font-size: 9px; border: 1px solid #000; text-align: center; ">DEPARTAMENTO DE SERVICIOS<br> ESCOLARES </td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" rowspan="4" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; ">  </td>
				<td colspan="6" style="width: 120px; font-size: 9px; border: 1px solid #000; text-align: center; "> DEPARTAMENTO DE SERVICIOS<br> ESCOLARES </td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="10" style="width: 200px; font-size: 9px; border: 1px solid #000; text-align: center; "> DEPARTAMENTO DE SERVICIOS<br> ESCOLARES </td>
			</tr>
			<tr style="padding: 0px; ">
				<td rowspan="2" style="width: 250; font-size: 9px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="6" rowspan="2" style="width: 120px; font-size: 9px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="10" style="width: 200px; font-size: 9px; border: 1px solid #000; text-align: left; "> PERIODO LEGALIZADO: </td>
			</tr>
			<tr style="padding: 0px; ">
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; border-bottom: 1px solid white;"> </td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="10" style="width: 200px; font-size: 9px; border: 1px solid #000; text-align: center; "> <br><br><br><br><br><br><br><br><br></td>
			</tr>
			<tr style="padding: 0px; ">
				<td style="width: 250; font-size: 8px; border: 1px solid #000; text-align: left; ">FECHA: <?php //echo $lstfir[0]["Fecha"]; ?></td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center;  "> </td>
				<td colspan="6" style="width: 120px; font-size: 8px; border: 1px solid #000; text-align: left; "> FECHA: <?php //echo $lstfir[0]["Fecha"]; ?></td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td rowspan="2" colspan="10" style="width: 200px; font-size: 9px; border-right: 1px solid #000; text-align: left; ">FECHA:</td>
			</tr>
			<tr style="padding: 0px; ">
				<td colspan="4" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; ">SELLO DEL PLANTEL </td>
				<td style="width: 200; font-size: 9px; border: 1px solid #000; text-align: center; ">FECHA Y SELLO DE VALIDACIÓN </td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> SELLO DEL PLANTEL </td>
				<td colspan="6" style="width: 120px; font-size: 9px; border: 1px solid #000; text-align: left;; ">FECHA Y SELLO DE VALIDACIÓN</td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<!-- <td colspan="10" style="width: 200px; font-size: 9px; border: 1px solid #000; text-align: left; "> FECHA: OK <?php //echo $lstfir[0]["Fecha"]; ?> </td> -->
			</tr>
			<tr style="padding: 0px; ">
				<td colspan="4" style="width: 100px; font-size: 10px; border: 1px solid #000; text-align: center; "> <br><br><br><br><br><br> <label style="font-size: 7px; margin-top: 25px;"><?php echo $lstfir[0]["Rector"]; ?> </label></td>
				<td style="width: 200; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><br><br><br><br><br><br><br><?php echo $lstfir[0]["Escolares_sep_cotejo"]; ?> </label></td>
				<td style="width: 20px; font-size: 10px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><br><br><br><br><br><br><br><?php echo $lstfir[0]["Rector"]; ?> </label> </td>
				<td colspan="6" style="width: 120px; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><br><br><br><br><br><br><br><?php echo $lstfir[0]["Escolares_sep_cotejo"]; ?> </label> </td>
				<td style="width: 20px; font-size: 10px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><br><br><br><br><br><br><br><?php echo $lstfir[0]["Oficina"]; ?> </label> </td>
				<td colspan="5" style="width: 100px; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><br><br><br><br><br><br><br><?php echo $lstfir[0]["Departamento"]; ?> </label> </td>
			</tr>
			<tr style="padding: 0px; ">
				<td colspan="4" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DIRECTOR <br>Y/O RECTOR </td>
				<td style="width: 200; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DE QUIEN VALIDA</td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DIRECTOR <br>Y/O RECTOR </td>
				<td colspan="6" style="width: 120px; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DE QUIEN VALIDA </td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DEL JEFE <br> DE OFICINA </td>
				<td colspan="5" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DE LA JEFA <br> DEL DEPARTAMENTO </td>
			</tr>

		</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>
</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

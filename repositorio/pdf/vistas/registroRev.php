
<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	$t=new Imprimir();


	$alumnos=$t->get_alumnosRep(substr($_GET["idGrupo"],10,10), substr($_GET["idCiclo"],10,10));
	$alumnosRIncor=$t->get_alumnosReinCor(substr($_GET["idGrupo"],10,10), substr($_GET["idCiclo"],10,10));
	$alumnosB=$t->get_alumnosB(substr($_GET["idGrupo"],10,10));

	$hombresI=$t->get_alumSx(substr($_GET["idGrupo"],10,10),'H');
	$mujeresI=$t->get_alumSx(substr($_GET["idGrupo"],10,10),'M');
	$hombresF=$t->get_alumSxF(substr($_GET["idGrupo"],10,10),'H');
	$mujeresF=$t->get_alumSxF(substr($_GET["idGrupo"],10,10),'M');

	$datMen=$t->get_menDatos(substr($_GET["idGrupo"],10,10));
	$datCiclo=$t->get_datCiclo(substr($_GET["idCiclo"],10,10));
	$lstMaterias=$t->get_lstMateria(substr($_GET["idCiclo"],10,10),substr($_GET["idGrupo"],10,10));
	$lstfir=$t->get_lstFir($datMen[0]["IdCampus"]);
	//
	// if(!$datMen[0]["IdCampus"]){
	// 	echo "<script type='text/javascript'>window.close();</script>";
	// }
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
    padding: 2px;
}
tr:nth-child(even) {
    /* background-color: #dddddd; */
}
#texto1 { width: 100px;}


-->
</style>
<title>Registro de escolaridad</title>
<!-- page define la hoja con los márgenes señalados -->
<page backtop="5mm" backbottom="5mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->



	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->





		<table style="margin-left:0px;">
			<tr style="padding: 4px; ">
				<td colspan="3" style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; ">ANTECEDENTES</td>
				<td rowspan="3" style="width: 150px; height: 120px; font-size: 11px; border: 1px solid #000; text-align: center;">NÚMERO DE<br><br><br><br><br><b style="font-size:8px;">CLAVE D.S.E.</b><br><br>CONTROL</td>
				<td rowspan="3" style="width: 325px; font-size: 11px; border: 1px solid #000; text-align: center;"><b>NOMBRE DEL ALUMNO</b><br><br><br><br><br><br><br>APELLIDO PATERNO &nbsp;&nbsp;&nbsp; MATERNO &nbsp;&nbsp;&nbsp; NOMBRE(S)</td>
				<td rowspan="3" style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center; transform: rotate(270deg);">SEXO</td>

				<td colspan="7" style="width: 200px; font-size: 11px; border: 1px solid #000; text-align: center; "> CALIFICACIONES FINALES</td>
				<td colspan="10" style="width: 200px; font-size: 11px; border: 1px solid #000; text-align: center;"> CALIFICACIÓN DE REGULARIZACIÓN </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
			</tr>
			<tr style="padding: 4px; ">
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000; "><img src="../../assets/imgRegistroEsc/no1.png" style="width: 100%; margin-bottom: -15px;"></td>
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no2.png" style="width: 100%; margin-bottom: -40px;"></td>
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no3.png" style="width: 100%; margin-bottom: -15px;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><br></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 10px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
			</tr>
			<tr style="padding: 4px; ">
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center; transform: rotate(270deg);"><p style="margin-left: -30px;"> <?php echo substr($lstMaterias[0]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center; transform: rotate(270deg);"><p style="margin-left: -30px;"> <?php echo substr($lstMaterias[1]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center; transform: rotate(270deg);"><p style="margin-left: -30px;"> <?php echo substr($lstMaterias[2]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center; transform: rotate(270deg);"><p style="margin-left: -30px;"> <?php echo substr($lstMaterias[3]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center; transform: rotate(270deg);"><p style="margin-left: -30px;"> <?php echo substr($lstMaterias[4]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center; transform: rotate(270deg);"><p style="margin-left: -30px;"> <?php echo substr($lstMaterias[5]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 125%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 125%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 125%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 125%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 125%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 125%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 125%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 125%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 125%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no2.png" style="width: 115%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no3.png" style="width: 95%; margin-bottom: 5px;"></td>
			</tr>
			<?php //for ($i=0;$i< sizeof($clvGrupo);$i++) {  ?>

			<tr style="padding: 0px; ">
				<td colspan="25" style="width: 500px; padding:10px; font-size: 16px; border-bottom: 1px solid #000; text-align: center; "> <b>ALUMNOS QUE REPITEN CURSO</b> </td>
			</tr>
			<?php for ($i=0;$i< 4;$i++) {
				$lstPromB1=$t->get_lstProm($alumnos[$i]["IdUsua"], $alumnos[0]["IdOferta"],$lstMaterias[0]["IdModulo"]);
				$lstPromB2=$t->get_lstProm($alumnos[$i]["IdUsua"], $alumnos[0]["IdOferta"],$lstMaterias[1]["IdModulo"]);
				$lstPromB3=$t->get_lstProm($alumnos[$i]["IdUsua"], $alumnos[0]["IdOferta"],$lstMaterias[2]["IdModulo"]);
				$lstPromB4=$t->get_lstProm($alumnos[$i]["IdUsua"], $alumnos[0]["IdOferta"],$lstMaterias[3]["IdModulo"]);
				$lstPromB5=$t->get_lstProm($alumnos[$i]["IdUsua"], $alumnos[0]["IdOferta"],$lstMaterias[4]["IdModulo"]);
				$lstPromB6=$t->get_lstProm($alumnos[$i]["IdUsua"], $alumnos[0]["IdOferta"],$lstMaterias[5]["IdModulo"]);

				?>
			<tr style="padding: 0px; ">
			<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $i + 1;?> </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; ">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
			<td style="width: 80px; font-size: 10px; border: 1px solid #000; text-align: center; "><?php echo $alumnos[$i]["Usuario"]; ?></td>
			<td style="width: 292px; font-size: 10px; border: 1px solid #000;"> <?php echo $alumnos[$i]["APaterno"].' '.$alumnos[$i]["AMaterno"].' '.$alumnos[$i]["Nombre"]; ?></td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $alumnos[$i]["Sexo"]; ?> </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB1[0]["Promedio"]; ?></td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB2[0]["Promedio"]; ?></td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB3[0]["Promedio"]; ?></td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB4[0]["Promedio"]; ?></td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB5[0]["Promedio"]; ?></td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB6[0]["Promedio"]; ?></td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			</tr><?php  } ?>
			<tr style="padding: 0px; ">
				<td colspan="25" style="width: 500px; font-size: 16px; padding:10px; border-bottom: 1px solid #000; text-align: center; "> <b>ALUMNOS DADOS DE ALTA</b> </td>
			</tr>
			<?php for ($i=0;$i< 4;$i++) {
				// $lstPromB1=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[0]["IdModulo"]);
				// $lstPromB2=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[1]["IdModulo"]);
				// $lstPromB3=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[2]["IdModulo"]);
				// $lstPromB4=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[3]["IdModulo"]);
				// $lstPromB5=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[4]["IdModulo"]);
				// $lstPromB6=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[5]["IdModulo"]);

				 ?>
			<tr style="padding: 0px; ">
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $i + 1;?> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; ">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 80px; font-size: 10px; border: 1px solid #000; text-align: center; "><?php echo $alumnosRIncor[$i]["Usuario"]; ?></td>
				<td style="width: 292px; font-size: 10px; border: 1px solid #000;"> <?php echo $alumnosRIncor[$i]["APaterno"].' '.$alumnosRIncor[$i]["AMaterno"].' '.$alumnosRIncor[$i]["Nombre"]; ?></td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $alumnosRIncor[$i]["Sexo"]; ?> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB1[0]["Promedio"]; ?></td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB1[1]["Promedio"]; ?></td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB1[2]["Promedio"]; ?></td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB1[3]["Promedio"]; ?></td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB1[4]["Promedio"]; ?></td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $lstPromB1[5]["Promedio"]; ?></td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			</tr><?php } ?>

		</table><br>
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
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="10" style="width: 200px; font-size: 9px; border: 1px solid #000; text-align: center; "> <br><br><br><br><br><br><br><br><br></td>
			</tr>
			<tr style="padding: 0px; ">
				<td style="width: 250; font-size: 8px; border: 1px solid #000; text-align: left; ">FECHA: <?php echo $lstfir[0]["Fecha"]; ?></td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="6" style="width: 120px; font-size: 8px; border: 1px solid #000; text-align: left; "> FECHA: <?php echo $lstfir[0]["Fecha"]; ?></td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="10" style="width: 200px; font-size: 9px; border-right: 1px solid #000; text-align: center; "></td>
			</tr>
			<tr style="padding: 0px; ">
				<td colspan="4" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; ">SELLO DEL PLANTEL </td>
				<td style="width: 200; font-size: 9px; border: 1px solid #000; text-align: center; ">FECHA Y SELLO DE VALIDACIÓN </td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> SELLO DEL PLANTEL </td>
				<td colspan="6" style="width: 120px; font-size: 9px; border: 1px solid #000; text-align: center; ">FECHA Y SELLO DE VALIDACIÓN</td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="10" style="width: 200px; font-size: 9px; border: 1px solid #000; text-align: left; "> FECHA: <?php echo $lstfir[0]["Fecha"]; ?> </td>
			</tr>
			<tr style="padding: 0px; ">
				<td colspan="4" style="width: 100px; font-size: 10px; border: 1px solid #000; text-align: center; "> <br><br><br><br><br><br> <label style="font-size: 7px; margin-top: 25px;"><?php echo $lstfir[0]["Rector"]; ?> </label></td>
				<td style="width: 200; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><br><br><br><br><br><br><br><?php echo $lstfir[0]["Escolares"]; ?> </label></td>
				<td style="width: 20px; font-size: 10px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><br><br><br><br><br><br><br><?php echo $lstfir[0]["Rector"]; ?> </label> </td>
				<td colspan="6" style="width: 120px; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><br><br><br><br><br><br><br><?php echo $lstfir[0]["Escolares"]; ?> </label> </td>
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

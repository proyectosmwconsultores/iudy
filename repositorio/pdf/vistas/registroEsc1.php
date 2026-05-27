<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	$t=new Imprimir();

    $IdCiclo = substr($_GET["idCiclo"],10,10);

	$alumnos=$t->get_alumnos(substr($_GET["idGrupo"],10,10),$IdCiclo);

	//$alumnos=$t->get_alumnos(substr($_GET["idGrupo"],10,10));
	// $alumnosB=$t->get_alumnosB(substr($_GET["idGrupo"],10,10));

	$hombresI=$t->get_alumSx(substr($_GET["idGrupo"],10,10),'H',$IdCiclo);
	$mujeresI=$t->get_alumSx(substr($_GET["idGrupo"],10,10),'M',$IdCiclo);
	$hombresF=$t->get_alumSxF(substr($_GET["idGrupo"],10,10),'H',$IdCiclo);
	$mujeresF=$t->get_alumSxF(substr($_GET["idGrupo"],10,10),'M',$IdCiclo);

	$datMen=$t->get_menDatos(substr($_GET["idGrupo"],10,10));
	$datCiclo=$t->get_datCiclo(substr($_GET["idCiclo"],10,10));
	$lstMaterias=$t->get_lstMateria(substr($_GET["idCiclo"],10,10),substr($_GET["idGrupo"],10,10));

    $oferta = $datMen[0]["Nombre"];
    if(($datMen[0]["IdEducativa"] == 1) || ($datMen[0]["IdEducativa"] == 9)){
	    $oferta = "LICENCIATURA EN ENFERMERIA";
    }

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
<page backtop="50mm" backbottom="5mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<table style="margin-left:40px;">
		<tr style="padding: 4px; ">
			<td style="width: 282px; font-size: 11px; margin-top: -80px;"><img src="../../assets/images/chiapasImg.png" style="width: 180px; margin-top: -25px;" ></td>
			<td style="width: 512px; font-size: 13px; text-align: center;">
				GOBIERNO CONSTITUCIONAL DEL ESTADO DE CHIAPAS<br>
				SECRETARÍA DE EDUCACIÓN<br>
				SUBSECRETARÍA DE EDUCACIÓN ESTATAL<br>
				DIRECCIÓN DE EDUCACIÓN SUPERIOR<br>
				DEPARTAMENTO DE SERVICIOS ESCOLARES<br>
				<b style="font-size: 14px;">REGISTRO DE ESCOLARIDAD</b>
			</td>
			<td style="width: 382px; font-size: 11px; ">
				<img src="../../assets/images/campus/logo_inicio.png" style="width: 150px; margin-top: -30px;">
				<table style="margin-left: 180px; width: 200px; margin-top: -60px; position: absolute;">
					<tr style="padding: 4px; ">
						<td style="width: 80px; height: 70px; font-size: 10px; border: 1px solid #000; text-align: center; ">CONCEPTO</td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; transform: rotate(270deg);">HOMBRES</td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; transform: rotate(270deg);">MUJERES</td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; transform: rotate(270deg);">TOTAL</td>
					</tr>
					<tr style="padding: 4px; ">
						<td style="width: 80px; font-size: 8px; border: 1px solid #000; text-align: left; ">INICIO DE CURSO</td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "> <?php echo $hombresI[0]["Total"]; ?></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "> <?php echo $mujeresI[0]["Total"]; ?></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "> <?php  echo $s = $hombresI[0]["Total"] + $mujeresI[0]["Total"]; ?></td>
					</tr>
					<tr style="padding: 4px; ">
						<td style="width: 80px; font-size: 8px; border: 1px solid #000; text-align: left; ">FIN DE  CURSO</td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "> <?php echo $hombresF[0]["Total"]; ?></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "> <?php echo $mujeresF[0]["Total"]; ?></td>
						<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; "> <?php  echo $sd = $hombresF[0]["Total"] + $mujeresF[0]["Total"]; ?></td>
					</tr>

				</table>

			</td>
		</tr>
	</table>
	<table style="margin-top:-1px;">
		<tr style="padding: 4px;">
			<td rowspan="4" style="width:150px;"> </td>
			<td style="width: 385px; font-size: 12px; ">ESCUELA: <b style="text-decoration: underline;"><?php echo $datMen[0]["Escuela"]; ?></b></td>
			<td style="width: 180px; font-size: 12px; ">CLAVE: <b style="text-decoration: underline;"><?php echo $datMen[0]["Clave"]; ?></b></td>
			<td style="width: 280px; font-size: 12px; ">CICLO ESCOLAR: <b style="text-decoration: underline;"><?php echo substr($datCiclo[0]["FInicio"], 0, 4).'-'.substr($datCiclo[0]["FFinal"], 0, 4) ?></b></td>
			<td rowspan="4" style="width:150px; text-align: right;">HOJA: <?php if($s < 26){ echo "1 DE 1"; } else { echo "1 DE 2"; } ?>  </td>
		</tr>
		<tr style="padding: 4px;">
			<td style="width: 385px; font-size: 12px; ">LOCALIDAD: <b style="text-decoration: underline;"><?php echo $datMen[0]["Localidad"]; ?></b></td>
			<td style="width: 180px; font-size: 12px; ">TURNO: <b style="text-decoration: underline;"><?php echo $datMen[0]["Turno"]; ?></b></td>
			<td style="width: 280px; font-size: 12px; ">CUATRIMESTRE: <b style="text-decoration: underline;"><?php echo obtenerCuat($_GET["Grado"]); ?></b></td>
		</tr>
		<tr style="padding: 4px;">
			<td style="width: 385px; font-size: 12px; ">CARRERA: <b style="text-decoration: underline;"><?php echo $oferta; ?></b></td>
			<td style="width: 180px; font-size: 12px; ">RVOE: <b style="text-decoration: underline;"><?php echo $datMen[0]["Rvoe"]; ?></b></td>
			<td style="width: 280px; font-size: 12px; ">PER. ESC: <b style="text-decoration: underline;"><?php echo $datCiclo[0]["Ciclo"]; ?></b></td>
		</tr>
		<tr style="padding: 4px;">
			<td style="width: 385px; font-size: 12px; ">MODALIDAD: <b style="text-decoration: underline;"><?php echo $datMen[0]["Modalidad"]; ?></b></td>
			<td style="width: 180px; font-size: 12px; "></td>
			<td style="width: 280px; font-size: 12px; "></td>
		</tr>
	</table>


	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->


		<table style="margin-left:0px;">
		<tr style="padding: 4px; ">
				<td colspan="3" style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; ">ANTECEDENTES</td>
				<td rowspan="3" style="width: 80px; font-size: 11px; border: 1px solid #000; text-align: center;">NÚMERO DE<br><br><br><br><br><b style="font-size:8px;">CLAVE D.S.E.</b><br><br>CONTROL</td>
				<td rowspan="3" style="width: 325px; font-size: 11px; border: 1px solid #000; text-align: center;"><b>NOMBRE DEL ALUMNO</b><br><br><br><br><br><br><br>APELLIDO PATERNO &nbsp;&nbsp;&nbsp; MATERNO &nbsp;&nbsp;&nbsp; NOMBRE(S)</td>
				<td rowspan="3" style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center; transform: rotate(270deg);">SEXO</td>
				<td colspan="7" style="width: 200px; font-size: 11px; border: 1px solid #000; text-align: center; background: #ddd9c4; "> CALIFICACIONES FINALES</td>
				<td colspan="9" rowspan="2" style="width: 300px; font-size: 11px; border: 1px solid #000; text-align: center; background: #ddd9c4;"> CALIFICACIÓN DE REGULARIZACIÓN </td>
				<td rowspan="3" style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no2.png" style="width: 87%; margin-bottom: -40px;"></td>
				<td rowspan="3" style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no3.png" style="width: 80%; margin-bottom: -15px;"></td>
			</tr>
			<tr style="padding: 2px; ">
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000; "><img src="../../assets/imgRegistroEsc/no1.png" style="width: 100%; margin-bottom: -15px;"></td>
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no2.png" style="width: 100%; margin-bottom: -40px;"></td>
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no3.png" style="width: 100%; margin-bottom: -15px;"></td>
				<td style="width: 40px; font-size: 11px; border: 1px solid #000;  text-align: center;">A</td>
				<td style="width: 40px; font-size: 11px; border: 1px solid #000;  text-align: center;">B</td>
				<td style="width: 40px; font-size: 11px; border: 1px solid #000;  text-align: center;">C</td>
				<td style="width: 40px; font-size: 11px; border: 1px solid #000;  text-align: center;">D</td>
				<td style="width: 40px; font-size: 11px; border: 1px solid #000;  text-align: center;">E</td>
				<td style="width: 40px; font-size: 11px; border: 1px solid #000;  text-align: center;">F</td>
				<td style="width: 10px; font-size: 11px; border: 1px solid #000;  text-align: center;">G</td>


			</tr>

			<tr style="padding: 2px; ">
				<td style="width: 20px; font-size: 12px; border: 1px solid #000; text-align: center; transform: rotate(270deg); "> <p style="margin-left: -40px;"><?php echo substr($lstMaterias[0]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 12px; border: 1px solid #000; text-align: center; transform: rotate(270deg); "> <p style="margin-left: -40px;"> <?php echo substr($lstMaterias[1]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 12px; border: 1px solid #000; text-align: center; transform: rotate(270deg); "> <p style="margin-left: -40px;"> <?php echo substr($lstMaterias[2]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 12px; border: 1px solid #000; text-align: center; transform: rotate(270deg); "> <p style="margin-left: -40px;"> <?php echo substr($lstMaterias[3]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 12px; border: 1px solid #000; text-align: center; transform: rotate(270deg); "> <p style="margin-left: -40px;"> <?php echo substr($lstMaterias[4]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 12px; border: 1px solid #000; text-align: center; transform: rotate(270deg); "> <p style="margin-left: -40px;"> <?php echo substr($lstMaterias[5]["CodeModulo"],0,6); ?> </p></td>
				<td style="width: 20px; font-size: 12px; border: 1px solid #000;">  </td>
				<td style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 100%;"></td>
				<td style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 100%;"></td>
				<td style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 100%;"></td>
				<td style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 100%;"></td>
				<td style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 100%;"></td>
				<td style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 100%;"></td>
				<td style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 100%;"></td>
				<td style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 100%;"></td>
				<td style="width: 30px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 100%;"></td>


			</tr>

			<?php //for ($i=0;$i< sizeof($clvGrupo);$i++) {  ?>
			<?php  for ($i=0;$i< sizeof($alumnos);$i++) { if($i < 25) {
				$lstProm1=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[0]["IdModulo"]);
				$lstProm2=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[1]["IdModulo"]);
				$lstProm3=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[2]["IdModulo"]);
				$lstProm4=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[3]["IdModulo"]);
				$lstProm5=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[4]["IdModulo"]);
				$lstProm6=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[5]["IdModulo"]);

				 ?>
			<tr style="padding: 0px; ">
				<td style="width: 20px; font-size: 9px; border: 1px solid #000; text-align: center; "> <?php echo $i + 1;?> </td>
				<td style="width: 20px; font-size: 9px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 20px; font-size: 9px; border: 1px solid #000; text-align: center; "> P </td>
				<td style="width: 80px; font-size: 9px; border: 1px solid #000; text-align: center; "><?php echo $alumnos[$i]["Usuario"]; ?></td>
				<td style="width: 292px; font-size: 9px; border: 1px solid #000;"> <?php echo $alumnos[$i]["APaterno"].' '.$alumnos[$i]["AMaterno"].' '.$alumnos[$i]["Nombre"]; ?></td>
				<td style="width: 20px; font-size: 9px; border: 1px solid #000; text-align: center; "> <?php echo $alumnos[$i]["Sexo"];
				$idEs = $alumnos[$i]["IdEstatus"];
				?> </td>
				<td style="width: 20px; font-size: 9px; border: 1px solid #000;  text-align: center;"> <?php if($idEs== 20){ echo "NP"; } else { if($lstMaterias[0]["CodeModulo"]){ if($lstProm1[0]["Promedio"]){ echo round($lstProm1[0]["Promedio"]); } else { echo ""; } } } ?></td>
				<td style="width: 20px; font-size: 9px; border: 1px solid #000;  text-align: center;"> <?php if($idEs== 20){ echo "NP"; } else { if($lstMaterias[1]["CodeModulo"]){ if($lstProm2[0]["Promedio"]){ echo round($lstProm2[0]["Promedio"]); } else { echo ""; } } } ?></td>
				<td style="width: 20px; font-size: 9px; border: 1px solid #000;  text-align: center;"> <?php if($idEs== 20){ echo "NP"; } else { if($lstMaterias[2]["CodeModulo"]){ if($lstProm3[0]["Promedio"]){ echo round($lstProm3[0]["Promedio"]); } else { echo ""; } } } ?></td>
				<td style="width: 20px; font-size: 9px; border: 1px solid #000;  text-align: center;"> <?php if($idEs== 20){ echo "NP"; } else { if($lstMaterias[3]["CodeModulo"]){ if($lstProm4[0]["Promedio"]){ echo round($lstProm4[0]["Promedio"]); } else { echo ""; } } } ?></td>
				<td style="width: 20px; font-size: 9px; border: 1px solid #000;  text-align: center;"> <?php if($idEs== 20){ echo "NP"; } else { if($lstMaterias[4]["CodeModulo"]){ if($lstProm5[0]["Promedio"]){ echo round($lstProm5[0]["Promedio"]); } else { echo ""; } } } ?></td>
				<td style="width: 20px; font-size: 9px; border: 1px solid #000;  text-align: center;"> <?php if($idEs== 20){ echo "NP"; } else { if($lstMaterias[5]["CodeModulo"]){ if($lstProm6[0]["Promedio"]){ echo round($lstProm6[0]["Promedio"]); } else { echo ""; } } } ?></td>
				<td colspan="11" style="width: 450px; font-size: 9px; padding:2px; border: 1px solid #000; text-align: center;">
				<?php
				if($alumnos[$i]["IdEstatus"] == 20){ echo "BAJA POR DESERCION"; }
				// if($alumnos[$i]["IdEstatus"] == 50){ echo "BLOQUEADO TEMPORALMENTE"; }

				?>
				<?php if(($alumnos[$i]["IdEstatus"] == 8) || ($alumnos[$i]["IdEstatus"] == 50)){ $v = 0;
					if(($lstProm1[0]["Promedio"] == 5) || ($lstProm1[0]["Promedio"] == "NP")){ $v = 1; echo substr($lstMaterias[0]["CodeModulo"],0,6).' 7EX &nbsp;&nbsp;';}
					if(($lstProm2[0]["Promedio"] == 5) || ($lstProm2[0]["Promedio"] == "NP")){ $v = 1; echo substr($lstMaterias[1]["CodeModulo"],0,6).' 7EX &nbsp;&nbsp;';}
					if(($lstProm3[0]["Promedio"] == 5) || ($lstProm3[0]["Promedio"] == "NP")){ $v = 1; echo substr($lstMaterias[2]["CodeModulo"],0,6).' 7EX &nbsp;&nbsp;';}
					if(($lstProm4[0]["Promedio"] == 5) || ($lstProm4[0]["Promedio"] == "NP")){ $v = 1; echo substr($lstMaterias[3]["CodeModulo"],0,6).' 7EX &nbsp;&nbsp;';}
					if(($lstProm5[0]["Promedio"] == 5) || ($lstProm5[0]["Promedio"] == "NP")){ $v = 1; echo substr($lstMaterias[4]["CodeModulo"],0,6).' 7EX &nbsp;&nbsp;';}
					if(($lstProm6[0]["Promedio"] == 5) || ($lstProm6[0]["Promedio"] == "NP")){ $v = 1; echo substr($lstMaterias[5]["CodeModulo"],0,6).' 7EX &nbsp;&nbsp;';}
					if($v == 0){
							echo "= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = ="; }
					} ?>

				</td>
				<td style="width: 30px; font-size: 9px; border: 1px solid #000; text-align: center;"> <?php if(($alumnos[$i]["IdEstatus"] == 8) || ($alumnos[$i]["IdEstatus"] == 50)){ echo "P"; } else { echo "BD"; } ?> </td>
			</tr><?php } } $num = (25 - $i); ?>
			<input type="hidden" name="Numero" id="Numero" value="<?php echo $num; ?>">

			<?php if( $i > 25) { $maxi = 25; } else { $maxi = 25; } //$resta = $i - 23;
			//if( $resta < 0){ ?>
				<?php  for ($x=$i;$x< $maxi;$x++) { ?>
				<tr style="padding: 0px; margin-top: -5px; ">

					<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "><canvas id="canv" style="position: absolute; margin-left:-10px; margin-top:-2px;"></canvas> <?php echo $x + 1;?> </td>
					<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "> </td>
					<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "> </td>
					<td style="width: 80px; font-size: 8px; border: 1px solid #000; text-align: center; "></td>
					<td style="width: 292px; font-size: 8px; border: 1px solid #000;"></td>
					<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; "> </td>
					<td style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; ">  </td>
					<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>
					<td style="width: 30px; font-size: 8px; border: 1px solid #000;">  </td>

				</tr><?php } ?>

				<script>
				var c = document.getElementById("canv");
				var Num = document.getElementById("Numero").value;
				var sum = 0;
				sum = (13.9 * Num);

				var contexto = c.getContext("2d");
				var cw = c.width = 1350,
				  cx = cw / 2;
				var ch = c.height = sum,
				  cy = ch / 2;
				var a = {
				  x: 0,
				  y: 0,
				}
				var b = {
				  x: 1350,
				  y: sum,
				}

				contexto.moveTo(a.x, a.y);
				contexto.lineTo(b.x, b.y);
				contexto.stroke();

				</script>


			<?php //} ?>
		</table>
		<table style="border: none; font-size: 9px;">
			<tr>
				<td style="width: 50px;"></td>
				<td style="width: 50px;"><?php echo substr($lstMaterias[0]["CodeModulo"],0,6); ?></td>
				<td style="width: 340px;"><?php echo $lstMaterias[0]["NombreMod"]; ?></td>
				<td style="width: 50px;"><?php echo substr($lstMaterias[3]["CodeModulo"],0,6); ?></td>
				<td style="width: 340px;"><?php echo $lstMaterias[3]["NombreMod"]; ?></td>
				<td style="width: 300px;"></td>
			</tr>
			<tr>
				<td style="width: 50px;"></td>
				<td style="width: 50px;"><?php echo substr($lstMaterias[1]["CodeModulo"],0,6); ?></td>
				<td style="width: 340px;"><?php echo $lstMaterias[1]["NombreMod"]; ?></td>
				<td style="width: 50px;"><?php echo substr($lstMaterias[4]["CodeModulo"],0,6); ?></td>
				<td style="width: 340px;"><?php echo $lstMaterias[4]["NombreMod"]; ?></td>
				<td style="width: 300px;"></td>
			</tr>
			<tr>
				<td style="width: 50px;"></td>
				<td style="width: 50px;"><?php echo substr($lstMaterias[2]["CodeModulo"],0,6); ?></td>
				<td style="width: 340px;"><?php echo $lstMaterias[2]["NombreMod"]; ?></td>
				<td style="width: 50px;"><?php echo substr($lstMaterias[5]["CodeModulo"],0,6); ?></td>
				<td style="width: 340px;"><?php echo $lstMaterias[5]["NombreMod"]; ?></td>
				<td style="width: 300px;"></td>
			</tr>
		</table>





	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

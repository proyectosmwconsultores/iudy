<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	$t=new Imprimir();


	$alumnos=$t->get_alumnos(substr($_GET["idGrupo"],10,10));
	$alumnosB=$t->get_alumnosB(substr($_GET["idGrupo"],10,10));

	$hombresI=$t->get_alumSx(substr($_GET["idGrupo"],10,10),'H');
	$mujeresI=$t->get_alumSx(substr($_GET["idGrupo"],10,10),'M');
	$hombresF=$t->get_alumSxF(substr($_GET["idGrupo"],10,10),'H');
	$mujeresF=$t->get_alumSxF(substr($_GET["idGrupo"],10,10),'M');

	$datMen=$t->get_menDatos(substr($_GET["idGrupo"],10,10));
	$datCiclo=$t->get_datCiclo(substr($_GET["idCiclo"],10,10));
	$lstMaterias=$t->get_lstMateria(substr($_GET["idCiclo"],10,10),substr($_GET["idGrupo"],10,10));
	$lstfir=$t->get_lstFir($datMen[0]["IdCampus"]);

	$oferta = $datMen[0]["Nombre"];
    if(($datMen[0]["IdEducativa"] == 1) || ($datMen[0]["IdEducativa"] == 9)){
	    $oferta = "LICENCIATURA EN ENFERMERIA";
    }

	if(!$datMen[0]["IdCampus"]){
		echo "<script type='text/javascript'>window.close();</script>";
	}
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
    background-color: #dddddd;
}
#texto1 { width: 100px;}


-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="5mm" backbottom="5mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<table style="margin-top: 20px;">
		<tr style="padding: 2px; ">
			<td style="width: 1220px; font-size: 11px; text-align: right; ">HOJA [[page_cu]] DE [[page_nb]]</td>
		</tr>
	</table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
		<table style="margin-left:40px;">
			<tr style="padding: 4px; ">
				<td style="width: 382px; font-size: 11px; margin-top: -80px;"><img src="../../assets/images/chiapasImg.png" style="width: 180px; margin-top: -25px;" ></td>
				<td style="width: 412px; font-size: 15px; text-align: center;">
					GOBIERNO CONSTITUCIONAL DEL ESTADO DE CHIAPAS<br>
					SECRETARÍA DE EDUCACIÓN<br>
					SUBSECRETARÍA DE EDUCACIÓN ESTATAL<br>
					DIRECCIÓN DE EDUCACIÓN SUPERIOR<br>
					DEPARTAMENTO DE SERVICIOS ESCOLARES<br>
					<b style="font-size: 16px;">REGISTRO DE ESCOLARIDAD</b>
				</td>
				<td style="width: 382px; font-size: 11px; ">
					<img src="../../assets/images/campus/logo_inicio.png" style="width: 150px; margin-top: 25px;">
					<table style="margin-left: 182px; margin-top: 50px; position: absolute;">
						<tr style="padding: 4px; ">
							<td style="width: 80px; font-size: 10px; border: 1px solid #000; text-align: center; ">CONCEPTO</td>
							<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; ">H<br>O<br>M<br>B<br>R<br>E<br>S</td>
							<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; ">M<br>U<br>J<br>E<br>R<br>E<br>S</td>
							<td style="width: 15px; font-size: 8px; border: 1px solid #000; text-align: center; ">T<br>O<br>T<br>A<br>L</td>
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

		<table style="margin-left:px; border: none !important;">
			<tr style="padding: 4px;">
				<td style="width: 462px; font-size: 12px; ">ESCUELA: UNIVERSIDAD DEL SURESTE CAMPUS <?php echo $datMen[0]["Campus"]; ?></td>
				<td style="width: 332px; font-size: 12px; ">CLAVE: 07PSU0002D</td>
				<td style="width: 382px; font-size: 12px; ">CICLO ESCOLAR: <?php echo substr($datCiclo[0]["FInicio"], 0, 4).'-'.substr($datCiclo[0]["FFinal"], 0, 4) ?></td>
			</tr>
			<tr style="padding: 4px;">
				<td style="width: 462px; font-size: 12px; ">LOCALIDAD: <?php echo $datMen[0]["Lugar"]; ?></td>
				<td style="width: 332px; font-size: 12px; ">TURNO: <?php echo $datMen[0]["Turno"]; ?></td>
				<td style="width: 382px; font-size: 12px; ">CUATRIMESTRE: <?php echo obtenerCuat($_GET["Grado"]); ?></td>
			</tr>
			<tr style="padding: 4px;">
				<td style="width: 462px; font-size: 12px; ">CARRERA: <?php echo $oferta; ?></td>
				<td style="width: 332px; font-size: 12px; ">RVOE: <?php echo $datMen[0]["Rvoe"]; ?></td>
				<td style="width: 382px; font-size: 12px; ">PER. ESC: <?php echo $datCiclo[0]["Ciclo"]; ?></td>
			</tr>
			<tr style="padding: 4px;">
				<td style="width: 462px; font-size: 12px; ">MODALIDAD: <?php echo $datMen[0]["Modalidad"]; ?></td>
				<td style="width: 332px; font-size: 12px; "></td>
				<td style="width: 382px; font-size: 12px; "></td>
			</tr>
		</table>

		<table style="margin-left:0px;">
		<tr style="padding: 4px; ">
				<td colspan="3" style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; ">ANTECEDENTES</td>
				<td rowspan="3" style="width: 80px; font-size: 11px; border: 1px solid #000; text-align: center;">NÚMERO<br><br>DE<br><br>COTROL</td>
				<td rowspan="3" style="width: 325px; font-size: 11px; border: 1px solid #000; text-align: center;"><b>NOMBRE DEL ALUMNO</b><br><br>APELLIDO PATERNO &nbsp;&nbsp;&nbsp; MATERNO &nbsp;&nbsp;&nbsp; NOMBRE(S)</td>
				<td rowspan="3" style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;">S<br>E<br>X<br>O</td>
				<td colspan="10" style="width: 200px; font-size: 11px; border: 1px solid #000; text-align: center; "> CALIFICACIONES FINALES</td>
				<td colspan="10" style="width: 200px; font-size: 11px; border: 1px solid #000; text-align: center;"> CALIFICACIÓN DE REGULARIZACIÓN </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
			</tr>
			<tr style="padding: 4px; ">
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000; "><img src="../../assets/imgRegistroEsc/no1.png" style="width: 100%;"></td>
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no2.png" style="width: 100%;"></td>
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no3.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;  text-align: center;">A</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;  text-align: center;">B</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;  text-align: center;">C</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;  text-align: center;">D</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;  text-align: center;">E</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;  text-align: center;">F</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;  text-align: center;">G</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;  text-align: center;">H</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;  text-align: center;">I</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;  text-align: center;">J</td>
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
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[0]["IdModulo"]){ echo substr($lstMaterias[0]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[0]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[0]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[0]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[0]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[0]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[1]["IdModulo"]){ echo substr($lstMaterias[1]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[1]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[1]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[1]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[1]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[1]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[2]["IdModulo"]){ echo substr($lstMaterias[2]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[2]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[2]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[2]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[2]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[2]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[3]["IdModulo"]){ echo substr($lstMaterias[3]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[3]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[3]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[3]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[3]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[3]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[4]["IdModulo"]){ echo substr($lstMaterias[4]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[4]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[4]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[4]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[4]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[4]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[5]["IdModulo"]){ echo substr($lstMaterias[5]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[5]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[5]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[5]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[5]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[5]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no2.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no3.png" style="width: 100%;"></td>
			</tr>

			<?php //for ($i=0;$i< sizeof($clvGrupo);$i++) {  ?>
			<?php  for ($i=0;$i< sizeof($alumnos);$i++) {
				$lstProm1=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[0]["IdModulo"]);
				$lstProm2=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[1]["IdModulo"]);
				$lstProm3=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[2]["IdModulo"]);
				$lstProm4=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[3]["IdModulo"]);
				$lstProm5=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[4]["IdModulo"]);
				$lstProm6=$t->get_lstProm($alumnos[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[5]["IdModulo"]);

				 ?>
			<tr style="padding: 0px; ">
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $i + 1;?> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> P </td>
				<td style="width: 80px; font-size: 10px; border: 1px solid #000; text-align: center; "><?php echo $alumnos[$i]["Usuario"]; ?></td>
				<td style="width: 292px; font-size: 10px; border: 1px solid #000;"> <?php echo $alumnos[$i]["APaterno"].' '.$alumnos[$i]["AMaterno"].' '.$alumnos[$i]["Nombre"]; ?></td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $alumnos[$i]["Sexo"]; ?> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;  text-align: center;"><?php echo $lstProm1[0]["Promedio"]; ?></td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;  text-align: center;"> <?php echo $lstProm2[0]["Promedio"]; ?> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;  text-align: center;"> <?php echo $lstProm3[0]["Promedio"]; ?> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;  text-align: center;"> <?php echo $lstProm4[0]["Promedio"]; ?> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;  text-align: center;"> <?php echo $lstProm5[0]["Promedio"]; ?> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;  text-align: center;"> <?php echo $lstProm6[0]["Promedio"]; ?> </td>
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
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center;"> P </td>
			</tr><?php } ?>
			<?php if( $i > 24) { $maxi = 65; } else { $maxi = 23; } //$resta = $i - 23;
			//if( $resta < 0){ ?>
				<?php  for ($x=$i;$x< $maxi;$x++) { ?>
				<tr style="padding: 0px; ">
					<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $x + 1;?> </td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
					<td style="width: 80px; font-size: 10px; border: 1px solid #000; text-align: center; "></td>
					<td style="width: 292px; font-size: 10px; border: 1px solid #000;"></td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; ">  </td>
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
					<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
					<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				</tr><?php } ?>

			<?php //} ?>
		</table>
		<p style="font-size:10px; text-align: center;"> <?php $xc = 0; for ($m=0;$m< sizeof($lstMaterias);$m++) { $xc = $xc + 1;  echo substr($lstMaterias[$m]["CodeModulo"], 0, 6).'= '.$lstMaterias[$m]["NombreMod"].';  '; if($xc == 4){ echo "<br>"; $xc = 0; } } ?></p>
<br>
		<table style="margin-left:0px;">
			<tr style="padding: 4px; ">
				<td colspan="3" style="width: 20px; font-size: 8px; border: 1px solid #000; text-align: center; ">ANTECEDENTES</td>
				<td rowspan="3" style="width: 80px; font-size: 11px; border: 1px solid #000; text-align: center;">NÚMERO<br><br>DE<br><br>COTROL</td>
				<td rowspan="3" style="width: 325px; font-size: 11px; border: 1px solid #000; text-align: center;"><b>NOMBRE DEL ALUMNO</b><br><br>APELLIDO PATERNO &nbsp;&nbsp;&nbsp; MATERNO &nbsp;&nbsp;&nbsp; NOMBRE</td>
				<td rowspan="3" style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;">S<br>E<br>X<br>O</td>

				<td colspan="10" style="width: 200px; font-size: 11px; border: 1px solid #000; text-align: center; "> CALIFICACIONES FINALES</td>
				<td colspan="10" style="width: 200px; font-size: 11px; border: 1px solid #000; text-align: center;"> CALIFICACIÓN DE REGULARIZACIÓN </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"></td>
			</tr>
			<tr style="padding: 4px; ">
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000; "><img src="../../assets/imgRegistroEsc/no1.png" style="width: 100%;"></td>
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no2.png" style="width: 100%;"></td>
				<td rowspan="2" style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no3.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">A</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">B</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">C</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">D</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">E</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">F</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">G</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">H</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">I</td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">J</td>
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
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[0]["IdModulo"]){ echo substr($lstMaterias[0]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[0]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[0]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[0]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[0]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[0]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[1]["IdModulo"]){ echo substr($lstMaterias[1]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[1]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[1]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[1]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[1]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[1]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[2]["IdModulo"]){ echo substr($lstMaterias[2]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[2]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[2]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[2]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[2]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[2]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[3]["IdModulo"]){ echo substr($lstMaterias[3]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[3]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[3]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[3]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[3]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[3]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[4]["IdModulo"]){ echo substr($lstMaterias[4]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[4]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[4]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[4]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[4]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[4]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000; text-align: center;"> <?php if($lstMaterias[5]["IdModulo"]){ echo substr($lstMaterias[5]["CodeModulo"],0,1); echo '<br>'.substr($lstMaterias[5]["CodeModulo"],1,1); echo '<br>'.substr($lstMaterias[5]["CodeModulo"],2,1); echo '<br>'.substr($lstMaterias[5]["CodeModulo"],3,1); echo '<br>'.substr($lstMaterias[5]["CodeModulo"],4,1); echo '<br>'.substr($lstMaterias[5]["CodeModulo"],5,1); } ?> </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no6.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no7.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no8.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no2.png" style="width: 100%;"></td>
				<td style="width: 20px; font-size: 11px; border: 1px solid #000;"><img src="../../assets/imgRegistroEsc/no3.png" style="width: 100%;"></td>
			</tr>
			<?php //for ($i=0;$i< sizeof($clvGrupo);$i++) {  ?>

			<tr style="padding: 0px; ">
				<td colspan="28" style="width: 500px; font-size: 12px; border-bottom: 1px solid #000; text-align: center; "> <b>ALUMNOS QUE REPITEN CURSO</b> </td>
			</tr>
			<?php for ($i=0;$i< 8;$i++) {  ?>
			<tr style="padding: 0px; ">
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $i + 1;?> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 80px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 292px; font-size: 10px; border: 1px solid #000;"> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
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
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			</tr><?php } ?>
			<tr style="padding: 0px; ">
				<td colspan="28" style="width: 500px; font-size: 12px; border-bottom: 1px solid #000; text-align: center; "> <b>ALUMNOS DADOS DE BAJA</b> </td>
			</tr>
			<?php for ($i=0;$i< 6;$i++) {
				$lstPromB1=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[0]["IdModulo"]);
				$lstPromB2=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[1]["IdModulo"]);
				$lstPromB3=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[2]["IdModulo"]);
				$lstPromB4=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[3]["IdModulo"]);
				$lstPromB5=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[4]["IdModulo"]);
				$lstPromB6=$t->get_lstProm($alumnosB[$i]["IdUsua"], $datMen[0]["IdEducativa"],$lstMaterias[5]["IdModulo"]);

				 ?>
			<tr style="padding: 0px; ">
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $i + 1;?> </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; ">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> </td>
				<td style="width: 80px; font-size: 10px; border: 1px solid #000; text-align: center; "><?php echo $alumnosB[$i]["Usuario"]; ?></td>
				<td style="width: 292px; font-size: 10px; border: 1px solid #000;"> <?php echo $alumnosB[$i]["APaterno"].' '.$alumnosB[$i]["AMaterno"].' '.$alumnosB[$i]["Nombre"]; ?></td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000; text-align: center; "> <?php echo $alumnosB[$i]["Sexo"]; ?> </td>
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
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
				<td style="width: 20px; font-size: 10px; border: 1px solid #000;">  </td>
			</tr><?php } ?>
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
				<td style="width: 200; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><?php echo $lstfir[0]["Escolares"]; ?> </label></td>
				<td style="width: 20px; font-size: 10px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><?php echo $lstfir[0]["Rector"]; ?> </label> </td>
				<td colspan="6" style="width: 120px; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><?php echo $lstfir[0]["Escolares"]; ?> </label> </td>
				<td style="width: 20px; font-size: 10px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><?php echo $lstfir[0]["Oficina"]; ?> </label> </td>
				<td colspan="5" style="width: 100px; font-size: 10px; border: 1px solid #000; text-align: center; "> <label style="font-size: 7px; margin-top: 85px;"><?php echo $lstfir[0]["Departamento"]; ?> </label> </td>
			</tr>
			<tr style="padding: 0px; ">
				<td colspan="4" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DIRECTOR <br>Y/O RECTOR </td>
				<td style="width: 200; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DE QUIEN VALIDA</td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DIRECTOR <br>Y/O RECTOR </td>
				<td colspan="6" style="width: 120px; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DE QUIEN VALIDA </td>
				<td style="width: 20px; font-size: 9px; border-right: 1px solid #000; text-align: center; "> </td>
				<td colspan="5" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DEL JEFE <br> DE OFICINA </td>
				<td colspan="5" style="width: 100px; font-size: 9px; border: 1px solid #000; text-align: center; "> NOMBRE Y FIRMA DEL JEFE <br> DEL DEPARTAMENTO </td>
			</tr>

		</table>




	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

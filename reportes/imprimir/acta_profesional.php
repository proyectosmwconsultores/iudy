<?php
session_start();
if($_SESSION['Permisos']){
	include("consulta_impresion.php");
	include("../numeros.php");
	$rep = 0;
	$t=new Imprimir();

	 $IdUsua = substr($_GET["tokenId"], 10, 50);
	 $datUs=$t->get_datUsuario($IdUsua);
	 $datMen=$t->get_menDatos($datUs[0]["IdGrupo"]);
	 $acta=$t->get_acta_pro($IdUsua);
	 $lstfir=$t->get_lstFir($datMen[0]["IdCampus"],$datMen[0]['IdGrado']);


?>
<style>
table {
    border-collapse: collapse;
	}

table, tr, td {
    /* border: 1px solid #3e3e3e; */
		padding: 0.5px;
}
</style>
<html>
	<head>
		<title>Acta profesional</title>
	</head>
	<body onload="imprimir();">
		<table style='width: 700px;'>
			<tr>
				<td style="text-align: right; font-size: 9px;">
					<b>AEP-16-2021</b>
				</td>
			</tr>
			<tr>
				<td style="letter-spacing: 1px; text-align: center; font-family: Times New Roman; font-size: 16px;">
					<b>GOBIERNO CONSTITUCIONAL DEL ESTADO DE CHIAPAS</b><br>
					<b>SECRETARÍA DE EDUCACIÓN</b><br>
					<b>SUBSECRETARÍA DE EDUCACIÓN ESTATAL</b><br>
					<b style="font-size: 14px;">DIRECCIÓN DE EDUCACIÓN SUPERIOR</b><br>
					<b style="font-size: 13px;">DEPARTAMENTO DE SERVICIOS ESCOLARES</b><br>
					<b style="font-size: 13px;">UNIVERSIDAD DEL SURESTE</b><br>
					<b style="font-size: 10px;">RVOE: ACUERDO NÚMERO <?php echo $datMen[0]['Rvoe']; ?>  VIGENTE: A PARTIR DE <?php echo $datMen[0]['Vigencia']; ?></b>
				</td>
			</tr>
			<tr>
				<td style="text-align: left;">
					<img src="../../assets/images/logoImg.png" style="width: 85px; margin-top: -100px; position: absolute;">
				</td>
			</tr>
		</table><br>
		<table style="border: none;">
			<tr>
				<td style="border: none; width: 45px; text-align: center; font-family: Times New Roman; font-size: 14px;"></td>
				<td style="border: none; width: 70px; text-align: center; font-family: Times New Roman; font-size: 14px;"></td>
				<td style="border: none; width: 465px; text-align: center; font-family: Times New Roman; font-size: 14px;"> <b>RÉGIMEN: PARTICULAR </b></td>
				<td style="border: none; width: 70px; text-align: center; font-family: tahoma; font-size: 12px; text-align: right;"> FOLIO No.</td>
				<td style="border-bottom: 1px solid black; width: 45px; text-align: center; font-family: arial; font-size: 18px;"> <b style="color: red;"><?php echo $acta[0]['Folio']; ?></b></td>
			</tr>
		</table><br>

		<table style='width: 700px; margin-top: 8px;'>
			<tr>
				<td style="width: 190px;"><img src="../../assets/images/fondoImg.png" style="position: absolute; width: 100px; margin-left: 30px; margin-top: -15px;"></td>
				<td style="width: 510px; letter-spacing: 1.2px; text-align: justify; font-family: tahoma; font-size: 10px;">
					ACTA DE EXAMEN PROFESIONAL <u> &nbsp; No.<?php echo $acta[0]['No']; ?> &nbsp;</u>  AUTORIZACIÓN <u>&nbsp; <?php echo $acta[0]['Autorizacion']; ?> &nbsp;</u>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 12px;'>
			<tr>
				<td style="width: 190px; "></td>
				<td style="width: 130px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					EN LA CIUDAD DE
				</td>
				<td style="width: 380px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					&nbsp; <b><?php echo $acta[0]['Ciudad']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 12px;'>
			<tr>
				<td style="width: 190px; "></td>
				<td style="width: 80px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					SIENDO LAS
				</td>
				<td style="width: 180px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					&nbsp;<b> <?php echo $acta[0]['Hora']; ?></b>
				</td>
				<td style="width: 130px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					HORAS DEL DÍA
				</td>
				<td style="width: 120px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					&nbsp;<b> <?php echo $acta[0]['Dia']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 12px;'>
			<tr>
				<td style="width: 190px;"></td>
				<td style="width: 80px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					DEL MES DE
				</td>
				<td style="width: 430px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					&nbsp;<b> <?php echo $acta[0]['Mes']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 12px;'>
			<tr>
				<td style="width: 190px;"></td>
				<td style="width: 85px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					DEL DOS MIL
				</td>
				<td style="width: 425px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					&nbsp;<b> <?php echo $acta[0]['Anio']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 12px;'>
			<tr>
				<td style="width: 190px;"></td>
				<td style="width: 20px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					EN
				</td>
				<td style="width: 490px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					&nbsp;<b> <?php echo $acta[0]['Auditorio']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 12px;'>
			<tr>
				<td style="width: 190px;"></td>
				<td style="width: 20px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					DE
				</td>
				<td style="width: 490px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					&nbsp;<b> <?php echo $acta[0]['Escuela']; ?></b>
				</td>
			</tr>
		</table>
		<br>

		<table style='width: 700px; margin-top: 6px;'>
			<tr>
				<td style="width: 80px; padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					CON CLAVE
				</td>
				<td style="width: 150px; letter-spacing: 1px; border-bottom: 0.5px solid black; text-align: center; font-family: tahoma; font-size: 12px;">
					<b><?php echo $datMen[0]['Clave']; ?></b>
				</td>
				<td style="letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					TURNO
				</td>
				<td style="width: 120px; letter-spacing: 1px; border-bottom: 0.5px solid black; text-align: center; font-family: tahoma; font-size: 12px;">
					<b><?php echo $datMen[0]['Turno']; ?></b>
				</td>
				<td style="letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					MODALIDAD
				</td>
				<td style=" width: 120px; letter-spacing: 1px; border-bottom: 0.5px solid black; text-align: center; font-family: tahoma; font-size: 12px;">
					<b><?php echo $datMen[0]['Modalidad']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style=" padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					SE REUNIÓ EL JURADO INTEGRADO POR LOS CC.
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="width: 90px;  padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					PRESIDENTE:
				</td>
				<td style=" border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					<b>&nbsp; <?php echo $acta[0]['Presidente']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="width: 90px;  padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					SECRETARIO:
				</td>
				<td style=" border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					<b>&nbsp; <?php echo $acta[0]['Secretario']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="width: 90px;  padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					VOCAL:
				</td>
				<td style=" border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					<b>&nbsp; <?php echo $acta[0]['Vocal']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="width: 400px;  padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					PARA REALIZAR EL EXAMEN PROFESIONAL AL (A) C. PASANTE:
				</td>
				<td style=" border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">

				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					<b><?php echo $datUs[0]['Nombre'].' '.$datUs[0]['APaterno'].' '.$datUs[0]['AMaterno']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="width: 180px;  padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					CON NÚMERO DE CONTROL
				</td>
				<td style=" width: 100px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					<b>&nbsp; <?php echo $datUs[0]['Usuario']; ?> &nbsp;</b>
				</td>
				<td style=" letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					&nbsp; A QUIEN SE EXAMINÓ CON BASE A LA OPCIÓN:
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					<b><?php echo $acta[0]['Tipo']; ?></b>
				</td>
			</tr>
		</table>

		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="width: 195px;  padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					PARA OBTENER EL TÍTULO DE:
				</td>
				<td style=" border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					<b>&nbsp; <?php echo $acta[0]['Profesion']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="line-height: 35px; padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					ACTO EFECTUADO DE ACUERDO A LAS NORMAS ESTABLECIDAS POR LA DIRECCIÓN DE EDUCACIÓN SUPERIOR DE LA SUBSECRETARÍA DE EDUCACIÓN ESTATAL, UNA VEZ CONCLUIDO EL EXAMEN EL JURADO DELIBERÓ SOBRE LOS CONOCIMIENTOS Y APTITUDES DEMOSTRADAS Y DETERMINÓ
				</td>

			</tr>
		</table>

		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					<b><?php echo $acta[0]['Estatus']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 5px;'>
			<tr>
				<td style="line-height: 35px; padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					A CONTINUACIÓN EL PRESIDENTE DEL JURADO COMUNICÓ AL (A) C. SUSTENTANTE EL RESULTADO OBTENIDO Y LE TOMÓ PROTESTA DE LEY EN LOS TÉRMINOS SIGUIENTES: ¿PROTESTA USTED EJERCER SU
				</td>
			</tr>
		</table>

		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="width: 100px;  padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					PROFESIÓN DE:
				</td>
				<td style=" border-bottom: 0.5px solid black; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					<b>&nbsp; <?php echo $acta[0]['Profesion']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 13px;'>
			<tr>
				<td style="line-height: 35px; padding-left: 15px; letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 12px;">
					CON ENTUSIASMO Y HONRADEZ. VELAR SIEMPRE POR EL PRESTIGIO Y BUEN NOMBRE DE ESTA ESCUELA Y CONTINUAR ESFORZÁNDOSE POR MEJORAR SU PREPARACIÓN EN TODOS LOS ÓRDENES, PARA GARANTIZAR LOS INTERESES DEL PUEBLO Y DE LA PATRIA?
				</td>

			</tr>
		</table>
		<table style='width: 700px; margin-top: 40px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					¡SÍ PROTESTO!
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 60px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 100px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;"></td>
				<td style="width: 500px; letter-spacing: 1px;  border-bottom: 0.5px solid black; text-align: center; font-family: tahoma; font-size: 12px;"></td>
				<td style="width: 100px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;"></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 5px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					<b><?php echo $datUs[0]['Nombre'].' '.$datUs[0]['APaterno'].' '.$datUs[0]['AMaterno']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 25px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					SI ASÍ LO HICIERE, QUE LA SOCIEDAD Y LA NACIÓN SE LO PREMIEN Y SI NO, SE LO DEMANDEN.
				</td>
			</tr>
		</table>
		<br><br><br>
		<table style='width: 700px; margin-top: 25px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					TERMINANDO EL ACTO SE LEVANTA PARA CONSTANCIA LA PRESENTE ACTA<br>
					FIRMADO DE CONFORMIDAD LOS INTEGRANTES DEL JURADO Y DIRECTOR DEL <br>
					PLANTEL DE DA FE
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 20px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					<b>JURADO DEL EXAMEN</b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 40px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><b>NOMBRE:</b></td>
				<td style="width: 20px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><b>FIRMA:</b></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 40px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="border-bottom: 0.5px solid black; width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><br><br><?php echo $acta[0]['Presidente']; ?></td>
				<td style="width: 20px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="border-bottom: 0.5px solid black; width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><br><br></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 10px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: right; font-family: tahoma; font-size: 11px;">CÉDULA PROFESIONAL No.</td>
				<td style="border-bottom: 0.5px solid black; width: 50px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><?php echo $acta[0]['Cedula1']; ?></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 50px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="border-bottom: 0.5px solid black; width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><?php echo $acta[0]['Secretario']; ?></td>
				<td style="width: 20px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="border-bottom: 0.5px solid black; width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 20px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: right; font-family: tahoma; font-size: 11px;">CÉDULA PROFESIONAL No.</td>
				<td style="border-bottom: 0.5px solid black; width: 50px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><?php echo $acta[0]['Cedula2']; ?></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 50px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="border-bottom: 0.5px solid black; width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><?php echo $acta[0]['Vocal']; ?></td>
				<td style="width: 20px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="border-bottom: 0.5px solid black; width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 20px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: right; font-family: tahoma; font-size: 11px;">CÉDULA PROFESIONAL No.</td>
				<td style="border-bottom: 0.5px solid black; width: 50px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><?php echo $acta[0]['Cedula3']; ?></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 100px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					<b>RECTOR</b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 30px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 150px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;"></td>
				<td style="width: 400px; letter-spacing: 1px;  border-bottom: 0.5px solid black; text-align: center; font-family: tahoma; font-size: 12px;"></td>
				<td style="width: 150px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;"></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 0px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
					<b><?php echo $lstfir[0]['Rector']; ?></b>
				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 100px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="border-bottom: 0.5px solid black; width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><b>JEFA DEL DEPARTAMENTO DE<br>SERVICIOS ESCOLARES</b><br><br><br><br></td>
				<td style="width: 20px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="border-bottom: 0.5px solid black; width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><b>DIRECTOR DE EDUCACIÓN SUPERIOR</b><br><br><br><br></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 0px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><?php echo $lstfir[0]['Departamento']; ?></td>
				<td style="width: 20px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="width: 300px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"><?php echo $lstfir[0]['Educacion_superior']; ?></td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 100px;'>
			<tr>
				<td style="width: 240px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;">

					<table>
						<tr>
							<td style="background-color: #dddddd; padding: 5px; border: 0.5px solid black; width: 220px;  letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 9px;">
								<b>REGISTRO EN EL DEPARTAMENTO DE SERVICIOS<br>ESCOLARES</b>
							</td>
						</tr>
						<tr>
							<td style="padding: 5px; border: 0.5px solid black; width: 220px;  letter-spacing: 1px; text-align: left; font-family: tahoma; font-size: 9px;">
								CON No.
							</td>
						</tr>
						<tr>
							<td style="padding: 5px; border: 0.5px solid black; width: 220px;  letter-spacing: 1px; text-align: left; font-family: tahoma; font-size: 9px;">
								EN EL LIBRO
							</td>
						</tr>
						<tr>
							<td style="padding: 5px; border: 0.5px solid black; width: 220px;  letter-spacing: 1px; text-align: left; font-family: tahoma; font-size: 9px;">
								FOJA
							</td>
						</tr>
						<tr>
							<td style="padding: 5px; border: 0.5px solid black; width: 220px;  letter-spacing: 1px; text-align: left; font-family: tahoma; font-size: 9px;">
								FECHA
							</td>
						</tr>
						<tr>
							<td style="background-color: #dddddd; padding: 5px; border: 0.5px solid black; width: 220px;  letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 9px;">
								COTEJO
							</td>
						</tr>
						<tr>
							<td style=" padding: 5px; border: 0.5px solid black; width: 220px;  letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 9px;">
								<br><br>
							</td>
						</tr>
						<tr>
							<td style="background-color: #dddddd; padding: 5px; border: 0.5px solid black; width: 220px;  letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 9px;">
								JEFE DE OFICINA
							</td>
						</tr>
						<tr>
							<td style=" padding: 5px; border: 0.5px solid black; width: 220px;  letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 9px;">
								<br><br>
							</td>
						</tr>
					</table>
				</td>
				<td style="width: 60px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 11px;"></td>
				<td style="width: 400px;  letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 10px;">
					<table>

						<tr>
							<td colspan="2" style="width: 400px;  letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 10px;">POR ACUERDO DEL SECRETARIO GENERAL DE  GOBIERNO Y CON FUNDAMENTO EN EL ART. 29, FRACCIÓN X, DE
							LA LEY  ORGÁNICA DE LA ADMINISTRACIÓN PÚBLICA DEL ESTADO DE CHIAPAS.<br><br>
							SE  LEGALIZA PREVIO COTEJO CON LA EXISTENCIA EN EL
							CONTROL RESPECTIVO, LA FIRMA QUE ANTECEDE CORRESPONDIENTE AL DIRECTOR DE EDUCACIÓN SUPERIOR.</td>
						</tr>
						<tr>
							<td colspan="2" style="border-bottom: 0.5px solid black; width: 400px;  letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 10px;">
							<br><br><br><?php echo $lstfir[0]['Educacion_superior']; ?></td>
						</tr>
						<tr>
							<td style="width: 190px;  letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 10px;"><br>TUXTLA GUTIÉRREZ, CHIAPAS; A</td>
							<td style="border-bottom: 0.5px solid black; width: 210px;  letter-spacing: 1px; text-align: justify; font-family: tahoma; font-size: 10px;"><br>24 de avbirl de 2022</td>
						</tr>
						<tr>
							<td colspan="2" style="border-bottom: 0.5px solid black; width: 400px;  letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 9px;">
								<br><br><b>SUBSECRETARIO DE ASUNTOS JURÍDICOS</b><br><br>
								<?php echo $lstfir[0]['Coordinadora']; ?>
							<br><br></td>
						</tr>
					</table>


				</td>
			</tr>
		</table>
		<table style='width: 700px; margin-top: 100px;'>
			<tr>
				<td style="width: 0px;  padding-left: 15px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 12px;">
				</td>
				<td style="width: 700px; letter-spacing: 1px; text-align: center; font-family: tahoma; font-size: 9px;">
					ESTE DOCUMENTO NO ES VALIDO SI PRESENTA RASPADURAS O ENMENDADURAS
				</td>
			</tr>
		</table>


	</body>
	<script>
	function imprimir() {
							 if (window.print) {
									 window.print();
							 } else {
									 alert("La función de impresion no esta soportada por su navegador.");
							 }
					 }
	</script>
</html>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

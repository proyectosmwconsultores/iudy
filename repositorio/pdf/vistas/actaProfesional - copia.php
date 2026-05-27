<?php

if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include('numeros.php');
	$t=new Imprimir();
	 $Usuario = "LPC20011"; //substr($_GET["tokenId"], 10, 50); die();
	$_SESSION["Mat"] = $Usuario;
	$datUs=$t->get_datUsuario($Usuario);
	$datMen=$t->get_menDatos($datUs[0]["IdGrupo"]);
	$acta=$t->get_acta_pro($datUs[0]["IdUsua"]);
	$lstfir=$t->get_lstFir($datMen[0]["IdCampus"],$datMen[0]['IdGrado']);

?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--

table {
    font-family: arial;
    border-collapse: collapse;
    width: 100%;
		font-size: 10px;
}

td, th {
    border: 1px solid #3e3e3e;
    padding: 2.3px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="30m" backbottom="12mm" backleft="1mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>
	<img src="../../assets/images/logoImg.png" style="width: 85px; margin-top: 50px; margin-left:50px; position: absolute;">
	<table style="margin-top: -140px;">
	    <tr>
			<td style="width: 765px; text-align: right; border: none; font-size: 9px;"><b>AEP-16-2021</b></td>
		</tr>
		<tr>
			<td style="width: 765px; text-align: center; font-size: 14px; border: none;">
			    <b>GOBIERNO DEL ESTADO DE CHIAPAS</b><br>
				<b>SECRETARÍA DE EDUCACIÓN</b><br>
				<b>SUBSECRETARÍA DE EDUCACIÓN ESTATAL</b><br>
				<b style="font-size: 13px;">DIRECCIÓN DE EDUCACIÓN SUPERIOR</b><br>
				<b style="font-size: 12px;">DEPARTAMENTO DE SERVICIOS ESCOLARES</b>
			</td>
		</tr>
		<tr>
			<td style="width: 765px; text-align: center; font-size: 9px; border: none;">
			    <b>RVOE:</b> ACUERDO NÚMERO <?php echo $datMen[0]['Rvoe']; ?> &nbsp;&nbsp;&nbsp;&nbsp; <b>VIGENTE:</b> A PARTIR DE <?php echo $datMen[0]['Vigencia']; ?>
			</td>
		</tr>
	</table><br>
	<table style='margin-left: 150px;'>
		<tr>
			<td style='width: 460px; text-align: center; border: none;'><b>RÉGIMEN: PARTICULAR </b></td>
			<td style='width: 40px; text-align: right; border: none;'>No.</td>
			<td style='width: 60px; text-align: center; border-top: none; border-right: none;'><?php echo $acta[0]['Folio']; ?></td>
		</tr>
	</table><br>
	<table>
		<tr>
		<td style="width: 180; text-align: left; font-size: 13px; border: none;">
		<img src="../../assets/images/fondoImg.png" style="width: 100px; margin-left: 30px; margin-top: -15px;">
		</td>
			<td style="width: 565px; text-align: justify; font-size: 13px; border: none; ">
			    <table>
			        <tr>
			            <td colspan='5' style="width: 360px; border: none; height: 10px;">ACTA &nbsp;&nbsp;&nbsp; DE &nbsp;&nbsp;&nbsp; EXAMEN &nbsp;&nbsp;&nbsp; PROFESIONAL &nbsp;&nbsp;&nbsp; No.<?php echo $acta[0]['No']; ?> &nbsp;&nbsp;&nbsp; AUTORIZACIÓN </td>
			            <td style="border: 0.6px solid black; width: 160px; border-top: none; border-right: none; ">&nbsp;&nbsp;&nbsp;<b><?php echo $acta[0]['Autorizacion']; ?></b></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none;"></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none;"></td>
			        </tr>

			        <tr>
			            <td colspan='3' style="width: 90px; border: none;height: 10px; ">EN LA CIUDAD DE</td>
			            <td colspan='3' style="border: 0.6px solid black; width: 300px; border-right: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $acta[0]['Ciudad']; ?></b></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none; "></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none;"></td>
			        </tr>

			        <tr>
			            <td colspan='2' style="width: 70px; border: none; height: 10px;">SIENDO LAS </td>
			            <td colspan='2' style="border: 0.6px solid black; width: 190px; border-right: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $acta[0]['Hora']; ?></b></td>
			            <td style="width: 85px; border-bottom: none; border-right: none;">HORAS DEL DÍA</td>
			            <td style="border: 0.6px solid black; width: 160px; border-right: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $acta[0]['Dia']; ?></b></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none; "></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none;"></td>
			        </tr>
			        <tr>
			            <td colspan='2' style="width: 70px; border: none; height: 10px;">DEL MES DE </td>
			            <td colspan='4' style="border: 0.6px solid black; width: 390px; border-right: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $acta[0]['Mes']; ?></b></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none; "></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none;"></td>
			        </tr>
			        <tr>
			            <td colspan='2' style="width: 70px; border: none; height: 10px;">DE DOS MIL </td>
			            <td colspan='4' style="border: 0.6px solid black; width: 390px; border-right: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $acta[0]['Anio']; ?></b></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none; "></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none;"></td>
			        </tr>
			        <tr>
			            <td style="width: 20px; border: none; height: 10px;">EN </td>
			            <td colspan='5' style="border: 0.6px solid black; width: 390px; border-right: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $acta[0]['Auditorio']; ?></b></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none; "></td>
			        </tr>
			        <tr>
			            <td colspan='6' style="width: 360px; border: none;"></td>
			        </tr>
			        <tr>
			            <td style="width: 20px; border: none; height: 10px;">DE </td>
			            <td colspan='5' style="border: 0.6px solid black; width: 390px; border-right: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $acta[0]['Escuela']; ?></b> </td>
			        </tr>
			        <tr>
			            <td style="width: 20px; border: none;"></td>
			            <td style="width: 40px; border-right: none; border-bottom: none;"></td>
			            <td style="width: 20px; border-right: none; border-bottom: none;"></td>
			            <td style="width: 170px; border-right: none; border-bottom: none;"></td>
			            <td style="width: 85px; border-right: none; border-bottom: none;"></td>
			            <td style="width: 160px; border-right: none; border-bottom: none;"></td>
			        </tr>
			    </table>
			</td>
		</tr>
	</table><br>
	<table style="margin-left: 35px;">
	    <tr>
	        <td colspan='2' style="width: 80px; height: 10px; border: none;">CON CLAVE</td>
	        <td style="border: 0.6px solid black; width: 95px; text-align: center; border-top: none; border-right: none;"><b><?php echo $datMen[0]['Clave']; ?></b></td>
	        <td style="width: 100px; text-align: center; border: none; ">TURNO</td>
	        <td style="border: 0.6px solid black; width: 125px; text-align: center; border-top: none; border-right: none;"><b><?php echo $datMen[0]['Turno']; ?></b></td>
	        <td style="width: 100px; text-align: center; border: none; ">MODALIDAD</td>
	        <td style="border: 0.6px solid black; width: 145px; text-align: center; border-top: none; border-right: none;"><b><?php echo $datMen[0]['Modalidad']; ?></b></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>

	    <tr>
	        <td colspan='7' style="width: 400px; height: 10px; border-left: none; border-bottom: none; border-right: none;">SE REUNIÓ EL JURADO INTEGRADO POR LOS CC.</td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='2' style="width: 80px; height: 10px; border: none; ">PRESIDENTE:</td>
	        <td colspan='5' style="border: 0.6px solid black; width: 300px; border-right: none;"><b><?php echo $acta[0]['Presidente']; ?></b></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='2' style="width: 80px; height: 10px; border: none;">SECRETARIO:</td>
	        <td colspan='5' style="border: 0.6px solid black; width: 300px; border-right: none;"><b><?php echo $acta[0]['Secretario']; ?></b></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td style="width: 40px; height: 10px; border: none;">VOCAL:</td>
	        <td colspan='6' style="border: 0.6px solid black; width: 300px; border-right: none;"><b><?php echo $acta[0]['Vocal']; ?></b></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='5' style="width: 350px; height: 10px; border: none;">PARA &nbsp; REALIZAR &nbsp; EL &nbsp; EXAMEN &nbsp; PROFESIONAL &nbsp; AL (A) C. SUSTENTANTE:</td>
	        <td colspan='2' style="border: 0.6px solid black; width: 200px; border-right: none; "></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='7' style="border: 0.6px solid black; width: 500px; height: 10px; border-left: none; border-right: none; text-align: center; "><b><?php echo $datUs[0]['Nombre'].' '.$datUs[0]['APaterno'].' '.$datUs[0]['AMaterno']; ?></b></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='3' style="width: 150px; height: 10px; border: none;">CON &nbsp;&nbsp; NÚMERO &nbsp;&nbsp; DE &nbsp;&nbsp; CONTROL</td>
	        <td style=" border: 0.6px solid black; width: 100px; border-right: none; text-align: center; "><b><?php echo $Usuario; ?></b></td>
	        <td colspan='3'style="width: 300px; border-bottom: none; border-right: none; ">A &nbsp; QUIEN &nbsp;SE &nbsp; EXAMINÓ &nbsp; CON &nbsp; BASE &nbsp; A &nbsp; LA &nbsp; OPCIÓN:</td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='7' style="border: 0.6px solid black; width: 500px; border-left: none; border-right: none; text-align: center;"><b><?php echo $acta[0]['Tipo']; ?></b></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='3' style="width: 170px; height: 10px; border: none;"><br>PARA OBTENER EL GRADO DE:</td>
	        <td colspan='4' style="border: 0.6px solid black; width: 440px; border-right: none;"><b><?php echo $acta[0]['Profesion']; ?></b></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='7' style="width: 600px; border: none;">
	            ACTO &nbsp;&nbsp; EFECTUADO &nbsp;&nbsp;&nbsp; DE &nbsp; ACUERDO &nbsp;&nbsp;&nbsp; A &nbsp;&nbsp; LAS &nbsp;&nbsp; NORMAS &nbsp;&nbsp;&nbsp; ESTABLECIDAS &nbsp; &nbsp;&nbsp; POR &nbsp;&nbsp;&nbsp; LA &nbsp;&nbsp;&nbsp; DIRECCIÓN &nbsp;&nbsp; DE &nbsp;&nbsp; EDUCACIÓN &nbsp;&nbsp;&nbsp; SUPERIOR &nbsp;&nbsp;&nbsp; DE <br><br> LA &nbsp;&nbsp;&nbsp;
	            SUBSECRETARÍA &nbsp;&nbsp;&nbsp; DE &nbsp;&nbsp;&nbsp; EDUCACIÓN &nbsp;&nbsp; ESTATAL, &nbsp;&nbsp; UNA &nbsp;&nbsp; VEZ &nbsp; CONCLUIDO &nbsp;&nbsp;&nbsp; EL &nbsp;&nbsp;&nbsp; EXAMEN &nbsp;&nbsp; EL &nbsp;&nbsp;&nbsp; JURADO &nbsp;&nbsp; DELIBERÓ &nbsp;&nbsp;&nbsp; SOBRE &nbsp;&nbsp;&nbsp; LOS  <br><br>CONOCIMIENTOS &nbsp;&nbsp;
	            Y &nbsp;&nbsp;APTITUDES &nbsp;&nbsp; DEMOSTRADAS &nbsp;&nbsp; Y &nbsp;&nbsp; DETERMINÓ
	        </td>
	    </tr>

	    <tr>
	        <td colspan='7' style="border: 0.6px solid black; width: 500px; text-align: center; height: 10px; border-left: none; border-right: none; text-align: center; "><b><?php echo $acta[0]['Estatus']; ?></b> </td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='7' style="width: 500px; border: none;"><br><br>
	            A &nbsp;&nbsp;&nbsp; CONTINUACIÓN, &nbsp;&nbsp;&nbsp;&nbsp; EL &nbsp;&nbsp;&nbsp; PRESIDENTE &nbsp;&nbsp;&nbsp;&nbsp; DEL &nbsp;&nbsp;&nbsp;&nbsp; JURADO &nbsp;&nbsp;&nbsp;&nbsp; COMUNICÓ &nbsp;&nbsp;&nbsp;&nbsp; AL &nbsp;&nbsp;&nbsp;&nbsp; (A) C. &nbsp;&nbsp;&nbsp;&nbsp; SUSTENTANTE &nbsp;&nbsp;&nbsp; &nbsp;EL &nbsp;&nbsp;&nbsp; RESULTADO &nbsp;&nbsp;&nbsp;OBTENIDO <br><br> Y  &nbsp;&nbsp;
	             LE &nbsp;&nbsp; TOMÓ &nbsp;&nbsp; PROTESTA &nbsp;&nbsp; DE &nbsp;&nbsp; LEY &nbsp;&nbsp; EN &nbsp;&nbsp; LOS &nbsp;&nbsp; TÉRMINOS &nbsp;&nbsp; SIGUIENTES: &nbsp;&nbsp; ¿PROTESTA &nbsp;&nbsp; USTED &nbsp;&nbsp; EJERCER &nbsp;&nbsp; SU &nbsp;&nbsp; PROFESIÓN &nbsp;&nbsp; DE:
	        </td>
	    </tr>

	    <tr>
	        <td colspan='7' style=" border: 0.6px solid black; width: 500px; text-align: center; height: 10px; border-left: none; border-right: none;"><b><?php echo $acta[0]['Profesion']; ?></b></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='7' style="width: 500px; border: none;"><br><br>
	            CON &nbsp;&nbsp;&nbsp; ENTUSIASMO &nbsp;&nbsp;&nbsp; &nbsp;Y &nbsp;&nbsp;&nbsp; HONRADEZ. &nbsp;&nbsp;&nbsp; VELAR &nbsp;&nbsp;&nbsp; SIEMPRE &nbsp;&nbsp;&nbsp; POR &nbsp;&nbsp;&nbsp; EL &nbsp;&nbsp;&nbsp; PRESTIGIO &nbsp;&nbsp;&nbsp; Y &nbsp;&nbsp;&nbsp; BUEN &nbsp;&nbsp;&nbsp; NOMBRE &nbsp;&nbsp;&nbsp; DE &nbsp;&nbsp;&nbsp; ESTA &nbsp;&nbsp;&nbsp; ESCUELA &nbsp;&nbsp;&nbsp; Y <br><br>
	            CONTINUAR &nbsp;&nbsp;&nbsp; ESFORZÁNDOSE &nbsp;&nbsp;&nbsp; POR &nbsp;&nbsp;&nbsp; MEJORAR &nbsp;&nbsp;&nbsp; SU &nbsp;&nbsp;&nbsp; PREPARACIÓN &nbsp;&nbsp;&nbsp; EN &nbsp;&nbsp;&nbsp; TODOS &nbsp;&nbsp;&nbsp; LOS &nbsp;&nbsp;&nbsp; ÓRDENES, &nbsp;&nbsp;&nbsp; PARA &nbsp;&nbsp;&nbsp; GARANTIZAR &nbsp;&nbsp;&nbsp; LOS <br><br>
	            INTERESES  &nbsp;&nbsp;&nbsp; DEL  &nbsp;&nbsp;&nbsp; PUEBLO  &nbsp;&nbsp;&nbsp; Y  &nbsp;&nbsp;&nbsp;&nbsp; DE  &nbsp;&nbsp;&nbsp; LA  &nbsp;&nbsp;&nbsp; PATRIA?
	        </td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='7' style="width: 500px; text-align: center; height: 10px; border: none;"> <br><br>¡SI PROTESTO!<br><br></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='7' style="width: 500px; text-align: center; border: none;"><br>_______________________________________________
	        <br><br><b><?php echo $datUs[0]['Nombre'].' '.$datUs[0]['APaterno'].' '.$datUs[0]['AMaterno']; ?></b></td>
	    </tr>
	    <tr><td colspan='7' style="width: 400px; border: none;"></td></tr><tr><td colspan='7' style="width: 400px; border: none;"></td></tr>
	    <tr>
	        <td colspan='7' style="width: 500px; text-align: center; border: none;"><br><br> SI &nbsp; ASÍ &nbsp;LO &nbsp; HICIERE, &nbsp; QUE &nbsp; LA &nbsp; SOCIEDAD &nbsp; Y &nbsp; LA &nbsp; NACIÓN &nbsp; SE &nbsp; LO &nbsp; PREMIEN &nbsp; Y &nbsp; SI &nbsp; NO, &nbsp; SE &nbsp; LO &nbsp; DEMANDEN.</td>
	    </tr>

	    <tr>
	        <td style="width: 40px; border: none;"></td>
	        <td style="width: 40px; border: none;"></td>
	        <td style="width: 95px; border: none;"></td>
	        <td style="width: 100px; border: none;"></td>
	        <td style="width: 125px; border: none;"></td>
	        <td style="width: 100px; border: none;"></td>
	        <td style="width: 145px; border: none;"></td>
	    </tr>


	</table>
	<br><br><br><br><br><br><br><br><br>
	<table style="margin-left: 35px;">
	    <tr style='font-weight: bold;'>
	        <td colspan='5' style="width: 400px; text-align: center; font-size: 12px; border: none; ">
					TERMINADO EL ACTO SE LEVANTA PARA CONSTANCIA LA PRESENTE ACTA <br>
					FIRMANDO DE CONFORMIDAD LOS INTEGRANTES DEL JURADO Y DIRECTOR DEL<br>
					PLANTEL DE DA FE
					</td>
	    </tr>
			<tr style='font-weight: bold;'>
	        <td colspan='5' style="width: 400px; height: 30px; text-align: center; font-size: 12px; border: none; ">
					JURADO DEL EXAMEN
					</td>
	    </tr>
			<tr style='font-weight: bold;'>
	        <td colspan='2' style="width: 300px; text-align: center; height: 30px; border: none;">NOMBRE:</td>
	        <td style="width: 12px; text-align: center; border: none; "></td>
					<td colspan='2' style="width: 300px; text-align: center; border: none;">FIRMA:</td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; border-left: none; border-right: none;"><?php echo $acta[0]['Presidente']; ?></td>
	        <td style="width: 12px; text-align: center; border: none;  "></td>
	        <td colspan='2' style="width: 300px; text-align: center; border-right: none; "></td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; border-left: none; border-right: none; border-bottom: none; ">PRESIDENTE</td>
	        <td style="width: 12px; text-align: center; border: none; "></td>
					<td style="width: 158px; text-align: right; border-right: none; border-bottom: none;">CEDULA PROF. No</td>
	        <td style="width: 158px; text-align: center; border-right: none;"><?php echo $acta[0]['Cedula1']; ?></td>
	    </tr>
			<tr>
	        <td colspan='5' style="width: 400px; height: 50px; text-align: center; font-size: 12px; border-left: none; border-right: none; border-bottom: none;"></td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; border-left: none; border-right: none; "><?php echo $acta[0]['Secretario']; ?></td>
	        <td style="width: 12px; text-align: center; border: none;  "></td>
	        <td colspan='2' style="width: 300px; text-align: center; border-right: none;"></td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; border-left: none; border-right: none; border-bottom: none;">SECRETARIO</td>
	        <td style="width: 12px; text-align: center; border: none; "></td>
					<td style="width: 158px; text-align: right; border-right: none; border-bottom: none;">CEDULA PROF. No</td>
	        <td style="width: 158px; text-align: center; border-right: none;"><?php echo $acta[0]['Cedula2']; ?></td>
	    </tr>
			<tr>
	        <td colspan='5' style="width: 400px; height: 50px; text-align: center; font-size: 12px; border-left: none; border-right: none; border-bottom: none;"></td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; border-left: none; border-right: none; "><?php echo $acta[0]['Vocal']; ?></td>
	        <td style="width: 12px; text-align: center; border: none; "></td>
	        <td colspan='2' style="width: 300px; text-align: center; border-right: none;"></td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; border-left: none; border-right: none; border-bottom: none;">VOCAL</td>
	        <td style="width: 12px; text-align: center; border: none; "></td>
					<td style="width: 158px; text-align: right; border-right: none; border-bottom: none;">CEDULA PROF. No</td>
	        <td style="width: 158px; text-align: center; border-right: none;"><?php echo $acta[0]['Cedula3']; ?></td>
	    </tr>
			<tr>
	        <td colspan='5' style="width: 400px; height: 90px; text-align: center; font-size: 12px; border-left: none; border-right: none; border-bottom: none;"></td>
	    </tr>
			<tr>
	        <td colspan='5' style="border:none; font-weight: bold; width: 400px; height: 60px; text-align: center; font-size: 12px; ">DIRECTOR DEL PLANTEL<br><br><br><br>_______________________________________________</td>
	    </tr>
			<tr>
	        <td colspan='5' style="border:none; width: 400px; text-align: center; font-size: 12px; "><?php echo $lstfir[0]['Rector']; ?></td>
	    </tr>
			<tr>
	        <td colspan='5' style="width: 400px; height: 60px; text-align: center; font-size: 12px; border-left: none; border-right: none; border-bottom: none;"></td>
	    </tr>
			<tr style='font-weight: bold;'>
	        <td colspan='2' style=" border: none; width: 300px; text-align: center; height: 50px; ">JEFA DEL DEPARTAMENTO DE<br> SERVICIOS ESCOLARES</td>
	        <td style="width: 12px; text-align: center; border: none; "></td>
					<td colspan='2' style="border: none;  width: 300px; text-align: center; ">DIRECTOR DE EDUCACIÓN SUPERIOR</td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; border-left: none; border-right: none;"></td>
	        <td style="border: none;  width: 12px; text-align: center; "><br><br><br><br></td>
					<td colspan='2' style="width: 300px; text-align: center; border-right: none;"></td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; border-left: none; border-right: none; border-bottom: none; "><?php echo $lstfir[0]['Departamento']; ?></td>
	        <td style="border: none; width: 12px; text-align: center; "></td>
					<td colspan='2' style="width: 300px; text-align: center; border-right: none; border-bottom: none;"><?php echo $lstfir[0]['Educacion_superior']; ?></td>
	    </tr>
			<tr>
	        <td style="width: 158px; text-align: center; border: none; "></td>
	        <td style="width: 158px; text-align: center; border: none;"></td>
	        <td style="width: 12px; text-align: center; border: none;"></td>
					<td style="width: 158px; text-align: center;border: none; "></td>
	        <td style="width: 158px; text-align: center; border: none;"></td>
	    </tr>

	</table><br><br><br><br><br>
	<table style="margin-left: 35px; font-weight: bold;">
			<tr>
	        <td rowspan='6' style="width: 250px; text-align: center; border: none; ">
						<table style='font-size: 12px; margin-left: 20px;'>
							<tr><td style='width: 150px; padding: 5px;'>REGISTRO EN EL DEPARTAMENTO DE SERVICIOS<br>ESCOLARES</td></tr>
							<tr><td style='width: 150px; padding: 5px; text-align: left;'>CON No.</td></tr>
							<tr><td style='width: 150px; padding: 5px; text-align: left;'>EN EL LIBRO</td></tr>
							<tr><td style='width: 150px; padding: 5px; text-align: left;'>FOJA</td></tr>
							<tr><td style='width: 150px; padding: 5px; text-align: left;'>FECHA</td></tr>
							<tr><td style='width: 150px; padding: 5px; text-align: center;'>COTEJO</td></tr>
							<tr><td style='width: 150px; padding: 5px; text-align: left;'><br><br></td></tr>
							<tr><td style='width: 150px; padding: 5px; text-align: center;'>JEFE DE OFICINA</td></tr>
							<tr><td style='width: 150px; padding: 5px; text-align: center;'><br><br></td></tr>
						</table>
					</td>
	        <td rowspan='6' style="width: 50px; text-align: center; border: none;"></td>
	        <td colspan='2' style="width: 300px; text-align: justify; font-size: 10px; font-weight: bold; border: none;">
					POR &nbsp; ACUERDO &nbsp; DEL &nbsp; SECRETARIO &nbsp; GENERAL &nbsp; DE &nbsp; GOBIERNO Y CON &nbsp; FUNDAMENTO &nbsp; EN &nbsp; EL &nbsp; ART. 29, &nbsp; FRACCIÓN X, DE
					LA &nbsp; LEY  &nbsp; ORGÁNICA &nbsp; DE LA &nbsp; ADMINISTRACIÓN &nbsp; PÚBLICA &nbsp; DEL &nbsp; ESTADO &nbsp; DE &nbsp; CHIAPAS.<br><br>
					SE  LEGALIZA PREVIO COTEJO CON LA EXISTENCIA EN EL
					CONTROL RESPECTIVO, LA FIRMA QUE ANTECEDE CORRESPONDIENTE AL DIRECTOR DE EDUCACIÓN SUPERIOR.
					</td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; font-weight: bold; border-left: none; border-right: none;">
					<br><br><?php echo $lstfir[0]['Educacion_superior']; ?>
					</td>
	    </tr>
			<tr>
					<td style="width: 171px; font-size: 10px; text-align: left; border-left: none; border-right: none; border-bottom: none; "><br>TUXTLA GUTIERREZ, CHIAPAS; A</td>
	        <td style="width: 171px; text-align: center; border-right: none; "></td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; font-size: 12px; font-weight: bold; border-left: none; border-right: none; ">
					<br><br>COORDINADORA DE ASUNTOS JURÍDICOS DE GOBIERNO<br><br>
					</td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; text-align: center; font-weight: bold; border-left: none; border-right: none; border-bottom: none; ">
					<?php echo $lstfir[0]['Coordinadora']; ?>
					</td>
	    </tr>
			<tr>
	        <td colspan='2' style="width: 300px; border:none;"></td>
	    </tr>
			<tr>
	        <td colspan='4' style="width: 250px; text-align: center; border:none;"><br><br>ESTE DOCUMENTO NO ES VALIDO SI PRESENTA RASPADURAS O ENMENDADURAS</td>
	    </tr>
			<tr>
	        <td style="width: 250px; text-align: center; border:none;"></td>
	        <td style="width: 50px; text-align: center; border:none;"></td>
					<td style="width: 171px; text-align: center; border:none;"></td>
	        <td style="width: 171px; text-align: center; border:none;"></td>
	    </tr>
	</table>









	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->



	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

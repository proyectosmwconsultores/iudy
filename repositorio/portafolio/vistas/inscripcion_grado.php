<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	include('../hace_fecha.php');
	include('../pdf/vistas/importe.php');
	$t=new Imprimir();
	$IdUsua = substr($_GET['idToks'], 10, 10);
	$docs=$t->get_docs_id($IdUsua);
	$user=$t->get_usuario_id($IdUsua);
	$px = $user[0]['P_civil'];
	$grad = $user[0]['IdGrado'];
	if($px == 1){ $_pcx = "SOLTERO"; } elseif($px == 2){ $_pcx = "CASADO"; } elseif($px == 3){ $_pcx = "UNIÓN LIBRE"; } elseif($px == 5){ $_pcx = "VIUDO"; } elseif($px == 4){ $_pcx = "DIVORCIADO"; }
	if($grad == 1){ $txtM_1 = 'DOCTORANTE'; $txtnx_1 = 'doctorante'; $txtMi_1 = 'doctorado'; $docsx1 = 'maestría'; }
	if($grad == 2){ $txtM_1 = 'MAESTRANTE'; $txtnx_1 = 'maestrante'; $txtMi_1 = 'maestría'; $docsx1 = 'licenciatura'; }
	if($grad == 3){ $txtM_1 = 'LICENCIADO'; $txtnx_1 = 'licenciado'; $txtMi_1 = 'licenciatura'; $docsx1 = 'bachillerato'; }


?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
		font-size: 12px;

}

td, th {
    border: 0.5px solid black;
    padding: 2px;
}


-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="38mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<table style="margin-left: 42px; margin-top: 15px;">
		<tr>
			<td style="border: none; width: 330px; height: 80px; text-align: center;"><img src="../../assets/images/campus/obtencion_grado.png" style="width: 200px;" ></td>
			<td style="border: none; width: 330px; heifht: 80px; text-align: center; font-size: 13px;"><b>PROCESO DE OBTENCIÓN DEL GRADO DE <?php echo $user[0]['_Grado']; ?> POR <?php echo $user[0]['Nombre_titulacion']; ?> <br>CICLO ESCOLAR <?php echo $user[0]['Periodo']; ?></b></td>
		</tr>
	</table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

<img src="../../assets/images/campus/hoja_abajo.png" style="width: 100%;" >

	</page_footer>
	<table style="font-size: 12px; margin-left: 4px;">
			<tr>
				<td colspan="3" style="width: 600px; text-align: center; border-left: none; border-top: none; border-right: none;"><?php echo $user[0]['Educativa']; ?></td>
			</tr>
			<tr>
				<td colspan="3" style="width: 600px; text-align: center; height: 20px; border-left: none; border-bottom: none; border-right: none;"></td>
			</tr>
			<tr>
				<td style="width: 217px; text-align: center; border-left: none; border-top: none; border-right: none;"><?php echo $user[0]['APaterno']; ?></td>
				<td style="width: 217px; text-align: center; border-top: none; border-right: none;"><?php echo $user[0]['AMaterno']; ?></td>
				<td style="width: 217px; text-align: center; border-top: none; border-right: none;"><?php echo $user[0]['Nombre']; ?></td>
			</tr>
			<tr>
				<td style="width: 217px; text-align: center; border-left: none; border-bottom: none; border-right: none;"><b>APELLIDO PATERNO</b></td>
				<td style="width: 217px; text-align: center; border-bottom: none; border-right: none;"><b>APELLIDO MATERNO</b></td>
				<td style="width: 217px; text-align: center; border-bottom: none; border-right: none;"><b>NOMBRE (S)</b></td>
			</tr>
	</table>
	<table style="font-size: 10px; margin-left: 4px; margin-top: 25px;">
			<tr>
				<td style="width: 90px; border: none;"><b>DIRECCIÓN:</b></td>
				<td style="width: 310px; border-top: none; border-right: none;"><?php echo $user[0]['D_direccion']; ?></td>
				<td style="width: 10px; border: none;"></td>
				<td style="width: 100px; border: none;"><b>TELÉFONO:</b></td>
				<td style="width: 124px; border-top: none; border-right: none;"><?php echo $user[0]['Telefono']; ?></td>
			</tr>
	</table>
	<table style="font-size: 10px; margin-left: 4px; margin-top: 12px;">
			<tr>
				<td style="width: 90px; border: none;"><b>TRABAJO:</b></td>
				<td style="width: 310px; border-top: none; border-right: none;"><?php echo $user[0]['Trabaja']; ?></td>
				<td style="width: 10px; border: none;"></td>
				<td style="width: 100px; border: none;"><b>CELULAR:</b></td>
				<td style="width: 124px; border-top: none; border-right: none;"><?php echo $user[0]['Tel_trabajo']; ?></td>
			</tr>
	</table>
	<table style="font-size: 10px; margin-left: 4px; margin-top: 12px;">
			<tr>
				<td style="width: 140px; border: none;"><b>CORREO ELECTRÓNICO:</b></td>
				<td style="width: 260px; border-top: none; border-right: none;"><?php echo $user[0]['Telefono']; ?></td>
				<td style="width: 10px; border: none;"></td>
				<td style="width: 100px; border: none;"><b>TEL. TRABAJO:</b></td>
				<td style="width: 124px; border-top: none; border-right: none;"><?php echo $user[0]['Correo']; ?></td>
			</tr>
	</table>
	<table style="font-size: 10px; margin-left: 4px; margin-top: 12px;">
			<tr>
				<td style="width: 300px; border: none;"><b>ESTADO CIVIL:</b> <?php echo $_pcx; ?></td>
				<td style="width: 350px; border: none;"><b>ECONÓMICAMENTE DEPENDO DE:</b> <?php echo $user[0]['P_depende']; ?></td>
			</tr>
	</table>
	<br><br><br><br>
	<table style="margin-left: 5px; font-size: 9px;">
		<tr>
			<td style="width: 258px; text-align: center; height: 25px;"><b>DOCUMENTACIÓN QUE PRESENTA EL DOCTORANTE<br>
			ENTREGADA (E)<br>PENDIENTE (P)
			</b></td>
			<td style="width: 10px; text-align: center;"><b>E</b></td>
			<td style="width: 10px; text-align: center;"><b>P</b></td>
		</tr>
		<?php for ($d1=0;$d1<=4; $d1++) { ?>
		<tr>
			<td style="width: 258px; text-align: left; height: 20px; border-bottom: none; padding-left: 10px;"><b><?php echo $docs[$d1]['Nombre']; ?></b></td>
			<td style="width: 10px; text-align: center; border-bottom: none;"><b>( )</b></td>
			<td style="width: 10px; text-align: center; border-bottom: none;"><b>( )</b></td>
		</tr><?php } ?>
		<tr>
			<td style="width: 258px;"></td>
			<td style="width: 10px;"></td>
			<td style="width: 10px;"></td>
		</tr>
	</table>

	<table style="margin-left: 370px; font-size: 9px; margin-top: -184px;">
		<tr>
			<td style="width: 258px; text-align: center; height: 25px;"><b>DOCUMENTACIÓN QUE PRESENTA EL DOCTORANTE<br>
			ENTREGADA (E)<br>PENDIENTE (P)
			</b></td>
			<td style="width: 10px; text-align: center;"><b>E</b></td>
			<td style="width: 10px; text-align: center;"><b>P</b></td>
		</tr>
		<?php for ($d1=5;$d1<=9; $d1++) { if(isset($docs[$d1])){ ?>
		<tr>
			<td style="width: 258px; text-align: left; height: 20px; border-bottom: none; padding-left: 10px;"><b><?php echo $docs[$d1]['Nombre']; ?></b></td>
			<td style="width: 10px; text-align: center; border-bottom: none;"><b>( )</b></td>
			<td style="width: 10px; text-align: center; border-bottom: none;"><b>( )</b></td>
		</tr><?php } } ?>
		<tr>
			<td style="width: 258px; text-align: left; height: 20px; border-bottom: none; padding-left: 10px;"><b>BOLETAS DE PAGO DE HACIENDA DE EXAMEN DE GRADO</b></td>
			<td style="width: 10px; text-align: center; border-bottom: none;"><b>( )</b></td>
			<td style="width: 10px; text-align: center; border-bottom: none;"><b>( )</b></td>
		</tr>
		<tr>
			<td style="width: 258px; text-align: left; height: 20px; border-bottom: none; padding-left: 10px;"><b>BOLETAS DE PAGO DE HACIENDA DE TITULO DE GRADO</b></td>
			<td style="width: 10px; text-align: center; border-bottom: none;"><b>( )</b></td>
			<td style="width: 10px; text-align: center; border-bottom: none;"><b>( )</b></td>
		</tr>
		<tr>
			<td style="width: 258px;"></td>
			<td style="width: 10px;"></td>
			<td style="width: 10px;"></td>
		</tr>
	</table>


	<table style="font-size: 10px; margin-left: 4px; margin-top: 50px; text-align: center;">
			<tr>
				<td style="width: 663px; border: none; height: 20px;"><b>PRESENTAR ORIGINAL Y COPIA EN REDUCCIÓN TAMAÑO CARTA DE CADA DOCUMENTO DE AMBOS LADOS.</b></td>
			</tr>
			<tr>
				<td style="width: 600px; border: none; height: 20px;">NOTA: Verificar que los certificados en caso de ser de otro estado se encuentren certificados por la S.E.P. del estado de origen.</td>
			</tr>
			<tr>
				<td style="width: 600px; border: none; height: 20px; text-align: right;">TUXTLA GUTIÉRREZ CHIAPAS, A <?php echo obtFechMay($user[0]['Fecha_titulacion']); ?></td>
			</tr>
	</table>
	<table style="font-size: 10px; margin-left: 4px; margin-top: 40px;">
			<tr>
				<td style="width: 180px; text-align: center; border-left: none; border-top: none; border-right: none;"><b>DOCTORANTE</b><br><br><br><br><br><br><br></td>
				<td style="width: 282px; border: none;"></td>
				<td style="width: 180px; text-align: center; border-top: none; border-right: none;"><b>VTO. BNO.</b><br><br><br><br><br><br><br></td>
			</tr>
			<tr>
				<td style="width: 180px; text-align: center; border-left: none; border-bottom: none; border-right: none;"><b>FIRMA</b></td>
				<td style="width: 282px; border: none;"></td>
				<td style="width: 180px; text-align: center; border-bottom: none; border-right: none;"><b>DIRECCIÓN GENERAL</b></td>
			</tr>
	</table>
	<br><br><br><br><br><br><br><br><br><br><br><br><br>
	<table style="font-size: 9px; margin-left: 4px;">
			<tr>
				<td colspan='4' style="width: 680px; text-align: center; border: none;"><b>
					CONTRATO DE PRESTACION DE SERVICIOS EDUCATIVOS<br>
					PARA LA TITULACIÓN POR LA OPCIÓN “<?php echo $user[0]['Nombre_titulacion']; ?>”
					</b>
				</td>
			</tr>
			<tr>
				<td colspan="4" style="width: 680px; text-align: justify; border: none;">
					Con fundamento a lo previsto en el acuerdo celebrado entre la Secretaría de Comercio y Fomento Industrial, Secretaría de Educación y Procuraduría Federal del Consumidor de fecha 10 de Marzo de 1992, La Escuela Nacional de Protección Civil, Campus Chiapas con clave 07PSU0234U, que en lo sucesivo se le denominará “La Universidad”, por una parte y por la otra el egresado del Doctorado, que en lo sucesivo se le denominará “<b>EL <?php echo $txtM_1; ?></b>”, convienen en celebrar contrato de prestación de servicios educativos, para efecto de obtener el acta de examen de grado, tramitación, expedición y registro del título, bajo el tenor de las cláusulas siguientes:
				</td>
			</tr>
			<tr>
				<td colspan="4" style="width: 680px; height: 15px; text-align: center; border: none;">
					=========================== CLÁUSULAS ==========================
				</td>
			</tr>

			<tr>
				<td colspan="4" style="width: 680px; text-align: justify; border: none;">
				<b>PRIMERA:</b> La Universidad declara:
				</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;">I.</td>
				<td colspan="3" style="width: 620px; text-align: justify; border: none;">Que se dedica a impartir enseñanza en el nivel superior según clave arriba citada.</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;">II.</td>
				<td colspan="3" style="width: 620px; text-align: justify; border: none;">Que, para efecto de Titulación, Expedición y Registro del Título de grado, se crea el presente contrato.</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;">III.</td>
				<td colspan="3" style="width: 620px; text-align: justify; border: none;">El presente contrato es válido para los egresados de la Universidad en el nivel de <?php echo $txtMi_1; ?> que obtiene el grado académico por la opción de <b style="text-transform: lowercase; "><?php echo $user[0]['Nombre_titulacion']; ?></b>. </td>
			</tr>
			<tr>
				<td colspan="4" style="width: 680px; text-align: justify; border: none;">
				<b>SEGUNDA:</b><br>
				Para el proceso de titulación deberás cubrir la cantidad de: <b>$ <?php echo number_format($user[0]['Monto'], 2, '.', ','); ?> (<?php echo num2letras($user[0]['Monto'],false,false); ?>),</b> realizando el pago en una sola exhibición en la fecha correspondiente:<br>
				•	<b>El pago incluye la inscripción al proceso de titulación, toma de protesta y registro electrónico de título por $ <?php echo number_format($user[0]['Monto'], 2, '.', ','); ?> (<?php echo num2letras($user[0]['Monto'],false,false); ?>)</b>
				</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;">I.</td>
				<td colspan="3" style="width: 640px; text-align: justify; border: none;">Además, deberá de cumplir con todos los demás requisitos que se establezca la Universidad</td>
			</tr>
			<tr>
				<td colspan="4" style="width: 680px; text-align: justify; border: none;">
					<b>TERCERA:</b> El alumno tendrá derecho a recibir por parte de la Universidad, el acta de examen y grado académico.
				</td>
			</tr>
			<tr>
				<td colspan="4" style="width: 680px; text-align: justify; border: none;">
					<b>CUARTA:</b> Para poder realizar el acto de recepción profesional a fin de obtener el acta de examen y diploma de grado en el nivel de posgrado, el <?php echo $txtnx_1; ?> debe cumplir con los siguientes requisitos.
				</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;">I.</td>
				<td colspan="3" style="width: 620px; text-align: justify; border: none;">Ser egresado de esta Universidad en el nivel de <?php echo $txtMi_1; ?>. </td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;">II.</td>
				<td colspan="3" style="width: 620px; text-align: justify; border: none;">Requisitar el contrato para la sustentación del acto de recepción y obtención del grado académico.</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;">III.</td>
				<td colspan="3" style="width: 620px; text-align: justify; border: none;">Haber entregado en el departamento de servicios escolares la siguiente documentación (original y copia fotostática tamaño carta) y fotografías.</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;"></td>
				<td style="width: 10px; text-align: left; border: none;">1.</td>
				<td colspan="2" style="width: 600px; text-align: justify; border: none;">Cédula de <b><?php echo $docsx1; ?>. </b></td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;"></td>
				<td style="width: 10px; text-align: left; border: none;">2.</td>
				<td colspan="2" style="width: 620px; text-align: justify; border: none;">Certificado del nivel de <?php echo $docsx1; ?>. </td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;"></td>
				<td style="width: 10px; text-align: left; border: none;">3.</td>
				<td colspan="2" style="width: 620px; text-align: justify; border: none;">CURP.</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;"></td>
				<td style="width: 10px; text-align: left; border: none;">4.</td>
				<td colspan="2" style="width: 620px; text-align: justify; border: none;">2 copias vigente de INE-IFE.</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;"></td>
				<td style="width: 10px; text-align: left; border: none;">5.</td>
				<td colspan="2" style="width: 620px; text-align: justify; border: none;">Seis fotografías tamaño credencial ovaladas, de frente, fondo blanco, ropa clara, (sin barba hombres), (sin aretes, cadenas o maquillaje mujeres), frente y orejas despejadas, cabello recogido, sin lentes, no instantáneas.</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: left; border: none;"></td>
				<td style="width: 10px; text-align: left; border: none;">6.</td>
				<td colspan="2" style="width: 620px; text-align: justify; border: none;">Efectuar los siguientes pagos en hacienda del estado <b>CUANDO SE LE INDIQUE</b>, mismos que deberán presentar en original al departamento de servicios escolares por los siguientesconceptos:</td>
			</tr>
			<tr>
				<td colspan="3" style="width: 10px; text-align: left; border: none;"></td>
				<td  style="width: 620px; text-align: justify; border: none;"><b>Boleta de pago de hacienda del estado para el acta de examen de grado por:</b></td>
			</tr>
			<tr>
				<td colspan="3" style="width: 10px; text-align: left; border: none;"></td>
				<td  style="width: 620px; text-align: justify; border: none;">ACTAS DE EXAMEN (DE GRADO); TOMA DE PROTESTA (ACTA DE EXAMEN)</td>
			</tr>
			<tr>
				<td colspan="3" style="width: 10px; text-align: left; border: none;"></td>
				<td  style="width: 620px; text-align: justify; border: none;">Art. 21 Fracc. VII. Legalización de firmas de documentos oficiales con firmas de funcionarios públicos. $234.00</td>
			</tr>
			<tr>
				<td colspan="3" style="width: 10px; text-align: left; border: none;"></td>
				<td  style="width: 620px; text-align: justify; border: none;">Art. 39 Fracc. VIII-. Expedición de actas de grado. $435.00</td>
			</tr>
			<tr>
				<td colspan="3" style="width: 10px; text-align: left; border: none;"></td>
				<td  style="width: 620px; text-align: justify; border: none;">Art. 39 Fracc. XXII (b). Certificación o legalización de actas de examen profesional tipo medio superior y superior. $234.00</td>
			</tr>
			<tr>
				<td colspan="3" style="width: 10px; text-align: left; border: none;"></td>
				<td  style="width: 620px; text-align: justify; border: none;"><b>Boleta de pago de hacienda del estado para el diploma de grado por:</b></td>
			</tr>
			<tr>
				<td colspan="3" style="width: 10px; text-align: left; border: none;"></td>
				<td  style="width: 620px; text-align: justify; border: none;">Art. 40 Fracc. III- (b). Legalización de firmas de títulos electrónicos profesionales o títulos electrónicos de grado. $636.00</td>
			</tr>
			<tr>
				<td colspan="3" style="width: 10px; text-align: left; border: none;"></td>
				<td  style="width: 620px; text-align: justify; border: none;">Art. 40 Fracc. IV- (a). Expedición y registro de título profesional electrónico medio superior y superior particulares. $1,272.00</td>
			</tr>
			<tr>
				<td colspan="3" style="width: 10px; text-align: left; border: none;"></td>
				<td  style="width: 620px; text-align: justify; border: none;">&nbsp;&nbsp; •	&nbsp;&nbsp; Nota aclaratoria: de acuerdo a costos del ciclo escolar anterior hay un incremento del 6%.</td>
			</tr>
			<tr>
				<td colspan="4" style="width: 680px; text-align: center; border: none; height: 15px; ">
					<b>ACLARACIÓN IMPORTANTE::</b>
				</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: center; border: none;"></td>
				<td style="width: 10px; text-align: center; border: none;">-</td>
				<td colspan="2" style="width: 620px; text-align: justify; border: none;">El acta de examen profesional que el interesado firme en el acto protocolario de toma de protesta, se enviará a la secretaría de educación del estado y se lleva un tiempo aproximado para su legalización de 2 a 3 meses a partir de la fecha de ingreso que indique la secretaría para el trámite correspondiente. </td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: center; border: none;"></td>
				<td style="width: 10px; text-align: center; border: none;">-</td>
				<td colspan="2" style="width: 620px; text-align: justify; border: none;">Una vez legalizado el acta de examen de grado, Iniciará el proceso de trámite y registro electrónico del título de grado ante la Secretaria de Educación de acuerdo a la cita que le sea asignada a la Escuela Nacional de Protección Civil, Campus Chiapas, este trámite llevará un tiempo aproximado de 30 a 45 días hábiles a partir del día que ingrese dicho trámite a la secretaria de educación.</td>
			</tr>
			<tr>
				<td style="width: 10px; text-align: center; border: none;"></td>
				<td style="width: 10px; text-align: center; border: none;">-</td>
				<td colspan="2" style="width: 620px; text-align: justify; border: none;">Una vez que recibas la notificación vía correo electrónico de que tu Grado ya fue registrado electrónicamente, podrás descargarlo e imprimirlo a través de una plataforma (enlace) electrónica; así mismo podrás tramitar en línea tu cédula de grado cumpliendo los requisitos que establece la Dirección General de Profesiones.</td>
			</tr>
			<tr>
				<td colspan="4" style="width: 680px; text-align: justify; border: none;">
					<b>QUINTA:</b> La falta de algún documento, fotografía, pagos hacendarios o pagos a la universidad en los periodos mencionados, cancelará en cualquiera de las etapas, el trámite motivo del presente contrato, sin responsabilidad alguna para la Universidad, debiendo el <?php echo $txtnx_1; ?> sujetarse a las disposiciones y periodos posteriores establecidos por la Universidad.
				</td>
			</tr>
			<tr>
				<td colspan="4" style="width: 680px; text-align: justify; border: none;">
					<b>SEXTA:</b> Los costos que se contemplan en el presente contrato tienen vigencia únicamente en las fechas señaladas anteriormente, posterior a esas fechas el <?php echo $txtnx_1; ?> tendrá que sujetarse a los requisitos normativos y vigentes que estén en ese momento.
				</td>
			</tr>
			<tr>
				<td colspan="4" style="width: 680px; text-align: justify; border: none;">
					<b>SEPTIMA:</b> A través de la información proporcionada personalmente, no tengo inconveniente de realizar los pagos en los periodos establecidos por la universidad.
				</td>
			</tr>
			<tr>
				<td colspan="4" style="width: 680px; text-align: justify; border: none;">
					Leído íntegramente el contenido de este documento ante las partes, manifiestan que en su celebración no ha mediado dolo, error, ni mala fe que pudieran ser objeto de nulidad por lo que de conformidad y libre voluntad firman al calce para constancia y debido cumplimiento, a los <?php echo fecha_impre($user[0]['Fecha_titulacion']); ?> en la ciudad de Tuxtla Gutiérrez, Chiapas.
				</td>
			</tr>

	</table>
	<br><br>
	<table style="margin-left: 4px; font-size: 9px;">
		<tr>
			<td style="width: 140px; text-align: center; height: 50px; border: none;"><b><?php echo $txtM_1; ?></b></td>
			<td style="width: 380px; text-align: center; border: none;"></td>
			<td style="width: 140px; text-align: center; font-size: 7px; border: none;"><b>POR LA ESCUELA</b></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: center; border-left: none; border-right: none;"></td>
			<td style="width: 380px; text-align: center; border: none;"></td>
			<td style="width: 140px; text-align: center; border-left: none; border-right: none;"></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: center; border-left: none; border-right: none; border-bottom: none;"><b>FIRMA</b></td>
			<td style="width: 380px; text-align: center; border: none;"></td>
			<td style="width: 140px; text-align: center; border-left: none; border-right: none; border-bottom: none; font-size: 7px;"><b>DIRECCIÓN DE LA ESCUELA</b></td>
		</tr>
	</table>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

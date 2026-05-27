<?php

	require_once '../classprint.php';
	include("numeros.php");
	include("importe.php");
	include("hace.php");
	$t = new Imprimir();

	$factura = $t->get_factura_id($_GET["idToks"]);

	$_Folio = $factura[0]['FolioPago']; 

	$dat_fac = $t->get_datos_factura_id($_GET["idToks"]);
	$pag = $t->get_pagos_factura($_GET["idToks"]);
	$direc = $t->get_direccion_id($_Folio);
	$deta = $t->get_detalle_id($_Folio,$factura);

	$qrCode = $factura[0]['_folio'] . '.png';
	$_SESSION['_nombre'] = $dat_fac[0]['Serie'].$dat_fac[0]['Folio'].'_'.$dat_fac[0]['R_Nombre'].'.pdf';

	if (!$factura[0]["IdFactura"]) {
		echo "<script type='text/javascript'>window.close();</script>";
	}
?>
	<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
	<style>
		<!--
		table {
			font-family: Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		td,
		th {
			/* border: 1px solid #003A70; */
			padding: 2px;
		}

		tr:nth-child(even) {
			background-color: #dddddd;
		}
		-->
	</style>
	<!-- page define la hoja con los márgenes señalados -->
	<page backtop="60mm" backbottom="20mm" backleft="10mm" backright="10mm">
		<page_header>
			<!-- Define el header de la hoja -->
			<table style="margin-left: 38px; margin-top: 50px;">
				<tr>
					<td style="width: 335px; border-left: none; border-top: none; border-bottom: none; text-align: left;"><img src="../../assets/images/campus/logo_inicio.png" style="width: 300px; margin-top: 20px;"></td>
					<td style="width: 335px; background: #0082b7; color: white;">
						<table>
							<tr>
								<td style="font-size: 12px; width: 330px; border: none; text-align: center;"><b>CENTRO INTEGRAL DE ESTUDIOS PROFESIONALES</b></td>
							</tr>
							<tr>
								<td style="font-size: 10px; border: none; text-align: center;">RFC: CIE090115D22</td>
							</tr>
							<tr>
								<td style="font-size: 10px; border: none; width: 330px;">
									Tipo de comprobante: I - Ingreso<br>
									Lugar de expedición: 86280<br>
									Domicilio: Carretera Federal Villahermosa-Teapa No. KM. 1, Plutarco Elias Calles, 86280, Centro Tabasco, México.<br>
									Regimen fiscal: 601 - General de Ley Personas Morales
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</page_header>
		<page_footer>
			<!-- Define el footer de la hoja -->
			<p style="text-align: center; font-size: 10px;">Este documento es una representación impresa de un CFDI. Version 4.0</p>
			<br>
		</page_footer>
		<?php $x = 0;
		for ($c = 0; $c < 1; $c++) { ?>
			<!-- Define el cuerpo de la hoja -->
			<table style="font-size: 11px;">
				<tr>
					<td style="width: 100px; background: #d9d9d9; color: #0082b7;"><b>Forma de pago:</b></td>
					<td style="width: 350px;"><?php echo $dat_fac[0]['FormaPago']; ?> <?php echo $deta[0]['_formaPago']; ?></td>
					<td style="width: 74px; background: #d9d9d9; color: #0082b7;"><b>Folio:</b></td>
					<td style="width: 130px;"> <b><?php echo $dat_fac[0]['Serie'].'-'.$dat_fac[0]['Folio']; ?></b></td>
				</tr>
				<tr>
					<td style="width: 100px; background: #d9d9d9; color: #0082b7;"><b>Metodo de pago:</b></td>
					<td style="width: 350px;">PUE PAGO EN UNA SOLA EXHIBICIÓN</td>
					<td style="width: 74px; background: #d9d9d9; color: #0082b7;"><b>Fecha:</b></td>
					<td style="width: 130px;"><?php echo $dat_fac[0]['Fecha']; ?></td>
				</tr>
				<tr>
					<td style="width: 100px; background: #d9d9d9; color: #0082b7;"><b>Moneda:</b></td>
					<td style="width: 350px;">MXN - PESO MEXICANO</td>
					<td style="width: 74px; background: #d9d9d9; color: #0082b7;"></td>
					<td style="width: 130px;"></td>
				</tr>
			</table><br><br>
			<table style="font-size: 11px;">
				<tr>
					<td style="width: 678px; background: #d9d9d9; color: #0082b7;"><b>Datos del cliente</b></td>
				</tr>
			</table>
			<table style="font-size: 11px;">
				<tr>
					<td style="width: 60px; "><b>Nombre:</b></td>
					<td style="width: 300px; "><?php echo $dat_fac[0]['R_Nombre']; ?></td>
					<td style="width: 75px; "><b>Uso CFDI:</b></td>
					<td style="width: 219px; "><?php echo $dat_fac[0]['R_UsoCFDI']; ?> <?php echo $deta[0]['_usoCFDI']; ?></td>
				</tr>
				<tr>
					<td style="width: 60px; "><b>RFC:</b></td>
					<td style="width: 300px; "><?php echo $dat_fac[0]['R_Rfc']; ?></td>
					<td style="width: 75px; "><b>Régimen fiscal:</b></td>
					<td style="width: 219px; "><?php echo $dat_fac[0]['R_RegimenFiscalReceptor']; ?> <?php echo $deta[0]['_regimenFiscal']; ?></td>
				</tr>
				<tr>
					<td style="width: 60px; "><b>Domicilio:</b></td>
					<td colspan="3" style="width: 500px; "><?php if($direc[0]['tipoPersona'] <> 3){ echo $direc[0]['Domicilio'] . ' ' . $direc[0]['NoExterior'] . ', ' . $direc[0]['Municipio'] . ', ' . $direc[0]['Estado']; ?> - <?php echo $dat_fac[0]['R_DomicilioFiscalReceptor']; } else { echo "---"; } ?></td>
				</tr>
			</table>
			<br>
			<table style="font-size: 11px;">
				<tr style="text-align: center;">
					<td style="width: 30px; background: #d9d9d9; color: #0082b7;"><b>Cant.</b></td>
					<td style="width: 60px; background: #d9d9d9; color: #0082b7;"><b>Clave Unidad<br>SAT</b></td>
					<td style="width: 80px; background: #d9d9d9; color: #0082b7;"><b>Clave <br>producto / servicio</b></td>
					<td style="width: 220px; background: #d9d9d9; color: #0082b7;"><b>Concepto /<br>descripción</b></td>
					<td style="width: 65px; background: #d9d9d9; color: #0082b7; "><b>Valor<br>unitario</b></td>
					<td style="width: 65px; background: #d9d9d9; color: #0082b7;"><b>Descuentos</b></td>
					<td style="width: 45px; background: #d9d9d9; color: #0082b7;"><b>Impuestos</b></td>
					<td style="width: 57px; background: #d9d9d9; color: #0082b7; text-align: right;"><b>Importe</b></td>
				</tr>
				<?php for ($i = 0; $i < sizeof($pag); $i++) { ?>
					<tr style="text-align: center; font-size: 10px;">
						<td style="width: 30px; "><?php echo $pag[$i]['Cantidad']; ?>.00</td>
						<td style="width: 60px; "><?php echo $pag[$i]['ClaveUnidad'] . ' - ' . $pag[$i]['Unidad']; ?></td>
						<td style="width: 80px; "><?php echo $pag[$i]['ClaveProdServ'].' - '.$pag[$i]['DesProd']; ?> </td>
						<td style="width: 220px; text-align: justify; ">
						    <?php echo $pag[$i]['Descripcion']; ?>
						    <?php if($pag[$i]['complemento'] == 1){
						        echo "<br>ALUMNO: ".$pag[$i]['alumno'];
						        echo "<br>CURP: ".$pag[$i]['curp'];
						        echo "<br>NIVEL: ".$pag[$i]['nivel'];
						        echo "<br>AUTRVOE: ".$pag[$i]['rvoe'];
						        echo "<br>RFC PAGO: ".$dat_fac[0]['R_Rfc'];
						        echo "<br>VERSION: 1.0";
						    } ?>
						</td>
						<td style="width: 65px; "><?php echo number_format($pag[$i]['ValorUnitario'], 2, '.', ','); ?></td>
						<td style="width: 65px; "><?php echo number_format($pag[$i]['Descuento'], 2, '.', ','); ?></td>
						<td style="width: 45px; ">0.00</td>
						<td style="width: 57px; text-align: right; "><?php echo number_format($pag[$i]['Importe'], 2, '.', ','); ?></td>
					</tr>
				<?php } ?>
			</table>
			<table style="font-size: 11px; margin-top: 20px;">
				<tr>
					<td style="width: 492px; color: #0082b7; "><b>Importe con letra:</b></td>
					<td style="width: 100px; background: #d9d9d9; color: #0082b7;"><b>Subtotal:</b></td>
					<td style="width: 70px; text-align: right;"><?php echo number_format($dat_fac[0]['SubTotal'], 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td style="width: 492px; "><?php echo num2letras($dat_fac[0]['Total'], false, false); ?></td>
					<td style="width: 100px; background: #d9d9d9; color: #0082b7;"><b>Descuento:</b></td>
					<td style="width: 70px; text-align: right;"><?php echo number_format($dat_fac[0]['Descuento'], 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td style="width: 492px; "></td>
					<td style="width: 100px; background: #d9d9d9; color: #0082b7;"><b>Impuestos Traslados:</b></td>
					<td style="width: 70px; text-align: right;">0.00</td>
				</tr>
				<tr>
					<td style="width: 492px; "></td>
					<td style="width: 100px; background: #d9d9d9; color: #0082b7;"><b>Total:</b></td>
					<td style="width: 70px; text-align: right;"><?php echo number_format($dat_fac[0]['Total'], 2, '.', ','); ?></td>
				</tr>
			</table>
			<table style="font-size: 11px; margin-top: 10px;">
				<tr>
					<td style="width: 492px; color: #0082b7; "><b>CFDI Relacionado:</b></td>
				</tr>
				<tr>
					<td style="width: 492px; color: #000; "><b>Tipo Relación: - </b></td>
				</tr>
				<tr>
					<td style="width: 492px; color: #000; "><b>CFDI Relacionado:</b></td>
				</tr>
			</table>
			<table style="font-size: 11px; margin-top: 20px;">
				<tr>
					<td rowspan="5" style="width: 210px; ">
					</td>
					<td style="width: 200px; background: #d9d9d9; color: #0082b7;"><b>Serie del Certificado del emisor</b></td>
					<td style="width: 250px; "><?php echo $dat_fac[0]['NoSerie_emisor']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px; background: #d9d9d9; color: #0082b7;"><b>Folio fiscal</b></td>
					<td style="width: 250px; "><?php echo $factura[0]['uuid']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px; background: #d9d9d9; color: #0082b7;"><b>No. de Serie del Certificado SAT</b></td>
					<td style="width: 250px; "><?php echo $factura[0]['noCertificadoSAT']; ?></td>
				</tr>
				<tr>
					<td style="width: 200px; background: #d9d9d9; color: #0082b7;"><b>Fecha y hora de certificación</b></td>
					<td style="width: 250px; "><?php echo $factura[0]['fechaTimbrado']; ?></td>
				</tr>
			</table>
			<img src="../../assets/docs/factura/<?php echo $dat_fac[0]['Anio']; ?>/<?php echo $dat_fac[0]['Mes']; ?>/<?php echo $qrCode; ?>" style="width: 120px; margin-top: -80px; margin-left: -10px; ">
			<br><br><br><br><br><br><br>
			<table style="font-size: 11px;">
				<tr>
					<td style="width: 678px; background: #d9d9d9; color: #0082b7;"><b>Sello digital de CFDI</b></td>
				</tr>
				<tr>
					<td style="width: 678px;">
						<?php echo substr($factura[0]['selloCFDI'], 0, 100); ?>
						<?php echo substr($factura[0]['selloCFDI'], 100, 100); ?>
						<?php echo substr($factura[0]['selloCFDI'], 200, 100); ?>
						<?php echo substr($factura[0]['selloCFDI'], 300, 100); ?>
					</td>
				</tr>
				<tr>
					<td style="width: 678px; background: #d9d9d9; color: #0082b7;"><b>Sello del SAT</b></td>
				</tr>
				<tr>
					<td style="width: 678px;">
						<?php echo substr($factura[0]['selloSAT'], 0, 100); ?>
						<?php echo substr($factura[0]['selloSAT'], 100, 100); ?>
						<?php echo substr($factura[0]['selloSAT'], 200, 100); ?>
						<?php echo substr($factura[0]['selloSAT'], 300, 100); ?>
					</td>
				</tr>
				<tr>
					<td style="width: 678px; background: #d9d9d9; color: #0082b7;"><b>Cadena original del complemento de certificación digital del SAT</b></td>
				</tr>
				<tr>
					<td style="width: 678px;">
						<?php echo substr($factura[0]['cadenaOriginalSAT'], 0, 100); ?>
						<?php echo substr($factura[0]['cadenaOriginalSAT'], 100, 100); ?>
						<?php echo substr($factura[0]['cadenaOriginalSAT'], 200, 100); ?>
						<?php echo substr($factura[0]['cadenaOriginalSAT'], 300, 100); ?>
						<?php echo substr($factura[0]['cadenaOriginalSAT'], 400, 100); ?>
					</td>
				</tr>
			</table>
			<?php if($factura[0]['IdEstatus'] == 7){  ?>
		<img src="../../assets/images/campus/cancelado.png" style="width: 90%; position: absolute; margin-left: 40px; margin-top: 50px;" >
		<?php } ?>
			<!-- Fin del cuerpo de la hoja -->
		<?php } ?>
	</page>

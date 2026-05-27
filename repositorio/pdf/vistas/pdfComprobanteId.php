<?php

	require_once'../classprint.php';
	include("numeros.php");
	include("importe.php");
	$t=new Imprimir();
	//cadena en el 26
	$id = substr($_GET["tokenId"], 52,4);
	$datos=$t->get_configuracion();
	$pago=$t->get_comprobanteId($id);
	$desLista=$t->get_descuento($pago[0]["EstatusDescuento"]);


?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--
#encabezado {padding:10px 0; border-top: 1px solid; border-bottom: 1px solid; width:100%;}
#encabezado .fila #col_1 {width: 15%}
#encabezado .fila #col_2 {text-align:left; width: 70%}
#encabezado .fila #col_3 {width: 15%}
#encabezado .fila #col_4 {width: 15%}
#encabezado .fila #col_5 {width: 3%}
#encabezado .fila #col_6 {text-align:left; width: 100%;}
#encabezado .fila #col_7 {width: 52%}
#encabezado .fila #col_8 {text-align:center; width: 50%}

#encabezado .fila td img {width:50%}
#encabezado .fila #col_2 #span1{font-size: 15px;}
#encabezado .fila #col_2 #span2{font-size: 12px; color: #4d9;}
#encabezado .fila #col_3 #span3{font-size: 12px; text-align: left;}
#encabezado .fila #col_2 #span4{font-size: 12px; color: black;}
#encabezado .fila #col_7 #span3{font-size: 12px; text-align: left;}


#footer {padding-top:5px 0; border-top: 2px solid #46d; width:100%;}
#footer .fila td {text-align:center; width:100%;}
#footer .fila td span {font-size: 10px; color: #000;}

#fecha {margin-top:70px; width:100%;}
#fecha tr td {text-align: right; width:100%;}

#central {margin-top:20px; text-align: justify;}
#central tr th {padding: 10px;}
#central tr td {padding: 10px; text-align: justify; width:100%;}

#datos {border:1px solid; margin-left:180px; width:50%;}
#datos tr {border:1px solid;}
#datos tr td{border:1px solid;}

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    padding: 8px;
}
#encabezado td, th {
    border: 1px solid #dddddd;
    padding: 1px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}
#texto1 { width: 100px;}
-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="55mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<div style= "width: 100%; position: absolute; ">

		<div style="float: left; width: 20%; margin-top:30px; margin-left: 50px;">

		</div>
		<div style="float: left; width: 100%; margin-top: -50px;">
		<table id="encabezado" style="border: none;">
			<tr class="fila">
				<td id="col_6" style="border: none">
					<span id="span1"><b style='color:#FE9900; '>
			  <img src="../../assets/images/campus/logo_inicio.png" style="width:100%";>
            </b></span>
				</td>
			</tr>
		</table>
		</div>
	</div>




	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->


	</page_footer>


	<table border='1' cellpadding='0' style=" padding: 4px; margin-left: 25px; margin-right: 80px;">
		<tr style="padding: 6px;">
			<td colspan='2' style="width: 356px; font-size: 11px;  margin-bottom: -15px; ">
				<p style='font-size: 9px;'><b>No. CONTROL:</b></p>
				<p style='font-size: 10px; padding-left: 15px;'><?php echo $pago[0]["NomUsuario"].' '.$pago[0]["APaterno"].' '.$pago[0]["AMaterno"]; ?></p>
				<p style='font-size: 9px; text-transform: uppercase;'><b><?php echo $pago[0]["Tipo"]; ?>:</b></p>
				<p style='font-size: 10px; padding-left: 15px;'><?php echo $pago[0]["Nombre"]; ?></p>
			</td>
			<td style="width: 193px; font-size: 11px; margin-bottom: -15px; background: #056fb1;">
				<table style='margin-left: -9px; margin-top: -9px;'>
					<tr style="padding: 2px;"><td style="border-right: none; width: 185px; font-size: 9px; padding: 2px; background: #056fb1; color: #fff; "><b>NO. RECIBO</b></td></tr>
					<tr style="padding: 6px;"><td style="width: 185px; font-size: 9px; background: #fff; "><?php echo $pago[0]["NoFolio"]; ?></td></tr>
					<tr style="padding: 2px;"><td style="border-right: none; width: 185px; font-size: 9px; padding: 2px; background: #056fb1; color: #fff; "><b>FORMA DE PAGO</b></td></tr>
					<tr style="padding: 6px;"><td style="width: 185px; font-size: 9px; text-transform: uppercase; background: #fff; "><?php echo $pago[0]["Descripcion"]; ?></td></tr>
					<tr style="padding: 2px;"><td style="border-right: none; width: 185px; font-size: 9px; padding: 2px; background: #056fb1; color: #fff; "><b>FECHA DE PAGO</b></td></tr>
					<tr style="padding: 6px;"><td style="width: 185px; font-size: 9px; background: #fff; "><?php echo $pago[0]["FecPago"]; ?></td></tr>
				</table>
			</td>
		</tr>
		<tr style="padding: 6px;">
			<td colspan='3' style="width: 579px; font-size: 11px; text-align: center; "><b>CONCEPTO DE PAGO</b></td>
		</tr>
		<tr style="padding: 6px;">
			<td colspan='2' style="width: 386px; font-size: 11px; ">
				<p style='font-size: 9px;'><b>NOMBRE DEL CONCEPTO:</b></p>
				<p style='font-size: 10px; padding-left: 15px;'><?php echo $pago[0]["NomConcepto"]; ?></p>
			</td>
			<td style="width: 193px; font-size: 11px; margin-bottom: -15px; text-align: right;">
				<p style='font-size: 9px; text-align: right;'><b>IMPORTE:</b></p>
				<p style='font-size: 10px;'> $ <?php echo number_format($pago[0]["Pagar"], 2, '.', ','); ?></p>
			</td>
		</tr>
		<?php
		 // $xv = 1;
	   // echo $total1 = $pago[0]["Pagar"];
		 // echo $pagado1 = $pago[0]["TotalPagado"];
		  if($total1 == $pagado1) { $xv = 1; } else { $vx = 2;}
		 //
		 // echo $xv;
		  ?>
		<?php if($pago[0]["Recargos"]){ ?>
		<tr style="padding: 6px;">
			<td colspan='2' style="width: 386px; font-size: 11px; ">
				<p style='font-size: 10px; text-align: right;'><b>Recargo:</b></p>
			</td>
			<td style="width: 193px; font-size: 11px; margin-bottom: -15px; text-align: right;">
				<p style='font-size: 10px;'><b>$ <?php echo number_format($pago[0]["Recargos"], 2, '.', ','); ?></b></p>
			</td>
		</tr>
		<?php } $total = $pago[0]["Pagar"] + $pago[0]["Recargos"]; ?>
		<tr style="padding: 6px;">
			<td colspan='2' style="width: 386px; font-size: 11px; ">
				<p style='font-size: 10px; text-align: right;'><b>TOTAL:</b></p>
			</td>
			<td style="width: 193px; font-size: 11px; margin-bottom: -15px; text-align: right;">
				<p style='font-size: 10px;'><b>$ <?php echo number_format($pago[0]["TotalPagado"], 2, '.', ','); ?></b></p>
			</td>
		</tr>

		<tr style="padding: 6px;">
			<td colspan='3' style="width: 579px; font-size: 11px; text-align: center; ">
				<p style='font-size: 8px;'><b>IMPORTE CON LETRA:</b></p>
				<p style='font-size: 10px; text-align: center;'><?php echo num2letras($total, false, false); ?></p>
			</td>
		</tr>
		<tr style="padding: 6px;">
			<td colspan='3' style="width: 579px; font-size: 6px; text-align: center; "><b>LA REPRODUCCIÓN NO AUTORIZADA DE ESTE COMPROBANTE CONSTITUYE UN DELITO EN LOS TERMINOS DE LAS DISPOSICIONES FISCALES</b></td>
		</tr>


		<tr style="padding: 6px;">
			<td style="width: 193px; font-size: 11px; text-align: right; "></td>
			<td style="width: 193px; font-size: 11px; "></td>
			<td style="width: 193px; font-size: 11px; text-align: right; "></td>
		</tr>


	</table>


	<!-- Fin del cuerpo de la hoja -->




</page>

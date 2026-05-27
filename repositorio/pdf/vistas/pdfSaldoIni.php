<?php
	require_once'../classprint.php';
	include("numeros.php");
	include("hace.php");
	$t=new Imprimir();
	$IdUsua = (substr($_GET["tokenId"],10,10));
	$datos=$t->get_configuracion();
	$chkDeuda = $t->get_chkDeuda($IdUsua);
	$chkUser = $t->get_userSaldo($IdUsua);

	$bancos=$t->get_bancos($chkUser[0]["IdOferta"]);

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
#encabezado .fila #col_6 {text-align:center; width: 100%}
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
<page backtop="10mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

		<table id="footer">
			<tr class="fila">
				<td style="border: none">
					<span><?php echo $datos[1]["Descripcion"] ?></span>
				</td>
			</tr>
		</table>
	</page_footer>
	<table>
		<tr>
			<td colspan="4" style="width: 560px; font-size: 12px; border: none; text-align: center; "><b style="font-size: 25px; color: #066db0;">
			<img src="../../assets/images/campus/logo_inicio.png" style="width:150px";><br><br></b></td>
		</tr>
		<tr style="background: whitesmoke;">
			<td colspan="4" style="width: 560px; font-size: 12px; border: none; text-align: center; "><b style="font-size: 25px; color: #066db0;">
			FICHA DE PAGO DE SALDO INICIAL</b></td>
		</tr>

		<tr Style="background: #fff9f9;">
			<td colspan="4" style="width: 460px; font-size: 12px; border: none; text-align: left; ">
			<label style="font-size: 10px; color: #71b956;">Fecha de descarga de la ficha: <?php echo $FecIns=date("Y-m-d h:i:s"); ?></label><br>
			</td>
		</tr>
		<tr style="background: #fff9f9;">
			<td colspan="2" style="width: 280px; font-size: 12px; border: none; text-align: right; color: #0b73b5;"><b>NOMBRE ALUMNO:</b></td>
			<td colspan="2" style="width: 280px; font-size: 12px; border: none; text-align: left; color: #0b73b5;"><?php echo $chkUser[0]["Nombre"].' '.$chkUser[0]["APaterno"].' '.$chkUser[0]["AMaterno"]; ?></td>
		</tr>
		<tr style="background: #fff9f9;">
			<td colspan="2" style="width: 280px; font-size: 12px; border: none; text-align: right; color: #0b73b5;"><b>CONCEPTO:</b></td>
			<td colspan="2" style="width: 280px; font-size: 12px; border: none; text-align: left; color: #0b73b5;">Saldo inicial</td>
		</tr>
		<tr style="background: #fff9f9;">
			<td colspan="2" style="width: 280px; font-size: 12px; border: none; text-align: right; color: #0b73b5;"><b>COMENTARIO:</b></td>
			<td colspan="2" style="width: 280px; font-size: 12px; border: none; text-align: left; color: #0b73b5;"><?php echo $chkUser[0]["Descripcion"]; ?></td>
		</tr>
		<tr style="background: #fff9f9;">
			<td colspan="2" style="width: 280px; font-size: 12px; border: none; text-align: right; color: #0b73b5;"><b>TOTAL CONCEPTO:</b></td>
			<td colspan="2" style="width: 280px; font-size: 12px; border: none; text-align: left; color: #0b73b5;">$ <?php echo number_format($chkDeuda[0]["Saldo"], 2, '.', ','); ?></td>
		</tr>


		<tr style="background: whitesmoke;">
			<td colspan="4" style="width: 560px; font-size: 12px; border: none; text-align: center; "><b style="font-size: 25px; color: #066db0;">
			Total pagar: $ <?php echo number_format($chkDeuda[0]["Saldo"], 2, '.', ','); ?></b></td>
		</tr>






		<tr style="background: #fff9f9;">
			<td style="width: 100px; font-size: 12px; border: none; text-align: center; "></td>
			<td  style="width: 180px; font-size: 12px; border: none; text-align: center; "></td>
			<td style="width: 180px; font-size: 12px; border: none; text-align: center; "></td>
			<td style="width: 100px; font-size: 12px; border: none; text-align: center; "></td>
		</tr>
	</table>


<div style="border: 1px solid #d2d6de; width: 669px; height: 15px; padding: 8px; font-size: 18px; text-align: center; ">
<b>REFERENCIA DE PAGO: <?php //echo $boucher[0]["Usuario"]; ?></b>

</div>
<?php if($bancos[0]){ ?>
	<div style="border: 1px solid #d2d6de; <?php if($Nobancos[0]["sumBanco"] == 1) { ?> width: 669px; <?php } else { ?> width: 326px; <?php } ?>  height: 80px; padding: 8px; font-size: 12px; ">
	  <?php if($bancos[0]["Nombre"]){ ?><b>Nombre:</b> <?php echo $bancos[0]["Nombre"]; ?><br><?php } ?>
		<?php if($bancos[0]["Banco"]){ ?><b>Banco:</b> <?php echo $bancos[0]["Banco"]; ?><br><?php } ?>
		<?php if($bancos[0]["Convenio"]){ ?><b>Convenio:</b> <?php echo $bancos[0]["Convenio"]; ?><br><?php } ?>
		<?php if($bancos[0]["NoCuenta"]){ ?><b>No. Cuenta:</b> <?php echo $bancos[0]["NoCuenta"]; ?><br><?php } ?>
		<?php if($bancos[0]["Clabe"]){ ?><b>Clabe interbancaria:</b> <?php echo $bancos[0]["Clabe"]; ?><br><?php } ?>

	</div>
<?php } if($bancos[1]){ ?>
	<div style="border: 1px solid #d2d6de; width: 326px; height: 80px; padding: 8px; font-size: 12px; margin-left: 342px; margin-top:-98px; ">
		<?php if($bancos[1]["Nombre"]){ ?><b>Nombre:</b> <?php echo $bancos[1]["Nombre"]; ?><br><?php } ?>
		<?php if($bancos[1]["Banco"]){ ?><b>Banco:</b> <?php echo $bancos[1]["Banco"]; ?><br><?php } ?>
		<?php if($bancos[1]["Convenio"]){ ?><b>Convenio:</b> <?php echo $bancos[1]["Convenio"]; ?><br><?php } ?>
		<?php if($bancos[1]["NoCuenta"]){ ?><b>No. Cuenta:</b> <?php echo $bancos[1]["NoCuenta"]; ?><br><?php } ?>
		<?php if($bancos[1]["Clabe"]){ ?><b>Clabe interbancaria:</b> <?php echo $bancos[1]["Clabe"]; ?><br><?php } ?>

	</div>
<?php } if($bancos[2]){ ?>
	<div style="border: 1px solid #d2d6de; width: 326px; height: 80px; padding: 8px; font-size: 12px; ">
		<?php if($bancos[2]["Nombre"]){ ?><b>Nombre:</b> <?php echo $bancos[2]["Nombre"]; ?><br><?php } ?>
		<?php if($bancos[2]["Banco"]){ ?><b>Banco:</b> <?php echo $bancos[2]["Banco"]; ?><br><?php } ?>
		<?php if($bancos[2]["Convenio"]){ ?><b>Convenio:</b> <?php echo $bancos[2]["Convenio"]; ?><br><?php } ?>
		<?php if($bancos[2]["NoCuenta"]){ ?><b>No. Cuenta:</b> <?php echo $bancos[2]["NoCuenta"]; ?><br><?php } ?>
		<?php if($bancos[2]["Clabe"]){ ?><b>Clabe interbancaria:</b> <?php echo $bancos[2]["Clabe"]; ?><br><?php } ?>
	</div>
<?php } if($bancos[3]){ ?>
	<div style="border: 1px solid #d2d6de; width: 326px; height: 80px; padding: 8px; font-size: 12px; margin-left: 342px; margin-top:-98px; ">
		<?php if($bancos[3]["Nombre"]){ ?><b>Nombre:</b> <?php echo $bancos[0]["Nombre"]; ?><br><?php } ?>
		<?php if($bancos[3]["Banco"]){ ?><b>Banco:</b> <?php echo $bancos[0]["Banco"]; ?><br><?php } ?>
		<?php if($bancos[3]["Convenio"]){ ?><b>Convenio:</b> <?php echo $bancos[0]["Convenio"]; ?><br><?php } ?>
		<?php if($bancos[3]["NoCuenta"]){ ?><b>No. Cuenta:</b> <?php echo $bancos[0]["NoCuenta"]; ?><br><?php } ?>
		<?php if($bancos[3]["Clabe"]){ ?><b>Clabe interbancaria:</b> <?php echo $bancos[0]["Clabe"]; ?><br><?php } ?>
	</div>
<?php } ?>

	<!-- Fin del cuerpo de la hoja -->




</page>

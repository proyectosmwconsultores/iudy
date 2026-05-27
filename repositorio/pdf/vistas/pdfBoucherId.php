<?php
	require_once'../classprint.php';
	include("numeros.php");
	include("hace.php");
	$t=new Imprimir();
	$datos=$t->get_configuracion();
	$boucher=$t->get_boucherId(substr($_GET["tokenId"],10,10));
	$beca=$t->get_beca($boucher[0]['IdUsua'],substr($_GET["tokenId"],10,10));
	

	$recargo=$t->get_recargo($boucher[0]['IdUsua'],substr($_GET["tokenId"],10,10));
    $FecIns=date("Y-m-d");
	$valor = 0;
	$msj= 0;

    $bancos=$t->get_bancos($boucher[0]["IdOferta"],$boucher[0]["IdCampus"]);
    $bank=$t->get_bancos_id();

	$recargo = $boucher[0]["Recargos"];
	$descuento = ($boucher[0]["Descuento"] + $boucher[0]["Descuento2"] + $boucher[0]["TotalPagado"]);
	$pagar = ($boucher[0]["Monto"] + $recargo - $descuento);

	//$totPagar = ($boucher[0]["Monto"] - $boucher[0]["Descuento"]);
	//$totPagar = ($totPagar + $recargo[0]["Recargo"]);

	$txtF = $boucher[0]["Fecha"];

 

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
			FICHA DE PAGO</b></td>
		</tr>

		<tr Style="background: #fff9f9;">
			<td colspan="4" style="width: 460px; font-size: 12px; border: none; text-align: left; ">
			<?php if(($boucher[0]['IdGrado'] == 7) || ($boucher[0]['IdGrado'] == 8)){ echo ''; } else { ?> 
			<label><b style="font-size: 18px; color:#1ea45f;">FICHA DE PAGO VÁLIDO HASTA EL <?php echo fechaLetra($txtF); ?></b></label><br>
			<?php } ?>
			
			<label style="font-size: 10px; color: #71b956;">Fecha de descarga de la ficha: <?php echo $FecIns=date("Y-m-d h:i:s"); ?></label><br>
			</td>
		</tr>
		<tr style="background: #fff9f9;">
			<td colspan="2" style="width: 120px; font-size: 12px; border: none; text-align: right; color: #0b73b5;"><b>NOMBRE ALUMNO:</b></td>
			<td colspan="2" style="width: 380px; font-size: 12px; border: none; text-align: left; color: #0b73b5;"><?php echo $boucher[0]["Nombre"].' '.$boucher[0]["APaterno"].' '.$boucher[0]["AMaterno"]; ?></td>
		</tr>
		<tr style="background: #fff9f9;">
			<td colspan="2" style="width: 120px; font-size: 12px; border: none; text-align: right; color: #0b73b5;"><b>CONCEPTO:</b></td>
			<td colspan="2" style="width: 380px; font-size: 12px; border: none; text-align: left; color: #0b73b5;"><?php echo $boucher[0]["NomPlan"]; ?> DE <?php echo fec_Mes($boucher[0]["Fecha"]); ?></td>
		</tr>
		<tr style="background: #fff9f9;">
			<td colspan="2" style="width: 120px; font-size: 12px; border: none; text-align: right; color: #0b73b5;"><b>ESTATUS:</b></td>
			<td colspan="2" style="width: 380px; font-size: 12px; border: none; text-align: left; color: #0b73b5;"><?php echo $boucher[0]["Estatus"]; ?></td>
		</tr>
		<?php if($boucher[0]["_alfanumerica"]){ ?>
		<tr style="background: #fff9f9;">
			<td colspan="2" style="width: 120px; font-size: 12px; border: none; text-align: right; color: #0b73b5;"><b>ALFANUMERICA:</b></td>
			<td colspan="2" style="width: 380px; font-size: 12px; border: none; text-align: left; color: blue;"><?php echo $boucher[0]["_alfanumerica"]; ?></td>
		</tr>
		<tr style="background: #fff9f9;">
			<td colspan="2" style="width: 120px; font-size: 12px; border: none; text-align: right; color: #0b73b5;"><b>NUMERICA:</b></td>
			<td colspan="2" style="width: 380px; font-size: 12px; border: none; text-align: left; color: blue;"><?php echo $boucher[0]["_numerica"]; ?></td>
		</tr><?php } ?>

		<tr style="background: whitesmoke;">
			<td colspan="4" style="width: 560px; font-size: 12px; border: none; text-align: center; "><b style="font-size: 25px; color: #066db0;">
			Total pagar: $ <?php echo number_format($pagar, 2, '.', ','); ?></b></td>
		</tr>

		<tr style="background: #fff9f9;">
			<td style="width: 80px; font-size: 12px; border: none; text-align: center; "></td>
			<td  style="width: 100px; font-size: 12px; border: none; text-align: center; "></td>
			<td style="width: 180px; font-size: 12px; border: none; text-align: center; "></td>
			<td style="width: 200px; font-size: 12px; border: none; text-align: center; "></td>
		</tr>
	</table>


<div style="border: 1px solid #d2d6de; width: 669px; height: 15px; padding: 8px; font-size: 18px; text-align: center; ">
<b>CUENTAS DE BANCO DISPONIBLE <?php //echo $boucher[0]["Usuario"]; ?></b>

</div>
<?php for ($i=0;$i< sizeof($bancos);$i++) { ?>
    <div style="border: 1px solid #d2d6de; width: 669px; height: 60px; padding: 8px; font-size: 12px; ">
		<?php if($bancos[$i]["Nombre"]){ ?><b>Nombre:</b> <?php echo $bancos[$i]["Nombre"]; ?><br><?php } ?>
		<?php if($bancos[$i]["Banco"]){ ?><b>Banco:</b> <?php echo $bancos[$i]["Banco"]; ?><br><?php } ?>
		<?php if($bancos[$i]["Convenio"]){ ?><b>Convenio:</b> <?php echo $bancos[$i]["Convenio"]; ?><br><?php } ?>
		<?php if($bancos[$i]["NoCuenta"]){ ?><b>No. Cuenta:</b> <?php echo $bancos[$i]["NoCuenta"]; ?><br><?php } ?>
		<?php if($bancos[$i]["Clabe"]){ ?><b>Clabe interbancaria:</b> <?php echo $bancos[$i]["Clabe"]; ?><br><?php } ?>

	</div>

<?php } 
if($i == 0){ ?>
    <div style="border: 1px solid #d2d6de; width: 669px; height: 60px; padding: 8px; font-size: 12px; ">
		<?php if($bank[0]["Nombre"]){ ?><b>Nombre:</b> <?php echo $bank[0]["Nombre"]; ?><br><?php } ?>
		<?php if($bank[0]["Banco"]){ ?><b>Banco:</b> <?php echo $bank[0]["Banco"]; ?><br><?php } ?>
		<?php if($bank[0]["Convenio"]){ ?><b>Convenio:</b> <?php echo $bank[0]["Convenio"]; ?><br><?php } ?>
		<?php if($bank[0]["NoCuenta"]){ ?><b>No. Cuenta:</b> <?php echo $bank[0]["NoCuenta"]; ?><br><?php } ?>
		<?php if($bank[0]["Clabe"]){ ?><b>Clabe interbancaria:</b> <?php echo $bank[0]["Clabe"]; ?><br><?php } ?>

	</div>
<?php }
?>



	<!-- Fin del cuerpo de la hoja -->




</page>

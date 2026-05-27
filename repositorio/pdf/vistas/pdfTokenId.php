<?php

	require_once'../classprint.php';
	include("numeros.php");
	$t=new Imprimir();

	$datos=$t->get_configuracion();
	$token=$t->get_datosToken($_GET["token"]);
	$link = '../../tokenId.php?token='.$_GET["token"];

	$link = $datos[16]["Descripcion"];
	$inicio = $link;

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
<page backtop="50mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<div style= "width: 100%; position: absolute; ">
		<div style="float: left; width: 20%; margin-top:30px; margin-left: 50px;">

		</div>
		<div style="float: left; width: 100%; margin-top: -20px;">
		<table id="encabezado" style="border: none;">
			<tr class="fila">
				<td id="col_6" style="border: none">
					<span id="span1"><b style='color:#FE9900; '>

					<img src="./logoInicio.png" width="80px">
            </b></span>
				</td>
			</tr>
			<tr class="fila">
				<td id="col_6" style="border: none">
					<span id="span1"><b><br><?php echo $datos[1]["Descripcion"] ?></b></span>
					<br>
					<span id="span1"></span>
					<br>
					<span id="span2"> </span>
				</td>
			</tr>
		</table>
		</div>
	</div>




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


	<table border='0' cellpadding='0' style=" padding: 4px; background: #3b5868; color: #fff; ">
		<tr style="padding: 18px;">
			<td colspan='2' style="width: 650px; font-size: 18px; border: none; text-align: center; ">Confirmación de Registro en la Plataforma de Educación en Línea<br></td>
		</tr>
		<tr style="padding: 6px;">
			<td style="width: 200px; font-size: 11px; border: none; text-align: right; "><br><br>Alumno:</td>
			<td style="width: 320px; font-size: 11px; border: none; "><br><br><?php echo $token[0]["Nombre"]; ?></td>
		</tr>
		<tr style="padding: 6px;">
			<td style="width: 200px; font-size: 11px; border: none; text-align: right; ">Oferta Educativa:</td>
			<td style="width: 320px; font-size: 11px; border: none; "><?php echo $token[0]["NomOferta"]; ?></td>
		</tr>
		<tr style="padding: 6px;">
			<td style="width: 200px; font-size: 11px; border: none; text-align: right; ">Usuario:</td>
			<td style="width: 320px; font-size: 11px; border: none; "><?php echo $token[0]["Correo"]; ?></td>
		</tr>
		<tr style="padding: 6px;">
			<td style="width: 200px; font-size: 11px; border: none; text-align: right; ">Password:</td>
			<td style="width: 320px; font-size: 11px; border: none; "><?php echo $_GET["token"]; ?></td>
		</tr>
		<?php if($token[0]["Estatus"] == "Incompleto") { ?>
		<tr style="padding: 10px;">
			<td colspan='2' style="width: 540px; font-size: 18px; border: none; text-align: center; ">Para completar su registro dar clic aquí</td>
		</tr>
		<tr style="padding: 10px;">
			<td colspan='2' style="width: 540px; font-size: 18px; border: none; text-align: center; ">
			<a href='<?php echo $link; ?>'>
              <img src="./click.png" width="80px">
              </a>

			<br><br>
			</td>
		</tr><?php } else { ?>
		<tr style="padding: 10px;">
			<td colspan='2' style="width: 540px; font-size: 18px; border: none; text-align: center; ">Ya puede ingresar a la Plataforma de Educación en Línea</td>
		</tr>
		<tr style="padding: 10px;">
			<td colspan='2' style="width: 540px; font-size: 18px; border: none; text-align: center; ">
			<a href='<?php echo $inicio; ?>'>
              <img src="./ingresar.png" width="80px">
              </a>

			<br><br>
			</td>
		</tr>
		<?php } ?>
	</table>
	<!-- Fin del cuerpo de la hoja -->




</page>

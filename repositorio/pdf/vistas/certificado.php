<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	$t=new Imprimir();
	$datos=$t->get_certificado($_GET["Id"]);


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
<page backtop="40mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<div style= "width: 100%; position: absolute; background: red; ">

		<div style="float: left; width: 100%; background: #0b283e;">
			<img src="assets/images/campus/logo_inicio.png" style="width:150px; float: right;" >
		</div>
	</div>




	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<div style=" height: 80px; font-size: 24px;  width: 100%; text-align: center;">
		Este certificado avala a:
	</div>
	<div style=" height: 80px; font-size: 24px;  width: 100%; text-align: center;">
		<b><?php echo $datos[0][Nombre].' '.$datos[0][APaterno].' '.$datos[0][AMaterno]; ?></b>
	</div>
	<div style=" height: 80px; font-size: 24px;  width: 100%; text-align: center;">
		Por haber concluido satisfactoriamente
	</div>
	<div style=" height: 80px; font-size: 24px;  width: 100%; text-align: center;">
		el módulo <b><?php echo $datos[0][NombreMod]; ?></b> del
	</div>
	<div style=" height: 160px; font-size: 24px;  width: 100%; text-align: center;">
		<b><?php echo $datos[0][NomDiplomado]; ?></b>
	</div>
	<div style=" height: 50px; font-size: 24px;  width: 100%; text-align: center;">
		Fecha de conclusión del módulo: <?php echo $datos[0][FecFin]; ?>
	</div>
	<div style=" height: 50px; font-size: 24px;  width: 100%; text-align: center;">
		<?php echo $datos[0][Creditos]; ?> Créditos otorgados.
	</div>
	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

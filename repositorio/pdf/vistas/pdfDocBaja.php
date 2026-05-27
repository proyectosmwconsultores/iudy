<?php

	require_once'../classprint.php';
	include("hace.php");
	include("numeros.php");
	include("importe.php");
	$t=new Imprimir();
	//cadena en el 48
	$id = substr($_GET["tokenId"], 46);
	$consulta=$t->get_bajaUsua($id);
	$config=$t->get_configuracion();
	$pie  = $config[12]["Descripcion"];
	$porciones = explode("CP", $pie);

	//$baja=$t->get_datosBaja($id);
	// $datos=$t->get_datosUsuario($consulta[0]["IdUsua"]);
	// $datosCiclo=$t->get_datosCiclo($consulta[0]["IdPago"]);

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
<page backtop="70mm" backbottom="20mm" backleft="10mm" backright="10mm">
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
	<b style="font-size: 12px; margin-top: -145px; margin-left: 30px;"><?php echo $porciones[0]; ?></b><br>
	<b style="font-size: 12px; margin-left: 30px;"><?php echo 'CP'.$porciones[1]; ?></b>
	</page_footer>

  <div style="width: 727px; height: 80px; margin-left: -12px; text-align: justify; font-size: 13.5px;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		EL (LA) SUSCRITO(A) DIRECTOR(A) DE LAS LICENCIATURAS EN LA MODALIDAD EN LINEA
		DEL INSTITUTO DE ESTUDIOS SUPERIORES DE CHIAPAS PLANTEL TUXTLA, INCORPORADO AL SISTEMA ESTATAL,
		 CLAVE 07PU0142D.
	</div>

	<div style="width: 727px; height: 90px; margin-left: -12px; text-align: center; font-size: 18;"><br>
		<b>H A C E &nbsp;&nbsp;&nbsp;&nbsp; C O N S T A R </b>
	</div>

	<div style="width: 727px; height: 100px; margin-left: -12px; text-align: justify; font-size: 15px;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Que el (a) alumno (a) <b>C. <?php echo $consulta[0]["APaterno"].' '.$consulta[0]["AMaterno"].' '.$consulta[0]["Nombre"]; ?></b> con número de control <b><?php echo $consulta[0]["Matricula"]; ?>,</b>
		 del <b><?php echo obtenerLetraN($consulta[0]["SemCua"]); ?></b> Cuatrimestre de la <b><?php echo $consulta[0]["NomEducativa"]; ?>. </b> Ha causado <b><?php echo $consulta[0]["Estatus"]; ?>. </b>
	</div>

	<div style="width: 727px; height: 110px; margin-left: -12px; text-align: justify; font-size: 15px;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		A petición de la parte interesada y para los usos que mejor convengan, se
		extiende la presente en la ciudad de Tuxtla Gutiérrez Chiapas,a los <?php echo numeroMiniscula(substr($consulta[0]["FecCap"],8,2), false, false); ?> días del mes de <?php echo obtenerMesPrincipal($consulta[0]["FecCap"]); ?>
		del año <?php echo numeroMiniscula(substr($consulta[0]["FecCap"],0,4), false, false); ?>.

	</div>

	<div style="width: 727px; height: 80px; margin-left: -12px; text-align: center; font-size: 14px; font-weight: bold;">
		ATENTAMENTE <br>
		"<?php echo $config[21]["Descripcion"]; ?>" <br><br><br>

		__________________________________ <br>
		<?php echo $config[17]["Descripcion"]; ?><br>
		<?php echo $config[17]["Nombre"]; ?>

	</div>



	<!-- Fin del cuerpo de la hoja -->




</page>

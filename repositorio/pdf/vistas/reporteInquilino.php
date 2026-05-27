<?php
	require_once'../classprint.php';
	$t=new Imprimir();
	$tienda=$t->get_acta($_GET["Id"]);
	$datos=$t->get_configuracion();
	$datosActa=$t->get_datosacta($_GET["Id"]);
?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--
#encabezado {padding:10px 0; border-top: 1px solid; border-bottom: 1px solid; width:100%;}
#encabezado .fila #col_1 {width: 15%}
#encabezado .fila #col_2 {text-align:center; width: 70%}
#encabezado .fila #col_3 {width: 15%}
#encabezado .fila #col_4 {width: 15%}

#encabezado .fila td img {width:50%}
#encabezado .fila #col_2 #span1{font-size: 15px;}
#encabezado .fila #col_2 #span2{font-size: 12px; color: #4d9;}

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

tr:nth-child(even) {
    background-color: #dddddd;
}
#texto1 { width: 100px;}
-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="20mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header> <!-- Define el header de la hoja -->
		<table id="encabezado" style="border: none;">
            <tr class="fila">
                <td id="col_1" style="border: none" >
					

				</td>
                <td id="col_2" style="border: none">
					<span id="span1"><?php echo $datos[0]["Descripcion"] ?></span>
					<br>
					<span id="span1"><?php echo $datosActa[0]["Nombre"] ?></span>
					<br>
					<span id="span2">ACTA DE CALIFICACION FINAL</span>
				</td>

            </tr>
			<tr class="fila">

				<td colspan="4" style="border: none; text-align: right; padding-right: 50px;">
				<?php //echo $tiendadatos[0]["Tipo"].' - '.$tiendadatos[0]["Denominacion"]; ?><br>
				<?php //echo $tiendadatos[0]["Fecha"]; ?>
				</td>
			</tr>
        </table>
    </page_header>

    <page_footer> <!-- Define el footer de la hoja -->
		<table id="footer">
            <tr class="fila">
				<td style="border: none">
					<span><?php echo $datos[0]["Descripcion"] ?></span>
				</td>
			</tr>
        </table>
    </page_footer>
<?php $x= 0; for ($i=0;$i< 2;$i++) { ?>
    <!-- Define el cuerpo de la hoja -->
	<table>

		<?php   for ($i=0;$i< sizeof($tienda);$i++) { $x = $x + 1;
		$cal = 0;
		$cal = $tienda[$i]["Actividad1"] + $tienda[$i]["Actividad2"] + $tienda[$i]["Actividad3"] + $tienda[$i]["Actividad4"] + $tienda[$i]["Actividad5"] + $tienda[$i]["Actividad6"] + $tienda[$i]["Actividad7"] + $tienda[$i]["Actividad8"] + $tienda[$i]["Actividad9"] + $tienda[$i]["Actividad10"];
		 ?>
		<?php if($x == 1 ){  ?>
		<tr style="background: #DDD3D3; padding: 10px;">
			<td style="width: 30px;">No</td>
			<td style="width: 480px;">NOMBRE</td>
			<td style="width: 80px; text-align: center;">NÚMERO</td>

		</tr>
		<?php } ?>
		<tr>
		    <td style="width: 30px;"><?php echo $i + 1; ?></td>
		    <td style="width: 480px;"><?php echo $tienda[$i]["Nombre"].' '.$tienda[$i]["APaterno"].' '.$tienda[$i]["AMaterno"]; ?></td>
	            <td style="width: 80px; text-align: center;"><?php echo $cal; ?></td>



		</tr>
		<?php if($x==12) $x=0; } ?>
	</table>
    <!-- Fin del cuerpo de la hoja -->
	<?php } ?>
</page>

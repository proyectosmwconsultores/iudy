<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	include('../../hace.php');
	$t=new Imprimir();
	$IdAsignacion = $_GET["tokenId"];
	$AnioMes = $_GET["AnioMes"];
	$lstGrp=$t->get_lstAlumno($IdAsignacion);
	$encabz=$t->get_encabezado1($IdAsignacion);
	$campus=$t->get_campus_id($lstGrp[0]['IdCampus']);

	$_dias=$t->get_dias_clases($IdAsignacion,$AnioMes);
	$_user=$t->get_user_lista($IdAsignacion);
	$no_d = 0;
	 for ($s=0;$s< sizeof($_dias);$s++) {
		 $no_d = ($no_d + 1);
	 }
	 $no_d;
	 $cel = (330/$no_d);




?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
		font-size: 10px;

}

td, th {
    border: 1px solid #dddddd;
    padding: 4px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="68mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

    <img src="../../assets/images/campus/encabezado_formato.jpg" style="width: 100%;" >
    <table style='margin-top: -150px;'>
        <tr>
            <td style='width: 762px; text-align: center; border: none;'>
                <p style='font-size: 14px; color: #343f51;'>
                    <b style='font-size: 20px;'><?php echo $campus[0]['Campus']; ?></b><br>
                INCORPORADA EN LA SECRETARÍA DE EDUCACIÓN ESTATAL<br>
                REGISTRO ANTE DIRECCIÓN GENERAL DE PROFESIONES 070370<br>
                SUPERIOR CLAVE <?php echo $campus[0]['Clave']; ?><br><br>
                <b>FORMATO DE LISTA DE ASISTENCIA</b>
                </p>
            </td>
            <td style='width: 100px; border: none;'></td>
            <td style='width: 180px; text-align: center; border: none;'>
                <img src="../../assets/images/campus/logo_campus_formato.png" style="width: 130px; height: 130px;" >
            </td>
        </tr>
    </table>
    <table style='font-size: 12px; margin-left: 38px; margin-top: 15px;'>
		<tr>
			<td style="width: 100px; text-align: right;"><b>GRUPO:</b></td>
			<td style="width: 375px; "><?php echo $encabz[0]['CveGrupo']; ?></td>
			<td style="width: 100px; text-align: right;"><b>MODALIDAD:</b></td>
			<td style="width: 369px; "><?php echo $encabz[0]['_Modalidad']; ?> - <?php echo $encabz[0]['_Dias']; ?></td>
		</tr>
		<tr>
			<td style="width: 100px; text-align: right;"><b>OFERTA:</b></td>
			<td style="width: 375px; "><?php echo $encabz[0]['Educativa']; ?></td>
			<td style="width: 100px; text-align: right;"><b>MATERIA:</b></td>
			<td style="width: 369px; "><?php echo $encabz[0]['NombreMod']; ?></td>
		</tr>
		<tr>
			<td style="width: 100px; text-align: right;"><b>DOCENTE:</b></td>
			<td colspan='3' style="width: 375px; "><?php echo $encabz[0]['Nombre'].' '.$encabz[0]['APaterno'].' '.$encabz[0]['AMaterno']; ?></td>
		</tr>
	</table>



	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	<table>
		<tr>
			<td style="width: 550px; text-align: center; border: none; ">______________________________</td>
			<td style="width: 550px; text-align: center; border: none; ">______________________________</td>
		</tr>
		<tr>
			<td style="width: 550px; text-align: center; border: none;">Nombre y Firma del Docente</td>
			<td style="width: 550px; text-align: center; border: none;">Coordinación de Servicios Escolares</td>
		</tr>
	</table><br>
	<img src="../../assets/images/campus/pie_formato.jpg" style="width: 100%;" >
	<table style='font-size: 12px; margin-top: -65px;'>
        <tr>
            <td style='width: 660px; border: none;'>
                <p style='margin-left: 30px; color: #343f51; margin-top: -0px;'>
                <?php echo $campus[0]['Link']; ?><br>
                <?php echo $campus[0]['Direccion']; ?> <br>
                <?php echo $campus[0]['Ciudad']; ?>
                </p>
            </td>
            <td style='width: 400px; text-align: center; font-size: 12px; color: #fff; border: none;'><b>“<?php echo $campus[0]['Lema']; ?>”</b></td>
        </tr>
    </table>
	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table>
			<tr>
				<td rowspan='2' style="width: 15px;"><b>NO.</b></td>
				<td rowspan='2' style="width: 60px;"><b>CONTROL</b></td>
				<td rowspan='2' style="width: 280px"><b>NOMBRE</b></td>
				<td style="width: 180px; text-align: center;" colspan='10'><b>ASISTENCIAS E INASISTENCIAS</b></td>
				<td rowspan='2' style="width: 10px; text-align: center;"><b>A</b></td>
				<td rowspan='2' style="width: 10px; text-align: center;"><b>P</b></td>
				<td rowspan='2' style="width: 10px; text-align: center;"><b>F</b></td>
			</tr>
			<tr>

			<td style="text-align: center; width: 33px; font-size: 10px;"><b><?php if(isset($_dias[0]['Fecha'])){ echo obtener_dia($_dias[0]['Fecha']); }  else { echo "----"; } ?></b></td>
			<td style="text-align: center; width: 33px; font-size: 10px;"><b><?php if(isset($_dias[1]['Fecha'])){ echo obtener_dia($_dias[1]['Fecha']); }  else { echo "----"; } ?></b></td>
			<td style="text-align: center; width: 33px; font-size: 10px;"><b><?php if(isset($_dias[3]['Fecha'])){ echo obtener_dia($_dias[3]['Fecha']); }  else { echo "----"; } ?></b></td>
			<td style="text-align: center; width: 33px; font-size: 10px;"><b><?php if(isset($_dias[2]['Fecha'])){ echo obtener_dia($_dias[2]['Fecha']); }  else { echo "----"; } ?></b></td>
			<td style="text-align: center; width: 33px; font-size: 10px;"><b><?php if(isset($_dias[4]['Fecha'])){ echo obtener_dia($_dias[4]['Fecha']); }  else { echo "----"; } ?></b></td>
			<td style="text-align: center; width: 33px; font-size: 10px;"><b><?php if(isset($_dias[5]['Fecha'])){ echo obtener_dia($_dias[5]['Fecha']); }  else { echo "----"; } ?></b></td>
			<td style="text-align: center; width: 33px; font-size: 10px;"><b><?php if(isset($_dias[6]['Fecha'])){ echo obtener_dia($_dias[6]['Fecha']); }  else { echo "----"; } ?></b></td>
			<td style="text-align: center; width: 33px; font-size: 10px;"><b><?php if(isset($_dias[7]['Fecha'])){ echo obtener_dia($_dias[7]['Fecha']); }  else { echo "----"; } ?></b></td>
			<td style="text-align: center; width: 33px; font-size: 10px;"><b><?php if(isset($_dias[8]['Fecha'])){ echo obtener_dia($_dias[8]['Fecha']); }  else { echo "----"; } ?></b></td>
			<td style="text-align: center; width: 33px; font-size: 10px;"><b><?php if(isset($_dias[9]['Fecha'])){ echo obtener_dia($_dias[9]['Fecha']); }  else { echo "----"; } ?></b></td>




			</tr>
			<?php  $vx = 0;   for ($x=0;$x< sizeof($_user);$x++) { $vx = ($vx + 1); $cadena = "";
				 if(isset($_dias[0]['Fecha'])){ $_asis01=$t->get_valos_asis($IdAsignacion,$_user[$x]['IdUsua'],$_dias[0]['Fecha']); }
			 	 if(isset($_dias[1]['Fecha'])){$_asis02=$t->get_valos_asis($IdAsignacion,$_user[$x]['IdUsua'],$_dias[1]['Fecha']); }
			 	 if(isset($_dias[2]['Fecha'])){$_asis03=$t->get_valos_asis($IdAsignacion,$_user[$x]['IdUsua'],$_dias[2]['Fecha']); }
			 	 if(isset($_dias[3]['Fecha'])){$_asis04=$t->get_valos_asis($IdAsignacion,$_user[$x]['IdUsua'],$_dias[3]['Fecha']); }
			 	 if(isset($_dias[4]['Fecha'])){$_asis05=$t->get_valos_asis($IdAsignacion,$_user[$x]['IdUsua'],$_dias[4]['Fecha']); }
			 	 if(isset($_dias[5]['Fecha'])){$_asis06=$t->get_valos_asis($IdAsignacion,$_user[$x]['IdUsua'],$_dias[5]['Fecha']); }
			 	 if(isset($_dias[6]['Fecha'])){$_asis07=$t->get_valos_asis($IdAsignacion,$_user[$x]['IdUsua'],$_dias[6]['Fecha']); }
			 	 if(isset($_dias[7]['Fecha'])){$_asis08=$t->get_valos_asis($IdAsignacion,$_user[$x]['IdUsua'],$_dias[7]['Fecha']); }
			 	 if(isset($_dias[8]['Fecha'])){$_asis09=$t->get_valos_asis($IdAsignacion,$_user[$x]['IdUsua'],$_dias[8]['Fecha']); }
			 	 if(isset($_dias[9]['Fecha'])){$_asis10=$t->get_valos_asis($IdAsignacion,$_user[$x]['IdUsua'],$_dias[9]['Fecha']); }

				 if(isset($_asis01[0]['IdTipo'])){ $_as1 = $_asis01[0]['IdTipo']; } else { $_as1 = 0; }
				 if(isset($_asis02[0]['IdTipo'])){ $_as2 = $_asis02[0]['IdTipo']; } else { $_as2 = 0; }
				 if(isset($_asis03[0]['IdTipo'])){ $_as3 = $_asis03[0]['IdTipo']; } else { $_as3 = 0; }
				 if(isset($_asis04[0]['IdTipo'])){ $_as4 = $_asis04[0]['IdTipo']; } else { $_as4 = 0; }
				 if(isset($_asis05[0]['IdTipo'])){ $_as5 = $_asis05[0]['IdTipo']; } else { $_as5 = 0; }
				 if(isset($_asis06[0]['IdTipo'])){ $_as6 = $_asis06[0]['IdTipo']; } else { $_as6 = 0; }
				 if(isset($_asis07[0]['IdTipo'])){ $_as7 = $_asis07[0]['IdTipo']; } else { $_as7 = 0; }
				 if(isset($_asis08[0]['IdTipo'])){ $_as8 = $_asis08[0]['IdTipo']; } else { $_as8 = 0; }
				 if(isset($_asis09[0]['IdTipo'])){ $_as9 = $_asis09[0]['IdTipo']; } else { $_as9 = 0; }
				 if(isset($_asis10[0]['IdTipo'])){ $_as10 = $_asis10[0]['IdTipo']; } else { $_as10 = 0; }

				 //$cadena = $_asis01[0]['IdTipo'].'-'.$_asis02[0]['IdTipo'].'-'.$_asis03[0]['IdTipo'].'-'.$_asis04[0]['IdTipo'].'-'.$_asis05[0]['IdTipo'].'-'.$_asis06[0]['IdTipo'].'-'.$_asis07[0]['IdTipo'].'-'.$_asis08[0]['IdTipo'].'-'.$_asis09[0]['IdTipo'].'-'.$_asis10[0]['IdTipo'];
				 $cadena = $_as1.'-'.$_as2.'-'.$_as3.'-'.$_as4.'-'.$_as5.'-'.$_as6.'-'.$_as7.'-'.$_as8.'-'.$_as9.'-'.$_as10;

//die();
				?>
				<tr>
					<td style="width: 15px;"><?php echo $vx; ?>.-</td>
					<td style="width: 60px;"><?php echo $_user[$x]['Usuario']; ?></td>
					<td style="width: 280px"><?php echo $_user[$x]['APaterno'].' '.$_user[$x]['AMaterno'].' '.$_user[$x]['Nombre']; ?></td>

					<td style="text-align: center; font-size: 10px;"><?php if(isset($_asis01[0]['Letra'])){ echo $_asis01[0]['Letra']; } ?></td>
					<td style="text-align: center; font-size: 10px;"><?php if(isset($_asis02[0]['Letra'])){ echo $_asis02[0]['Letra']; } ?></td>
					<td style="text-align: center; font-size: 10px;"><?php if(isset($_asis03[0]['Letra'])){ echo $_asis03[0]['Letra']; } ?></td>
					<td style="text-align: center; font-size: 10px;"><?php if(isset($_asis04[0]['Letra'])){ echo $_asis04[0]['Letra']; }  ?></td>
					<td style="text-align: center; font-size: 10px;"><?php if(isset($_asis05[0]['Letra'])){ echo $_asis05[0]['Letra']; } ?></td>
					<td style="text-align: center; font-size: 10px;"><?php if(isset($_asis06[0]['Letra'])){ echo $_asis06[0]['Letra']; }  ?></td>
					<td style="text-align: center; font-size: 10px;"><?php if(isset($_asis07[0]['Letra'])){ echo $_asis07[0]['Letra']; } ?></td>
					<td style="text-align: center; font-size: 10px;"><?php if(isset($_asis08[0]['Letra'])){ echo $_asis08[0]['Letra']; } ?></td>
					<td style="text-align: center; font-size: 10px;"><?php if(isset($_asis09[0]['Letra'])){ echo$_asis09[0]['Letra']; } ?></td>
        	<td style="text-align: center; font-size: 10px;"><?php if(isset($_asis10[0]['Letra'])){ echo $_asis10[0]['Letra']; } ?></td>

					<td style="width: 10px; text-align: center;"><?php echo substr_count($cadena,"2") ?></td>
					<td style="width: 10px; text-align: center;"><?php echo substr_count($cadena,"3") ?></td>
					<td style="width: 10px; text-align: center;"><?php echo substr_count($cadena,"4") ?></td>
				</tr><?php } ?>

	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

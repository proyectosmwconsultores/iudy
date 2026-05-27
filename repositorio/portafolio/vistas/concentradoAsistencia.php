<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$IdAsignacion = $_GET["tokenId"];
	$lstGrp=$t->get_asistenia_concentrado($IdAsignacion);
	$encabz=$t->get_encabezado1($IdAsignacion);
	$campus=$t->get_campus_id($lstGrp[0]['IdCampus']);
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
<page backtop="51mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->


	<img src="../../assets/images/campus/encabezado_formato.jpg" style="width: 100%;" >
    <table style='margin-top: -115px;'>
        <tr>
            <td style='width: 515px; text-align: center; border:none;'>
                <p style='font-size: 12px; color: #343f51;'>
                    <b style='font-size: 18px;'><?php echo $campus[0]['Campus']; ?></b><br>
                INCORPORADA EN LA SECRETARÍA DE EDUCACIÓN ESTATAL<br>
                REGISTRO ANTE DIRECCIÓN GENERAL DE PROFESIONES 070370<br>
                SUPERIOR CLAVE <?php echo $campus[0]['Clave']; ?><br><br>
                <b>LISTA DE ASISTENCIA</b>
                </p>
            </td>
            <td style='width: 80px; border:none;'></td>
            <td style='width: 120px; text-align: center; border:none;'>
                <img src="../../assets/images/campus/logo_campus_formato.png" style="width: 100px; height: 100px;" >
            </td>
        </tr>
    </table>

	<table style='margin-left: 38px; margin-top: 10px;'>
		<tr>
			<td style="width: 80px; text-align: right;"><b>GRUPO:</b></td>
			<td style="width: 250px; "><?php echo $encabz[0]['CveGrupo']; ?></td>
			<td style="width: 75px; text-align: right;"><b>MODALIDAD:</b></td>
			<td style="width: 210px; "><?php echo $encabz[0]['_Modalidad']; ?> - <?php echo $encabz[0]['_Dias']; ?></td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: right;"><b>OFERTA:</b></td>
			<td style="width: 250px; "><?php echo $encabz[0]['Educativa']; ?></td>
			<td style="width: 75px; text-align: right;"><b>MATERIA:</b></td>
			<td style="width: 210px; "><?php echo $encabz[0]['NombreMod']; ?></td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: right;"><b>DOCENTE:</b></td>
			<td colspan='3' style="width: 375px; "><?php echo $encabz[0]['Nombre'].' '.$encabz[0]['APaterno'].' '.$encabz[0]['AMaterno']; ?></td>
		</tr>
	</table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table>
		<tr>
			<td style="width: 365px; text-align: center; border: none; ">_________________________________________</td>
			<td style="width: 365px; text-align: center; border: none; ">_________________________________________</td>
		</tr>
		<tr>
			<td style="width: 320px; text-align: center; border: none;">Nombre y Firma del Docente</td>
			<td style="width: 320px; text-align: center; border: none;">Coordinación de Servicios Escolares</td>
		</tr>
	</table><br>
	<img src="../../assets/images/campus/pie_formato.jpg" style="width: 100%;" >
	<table style='font-size: 10px; margin-top: -45px;'>
        <tr>
            <td style='width: 425px; border: none;'>
                <p style='margin-left: 30px; color: #343f51; margin-top: -2px;'>
                <?php echo $campus[0]['Link']; ?><br>
                <?php echo $campus[0]['Direccion']; ?> <br>
                <?php echo $campus[0]['Ciudad']; ?>
                </p>
            </td>
            <td style='width: 307px; text-align: center; font-size: 10px; color: #fff; border: none; '><b>“<?php echo $campus[0]['Lema']; ?>”</b></td>
        </tr>
    </table>
	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table>
			<tr>
				<td rowspan='2' style="width: 11px;"><b>NO.</b></td>
				<td rowspan='2' style="width: 50px;"><b>CONTROL</b></td>
				<td rowspan='2' style="width: 302px"><b>NOMBRE</b></td>
				<td colspan='3' style="width: 200px; text-align: center;"><b>TOTAL ASISTENCIA</b></td>
			</tr>
			<tr>
				<td style="width: 71px; text-align: center;"><b>ASISTENCIA</b></td>
				<td style="width: 71px; text-align: center;"><b>PERMISO</b></td>
				<td style="width: 71px; text-align: center;"><b>FALTA</b></td>
			</tr>
			<?php   for ($y=0;$y< sizeof($lstGrp);$y++) { $x = $x + 1; ?>
				<tr>
					<td style="width: 11px;"><?php echo $x; ?>.- </td>
					<td style="width: 50px;"><?php echo $lstGrp[$y]['Usuario']; ?></td>
					<td style="width: 302px"><?php echo $lstGrp[$y]['APaterno'].' '.$lstGrp[$y]['AMaterno'].' '.$lstGrp[$y]['Nombre']; ?></td>
					<td style="width: 71px; text-align: center;"><?php echo $lstGrp[$y]['A']; ?></td>
					<td style="width: 71px; text-align: center;"><?php echo $lstGrp[$y]['R']; ?></td>
					<td style="width: 71px; text-align: center;"><?php echo $lstGrp[$y]['F']; ?></td>
				</tr><?php } ?>

	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

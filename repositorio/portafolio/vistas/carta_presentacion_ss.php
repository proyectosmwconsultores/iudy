<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$tokenId = substr($_GET["tokenId"], 10,10);
	$serv=$t->get_const_ser_soc($tokenId);
	$firma=$t->get_lstFir($serv[0]['IdCampus'],3);
	$dat=$t->get_menDatos($serv[0]['IdGrupo']);

	$_SESSION["nom_file"] = 'CARTA_PRESENTACION_SERVICIO_SOCIAL_'.$serv[0]['Nombre'].' '.$serv[0]['APaterno'].' '.$serv[0]['AMaterno'];
	if($serv['0']['TipoCiclo'] == 'C'){ $_s = 'Cuatrimestre'; } else { $_s = 'Semestre'; }

?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--

table {
	/* font-family: arial, sans-serif; */
    font-family: Arial,sans-serif;

    border-collapse: collapse;
    width: 100%;
		font-size: 10px;

}

td, th {
    border: 0.5px solid black;
    padding: 2px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="40mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->


	<img src="../../assets/images/campus/encabezado_formato.jpg" style="width: 100%;" >

    <table style='margin-top: -115px;'>
        <tr>
            <td style='width: 530px; text-align: center; border:none;'>
                <p style='font-size: 10px; color: #343f51;'>
                    <b style='font-size: 18px;'><?php echo $dat[0]['Escuela']; ?></b><br>
                INCORPORADA EN LA SECRETARÍA DE EDUCACIÓN ESTATAL<br>
                REGISTRO ANTE DIRECCIÓN GENERAL DE PROFESIONES 070370<br>
                SUPERIOR CLAVE <?php echo $dat[0]['Clave']; ?><br><br>
                </p>
            </td>
            <td style='width: 80px; border:none;'></td>
            <td style='width: 120px; text-align: center; border:none;'>
                <img src="../../assets/images/campus/logo_campus_formato.png" style="width: 100px; height: 100px;" >
            </td>
        </tr>
    </table>



	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	<img src="../../assets/images/campus/pie_formato.jpg" style="width: 100%;" >
	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
		<table style="font-size: 9px; margin-left: 4px;">
			<tr>
				<td style="width: 675px; font-size: 12px; line-height: 1.2; text-align: right; border: none;">
				<?php echo $dat[0]['Localidad']; ?>
				<?php echo substr($serv[0]['FecCarta'], 8, 2); ?>/<?php echo substr($serv[0]['FecCarta'], 5, 2); ?>/<?php echo substr($serv[0]['FecCarta'], 0, 4); ?><br>
				<b>ASUNTO:</b> CARTA DE PRESENTACIÓN PARA SERVICIO SOCIAL<br>
				<b>NO. DE OFICIO:</b> <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $serv[0]['Folio_carta']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
				</td>
			</tr>
			<tr>
				<td style="width: 675px; font-size: 12px; line-height: 1.2; border: none;"><br><br>
				<b>A QUIEN CORRESPONDA</b><br><br><br>
				</td>
			</tr>
			<tr>
				<td style="width: 675px; font-size: 13px; border: none;">
				<p>
				Por &nbsp; este &nbsp; medio &nbsp; me &nbsp; permito &nbsp; saludarlo (a) cordialmente &nbsp; y &nbsp; al &nbsp; mismo &nbsp; tiempo &nbsp; presentar &nbsp; a usted &nbsp; al &nbsp; (a la) C.
				</p><br>
				<p style='line-height: 2.8px; word-spacing: 1.8px; text-align: center;'>
				<b><?php echo $serv[0]['Nombre'].' '.$serv[0]['APaterno'].' '.$serv[0]['AMaterno']; ?></b>
				</p><br>
				<p style='line-height: 2.8px; word-spacing: 1.8px;'>
				Quien &nbsp; se &nbsp; encuentra &nbsp; inscrito (a) en el <?php echo $serv[0]['Grado']; ?>°. <?php echo $_s; ?> &nbsp; de &nbsp; la &nbsp; carrera de:
				</p><br>
				<p style='line-height: 2.8px; word-spacing: 1.8px; text-align: center;'>
				<b><?php echo $serv[0]['Educativa']; ?></b>
				</p><br>
				<p style='text-align: justify;'>
				En el presente ciclo escolar año <?php echo substr($serv[0]['FecCarta'], 0, 4); ?>.<br><br>
				En &nbsp; virtud &nbsp; de haber &nbsp; alcanzado &nbsp; el 70% &nbsp; de &nbsp; los &nbsp; créditos de &nbsp; la &nbsp; carrera &nbsp; y &nbsp; conforme &nbsp; el &nbsp; reglamento,
				establecido, &nbsp; me &nbsp; dirijo &nbsp; a &nbsp; usted &nbsp; atentamente, solicitándole &nbsp; el &nbsp; apoyo &nbsp; necesario &nbsp; a &nbsp; fin de &nbsp; que &nbsp; realice &nbsp; el
				servicio &nbsp; social &nbsp; en el &nbsp; área &nbsp; asignada.
				</p><br>
				<p style='line-height: 2.8px; word-spacing: 1.8px; text-align: center;'>
				<b><?php echo $serv[0]['NomDependencia']; ?></b>
				</p><br>
				<p style='text-align: justify;'>
				En &nbsp; la &nbsp; institución &nbsp; a su digno &nbsp; cargo &nbsp; durante &nbsp; el &nbsp; periodo &nbsp; comprendido del:
				</p><br>
				<p style='line-height: 2.8px; word-spacing: 1.8px; text-align: center;'>
				<b><?php echo $serv[0]['Periodo']; ?></b>
				</p><br>
				<p style='text-align: justify;'>
				Hasta cubrir un total de <b>480 horas</b>.<br><br>
				En caso &nbsp; de aceptarlo (a) como &nbsp; prestador de &nbsp; servicio &nbsp; social, le &nbsp; solicito &nbsp; también &nbsp; expedir la respuesta
				a este &nbsp; documento la &nbsp; carta de &nbsp; aceptación y en &nbsp; su debido &nbsp; tiempo la &nbsp; carta de &nbsp; liberación, en &nbsp; esta última
				siempre y cuando &nbsp; cumpla conforme &nbsp; los lineamientos &nbsp; normativos establecidos.
				</p><br>
				<p style='text-align: center;'>
				Agradezco su atención y reitero a usted mi saludo muy cordial.
				</p><br><br><br>
				<p style='text-align: center;'>
				<b>Atentamente</b><br><br>
				<b style='font-size: 10px;'><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $firma[0]['Servicio']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b>
				<br>
				<b style='font-size: 10px;'>
				RESPONSABLE DE SERVICIOS ESCOLARES<br><?php echo $dat[0]['Escuela']; ?></b>

				</p>

				</td>
			</tr>
		</table>



	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

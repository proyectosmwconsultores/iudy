<?php
	$IdPer = 0;
	if(isset($_SESSION['Permisos'])){
		$IdPer = $_SESSION['Permisos'];
	}
	require_once'../classprint.php';
	include("numeros.php");
	include("hace.php");
	$t=new Imprimir();
	$IdDocs = substr($_GET['tokenId'],20,10);
	
    $val = $_GET['tokenId'];
	
	$datos=$t->get_datos_const($IdDocs);
	$IdDoss = isset($datos[0]['IdDocumento']);
	if(isset($IdDoss)){
	$grp=$t->get_grpt($datos[0]['IdGrupo']);
	//$tipS = substr($grp[0]['CveGrupo'],7,1);
	$tipS = $grp[0]['TipoCiclo'];
    $uni=$t->get_plataforma();
    $campus=$t->get_campus_id($grp[0]['IdCampus']);

	if($datos[0]['Sexo'] == 'H'){
		$alum = 'alumno';
		$insc = 'inscrito';
		$txt = 'el';
	} else {
		$alum = 'alumna';
		$insc = 'inscrita';
		$txt = 'la';
	}

	if($tipS == 'C'){
		$tip = 'cuatrimestre';
	} else {
		$tip = 'semestre';
	}

}



?>


<!-- page define la hoja con los márgenes señalados -->
<page backtop="20mm" backbottom="10mm" backleft="10mm" backright="10mm">

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
                
                </p>
            </td>
            <td style='width: 120px; border:none;'></td>
            <td style='width: 120px; text-align: center; border:none;'>
                <img src="../../assets/images/campus/logo_campus_formato.png" style="width: 100px; height: 100px;" >
            </td>
        </tr>
    </table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
    <img src="../../assets/images/campus/pie_formato.jpg" style="width: 100%;" >
	<table style='font-size: 10px; margin-top: -45px;'>
        <tr>
            <td style='width: 450px; border: none;'>
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
	<?php if(isset($IdDoss)){ ?>

	<p style='margin-top: 100px; text-align: right; font-family: arial, sans-serif; font-size: 16px; line-height: 30px;'>Tuxtla Gutiérrez, Chiapas a <?php echo obtFechConst($datos[0]['Fecha']); ?></p>
	<p style='margin-top: 30px; text-align: right; font-family: arial, sans-serif; font-size: 16px; line-height: 30px;'><b>Asunto:</b> Constancia de Estudios</p>
	<p style='margin-top: 50px; text-align: justify; font-family: arial, sans-serif; font-size: 16px; line-height: 30px;'><b>A quien corresponda:</b></p>
	<p style='margin-top: 30px; text-align: justify; font-family: arial, sans-serif; font-size: 16px; line-height: 30px;'>
	La Dirección de Servicios Escolares de la <?php echo $uni[0]['Descripcion']; ?><?php //echo $datos[0]['Escuela']; ?>
	con clave: <?php echo $datos[0]['Clave']; ?>, hace constar que <?php echo $txt.' '.$alum; ?>:
	 <b><?php echo $datos[0]['Nombre'].' '.$datos[0]['APaterno'].' '.$datos[0]['AMaterno']; ?></b>
	  con número de matrícula <b><?php echo $datos[0]['Usuario']; ?></b>
		es <?php echo $alum.' '.$insc; ?> en el <?php echo $datos[0]['SemCua']; ?>° <?php echo $tip; ?>
		de la <?php echo $datos[0]['Educativa']; ?>,
		modalidad <?php echo $datos[0]['Modalidad']; ?>,
		dentro del ciclo Escolar <?php echo $datos[0]['Ciclo']; ?>.
	</p>

	<p style='margin-top: 50px; text-align: justify; font-family: arial, sans-serif; font-size: 16px; line-height: 30px;'>A petición de la parte interesada y para los usos legales que le convengan, se extiende la presente constancia.</p>

	<p style='margin-top: 50px; text-align: justify; font-family: arial, sans-serif; font-size: 16px; margin-left: 70px; line-height: 30px;'>
	<b>A T E N T A M E N T E</b><br><br><br>
	___________________________________<br>
	Janeth Méndez Aguilar<br>
	Dirección de Servicios Escolares
	</p>
	<p style='margin-top: -175px; margin-left: 90px;'> <img src="../../assets/images/_firma.png" style='width: 230px' > </p>
	<p style='margin-top: -100px; margin-left: 515px;'> <img src="../../assets/images/qr/<?php echo $datos[0]['Anio'].'/'.$datos[0]['Mes']; ?>/<?php echo $datos[0]['IdDocumento']; ?>.png" style='width: 150px' > </p>

	<?php } ?>



	<!-- Fin del cuerpo de la hoja -->




</page>

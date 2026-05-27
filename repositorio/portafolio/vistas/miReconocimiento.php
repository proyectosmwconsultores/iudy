<?php
if($_SESSION['Permisos']){
	require_once'../portafolio.php';
	include('./../hace_fecha.php');
	$t=new Imprimir();
 	$IdGrupo = $_GET["idToks"];
	$rec=$t->get_imp_reconocimiento(substr($_GET["idToks"],10,10));
	$lugar = $rec[0]['Lugar']; $grad = $rec[0]['IdGrado']; 
	if($lugar == 1){ $_lug = "PRIMER LUGAR"; }
	if($lugar == 2){ $_lug = "SEGUNDO LUGAR"; }
	if($lugar == 3){ $_lug = "TERCER LUGAR"; }
	
	if($grad == 1){ $_txt = "del "; } else { $_txt = "de la ";}
	
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
    padding: 2px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="49mm" backbottom="5mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<img src="../../assets/images/campus/reconocimiento.jpg" style="width: 97%; margin-left: 15px;" >

    
	

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	
	</page_footer>
	<img src="../../assets/images/campus/logo_campus.png" style="width: 200px; margin-left: 750px; position: relative; margin-top: -100px; " >
    <div style="width: 1020px; height: 70px; margin-top: 155px;"></div>
    
    <div style="width: 767px; height: 50px; margin-left: 200px; color: #231942; font-size: 40px; "><b style=" margin-top: 7px;"><?php echo $rec[0]['Nombre'].' '.$rec[0]['APaterno'].' '.$rec[0]['AMaterno']; ?></b></div>
    <div style="width: 1020px; height: 70px; "></div>
    <div style="width: 590px; height: 100px; text-align: center; font-size: 20px; padding-left: 75px; ">
        <p>Por haber obtenido el <b style="color: #231942;"><?php echo $_lug; ?></b> de excelencia académica, <br> con un promedio de <?php echo $rec[0]['Promedio']; ?>
        durante el periodo escolar <br><?php echo $rec[0]['Ciclo'].' '.$_txt; ?> <br><b style="color: #231942;"><?php echo $rec[0]['Educativa']; ?>.</b></p>
    </div>
    <div style="width: 1020px; height: 105px; "></div>
    <div style="width: 1020px; height: 20px; margin-left: 115px; color: #231942; font-size: 14px; "><?php echo obtFechConst($rec[0]['Fecha']);  ?></div>
	

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

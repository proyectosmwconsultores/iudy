<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	
	$imp=$t->get_imprimir_();
?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--
table { font-family: arial, sans-serif; border-collapse: collapse; font-size: 12px;}
td, th { border: 1px solid #dddddd; padding: 2px; }

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="20mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	
	</page_footer>

	
			<?php $c = 0;   for ($y=0;$y< sizeof($imp);$y++) { $x = $x + 1; $c = ($c + 1); 
			if($c == 2){
			    $c = 0;
			}
			?>
			
			<div style="width: 200px; height: 453px; border: 2px dotted black; padding: 10px; background: red; position: relative; <?php if($c == 0){ echo ' margin-top: -483px; margin-left: 300px;';} else { echo 'width: 200px;  height: 453px;'; } ?>">
        hola - <?php echo $c; ?>
        <p><?php echo $x; ?></p>
            </div>
  
			<?php } ?>


</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>

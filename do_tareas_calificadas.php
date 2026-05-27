<?php $section = "Lista de actividades"; $_v = 93; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de la lista de actividades calificadas.'); }
if($_SESSION['Permisos']) {
	$t->get_validar_mat_doc($_GET["idToks"],$_SESSION['IdUsua']);
$IdParcial = $_GET['idParcial'];
$AsignacionId=$t->get_datosModuloD($_GET["idToks"]);
$alum=$t->get_alumnos_mat($_GET["idToks"]);
$tarx=$t->get_list_tar_mat($_GET["idToks"],$IdParcial);
if($AsignacionId[0]["NombreMod"]) {
$idV = $_GET["idToks"];
?>

		  <h1>
			<?php echo $AsignacionId[0]["NombreMod"];?>
		  </h1>

			<table class="table table-hover" style="font-size: 12px;">
				<tbody>
				<tr>
					<td style="width: 300px;">Nombre del alumno</td>
					<?php for ($tr=0;$tr< sizeof($tarx);$tr++) { ?>
					<td colspan="3" style="text-align: center; width: 600px; -webkit-transform: rotate(-90deg);  -moz-transform: rotate(-90deg); -o-transform: rotate(-90deg); transform: rotate(-90deg);"><?php echo substr($tarx[$tr]['NomActividad'], 0, 20).' ...'; ?></td>
					<?php } ?>
				</tr>
				<?php for ($tx=0;$tx< sizeof($alum);$tx++) { ?>
					<tr>
						<td style="width: 300px;"><?php echo $alum[$tx]['APaterno'].'-'.$alum[$tx]['AMaterno'].'-'.$alum[$tx]['Nombre']; ?></td>
						<?php for ($tr=0;$tr< sizeof($tarx);$tr++) {
							$vanx1 = "NO";
							$vanx2 = "NO";
							$vanx3 = "--";
							$t_id=$t->get_tarea_id($_GET["idToks"],$tarx[$tr]['IdActividadesDocente'],$alum[$tx]['IdUsua']);
							if(($t_id[0]['Link']) || ($t_id[0]['Link2']) || ($t_id[0]['Link3'])){
								$vanx1 = "SI";
							}
							if($t_id[0]['Calificacion']){
								$vanx2 = "SI";
								$vanx3 = $t_id[0]['Calificacion'];
							}
							?>
							<td style="background: #b97e78"><?php echo $vanx1; ?></td>
							<td style="background: #e6e6ff;"><?php echo $vanx2; ?></td>
							<td style="background: #babaf0;"><?php echo $vanx3; ?></td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
<?php
 unset($_SESSION['Alerta']); unset($_SESSION['Variable']);
 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
}
 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>

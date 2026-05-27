<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../../php/clases/class.System.php');
include('../../hace.php');
$db = new Conexion();
$IdOferta = $_POST['IdOferta'];
$IdCampus = $_POST['IdCampus'];
// $Tipo = $_POST['Tipo'];

$materias = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus'");

$sql_80 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$IdUsua' AND tblc_modulousuario.IdModulo = '80' ");
$db->rows($sql_80);
$_mod80 = $db->recorrer($sql_80);

?>

<div class="col-xs-12">
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Lista de las asignaturas</h3>
		</div>
		<div class="box-body">
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Clave</th>
						<th>Nombre de la asignatura</th>
						<th>Créditos</th>
						<th>HraDoc</th>
						<th>HraInd</th>
						<?php //if(isset($_mod80['IdModUsua'])) { ?>
						<th>Ajuste</th><?php //} ?>
					</tr>
				</thead>
				<tbody>
					<?php while ($_mat = $db->recorrer($materias)) {
						$id = $_mat["IdModulo"];
					?>
						<tr>
							<td><?php echo $_mat["Code"]; ?></td>
							<td><?php echo $_mat["CodeModulo"]; ?></td>
							<td><?php echo $_mat["NombreMod"]; ?></td>
							<td><?php echo $_mat["Creditos"]; ?></td>
							<td><?php echo $_mat["HraDoc"]; ?></td>
							<td><?php echo $_mat["HraInd"]; ?></td>
							<?php //if(isset($_mod80['IdModUsua'])) { ?>
							<td>
								<a onClick="mostrarMat(<?php echo $id; ?>)" href="javascript:void(0);">
									<button title="Materias de avance" type="button" class="btn btn-danger"><i class="fa fa-edit"></i></button>
								</a>
							</td><?php //} ?>
						</tr>
					<?php } ?>
					</tfoot>
			</table>
		</div>
	</div>
</div>
<script>
	$(function() {
		$('#example1').DataTable()
	})
</script>
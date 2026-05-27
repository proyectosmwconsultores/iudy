<?php $totalAlumnos=$t->get_totalAlumnos($AsignacionId[0]["IdModulo"],$AsignacionId[0]["Grupo"]); ?>
<div class="col-md-3">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Información</h3>
		</div>
		<div class="box-body">
			<strong><i class="fa fa-gears margin-r-5"></i> <?php echo $AsignacionId[0]["Tipo"];?></strong>
			<p class="text-muted">
				<?php echo $AsignacionId[0]["NombreMod"];?>
			</p>
			<hr>
			<strong><i class="fa fa-book margin-r-5"></i> Módulo <?php echo $AsignacionId[0]["NoModulo"]; ?></strong>
			<p class="text-muted"><?php echo $AsignacionId[0]["NombreMod"];?></p>
			<hr>
			<strong><i class="fa fa-group"></i> Grupo <?php echo $AsignacionId[0]["Grupo"]; ?></strong>
		</div>
	</div>
	<div class="box box-primary">
		<div class="box-body box-profile">
			<ul class="list-group list-group-unbordered">
				<li class="list-group-item">
					<b>Alumnos</b> <a class="pull-right"><?php echo $totalAlumnos[0]["Total"]; ?></a>
				</li>
				<li class="list-group-item">
					<b>Inicio</b> <a class="pull-right"><?php echo obtenerFechaCorta($AsignacionId[0]["FecIni"]); ?></a>
				</li>
				<li class="list-group-item">
					<b>Final</b> <a class="pull-right"><?php echo obtenerFechaCorta($AsignacionId[0]["FecFin"]); ?></a>
				</li>
			</ul>
			<?php if($section == "Formar Grupo"){ ?>
			<a onClick="window.open('doSelAsignatura.php?Id=<?php echo $_GET["Id"]; ?>','_self')" href="javascript:void(0);" class="btn btn-warning btn-block"><i class="fa fa-arrow-circle-left"></i> <b>Regresar</b></a>
			<?php } else { ?>
			<a onClick="window.open('doAddGrupo.php?Id=<?php echo $_GET["Id"]; ?>','_self')" href="javascript:void(0);" class="btn btn-primary btn-block"><b>Grupo</b></a>
			<?php } ?>
		</div>
	</div>
</div>

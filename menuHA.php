<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-<?php if($section=="Agregar Actividades"){ echo "red"; } else { echo "aqua";} ?>">
		<div class="inner">
			<p>Agregar actividades</p>
		</div>
		<div class="icon">
			<i class="ion ion-bag"></i>
		</div>
		<?php if($section=="Agregar Actividades"){ ?>
		<a onClick="window.open('doSelAsignatura.php?Id=<?php echo $_GET["Id"]; ?>','_self')" href="javascript:void(0);" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> Ir</i></a>
		<?php } else { ?>
		<a onClick="window.open('doAddActividades.php?Id=<?php echo $_GET["Id"]; ?>','_self')" href="javascript:void(0);" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
		<?php } ?>
	</div>
</div>
<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-<?php if($section=="Calificar actividades"){ echo "red"; } else { echo "aqua";} ?>">
		<div class="inner">
			<p>Calificar actividad</p>
		</div>
		<div class="icon">
			<i class="ion ion-bag"></i>
		</div>
		<?php if($section=="Calificar actividades"){ ?>
		<a onClick="window.open('doSelAsignatura.php?Id=<?php echo $_GET["Id"]; ?>','_self')" href="javascript:void(0);" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> Ir</i></a>
		<?php } else { ?>
		<a onClick="window.open('doAddCalificar.php?Id=<?php echo $_GET["Id"]; ?>','_self')" href="javascript:void(0);" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
		<?php } ?>
	</div>
</div>
<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-aqua">
		<div class="inner">
			<p>Recursos de apoyo</p>
		</div>
		<div class="icon">
			<i class="ion ion-bag"></i>
		</div>
		<a href="#" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
	</div>
</div>
<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-<?php if($section=="Datos del Módulos"){ echo "red"; } else { echo "aqua";} ?>">
		<div class="inner">
			<p>Información general</p>
		</div>
		<div class="icon">
			<i class="ion ion-bag"></i>
		</div>
		<?php if($section=="Datos del Módulos"){ ?>
		<a onClick="window.open('doSelAsignatura.php?Id=<?php echo $_GET["Id"]; ?>','_self')" href="javascript:void(0);" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> Ir</i></a>
		<?php } else { ?>
		<a onClick="window.open('doSelDatosM.php?Id=<?php echo $_GET["Id"]; ?>','_self')" href="javascript:void(0);" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
		<?php } ?>
	</div>
</div>
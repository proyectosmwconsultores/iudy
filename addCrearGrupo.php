<?php $section = "Agregar alumnos al grupo"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de agregar alumnos al grupo'); }
if(isset($_POST['txtOferta'])){ $_POST['txtOferta'] = $_POST['txtOferta']; } else { $_POST['txtOferta'] = ''; }
if(isset($_POST['txtCampus'])){ $_POST['txtCampus'] = $_POST['txtCampus']; } else { $_POST['txtCampus'] = ''; }
$oferta=$t->get_OfertaCoordinador($_SESSION['IdUsua']);
$campusId=$t->get_campusPermiso($_SESSION['IdUsua']);
$lstAlumnos=$t->get_alumnosProcess($_SESSION["IdUsua"]);

if(isset($_POST["Mov"]) && $_POST["Mov"]=="subExcel"){
  $t->add_excelGrupo();
  exit;
}

if(isset($lstAlumnos[0])){
    $lstGrupo=$t->get_grupoNuevo($lstAlumnos[0]['Oferta'],$lstAlumnos[0]['IdCampus']);
}

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">

	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-upload"></i> Agregar alumnos al grupo
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Módulos</a></li>
					<li class="active">Crear grupo</li>
				</ol>
			</section>
			<section class="content">
        <div class="box box-default">
          <div class="box-body">
            <div class="row">
			    <form name="frm" id="frm" action="addCrearGrupo.php" method="POST" enctype="multipart/form-data">
        		<input id="TipoGuardar" name="TipoGuardar" value="asigGrupo" type="hidden"/>
        		<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
        		<input id="Mov" name="Mov" value="" type="hidden"/>
        		<input id="Alerta" name="Alerta" value="<?php if(isset($_SESSION['Alerta'])){ echo $_SESSION['Alerta']; } ?>" type="hidden"/>


				    <?php if(!isset($lstAlumnos[0])){ ?>
			        <div class="col-md-6">
						<div class="form-group">
							<label>Plan de estudio:</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-gears"></i>
								</div>
								<select class="form-control select2" name="txtOferta" id="txtOferta">
									<option value=""> - Seleccione - </option>
									<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
									<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){ ?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Campus:</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-gears"></i>
								</div>
								<select class="form-control select2" name="txtCampus" id="txtCampus">
									<option value=""> - Seleccione - </option>
									<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
									<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"<?php if($_POST["txtCampus"]==$campusId[$i]["IdCampus"]){ ?>selected="selected"<?php }?>><?php echo $campusId[$i]["Campus"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>

						<div class="col-md-8">
							<div class="form-group">
								<label>Buscar archivo <b>excel(.xls)</b>:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-file-excel-o"></i>
									</div>
									<input type="file" class="form-control" name="txtArchivo" id="txtArchivo" onchange="validarExcel(this,'txtArchivo');">
								</div>
							</div>
						</div>
						<?php } if(isset($lstAlumnos[0])){ ?>
						<div class="col-md-8">
							<div class="form-group">
								<label>Seleccione grupo:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									</div>
									<select class="form-control select2" name="txtGrupo" id="txtGrupo">
    									<option value=""> - Seleccione - </option>
    									<?php for ($i=0;$i< sizeof($lstGrupo);$i++) { ?>
    									<option value="<?php echo $lstGrupo[$i]["IdGrupo"]; ?>"><?php echo $lstGrupo[$i]["Grado"].'° '.$lstGrupo[$i]["CveGrupo"].' - '.$lstGrupo[$i]["Ciclo"]; ?></option>
    									<?php } ?>
    								</select>
								</div>
							</div>
						</div>

                        <?php } ?>

						<div class="col-md-4">
							<div class="form-group">
								<label>Movimiento:</label>
								<div class="input-group">
										<?php if(isset($lstAlumnos[0])){ ?>
											<button type="button" class="btn bg-olive btn-flat" onClick="val_delRegistroExc()" style="float: right; margin-right: 5px;"><i class="fa fa-trash"></i> Eliminar</button>
											<button type="button" class="btn bg-navy btn-flat" onClick="val_closeGrupo()" style="float: right; margin-right: 5px;"><i class="fa fa-save"></i> Guardar alumnos</button>
										<?php } else { ?>
										<button type="button" class="btn bg-navy btn-flat" onClick="val_addExcel_alumnos()" style="float: right; margin-right: 5px;"><i class="fa fa-cloud-upload"></i> Subir excel</button>
										<button type="button" class="btn bg-olive btn-flat" onClick="window.open('assets/carga_masiva_alumnos.xls','_blank')" href="javascript:void(0);" style="float: right; margin-right: 5px;"><i class="fa fa-clipboard"></i> Layout</button>
										<?php } ?>

								</div>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none;">
								<div class="col-sm-12" style="text-align: center;">
										<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
								</div>
							</div>

							<div class="box">
								<div class="box-header">

									<h3 class="box-title"><i class="fa fa-fw fa-bookmark"></i> Lista de alumnos en proceso de alta</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
										<thead>
											<tr>
												<!-- <th>Grupo</th> -->
												<th>#</th>
											    <th>NO. CONTROL</th>
  												<th>NOMBRE DEL ALUMNO</th>
                          <th>SEXO</th>
                          <th>CAMPUS</th>
                          <th>PLAN DE ESTUDIOS</th>
                          <th>CORREO</th>
                          <th>CELULAR</th>
                          <th>FEC.NAC</th>
											</tr>
										</thead>
										<tbody id="tbtabl59">
											<?php for ($i=0;$i< sizeof($lstAlumnos);$i++) {
												if($lstAlumnos[$i]["IdEstatus"] == 29){ $txtT = "style='background: red'"; } else { $txtT =""; }
												 ?>
											<tr <?php echo $txtT; ?>>
												<td><?php echo $i+1; ?>.- </td>
												<td><?php echo $lstAlumnos[$i]["Usuario"]; ?></td>
												<td><?php echo $lstAlumnos[$i]["APaterno"].' '.$lstAlumnos[$i]["AMaterno"].' '.$lstAlumnos[$i]["Nombre"]; ?></td>
                        <td><?php echo $lstAlumnos[$i]["Sexo"]; ?></td>
                        <td><?php echo $lstAlumnos[$i]["Campus"]; ?></td>
                        <td><?php echo $lstAlumnos[$i]["Educativa"]; ?></td>
                        <td>
                          <?php echo $lstAlumnos[$i]["Correo"]; ?><br><?php echo $lstAlumnos[$i]["Correo_ins"]; ?></td>
                        <td><?php echo $lstAlumnos[$i]["Cel"]; ?></td>
												<td><?php echo $lstAlumnos[$i]["Nac"]; ?></td>
											</tr>
										<?php } ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div>


				</form>
        </div>
        </div>
        </div>
			</section>
		</div>
	  <?php include("footer.php"); ?>
	</div>




</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	if(alerta){
		if(alerta =="2"){
			swal("Error al subir", "Ha ocurrido un error, no se puede subir el archivo", "error");
		}
		if(alerta =="1"){
			swal("Guardado", "Registros del grupo guardado correctamente", "success");
		}
		if(alerta =="0"){
			swal("Error al guardar", "No se ha podido guardar los registros", "error");
		}
		if(alerta =="3"){
			swal("Eliminado correctamente", "La lista de usuarios se a eliminado correctamente", "success");
		}
		if(alerta =="8"){
			swal("Grupo cerrado", "El grupo se ha cerrado correctamente son sus nuevos alumnos", "success");
		}
	}
});


  $(function () {
    $('#example1').DataTable()
  })
</script>
</body>
</html>

<?php unset($_SESSION['Alerta']);  ?>

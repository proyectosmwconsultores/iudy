<?php $section = "Agregar calificaciones"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de subir calificaciones.'); }

if(isset($_POST["txtOferta"])){ $_POST["txtOferta"] = $_POST["txtOferta"]; } else { $_POST["txtOferta"] = ''; }
if(isset($_POST["txtCiclo"])){ $_POST["txtCiclo"] = $_POST["txtCiclo"]; } else { $_POST["txtCiclo"] = ''; }

$lstAlumnosCal=$t->get_alumnosCal($_SESSION["IdUsua"]);
if(isset($lstAlumnosCal[0])){
  $oferta=$t->get_ofertaId($lstAlumnosCal[0]["IdOferta"]);
  $ciclo=$t->get_cic_x_user($lstAlumnosCal[0]["Usuario"]);
  $docente=$t->get_lst_doc();
  // $asignatura=$t->get_asignatyraU($_POST["txtOferta"]);
  $asignatura=$t->get_asignatyraUD($lstAlumnosCal[0]["IdCampus"],$_POST["txtOferta"]);
}


if(isset($_POST["Mov"]) && $_POST["Mov"]=="subCal"){
  $t->add_calAlumnos();
  exit;
}

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">

	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1><i class="fa fa-fw fa-cloud-upload"></i> Subir calificaciones </h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Subir</a></li>
					<li class="active">Calificaciones</li>
				</ol>
			</section>
			<section class="content">
        <div class="box box-default">
          <div class="box-body">
        <form name="frm" id="frm" action="addSubirCal.php" method="POST" enctype="multipart/form-data">
      		<input id="TipoGuardar" name="TipoGuardar" value="asigGrupo" type="hidden"/>
      		<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
      		<input id="Mov" name="Mov" value="" type="hidden"/>
      		<input id="Alerta" name="Alerta" value="<?php if(isset($lstAlumnosCal[0]["Oferta"])){ echo $lstAlumnosCal[0]["Oferta"]; } ?>" type="hidden"/>

				<div class="row">
						<div class="col-md-7">
							<div class="form-group">
								<label>Buscar archivo <b>excel(.xls)</b>:</label>
                <div class="input-group">
                <input type="file" class="form-control" name="txtArchivo" id="txtArchivo" onchange="validarExcel(this,'txtArchivo');">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info btn-flat" onClick="val_addCal()">Subir excel</button>
                      <button type="button" class="btn bg-olive btn-flat" onclick="window.open('assets/carga_calificacion.xls','_blank')" href="javascript:void(0);" style="margin-right: 5px;"><i class="fa fa-clipboard"></i> Layout</button>
                    </span>
              </div>
							</div>
						</div>

            <div class="col-md-5">
							<div class="form-group">
								<label>Oferta:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-book"></i>
									</div>
                  <select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){  ?>selected="selected"<?php }?>><?php echo $oferta[$i]["Clave"].' - '.$oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
            <div class="col-md-6">
							<div class="form-group">
								<label>Asignatura:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									</div>
                  <select class="form-control" name="txtModulo" id="txtModulo" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($asignatura);$i++) { ?>
										<option value="<?php echo $asignatura[$i]["IdModulo"]; ?>"<?php if($_POST["txtModulo"]==$asignatura[$i]["IdModulo"]){  ?>selected="selected"<?php }?>><?php echo $asignatura[$i]["CodeModulo"].' - '.$asignatura[$i]["NombreMod"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
            <div class="col-md-6">
							<div class="form-group">
								<label>Ciclo escolar:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									</div>
                  <select class="form-control" name="txtCiclo" id="txtCiclo">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($ciclo);$i++) { ?>
										<option value="<?php echo $ciclo[$i]["IdCiclo"]; ?>"><?php echo $ciclo[$i]["Ciclo"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
            <div class="col-md-6">
							<div class="form-group">
								<label>Docente a cargo:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-user"></i>
									</div>
                  <select class="form-control" name="txtDocente" id="txtDocente">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($docente);$i++) { ?>
										<option value="<?php echo $docente[$i]["IdUsua"]; ?>"><?php echo $docente[$i]["Nombre"].' '.$docente[$i]["APaterno"].' '.$docente[$i]["AMaterno"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
            <div class="col-md-3">
							<div class="form-group">
								<label>Fecha de la calificación:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
                  <input type="text" name="txtFecha" id="txtFecha" class="form-control">
								</div>
							</div>
						</div>


						<div class="col-md-3">
							<div class="form-group">
								<label>Movimiento:</label> 
								<div class="input-group">
										<?php if(isset($lstAlumnosCal[0])){ ?>
											<button type="button" class="btn btn-danger" onClick="val_delCalExc()" style="float: right; margin-right: 5px;"><i class="fa fa-trash"></i> Eliminar</button>
                      <?php if(isset($_POST["txtModulo"])){ ?>
                      <button type="button" class="btn btn-success" onClick="val_saveCal(<?php echo $lstAlumnosCal[0]["IdGrupo"]; ?>,<?php echo $lstAlumnosCal[0]["IdCampus"]; ?>)" style="float: right; margin-right: 5px;"><i class="fa fa-lock"></i> Guardar</button>
										<?php } } ?>
										<!-- <button type="button" class="btn btn-success" onClick="val_addCal()" style="float: right; margin-right: 5px;"><i class="fa fa-cloud-upload"></i> Subir</button> -->

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
									<h3 class="box-title"><i class="fa fa-fw fa-database"></i> Lista de calificaciones en proceso de alta</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
										<thead>
											<tr>
												<!-- <th>Grupo</th> -->
												<th>NO. CONTROL</th>
                        <th>NOMBRE DEL ALUMNO</th>
												<th>GRUPO</th>
												<th style="text-align: center;">CAL.1</th>
												<th style="text-align: center;">CAL.2</th>
												<th style="text-align: center;">CAL.3</th>
												<th style="text-align: center;">CAL.4</th>
                        <th style="text-align: center;">EX.1</th>
                        <th style="text-align: center;">EX.2</th>
                        <th style="text-align: center;">ASIS.</th>
                        <th style="text-align: center;">FAL.</th>
												<th style="text-align: center;">PROMEDIO</th>
											</tr>
										</thead>
										<tbody id="tbtabl59">
											<?php for ($i=0;$i< sizeof($lstAlumnosCal);$i++) {
												if($lstAlumnosCal[$i]["IdEstatus"] == 29){ $txtT = "style='background: red'"; } else { $txtT =""; }
												 ?>
											<tr <?php echo $txtT; ?>>
                        <td><?php echo $lstAlumnosCal[$i]["Usuario"]; ?></td>
												<td><?php echo $lstAlumnosCal[$i]["APaterno"].' '.$lstAlumnosCal[$i]["AMaterno"].' '.$lstAlumnosCal[$i]["Nombre"]; ?></td>
                        <td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["CveGrupo"]; ?></td>
												<td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["P1"]; ?></td>
												<td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["P2"]; ?></td>
												<td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["P3"]; ?></td>
												<td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["P4"]; ?></td>
                        <td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["Ex1"]; ?></td>
                        <td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["Ex2"]; ?></td>
                        <td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["A"]; ?></td>
                        <td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["F"]; ?></td>
                        <td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["Promedio"]; ?></td>
											</tr>
										<?php } ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div>

				</div>
      </form>
      </div>
      </div>
			</section>
		</div>
	  <?php include("footer.php"); ?>
	</div>



	</form>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

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

    $('#txtFecha').datepicker({
      autoclose: true
    })

  })
</script>
</body>
</html>

<?php unset($_SESSION['Alerta']);  ?>

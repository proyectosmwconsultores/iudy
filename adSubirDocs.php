<?php
$section = "Subir reglamento"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por actualizar una asignaturas'); }
$lstCiclo=$t->get_periodoEsc();
$lstDocs=$t->get_docsLine();
if($_SESSION['Permisos']) {
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="uploadDocs"){
		$t->add_fileDocs();
		exit;
	}
}


?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-upload"></i> Subir reglamento por periodo escolar
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Periodo escolar</a></li>
        <li class="active">Reglamento</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
					  <form name="frm" id="frm" action="adSubirDocs.php" method="POST" enctype="multipart/form-data">
							<input id="Mov" name="Mov" value="" type="hidden"/>
						<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
						<div class="col-md-3">
						  <div class="box-primary">
								<div class="form-group">
									<label>Nivel:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									  </div>
										<select class="form-control" name="txtGrado" id="txtGrado">
											<option value=""> - Seleccione - </option>
											<option value="1">DOCTORADO</option>
											<option value="2">MAESTRÍA</option>
											<option value="3">LICENCIATURA</option>
											<option value="4">BACHILLERATO</option>
										</select>
									</div>
							  </div>
						  </div>
						</div>
					<div class="col-md-5">
					  <div class="box-primary">
							<div class="form-group">
								<label>Nombre del archivo:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-list-alt"></i>
								  </div>
								  <input class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre del archivo" type="text">
								</div>
							</div>
					  </div>
					</div>
					<div class="col-md-4">
						<div class="box-primary">
							<div class="form-group">
								<label>Periodo escolar:</label>
								<div class="input-group">
									<div class="input-group-addon">
									<i class="fa fa-qrcode"></i>
									</div>
									<select class="form-control" name="txtCiclo" id="txtCiclo">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
										<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if(isset($_POST["txtCiclo"])){ if($_POST["txtCiclo"]==$lstCiclo[$i]["IdCiclo"]){ ?>selected="selected"<?php } } ?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-8">
					  <div class="box-primary">
							<div class="form-group">
								<label>Buscar archivo:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-book"></i>
								  </div>
								  <input class="form-control" id="txtArchivo" name="txtArchivo" type="file">
								</div>
						  </div>
					  </div>
					  <!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box-primary">
							<div class="box-body">
							<div class="box-footer" style=" text-align: right;">
								<button type="button" class="btn btn-success" onClick="val_subFileDocs()"><i class="fa fa-fw fa-save"></i> Subir archivo </button>
							</div>
							</div>
						</div>
					</div>

					<div class="col-md-12" name="imgLoadDoAlum" id="imgLoadDoAlum" style="display: none;">
					    <div class="box-primary">
						    <div class="box-body">
								<div class="box-footer" style=" text-align: center;">
									<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
								</div>
						    </div>
					    </div>
					</div>
					<div class="col-md-12">

					</div>
					</form>
					<br><br><br><br>
          </div>
          <!-- /.row -->
        </div>
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
						<thead>
							<tr>
								<th>AJUSTE</th>
								<th>NIVEL</th>
								<th>PERIODO ESCOLAR</th>
								<th>NOMBRE</th>
								<th>FEC.CAP</th>
								<th>ESTATUS</th>
							</tr>
						</thead>
						<tbody>
							<?php for ($i=0;$i< sizeof($lstDocs);$i++) { ?>
							<tr id="<?php echo $lstDocs[$i]["IdDocs"]; ?>">
								<td>
									<button onclick="delFileDocs(<?php echo $lstDocs[$i]["IdDocs"]; ?>)" title="Eliminar archivo" type="button" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i></button>
									<button onclick="calenCampus(<?php echo $lstDocs[$i]["IdDocs"]; ?>)" title="Configurar documento" type="button" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i></button>
									<button title="Ver archivo" onClick="window.open('assets/docs/files/<?php echo $lstDocs[$i]["Anio"]; ?>/<?php echo $lstDocs[$i]["Mes"]; ?>/<?php echo $lstDocs[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-warning btn-sm"><i class="fa fa-file"></i></button>
								</td>
								<td><?php echo $lstDocs[$i]["_Grado"]; ?></td>
								<td><?php echo $lstDocs[$i]["Ciclo"]; ?></td>
								<td><?php echo $lstDocs[$i]["Nombre"]; ?></td>
								<td><?php echo $lstDocs[$i]["FecCap"]; ?></td>
								<td><?php echo $lstDocs[$i]["Estatus"]; ?></td>
							</tr>
							<?php } ?>
						</tfoot>
					</table>
				</div>
      </div>
    </section>

  </div>
  <?php include("footer.php"); ?>
</div>

<div id="dataGrp" class="modal fade"> <!--MODAL ME GUSTA-->
		 <div class="modal-dialog">
					<div class="modal-content">
							 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuración de documento</h4>
							 </div>
							 <div class="modal-body" id="employee_Grp">

							 </div>
					</div>
		 </div>
</div>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#example1').DataTable()
  })

	function calenCampus(IdDocs){
		var IdCampus = 0;
		$.ajax({
				 url:"formConsulta/calendarioCampus.php",
				 method:"POST",
				 data:{IdDocs:IdDocs, IdCampus:IdCampus},
				 success:function(data){
							$('#employee_Grp').html(data);
							$('#dataGrp').modal('show');
				 }
		});
	}

	$(document).ready(function(){
        $("#txtGrado").change(function () {
          $("#txtGrado option:selected").each(function () {
            IdGrado = $(this).val();
						if(IdGrado == 2){
							document.getElementById("op1").style.display = 'none';
							document.getElementById("op2").style.display = 'none';
							document.getElementById("op3").style.display = 'block';
							document.getElementById("op4").style.display = 'block';
						} else {
							document.getElementById("op1").style.display = 'block';
							document.getElementById("op2").style.display = 'block';
							document.getElementById("op3").style.display = 'none';
							document.getElementById("op4").style.display = 'none';
						}

          });
        })
      });
</script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>

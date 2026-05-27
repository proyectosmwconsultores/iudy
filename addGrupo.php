<?php $valor = 1; $section = "Crear claves de grupo"; include("head.php");
if($_SESSION['IdUsua']){  $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de crear claves de grupo'); }
if(isset($_GET["C"])){ $_POST["txtCampus"] = $_GET["C"]; }
if(isset($_GET["O"])){ $_POST["txtOferta"] = $_GET["O"]; }
if(isset($_POST["txtCampus"])){ $_POST["txtCampus"] = $_POST["txtCampus"]; } else { $_POST["txtCampus"] = ''; }
if(isset($_POST["txtOferta"])){ $_POST["txtOferta"] = $_POST["txtOferta"]; } else { $_POST["txtOferta"] = ''; }

$lstCampus=$t->get_lstCampusAc2($_SESSION['Permisos'],$_SESSION['IdUsua']);
$lstOferta=$t->get_ofertNb($_SESSION['Permisos'],$_SESSION['IdUsua']);


$get_grupo=$t->get_gruposTotal($_POST["txtCampus"],$_POST['txtOferta']);
 ?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1> Crear claves de grupo </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> Grupo</a></li>
        <li class="active">Crear claves de grupo como indentificador</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Crear clave como indentificador</h3>
        </div>
        <div class="box-body">
          <div class="row">
    		  <form name="frm" id="frm" action="addGrupo.php" method="POST" enctype="multipart/form-data">
    		  <input id="TipoGuardar" name="TipoGuardar" value="val_addCveGrp" type="hidden"/>
          <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden"/>

					<div class="col-md-4">
							<div class="form-group">
								<label>Campus/Escuela:</label>
								<div class="input-group">
									<div class="input-group-addon">
									<i class="fa fa-compass"></i>
									</div>
									<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCampus);$i++) { ?>
										<option value="<?php echo $lstCampus[$i]["IdCampus"]; ?>"<?php if($_POST['txtCampus']==$lstCampus[$i]["IdCampus"]){?>selected="selected"<?php } ?>><?php echo $lstCampus[$i]["Campus"]; ?></option>
										<?php } ?>
									</select>
								</div>
						</div>
					</div>
					<div class="col-md-8">
							<div class="form-group">
								<label>Oferta educativa:</label>
								<div class="input-group">
									<div class="input-group-addon">
									<i class="fa fa-compass"></i>
									</div>
									<select class="form-control select2" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstOferta);$i++) { ?>
										<option value="<?php echo $lstOferta[$i]["IdEducativa"]; ?>" <?php if($_POST['txtOferta']==$lstOferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php  echo $lstOferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
						</div>
					</div>
					<div class="col-md-4">
							<div class="form-group">
								<label>Clave de grupo:</label>
								<div class="input-group">
									<div class="input-group-addon">
									<i class="fa fa-key"></i>
									</div>
									<input class="form-control" id="txtClave" name="txtClave" placeholder="Clave" type="text">
								</div>
						</div>
					</div>
          <!-- <div class="col-md-6">
							<div class="form-group">
								<label>Generaci&oacute;n:</label>
								<div class="input-group">
									<div class="input-group-addon">
									<i class="fa fa-qrcode"></i>
									</div>
									<input class="form-control" id="txtPeriodo" name="txtPeriodo" placeholder="Periodo del grupo" type="text">
								</div>
						</div>
					</div> -->
					<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp;</label>
								<div class="input-group">

									<button type="button" class="btn btn-primary" onClick="val_addCveGrp()"><i class="fa fa-fw fa-save"></i> Guardar</button>
								</div>
						</div>
					</div>

			</form>
			<br>
          </div>
          <div class="row">
            <?php if(isset($get_grupo[0])){ for ($i=0;$i< sizeof($get_grupo);$i++) { ?>
            <div class="col-sm-4 col-md-2">
							<?php if($get_grupo[$i]["Tipo"] == "Cerrado"){ ?>
              <div class="color-palette-set view_grupo" href="javascript:void(0);" name="view" value="view" id="<?php echo $get_grupo[$i]["IdGrupo"]; ?>" style="cursor: pointer; ">
                <div class="bg-purple color-palette" style=" padding: 5px; margin-top: 5px; text-align: center; color: black; font-weight: bold;"><span><?php echo $get_grupo[$i]["CveGrupo"]; ?></span></div>
              </div>
						<?php } else { ?>
							<div class="color-palette-set  view_grupo" href="javascript:void(0);" name="view" value="view" id="<?php echo $get_grupo[$i]["IdGrupo"]; ?>" style="cursor: pointer; ">
                <div class="bg-red color-palette" style=" padding: 5px; margin-top: 5px; text-align: center; color: black; font-weight: bold;"><span><?php echo $get_grupo[$i]["CveGrupo"]; ?></span></div>
              </div>
						<?php } ?>
            </div>
          <?php } } ?>
          </div>

          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <div id="dataModalGrp" class="modal fade"> <!--MODAL ME GUSTA-->
       <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Configuración de grupo</h4>
                 </div>
                 <div class="modal-body" id="employee_detailGrp">
                 </div>
            </div>
       </div>
  </div>
  <!-- /.content-wrapper -->
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script>

$(document).ready(function(){
     $(document).on('click', '.view_grupo', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {
               $.ajax({
                    url:"formConsulta/updGrupo.php",
                    method:"POST",
                    data:{employee_id:employee_id},
                    success:function(data){
                         $('#employee_detailGrp').html(data);
                         $('#dataModalGrp').modal('show');
                    }
               });
          }
     });
});

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>

<?php $valor = 1; $section = "Crear claves de grupo"; include("head.php");
if($_SESSION['IdUsua']){  $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de crear claves de grupo'); }
if(isset($_GET["C"])){ $_POST["txtCampus"] = $_GET["C"]; }
if(isset($_GET["O"])){ $_POST["txtOferta"] = $_GET["O"]; }
if(isset($_POST["txtCampus"])){ $_POST["txtCampus"] = $_POST["txtCampus"]; } else { $_POST["txtCampus"] = ''; }
if(isset($_POST["txtOferta"])){ $_POST["txtOferta"] = $_POST["txtOferta"]; } else { $_POST["txtOferta"] = ''; }

$lstCampus=$t->get_campusPermiso($_SESSION["IdUsua"]);
//$lstOferta=$t->get_lstoFERTACampus($_POST["txtCampus"]);
$lst_oferta=$t->get_mis_ofertas($_SESSION['IdUsua']);


$get_grupo=$t->get_gruposTotal($_POST["txtCampus"],$_POST['txtOferta']);
 ?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-fw fa-cog"></i> Crear claves de grupo </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> Grupo</a></li>
        <li class="active">Crear claves de grupo como indentificador</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
    		  <form name="frm" id="frm" action="adAddCveGrupo.php" method="POST" enctype="multipart/form-data">
    		  <input id="TipoGuardar" name="TipoGuardar" value="val_adAddCveGrupo" type="hidden"/>
          <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden"/>

					<div class="col-md-5">
							<div class="form-group">
								<label>Campus:</label>
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
					<div class="col-md-7">
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
                  <?php if(($_POST['txtCampus']) && ($_POST['txtOferta'])){ ?>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary" onClick="crear_grupo()"><i class="fa fa-fw fa-qrcode"></i> Crear grupo</button>
                    </span>
                  <?php } ?>
								</div>
						</div>
					</div>
					<!-- <div class="col-md-4">
							<div class="form-group">
								<label>Clave de grupo:</label>
								<div class="input-group">
									<div class="input-group-addon">
									<i class="fa fa-key"></i>
									</div>
									<input class="form-control" maxlength="10" id="txtClave" name="txtClave" placeholder="Clave" type="text">
								</div>
						</div>
					</div>
          <div class="col-md-4">
							<div class="form-group">
								<label>Generaci&oacute;n:</label>
								<div class="input-group">
									<div class="input-group-addon">
									<i class="fa fa-qrcode"></i>
									</div>
									<input class="form-control" id="txtPeriodo" name="txtPeriodo" placeholder="Periodo del grupo" type="text">
								</div>
						</div>
					</div>
					<div class="col-md-4">
							<div class="form-group">
								<label>&nbsp;</label>
								<div class="input-group">

                  <button type="button" class="btn btn-success" onClick="val_adAddCveGrupo()"><i class="fa fa-fw fa-save"></i> Guardar</button>
									<button type="button" class="btn btn-default" onClick="vstAyuda()"><i class="fa fa-fw fa-question-circle"></i> Ayuda</button>

								</div>
						</div>
					</div> -->

			</form>
			<br>
          </div>
          <div class="row">
            <?php if(isset($get_grupo[0])){ for ($i=0;$i< sizeof($get_grupo);$i++) {
              $id_e = $get_grupo[$i]['IdEstatus'];
              if($id_e == 12){ $cols = 'purple'; } elseif($id_e == 8){ $cols = 'navy'; } elseif($id_e == 55){ $cols = 'maroon'; }
               ?>
            <div class="col-sm-4 col-md-2">
              <div class="color-palette-set view_grupo" href="javascript:void(0);" name="view" value="view" id="<?php echo $get_grupo[$i]["IdGrupo"]; ?>" style="cursor: pointer; ">
                <div class="bg-<?php echo $cols; ?> color-palette" style=" padding: 5px; margin-top: 5px; text-align: center; color: black; font-weight: bold;"><span><?php echo $get_grupo[$i]["Grado"].'° '.$get_grupo[$i]["CveGrupo"]; ?></span></div>
              </div>
            </div><?php } ?>
          <?php }  ?>
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
                 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuración de grupo</h4>
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
<div id="dataModalModFue"  class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-question-circle"></i> Ayuda para generar clave de grupo</h4>
               </div>
               <div class="modal-body" id="employee_detailModFue">
               </div>
          </div>
     </div>
</div>
<div id="dataDocsx"  class="modal fade">
       <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Crear clave de grupo</h4>
                 </div>

                 <div class="modal-body" id="employee_docsx">
                 </div>
            </div>
       </div>
  </div>
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

function vstAyuda(){
  $.ajax({
       url:"formConsulta/vstAyuda.php",
       method:"POST",
       data:{},
       success:function(data){
            $('#employee_detailModFue').html(data);
            $('#dataModalModFue').modal('show');
       }
  });
}

function crear_grupo(){
  var IdCampus = document.getElementById("txtCampus").value;
  var IdOferta = document.getElementById("txtOferta").value;
  $.ajax({
       url:"formConsulta/add_grupo.php",
       method:"POST",
       data:{IdCampus:IdCampus, IdOferta:IdOferta},
       success:function(data){
            $('#employee_docsx').html(data);
            $('#dataDocsx').modal('show');
       }
  });
}

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

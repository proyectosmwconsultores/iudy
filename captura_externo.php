<?php $valor = 3; $section = "Captura de alumno"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por agregar un nuevo usuario'); }
if(isset($_GET["Grp"])){ $_POST["txtGrupo"] = $_GET["Grp"]; }
if(isset($_GET["Cal"])){ $_POST["txtPlan"] = $_GET["Cal"]; }

if(isset($_POST["txtGrupo"])){ $_POST["txtGrupo"] = $_POST["txtGrupo"]; } else { $_POST["txtGrupo"] = ''; }
if(isset($_POST["txtPlan"])){ $_POST["txtPlan"] = $_POST["txtPlan"]; } else { $_POST["txtPlan"] = ''; }

$get_grupo=$t->get_grupos_cuc();
$get_mat=$t->get_matr_cur($_POST["txtGrupo"]);
$plan=$t->get_plan_pag($_POST["txtGrupo"]);

?>

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Captura de usuarios externos
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Usuarios</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="captura_externo.php" method="POST" enctype="multipart/form-data">
      <input id="TipoGuardar" name="TipoGuardar" value="add_alumno_ex" type="hidden"/>
      <input id="IdSeriacion" name="IdSeriacion" value="<?php if(isset($get_mat[0]['IdSeriacion'])){ echo $get_mat[0]['IdSeriacion']; } ?>" type="hidden"/>
      <div class="box box-default">

        <div class="box-body">
          <div class="row">
            <?php if(!isset($get_mat[0]['IdSeriacion'])){ ?>
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-ban"></i> Alerta</h4>
                  No puede capturar este usuario externo ya que no se ha configurado el número de control.
                </div>
              </div><?php }   ?>
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Grupo:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                      <i class="fa fa-compass"></i>
                      </div>
                      <select class="form-control select2" name="txtGrupo" id="txtGrupo" onchange="document.frm.submit();">
                        <option value=""> - Seleccione - </option>
                        <?php for ($i=0;$i< sizeof($get_grupo);$i++) { ?>
                        <option value="<?php echo $get_grupo[$i]["IdGrupo"]; ?>" <?php if($_POST['txtGrupo']==$get_grupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php  echo $get_grupo[$i]["CveGrupo"]; ?> - <?php  echo $get_grupo[$i]["Nombre"]; ?> - <?php  echo $get_grupo[$i]["Ciclo"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Plan de pago:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                      <i class="fa fa-compass"></i>
                      </div>
                      <select class="form-control select2" name="txtPlan" id="txtPlan" id="txtGrupo" onchange="document.frm.submit();">
                        <option value=""> - Seleccione - </option>
                        <?php for ($i=0;$i< sizeof($plan);$i++) { ?>
                        <option value="<?php echo $plan[$i]["IdCalendario"]; ?>" <?php if($_POST['txtPlan']==$plan[$i]["IdCalendario"]){?>selected="selected"<?php }?>><?php  echo $plan[$i]["NomPlan"]; ?> / ($ <?php  echo $plan[$i]["Monto"]; ?>)</option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Celular:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                      <i class="fa fa-phone"></i>
                      </div>
                      <input onchange="validar_cel()" maxlength="10" class="form-control" id="txtTelefono" name="txtTelefono" data-inputmask='"mask": "(999) 999-9999"' data-mask type="text">
                    </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Tipo usuario:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                    </div>
                    <select class="form-control" name="txtTipo" id="txtTipo">
                      <option value="">- Seleccione -</option>
                      <option value="PUBLICO GENERAL"> PÚBLICO EN GENERAL</option>
                      <option value="CONVENIO"> CONVENIO</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Descuento:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                    <i class="fa fa-money"></i>
                    </div>
                    <input class="form-control" id="txtDescuento" name="txtDescuento" value="0" type="text">
                  </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Nombre:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                  <i class="fa fa-user"></i>
                  </div>
                  <input class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" type="text">
                </div>
            </div>
          </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label>A. Paterno:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                    </div>
                    <input class="form-control" id="txtAPaterno" name="txtAPaterno" placeholder="Paterno" type="text">
                  </div>
              </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>A. Materno:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                      </div>
                      <input class="form-control" id="txtAMaterno" name="txtAMaterno" placeholder="Materno" type="text">
                    </div>
                </div>
              </div>

              <div class="col-md-3">
                  <div class="form-group">
                    <label>Sexo:</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-user"></i></div>
                      <select class="form-control select2" name="txtSexo" id="txtSexo">
                      <option value=""> - Seleccione - </option>
                      <option value="F"> MUJER </option>
                      <option value="M"> HOMBRE </option>
                      </select>
                    </div>
                </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label>Correo:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                      <i class="fa fa-envelope"></i>
                      </div>
                      <input class="form-control" id="txtCorreo" name="txtCorreo" placeholder="Enter email" type="email">
                    </div>
                </div>
              </div>
              <?php if(isset($get_mat[0]['IdSeriacion'])){ ?>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <div class="input-group">
                      <button id="btn_sav" type="button" class="btn btn-success" onClick="add_alumno_ex()"><i class="fa fa-fw fa-save"></i> Guardar</button>
                      <button type="button" class="btn btn-primary" onClick="search_user()"><i class="fa fa-fw fa-search"></i> Buscar</button>
                    </div>
                </div>
              </div><?php } ?>
              <div class="col-xs-12">
								<div class="box" id="mi_lista_materias"></div>
							</div>


          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
      </form>
    </section>
    <!-- /.content -->
  </div>
  <div id="dataModal3"  class="modal fade">
       <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-fw fa-users"></i> Buscar usuario en la Plataforma</h4>
                 </div>

                 <div class="modal-body" id="employee_detail3">
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
<!-- Page script -->
<script>

  $(function () {
    var IdGrupo = document.getElementById("txtGrupo").value;
    var IdPlan = document.getElementById("txtPlan").value;
    if((IdGrupo) && (IdPlan)){
      cargar_listax_usId(IdGrupo,IdPlan);
    }
  })

  function cargar_listax_usId(IdGrupo,IdPlan){
    document.getElementById("mi_lista_materias").style.display = 'block';
    var Capa = "#mi_lista_materias";
    $(Capa).load("dashboard/rep_usuarios_curso.php",{IdGrupo:IdGrupo, IdPlan:IdPlan}, function(response, status, xhr) {
      if (status == "error") {
        var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
  }

  $(function () {
    $('.select2').select2()

  })

  function validar_cel(){
    var Celular = document.getElementById("txtTelefono").value;
		var Tipo = "buscar_celular";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, Celular:Celular }, function(data){
			if(data == 1){
        swal("Error al guardar", "Este número de celular ya se encuentra activo, favor de realizar la captura mediante el buscador.", "error");
        document.getElementById("btn_sav").style.display = 'none';
      } else {
        document.getElementById("btn_sav").style.display = 'block';
      }
		});
  }

  function search_user(){
    var IdGrupo = document.getElementById("txtGrupo").value;
    var IdPlan = document.getElementById("txtPlan").value;
    var IdUsua = 0;
    var Descuento = 0;
    $.ajax({
         url:"formConsulta/usuario_plataforma.php",
         method:"POST",
         data:{IdGrupo:IdGrupo,IdPlan:IdPlan, IdUsua:IdUsua, Descuento:Descuento},
         success:function(data){
              $('#employee_detail3').html(data);
              $('#dataModal3').modal('show');
         }
    });
  }

  function del_pago_curx(IdPago){
    var IdGrupo = document.getElementById("txtGrupo").value;
    var IdPlan = document.getElementById("txtPlan").value;
    var TipoGuardar = "del_pagocuxx";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea eliminar el usuario y el pago de este curso?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Aceptar',
      cancelButtonText: "Cancelar",
    },
    function (isConfirm) {
      if(isConfirm) {
        $(".confirm").attr('disabled', 'disabled');
        $.ajax({
             url:"formConsulta/setting.php",
             method:"POST",
             data:{TipoGuardar:TipoGuardar, IdPago:IdPago},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Eliminado correctamente", "El usuario y pago se ha eliminado correctamente.", "success");

            cargar_listax_usId(IdGrupo,IdPlan);

  				}
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });

  }
</script>
</body>
</html>

<?php $valor = 3; $section = "Captura de alumno"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por agregar un nuevo usuario'); }
if(isset($_GET["C"])){ $_POST["txtCampus"] = $_GET["C"]; }
if(isset($_GET["O"])){ $_POST["txtOferta"] = $_GET["O"]; }

if(isset($_POST["txtCampus"])){ $_POST["txtCampus"] = $_POST["txtCampus"]; } else { $_POST["txtCampus"] = ''; }
if(isset($_POST["txtOferta"])){ $_POST["txtOferta"] = $_POST["txtOferta"]; } else { $_POST["txtOferta"] = ''; }
if(isset($_POST["txtGrupo"])){ $_POST["txtGrupo"] = $_POST["txtGrupo"]; } else { $_POST["txtGrupo"] = ''; }

$lstCampus=$t->get_campusPermiso($_SESSION["IdUsua"]);
$lstOferta=$t->get_lstoFEst4s($_POST["txtCampus"],$_SESSION['IdUsua']);

$lstAlumnos=$t->get_lstalumnosPro($_POST["txtCampus"],$_POST["txtOferta"],$_POST["txtGrupo"]);

$get_grupo=$t->get_gruposLib($_POST["txtCampus"],$_POST['txtOferta']);
$get_mat=$t->get_matrLib($_POST["txtCampus"],$_POST['txtOferta']);

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
        Captura de alumnos
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Usuarios</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="adAddAlumno.php" method="POST" enctype="multipart/form-data">
      <input id="TipoGuardar" name="TipoGuardar" value="add_alumno" type="hidden"/>
      <input id="Mov" name="Mov" value="" type="hidden"/>
      <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
      <input id="IdSeriacion" name="IdSeriacion" value="<?php if(isset($get_mat[0]['IdSeriacion'])){ echo $get_mat[0]['IdSeriacion']; } ?>" type="hidden"/>
      <div class="box box-default">

        <div class="box-body">
          <div class="row">
            <?php if((isset($_POST["txtCampus"])) && (isset($_POST['txtOferta']))){
              if(!isset($get_mat[0]['IdSeriacion'])){ ?>
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-ban"></i> Alerta</h4>
                  No puede capturar este alumno ya que no se ha configurado la matrícula, favor de configurar primero la matrícula para este campus y oferta educativa.
                </div>
              </div><?php }  } ?>
              <div class="col-md-4">
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
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Oferta educativa:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                      <i class="fa fa-compass"></i>
                      </div>
                      <select class="form-control select2" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
                        <option value=""> - Seleccione - </option>
                        <?php for ($i=0;$i< sizeof($lstOferta);$i++) { ?>
                        <option value="<?php echo $lstOferta[$i]["IdOferta"]; ?>" <?php if($_POST['txtOferta']==$lstOferta[$i]["IdOferta"]){?>selected="selected"<?php }?>><?php  echo $lstOferta[$i]["Nombre"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Grupo:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                      <i class="fa fa-compass"></i>
                      </div>
                      <select class="form-control select2" name="txtGrupo" id="txtGrupo" onchange="document.frm.submit();">
                        <option value=""> - Seleccione - </option>
                        <?php for ($i=0;$i< sizeof($get_grupo);$i++) { ?>
                        <option value="<?php echo $get_grupo[$i]["IdGrupo"]; ?>" <?php if($_POST['txtGrupo']==$get_grupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php  echo $get_grupo[$i]["CveGrupo"]; ?></option>
                        <?php } ?>
                      </select>
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
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Sexo:</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-user"></i></div>
                      <select class="form-control select2" name="txtSexo" id="txtSexo">
                      <option value=""> - Seleccione - </option>
                      <option value="M"> MUJER </option>
                      <option value="H"> HOMBRE </option>
                      </select>
                    </div>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Teléfono:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                      <i class="fa fa-phone"></i>
                      </div>
                      <input class="form-control" id="txtTelefono" name="txtTelefono" data-inputmask='"mask": "(999) 999-9999"' data-mask type="text">
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
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Matrícula:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                      <i class="fa fa-envelope"></i>
                      </div>
                      <input class="form-control" id="txtMatr" name="txtMatr" placeholder="Seriación de matrícula" type="text" value="<?php if(isset($get_mat[0]["Matricula"])){ echo $get_mat[0]["Matricula"]; } ?>" disabled>
                    </div>
                </div>
              </div>
              <?php if(isset($get_mat[0]["Matricula"])){ ?>
              <div class="col-md-12">
                  <div class="box-primary">
                    <div class="box-body">
                    <div class="box-footer" style=" text-align: center;">
                      <button type="button" class="btn btn-success" onClick="add_alumno()"><i class="fa fa-fw fa-save"></i> Guardar</button>
                    </div>
                    </div>
                  </div>
                <!-- /.box -->
              </div><?php } ?>
              <?php if(isset($lstAlumnos[0])){ ?>
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Ajuste</th>
                      <th>Nombre</th>
                      <th>Campus</th>
                      <th>Oferta</th>
                      <th>Grupo</th>
                      <th>Matricula</th>
                    </tr>
                  </thead>
                  <tbody id="tbtabl59">
                    <?php for ($i=0;$i< sizeof($lstAlumnos);$i++) {
                       ?>
                    <tr id="<?php echo $lstAlumnos[$i]["IdUsua"]; ?>">
                      <td><?php echo $i+1; ?></td>
                      <td>
                        <button type="button" class="btn btn-danger btn-sm" onClick="delAlumno(<?php echo $lstAlumnos[$i]["IdUsua"]; ?>)"><i class="fa fa-fw fa-trash"></i></button>
                        <button title="Llenar cédula de inscripción" type="button" class="btn btn-warning btn-sm" onClick="window.open('adCaptura.php?idToks=<?php echo time().$lstAlumnos[$i]["IdUsua"]; ?>&Ub=A','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i></button>
                        <!-- <button title="Imprimir cédula de inscripción" type="button" class="btn btn-danger btn-sm" onclick="javascript:window.open('repositorio/pdf/cedula.php?idToks=<?php echo time().$lstAlumnos[$i]["IdUsua"]; ?>');" href="javascript:void(0);"><i class="fa fa-fw fa-print"></i></button>
                        <button title="Imprimir carta compromiso" type="button" class="btn btn-info btn-sm" onclick="javascript:window.open('repositorio/pdf/cartaCompromiso.php?idToks=<?php echo time().$lstAlumnos[$i]["IdUsua"]; ?>');" href="javascript:void(0);"><i class="fa fa-fw fa-print"></i></button> -->
                      </td>
                      <td><?php echo $lstAlumnos[$i]["APaterno"].' '.$lstAlumnos[$i]["AMaterno"].' '.$lstAlumnos[$i]["Nombre"]; ?></td>
                      <td><?php echo $lstAlumnos[$i]["Campus"]; ?></td>
                      <td><?php echo $lstAlumnos[$i]["Oferta"]; ?></td>
                      <td><?php echo $lstAlumnos[$i]["CveGrupo"]; ?></td>
                      <td><?php echo $lstAlumnos[$i]["Usuario"]; ?></td>
                    </tr>
                  <?php } ?>
                  </tfoot>
                </table>
              </div>
            <?php } ?>

          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
      </form>
    </section>
    <!-- /.content -->
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
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
//Money Euro
    $('[data-mask]').inputmask()
    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
  $(function () {
    $('#example1').DataTable()
  })
  $(function () {
    $('.select2').select2()

  })
</script>
</body>
</html>

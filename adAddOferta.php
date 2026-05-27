<?php $valor = 1; $section = "Plan de estudio"; include("head.php");
if($_SESSION['IdUsua']){  $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por agregar un nuevo plan de estudio.'); }

$oferta=$t->get_misOfertas();

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
      <h1><i class="fa fa-fw fa-folder-open"></i> Plan de estudio</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> Agregar</a></li>
        <li class="active">Plan de estudio</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
      		  <form name="frm" id="frm" action="adAddOferta.php" method="POST" enctype="multipart/form-data">
      		  <input id="TipoGuardar" name="TipoGuardar" value="val_adAddOferta" type="hidden"/>
            <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden"/>
                  <div class="col-md-2">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Clave:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
          						  <input maxlength="10" class="form-control" id="txtClave" name="txtClave" placeholder="Clave" type="text">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-5">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Nombre del plan de estudio:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-book"></i>
          						  </div>
          						  <input class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" type="text">
          						</div>
          					</div>
          			  </div>
          			</div>
          			<div class="col-md-3">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Tipo:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <select class="form-control" name="txtTipo" id="txtTipo">
          							<option value=""> - Seleccione - </option>
          							<option value="1"> DOCTORADO </option>
          							<option value="2"> MAESTRIA </option>
                        <option value="3"> LICENCIATURA </option>
                        <option value="4"> BACHILLERATO </option>
                        <option value="7"> DIPLOMADO</option>
                        <option value="8"> CURSO</option>
                        <option value="9"> CERTIFICACION</option>
          							<!-- <option value="5"> Secundaria </option>
                        <option value="6"> Diplomado </option>
          							<option value="7"> Curso </option> -->
          						  </select>
          						</div>
          					</div>
          			  </div>
          			</div>
          			<div class="col-md-2">
          			    <div class="box-primary">
          				    <div class="box-body">
          						<div class="box-footer" style=" text-align: center;">
          							<button type="button" class="btn btn-success" onClick="val_adAddOferta()"><i class="fa fa-fw fa-save"></i> Guardar</button>
          						</div>
          				    </div>
          			    </div>
          			</div>
      			</form>

          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-bookmark"></i> Actualizar informaci&oacute;n</h3>
              </div>
              <div class="box-body">
                <table class="table table-striped" style="font-size: 12px;">
                  <tbody>
                    <tr>
                      <th>CLAVE</th>
                      <th>NOMBRE</th>
                      <th></th>
                    </tr>
                    <?php for ($i=0;$i< sizeof($oferta);$i++) { 	$id= $oferta[$i]["IdEducativa"]; $tok = time(); $toks = $tok.$id; ?>
                    <tr>
                      <td><?php echo $oferta[$i]["Clave"]; ?></td>
                      <td><?php echo $oferta[$i]["Nombre"]; ?></td>
                      <td>
                          <button onClick="mostrar_materias(<?php echo $oferta[$i]["IdEducativa"]; ?>)" href="javascript:void(0);" title="Editar plan de estudio" type="button" class="btn bg-purple btn-flat btn-sm"><i class="fa fa-book"></i></button>
                          <button onClick="window.open('adUpdOferta.php?IdEducativa=<?php echo $toks; ?>','_self')" href="javascript:void(0);" title="Editar plan de estudio" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-edit"></i></button>
                      </td>
                    </tr>
                    <?php } ?>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

          </div>


        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>

  <div id="dataModalModFue"  class="modal fade">
       <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><span class="glyphicon glyphicon-check"></span> Lista de materias</h4>
                 </div>
                 <div class="modal-body" id="employee_detailModFue">
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
    $("#txtServicio").change(function () {
      $("#txtServicio option:selected").each(function () {
        idServicio = $(this).val();
        if(idServicio == 1){
           document.getElementById("Campus").style.display = 'none';
        } else {
          document.getElementById("Campus").style.display = 'block';
        }
      });
    })
  });

  function mostrar_materias(IdOferta){
    $.ajax({
         url:"vistas/admin/lista_materias.php",
         method:"POST",
         data:{IdOferta:IdOferta},
         success:function(data){
              $('#employee_detailModFue').html(data);
              $('#dataModalModFue').modal('show');
         }
    });
  }


  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>

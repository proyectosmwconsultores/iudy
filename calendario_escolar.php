<?php $valor = 3; $section = "Altas"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de creación de calendario escolar'); }

$lstCalendario=$t->get_lst_calendario_esc();
if(isset($_POST["Mov"]) && $_POST["Mov"]=="upLogo"){
		$t->up_logo();
		exit;
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
        <i class="fa fa-fw fa-calendar"></i> Configuración de calendario escolar
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Calendario</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="calendario_escolar.php" method="POST" enctype="multipart/form-data">
      <div class="box box-default">

        <div class="box-body">
          <div class="row">
              <div class="col-md-12">
                  <div class="box-primary">
                    <div class="box-footer" style=" text-align: right;">
                      <button type="button" class="btn btn-primary" onClick="new_calendario()"><i class="fa fa-plus-circle"></i> Crear calendario</button>
                    </div>
                  </div>
              </div>
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped"  style="font-size: 12px;">
                  <thead>
                    <tr>
                      <th></th>
											<th>PERIODO ESCOLAR</th>
											<th>NOMBRE DEL CALENDARIO</th>
                      <th>MODALIDAD</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php for ($i=0;$i< sizeof($lstCalendario);$i++) { ?>
                    <tr>
                      <td>
												<button title="Actualizar calendario" type="button" class="btn bg-maroon btn-flat btn-sm" onclick="edit_calendario(<?php echo $lstCalendario[$i]["IdCalendario"]; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i></button>
                        <button title="Configurar calendario" type="button" class="btn bg-orange btn-flat btn-sm" onclick="config_calendario(<?php echo $lstCalendario[$i]["IdCalendario"]; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-cog"></i></button>
                      </td>
											<td><?php echo $lstCalendario[$i]["Ciclo"]; ?></td>
											<td><?php echo $lstCalendario[$i]["Nombre"]; ?></td>
                      <td><?php echo $lstCalendario[$i]["_Modalidad"]; ?></td>
                    </tr>
                  <?php } ?>
                  </tfoot>
                </table>
              </div>

              <div class="col-md-12" style="display: none;" id='divLogo'>
                <input name="id_Cam" id='id_Cam' value="0" type="hidden">
                <input name="Alerta" id='Alerta' value="<?php if(isset($_SESSION['Alerta'])){ echo $_SESSION['Alerta']; } ?>" type="hidden">
                <input name="Mov" id='Mov' value="" type="hidden">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Cargar logo del campus/escuela</h3>
                </div>

                <div class="box-body">
                  <label for="exampleInputFile">Logo del campus/escuela</label>
                  <div class="input-group input-group-sm">
                    <input name="txtLogo" id="txtLogo" type="file" class="form-control">
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-info btn-flat" onclick="loadLogo()"><i class="fa fa-fw fa-cloud-upload"></i> Cargar logo</button>
                        </span>
                  </div>
                  <p class="help-block"><b>Nota:</b> La imagen debe ser cuadrada por ejemplo: 500* 500px; transparente (png)</p>

                </div>

              </div>

            </div>

          </div>

        </div>
      </div>

      </form>
    </section>

  </div>
  <!-- /.content-wrapper -->
  <?php include("footer.php"); ?>
</div>
<div id="dataModalModFue"  class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-check"></span> Configuración de calendario escolar</h4>
               </div>
               <div class="modal-body" id="employee_detailModFue">
               </div>
          </div>
     </div>
</div>

<div id="dataModalC"  class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-check"></span> Configuración de fechas del calendario escolar</h4>
               </div>
               <div class="modal-body" id="employee_detailC">
               </div>
          </div>
     </div>
</div>

<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

function cargarLogo(IdCampus){
  document.getElementById("id_Cam").value = IdCampus;
  document.getElementById("divLogo").style.display = "block";
  // document.getElementById("id_p").value = Nombre;
}
function new_calendario(){
  $.ajax({
       url:"formConsulta/addCalendario.php",
       method:"POST",
       data:{},
       success:function(data){
            $('#employee_detailModFue').html(data);
            $('#dataModalModFue').modal('show');
       }
  });
}

function edit_calendario(IdCalendario){
  $.ajax({
       url:"formConsulta/updCalendario_escolar.php",
       method:"POST",
       data:{IdCalendario:IdCalendario},
       success:function(data){
            $('#employee_detailModFue').html(data);
            $('#dataModalModFue').modal('show');
       }
  });
}

function config_calendario(IdCalendario){
	var IdFecha = 0;
  $.ajax({
       url:"formConsulta/addFecha_parcial.php",
       method:"POST",
       data:{IdCalendario:IdCalendario, IdFecha:IdFecha},
       success:function(data){
            $('#employee_detailC').html(data);
            $('#dataModalC').modal('show');
       }
  });
}

  $(function () {
    $('#example1').DataTable()
  })

  function loadLogo(){
  	if (document.frm.txtLogo.value.length==''){
  		swal("Error al guardar", "Debe seleccionar el logo.", "error");
          document.getElementById("txtLogo").focus();
          return 0;
      }


  	swal({
  		title: "\u00BFEst\u00E1 seguro que subir este logo?",
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: '#DD6B55',
  		confirmButtonText: 'Aceptar',
  		cancelButtonText: "Cancelar",
  	},
    function (isConfirm) {
  		if (isConfirm) {
  			document.frm.Mov.value='upLogo';document.frm.submit();
  			return true;
  		} else {
  			return false;
  		}
  	});
  }

  $(document).ready(function(){
    var alerta = document.frm.Alerta.value;
    if(alerta){
      if(alerta =="0"){
        swal("Error", "Error no se ha podido subir el logo.", "error");
      }
      if(alerta =="1"){
        swal("Guardado", "El logo se ha subido correctamente.", "success");
      }
    }
  });

</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>

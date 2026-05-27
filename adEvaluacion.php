<?php $valor = 3; $section = "Tipo de evaluaciones"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está el el modulo de altas de tipos de evaluaciones'); }

$lstEva=$t->get_tipoEvaluacion();

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
        <i class="fa fa-fw fa-gg"></i> Tipos de evaluaciones
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Evaluaciones</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="adEvaluacion.php" method="POST" enctype="multipart/form-data">
      <div class="box box-default">

        <div class="box-body">
          <div class="row">
              <div class="col-md-12">
                  <div class="box-primary">
                    <div class="box-footer" style=" text-align: right;">
                      <button type="button" class="btn btn-primary" onClick="newEvaluacion()"> <i class="fa fa-fw fa-plus-circle"></i> Nuevo</button>
                    </div>
                  </div>
              </div>
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
                  <thead>
                    <tr>
                      <th></th>
                      <th>NOMBRE DE LA EVALUACIÓN</th>
                      <th>EVALUACIÓN PARA</th>
                      <th>ESTATUS</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php for ($i=0;$i< sizeof($lstEva);$i++) { ?>
                    <tr>
                      <td>
                        <button title="Preguntas" type="button" class="btn bg-purple btn-flat btn-sm" onClick="window.open('adPreguntas.php?idToks=<?php echo time().$lstEva[$i]["IdTipoEvaluacion"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-question-circle"></i></button>
                        <button title="Actualizar nombre" type="button" class="btn bg-maroon btn-flat btn-sm" onclick="editEvaluacion(<?php echo $lstEva[$i]["IdTipoEvaluacion"]; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i></button>
                        <?php if($lstEva[$i]["IdEstatus"] == 8){ ?>
                        <button title="Configurar evaluación" type="button" class="btn bg-navy btn-flat btn-sm" onclick="setting_eva(<?php echo $lstEva[$i]["IdTipoEvaluacion"]; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-gears"></i></button>
                        <?php } ?>
                      </td>
                      <td><?php echo $lstEva[$i]["Evaluacion"]; ?></td>
                      <td><?php echo $lstEva[$i]["Permiso"]; ?></td>
                      <td><?php echo $lstEva[$i]["Estatus"]; ?></td>
                    </tr>
                  <?php } ?>
                  </tfoot>
                </table>
              </div>

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
<div id="dataModalModFue"  class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuración de evaluación</h4>
               </div>
               <div class="modal-body" id="employee_detailModFue">
               </div>
          </div>
     </div>
</div>
<div id="dataModal5" class="modal fade"> <!--MODAL ME GUSTA-->
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-gears"></i> Configurar evaluación</h4>
               </div>
               <div class="modal-body" id="employee_detail5">
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
function newEvaluacion(){
  $.ajax({
       url:"formConsulta/addEvaluacion.php",
       method:"POST",
       data:{},
       success:function(data){
            $('#employee_detailModFue').html(data);
            $('#dataModalModFue').modal('show');
       }
  });
}

function editEvaluacion(IdTipo){
  $.ajax({
       url:"formConsulta/updEvaluacion.php",
       method:"POST",
       data:{IdTipo:IdTipo},
       success:function(data){
            $('#employee_detailModFue').html(data);
            $('#dataModalModFue').modal('show');
       }
  });
}

  $(function () {
    $('#example1').DataTable()
  })

  function setting_eva(IdTipoEvaluacion){
  	var IdCampus = 0;
  	$.ajax({
  			 url:"formConsulta/configurar_evaluacion.php",
  			 method:"POST",
  			 data:{IdTipoEvaluacion:IdTipoEvaluacion, IdCampus:IdCampus},
  			 success:function(data){
  						$('#employee_detail5').html(data);
  						$('#dataModal5').modal('show');
  			 }
  	});
  }

</script>
</body>
</html>

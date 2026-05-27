<?php $valor = 3; $section = "Altas"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está el el modulo de altas'); }

//$t->get_sincornizacion();
$lstCampus=$t->get_lstCampusN();
if(isset($_POST["Mov"]) && $_POST["Mov"]=="upLogo"){
		$t->up_logo();
		exit;
	}
	
//	$alumnost =  $t->alumnos_beca_alumnos();
	

	
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
        <i class="fa fa-fw fa-gears"></i> Configuración inicial
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Configuración</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="adAltas.php" method="POST" enctype="multipart/form-data">
      <div class="box box-default">
<?php //$dat =  $t->validar_beca_alumnos(); ?>
        <div class="box-body">
          <div class="row">
              <div class="col-md-12">
                  <div class="box-primary">
                    <div class="box-footer" style=" text-align: right;">
                      <button type="button" class="btn btn-primary" onClick="newCampus()"><i class="fa fa-plus-circle"></i> Nuevo</button>
                    </div>
                  </div>
              </div>
              <div class="box-body">
                  <!--
                  <table class="table table-bordered table-striped"  style="font-size: 12px;">
                  <thead>
                    <tr>
					  <th>CAMPUS</th>
                      <th>OFERTA</th>
                      <th>MATRICULA</th>
                      <th>NOMBRE</th>
                      <th>MONTO MENSUALIDAD</th>
                      <th>DESCUENTO MENSUALIDAD</th>
                      <th>PAGAR MENSUALIDAD</th>
                      <th>MONTO INSCRIPCION</th>
                      <th>DESCUENTO INSCRIPCION</th>
                      <th>PAGAR INSCRIPCION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php //for ($i=0;$i< sizeof($alumnost);$i++) { 
                    //$mens =  $t->get_datos_conpceot_id($alumnost[$i]["IdUsua"], 54, 2);
                    //$reins =  $t->get_datos_conpceot_id($alumnost[$i]["IdUsua"], 54, 3);
                    //if(!isset($reins[0])){
                     //   $reins =  $t->get_datos_conpceot_id($alumnost[$i]["IdUsua"], 54, 1);
                    //}
                    ?>
                    <tr>
                      <td><?php //echo $alumnost[$i]["Campus"]; ?></td>
                      <td><?php //echo $alumnost[$i]["Educativa"]; ?></td>
                      <td><?php //echo $alumnost[$i]["Usuario"]; ?></td>
                      <td><?php //echo $alumnost[$i]["Nombre"]; ?> <?php echo $alumnost[$i]["APaterno"]; ?> <?php echo $alumnost[$i]["AMaterno"]; ?></td>
                      <td><?php //echo $reins[0]["Monto"]; ?></td>
                      <td><?php //echo $reins[0]["Descuento"]; ?></td>
                      <td><?php //echo $reins[0]["Total"]; ?></td>
                      <td><?php //echo $mens[0]["Monto"]; ?></td>
                      <td><?php //echo $mens[0]["Descuento"]; ?></td>
                      <td><?php //echo $mens[0]["Total"]; ?></td>
                    </tr>
                  <?php //} ?>
                  </tfoot>
                </table>-->
                <br>
                  
                  
                  <?php // echo $datosok = $t->validar_beca_alumnos(); ?>
                <table id="example1" class="table table-bordered table-striped"  style="font-size: 12px;">
                  <thead>
                    <tr>
                      <th></th>
											<th>#CAMPUS</th>
                      <th>NOMBRE DE LA ESCUELA</th>
                      <th>ESTATUS</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php for ($i=0;$i< sizeof($lstCampus);$i++) { ?>
                    <tr>
                      <td>
                        <button title="Actualizar campus" type="button" class="btn bg-maroon btn-flat btn-sm" onclick="editCampus(<?php echo $lstCampus[$i]["IdCampus"]; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i></button>
                      </td>
											<td><?php echo $lstCampus[$i]["IdCampus"]; ?></td>
                      <td><?php echo $lstCampus[$i]["Campus"]; ?></td>
                      <td><?php if($lstCampus[$i]["IdEstatus"] == 8){ echo "ACTIVO"; } elseif($lstCampus[$i]["IdEstatus"] == 9){ echo "INACTIVO"; } ?></td>
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
                    <h4 class="modal-title"><span class="glyphicon glyphicon-check"></span> Configuración de campus / escuela</h4>
               </div>
               <div class="modal-body" id="employee_detailModFue">
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
function newCampus(){
  $.ajax({
       url:"formConsulta/addCampus.php",
       method:"POST",
       data:{},
       success:function(data){
            $('#employee_detailModFue').html(data);
            $('#dataModalModFue').modal('show');
       }
  });
}

function editCampus(IdCampus){
  $.ajax({
       url:"formConsulta/updCampus.php",
       method:"POST",
       data:{IdCampus:IdCampus},
       success:function(data){
            $('#employee_detailModFue').html(data);
            $('#dataModalModFue').modal('show');
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

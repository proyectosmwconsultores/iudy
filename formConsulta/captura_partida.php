<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdPartida = $_POST['IdPartida'];

  $sql_partida = $db->query("SELECT * FROM tblc_partida ORDER BY tblc_partida.Partida ASC");
  ?>

  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <?php if($IdPartida == 0){ ?>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">

          <div class="col-md-4">
            <div class="form-group">
              <label>Partida:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <input type="number" name="txt_partida" id="txt_partida" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label>Descripción de la partida:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <input type="text" name="txt_descripcion" id="txt_descripcion" class="form-control">
              </div>
            </div>
          </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="sav_new_partida()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>
  </div>
  <br>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th></th>
        <th>PARTIDA</th>
        <th>DESCRICIÓN</th>
        <th></th>
      </tr>
      <?php $d = 0; while($_part = $db->recorrer($sql_partida)){ ?>
      <tr>
        <td style="width: 15px;"><b><?php echo $d = ($d + 1); ?>.- </b></td>
        <td><?php echo $_part["Partida"]; ?></td>
        <td><?php echo $_part["Descripcion"]; ?></td>
        <td>
          <button onclick="upd_partida(<?php echo $_part["IdPartida"]; ?>)" type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button>
        </td>
      </tr>
      <?php } ?>
  </tbody></table>
<?php } else {

  $sql9 = $db->query("SELECT * FROM tblc_partida WHERE tblc_partida.IdPartida = '$IdPartida'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

   ?>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">

          <div class="col-md-4">
            <div class="form-group">
              <label>Partida:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <input type="number" name="txt_upartida" id="txt_upartida" class="form-control" value="<?php echo $datos91['Partida']; ?>">
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label>Descripción de la partida:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <input type="text" name="txt_udescripcion" id="txt_udescripcion" class="form-control" value="<?php echo $datos91['Descripcion']; ?>">
              </div>
            </div>
          </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-info pull-right" onClick="update_partida_id(<?php echo $IdPartida; ?>)"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
        </div>
      </div>
    </table>
  </div>
<?php } ?>
  </form>
<script>

  function cambiar_nivel(){
    var IdGasto = document.getElementById("txt_gaston1").value;
    $.ajax({
				 url:"formConsulta/captura_concepto_gasto_n2.php",
				 method:"POST",
				 data:{IdGasto:IdGasto},
				 success:function(data){
							$('#employee_detailC2').html(data);
							$('#dataModalC2').modal('show');
				 }
		});
  }

  function sav_new_partida(){
    var Partida = document.getElementById("txt_partida").value;
    var Descripcion = document.getElementById("txt_descripcion").value;

    if (Partida ==""){
        swal("Error al guardar", "Debe escribir la partida.", "error");
        document.getElementById("txt_partida").focus();
        return 0;
    }

    var TipoGuardar = "sav_new_partida";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar esta nueva partida?",
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
             data:{TipoGuardar:TipoGuardar, Partida:Partida, Descripcion:Descripcion},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Guardado correctamente", "La nueva partida se ha guardado correctamente.", "success");

            var IdPartida = 0;
        		$.ajax({
        				 url:"formConsulta/captura_partida.php",
        				 method:"POST",
        				 data:{IdPartida:IdPartida},
        				 success:function(data){
        							$('#employee_detailPa').html(data);
        							$('#dataModalPa').modal('show');
        				 }
        		});
  				}
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }

  function update_partida_id(IdPartida){
    var Partida = document.getElementById("txt_upartida").value;
    var Descripcion = document.getElementById("txt_udescripcion").value;

    if (Partida ==""){
        swal("Error al guardar", "Debe escribir la partida.", "error");
        document.getElementById("txt_upartida").focus();
        return 0;
    }

    var TipoGuardar = "upd_partida_id_x";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de este número de partida?",
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
             data:{TipoGuardar:TipoGuardar, IdPartida:IdPartida, Partida:Partida, Descripcion:Descripcion},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Actualizado correctamente", "Los datos de la partida se ha actualizado correctamente.", "success");

            var IdPartida = 0;
        		$.ajax({
        				 url:"formConsulta/captura_partida.php",
        				 method:"POST",
        				 data:{IdPartida:IdPartida},
        				 success:function(data){
        							$('#employee_detailPa').html(data);
        							$('#dataModalPa').modal('show');
        				 }
        		});
  				}
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }

  function upd_partida(IdPartida){
    $.ajax({
         url:"formConsulta/captura_partida.php",
         method:"POST",
         data:{IdPartida:IdPartida},
         success:function(data){
              $('#employee_detailPa').html(data);
              $('#dataModalPa').modal('show');
         }
    });
  }
</script>

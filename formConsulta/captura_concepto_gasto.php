<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $sql_concep = $db->query("SELECT * FROM tblc_concepto_gasto ORDER BY tblc_concepto_gasto.Nombre_gasto ASC ");
  ?>

  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre del concepto de gasto:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <input type="text" name="txtConcepto" id="txtConcepto" class="form-control">
              </div>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="sav_new_concepto()"> <i class="fa fa-fw fa-save"></i> Guardar concepto</button>
        </div>
      </div>
    </table>
  </div>
  <br>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th></th>
        <th>NOMBRE DEL CONCEPTO DE GASTO</th>
      </tr>
      <?php $d = 0; while($_concep = $db->recorrer($sql_concep)){ ?>
      <tr>
        <td style="width: 15px;"><b><?php echo $d = ($d + 1); ?>.- </b></td>
        <td><?php echo $_concep["Nombre_gasto"]; ?></td>
      </tr>
      <?php } ?>
  </tbody></table>
  </form>
<script>


  function sav_new_concepto(){
    var Concepto = document.getElementById("txtConcepto").value;

    if (Concepto ==""){
        swal("Error al guardar", "Debe escribir el nombre del concepto de gasto.", "error");
        document.getElementById("txtConcepto").focus();
        return 0;
    }

    var TipoGuardar = "sav_new_concep";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar este nuevo concepto de gasto?",
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
             data:{TipoGuardar:TipoGuardar, Concepto:Concepto},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Guardado correctamente", "El nuevo concepto de gasto se ha guardado correctamente.", "success");
            $.ajax({
        				 url:"formConsulta/captura_concepto_gasto.php",
        				 method:"POST",
        				 data:{},
        				 success:function(data){
        							$('#employee_detailC').html(data);
        							$('#dataModalC').modal('show');
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
</script>

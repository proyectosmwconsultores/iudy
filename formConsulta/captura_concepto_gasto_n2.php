<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdGasto = $_POST['IdGasto'];

  $sql_concep = $db->query("SELECT * FROM tblc_concepto_gasto ORDER BY tblc_concepto_gasto.Nombre_gasto ASC ");
  $sql_level1 = $db->query("SELECT * FROM tblc_concepto_gasto2 WHERE tblc_concepto_gasto2.IdGasto = '$IdGasto' ORDER BY tblc_concepto_gasto2.Nombre_gasto2 ASC ");
  ?>

  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Concepto de gasto nivel 1:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <select class="form-control" name="txt_gaston1" id="txt_gaston1" onchange="cambiar_nivel()">
                  <option value=""> - Seleccione - </option>
                  <?php while($lv1 = $db->recorrer($sql_concep)){ ?>
                  <option value="<?php echo $lv1["IdConcepto"]; ?>" <?php if($IdGasto==$lv1["IdConcepto"]){?>selected="selected"<?php }?> > <?php echo $lv1["Nombre_gasto"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre del concepto de gasto nivel 2:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <input type="text" name="txtConcepto2" id="txtConcepto2" class="form-control">
              </div>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="sav_new_concepto2()"> <i class="fa fa-fw fa-save"></i> Guardar concepto</button>
        </div>
      </div>
    </table>
  </div>
  <br>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th></th>
        <th>NOMBRE DEL CONCEPTO DE GASTO NIVEL 2</th>
      </tr>
      <?php $d = 0; while($_concep = $db->recorrer($sql_level1)){ ?>
      <tr>
        <td style="width: 15px;"><b><?php echo $d = ($d + 1); ?>.- </b></td>
        <td><?php echo $_concep["Nombre_gasto2"]; ?></td>
      </tr>
      <?php } ?>
  </tbody></table>
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

  function sav_new_concepto2(){
    var IdGasto1 = document.getElementById("txt_gaston1").value;
    var Gasto2 = document.getElementById("txtConcepto2").value;

    if (IdGasto1 ==""){
        swal("Error al guardar", "Debe selecciona el concepto de gasto.", "error");
        document.getElementById("txt_gaston1").focus();
        return 0;
    }
    if (Gasto2 ==""){
        swal("Error al guardar", "Debe escribir el nombre del concepto de gasto.", "error");
        document.getElementById("txtConcepto2").focus();
        return 0;
    }

    var TipoGuardar = "sav_new_concep_2";
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
             data:{TipoGuardar:TipoGuardar, IdGasto1:IdGasto1, Gasto2:Gasto2},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Guardado correctamente", "El nuevo concepto de gasto se ha guardado correctamente.", "success");

        		$.ajax({
        				 url:"formConsulta/captura_concepto_gasto_n2.php",
        				 method:"POST",
        				 data:{IdGasto:IdGasto1},
        				 success:function(data){
        							$('#employee_detailC2').html(data);
        							$('#dataModalC2').modal('show');
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

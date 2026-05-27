<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdPlan = $_POST["IdConceptoPlan"];
  $IdCosto = $_POST["IdCosto"];

  $anio = date("Y-m-s");
  $sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio >= '$anio' ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC");

  $lst_costo = $db->query("SELECT
tblc_costos_ciclo.IdCosto,
tblc_costos_ciclo.Monto,
tblc_costos_ciclo.Recargo,
tblc_costos_ciclo.FecCap,
tblc_costos_ciclo.Fecha,
tblc_costos_ciclo.Numero,
tblc_ciclo.Ciclo,
tblc_ciclo.Tipo
FROM
tblc_costos_ciclo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_costos_ciclo.IdCiclo
WHERE tblc_costos_ciclo.IdPlan = '$IdPlan'
ORDER BY tblc_ciclo.FInicio DESC
");

  $sql8 = $db->query("SELECT * FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes =  '$IdPlan'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);

  $mod53 = $db->query("SELECT * FROM tblc_modulousuario WHERE tblc_modulousuario.IdModulo = '53' AND tblc_modulousuario.IdUsua = '".$_SESSION['IdUsua']."'");
  $db->rows($mod53);
  $_mod53 = $db->recorrer($mod53);



  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="configurar_costo.php" method="POST" enctype="multipart/form-data">

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <?php if($IdCosto){
          $_costo = $db->query("SELECT * FROM tblc_costos_ciclo WHERE tblc_costos_ciclo.IdCosto = '$IdCosto'");
          $db->rows($_costo);
          $_datC = $db->recorrer($_costo);
           ?>
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre del plan de pago:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-map-signs"></i>
                </div>
                <input type="text" class="form-control" disabled value="<?php echo $datos81["NomPlan"]; ?>">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Periodo escolar:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-dollar"></i>
                </div>
                <select class="form-control" disabled>
                  <option value="">Seleccione</option>
                  <?php while($x = $db->recorrer($sql_ciclo)){ ?>
                    <option value="<?php echo $x["IdCiclo"]; ?>" <?php if($_datC["IdCiclo"] == $x["IdCiclo"]){ ?>selected="selected"<?php } ?> ><?php echo $x["Tipo"]; ?> - <?php echo $x["Ciclo"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Costo:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-dollar"></i>
                </div>
                <input type="text" class="form-control" name="txt_costox_a" id="txt_costox_a" value="<?php echo $_datC["Monto"]; ?>">
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Recargo:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-dollar"></i>
                </div>
                <input type="text" class="form-control" name="txt_recargox_a" id="txt_recargox_a" value="<?php echo $_datC["Recargo"]; ?>">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Fecha de pago:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" name="txt_fechax_a" id="txt_fechax_a" value="<?php echo $_datC["Fecha"]; ?>">
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Número de pagos:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-dollar"></i>
                </div>
                <input type="text" class="form-control" disabled value="<?php echo $_datC["Numero"]; ?>">
              </div>
            </div>
          </div>

          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-danger" onclick="config_costo(<?php echo $IdPlan; ?>)"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
            <button type="button" class="btn btn-warning pull-right" onClick="upd_costo_plan(<?php echo $IdPlan; ?>,<?php echo $_SESSION['IdUsua']; ?>,<?php echo $IdCosto; ?>)"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>

          </div>
        <?php } else { ?>
        <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Nombre del plan de pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <input type="text" class="form-control" disabled value="<?php echo $datos81["NomPlan"]; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Periodo escolar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <select name="txt_ciclox" id="txt_ciclox" class="form-control">
                <option value="">Seleccione</option>
                <?php while($x = $db->recorrer($sql_ciclo)){ ?>
                  <option value="<?php echo $x["IdCiclo"]; ?>" ><?php echo $x["Tipo"]; ?> - <?php echo $x["Ciclo"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Costo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <input type="text" class="form-control" name="txt_costox" id="txt_costox" value="<?php echo $datos81['Costo']; ?>">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Recargo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <input type="text" class="form-control" name="txt_recargox" id="txt_recargox" value="<?php echo $datos81['Recargo']; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha de pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control" name="txt_fechax" id="txt_fechax">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Número de pagos:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <input type="text" class="form-control" name="txt_numerox" id="txt_numerox">
            </div>
          </div>
        </div>


        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="sav_costo_plan(<?php echo $IdPlan; ?>,<?php echo $_SESSION['IdUsua']; ?>)"> <i class="fa fa-fw fa-save"></i> Guardar</button>

        </div>

        <table class="table table-striped" style="font-size: 12px;">
          <tbody><tr>
            <th style="width: 10px"></th>
            <th>PERIODO ESCOLAR</th>
            <th>FECHA</th>
            <th>NOPAGOS</th>
            <th>COSTO</th>
            <th>RECARGO</th>
            <?php if(isset($_mod53[0])){ ?>
            <th></th><?php } ?>
          </tr>
          <?php $v = 0; while($x = $db->recorrer($lst_costo)){ ?>
          <tr>
            <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
            <td><?php echo $x['Ciclo']; ?></td>
            <td><?php echo $x['Fecha']; ?></td>
            <td><?php echo $x['Numero']; ?></td>
            <td>$ <?php echo number_format($x['Monto'], 2, '.', ','); ?></td>
            <td><?php echo number_format($x['Recargo'], 2, '.', ','); ?> %</td>
            <?php if(isset($_mod53[0])){ ?>
            <td>
              <button onclick="editar_costo_id(<?php echo $x['IdCosto']; ?>,<?php echo $IdPlan; ?>)" title="Editar plan de concepto" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-fw fa-edit"></i></button>
            </td><?php } ?>
          </tr><?php } ?>
        </tbody></table>
        <?php } ?>
      </div>
    </table>
  </div>

  </form>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
$(function () {
  //Date picker
  $('#txt_fechax').datepicker({
    autoclose: true
  })
  $('#txt_fechax_a').datepicker({
    autoclose: true
  })
})
  function sav_costo_plan(IdPlan, IdUsua){
    var TipoGuardar = "sav_costo_planx";

    var IdCiclo = document.getElementById("txt_ciclox").value;
    var Costo = document.getElementById("txt_costox").value;
    var Recargo = document.getElementById("txt_recargox").value;
    var Fecha = document.getElementById("txt_fechax").value;
    var Numero = document.getElementById("txt_numerox").value;


    if (IdCiclo ==''){
  			swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
  			document.getElementById("txt_ciclox").focus();
  			return 0;
  	}
    if (Costo ==''){
  			swal("Error al guardar", "Debe escribir el costo.", "error");
  			document.getElementById("txt_costox").focus();
  			return 0;
  	}
    if (Recargo ==''){
  			swal("Error al guardar", "Debe escribir el recargo.", "error");
  			document.getElementById("txt_recargox").focus();
  			return 0;
  	}
    if (Fecha ==''){
  			swal("Error al guardar", "Debe seleccionar la fecha inicial del pago.", "error");
  			document.getElementById("txt_fechax").focus();
  			return 0;
  	}
    if (Numero ==''){
  			swal("Error al guardar", "Debe seleccionar el número de pagos que se van a realizar.", "error");
  			document.getElementById("txt_numerox").focus();
  			return 0;
  	}

        swal({
          title: "\u00BFEst\u00E1 seguro que desea agregar este monto este plan de pago para este periodo escolar?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Aceptar',
          cancelButtonText: "Cancelar",
        },
        function (isConfirm) {
          if (isConfirm) {
            $(".confirm").attr('disabled', 'disabled');

            $.ajax({
                 url:"formConsulta/setting.php",
                 method:"POST",
                 data:{TipoGuardar:TipoGuardar, IdPlan:IdPlan, IdCiclo:IdCiclo, Costo:Costo, Recargo:Recargo, Fecha:Fecha, Numero, Numero, IdUsua:IdUsua},
                 success:function(data){

                 }
            })
            .done(function(data) {
      				if(data==1){
      					swal("Guardado correctamente", "El monto del plan de pago se ha agregado correctamente.", "success");
                var IdCosto = 0;
          				$.ajax({
          						 url:"formConsulta/configurar_costo.php",
          						 method:"POST",
          						 data:{IdConceptoPlan:IdPlan, IdCosto:IdCosto},
          						 success:function(data){
          									$('#employee_detail_5').html(data);
          									$('#dataModal_5').modal('show');
          						 }
          				});
      				}
              if(data==2){
      					swal("Error al guardar", "El monto del plan de pago ya existen.", "error");
                var IdCosto = 0;
          				$.ajax({
          						 url:"formConsulta/configurar_costo.php",
          						 method:"POST",
          						 data:{IdConceptoPlan:IdPlan, IdCosto:IdCosto},
          						 success:function(data){
          									$('#employee_detail_5').html(data);
          									$('#dataModal_5').modal('show');
          						 }
          				});
      				}
              if(data == 0){
                swal("Error al guardar", "No se puede guardar el plan de pago.", "error");
              }

      			})
      			.error(function(data) {
      				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
      			});

          }

        });
  }

  function upd_costo_plan(IdPlan, IdUsua, IdCosto){
    var TipoGuardar = "updx_costo_planx";

    var Costo = document.getElementById("txt_costox_a").value;
    var Recargo = document.getElementById("txt_recargox_a").value;
    var Fecha = document.getElementById("txt_fechax_a").value;

    if (Costo ==''){
  			swal("Error al guardar", "Debe escribir el costo.", "error");
  			document.getElementById("txt_costox").focus();
  			return 0;
  	}
    if (Recargo ==''){
  			swal("Error al guardar", "Debe escribir el recargo.", "error");
  			document.getElementById("txt_recargox").focus();
  			return 0;
  	}
    if (Fecha ==''){
  			swal("Error al guardar", "Debe seleccionar la fecha inicial del pago.", "error");
  			document.getElementById("txt_fechax").focus();
  			return 0;
  	}
        swal({
          title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de este plan de pago de este periodo escolar?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Aceptar',
          cancelButtonText: "Cancelar",
        },
        function (isConfirm) {
          if (isConfirm) {
            $(".confirm").attr('disabled', 'disabled');

            $.ajax({
                 url:"formConsulta/setting.php",
                 method:"POST",
                 data:{TipoGuardar:TipoGuardar, IdPlan:IdPlan, IdCosto:IdCosto, Costo:Costo, Recargo:Recargo, Fecha:Fecha, IdUsua:IdUsua},
                 success:function(data){

                 }
            })
            .done(function(data) {
      				if(data==1){
      					swal("Actualizado correctamente", "El plan de pago se ha actualizado correctamente.", "success");
                var IdCosto = 0;
          				$.ajax({
          						 url:"formConsulta/configurar_costo.php",
          						 method:"POST",
          						 data:{IdConceptoPlan:IdPlan, IdCosto:IdCosto},
          						 success:function(data){
          									$('#employee_detail_5').html(data);
          									$('#dataModal_5').modal('show');
          						 }
          				});
      				}

              if(data == 0){
                swal("Error al guardar", "No se puede guardar el plan de pago.", "error");
              }

      			})
      			.error(function(data) {
      				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
      			});

          }

        });
  }

  function del_beca_user(IdUsua,IdBeca){
    var TipoGuardar = "del_beca_user";

        swal({
          title: "\u00BFEst\u00E1 seguro que desea eliminar esta beca a este alumno?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Aceptar',
          cancelButtonText: "Cancelar",
        },
        function (isConfirm) {
          if (isConfirm) {
            $(".confirm").attr('disabled', 'disabled');

            $.ajax({
                 url:"formConsulta/setting.php",
                 method:"POST",
                 data:{TipoGuardar:TipoGuardar, IdBeca:IdBeca},
                 success:function(data){

                 }
            })
            .done(function(data) {
      				if(data==1){
      					swal("Eliminado correctamente", "La beca se ha sido eliminado correctamente.", "success");
                var IdConcepto = 0;
                var IdPlan = 0;
                $.ajax({
              			 url:"formConsulta/beca_admisiones.php",
              			 method:"POST",
              			 data:{IdUsua:IdUsua, IdPlan:IdPlan, IdConcepto:IdConcepto},
              			 success:function(data){
              						$('#employee_detail3').html(data);
              						$('#dataModal3').modal('show');
              			 }
              	});
      				}else {
      					swal("Error al eliminar", "No se pudo eliminar la beca.", "error");
      				}
      			})
      			.error(function(data) {
      				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
      			});

          }

        });
  }

  function sel_concepto(Id_planx, IdUsua, IdConcepto){
    var IdPlan = Id_planx.value;
    $.ajax({
         url:"formConsulta/beca_admisiones.php",
         method:"POST",
         data:{IdUsua:IdUsua, IdPlan:IdPlan, IdConcepto:IdConcepto},
         success:function(data){
              $('#employee_detail3').html(data);
              $('#dataModal3').modal('show');
         }
    });
  }
</script>

<?php
session_start();
require('../php/clases/class.System.php');
require('../hace.php');
$db = new Conexion();
$anio = date("Y");
$IdCalendario = $_POST["IdCalendario"];
$IdFecha = $_POST["IdFecha"];

$sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio >= '$anio' ORDER BY tblc_ciclo.FInicio DESC ");

$lst_calen = $db->query("SELECT * FROM tble_fecha WHERE tble_fecha.IdCalendario = '$IdCalendario' ORDER BY tble_fecha.Parcial ASC ");
if($IdFecha){
  $sql_fx = $db->query("SELECT * FROM tble_fecha WHERE tble_fecha.IdFecha = '$IdFecha'");
  $db->rows($sql_fx);
  $fex = $db->recorrer($sql_fx);
}

$sql_cal = $db->query("SELECT * FROM tble_calendario WHERE tble_calendario.IdCalendario = '$IdCalendario'");
$db->rows($sql_cal);
$cal = $db->recorrer($sql_cal);
$idCiclo = $cal['IdCiclo'];
$modalidad = $cal['Modalidad'];

$sql_grp = $db->query("SELECT
tblc_ciclogrupo.IdGrupo,
tblc_ciclogrupo.Grado,
tblp_grupo.CveGrupo,
tblp_educativa.Nombre,
tblc_modalidad._Modalidad,
tblc_dias_clases._Dias
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblc_ciclogrupo.IdCiclo =  '$idCiclo' AND
tblp_grupo.Modalidad =  '$modalidad' AND
tblp_educativa.IdGrado =  '3' ORDER BY tblp_grupo.IdOferta ASC, tblp_grupo.Grado ASC
 ");

?>
  <form class="form-horizontal">
    <?php if($IdFecha){ ?>
      <div class="box-body">
      <div class="form-group">
        <label class="col-sm-5 control-label">Seleccione:</label>
        <div class="col-sm-7">
          <select disabled class="form-control">
            <option value=""> - Seleccione - </option>
            <option value="1" <?php if($fex["Parcial"] == 1){ ?>selected="selected"<?php } ?>>Parcial 1</option>
            <option value="2" <?php if($fex["Parcial"] == 2){ ?>selected="selected"<?php } ?>>Parcial 2</option>
            <option value="3" <?php if($fex["Parcial"] == 3){ ?>selected="selected"<?php } ?>>Parcial 3</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-5 control-label">Fecha inicial:</label>
        <div class="col-sm-7">
        <input type="text" class="form-control" id="txt_fecha1x" name="txt_fecha1x" value="<?php echo $fex['FechaIni']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-5 control-label">Fecha final:</label>
        <div class="col-sm-7">
        <input type="text" class="form-control" id="txt_fecha2x" name="txt_fecha2x" value="<?php echo $fex['FechaFin']; ?>">
        </div>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="cancel_fex(<?php echo $IdCalendario; ?>)"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
        <button type="button" class="btn btn-primary pull-right" onClick="upd_fechax(<?php echo $IdCalendario; ?>,<?php echo $IdFecha; ?>)"> <i class="fa fa-fw fa-save"></i> Actualizar</button>
      </div>
    <?php } else { ?>
    <div class="box-body">
    <div class="form-group">
      <label class="col-sm-5 control-label">Seleccione:</label>
      <div class="col-sm-7">
        <select name="txt_parcial" id="txt_parcial" class="form-control">
          <option value=""> - Seleccione - </option>
          <option value="1">Parcial 1</option>
          <option value="2">Parcial 2</option>
          <option value="3">Parcial 3</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-5 control-label">Fecha inicial:</label>
      <div class="col-sm-7">
      <input type="text" class="form-control" id="txt_fecha1" name="txt_fecha1">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-5 control-label">Fecha final:</label>
      <div class="col-sm-7">
      <input type="text" class="form-control" id="txt_fecha2" name="txt_fecha2">
      </div>
    </div>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
      <button type="button" class="btn btn-primary pull-right" onClick="add_fecha(<?php echo $IdCalendario; ?>)"> <i class="fa fa-fw fa-save"></i> Guardar</button>
    </div>
    <br>
    <table class="table table-striped">
      <tbody>
        <tr>
          <th style="width: 10px">#</th>
          <th>Parcial</th>
          <th>Inicia</th>
          <th>Finaliza</th>
          <th></th>
        </tr>
      <?php $c = 0; while($_cal = $db->recorrer($lst_calen)){ ?>
        <tr>
          <td><b><?php echo $c = ($c + 1); ?>.- </b></td>
          <td>Parcial <?php echo $_cal['Parcial']; ?></td>
          <td><?php echo obtenerFechaEnLetra($_cal['FechaIni']); ?></td>
          <td><?php echo obtenerFechaEnLetra($_cal['FechaFin']); ?></td>
          <td>
            <button title="Actualizar calendario" type="button" class="btn bg-maroon btn-flat btn-sm" onclick="upd_actualizar_fex(<?php echo $IdCalendario; ?>,<?php echo $_cal['IdFecha']; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i></button>
          </td>
        </tr><?php } ?>
      </tbody></table>
      <br>
      <table class="table table-striped">
        <tbody>
          <tr>
            <th style="width: 10px"></th>
            <th>GRUPO</th>
            <th>MODALIDAD</th>
            <th>DÍA</th>
          </tr>
        <?php $c = 0; while($_grp = $db->recorrer($sql_grp)){
          $sql_chk = $db->query("SELECT tble_calendario_grupo.IdDisponible FROM tble_calendario_grupo WHERE tble_calendario_grupo.IdCalendario = '$IdCalendario' AND tble_calendario_grupo.IdGrupo = '".$_grp['IdGrupo']."' ");
          $db->rows($sql_chk);
          $chk = $db->recorrer($sql_chk);

           ?>
          <tr>
            <td>
              <?php if($chk['IdDisponible']){ ?>
                <button title="Activar" type="button" class="btn bg-navy btn-flat btn-sm" onclick="add_grp_calen(<?php echo $IdCalendario; ?>,<?php echo $_grp['IdGrupo']; ?>,<?php echo $idCiclo; ?>,0)" href="javascript:void(0);"><i class="fa fa-fw fa-check-circle"></i></button>

            <?php } else { ?>
              <button title="Activar" type="button" class="btn bg-orange btn-flat btn-sm" onclick="add_grp_calen(<?php echo $IdCalendario; ?>,<?php echo $_grp['IdGrupo']; ?>,<?php echo $idCiclo; ?>,1)" href="javascript:void(0);"><i class="fa fa-fw fa-times-circle"></i></button>
            <?php } ?>
            </td>
            <td><?php echo $_grp['Grado']; ?>° <?php echo $_grp['CveGrupo']; ?></td>
            <td><?php echo $_grp['_Modalidad']; ?></td>
            <td><?php echo $_grp['_Dias']; ?></td>
          </tr><?php } ?>
        </tbody></table>
    <?php } ?>




</form>

  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
$(function () {

  $('#txt_fecha1').datepicker({
    autoclose: true
  })
  $('#txt_fecha2').datepicker({
    autoclose: true
  })
  $('#txt_fecha1x').datepicker({
    autoclose: true
  })
  $('#txt_fecha2x').datepicker({
    autoclose: true
  })
})

function add_fecha(IdCalendario){
  var Parcial = document.getElementById("txt_parcial").value;
  var Fecha1 = document.getElementById("txt_fecha1").value;
  var Fecha2 = document.getElementById("txt_fecha2").value;

	if (Parcial ==''){
			swal("Error al guardar", "Debe seleccionar el parcial.", "error");
			document.getElementById("txt_parcial").focus();
			return 0;
	}

  if (Fecha1 ==''){
			swal("Error al guardar", "Debe seleccionar la fecha de inicio del parcial.", "error");
			document.getElementById("txt_fecha1").focus();
			return 0;
	}
  if (Fecha2 ==''){
			swal("Error al guardar", "Debe seleccionar la fecha de final del parcial.", "error");
			document.getElementById("txt_fecha2").focus();
			return 0;
	}

  var TipoGuardar = "add_fecha_cal_esc";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta fecha del parcial?",
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
           data:{TipoGuardar:TipoGuardar, IdCalendario:IdCalendario, Parcial:Parcial, Fecha1:Fecha1, Fecha2:Fecha2},
           success:function(data){
           }
      })
			.done(function(data) {
        if(data==1){
					swal("Guardado correctamente", "Los datos se han guardado correctamente.", "success");
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
        if(data==2){
					swal("Error al guardar", "Los datos ingresados ya existen en este calendario escolar.", "error");
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
				if(data==0){
					swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function upd_fechax(IdCalendario,IdFecha){
  var Fecha1 = document.getElementById("txt_fecha1x").value;
  var Fecha2 = document.getElementById("txt_fecha2x").value;

  if (Fecha1 ==''){
			swal("Error al guardar", "Debe seleccionar la fecha de inicio del parcial.", "error");
			document.getElementById("txt_fecha1x").focus();
			return 0;
	}
  if (Fecha2 ==''){
			swal("Error al guardar", "Debe seleccionar la fecha de final del parcial.", "error");
			document.getElementById("txt_fecha2x").focus();
			return 0;
	}

  var TipoGuardar = "upd_fecha_cal_esc";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar la fecha de este parcial?",
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
           data:{TipoGuardar:TipoGuardar, IdFecha:IdFecha, Fecha1:Fecha1, Fecha2:Fecha2},
           success:function(data){
           }
      })
			.done(function(data) {
        if(data==1){
					swal("Actualizado correctamente", "Los datos se han actualizado correctamente.", "success");
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
        if(data==2){
					swal("Error al guardar", "Los datos ingresados ya existen en este calendario escolar.", "error");
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
				if(data==0){
					swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function upd_actualizar_fex(IdCalendario,IdFecha){
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

function cancel_fex(IdCalendario){
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

function add_grp_calen(IdCalendario, IdGrupo, IdCiclo, Valor){
    var TipoGuardar = "asig_fecha_grp";
    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdCalendario:IdCalendario, IdGrupo:IdGrupo, Valor:Valor, IdCiclo:IdCiclo},
         success:function(data){

         }
    })
    .done(function(data) {
      if(data==1){
        swal("Actualizado correctamente", "Los datos se han actualizado correctamente.", "success");
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

      if(data==2){
        swal("Error al agregar", "Este grupo ya tiene activo un calendario escolar activo.", "error");
      }

      if(data==0){
        swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
      }
    })
    .error(function(data) {
      swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
    });
}
</script>

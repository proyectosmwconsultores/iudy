<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdActividadDoc = $_POST["IdActividadDoc"];

  $sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.Tiempo,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.FecIni,
tblp_actividadesdocente.FecFin,
tblp_actividadesdocente.Orden,
tblp_actividadesdocente.Ini,
tblp_actividadesdocente.Fin
FROM
tblp_actividadesdocente
WHERE tblp_actividadesdocente.IdActividadesDocente =  '$IdActividadDoc' ");
$db->rows($sql);
$dat = $db->recorrer($sql);
$_tiempo = $dat['Tiempo'];
  ?>
  <div class="box box-info">
<div class="box-header with-border">
<h3 class="box-title"><?php echo $dat['NomActividad']; ?></h3>
</div>


<form class="form-horizontal">
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-4 control-label">Duración de la evaluación:</label>
      <div class="col-sm-8">
        <select class="form-control" name="txt_tiempox" id="txt_tiempox" onchange="save_Tiempo(<?php echo $IdActividadDoc; ?>)">
          <option value=""> - Seleccione - </option>
          <option value="1" <?php if($dat["Tiempo"] == 1){ ?>selected="selected"<?php } ?> > 1 hora </option>
          <option value="2" <?php if($dat["Tiempo"] == 2){ ?>selected="selected"<?php } ?> > 2 horas </option>
          <option value="3" <?php if($dat["Tiempo"] == 3){ ?>selected="selected"<?php } ?> > 3 horas </option>
          <option value="4" <?php if($dat["Tiempo"] == 4){ ?>selected="selected"<?php } ?> > 4 horas </option>
          <option value="5" <?php if($dat["Tiempo"] == 5){ ?>selected="selected"<?php } ?> > 5 horas </option>
        </select>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-4 control-label">Hora de inicio:</label>
      <div class="col-sm-8">
        <select class="form-control" name="txt_inix" id="txt_inix" onchange="save_Hra(this,'Ini',<?php echo $IdActividadDoc; ?>)">
          <option value=""> - Seleccione - </option>
          <option value="07:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 07:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 07:00 AM</option>
          <option value="08:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 08:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 08:00 AM</option>
          <option value="09:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 09:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 09:00 AM</option>
          <option value="10:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 10:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 10:00 AM</option>
          <option value="11:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 11:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 11:00 AM</option>
          <option value="12:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 12:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 12:00 PM</option>
          <option value="13:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 13:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 13:00 PM</option>
          <option value="14:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 14:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 14:00 PM</option>
          <option value="15:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 15:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 15:00 PM</option>
          <option value="16:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 16:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 16:00 PM</option>
          <option value="17:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 17:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 17:00 PM</option>
          <option value="18:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 18:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 18:00 PM</option>
          <option value="19:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 19:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 19:00 PM</option>
          <option value="20:00:00" <?php if($dat["Ini"] == $dat["FecIni"].' 20:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecIni"]; ?> 20:00 PM</option>
        </select>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-4 control-label">Hora final:</label>
      <div class="col-sm-8">
        <select class="form-control" name="txt_fin_x" id="txt_fin_x" onchange="save_Hra(this,'Fin',<?php echo $IdActividadDoc; ?>)">
          <option value=""> - Seleccione - </option>
          <option value="08:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 08:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 08:00 AM</option>
          <option value="09:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 09:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 09:00 AM</option>
          <option value="10:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 10:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 10:00 AM</option>
          <option value="11:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 11:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 11:00 AM</option>
          <option value="12:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 12:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 12:00 PM</option>
          <option value="13:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 13:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 13:00 PM</option>
          <option value="14:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 14:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 14:00 PM</option>
          <option value="15:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 15:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 15:00 PM</option>
          <option value="16:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 16:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 16:00 PM</option>
          <option value="17:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 17:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 17:00 PM</option>
          <option value="18:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 18:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 18:00 PM</option>
          <option value="19:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 19:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 19:00 PM</option>
          <option value="20:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 20:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 20:00 PM</option>
          <option value="21:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 21:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 21:00 PM</option>
          <option value="22:00:00" <?php if($dat["Fin"] == $dat["FecFin"].' 22:00:00'){?>selected="selected"<?php } ?>> <?php echo $dat["FecFin"]; ?> 22:00 PM</option>
        </select>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-4 control-label">Orden de las preguntas:</label>
      <div class="col-sm-8">
        <select class="form-control" name="txt_ordenx" id="txt_ordenx">
          <option value=""> - Seleccione - </option>
          <option value="1" <?php if($dat["Orden"] == 1){ ?>selected="selected"<?php } ?> > Aleatorio </option>
          <option value="2" <?php if($dat["Orden"] == 2){ ?>selected="selected"<?php } ?> > Consecutivo </option>
        </select>
      </div>
    </div>
  </div>

  <div class="box-footer">
  <button onclick="sav_conf_fecha(<?php echo $IdActividadDoc; ?>)" type="button" class="btn btn-info pull-right"><i class="fa fa-save"></i> Guardar configuración</button>
  </div>

  </form>
</div>
<script>

  function sav_conf_fecha(IdActividadDoc){
    var TipoGuardar = "addHora_Exi";
    var Tiempo = document.getElementById("txt_tiempox").value;
    var Inicio = document.getElementById("txt_inix").value;
    var Final = document.getElementById("txt_fin_x").value;
    var Orden = document.getElementById("txt_ordenx").value;

    if (Tiempo ==''){
  			swal("Error al guardar", "Debe seleccionar la duración del examen.", "error");
  			document.getElementById("txt_tiempox").focus();
  			return 0;
  	}
    if (Inicio ==''){
  			swal("Error al guardar", "Debe seleccionar el inicio de la evaluación.", "error");
  			document.getElementById("txt_inix").focus();
  			return 0;
  	}
    if (Final ==''){
  			swal("Error al guardar", "Debe seleccionar la hora final del examen.", "error");
  			document.getElementById("txt_fin_x").focus();
  			return 0;
  	}
    if (Orden ==''){
  			swal("Error al guardar", "Debe seleccionar el orden de organizar las preguntas.", "error");
  			document.getElementById("txt_ordenx").focus();
  			return 0;
  	}

        swal({
          title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de esta evaluación?",
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
                 data:{TipoGuardar:TipoGuardar, IdActividadDoc:IdActividadDoc, Tiempo:Tiempo, Inicio:Inicio, Final:Final, Orden:Orden},
                 success:function(data){

                 }
            })
            .done(function(data) {
      				if(data==1){
      					swal("Guardado correctamente", "La configuración de la evaluación se ha generado correctamente.", "success");
                $.ajax({
          					 url:"formConsulta/configurar_fecha_examen.php",
          					 method:"POST",
          					 data:{IdActividadDoc:IdActividadDoc},
          					 success:function(data){
          								$('#employee_detailFE').html(data);
          								$('#dataModalFE').modal('show');
          					 }
          			});
      				} else {
                swal("Error al actualizar", "No se puede actualizar el plan de pago.", "error");
              }

      			})
      			.error(function(data) {
      				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
      			});

          }

        });
  }

  function save_Hra(Tipo,Campo,IdActividadDoc){
    var TipoGuardar = "addHoraEx";
    var Hora = Tipo.value;
    $.ajax({
          url:"formConsulta/setting.php",
          method:"POST",
          data:{TipoGuardar:TipoGuardar,IdActividadDoc:IdActividadDoc, Hora:Hora, Campo:Campo},
          success:function(data){
          }

     });
  }

  function save_Tiempo(IdActividadDoc){
    var TipoGuardar = "addTeimpoEx";

    var Tiempo = document.getElementById("txt_tiempox").value;
    $.ajax({
          url:"formConsulta/setting.php",
          method:"POST",
          data:{TipoGuardar:TipoGuardar,IdActividadDoc:IdActividadDoc, Tiempo:Tiempo},
          success:function(data){
          }
     })
  }
</script>

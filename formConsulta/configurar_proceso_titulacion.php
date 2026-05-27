<?php
  session_start();
  include('../hace.php');
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $IdCiclo = $_POST["IdCiclo"];
//601521056
  $sql_us = $db->query("SELECT
tblc_usuario.IdUsua,
tblp_educativa.IdGrado,
tblp_informacion.IdTitulacion,
tblp_informacion.Fecha_titulacion,
tblp_informacion.IdPeriodo_egreso,
tblp_informacion.IdCiclo_egreso,
tblp_informacion.Monto,
tblp_informacion.IdCalendario,
tblp_grupo.TipoCiclo
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $db->rows($sql_us);
  $_us = $db->recorrer($sql_us);
  $IdGrado = $_us['IdGrado'];
  $IdTitulacion = $_us['IdTitulacion'];
  $IdPeriodo = $_us['IdPeriodo_egreso'];

  $TipoCiclo = $_us['TipoCiclo'];
  $Fecha = $_us['Fecha_titulacion'];
  $Monto = $_us['Monto'];
  $IdCal = $_us['IdCalendario'];

  if($_POST["IdCiclo"]){
    $IdCiclo = $_POST["IdCiclo"];
  } else {
    $IdCiclo = $_us['IdCiclo_egreso'];
  }

  if($TipoCiclo='C'){
    $TipoCiclox = 'CUATRIMESTRE';
  } else {
    $TipoCiclox = 'SEMESTRE';
  }
  $sql_titulacion = $db->query("SELECT * FROM tblc_tipo_titulacion WHERE tblc_tipo_titulacion.IdGrado = '$IdGrado'");
  $sql_per = $db->query("SELECT * FROM tblc_periodo ORDER BY tblc_periodo.Anio ASC");

  $sql_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$TipoCiclox' ORDER BY tblc_ciclo.FInicio ASC");

  $sql_calend = $db->query("SELECT tblp_calendario.IdCalendario, tblp_calendario.FecDescuento, tblp_calendario.Monto, tblc_conceptosplanes.NomPlan FROM tblp_calendario Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes WHERE tblp_calendario.IdCiclo =  '$IdCiclo' AND tblc_conceptosplanes.IdConcepto =  '5' AND tblp_calendario.IdGrado =  '$IdGrado'");

  ?>
  <div class="box-body">
    <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Periodo escolar de obtención de grado:</label>
        <div class="col-sm-8">
          <select name="txt_IdCiclo" id="txt_IdCiclo" class="form-control" onchange="sel_ciclo_es(<?php echo $IdUsua; ?>)">
            <option value="">- Seleccione - </option>
            <?php while($cic = $db->recorrer($sql_cic)){ ?>
            <option value="<?php echo $cic['IdCiclo']; ?>" <?php if($IdCiclo==$cic['IdCiclo']){ ?>selected="selected"<?php } ?>><?php echo $cic['Ciclo']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Forma en la que se va a titular el alumno:</label>
        <div class="col-sm-8">
          <select name="txt_IdTitulo" id="txt_IdTitulo" class="form-control">
            <option value="">- Seleccione - </option>
            <?php while($tit = $db->recorrer($sql_titulacion)){ ?>
            <option value="<?php echo $tit['IdTitulacion']; ?>" <?php if($IdTitulacion==$tit['IdTitulacion']){ ?>selected="selected"<?php } ?>><?php echo $tit['Nombre_titulacion']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Ciclo escolar de obtención de grado:</label>
        <div class="col-sm-8">
          <select name="txt_IdPeriodo" id="txt_IdPeriodo" class="form-control">
            <option value="">- Seleccione - </option>
            <?php while($per = $db->recorrer($sql_per)){ ?>
            <option value="<?php echo $per['IdPeriodo']; ?>" <?php if($IdPeriodo==$per['IdPeriodo']){ ?>selected="selected"<?php } ?>><?php echo $per['Periodo']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Plan de pago:</label>
        <div class="col-sm-9">
          <select name="txt_calendario" id="txt_calendario" class="form-control" onchange="sel_calendario()">
            <option value="">- Seleccione - </option>
            <?php while($_cal = $db->recorrer($sql_calend)){ ?>
            <option value="<?php echo $_cal['IdCalendario']; ?>" <?php if($IdCal==$_cal['IdCalendario']){ ?>selected="selected"<?php } ?>><?php echo $_cal['NomPlan']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-6 control-label">Fecha de solicitud:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="txt_fecha" name="txt_fecha" value="<?php echo $Fecha; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Monto a pagar:</label>
        <div class="col-sm-6">
          <input type="number" class="form-control" id="txt_monto" name="txt_monto" value="<?php echo $Monto; ?>">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <?php if($Fecha){ ?>
      <button onclick="javascript:window.open('repositorio/portafolio/inscripcion_grado.php?idToks=<?php echo time().$IdUsua; ?>');" href="javascript:void(0);" type="button" class="btn btn-success pull-left"><i class="fa fa-print"></i> Imprimir ficha</button>
      <?php } ?>
      <button onclick="solicitar_grado(<?php echo $IdUsua; ?>)" type="button" class="btn btn-info pull-right"><i class="fa fa-save"></i> Generar ficha</button>
    </div>
  </form>
</div>
<script>
$(function () {
  $('#txt_fecha').datepicker({
    autoclose: true
  })
})

  function solicitar_grado(IdUsua){
    var IdCalendario = document.getElementById("txt_calendario").value;
    var IdTitulacion = document.getElementById("txt_IdTitulo").value;
    var IdPeriodo = document.getElementById("txt_IdPeriodo").value;
    var IdCiclo = document.getElementById("txt_IdCiclo").value;
    var Fecha = document.getElementById("txt_fecha").value;
    var Monto = document.getElementById("txt_monto").value;
    if (IdCiclo ==""){
        swal("Error al guardar", "Debe seleccionar el Periodo Escolar.", "error");
        return 0;
    }
    if (IdTitulacion ==""){
        swal("Error al guardar", "Debe seleccionar el tipo de titulación.", "error");
        return 0;
    }
    if (IdPeriodo ==""){
        swal("Error al guardar", "Debe seleccionar el Ciclo Escolar.", "error");
        return 0;
    }

    if (IdCalendario ==""){
        swal("Error al guardar", "Debe seleccionar el plan de pago.", "error");
        return 0;
    }
    if (Fecha ==""){
        swal("Error al guardar", "Debe seleccionar la fecha.", "error");
        return 0;
    }
    if (Monto ==""){
        swal("Error al guardar", "Debe escribir el monto.", "error");
        return 0;
    }
    var TipoGuardar = "obten_grado_id";
        swal({
          title: "\u00BFEst\u00E1 seguro que desea continuar con este proceso de obtención de grado del alumno?",
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
                 data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdTitulacion:IdTitulacion, IdPeriodo:IdPeriodo, IdCiclo:IdCiclo, Fecha:Fecha, Monto:Monto, IdCalendario:IdCalendario},
                 success:function(data){

                 }
            })
            .done(function(data) {
              if(data==1){
                var IdCiclo = 0;
                swal("Generado correctamente", "El proceso de obtención de grado se ha generado correctamente.", "success");
                $.ajax({
                     url:"formConsulta/configurar_proceso_titulacion.php",
                     method:"POST",
                     data:{IdUsua:IdUsua, IdCiclo:IdCiclo},
                     success:function(data){
                          $('#employee_detailI').html(data);
                          $('#dataModalI').modal('show');
                     }
                });
      				}

      				if(data==0){
      					swal("Error al generar", "No se puede generar, verifique sus datos.", "error");
      				}
      			})
      			.error(function(data) {
      				swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
      			});

          }

        });
  }

  function sel_ciclo_es(IdUsua){
    var IdCiclo = document.getElementById("txt_IdCiclo").value;
    $.ajax({
         url:"formConsulta/configurar_proceso_titulacion.php",
         method:"POST",
         data:{IdUsua:IdUsua, IdCiclo: IdCiclo},
         success:function(data){
              $('#employee_detailI').html(data);
              $('#dataModalI').modal('show');
         }
    });
  }

  function sel_calendario(){
    var IdCalendario = document.getElementById("txt_calendario").value;
    var TipoGuardar = "precio_titulo";
    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdCalendario:IdCalendario},
         success:function(data){
           document.getElementById('txt_monto').value = data;
         }
    })
  }
</script>

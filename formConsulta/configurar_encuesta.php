<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdCampus = $_POST["IdCampus"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $sql9 = $db->query("SELECT tblp_grupo.IdOferta FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91['IdOferta'];

  $sql_campus = $db->query("SELECT tblp_coordinador.IdCoordinador, tblp_coordinador.IdCampus, tblc_campus.Campus FROM tblp_coordinador Left Join tblc_campus ON tblc_campus.IdCampus = tblp_coordinador.IdCampus WHERE tblp_coordinador.IdUsua =  '$IdUsua' GROUP BY tblp_coordinador.IdCampus");
  $sql_ciclo = $db->query("SELECT * FROM tblc_ciclo ORDER BY tblc_ciclo.FInicio DESC");
  $sql_grp = $db->query("SELECT tblc_ciclogrupo.IdGrupo, tblc_ciclogrupo.Grado, tblp_grupo.CveGrupo FROM tblc_ciclogrupo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo = '$IdCiclo' ORDER BY tblc_ciclogrupo.Grado ASC ");


  $sql_eva = $db->query("SELECT
tblc_tipoevaluacion_setting.IdTipoEvaluacion,
tblc_tipoevaluacion.Evaluacion,
tblc_tipoevaluacion.IdEstatus
FROM
tblc_tipoevaluacion_setting
Left Join tblc_tipoevaluacion ON tblc_tipoevaluacion.IdTipoEvaluacion = tblc_tipoevaluacion_setting.IdTipoEvaluacion
WHERE
tblc_tipoevaluacion.IdEstatus =  '8' AND
tblc_tipoevaluacion.Cve <>  '1' AND
tblc_tipoevaluacion_setting.IdCampus =  '$IdCampus' AND
tblc_tipoevaluacion_setting.IdOferta =  '$IdOferta'
");


  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Seleccione campus:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-bank"></i>
                </div>
                <select name="txt_campus" id="txt_campus" class="form-control">
                  <option value="">Seleccione</option>
                  <?php while($_campus = $db->recorrer($sql_campus)){ ?>
                    <option value="<?php echo $_campus["IdCampus"]; ?>" <?php if($IdCampus == $_campus["IdCampus"]){ ?>selected="selected"<?php } ?>><?php echo $_campus["Campus"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="form-group">
              <label>Periodo escolar:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-bank"></i>
                </div>
                <select name="txt_ciclo" id="txt_ciclo" class="form-control" onchange="sel_periodo()">
                  <option value="">Seleccione</option>
                  <?php while($_ciclo = $db->recorrer($sql_ciclo)){ ?>
                    <option value="<?php echo $_ciclo["IdCiclo"]; ?>" <?php if($IdCiclo == $_ciclo["IdCiclo"]){ ?>selected="selected"<?php } ?>><?php echo $_ciclo["Ciclo"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label>Grupo:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-book"></i>
                </div>
                <select name="txt_grupo" id="txt_grupo" class="form-control" onchange="sel_grupox()">
                  <option value="">Seleccione</option>
                  <?php while($_grupo = $db->recorrer($sql_grp)){ ?>
                    <option value="<?php echo $_grupo["IdGrupo"]; ?>" <?php if($IdGrupo == $_grupo["IdGrupo"]){ ?>selected="selected"<?php } ?>><?php echo $_grupo["Grado"].'° - '.$_grupo["CveGrupo"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Tipo de encuesta:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-bank"></i>
                </div>
                <select name="txt_tipoE" id="txt_tipoE" class="form-control">
                  <option value="">Seleccione</option>
                  <?php while($_eva = $db->recorrer($sql_eva)){ ?>
                    <option value="<?php echo $_eva["IdTipoEvaluacion"]; ?>"><?php echo $_eva["Evaluacion"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha inicial:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-money"></i>
              </div>
              <input type="text" class="form-control" name="txtFeIni" id="txtFeIni" >
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha final:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-money"></i>
              </div>
              <input type="text" class="form-control" name="txtFeFin" id="txtFeFin" >
            </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="sav_encx_eva()"> <i class="fa fa-fw fa-save"></i> Generar encuesta</button>
        </div>
      </div>
    </table>
  </div>

  </form>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
$(function () {
  $('#txtFeIni').datepicker({
    autoclose: true
  })
  $('#txtFeFin').datepicker({
    autoclose: true
  })

})

  function sel_periodo(){
    var IdCiclo = document.getElementById("txt_ciclo").value;
    var IdCampus = document.getElementById("txt_campus").value;
    var IdGrupo = document.getElementById("txt_grupo").value;
    $.ajax({
				 url:"formConsulta/configurar_encuesta.php",
				 method:"POST",
				 data:{IdCampus:IdCampus, IdCiclo:IdCiclo, IdGrupo:IdGrupo},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
				 }
		});
  }

  function sel_grupox(){
    var IdCiclo = document.getElementById("txt_ciclo").value;
    var IdCampus = document.getElementById("txt_campus").value;
    var IdGrupo = document.getElementById("txt_grupo").value;
    $.ajax({
				 url:"formConsulta/configurar_encuesta.php",
				 method:"POST",
				 data:{IdCampus:IdCampus, IdCiclo:IdCiclo, IdGrupo:IdGrupo},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
				 }
		});
  }

  function sav_encx_eva(){
    var IdCampus = document.getElementById("txt_campus").value;
    var IdCiclo = document.getElementById("txt_ciclo").value;
    var IdGrupo = document.getElementById("txt_grupo").value;
    var Tipo = document.getElementById("txt_tipoE").value;
    var Ini = document.getElementById("txtFeIni").value;
    var Fin = document.getElementById("txtFeFin").value;

    if (IdCampus ==""){
        swal("Error al guardar", "Debe seleccionar el campus.", "error");
        document.getElementById("txt_campus").focus();
        return 0;
    }
    if (IdCiclo ==""){
        swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
        document.getElementById("txt_ciclo").focus();
        return 0;
    }
    if (IdGrupo ==""){
        swal("Error al guardar", "Debe seleccionar el grupo.", "error");
        document.getElementById("txt_grupo").focus();
        return 0;
    }
    if (Tipo ==""){
        swal("Error al guardar", "Debe seleccionar el tipo de encuesta.", "error");
        document.getElementById("txt_tipoE").focus();
        return 0;
    }
    if (Ini ==""){
        swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
        document.getElementById("txtFeIni").focus();
        return 0;
    }
    if (Fin ==""){
        swal("Error al guardar", "Debe seleccionar el final final.", "error");
        document.getElementById("txtFeFin").focus();
        return 0;
    }

    var TipoGuardar = "sav_encuesta_modx";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea publicar esta encuesta?",
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
             data:{TipoGuardar:TipoGuardar, IdCampus:IdCampus, Ini:Ini, Fin:Fin, Tipo:Tipo, IdGrupo:IdGrupo, IdCiclo:IdCiclo},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Publicado correctamente", "La encuesta se ha publicado correctamente.", "success");
            var IdCampus = 0;
        		var IdCiclo = 0;
        		var IdGrupo = 0;
        		$.ajax({
        				 url:"formConsulta/configurar_encuesta.php",
        				 method:"POST",
        				 data:{IdCampus:IdCampus, IdCiclo:IdCiclo, IdGrupo:IdGrupo},
        				 success:function(data){
        							$('#employee_detail_4').html(data);
        							$('#dataModal_4').modal('show');
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

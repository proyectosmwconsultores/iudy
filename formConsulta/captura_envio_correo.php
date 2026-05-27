<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdCampus = $_POST['IdCampus'];
  $IdGrupo = $_POST['IdGrupo'];

  $sql_campus = $db->query("SELECT tblc_campus.IdCampus, tblc_campus.Campus FROM tblc_campus");
  $sql_grupo = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus'");
  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-8">
            <div class="form-group">
              <label>Seleccione campus:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-user"></i>
                </div>
                <select class="form-control" name="txtCampusx" id="txtCampusx" onchange="sel_campusgx()">
                  <option value="">Seleccione</option>
                  <?php while($_camp = $db->recorrer($sql_campus)){ ?>
                    <option value="<?php echo $_camp["IdCampus"]; ?>" <?php if($IdCampus==$_camp["IdCampus"]){?>selected="selected"<?php } ?>><?php echo $_camp["Campus"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Seleccione grupo:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-bookmark-o"></i>
                </div>
                <select name="txtGrupox" id="txtGrupox" class="form-control" onchange="sel_grupogx()">
                  <option value="">Seleccione</option>
                  <?php while($_grp = $db->recorrer($sql_grupo)){ ?>
                    <option value="<?php echo $_grp["IdGrupo"]; ?>" <?php if($IdGrupo==$_grp["IdGrupo"]){?>selected="selected"<?php } ?>><?php echo $_grp["CveGrupo"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Asunto:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="txtAsunto" id="txtAsunto" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Mensaje:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-bank"></i>
                </div>
                <textarea name="txtMensaje" id="txtMensaje" class="form-control" rows="3" placeholder="Enter ..."></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="sav_msj_correo(<?php echo $IdUsua; ?>)"> <i class="fa fa-fw fa-save"></i> Enviar correo</button>
        </div>
      </div>
    </table>
  </div>

  </form>
<script>
  function sav_msj_correo(IdUsua){
    var IdCampus = document.getElementById("txtCampusx").value;
    var IdGrupo = document.getElementById("txtGrupox").value;
    var Asunto = document.getElementById("txtAsunto").value;
    var Mensaje = document.getElementById("txtMensaje").value;

    if (IdCampus ==""){
        swal("Error al guardar", "Debe seleccionar el campus.", "error");
        document.getElementById("txtCampusx").focus();
        return 0;
    }
    if (IdGrupo ==""){
        swal("Error al guardar", "Debe seleccionar el grupo.", "error");
        document.getElementById("txtGrupox").focus();
        return 0;
    }
    if (Asunto ==""){
        swal("Error al guardar", "Debe escribir el asunto.", "error");
        document.getElementById("txtAsunto").focus();
        return 0;
    }
    if (Mensaje ==""){
        swal("Error al guardar", "Debe escribir el mensaje del correo.", "error");
        document.getElementById("txtMensaje").focus();
        return 0;
    }

    var TipoGuardar = "sav_envio_mail";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea enviar este correo?",
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
             data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdCampus:IdCampus, IdGrupo:IdGrupo, Asunto:Asunto, Mensaje:Mensaje},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Enviado correctamente", "El correo se ha  enviado correctamente.", "success");
            var IdCampus = 0;
        		var IdGrupo = 0;
        		$.ajax({
        				 url:"formConsulta/captura_envio_correo.php",
        				 method:"POST",
        				 data:{IdCampus:IdCampus, IdGrupo:IdGrupo},
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

  function sel_campusgx(){
    var IdCampus = document.getElementById("txtCampusx").value;
    var IdGrupo = document.getElementById("txtGrupox").value;

    $.ajax({
				 url:"formConsulta/captura_envio_correo.php",
				 method:"POST",
				 data:{IdCampus:IdCampus, IdGrupo:IdGrupo},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
				 }
		});
  }

  function sel_grupogx(){
    var IdCampus = document.getElementById("txtCampusx").value;
    var IdGrupo = document.getElementById("txtGrupox").value;

    $.ajax({
				 url:"formConsulta/captura_envio_correo.php",
				 method:"POST",
				 data:{IdCampus:IdCampus, IdGrupo:IdGrupo},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
				 }
		});
  }
</script>

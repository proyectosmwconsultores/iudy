<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $IdCampus = $_POST["IdCampus"];
  $idDoc = $_SESSION['IdUsua'];
  $sqle9 = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$idDoc'");
  $db->rows($sqle9);
  $datose91 = $db->recorrer($sqle9);

  $sql1 = $db->query("SELECT tblc_campus.IdCampus, tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.id_usua = '$idDoc'");
  $sqlx = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa");
  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
    <div class="box-header with-border">
      <h3 class="box-title">Responsable de la activación del alumno</h3>
    </div>
    <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username"><?php echo $datose91['Nombre'].' '.$datose91['APaterno'].' '.$datose91['AMaterno']; ?></h3>
              <h5 class="widget-user-desc">Docente</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="assets/perfil/<?php echo $datose91['Foto']; ?>" alt="User Avatar">
            </div>
            <br><br>
            <div class="direct-chat-text">
              <b>Nota:</b> si usted activa este alumno a su cuenta, el alumno aparecera en su paquete de MWComenius.
            </div><br>




          </div>
          <table class="table table-bordered">
            <div class="box box-primary" style="border-top: none; margin-top: -5px;">

              <div class="col-md-12">
                <div class="form-group">
                  <label>Campus/Escuela:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <select class="form-control" name="txtCampus" id="txtCampus" onchange="cambioCampus()">
                      <option value=""> - Seleccione - </option>
                      <?php while($y2 = $db->recorrer($sql1)){ ?>
                      <option class="form-control"  value="<?php echo $y2["IdCampus"]; ?>"  <?php if($IdCampus==$y2["IdCampus"]){?>selected="selected"<?php }?>> <?php echo $y2["Campus"]; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Oferta educativa:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <select class="form-control" name="txtOferta" id="txtOferta" onchange="cambioOferta()">
                      <option value=""> - Seleccione - </option>
                      <?php while($yx = $db->recorrer($sqlx)){ ?>
                      <option class="form-control"  value="<?php echo $yx["IdEducativa"]; ?>" > <?php echo $yx["Nombre"]; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                    <button type="button" class="btn btn-block btn-danger" onclick="actAlumno(<?php echo $IdUsua; ?>,<?php echo $idDoc; ?>)"><i class="fa fa-fw fa-check-circle"></i> Activar alumno a mi cuenta</button>
                </div>
              </div>


            </div>

          </table>





  </form>
<script>
function cambioCampus(){
  var IdCampus = document.getElementById("txtCampus").value;
  var IdUsua = document.getElementById("IdUsua").value;


  $.ajax({
			 url:"reportes/activarAlumno.php",
			 method:"POST",
			 data:{IdUsua:IdUsua, IdCampus:IdCampus},
			 success:function(data){
						$('#employee_Grp').html(data);
						$('#dataGrp').modal('show');
			 }
	});

}

function actAlumno(IdUsua,IdDocente){
    var TipoGuardar = "actAlumnoD";
    var IdCampus = document.getElementById("txtCampus").value;
    var IdOferta = document.getElementById("txtOferta").value;

    if (IdCampus ==""){
        swal("Error al guardar", "Debe seleccionar el campus/escuela.", "error");
        return 0;
    }
    if (IdOferta ==""){
        swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
        return 0;
    }

    swal({
      title: "\u00BFEst\u00E1 seguro que desea activar este alumno a su cuenta?",
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
             url:"reportes/setting.php",
             method:"POST",
             data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdDocente:IdDocente, IdCampus:IdCampus, IdOferta:IdOferta},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==1){
            swal("Activado correctamente", "El alumno se ha activado correctamente a su cuenta.", "success");
            parent.location.href='alumno.php?token=1598989985'+IdUsua; //direcciona la pagina madre
          }
          if(data==4){
            swal("Error al activar", "No se puede activar el alumno, usted ya no tiene espacio en la Plataforma MWComenius.", "error");
          }

        })
        .error(function(data) {
          swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
        });
      }
    });

}

</script>

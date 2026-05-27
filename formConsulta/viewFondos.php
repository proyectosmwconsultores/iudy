<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $code = $_POST["employee_id"];

  $sqlH = $db->query("SELECT tblp_asignacion.Fondo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$code'");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);

  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input name="txt_Fondo" id="txt_Fondo" value="<?php echo $datos81['Fondo']; ?>" type="hidden" >
    <input name="txt_Texto" id="txt_Texto" value="txt_<?php echo $datos81['Fondo']; ?>" type="hidden" >
    <input name="txt_xcode" id="txt_xcode" value="<?php echo $code; ?>" type="hidden" >
    <div class="post">
                  <div class="row margin-bottom">
                    <?php for($i= 1; $i <= 15; $i++){ $img = "img_$i.jpg"; $label = "txt_img_$i.jpg"; ?>
                    <div class="col-sm-3" onclick="sel_Chk(<?php echo $i; ?>)" style="cursor: pointer;">
                      <img class="img-responsive" src="assets/fondo/img_<?php echo $i; ?>.jpg" alt="Photo" style='height: 100px;'>
                      <div class="checkbox">
                        <label><input id="<?php echo $img; ?>" name="<?php echo $img; ?>" <?php if($datos81['Fondo'] == $img){ echo 'checked'; } ?> type="checkbox"> <p id="<?php echo $label; ?>" name="<?php echo $label; ?>" ><?php if($datos81['Fondo'] == $img){ echo 'Seleccionado'; } else { echo 'Disponible'; } ?></p></label>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>

                <div class="box-footer">
                <button onclick="aplicarTema()" type="button" class="btn btn-info pull-right"> <i class="fa fa-fw fa-check-circle"></i> Aplicar fondo</button>
                <button type="button" data-dismiss="modal" class="btn btn-success pull-right" style="margin-right: 15px;"><i class="fa fa-fw fa-times-circle"></i> Cancel</button>
              </div>
  </form>
<script>
  function sel_Chk(IdImagen){
    var Imagen = 'img_'+IdImagen+'.jpg';
    var Label = 'txt_img_'+IdImagen+'.jpg';
    var Selecccionado = document.getElementById("txt_Fondo").value;
    var Texto = document.getElementById("txt_Texto").value;

    if(Imagen == Selecccionado){
      document.getElementById(Selecccionado).checked = true;
    } else {
      document.getElementById(Imagen).checked = true;
      document.getElementById(Selecccionado).checked = false;
      document.getElementById(Texto).innerHTML = "No Disponible";
      document.getElementById(Label).innerHTML = "Seleccionado";
      document.getElementById("txt_Fondo").value = Imagen;
      document.getElementById("txt_Texto").value = Label;
    }
  }

  function aplicarTema(){
    var IdAsignacion = document.getElementById("txt_xcode").value;
    var Fondo = document.getElementById("txt_Fondo").value;
    var TipoGuardar = "aplFondo";

        swal({
          title: "\u00BFEst\u00E1 seguro que desea aplicar este fondo a esta clase?",
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
                 data:{TipoGuardar:TipoGuardar, IdAsignacion:IdAsignacion, Fondo:Fondo},
                 success:function(data){

                 }
            })
            .done(function(data) {
      				if(data==1){
      					swal("Aplicado correctamente", "El fondo se ha aplicado correctamente a la clase.", "success");
                parent.location.href='doMiPlaneacion.php?idToks='+IdAsignacion; //direcciona la pagina madre
      				} else {
                swal("Error al aplicar", "Ha ocurrido un error no se puede aplicar el fondo.", "error");
              }
      			})
      			.error(function(data) {
      				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
      			});

          }

        });

  }
</script>

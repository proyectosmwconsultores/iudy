<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="TipoGuardar" name="TipoGuardar" value="savClase" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="col-md-12">
          <div class="form-group">
            <label>Código de clase:</label>
            <span class="help-block">Pídale a su maestro el código de la clase y luego ingréselo aquí.</span>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <input maxlength="9" name="txt_clase" id="txt_clase" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Para iniciar sesión con un código de clase</label>
            <span class="help-block">Use un código de clase con 9 letras o números, y sin espacios ni símbolos.</span>
          </div>
        </div>
        <?php if($_SESSION['IdEstatus'] == 8){ ?>
        <div class="col-md-12">
          <div class="form-group"><br>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
              <button type="button" class="btn btn-primary pull-right" onClick="savUnirse(<?php echo $_SESSION['IdUsua']; ?>)"> <i class="fa fa-fw fa-check-circle"></i> Unirse a la clase</button>
            </div>
          </div>
        </div><?php } ?>



      </div>
    </table>
  </div>

  </form>

<script>
  function savUnirse(IdUsua){
    var Code = document.getElementById("txt_clase").value;
    var Total = Code.length;

    if (Code==""){
      swal("Error al unirse", "Debe escribir su el código de la clase", "error");
          document.getElementById("txt_clase").focus();
          return 0;
      }

    if(Total == 9){
      var TipoGuardar = "unirseClase";

          swal({
            title: "\u00BFEst\u00E1 seguro que desea unirse a esta clase?",
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
                   data:{TipoGuardar:TipoGuardar, Code:Code, IdUsua:IdUsua},
                   success:function(data){


                   }
              })
              .done(function(data) {
        				if(data==1){
        					swal("Error al unirse", "No existe ninguna clase con el código ingresado.", "error");
        				}
                if(data==2){
        					swal("Error al unirse", "Usted ya esta dado de alta con este código de clase.", "error");
        				}
                if(data==3){
        					swal("Unido correctamente", "El código de la clase se ha ingresado correctamente.", "success");
                  parent.location.href='mis_clases.php';
        				}
        			})
        			.error(function(data) {
        				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
        			});

            }

          });
    } else {
      swal("Error de código", "Código de clase incompleta, deben ser 10 caracteres, incluidos números y letras.", "error");
    }




  }

</script>

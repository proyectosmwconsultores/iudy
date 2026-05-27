<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdDocDocente = $_POST["IdDocDocente"];
  $Tipo = $_POST["Tipo"];
  if($Tipo == 1){
    $_tx = "Título";
  } else {
    $_tx = "Cédula";
  }

  $sql_g = $db->query("SELECT * FROM tblc_docdocentes WHERE tblc_docdocentes.IdDocDocente = '$IdDocDocente'");
  $db->rows($sql_g);
  $_grad = $db->recorrer($sql_g);

  ?>

  <form name="frm2" class="form-horizontal" id="frm2" action="addGrado.php" method="POST" enctype="multipart/form-data">
      <div class="box-body">
        <div class="bg-aqua color-palette" style="padding: 5px;"><span style="color: #11101e;"><i class="fa fa-fw fa-flag-o"></i> <?php echo $_grad['Nombre']; ?></span></div>
        <br><br>
        <div class="form-group">
          <label class="col-sm-4 control-label">Buscar <?php echo $_tx; ?>:</label>
          <div class="col-sm-8">
            <input class="form-control" id="txt_titulox" name="txt_titulox" type="file" onchange="validar_titulo_file(this)">
          </div>
        </div>
        <?php if($Tipo == 2){ ?>
        <div class="form-group">
          <label class="col-sm-6 control-label">Número Cédula Profesional:</label>
          <div class="col-sm-6">
            <input class="form-control" id="txt_no_cedula" name="txt_no_cedula" type="text" value="<?php echo $_grad['Numero']; ?>">
          </div>
        </div><?php } else { ?>
          <input class="form-control" id="txt_no_cedula" name="txt_no_cedula" type="hidden">
        <?php } ?>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="button" onClick="upd_mi_grado(<?php echo $IdDocDocente; ?>,<?php echo $_grad['IdUsua']; ?>)" class="btn btn-info pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
      </div>

  </form>

<script>
  function validar_titulo_file(obj){
    var dispox = 0;
      var uploadFile = obj.files[0];
      if (!window.FileReader) { dispox = 1;
      	swal("Error", "EL NAVEGADOR NO SOPORTA LA LECTURA DE ARCHIVOS", "error");
          return;
      }

      if (!(/\.(jpg|png|pdf)$/i).test(uploadFile.name)) { dispox = 1;
      	swal("Error al subir", "Porfavor, cargue solamente archivo  .pdf / .png / .jpg", "error");
          document.getElementById("txt_titulox").value='';
          document.getElementById("txt_titulox").focus();
      }
      else {
          var img = new Image();
          if (uploadFile.size > 5000000)
          { dispox = 1;
          	swal("Error al subir", "El peso del archivo debe ser menor a 5 MB", "error");
              document.getElementById("txt_titulox").value='';
              document.getElementById("txt_titulox").focus();
          }

      }
  }



  function upd_mi_grado(IdDocDocente,IdUsua){
    var Archivo = document.getElementById("txt_titulox").value;
    var NoCedula = document.getElementById("txt_no_cedula").value;

    var Imagen3 = '#txt_titulox';

    if (Archivo ==0){
  			swal("Error al guardar", "Debe seleccionar el archivo que desea subir.", "error");
  			return 0;
  	}

    swal({
    title: "\u00BFEst\u00E1 seguro que desea subir este archivo?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Aceptar',
    cancelButtonText: "Cancelar",
  },
  function (isConfirm) {
    if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');

      var formData = new FormData();
      var files3 = $(Imagen3)[0].files[0];
      formData.append('IdDocDocente',IdDocDocente);
      formData.append('NoCedula',NoCedula);

      formData.append('files3',files3);

      $.ajax({
          url: 'upload_upd_grado_file.php',
          type: 'post',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
          }
      })
      .done(function(response) {
        if(response==1){
          datos_docente(IdUsua);

          swal("Actualizado correctamente", "El documento del grado de estudio de ha actualizado correctamente.", "success");
          $('#data_grad_u').modal('hide');

        }else{
          swal("Error al guardar", "No se puede guardar los datos.", "error");
        }
      })
      .error(function(data) {
        swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
      });
		}
  });
  }
</script>

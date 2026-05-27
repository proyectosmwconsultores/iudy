<?php
include('../hace.php');
if(isset($_POST["IdUsua"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];

  $sql9 = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);


  ?>
  <form name="frm" id="frm" action="configurarDocs.php" method="POST" enctype="multipart/form-data" class="form-horizontal">


    <div class="box-body">
      <div class="col-md-12">
        <div class="box-body box-profile" style="text-align: center;">
        <img style="width: 30%;" src="assets/perfil/<?php echo $datos91["Foto"]; ?>" alt="User profile picture">
        <h3 class="profile-username text-center"><?php echo $datos91["Nombre"]; ?></h3>
        <p class="text-muted text-center"><?php echo $datos91["APaterno"].' '.$datos91["AMaterno"]; ?></p>

        <div class="form-group" style="text-align: left;">
        <label>Buscar nueva foto de perfil:</label>
        <input type="file" class="form-control" id="txtArchivoy" name="txtArchivoy" onchange="validar_foto_perfil(this)">
        </div>
        <a onclick="subir_fotox(<?php echo $IdUsua; ?>)" class="btn btn-primary btn-block"><b><i class="fa fa-fw fa-cloud-upload"></i> Subir foto de perfil</b></a>
        </div>
      </div>
    </div>
  </form>
<script>
function subir_fotox(IdUsua){
  var Archivo = document.getElementById("txtArchivoy").value;
  var Imagen = '#txtArchivoy';

  if (Archivo ==""){
      swal("Error al guardar", "Debe seleccionar la foto de perfil del alumno.", "error");
      return 0;
  }


  swal({
    title: "\u00BFEst\u00E1 seguro que desea subir esta foto de perfil del alumno?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Aceptar',
    cancelButtonText: "Cancelar",
  },
  function (isConfirm) {
    if(isConfirm) {
    $(".confirm").attr('disabled', 'disabled');

    var formData = new FormData();
    var files = $(Imagen)[0].files[0];
    formData.append('IdUsua',IdUsua);
    formData.append('file',files);

    $.ajax({
        url: 'upload_foto_perfil.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {

        }
    })
    .done(function(response) {
      if(response==1){
        swal("Actualizado correctamente", "La foto de perfil se ha actualizado correctamente.", "success");
        $.ajax({
             url:"formConsulta/foto_perfil.php",
             method:"POST",
             data:{IdUsua:IdUsua},
             success:function(data){
                  $('#employee_detailPerfil').html(data);
                  $('#dataModalPerfil').modal('show');
             }
        });
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

function validar_foto_perfil(obj){
    var uploadFile = obj.files[0];
    var fileInput = document.getElementById('txtArchivo');
    if (!window.FileReader) {
			swal("Error", "El navegador no soporta la lectura de archivos.", "error");
        return;
    }

    if (!(/\.(jpg|png)$/i).test(uploadFile.name)) {
			swal("Error", "Favor de subir la foto de perfil en formato .jpg | .png.", "error");
            document.getElementById("txtArchivo").value='';
    }
}
</script>

  <?php
}
?>

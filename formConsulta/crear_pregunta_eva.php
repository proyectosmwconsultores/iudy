<?php
  session_start();
  require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();


  ?>
    <div class="box-body">
    <form role="form">
      <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_POST["IdAsignacion"]; ?>" type="hidden"/>
      <div class="form-group">
        <label>Escriba la pregunta:</label>
        <textarea name="txt_comentario" id="txt_comentario" class="form-control" rows="3" placeholder="Escriba un comentario a cerca de su comprobante de pago ..."></textarea>
      </div>
      <div class="form-group">
        <label>Tipo pregunta:</label>
        <select class="form-control" name="txt_tipop" id="txt_tipop">
          <option value="">- Seleccione -</option>
          <option value="A">Pregunta abierta</option>
          <option value="O">Opción Múltiple</option>
        </select>
      </div>
      <div class="form-group">
        <label>Buscar archivo: (opcional .jpg .png)</label>
        <input onchange="validar_file_exa(this,'txt_file');" name="txt_file" id="txt_file" type="file" class="form-control" placeholder="Enter ...">
      </div>

    <div class="box-footer">
    <button type="button" onclick="sav_preg_ex(<?php echo $_POST['IdActividadDoc']; ?>,<?php echo $_POST['IdParcialDoc']; ?>,<?php echo $_SESSION['IdUsua']; ?>)" class="btn btn-primary pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
    </div>
    </form>
  </div>





<script>
  function sav_preg_ex(IdActividadDoc,IdParcialDoc,IdUsua){
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    var Archivo = document.getElementById("txt_file").value;
    var Pregunta = document.getElementById("txt_comentario").value;
    var Tipo = document.getElementById("txt_tipop").value;
    var Imagen = '#txt_file';

    if (Pregunta==""){
        swal("Error al guardar", "Debe escribir la pregunta de la evaluación.", "error");
        document.getElementById("txt_comentario").focus();
        return 0;
    }
    if (Tipo==""){
        swal("Error al guardar", "Debe seleccionar el tipo de pregunta.", "error");
        document.getElementById("txt_tipop").focus();
        return 0;
    }
    var TipoGuardar = "solDocss";

      swal({
        title: "\u00BFEst\u00E1 seguro que desea agregar esta nueva pregunta?",
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
        formData.append('Tipo',Tipo);
        formData.append('Pregunta',Pregunta);
        formData.append('IdActividadDoc',IdActividadDoc);
        formData.append('IdParcialDoc',IdParcialDoc);
        formData.append('IdAsignacion',IdAsignacion);
        formData.append('IdUsua',IdUsua);

        formData.append('file',files);

        $.ajax({
            url: 'upload_img_pregunta.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {

            }
        })
        .done(function(response) {
          if(response==1){
            swal("Guardado correctamente", "La pregunta se ha guardado correctamente.", "success");
            lista_pregunta_id(IdActividadDoc);
            $.ajax({
      					 url:"formConsulta/crear_pregunta_eva.php",
      					 method:"POST",
      					 data:{IdActividadDoc:IdActividadDoc, IdAsignacion: IdAsignacion, IdParcialDoc:IdParcialDoc},
      					 success:function(data){
      								$('#employee_detailPE').html(data);
      								$('#dataModalPE').modal('show');
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

</script>

<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();
$Anio = date("Y");
$sql_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio = '$Anio' ORDER BY tblc_ciclo.FInicio ASC");

?>

<form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Título del aviso:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-tags"></i>
              </div>
              <input maxlength="80" type="text" name="txt_titulo" id="txt_titulo" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Periodo escolar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-tags"></i>
              </div>
              <select name="txt_ciclo" id="txt_ciclo" class="form-control">
                <option value="">- Seleccione campus - </option>
                <?php while ($cic = $db->recorrer($sql_cic)) { ?>
                  <option value="<?php echo $cic['IdCiclo']; ?>"><?php echo $cic['Ciclo']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Tipo de aviso:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-tags"></i>
              </div>
              <select name="txt_tipo" id="txt_tipo" class="form-control" onchange="sel_tipo()">
                <option value="">- Seleccione - </option>
                <option value="pdf">PDF</option>
                <option value="jpg">JPG</option>
                <option value="txt">Texto</option>
              </select>
            </div>
          </div>
        </div>
        <div id='div1' style="display: none;">
          <div class="col-md-12">
            <div class="form-group">
              <label>Texto del aviso</label>
              <div class="input-group">
                <textarea name="txt_texto" id="txt_texto" class="textarea" placeholder="Escriba el contenido del aviso..." style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div id='div2' style="display: none;">
          <div class="col-md-12">
            <div class="form-group">
              <label>Archivo (pdf / jpg / png):</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-file"></i>
                </div>
                <input type="file" name="txtArchivo" id="txtArchivo" class="form-control">
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
        <button type="button" class="btn btn-primary pull-right" onClick="sav_new_aviso(<?php echo $_SESSION["IdUsua"];  ?>)"> <i class="fa fa-fw fa-save"></i> Guardar aviso</button>
      </div>
    </table>
  </div>
</form>
<script>
  $(function() {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>

<script>
  function sel_tipo() {
    var Tipo = document.getElementById("txt_tipo").value;
    if (Tipo == 'txt') {
      document.getElementById("div1").style.display = "block";
    } else {
      document.getElementById("div1").style.display = "none";
    }
    if ((Tipo == 'pdf') || (Tipo == 'jpg')) {
      document.getElementById("div2").style.display = "block";
    } else {
      document.getElementById("div2").style.display = "none";
    }
  }


  function sav_new_aviso(IdUsua) {
    var Titulo = document.getElementById("txt_titulo").value;
    var IdCiclo = document.getElementById("txt_ciclo").value;
    var Tipo = document.getElementById("txt_tipo").value;
    var Texto = document.getElementById("txt_texto").value;

    var Archivo = document.getElementById("txtArchivo").value;
    var Imagen = '#txtArchivo';

    if (Titulo == "") {
      swal("Error al guardar", "Debe escribir el titulo del aviso.", "error");
      return 0;
    }
    if (IdCiclo == "") {
      swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
      return 0;
    }
    if (Tipo == "") {
      swal("Error al guardar", "Debe seleccionar el tipo de aviso.", "error");
      return 0;
    }

    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar este aviso?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');

          var formData = new FormData();
          var files = $(Imagen)[0].files[0];
          formData.append('IdUsua', IdUsua);
          formData.append('Titulo', Titulo);
          formData.append('IdCiclo', IdCiclo);
          formData.append('Tipo', Tipo);
          formData.append('Texto', Texto);

          formData.append('file', files);

          $.ajax({
              url: 'upload_aviso.php',
              type: 'post',
              data: formData,
              contentType: false,
              processData: false,
              success: function(response) {

                 
              }
            })
            .done(function(response) {
              if (response == 1) {
                swal("Guardado correctamente", "El aviso se ha guardado correctamente.", "success");
                cargar_ultimo_gasto();
                $.ajax({
                  url: "vistas/admin/captura_aviso.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua
                  },
                  success: function(data) {
                    $('#employee_detailC').html(data);
                    $('#dataModalC').modal('show');
                  }
                });
              } 
              if (response == 2) {
                swal("Error al guardar", "La imagen del aviso no se pudo subir.", "error");
              }
              if (response == 3) {
                swal("Error al guardar", "Favor de verificar el formato del archivo que esta subiendo.", "error");
              } 
              if (response == 4) {
                swal("Error al guardar", "Favor de seleccionar el archivo del aviso.", "error");
              } 
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });


        }
      });
  }
</script>
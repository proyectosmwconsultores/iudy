<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();
$Anio = date("Y");
$IdAviso = $_POST['IdAviso'];
$sql_con = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdAviso = '$IdAviso' ");
$db->rows($sql_con);
$_avi = $db->recorrer($sql_con);


$sql_cic = $db->query("SELECT * FROM tblc_periodo_ps WHERE tblc_periodo_ps.Tipo = 'P' ORDER BY tblc_periodo_ps.Inicia ASC ");

?>

<form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box-body">
      <div class="col-md-12">
          <div class="form-group">
            <label>Periodo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-tags"></i>
              </div>
              <select class="form-control" disabled>
                <option value="">- Seleccione campus - </option>
                <?php while ($cic = $db->recorrer($sql_cic)) { ?>
                  <option value="<?php echo $cic['IdPeriodo']; ?>" <?php if($cic['IdPeriodo'] == $_avi['IdCiclo']){ ?>selected="selected"<?php } ?>><?php echo $cic['Periodo']; ?> <?php echo $cic['Anio']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Título del aviso:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-tags"></i>
              </div>
              <input maxlength="80" type="text" name="txt_titulox" id="txt_titulox" class="form-control" value="<?php echo $_avi['Titulo']; ?>">
            </div>
          </div>
        </div>
       
        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha inicio de inscripcion:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-tags"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker1x" name="datepicker1x" value="<?php echo $_avi['Inicio']; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha límite de inscripcion:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-tags"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker2x" name="datepicker2x" value="<?php echo $_avi['Final']; ?>">
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label>Texto del aviso de la práctica:</label>
            <div class="input-group">
              <textarea name="txt_textox" id="txt_textox" class="textarea" placeholder="Escriba el contenido del aviso..." style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $_avi['Texto']; ?></textarea>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
        <button type="button" class="btn btn-primary pull-right" onClick="upd_new_aviso(<?php echo $_SESSION["IdUsua"];  ?>,<?php echo $IdAviso; ?>)"> <i class="fa fa-fw fa-save"></i> Actualizar aviso</button>
      </div>
    </table>
  </div>
</form>
<script>
  $(function() {

   
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
    $('#datepicker1x').datepicker({
      autoclose: true
    })
    $('#datepicker2x').datepicker({
      autoclose: true
    })
  })
</script>

<script>
  function upd_new_aviso(IdUsua, IdAviso) {
    var Titulo = document.getElementById("txt_titulox").value;
    var Texto = document.getElementById("txt_textox").value;
    var Inicio = document.getElementById("datepicker1x").value;
    var Final = document.getElementById("datepicker2x").value;
    

    if (Titulo == "") {
      swal("Error al guardar", "Debe escribir el titulo del aviso.", "error");
      return 0;
    }
    if (Inicio == "") {
      swal("Error al guardar", "Debe seleccionar la fecha inicial de inscripción.", "error");
      return 0;
    }
    if (Final == "") {
      swal("Error al guardar", "Debe seleccionar la fecha final de inscripción.", "error");
      return 0;
    }
    if (Texto == "") {
      swal("Error al guardar", "Debe escribir el mensaje del aviso.", "error");
      return 0;
    }
    var TipoGuardar = 'updx_aviso_nuevo';

    swal({
        title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de este aviso?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',

      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              url: "vistas/practicas/sav_desarrollo.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                Titulo: Titulo,
                IdAviso: IdAviso,
                Texto: Texto,
                Inicio: Inicio,
                Final: Final
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Actualizado correctamente", "El aviso se ha actualizado correctamente.", "success");
                cargar_ultimo_gasto();
                $.ajax({
                url: "vistas/practicas/actualizar_aviso.php",
                method: "POST",
                data: {
                  IdAviso: IdAviso
                },
                success: function(data) {
                  $('#employee_detailA').html(data);
                  $('#dataModalA').modal('show');
                }
              });
              }
              if (data == 2) {
                swal("Error al reincorporar", "El alumno ya se encuentra en proceso de reincorporación en este periodo escolar seleccionado.", "info");
              }
            })
            .error(function(data) {
              swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
            });

        }
      });
  }
</script>
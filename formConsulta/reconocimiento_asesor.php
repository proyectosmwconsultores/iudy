<?php
  session_start();
  include('../hace.php');
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAsignacion = $_POST["IdAsignacion"];
  $IdDocente = $_POST["IdDocente"];

  $sql9 = $db->query("SELECT tblp_asignacion.Reconocimiento, tblp_asignacion.Fec_reconocimiento, tblp_asignacion.Anio, tblp_asignacion.Mes FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  ?>
  <div class="box-body">
    <form class="form-horizontal">
      <input type="hidden" name="IdAsignacion" id="IdAsignacion" value="<?php echo $IdAsignacion; ?>">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-6 control-label">Fecha del reconocimiento:</label>

        <div class="col-sm-6">
          <input type="text" class="form-control" id="txt_fecha" name="txt_fecha" >
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Reconocimiento (JPG/PNG):</label>
        <div class="col-sm-6">
          <input type="file" class="form-control" name="txtArchivo" id="txtArchivo" onchange="validar_img(this,'txtArchivo');" >
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="subir_recono(<?php echo $IdDocente; ?>)" type="button" class="btn btn-info pull-right"><i class="fa fa-save"></i> Guardar reconocimiento</button>
    </div>
  </form>
  <?php if($datos91['Reconocimiento']){ ?>
  <div class="box box-solid">
    <div class="box-header with-border">
      <i class="fa fa-text-width"></i>

      <h3 class="box-title">Reconocimiento de la materia - <i class="fa fa-calendar"></i> <?php echo obtenerFechaCorta($datos91['Fec_reconocimiento']); ?></h3>
    </div>

    <img style="text-align: center; width: 100%;" src="assets/docs/files/<?php echo $datos91['Anio']; ?>/<?php echo $datos91['Mes']; ?>/<?php echo $datos91['Reconocimiento']; ?>">
  </div><?php } ?>
</div>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


<script>
  function subir_recono(IdDocente){
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    var Fecha = document.getElementById("txt_fecha").value;
    var Archivo = document.getElementById("txtArchivo").value;
    var Imagen = '#txtArchivo';

    if (Fecha ==""){
        swal("Error al guardar", "Debe seleccionar la fecha de emisión del reconocimiento.", "error");
        return 0;
    }
    if (Archivo ==""){
        swal("Error al guardar", "Debe seleccionar el archivo del reconocimiento.", "error");
        return 0;
    }

    var TipoGuardar = "sav_seg_alumno";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar este reconocimiento para este docente?",
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
      formData.append('IdAsignacion',IdAsignacion);
      formData.append('Fecha',Fecha);

      formData.append('file',files);

      $.ajax({
          url: 'upload_reconocimiento_asesor.php',
          type: 'post',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {

// alert(response);
          }
      })
      .done(function(response) {
        if(response==1){
          swal("Guardado correctamente", "Los el reconocimiento se ha guardado correctamente.", "success");
          $.ajax({
          		 url:"formConsulta/reconocimiento_asesor.php",
          		 method:"POST",
          		 data:{IdAsignacion:IdAsignacion, IdDocente:IdDocente},
          		 success:function(data){
          					$('#employee_EncRec').html(data);
          					$('#dataEncRec').modal('show');
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

  $(function () {
    $('#txt_fecha').datepicker({
      autoclose: true
    })


  })
</script>

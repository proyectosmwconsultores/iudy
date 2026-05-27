<?php
  session_start();
  include('../hace.php');
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $IdDocente = $_POST["IdDocente"];

  $sql = $db->query("SELECT * FROM tblc_tipo_reconocomiento WHERE tblc_tipo_reconocomiento.Valor = '1' ");


  ?>
  <div class="box-body">
    <form class="form-horizontal">

    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-6 control-label">Fecha del reconocimiento:</label>

        <div class="col-sm-6">
          <input type="text" class="form-control" id="txt_fecha" name="txt_fecha" >
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Tipo de reconocimiento:</label>
        <div class="col-sm-6">
          <select class="form-control" name="txtTipo" id="txtTipo">
            <option value=""> - Seleccione - </option>
            <?php while($x = $db->recorrer($sql)){ ?>
            <option value="<?php echo $x["IdTipoReconocimiento"]; ?>">  <?php echo $x["Reconocimiento"]; ?></option>
            <?php } ?>
          </select>
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
      <button onclick="subir_reconox(<?php echo $IdUsua; ?>, <?php echo $IdDocente; ?>)" type="button" class="btn btn-info pull-right"><i class="fa fa-save"></i> Guardar reconocimiento</button>
    </div>
  </form>

</div>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


<script>
  function subir_reconox(IdUsua, IdDocente){

    var Fecha = document.getElementById("txt_fecha").value;
    var Tipo = document.getElementById("txtTipo").value;
    var Archivo = document.getElementById("txtArchivo").value;
    var Imagen = '#txtArchivo';

    if (Fecha ==""){
        swal("Error al guardar", "Debe seleccionar la fecha de emisión del reconocimiento.", "error");
        return 0;
    }
    if (Tipo ==""){
        swal("Error al guardar", "Debe seleccionar el tipo de reconocimiento.", "error");
        return 0;
    }
    if (Archivo ==""){
        swal("Error al guardar", "Debe seleccionar el archivo del reconocimiento.", "error");
        return 0;
    }

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
      formData.append('IdUsua',IdUsua);
      formData.append('IdDocente',IdDocente);
      formData.append('Tipo',Tipo);
      formData.append('Fecha',Fecha);

      formData.append('file',files);

      $.ajax({
          url: 'upload_reconocimiento_asesor_all.php',
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
          swal("Guardado correctamente", "El reconocimiento se ha guardado correctamente.", "success");
          cargar_recono(IdUsua, IdDocente);
          $.ajax({
        			 url:"formConsulta/subir_reconocimiento_asesor.php",
        			 method:"POST",
        			 data:{IdUsua:IdUsua, IdDocente:IdDocente},
        			 success:function(data){
        						$('#employee_EncRecy').html(data);
        						$('#dataEncRecy').modal('show');
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

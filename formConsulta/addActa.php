<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAsignacion = $_POST["IdAsignacion"];


  $sql8 = $db->query("SELECT tblp_asignacion.Anio, tblp_asignacion.Plantel FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Anio = $datos81['Anio'];
  $Plantel = $datos81['Plantel'];
  ?>
  <script>
      function validar_acta(obj){
        var uploadFile = obj.files[0];
        if (!window.FileReader) {
        	swal("Error", "EL NAVEGADOR NO SOPORTA LA LECTURA DE ARCHIVOS", "error");
            return;
        }

        if (!(/\.(pdf)$/i).test(uploadFile.name)) {
        	swal("Error al subir", "Porfavor, cargue solamente archivo  .pdf", "error");
            document.getElementById("txt_acta").value='';
            document.getElementById("txt_acta").focus();
        }
        else {
            var img = new Image();
            if (uploadFile.size > 5000000)
            {
            	swal("Error al subir", "El peso del archivo debe ser menor a 5 MB", "error");
                document.getElementById("txt_acta").value='';
                document.getElementById("txt_acta").focus();
            }
        }
    }


    function save_mi_gradow(){
      var Acta = document.getElementById("txt_acta").value;
      var IdAsignacion = document.getElementById("IdAsignacion").value;

      var Imagen1 = '#txt_acta';

    	if (Acta ==''){
    			swal("Error al guardar", "Debe seleccionar el acta de calificación escaneado.", "error");
    			document.getElementById("txt_acta").focus();
    			return 0;
    	}

      swal({
      title: "\u00BFEst\u00E1 seguro que desea subir este documento?",
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
        var files1 = $(Imagen1)[0].files[0];
        formData.append('Acta',Acta);
        formData.append('IdAsignacion',IdAsignacion);

        formData.append('file1',files1);

        $.ajax({
            url: 'upload_acta_calificacion.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) { //alert(response);

            }
        })
        .done(function(response) {
          if(response==1){
            // datos_docente(IdUsua);
            cargar_calificacionx(IdAsignacion);
            swal("Guardado correctamente", "El acta de calificación se ha subido correctamente.", "success");

            $.ajax({
                url:"formConsulta/addActa.php",
                method:"POST",
                data:{IdAsignacion:IdAsignacion},
                success:function(data){
                     $('#employee_fondo').html(data);
                     $('#dataFondo').modal('show');
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

    function del_acatax(){
      var IdAsignacion = document.getElementById("IdAsignacion").value;
      var TipoGuardar = "del_cata_clas";
      swal({
        title: "\u00BFEst\u00E1 seguro que desea eliminar el acta de calificación actual?",
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
               data:{TipoGuardar:TipoGuardar, IdAsignacion:IdAsignacion},
               success:function(data){
               }
          })
          .done(function(data) {
            if(data==1){
              swal("Eliminado correctamente", "El documento del acta de calificacion se ha eliminado correctamente.", "success");
              $.ajax({
                  url:"formConsulta/addActa.php",
                  method:"POST",
                  data:{IdAsignacion:IdAsignacion},
                  success:function(data){
                       $('#employee_fondo').html(data);
                       $('#dataFondo').modal('show');
                  }
             });
            }

          })
          .error(function(data) {
            swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
          });
        }

      });
    }
  </script>
    <form name="frm2" class="form-horizontal" id="frm2" action="addGrado.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="IdAsignacion" id="IdAsignacion" value="<?php echo $IdAsignacion; ?>">
                <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-6 control-label">Acta de calificación escaneado:</label>
                    <div class="col-sm-6">
                      <input class="form-control" id="txt_acta" name="txt_acta" type="file" onchange="validar_acta(this)">
                    </div>
                  </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="button" onClick="save_mi_gradow()" class="btn btn-info pull-right"><i class="fa fa-fw fa-save"></i> Subir acta</button>
                  <?php if($Plantel){  ?>
                  <button type="button" onClick="del_acatax()" class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-fw fa-trash"></i> Eliminar acta</button>
                <?php } ?>
                </div>
                <?php if($Plantel){  ?>
                  <div class="box-body">
                    <iframe src="assets/docs/adjunto/<?php echo $Anio; ?>/<?php echo $Plantel; ?>" width="100%" height="400px">
                  </div>
                <?php } ?>


    </form>

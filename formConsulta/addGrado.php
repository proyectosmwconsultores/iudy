<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $IdGrado = $_POST["IdGrado"];

  $sql_g = $db->query("SELECT tblc_nivel_clases.IdGrado, tblc_grado.Descripcion, tblc_grado._Grado FROM tblc_nivel_clases Left Join tblc_grado ON tblc_grado.IdGrado = tblc_nivel_clases.IdGrado WHERE tblc_nivel_clases.IdUsua = '$IdUsua' ORDER BY tblc_nivel_clases.IdGrado DESC");
  $_v="";
  $_d="";
  ?>

  <form name="frm2" class="form-horizontal" id="frm2" action="addGrado.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="_ced" name="_ced" value="0" type="hidden"/>
    <input id="_tit" name="_tit" value="0" type="hidden"/>

              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Grado de estudio:</label>

                  <div class="col-sm-9">
                    <select class="form-control" name="txt_grado" id="txt_grado" onchange="sel_grado(<?php echo $IdUsua; ?>)">
                      <option value=""> - Seleccione - </option>
                      <?php while($gra = $db->recorrer($sql_g)){ ?>
                      <option value="<?php echo $gra['IdGrado']; ?>" <?php if($gra['IdGrado'] == $IdGrado){ $_v = $gra['_Grado']; $_d = $gra['Descripcion'];  ?>selected="selected"<?php } ?>><?php echo $gra['_Grado']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <?php if($IdGrado){ ?>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Nombre:</label>
                  <div class="col-sm-9">
                    <input class="form-control" id="txt_nombre" name="txt_nombre" type="text">
                    <p class="help-block" style="color: blue;"><b style="color: red;">EJEMPLO:</b> <?php echo $_v; ?> EN SISTEMAS COMPUTACIONALES</p>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><div class="checkbox"><input onclick="sav_chk_titulo()" type="checkbox" name="chk_titulo" id="chk_titulo"> EN PROCESO</div></label>
                  <label class="col-sm-3 control-label">Título <?php echo $_d; ?>:</label>
                  <div class="col-sm-6">
                    <input class="form-control" id="txt_titulo" name="txt_titulo" type="file" onchange="validar_titulo_file(this)">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><div class="checkbox"><input onclick="sav_chk_cedula()" type="checkbox" name="chk_cedula" id="chk_cedula"> EN PROCESO</div></label>
                  <label class="col-sm-3 control-label">Cédula <?php echo $_d; ?>:</label>
                  <div class="col-sm-6">
                    <input class="form-control" id="txt_cedula" name="txt_cedula" type="file" onchange="validar_cedula_file(this)">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-8 control-label">Número Cédula Profesional <?php echo $_d; ?>:</label>
                  <div class="col-sm-4">
                    <input class="form-control" id="txt_nocedula" name="txt_nocedula" type="text">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" onClick="save_mi_grado()" class="btn btn-info pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
              </div>
              <?php } ?>
  </form>

<script>
  function sel_grado(IdUsua){
    var IdGrado = document.getElementById("txt_grado").value;
    $.ajax({
         url:"formConsulta/addGrado.php",
         method:"POST",
         data:{IdUsua:IdUsua, IdGrado:IdGrado},
         success:function(data){
              $('#employee_grad').html(data);
              $('#data_grad').modal('show');
         }
    });
  }

  function sav_chk_titulo(){
    var Titulo = document.getElementById("chk_titulo").checked;
    if(Titulo == true){
      document.getElementById('txt_titulo').disabled = true;
      document.getElementById("_tit").value=1;
    } else {
      document.getElementById('txt_titulo').disabled = false;
      document.getElementById("_tit").value=0;
    }
  }

  function sav_chk_cedula(){
    var Titulo = document.getElementById("chk_cedula").checked;
    if(Titulo == true){
      document.getElementById('txt_cedula').disabled = true;
      document.getElementById("_ced").value=1;
    } else {
      document.getElementById('txt_cedula').disabled = false;
      document.getElementById("_ced").value=0;
    }
  }

  function validar_titulo_file(obj){
    var dispox = 0;
      var uploadFile = obj.files[0];
      if (!window.FileReader) { dispox = 1;
      	swal("Error", "EL NAVEGADOR NO SOPORTA LA LECTURA DE ARCHIVOS", "error");
          return;
      }

      if (!(/\.(jpg|png|pdf)$/i).test(uploadFile.name)) { dispox = 1;
      	swal("Error al subir", "Porfavor, cargue solamente archivo  .pdf / .png / .jpg", "error");
          document.getElementById("txt_titulo").value='';
          document.getElementById("txt_titulo").focus();
      }
      else {
          var img = new Image();
          if (uploadFile.size > 5000000)
          { dispox = 1;
          	swal("Error al subir", "El peso del archivo debe ser menor a 5 MB", "error");
              document.getElementById("txt_titulo").value='';
              document.getElementById("txt_titulo").focus();
          }

      }
      if(dispox ==0){
        document.getElementById("chk_titulo").disabled = true;
        document.getElementById("_tit").value=2;
      }
  }

  function validar_cedula_file(obj){
    var dispo = 0;
      var uploadFile = obj.files[0];
      if (!window.FileReader) { dispo = 1;
      	swal("Error", "EL NAVEGADOR NO SOPORTA LA LECTURA DE ARCHIVOS", "error");
          return;
      }

      if (!(/\.(jpg|png|pdf)$/i).test(uploadFile.name)) { dispo = 1;
      	swal("Error al subir", "Porfavor, cargue solamente archivo  .pdf / .png / .jpg", "error");
          document.getElementById("txt_cedula").value='';
          document.getElementById("txt_cedula").focus();
      }
      else {
          var img = new Image();
          if (uploadFile.size > 5000000)
          { dispo = 1;
          	swal("Error al subir", "El peso del archivo debe ser menor a 5 MB", "error");
              document.getElementById("txt_cedula").value='';
              document.getElementById("txt_cedula").focus();
          }

      }
      if(dispo ==0){
        document.getElementById("chk_cedula").disabled = true;
        document.getElementById("_ced").value=2;
      }
  }


  function save_mi_grado(){
    var Grado = document.getElementById("txt_grado").value;
    var Nombre = document.getElementById("txt_nombre").value;
    var IdUsua = document.getElementById("IdUsua").value;
    var Titulo = document.getElementById("_tit").value;
    var Cedula = document.getElementById("_ced").value;
    var NoCedula = document.getElementById("txt_nocedula").value;
    var Imagen1 = '#txt_titulo';
    var Imagen2 = '#txt_cedula';

  	if (Grado ==''){
  			swal("Error al guardar", "Debe seleccionar el grado de estudio.", "error");
  			document.getElementById("txt_grado").focus();
  			return 0;
  	}
    if (Nombre ==''){
  			swal("Error al guardar", "Debe escribir el nombre del grado de estudio.", "error");
  			document.getElementById("txt_nombre").focus();
  			return 0;
  	}
    if (Titulo ==0){
  			swal("Error al guardar", "Debe seleccionar el archivo del título de grado y/o marcar en proceso.", "error");
  			return 0;
  	}
    if (Cedula ==0){
  			swal("Error al guardar", "Debe seleccionar el archivo dela cédula de grado y/o marcar en proceso.", "error");
  			return 0;
  	}

    swal({
    title: "\u00BFEst\u00E1 seguro que desea guardar estos cambios de su grado de estudio?",
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
      var files2 = $(Imagen2)[0].files[0];
      formData.append('Grado',Grado);
      formData.append('Nombre',Nombre);
      formData.append('IdUsua',IdUsua);
      formData.append('Titulo',Titulo);
      formData.append('Cedula',Cedula);
      formData.append('NoCedula',NoCedula);

      formData.append('file1',files1);
      formData.append('file2',files2);

      $.ajax({
          url: 'upload_grado_file.php',
          type: 'post',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) { //alert(response);
            // $.ajax({
        		// 		 url:"view/actividades/evidenciaActividad.php",
        		// 		 method:"POST",
        		// 		 data:{IdActividad:IdActividad, dispo: dispo},
        		// 		 success:function(data){
        		// 					$('#employee_detailE').html(data);
        		// 					$('#dataModalE').modal('show');
        		// 		 }
        		// });

          }
      })
      .done(function(response) {
        if(response==1){
          datos_docente(IdUsua);
          // var Ocultar_evid = "evi_"+IdActividad; //var Ocultar_repro = "rep_"+IdActividad;
        // document.getElementById(Ocultar_evid).style.display = "none";
          // document.getElementById(Ocultar_repro).style.display = "none";
          swal("Guardado correctamente", "Los datos capturados se han guardado correctamente.", "success");
          var IdGrado = 0;
          $.ajax({
               url:"formConsulta/addGrado.php",
               method:"POST",
               data:{IdUsua:IdUsua, IdGrado:IdGrado},
               success:function(data){
                    $('#employee_grad').html(data);
                    $('#data_grad').modal('show');
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

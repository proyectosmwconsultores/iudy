<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdPregunta = $_POST["IdPregunta"];
  $IdActividadDoc = $_POST["IdActividadDoc"];

  $sql8 = $db->query("SELECT * FROM tblp_exampregunta WHERE tblp_exampregunta.IdPregunta = '$IdPregunta'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $tipoExa = $datos81["Tipo"];
  $imagen = $datos81["Imagen"];
  $sql = $db->query("SELECT * FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdPregunta = '$IdPregunta'");
  ?>
  <div class="box box-warning">
<div class="box-header with-border">
<h3 class="box-title"><?php echo $datos81["Pregunta"]; ?></h3>
</div>
  <form role="form">
  <div class="box-body">
      <div class="form-group">
      <label>Respuesta:</label>
      <textarea name="txt_respuesta" id="txt_respuesta" class="form-control" rows="3" placeholder="Enter ..."></textarea>
      </div>
    </div>
      <div class="box-footer">
      <button onclick="save_resp_exa_id(<?php echo $IdPregunta; ?>,<?php echo $IdActividadDoc; ?>)" type="button" class="btn btn-info pull-right"><i class="fa fa-save"></i> Guardar respuesta</button>
      </div>
  </form>
</div>
</div>
  <table class="table table-striped">
               <tbody><tr>
                 <th></th>
                 <th>Respuesta</th>
                 <th>Correcta</th>
                 <th>Eliminar</th>

               </tr>
               <?php $c = 0;  while($x = $db->recorrer($sql)){  ?>
               <tr>
                 <td style="width: 10px;"><b><?php echo $c = ($c + 1);?>.- </b></td>
                 <td><?php echo $x["Respuesta"]; ?></td>
                 <td>
                   <?php if($x["Valor"] == 1){ ?>
                   <button style="margin-left: 5px;" onclick="marcar_repuest(<?php echo $x["IdRespuesta"]; ?>,<?php echo $IdPregunta; ?>,<?php echo $IdActividadDoc; ?>,0)" type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>
                 <?php  } else { ?>
                   <button style="margin-left: 5px;" onclick="marcar_repuest(<?php echo $x["IdRespuesta"]; ?>,<?php echo $IdPregunta; ?>,<?php echo $IdActividadDoc; ?>,1)" type="button" class="btn btn-warning"><i class="fa fa-times-circle"></i></button>
                 <?php } ?>
                 </td>
                 <td>
                   <button style="margin-left: 5px;" onclick="del_repuesta_id(<?php echo $x["IdRespuesta"]; ?>,<?php echo $IdPregunta; ?>,<?php echo $IdActividadDoc; ?>)" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                 </td>
               </tr>
             <?php }  ?>
             </tbody></table>
<script>
  function save_resp_exa_id(IdPregunta,IdActividadDoc){
    var TipoGuardar = "sav_resp_ex_id";
    var Respuesta = document.getElementById("txt_respuesta").value;
    if (Respuesta==""){
        swal("Error al guardar", "Debe escribir la respuesta de la pregunta.", "error");
        document.getElementById("txt_respuesta").focus();
        return 0;
    }
    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar esta pregunta de la evaluación?",
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
              data:{TipoGuardar:TipoGuardar,IdPregunta:IdPregunta, Respuesta:Respuesta},
              success:function(data){

              }
         })
        .done(function(data) {
          if(data==1){
            swal("Guardado correctamente", "La respuesta se ha guardado correctamente.", "success");
            $.ajax({
      	         url:"formConsulta/addExamen.php",
      	         method:"POST",
      	         data:{IdPregunta:IdPregunta,IdActividadDoc:IdActividadDoc},
      	         success:function(data){
      	              $('#employee_detailPreg').html(data);
      	              $('#dataModalPreg').modal('show');
      	         }
      	    });
          }
          if(data==0){
            swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
          }
        })
        .error(function(data) {
          swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
        });
      }

    });
  }

  function marcar_repuest(IdRespuesta, IdPregunta, IdActividadDoc, Valor){

      var TipoGuardar = "sav_resp_val_id";

      swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar esta configuración?",
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
                data:{TipoGuardar:TipoGuardar,IdRespuesta:IdRespuesta, Valor:Valor, IdPregunta:IdPregunta},
                success:function(data){

                }
           })
          .done(function(data) {
            if(data==1){
              swal("Actualizado correctamente", "Los datos se han guardado correctamente.", "success");
              lista_pregunta_id(IdActividadDoc);
              $.ajax({
        	         url:"formConsulta/addExamen.php",
        	         method:"POST",
        	         data:{IdPregunta:IdPregunta,IdActividadDoc:IdActividadDoc},
        	         success:function(data){
        	              $('#employee_detailPreg').html(data);
        	              $('#dataModalPreg').modal('show');
        	         }
        	    });
            }
            if(data==0){
              swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
            }
          })
          .error(function(data) {
            swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
          });
        }

      });
  }


  function del_repuesta_id(IdRespuesta, IdPregunta, IdActividadDoc){
      var TipoGuardar = "del_resp_val_id";
      swal({
        title: "\u00BFEst\u00E1 seguro que desea eliminar esta respuesta?",
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
                data:{TipoGuardar:TipoGuardar,IdRespuesta:IdRespuesta, IdPregunta:IdPregunta},
                success:function(data){

                }
           })
          .done(function(data) {
            if(data==1){
              swal("Eliminado correctamente", "La respuesta se ha eliminado correctamente.", "success");
              lista_pregunta_id(IdActividadDoc);
              $.ajax({
        	         url:"formConsulta/addExamen.php",
        	         method:"POST",
        	         data:{IdPregunta:IdPregunta,IdActividadDoc:IdActividadDoc},
        	         success:function(data){
        	              $('#employee_detailPreg').html(data);
        	              $('#dataModalPreg').modal('show');
        	         }
        	    });
            }
            if(data==0){
              swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
            }
          })
          .error(function(data) {
            swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
          });
        }

      });
  }


</script>

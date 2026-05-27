<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdDocumento = $_POST['IdDocumento'];
  $sql_concep = $db->query("SELECT *  FROM tblp_docs_solicitados WHERE tblp_docs_solicitados.IdDocumento =  '$IdDocumento' ");
  $db->rows($sql_concep);
  $datos71 = $db->recorrer($sql_concep);
  $IdUsua = $datos71["IdUsua"];


  $sql_cicx = $db->query("SELECT
  tblc_usuario.IdUsua,
  tblp_grupo.IdCicloIni,
  tblc_ciclo.Tipo
  FROM
  tblc_usuario
  Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
  Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_grupo.IdCicloIni
  WHERE
  tblc_usuario.IdUsua =  '$IdUsua'
   ");
  $db->rows($sql_cicx);
  $cicx = $db->recorrer($sql_cicx);
  $anio = date("Y");

  $sql_ci = $db->query("SELECT *  FROM tblc_ciclo WHERE tblc_ciclo.Anio <= '$anio' AND  tblc_ciclo.Tipo =  '".$cicx["Tipo"]."' ORDER BY  tblc_ciclo.FInicio DESC LIMIT 4");


  ?>

  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-8">
            <div class="form-group">
              <label>PERIODO ESCOLAR:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <select class="form-control" name="txt_ciclo" id="txt_ciclo">
                <?php $c = 0; while($x = $db->recorrer($sql_ci)){ ?>
                  <option value="<?php echo $x['IdCiclo']; ?>" <?php if($datos71["IdCiclo"]==$x["IdCiclo"]){?>selected="selected"<?php }?>><?php echo $x['Ciclo']; ?></option>
                <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>GRADO:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <select class="form-control" name="txt_grado" id="txt_grado">
                  <option value="1" <?php if($datos71["Grado"]==1){?>selected="selected"<?php }?>>1°</option>
                  <option value="2" <?php if($datos71["Grado"]==2){?>selected="selected"<?php }?>>2°</option>
                  <option value="3" <?php if($datos71["Grado"]==3){?>selected="selected"<?php }?>>3°</option>
                  <option value="4" <?php if($datos71["Grado"]==4){?>selected="selected"<?php }?>>4°</option>
                  <option value="5" <?php if($datos71["Grado"]==5){?>selected="selected"<?php }?>>5°</option>
                  <option value="6" <?php if($datos71["Grado"]==6){?>selected="selected"<?php }?>>6°</option>
                  <option value="7" <?php if($datos71["Grado"]==7){?>selected="selected"<?php }?>>7°</option>
                  <option value="8" <?php if($datos71["Grado"]==8){?>selected="selected"<?php }?>>8°</option>
                  <option value="9" <?php if($datos71["Grado"]==9){?>selected="selected"<?php }?>>9°</option>
                  <option value="10" <?php if($datos71["Grado"]==10){?>selected="selected"<?php }?>>10°</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>TIPO DE CONSTANCIA:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <select class="form-control" name="txt_tipo_constancia" id="txt_tipo_constancia">
                  <option value="1" <?php if($datos71["IdVisto"]==1){?>selected="selected"<?php }?>> SIMPLE</option>
                  <option value="2" <?php if($datos71["IdVisto"]==2){?>selected="selected"<?php }?>> CON CALIFICACIONES</option>
                </select>
              </div>
            </div>
          </div>
          <!--
          <div class="col-md-6">
            <div class="form-group">
              <label>IMPRESIÓN:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <select class="form-control" name="txt_tipo_impresion" id="txt_tipo_impresion">
                    <option value="1" <?php if($datos71["IdVisto"]==1){?>selected="selected"<?php }?>> COMPLETO Y MATERIAS ACTIVAS</option>
                    <option value="2" <?php if($datos71["IdVisto"]==2){?>selected="selected"<?php }?>> COMPLETO</option>
                    <option value="3" <?php if($datos71["IdVisto"]==3){?>selected="selected"<?php }?>> SOLO EL GRADO ACTUAL </option>
                </select>
              </div>
            </div>
          </div>-->
          <div class="col-md-6">
            <div class="form-group">
              <label>&nbsp;</label>
              <div class="input-group">
                <button type="button" class="btn btn-primary pull-right" onClick="generar_consta_id(<?php echo $IdDocumento; ?>)"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </table>
  </div>

  </form>
<script>

  function generar_consta_id(IdDocumento){
    var IdCiclo = document.getElementById("txt_ciclo").value;
    var Grado = document.getElementById("txt_grado").value;
    var IdVisto = document.getElementById("txt_tipo_constancia").value;

      var TipoGuardar = "generar_consta_idx";
      swal({
        title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de esta constancia?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function (isConfirm) {
        if(isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
               url:"formConsulta/setting.php",
               method:"POST",
               data:{TipoGuardar:TipoGuardar, IdDocumento:IdDocumento, IdCiclo:IdCiclo, Grado:Grado, IdVisto:IdVisto},
               success:function(data){

               }
          })
          .done(function(data) {

            if(data==0){
              swal("Error al guardar", "Ha ocurrido un error, no se puede generar la constancia.", "error");
    				} else {
              swal("Actualizado correctamente", "Los datos de la constancia se han actualizado correctamente. ", "success");

              $.ajax({
                url:"formConsulta/validar_pago_solicitud.php",
                method:"POST",
                data:{IdDocumento:IdDocumento},
                success:function(data){
                      $('#employee_detailC').html(data);
                      $('#dataModalC').modal('show');
                }
            });
            }
    			})
          .error(function(data) {
    				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
    			});

        }
      });
  }

</script>

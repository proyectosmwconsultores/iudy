<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdTipoEvaluacion = $_POST['IdTipoEvaluacion'];
  $IdCampus = $_POST['IdCampus'];
  $_IdUsua = $_SESSION['IdUsua'];
  $sql_campus = $db->query("SELECT tblp_coordinador.IdCampus, tblc_campus.Campus FROM tblp_coordinador Left Join tblc_campus ON tblc_campus.IdCampus = tblp_coordinador.IdCampus WHERE tblp_coordinador.IdUsua =  '$_IdUsua' GROUP BY tblp_coordinador.IdCampus");
  $sql_oferta = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre, tblp_educativa.IdGrado, tblc_grado.Descripcion FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa ORDER BY tblp_educativa.IdGrado ASC, tblp_educativa.Nombre ASC ");

  ?>
  <form name="frm2" id="frm2" action="addBanco.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">

        <div class="col-md-12">
          <div class="form-group">
            <label>Campus:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-black-tie"></i>
              </div>
              <select class="form-control" name="txt_campus" id="txt_campus" onchange="sel_campus_x(<?php echo $IdTipoEvaluacion; ?>)">
                <option value="">- Seleccione campus - </option>
                <?php while($_campus = $db->recorrer($sql_campus)){ ?>
                <option value="<?php echo $_campus['IdCampus']; ?>" <?php if($IdCampus==$_campus['IdCampus']){ ?>selected="selected"<?php } ?>><?php echo $_campus['Campus']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>


        <div class="col-md-12">
          <table class="table table-striped">
                <tbody>
                <?php $g_i = 0; $g_f = 0;
                while($_oferta = $db->recorrer($sql_oferta)){ $g_i = $_oferta['IdGrado'];
                  $sql9 = $db->query("SELECT tblc_tipoevaluacion_setting.IdSetting FROM tblc_tipoevaluacion_setting WHERE tblc_tipoevaluacion_setting.IdTipoEvaluacion = '$IdTipoEvaluacion' AND tblc_tipoevaluacion_setting.IdCampus = '$IdCampus' AND tblc_tipoevaluacion_setting.IdOferta = '".$_oferta["IdEducativa"]."'");
                  $db->rows($sql9);
                  $datos91 = $db->recorrer($sql9);
                  $_idS = $datos91['IdSetting'];

                  if($g_i <> $g_f){ ?>
                    <tr style="background: #4c489e; color: white;">
                      <th style="width: 10px">Ajuste</th>
                      <th><?php echo $_oferta['Descripcion']; ?></th>
                    </tr>
                  <?php } ?>
                <tr>
                  <td>
                    <?php if($_idS){ ?>
                      <button onclick="sav_settingx(<?php echo '0,'.$IdTipoEvaluacion.','.$IdCampus.','.$_oferta['IdEducativa']; ?>)" type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>
                    <?php } else { ?>
                      <button onclick="sav_settingx(<?php echo '1,'.$IdTipoEvaluacion.','.$IdCampus.','.$_oferta['IdEducativa']; ?>)" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
                    <?php } ?>
                  </td>
                  <td><?php echo $_oferta['Nombre']; ?></td>
                </tr><?php $g_f = $_oferta['IdGrado']; } ?>
              </tbody></table>
        </div>
        </div>
      </div>
    </table>
  </div>

  </form>
<script>
  function sav_settingx(Valor, IdTipoEvaluacion, IdCampus, IdOferta){
    var TipoGuardar = "sav_eva_setting";

    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, Valor:Valor, IdTipoEvaluacion:IdTipoEvaluacion, IdCampus:IdCampus, IdOferta:IdOferta},
         success:function(data){
           $.ajax({
         			 url:"formConsulta/configurar_evaluacion.php",
         			 method:"POST",
         			 data:{IdTipoEvaluacion:IdTipoEvaluacion, IdCampus:IdCampus},
         			 success:function(data){
         						$('#employee_detail5').html(data);
         						$('#dataModal5').modal('show');
         			 }
         	});
         }
    })
  }

  function sel_campus_x(IdTipoEvaluacion){
    var IdCampus = document.getElementById("txt_campus").value;
    $.ajax({
  			 url:"formConsulta/configurar_evaluacion.php",
  			 method:"POST",
  			 data:{IdTipoEvaluacion:IdTipoEvaluacion, IdCampus:IdCampus},
  			 success:function(data){
  						$('#employee_detail5').html(data);
  						$('#dataModal5').modal('show');
  			 }
  	});
  }
</script>

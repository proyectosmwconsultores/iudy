<?php
  session_start();
  include('../hace.php');
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAs = $_POST["IdAsignacion"];
  $IdPlaneacion = $_POST["IdPlaneacion"];


  $sql9 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion =  '$IdAs'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdEstatus = $datos91["IdEstatus"];


  $sql8 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAs' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdGrp = $datos81["IdGrupo"];
  $HraDia = $datos81["HraDia"];
  $HraDoc = $datos81["HraDoc"];

  $sql2 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo =  '$IdGrp'");
  $db->rows($sql2);
  $datos21 = $db->recorrer($sql2);
  $Mod = $datos21["Modalidad"];
  $Dia = $datos21["IdDia"];

  if($Mod == "E"){
    // if(($Dia == 1) || ($Dia == 2)){
        $par = 4;
    // } else {
        // $par = 2;
    // }

  } else {
    $par = 2;
  }

  $sqlxB = $db->query("SELECT
tblp_parcialdocente.IdParcialDocente,
tblp_parcialdocente.NoParcial,
tblp_parcialdocente.Bimestre,
tblp_semanadocente.NoSemana

FROM
tblp_parcialdocente
Left Join tblp_semanadocente ON tblp_semanadocente.IdParcialDocente = tblp_parcialdocente.IdParcialDocente
WHERE
tblp_parcialdocente.IdAsignacion =  '$IdAs' GROUP BY
tblp_semanadocente.IdSemanaDocente ORDER BY tblp_parcialdocente.NoParcial ASC");

  ?>
  <form name="frm2" id="frm2" action="envioPlaneacion.php" method="POST" enctype="multipart/form-data">
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAs; ?>" type="hidden"/>
    <input id="IdPlaneacion" name="IdPlaneacion" value="<?php echo $IdPlaneacion; ?>" type="hidden"/>
    <input id="Tipo" name="Tipo" value="<?php echo $_POST["Tipo"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_POST["IdUsua"]; ?>" type="hidden"/>


          <?php if($_POST["Tipo"] == "A"){ ?>
            <div class="col-md-12">
              <div class="form-group">
                <table class="table table-striped">
                    <tbody>
                      <tr>
                        <th colspan="4">Informaci&oacute;n general de la Planeaci&oacute;n</th>
                      </tr>
                      <tr>
                        <th>Parcial</th>
                        <th>Unidad</th>

                      </tr>
                    <?php $ac = 0; $noP2 = 0;  while($xB = $db->recorrer($sqlxB)){
                      $noP1 = $xB["NoParcial"];

                       ?>
                    <tr>
                      <td><?php if($noP1 != $noP2){  echo "Parcial ".$xB["NoParcial"]; } else { echo ""; } ?>  </td>

                      <td><?php if($xB["NoSemana"]) { echo "<i class='fa fa-fw fa-check-circle'></i> Unidad ".$xB["NoSemana"]; } else { $ac = 1; echo "<i class='fa fa-fw fa-times-circle'></i> Unidad"; } ?></td>

                    </tr>
                    <?php $noP2 = $xB["NoParcial"]; } ?>
                  </tbody></table>
              </div>
            </div>

        <?php } else { ?>
          <div class="col-md-12">
            <?php $Cxa = 1; if(!$HraDia){ $Cxa = 0;  ?>
            <div style="padding: 10px;" class="bg-green disabled color-palette"><span><b>Alerta:</b> Favor agregar el horario de clases de esta asignatura. De lo contrario no podr&aacute; aprobar esta Planeaci&oacute;n.</span></div>

            <br><br><?php } ?>
            <?php $Cxa = 1; if(!$HraDoc){ $Cxa = 0;  ?>
            <div style="padding: 10px;" class="bg-green disabled color-palette"><span><b>Alerta:</b> Favor agregar horario Docente / Independiente asignatura. De lo contrario no podr&aacute; aprobar esta Planeaci&oacute;n.</span></div>

            <br><br><?php } ?>
            <div class="form-group">
              <label>Seleccione estatus:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-check"></i>
                </div>
                <select class="form-control" name="txtIdEstatus" id="txtIdEstatus">
                  <option> - Seleccione -</option>
                  <option value="25" <?php if($IdEstatus==25){?>selected="selected"<?php } ?>>De regreso a revisi&oacute;n</option>
                  <option value="4" <?php if($IdEstatus==4){?>selected="selected"<?php } ?>>Aprobado</option>
                </select>
              </div>
            </div>
          </div>

        <?php } ?>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i>  Cancelar</button>
          <?php if(($_POST["Tipo"] == "A") && ($ac == 0) && ($noP2 == $par)){ ?>
          <button type="button" class="btn btn-primary pull-right" onClick="enviarRevision(<?php echo $_POST["IdUsua"] ?>)"> <i class="fa fa-fw fa-paper-plane"></i> Enviar planeaci&oacute;n para revisi&oacute;n</button>
        <?php } else { ?>
          <!-- <button type="button" class="btn btn-danger"><i class="fa fa-fw fa-info-circle"></i> Planeaci&oacute;n incompleta</button> -->
        <?php } ?>
          <?php  if(($_POST["Tipo"] == "C") && ($Cxa == 1)){ ?>
          <button type="button" class="btn btn-primary" onclick="saveCambios(<?php echo $_POST["IdUsua"] ?>)"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        <?php } ?>
        </div>



  </form>

  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker-->
  <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script>

function saveBimestre(Valor, IdParcialDoc){
  var numero = Valor.value;


  var IdUsua = document.getElementById("IdUsua").value;
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var Tipo = document.getElementById("Tipo").value;
  var TipoGuardar = "savBimestre";
  swal({
    title: "\u00BFEst\u00E1 seguro que desea asignar este m\u00F3dulo a este parcial?",
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
           data:{TipoGuardar:TipoGuardar, IdParcialDoc:IdParcialDoc, numero:numero},
           success:function(data){

             $.ajax({
                  url:"formConsulta/envioPlaneacion.php",
                  method:"POST",
                  data:{IdUsua:IdUsua,IdAsignacion:IdAsignacion,Tipo:Tipo},
                  success:function(data){
                       $('#employee_detailenvioPlan').html(data);
                       $('#dataModalenvioPlan').modal('show');
                  }
             });
           }
      })
      .done(function(data) {

        if(data==1){
          swal("Guardado correctamente", "M\u00F3dulo guardado correctamente.", "success");

        }
        if(data==0){
          swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
        }
      })
      .error(function(data) {
        swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
      });
    }
  });


}




$(function () {
  //Date picker
  $('#datepicker1').datepicker({
    autoclose: true
  })
//Date picker
  $('#datepicker2').datepicker({
    autoclose: true
  })

  //bootstrap WYSIHTML5 - text editor
  $('.textarea').wysihtml5()
})
</script>

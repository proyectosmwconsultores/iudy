<?php session_start();
  include('../hace.php');
  require('../php/clases/class.php');
  $t=new Trabajo();
  $IdActividadDoc = $_POST['IdActividadDoc'];
  $preguntasExam=$t->get_pregunt_ex_id($IdActividadDoc);
  $actiEva=$t->get_datosAc($IdActividadDoc);
?>

  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-question-circle"></i> Lista de preguntas de la evaluación</h3>
  </div>

  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-striped" style="font-size: 12px;">
        <thead>
          <tr>
            <th>#</th>
            <th>Tipo</th>
            <th>Pregunta</th>
            <?php if($actiEva[0]['IdEstatus'] == 12){ ?>
            <th style="width: 150px;">Ajuste</th><?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $idEstatus = 8;
          $parx = 0; $d = 0;
          for ($i=0;$i< sizeof($preguntasExam);$i++) {
            if($preguntasExam[$i]["IdEstatus"] == 31){ $idEstatus = 12; }
            $parx = $preguntasExam[$i]["IdParcialDocente"];
            if($preguntasExam[$i]["Tipo"] == 'O'){ $txt_ = 'Múltiple'; } else { $txt_ = 'Abierta'; }
             ?>
          <tr>
            <td><b><?php echo $d= $d + 1; ?>.- </b></td>
            <td><?php echo $txt_; ?></td>
            <td><?php if($preguntasExam[$i]["IdEstatus"] == 31){ echo "<b style='color: red;'><i class='fa fa-fw fa-warning'></i></b>"; } ?> <?php echo $preguntasExam[$i]["Pregunta"]; ?></td>
              <?php if($actiEva[0]['IdEstatus'] == 12){ ?>
            <td>
              <div class="btn-group">
                <button style="margin-left: 5px;" onclick="del_ex_preg_id(<?php echo $preguntasExam[$i]["IdPregunta"]; ?>)" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                <?php if($preguntasExam[$i]["Tipo"] == 'O'){ ?>
                  <button style="margin-left: 5px;" onclick="addRespuesta(<?php echo $preguntasExam[$i]["IdPregunta"]; ?>)" type="button" class="btn btn-info"><i class="fa fa-plus-circle"></i></button>
                <?php } ?>
              </div>
            </td><?php } ?>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <p style="text-align: center;">
        <?php if(($idEstatus == 8) && ($actiEva[0]['IdEstatus'] == 12)){  ?>
        <a onclick="activar_eva_alumnos(<?php echo $IdActividadDoc; ?>,<?php echo $parx; ?>)" class="btn btn-primary" ><i class="fa fa-fw fa-check-circle"></i> Publicar evaluación</a>
        <?php }
        if($idEstatus == 31) { ?>
          <a class="btn btn-danger" ><i class="fa fa-fw fa-times-circle"></i> No disponible para publicar evaluación</a>
        <?php }
        if(($actiEva[0]['IdEstatus'] == 8) || ($actiEva[0]['IdEstatus'] == 26)) { ?>
          <a class="btn btn-success" ><i class="fa fa-fw fa-check-circle"></i> La evaluación ya ha sido publicada correctamente.</a>
        <?php } ?>
      </p>
    </div>
  </div>

<script>
function activar_eva_alumnos(IdActividad,IdParcial){
  var IdAsignacion = document.getElementById("IdAsignacion").value;

  var TipoGuardar = "activar_evaluacion_id";
  swal({
    title: "\u00BFEst\u00E1 seguro que desea publicar esta esta evaluación a sus alumnos?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Aceptar',
    cancelButtonText: "Cancelar",
  },
  function (isConfirm) {
    if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');

      var datos = 'TipoGuardar=' + TipoGuardar + '&IdActividad=' + IdActividad + '&IdParcial=' + IdParcial;
      $.ajax({
        type:"POST",
        url:"insertar.php",
        data:datos,
        success:function(data){

        }
      })
      .done(function(data) {

        if(data==1){
          swal("Publicado correctamente", "La evaluación se ha publicado correctamente.", "success");
          parent.location.href='doAddConfigExamen.php?idToks='+IdAsignacion+'&tok=1656608190'+IdActividad+'&p='+IdParcial;
        }
        if(data==0){
          swal("Error al publicar", "No se puede publicar, verifique sus datos.", "error");
        }
      })
      .error(function(data) {
        swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
      });
    }
  });
}
</script>

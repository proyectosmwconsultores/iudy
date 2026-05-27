<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION['IdUsua'];
  $IdAviso = $_POST["IdAviso"];

  $sql = $db->query("SELECT tblp_coordinador.IdCampus, tblc_campus.Campus FROM tblp_coordinador Left Join tblc_campus ON tblc_campus.IdCampus = tblp_coordinador.IdCampus WHERE tblp_coordinador.IdUsua =  '$IdUsua' GROUP BY tblp_coordinador.IdCampus");

  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>


    <div class="table-responsive">

        <div class="col-md-12">
          <div class="row">

            <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 20px">Ajuste</th>
                  <th>Nombre del campus</th>
                </tr>
                <?php while($x = $db->recorrer($sql)){
                  $IdC = $x["IdCampus"];
                  $sqle3 = $db->query("SELECT tblc_avisoasesor.IdAvisoD FROM tblc_avisoasesor WHERE tblc_avisoasesor.IdCampus = '$IdC' AND tblc_avisoasesor.IdAviso = '$IdAviso'");
                  $db->rows($sqle3);
                  $datose31 = $db->recorrer($sqle3);
                  $IdAvss = $datose31['IdAvisoD'];
                  ?>
                <tr>
                  <td>
                    <?php if($IdAvss){ ?>
                      <button type="button" onclick="actAvAses(<?php echo $IdC; ?>,<?php echo $IdAviso; ?>,0)" class="btn btn-info"><i class="fa fa-times-circle"></i></button>
                    <?php } else { ?>
                      <button type="button" onclick="actAvAses(<?php echo $IdC; ?>,<?php echo $IdAviso; ?>,1)" class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
                    <?php } ?>
                  </td>
                  <td><?php echo $x["Campus"]; ?></td>
                </tr>
                <?php } ?>

              </tbody></table>
        </div><br>
          <div class="form-group">
              <button type="button" class="btn btn-block btn-success" onclick="pubAvisoAses(<?php echo $IdAviso; ?>)"> <i class="fa fa-fw fa-check-circle"></i> Publicar aviso en todos los campus</button>
          </div>
        </div>

  </div>

  </form>


<script>



function pubAvisoAses(IdAviso){
    var TipoGuardar = "savPubAsesor";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea publicar el aviso en todos estos campus?",
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
             data:{TipoGuardar:TipoGuardar, IdAviso:IdAviso},
             success:function(data){
               $.ajax({
             			 url:"formConsulta/avisoAsesor.php",
             			 method:"POST",
             			 data:{IdAviso:IdAviso},
             			 success:function(data){
             						$('#employee_Grp').html(data);
             						$('#dataGrp').modal('show');
             			 }
             	});

             }
        })
      }
    });

}

function actAvAses(IdCampus,IdAviso,Valor){
  var TipoGuardar = "savGrupoAss";

  $.ajax({
       url:"formConsulta/setting.php",
       method:"POST",
       data:{TipoGuardar:TipoGuardar, IdCampus:IdCampus, IdAviso:IdAviso, Valor:Valor},
       success:function(data){
         $.ajax({
             url:"formConsulta/avisoAsesor.php",
             method:"POST",
             data:{IdAviso:IdAviso},
             success:function(data){
                  $('#employee_Grp').html(data);
                  $('#dataGrp').modal('show');
             }
        });
       }
  })
}

</script>

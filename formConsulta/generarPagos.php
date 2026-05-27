<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdCalendario = $_POST["IdCalendario"];
  $IdConceptoPlan = $_POST["IdConceptoPlan"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdCampus = $_POST["IdCampus"];
$sql1 = $db->query("SELECT tblc_campus.IdCampus, tblc_campus.Campus FROM tblc_campus");

//   $sql2 = $db->query("SELECT
// tblc_conceptosdetalle.IdConceptoDetalle,
// tblc_conceptosdetalle.IdConceptoPlan,
// tblc_conceptosdetalle.IdOferta,
// tblc_conceptosdetalle.IdConcepto,
// tblp_grupo.IdCampus,
// tblp_grupo.IdGrupo,
// tblp_grupo.CveGrupo,
// tblc_campus.Campus
// FROM
// tblc_conceptosdetalle
// Left Join tblp_grupo ON tblp_grupo.IdOferta = tblc_conceptosdetalle.IdOferta
// Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
// WHERE
// tblc_conceptosdetalle.IdConceptoPlan =  '$IdConceptoPlan' AND tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.IdEstatus = '8' AND tblp_grupo.IdCicloIni <> '$IdCiclo'
// ORDER BY
// tblp_grupo.IdCampus ASC,
// tblp_grupo.CveGrupo ASC
// ");

$sql2 = $db->query("SELECT
tblc_ciclogrupo.IdCicloGrupo,
tblp_grupo.CveGrupo,
tblc_ciclogrupo.FecCap,
tblc_conceptosdetalle.IdConceptoDetalle,
tblc_campus.Campus,
tblp_grupo.IdOferta,
tblc_conceptosdetalle.IdConcepto,
tblp_grupo.IdGrupo,
tblp_grupo.IdCampus,
tblc_ciclogrupo.Grado
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_conceptosdetalle ON tblp_grupo.IdOferta = tblc_conceptosdetalle.IdOferta
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
WHERE
tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND
tblp_grupo.IdEstatus =  '8' AND
tblc_conceptosdetalle.IdConceptoPlan =  '$IdConceptoPlan' AND
tblp_grupo.IdCampus =  '$IdCampus'
");

  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
    <input id="IdCiclo" name="IdCiclo" value="<?php echo $IdCiclo; ?>" type="hidden"/>
    <input id="IdCampus" name="IdCampus" value="<?php echo $IdCampus; ?>" type="hidden"/>


    <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none; margin-top: -5px;">
        <div class="col-md-12">
          <div class="form-group">
            <label>Campus:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <select class="form-control select2" name="txtCampus" id="txtCampus" onchange="cambioCampus(<?php echo $IdCalendario; ?>,<?php echo $IdConceptoPlan; ?>,<?php echo $IdCiclo; ?>)" style="width: 100%;">
                <option value=""> - Seleccione - </option>
                <?php while($y2 = $db->recorrer($sql1)){ ?>
                <option class="form-control"  value="<?php echo $y2["IdCampus"]; ?>"  <?php if($IdCampus==$y2["IdCampus"]){?>selected="selected"<?php }?>> <?php echo $y2["Campus"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row">
            <?php $dix = 0;  $ini = 0; $fin = 0; while($x2 = $db->recorrer($sql2)){
              $IdGrupo = $x2["IdGrupo"];

              $ini = $x2["IdCampus"];
              $sqle3 = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdGrupo =  '$IdGrupo' AND tblp_pagos.IdConceptoPlan =  '$IdConceptoPlan' AND tblp_pagos.IdCalendario =  '$IdCalendario' GROUP BY tblp_pagos.IdCalendario");
              $db->rows($sqle3);
              $datose31 = $db->recorrer($sqle3);
              $IdAvss = $datose31['IdPago'];
               ?>
            <?php if($ini <> $fin){ ?>
             <div class="col-sm-12 col-md-12">
               <div class="bg-aqua-active color-palette" style="padding: 10px; ">
                   <?php echo $x2["Campus"]; ?>
               </div>
             </div>
           <?php } ?>
            <div class="col-sm-4 col-md-4">
              <div class="color-palette-set" style="padding: 10px; ">
                <?php if($IdAvss){ $dix = 1; ?>
                  <button type="button" onclick="genPagoGtx(<?php echo $IdGrupo; ?>,<?php echo $IdCalendario; ?>,<?php echo $IdConceptoPlan; ?>,0)" class="btn btn-primary"><i class="fa fa-check-circle"></i></button>
                <?php } else { ?>
                  <button type="button" onclick="genPagoGtx(<?php echo $IdGrupo; ?>,<?php echo $IdCalendario; ?>,<?php echo $IdConceptoPlan; ?>,1)" class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
                <?php } ?>

                <?php echo $x2["Grado"]; ?>° <?php echo $x2["CveGrupo"]; ?>
              </div>
            </div>
          <?php $fin = $x2["IdCampus"]; } ?>
        </div><br>
        <?php if($dix == 0){ ?>
          <div class="form-group">
              <!-- <button type="button" class="btn btn-block btn-success" onclick="pubPago(<?php echo $IdConceptoPlan; ?>,<?php echo $IdCalendario; ?>)"> <i class="fa fa-fw fa-check-circle"></i> Generar pago para todos los grupos</button> -->
          </div><?php } ?>
        </div>


      </div>

    </table>
  </div>

  </form>
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>

<script>
$(function () {

  $('.select2').select2()

})




function cambioCampus(IdCalendario,IdConceptoPlan,IdCiclo){
var IdCampus = document.getElementById("txtCampus").value;
  $.ajax({
      url:"formConsulta/generarPagos.php",
      method:"POST",
      data:{IdCalendario:IdCalendario,IdConceptoPlan:IdConceptoPlan, IdCiclo:IdCiclo, IdCampus:IdCampus},
      success:function(data){
           $('#employee_Grp').html(data);
           $('#dataGrp').modal('show');
      }
 });
}


function genPagoGtx(IdGrupo,IdCalendario,IdConceptoPlan,Valor){
  var IdCiclo = document.getElementById("IdCiclo").value;
  var IdCampus = document.getElementById("IdCampus").value;
  var TipoGuardar = "savGenPagox";

  $.ajax({
       url:"formConsulta/setting.php",
       method:"POST",
       data:{TipoGuardar:TipoGuardar, IdGrupo:IdGrupo, IdCalendario:IdCalendario, IdConceptoPlan:IdConceptoPlan, Valor:Valor, IdCiclo:IdCiclo},
       success:function(data){
           
         if(data == 3){
           swal("Error al generar", "No se puede generar el pago del grupo, ya que no existe el plan de pago según el periodo escolar en la que inicio el grupo.", "error");
           return 0;
         } else {
           $.ajax({
       				 url:"formConsulta/generarPagos.php",
       				 method:"POST",
       				 data:{IdCalendario:IdCalendario,IdConceptoPlan:IdConceptoPlan, IdCiclo:IdCiclo, IdCampus:IdCampus},
       				 success:function(data){
                 swal("Ejecutado correctamente", "Se ha realizado el proceso correctamente.", "success");
       							$('#employee_Grp').html(data);
       							$('#dataGrp').modal('show');
       				 }
       		});
         }

       }
  })
}

function pubPago(IdConceptoPlan, IdCalendario){
  var IdCiclo = document.getElementById("IdCiclo").value;
  var IdCampus = document.getElementById("IdCampus").value;


    if (IdCampus ==""){
        swal("Error al guardar", "Debe seleccionar el campus.", "error");
        return 0;
    }

    var TipoGuardar = "pubPagosG";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea generar los pagos a todos estos grupos?",
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
             data:{TipoGuardar:TipoGuardar, IdConceptoPlan:IdConceptoPlan, IdCalendario:IdCalendario, IdCiclo:IdCiclo, IdCampus:IdCampus},
             success:function(data){
               $.ajax({
           				 url:"formConsulta/generarPagos.php",
           				 method:"POST",
           				 data:{IdCalendario:IdCalendario,IdConceptoPlan:IdConceptoPlan, IdCiclo:IdCiclo, IdCampus:IdCampus},
           				 success:function(data){
                     swal("Guardado correctamente", "Se ha ejecutado correctamente la consulta.", "success");
           							$('#employee_Grp').html(data);
           							$('#dataGrp').modal('show');
           				 }
           		});

             }
        })
      }
    });

}

</script>

<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdDocs = $_POST["IdDocs"];
  $IdCampus = $_POST["IdCampus"];

  $sql1 = $db->query("SELECT * FROM tblc_campus");
  $sql_grp = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_grupo.Grado FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus'");

  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data">

    <div class="table-responsive">
      <div class="col-md-12">
        <div class="form-group">
          <label>Campus:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-user"></i>
            </div>
            <select class="form-control select2" name="txtCampus" id="txtCampus" onchange="cambioCampus(<?php echo $IdDocs; ?>)" style="width: 100%;">
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

            <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 90px">Ajuste</th>
                  <th>Clave de grupo</th>
                </tr>
                <?php while($x = $db->recorrer($sql_grp)){
                  $IdC = $x['IdGrupo'];
                  $sqle3 = $db->query("SELECT tblp_docs_grupo.IdDocsC FROM tblp_docs_grupo WHERE tblp_docs_grupo.IdGrupo = '$IdC' AND tblp_docs_grupo.IdDocs = '$IdDocs'");
                  $db->rows($sqle3);
                  $datose31 = $db->recorrer($sqle3);
                  $IdAvss = $datose31['IdDocsC'];
                  ?>
                <tr>
                  <td>
                    <?php if($IdAvss){ ?>
                      <button type="button" onclick="actAvCampsId(<?php echo $IdCampus; ?>,<?php echo $IdC; ?>,<?php echo $IdDocs; ?>,0)" class="btn btn-info btn-sm"><i class="fa fa-check-circle"></i></button>
                    <?php } else { ?>
                      <button type="button" onclick="actAvCampsId(<?php echo $IdCampus; ?>,<?php echo $IdC; ?>,<?php echo $IdDocs; ?>,1)" class="btn btn-danger btn-sm"><i class="fa fa-times-circle"></i></button>
                    <?php } ?>
                  </td>
                  <td><?php echo $x["Grado"]; ?>° <?php echo $x["CveGrupo"]; ?></td>
                </tr>
                <?php } ?>
              </tbody></table>
        </div>
        </div>

  </div>

  </form>
<script>
function actAvCampsId(IdCampus,IdGrupo,IdDocs,Valor){
  var TipoGuardar = "savCampsIdAss";

  $.ajax({
       url:"formConsulta/setting.php",
       method:"POST",
       data:{TipoGuardar:TipoGuardar, IdGrupo:IdGrupo, IdCampus:IdCampus, IdDocs:IdDocs, Valor:Valor},
       success:function(data){
         $.ajax({
     				 url:"formConsulta/calendarioCampus.php",
     				 method:"POST",
     				 data:{IdDocs:IdDocs, IdCampus:IdCampus},
     				 success:function(data){
     							$('#employee_Grp').html(data);
     							$('#dataGrp').modal('show');
     				 }
     		});
       }
  })
}

function cambioCampus(IdDocs){
  var IdCampus = document.getElementById("txtCampus").value;
    $.ajax({
         url:"formConsulta/calendarioCampus.php",
         method:"POST",
         data:{IdDocs:IdDocs, IdCampus:IdCampus},
         success:function(data){
              $('#employee_Grp').html(data);
              $('#dataGrp').modal('show');
         }
    });
}

</script>

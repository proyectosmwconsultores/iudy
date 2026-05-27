<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdPermiso = $_SESSION['Permisos'];
  $IdUsua = $_SESSION['IdUsua'];
  $IdCampus = $_POST['IdCampus'];
  $IdOferta = $_POST['IdOferta'];
  if($IdPermiso == 2){ $cond1 = " WHERE tblc_campus.id_usua = '$IdUsua'"; } else { $cond1 = ""; }
  if($IdPermiso == 2){ $cond2 = " WHERE tblc_ciclo.id_usua = '$IdUsua'"; } else { $cond2 = ""; }
  if($IdPermiso == 2){ $cond3 = " AND tblp_grupo.id_usua = '$IdUsua'"; } else { $cond3 = ""; }

  $sql_cam = $db->query("SELECT * FROM tblc_campus $cond1");
  $sql_ofe = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_educativa.id_usua =  '$IdUsua' AND tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa");
  $sql_cic = $db->query("SELECT * FROM tblc_ciclo $cond2");
  $sql_grp = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' $cond3");
  $sql_mat = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus' ");

  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="TipoGuardar" name="TipoGuardar" value="savClase" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="col-md-12">
          <div class="form-group">
            <label>Campus/Escuela:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select class="form-control" name="txt_campus" id="txt_campus" onchange="selCampus()">
                <option value=""> - Seleccione - </option>
                <?php while($cam = $db->recorrer($sql_cam)){ ?>
                <option value="<?php echo $cam["IdCampus"]; ?>" <?php if($cam["IdCampus"] == $IdCampus){ ?>selected="selected"<?php } ?> > <?php echo $cam["Campus"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Oferta educativa:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select class="form-control" name="txt_oferta" id="txt_oferta" onchange="selOferta()">
                <option value=""> - Seleccione - </option>
                <?php while($ofe = $db->recorrer($sql_ofe)){ ?>
                <option value="<?php echo $ofe["IdEducativa"]; ?>" <?php if($ofe["IdEducativa"] == $IdOferta){ ?>selected="selected"<?php } ?>> <?php echo $ofe["Nombre"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Materia:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select class="form-control" name="txt_materia" id="txt_materia">
                <option value=""> - Seleccione - </option>
                <?php while($mat = $db->recorrer($sql_mat)){ ?>
                <option value="<?php echo $mat["IdModulo"]; ?>"> <?php echo $mat["NombreMod"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Periodo escolar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select class="form-control" name="txt_ciclo" id="txt_ciclo">
                <option value=""> - Seleccione - </option>
                <?php while($cic = $db->recorrer($sql_cic)){ ?>
                <option value="<?php echo $cic["IdCiclo"]; ?>"> <?php echo $cic["Ciclo"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Grupo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select class="form-control" name="txt_grupo" id="txt_grupo">
                <option value=""> - Seleccione - </option>
                <?php while($grp = $db->recorrer($sql_grp)){ ?>
                <option value="<?php echo $grp["IdGrupo"]; ?>"> <?php echo $grp["CveGrupo"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <?php if($_SESSION['comEst'] == 8){  ?>
        <div class="col-md-12">
          <div class="form-group"><br>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
              <button type="button" class="btn btn-primary pull-right" onClick="savClase()"> <i class="fa fa-fw fa-check-circle"></i> Crear clase</button>
            </div>
          </div>
        </div><?php } ?>




      </div>
    </table>
  </div>
<?php if($_SESSION['comEst'] == 1){ include("msjCompra.php"); } ?>
  </form>

<script>
  function selCampus(){
    var IdCampus = document.getElementById("txt_campus").value;
    var IdOferta = document.getElementById("txt_oferta").value;
    $.ajax({
         url:"formConsulta/addClase.php",
         method:"POST",
         data:{IdCampus:IdCampus,IdOferta:IdOferta},
         success:function(data){
              $('#employee_class').html(data);
              $('#dataClass').modal('show');
         }
    });
  }

  function selOferta(){
    var IdCampus = document.getElementById("txt_campus").value;
    var IdOferta = document.getElementById("txt_oferta").value;
    $.ajax({
         url:"formConsulta/addClase.php",
         method:"POST",
         data:{IdCampus:IdCampus,IdOferta:IdOferta},
         success:function(data){
              $('#employee_class').html(data);
              $('#dataClass').modal('show');
         }
    });
  }
</script>

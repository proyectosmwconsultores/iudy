<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST['IdCiclo'];
  $IdCampus = $_POST['IdCampus'];
  $lst_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdEstatus = '8' ORDER BY tblc_ciclo.Tipo ASC,  tblc_ciclo.FInicio DESC");
  $lst_cam = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus._visible = '1'");
  if(($IdCiclo) && ($IdCampus)){


    $lst_enlz = $db->query("SELECT
    tblc_ciclogrupo.IdCicloGrupo,
    tblc_ciclogrupo.Grado,
    tblc_ciclogrupo.Migrado,
    tblc_ciclo.Tipo,
    tblc_ciclo.Numero,
    tblc_ciclo.Ciclo,
    tblp_grupo.IdGrupo,
    tblp_grupo.CveGrupo,
    tblp_grupo.Nivel,
    tblp_grupo.Grupo,
    tblp_grupo.IdOferta,
    tblp_educativa.Nombre,
    tblp_educativa.IdGrado,
    tblc_grado._Grado,
    tblc_dias_clases._Dias,
    tblc_campus.Campus
    FROM
    tblc_ciclogrupo
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
    Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado
    Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
    Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus WHERE tblc_ciclogrupo.IdCiclo = '$IdCiclo' AND tblp_grupo.IdCampus = '$IdCampus' AND tblc_dias_clases.Tipo = '1' AND tblp_educativa.IdGrado <= '4' ORDER BY tblp_educativa.IdGrado ASC, tblp_educativa.IdEducativa ASC, tblc_ciclogrupo.Grado ASC");

    $sqlx = $db->query("SELECT tblc_ciclo.FInicio, tblc_ciclo.Tipo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
    $db->rows($sqlx);
    $datx = $db->recorrer($sqlx);
    $Tipo = $datx["Tipo"];
    $FInicio = $datx["FInicio"];

    $tipo_ciclo = substr($Tipo,0,1);
    $grp_dis = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_grupo.Grado FROM tblp_grupo WHERE tblp_grupo.IdCampus = '1' AND tblp_grupo.TipoCiclo = 'C' AND tblp_grupo.IdCicloIni <> '1' AND ((tblp_grupo.IdEstatus = '8') || (tblp_grupo.IdEstatus = '12')) ORDER BY tblp_grupo.Grado ASC");

  }

  $sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);
  ?>

  <div class="col-md-6">
    <div class="box-primary">
      <div class="box-body">
      <div class="form-group">
        <label>Periodo escolar:</label>
        <div class="input-group">
          <div class="input-group-addon">
          <i class="fa fa-book"></i></div>
          <select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="sel_ciclo_es(<?php echo $IdCampus; ?>)">
            <option value=""> - Seleccione - </option>
            <?php while($_cic = $db->recorrer($lst_cic)){ ?>
            <option value="<?php echo $_cic["IdCiclo"]; ?>"<?php if($IdCiclo == $_cic["IdCiclo"]){  ?>selected="selected"<?php }?>><?php echo $_cic["Tipo"].' - '.$_cic["Ciclo"]; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box-primary">
      <div class="box-body">
      <div class="form-group">
        <label>Campus:</label>
        <div class="input-group">
          <div class="input-group-addon"> 
          <i class="fa fa-bank"></i></div>
          <select class="form-control select2" name="txtCampus" id="txtCampus" onchange="sel_campus_es(<?php echo $IdCiclo; ?>)">
            <option value=""> - Seleccione - </option>
            <?php while($_camp= $db->recorrer($lst_cam)){ ?>
            <option value="<?php echo $_camp["IdCampus"]; ?>"<?php if($IdCampus == $_camp["IdCampus"]){  ?>selected="selected"<?php }?>><?php echo $_camp["Campus"]; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      </div>
    </div>
  </div>

  <!-- <div class="col-md-6">
    <div class="box-primary">
      <div class="box-body">
      <div class="form-group">
        <label>Grupo:</label>
        <div class="input-group">
          <div class="input-group-addon">
          <i class="fa fa-users"></i>
          </div>
          <select class="form-control select2" name="txtGrupo" id="txtGrupo">
            <option value=""> - Seleccione - </option>
            <?php while($_disp = $db->recorrer($grp_dis)){
              $sq_c = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdCiclo = '$IdCiclo' AND tblc_ciclogrupo.IdGrupo = '".$_disp["IdGrupo"]."'");
              $db->rows($sq_c);
              $_cx = $db->recorrer($sq_c);
              $_idcx = $_cx["IdCicloGrupo"];
              if(!$_idcx){
              ?>
            <option value="<?php echo $_disp["IdGrupo"]; ?>"><?php echo $_disp["Grado"].'° '.$_disp["CveGrupo"]; ?></option>
          <?php } } ?>
          </select>
          <span class="input-group-btn">
            <button type="button" class="btn bg-navy" onClick="enlazar_grpx()"> <i class="fa fa-fw fa-random"></i> Enlazar</button>
          </span>
        </div>
      </div>
      </div>
    </div>
  </div> -->
<?php if(($IdCiclo) && ($IdCampus)){ ?>
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-fw fa-bookmark"></i> Lista de grupos asociados a un Periodo Escolar</h3>
      </div>
      <div class="box-body">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody><tr>
            <!-- <th>AJUSTE</th> -->
            <th></th>
            <th>PERIODO ESCOLAR </th>
            <th style="text-align: center;">GRADO EN EL PERIODO</th>
            <th>GRUPO</th>
            <th>DIA</th>
            <th>CAMPUS</th>
            <th></th>
          </tr>
          <?php $s=0; $ci=0; $cf=0; $oi = 0; $of = 0;
            while($_enlz = $db->recorrer($lst_enlz)){
            $idG = $_enlz["IdGrupo"];
            if($idG){
            $ci = $_enlz["IdGrado"];
            $oi = $_enlz["IdOferta"];
            if($ci <> $cf){ ?>
              <tr style="background: #d8caff;">
                <td colspan="7"><b><?php echo $_enlz["_Grado"]; ?></b></td>
              </tr>
            <?php } 
             if($oi <> $of){ ?>
              <tr style="background: #c0c0c1;">
                <td></td>
                <td colspan="6"><b><i class="fa fa-fw fa-bookmark-o"></i> <?php echo $_enlz["Nombre"]; ?></b></td>
              </tr>
            <?php } ?>
          <tr>
            <!-- <td> -->
              <?php if(($_SESSION["IdUsua"] == 1) || ($_SESSION["IdUsua"] == 2)){ ?>
              <!-- <button title="Eliminar enlace" onclick="delEnlace(<?php echo $_enlz["IdCicloGrupo"]; ?>,<?php echo $_enlz["IdGrupo"]; ?>,<?php echo $IdCiclo; ?>)" type="button" class="btn bg-navy btn-flat btn-sm"><i class="fa fa-trash"></i></button> -->
              <?php } ?>
            <!-- </td> -->
            <td><b><?php echo $s= ($s+1); ?>.- (<?php echo $_enlz["IdGrupo"]; ?>)</b></td>
            <td><?php echo $_enlz["Ciclo"]; ?></td>
            <td style="text-align: center;"><?php echo $_enlz["Grado"]; ?>° </td>
            <td><?php echo $_enlz["CveGrupo"]; ?></td>
            <td><?php echo $_enlz["_Dias"]; ?></td>
            <td><?php echo $_enlz["Campus"]; ?></td>
            <td style="text-align: center;">
            <?php if($_enlz["Migrado"] <> 1){  ?>
            <!-- <button onclick="cargar_lista_alumnos(<?php echo $_enlz["IdGrupo"]; ?>, <?php echo $_enlz["Grado"]; ?>)" type="button" class="btn bg-navy btn-flat"><i class="fa fa-fw fa-check-circle"></i> Migrar</button>  -->
            <?php } ?>
            <?php if($_enlz['Migrado'] == 1){ ?>
              <button onclick="cargar_lista_alumnos(<?php echo $_enlz['IdGrupo']; ?>, <?php echo $_enlz["Grado"]; ?>, 0)" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-fw fa-check-circle"></i> Migrado</button>
            <?php } else { ?>
              <button onclick="cargar_lista_alumnos(<?php echo $_enlz["IdGrupo"]; ?>, <?php echo $_enlz["Grado"]; ?>, 1)" type="button" class="btn bg-navy btn-flat"><i class="fa fa-fw fa-check-circle"></i> Migrar</button>
            <?php  } ?>   

          </td>

          </tr><?php $cf = $_enlz["IdGrado"]; $of = $_enlz["IdOferta"]; } } ?>
        </tbody></table>
      </div>
    </div>
  </div><?php }  ?>

<script>
$(function () {
  //Initialize Select2 Elements
  $('.select2').select2()
})
</script>

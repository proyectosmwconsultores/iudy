<?php
  require('../php/clases/class.php');
  $t=new Trabajo();
  $IdCampus = $_POST['IdCampus'];
  $IdGrupo = $_POST['IdGrupo'];
  include('../hace.php');
  $sql_lista_mat=$t->get_lst_enc_grp($IdCampus,$IdGrupo);
  $sql_grp=$t->get_lst_grp($IdGrupo);
  ?>

  <div class="bg-maroon-active color-palette" style="padding: 8px;"><span style="color: yellow;"><i class="fa fa-fw fa-bookmark"></i> <?php echo $sql_grp[0]["Nombre"].' - '.$sql_grp[0]["_Modalidad"].' - '.$sql_grp[0]["_Dias"]; ?> </span></div>
  <?php $_as = 0; $p_i = 0; $p_f = 0;
  for ($i=0;$i< sizeof($sql_lista_mat);$i++) { $p_i = $sql_lista_mat[$i]["IdCiclo"]; ?>
  <?php if($p_i <> $p_f){ ?>
  <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> PERIODO ESCOLAR: </b></span><?php echo $sql_lista_mat[$i]["Ciclo"]; ?></div>

  <?php } ?>
  <blockquote>
    <small><b style="color: blue;"><?php echo $sql_lista_mat[$i]["Evaluacion"]; ?> del <?php echo $sql_lista_mat[$i]["FecIni"]; ?> al <?php echo $sql_lista_mat[$i]["FecFin"]; ?></b> </small>
    <?php if($sql_lista_mat[$i]["NombreMod"]){ ?><small><?php echo $sql_lista_mat[$i]["NombreMod"]; ?></small><?php } ?>
  </blockquote>

  <div class="box-body">
    <?php
     $_user=$t->get_us_list_enc($IdCampus,$sql_lista_mat[$i]["IdCiclo"],$IdGrupo,$sql_lista_mat[$i]["IdTipo"],$sql_lista_mat[$i]["IdAsignacion"]);
    ?>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th>No.CONTROL</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th style="text-align: center;">FECHA DE REALIZACIÓN</th>
          <th style="text-align: center;">ESTATUS</th>
          <?php if($sql_lista_mat[$i]["Cve"] == 2){ ?>
          <th style="text-align: center;"></th><?php } ?>
        </tr>
        <?php
        for ($x=0;$x< sizeof($_user);$x++) { ?>
        <tr>
          <td><?php echo $_user[$x]['Usuario']; ?></td>
          <td>
            <?php echo $_user[$x]['APaterno'].' '.$_user[$x]['AMaterno'].' '.$_user[$x]['Nombre']; ?>
          </td>
          <td style="text-align: center; "><?php echo $_user[$x]['Ini'].' / '.$_user[$x]['Fin']; ?></td>
          <td style="text-align: center; "><?php echo $_user[$x]['Estatus']; ?></td>
          <td style="text-align: center; ">
            <?php if(($_user[$x]['IdEstatus'] == 10) &&  ($sql_lista_mat[$i]["Cve"] == 2)) { ?>
              <button onclick="window.open('repositorio/portafolio/cedula_pre-egreso.php?idToks=<?php echo time().$_user[$x]['IdUsua']; ?>','_blank')" type="button" class="btn bg-maroon btn-flat" href="javascript:void(0);" title="Generar cédula"><i class="fa fa-fw fa-file-pdf-o"></i></button>
            <?php } ?>
          </td>
        </tr><?php
       } ?>
   </tbody></table>
   <!-- <button style="float: right; "type="button" class="btn bg-orange btn-flat margin view_gra" id="<?php echo $sql_lista_mat[$i]["IdCiclo"].'_'.$IdGrupo; ?>" href="javascript:void(0);" title="Generar gráfica de asistencia"><i class="fa fa-fw fa-trash"></i> Eliminar encuesta</button> -->
   <?php if($sql_lista_mat[$i]["Cve"] == 1){ ?>
     <input type="hidden" value="<?php echo $sql_lista_mat[$i]["IdDocente"]; ?>" name="_<?php echo $sql_lista_mat[$i]["IdAsignacion"]; ?>" id="_<?php echo $sql_lista_mat[$i]["IdAsignacion"]; ?>">
     <button style="float: right; "type="button" class="btn bg-navy btn-flat margin view_enc_docx" id="<?php echo $sql_lista_mat[$i]["IdAsignacion"]; ?>" href="javascript:void(0);" title="Generar gráfica de encuesta"><i class="fa fa-fw fa-bar-chart"></i> Generar gráfica</button>

   <?php } else { ?>
     <button style="float: right; "type="button" class="btn bg-navy btn-flat margin view_enc_all" id="<?php echo $IdCampus.'_'.$sql_lista_mat[$i]["IdCiclo"].'_'.$IdGrupo.'_'.$sql_lista_mat[$i]["IdTipo"].'_'.$sql_lista_mat[$i]['IdEvaluacionX'].'_'.$sql_lista_mat[$i]["IdAsignacion"]; ?>" href="javascript:void(0);" title="Generar gráfica de encuesta"><i class="fa fa-fw fa-bar-chart"></i> Generar gráfica</button>
   <?php } ?>



  </div>
<?php $p_f = $sql_lista_mat[$i]["IdCiclo"]; }  ?>

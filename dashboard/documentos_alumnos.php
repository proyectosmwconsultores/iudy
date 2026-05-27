<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST['IdCiclo'];
  $IdGrupo = $_POST['IdGrupo'];


  $porciones = explode("_", $IdGrupo);
  $Grado =  $porciones[0]; // porción1
  $IdGrupo = $porciones[1]; // porción2

  $sql_lsta = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Grado, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblc_usuario.IdOferta FROM tblc_usuario WHERE tblc_usuario.IdGrupo ='$IdGrupo' ORDER BY tblc_usuario.APaterno ASC");

  $sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);

  $sql_grp = $db->query("SELECT tblp_grupo.TipoCiclo, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_grp);
  $_grp = $db->recorrer($sql_grp);
  if($_grp['TipoCiclo'] == 'C') { $_txG = 'CUATRIMESTRE'; } else { $_txG = 'SEMESTRE'; }

  $sql_docsx = $db->query("SELECT Count(tblh_tipodocumento.IdTipoDoc) AS Total FROM tblh_tipodocumento WHERE tblh_tipodocumento.Grado =  '".$_grp['IdGrado']."' AND tblh_tipodocumento.IdEstatus =  '8' AND tblh_tipodocumento.Tipo =  '1' ");
  $db->rows($sql_docsx);
  $no_docs = $db->recorrer($sql_docsx);



  ?>

  <div class="box-body">
    <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> PERIODO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?></div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr style="background: #a6a6a6;">
          <th></th>
          <th>NO.CONTROL</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>DOCUMENTACIÓN</th>
          <th style="text-align: center;">CONVENIO BECA</th>
          <th style="text-align: center;">FICHA INSCRIPCIÓN</th>
          <th style="text-align: center;">DOCUMENTOS</th>
        </tr>
      <?php $g = 0; while($matx = $db->recorrer($sql_lsta)){
        $_dispx = $matx['IdOferta'];

        if($matx['Grado'] == 3){
          $nombre_file = "ficha_inscripcion_licenciatura";
        } else {
          $nombre_file = "ficha_inscripcion";
        }
        $noaprobado = 0;
        $texto = "INCOMPLETA"; 
        $color = "red"; 

        $sql_aprob = $db->query("SELECT Count(tblp_documentos.IdDocumento) AS Total, tblh_tipodocumento.Nombre FROM tblp_documentos Left Join tblh_tipodocumento ON tblh_tipodocumento.IdTipoDoc = tblp_documentos.IdTipoDocumento WHERE tblp_documentos.IdUsua =  '".$matx['IdUsua']."' AND tblh_tipodocumento.IdEstatus =  '8' AND tblp_documentos.Si =  '1' AND tblh_tipodocumento.Tipo =  '1' GROUP BY tblp_documentos.IdUsua ");
        $db->rows($sql_aprob);
        $aprob = $db->recorrer($sql_aprob);
        if(isset($aprob['Total'])){
          $noaprobado = $aprob['Total'];
        } else {
          $noaprobado = 0;
        }

        if($noaprobado == $no_docs['Total']){
          $texto = "COMPLETO";  $color = "blue"; 
        }
        

         ?>
      <tr>
        <td><b><?php echo $g = ($g + 1); ?>.- </b></td>
        <td><?php echo $matx['Usuario']; ?></td>
        <td><?php echo $matx['APaterno'].' '.$matx['AMaterno'].' '.$matx['Nombre']; ?></td>
        <td style="color: <?php echo $color; ?>"><?php echo $texto; ?> (<?php echo $noaprobado; ?> / <?php  echo $no_docs['Total']; ?>)</td>
        <td style="text-align: center;">
          <?php if(($matx['Grado'] == 1) || ($matx['Grado'] == 2) || ($matx['IdOferta'] == 6)){ ?>
          <button onclick="window.open('repositorio/portafolio/convenio_beca.php?id=<?php echo time().$matx['IdUsua']; ?>&idToks=<?php echo time().$IdCiclo; ?>','_blank')" href="javascript:void(0);" title="Descargar convenio de beca" type="button" class="btn bg-maroon btn-flat btn-xs"><i class="fa fa-fw fa-file-pdf-o"></i> Descargar</button>
        <?php } else { echo "----"; } ?>
        </td>
        <td style="text-align: center;">
          <button onclick="window.open('repositorio/portafolio/<?php echo $nombre_file; ?>.php?id=<?php echo time().$matx['IdUsua']; ?>&idToks=<?php echo time().$IdCiclo; ?>','_blank')" href="javascript:void(0);" title="Descargar convenio de beca" type="button" class="btn bg-maroon btn-flat btn-xs"><i class="fa fa-fw fa-file-pdf-o"></i> Descargar</button>
        </td>
        <td style="text-align: center;">
          <button onclick="configurar_Docs(<?php echo $matx['IdUsua']; ?>)"  href="javascript:void(0);" title="Descargar convenio de beca" type="button" class="btn bg-purple btn-flat btn-xs"><i class="fa fa-fw fa-cog"></i> Configurar</button>
          <?php if($matx['Grado'] == 3){ ?>
          <button onclick="window.open('repositorio/portafolio/documentos_entregados.php?id=<?php echo time().$matx['IdUsua']; ?>&idToks=<?php echo time().$IdCiclo; ?>','_blank')" href="javascript:void(0);" title="Control documentos" type="button" class="btn bg-maroon btn-flat btn-xs"><i class="fa fa-fw fa-file-pdf-o"></i> Documentos</button>
        <?php } ?>
        </td>
      </tr><?php } ?>
    </tbody></table>
  </div>

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

  $sql_lsta = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Correo_institucional, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.Usuario, tblc_usuario.AMaterno, tblc_usuario.Celular, tblc_usuario.Correo, tblc_usuario.IdEstatus, tblc_usuario.Sexo, tblp_educativa.IdGrado, tblc_usuario.IdOferta, tblp_educativa.Nombre AS NomEducativa, tblp_grupo.CveGrupo, tblc_estatus.Estatus, tblp_informacion.P_curp FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua WHERE  tblc_usuario.IdGrupo = '$IdGrupo' ");

  $sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);

  $sql_grp = $db->query("SELECT tblp_grupo.CveGrupo, tblc_modalidad._Modalidad, tblc_dias_clases._Dias, tblp_grupo.TipoCiclo FROM tblp_grupo Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_grp);
  $_grp = $db->recorrer($sql_grp);
  if($_grp['TipoCiclo'] == 'C') { $_txG = 'CUATRIMESTRE'; } else { $_txG = 'SEMESTRE'; }
  ?>

  <div class="box-body">
    <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> PERIODO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?> (<?php echo $_txG; ?> - <?php echo $_grp['_Modalidad'] ?> - <?php echo $_grp['_Dias'] ?>)</div>
    <br>

    <table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;" >
      <thead>
        <tr>
          <th>Matricula</th>
          <th>Nombre</th>
          <th>Celular</th>
          <th>Correo personal</th>
          <th>Correo institucional</th>
          <th>Sexo</th>
          <th>Estatus</th>
          <th>Oferta educativa</th>
          <th>Curp</th>
        </tr>
      </thead>
      <tbody>
        <?php $col = ''; while($matx = $db->recorrer($sql_lsta)){ $col = '';
          if($matx["IdEstatus"] == 8){
            $col = "style='color: black;'";
          } else if($matx["IdEstatus"] == 55){
            $col = "style='color: blue;'";
          } else {
            $col = "style='color: red;'";
          }
           ?>
        <tr <?php echo $col; ?>>
          <td><?php echo $matx["Usuario"]; ?></td>
          <td><?php echo $matx["APaterno"].' '.$matx["AMaterno"].' '.$matx["Nombre"]; ?></td>
          <td><?php echo $matx["Celular"]; ?></td>
          <td><?php echo $matx["Correo"]; ?></td>
          <td><?php echo $matx["Correo_institucional"]; ?></td>
          <td><?php echo $matx["Sexo"]; ?></td>
          <td><?php echo $matx["Estatus"]; ?></td>
          <td><?php echo $matx["NomEducativa"]; ?></td>
          <td><?php echo $matx["P_curp"]; ?></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </div>
  <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
  <!-- Custom and plugin javascript -->
  <script src="assets/table/js/scriptAgregado1.js"></script>

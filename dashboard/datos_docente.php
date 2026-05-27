<?php
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST['IdUsua'];

  $sql_g1 = $db->query("SELECT tblc_nivel_clases.IdNivel FROM tblc_nivel_clases WHERE tblc_nivel_clases.IdUsua = '$IdUsua' AND tblc_nivel_clases.IdGrado = 1");
  $db->rows($sql_g1);
  $_g1 = $db->recorrer($sql_g1);
  $sql_g2 = $db->query("SELECT tblc_nivel_clases.IdNivel FROM tblc_nivel_clases WHERE tblc_nivel_clases.IdUsua = '$IdUsua' AND tblc_nivel_clases.IdGrado = 2");
  $db->rows($sql_g2);
  $_g2 = $db->recorrer($sql_g2);

  $sql_g3 = $db->query("SELECT tblc_nivel_clases.IdNivel FROM tblc_nivel_clases WHERE tblc_nivel_clases.IdUsua = '$IdUsua' AND tblc_nivel_clases.IdGrado = 3");
  $db->rows($sql_g3);
  $_g3 = $db->recorrer($sql_g3);

  $lst_n = $db->query("SELECT tblc_docdocentes.IdDocDocente, tblc_docdocentes.Nombre, tblc_docdocentes.Code, tblc_tipodocumento.IdGrado FROM tblc_docdocentes Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docdocentes.IdTipoDocumento WHERE tblc_docdocentes.IdUsua =  '$IdUsua' AND tblc_docdocentes.Code IS NOT NULL  GROUP BY tblc_docdocentes.Code ORDER BY tblc_tipodocumento.IdGrado ASC");


  $sql_sem = $db->query("SELECT tblc_usuario.Semblanza FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql_sem);
  $_sem = $db->recorrer($sql_sem);

  $_gx = 0;
  if((isset($_g3['IdNivel'])) || (isset($_g2['IdNivel'])) || (isset($_g1['IdNivel']))){
    $_gx = 1;
  }
  ?>
  <?php if($_gx == 0){ ?>
  <div class="bg-red-active color-palette" style="padding: 4px; "><span style="color: yellow; font-size: 12px;"><i class="fa fa-fw fa-warning"></i> Nota: debe de seleccionar los grados de estudios que ha alcanzado.</span></div>
  <?php } ?>

  
  <div class="btn-group">
   <button type="button" <?php if(isset($_g3['IdNivel'])){ ?> onclick="aplicar_n(<?php echo $IdUsua; ?>, 3, 0)" class="btn btn-success" <?php } else { ?> onclick="aplicar_n(<?php echo $IdUsua; ?>, 3, 1)" class="btn btn-default" <?php } ?>><i class="fa fa-fw <?php if(isset($_g3['IdNivel'])){ echo 'fa-check-circle'; } else { echo 'fa-hand-stop-o'; } ?>"></i> LICENCIATURA</button>
   <button type="button" <?php if(isset($_g2['IdNivel'])){ ?> onclick="aplicar_n(<?php echo $IdUsua; ?>, 2, 0)" class="btn btn-success" <?php } else { ?> onclick="aplicar_n(<?php echo $IdUsua; ?>, 2, 1)" class="btn btn-default" <?php } ?>><i class="fa fa-fw <?php if(isset($_g2['IdNivel'])){ echo 'fa-check-circle'; } else { echo 'fa-hand-stop-o'; } ?>"></i> MAESTRÍA</button>
   <button type="button" <?php if(isset($_g1['IdNivel'])){ ?> onclick="aplicar_n(<?php echo $IdUsua; ?>, 1, 0)" class="btn btn-success" <?php } else { ?> onclick="aplicar_n(<?php echo $IdUsua; ?>, 1, 1)" class="btn btn-default" <?php } ?>><i class="fa fa-fw <?php if(isset($_g1['IdNivel'])){ echo 'fa-check-circle'; } else { echo 'fa-hand-stop-o'; } ?>"></i> DOCTORADO</button>
   <button type="button" class="btn bg-navy btn-flat btn-sx" onclick="viewGrados(<?php echo $IdUsua; ?>)" href="javascript:void(0);"> <i class="fa fa-fw fa-upload"></i> SUBIR GRADOS</button>

 </div>
 <br>

 <div class="box box-solid">
   <div class="box-body">
     <table class="table table-striped">
      <tbody>
        <tr>
          <th>Nivel de formación acad&eacute;mica</th>
          <th style="text-align: center;">Título</th>
          <th style="text-align: center;">Cédula</th>
          <th></th>
        </tr>
        <?php $_f = 0; while($_nivel = $db->recorrer($lst_n)){ $_f = ($_f + 1);
          if($_nivel['IdGrado'] == 3){ $IdTipoDocT = 5; }
          if($_nivel['IdGrado'] == 2){ $IdTipoDocT = 6; }
          if($_nivel['IdGrado'] == 1){ $IdTipoDocT = 7; }

          if($_nivel['IdGrado'] == 3){ $IdTipoDocC = 8; }
          if($_nivel['IdGrado'] == 2){ $IdTipoDocC = 9; }
          if($_nivel['IdGrado'] == 1){ $IdTipoDocC = 35; }
          $cox = $_nivel['Code'];
          $sql_ti = $db->query("SELECT tblc_docdocentes.IdDocDocente, tblc_estatus.Estatus, tblc_docdocentes.Archivo, tblc_docdocentes.Anio, tblc_docdocentes.Mes, tblc_docdocentes.Estatus AS IdE FROM tblc_docdocentes Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docdocentes.Estatus WHERE tblc_docdocentes.IdUsua =  '$IdUsua' AND tblc_docdocentes.IdTipoDocumento =  '$IdTipoDocT' AND tblc_docdocentes.Code = '$cox'");
          $db->rows($sql_ti);
          $_ti = $db->recorrer($sql_ti);

          $sql_ce = $db->query("SELECT tblc_docdocentes.Code, tblc_docdocentes.IdDocDocente, tblc_estatus.Estatus, tblc_docdocentes.Archivo, tblc_docdocentes.Anio, tblc_docdocentes.Mes, tblc_docdocentes.Estatus AS IdE FROM tblc_docdocentes Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docdocentes.Estatus WHERE tblc_docdocentes.IdUsua =  '$IdUsua' AND tblc_docdocentes.IdTipoDocumento =  '$IdTipoDocC' AND tblc_docdocentes.Code = '$cox'");
          $db->rows($sql_ce);
          $_ce = $db->recorrer($sql_ce);

          ?>
        <tr>
          <td><?php echo $_nivel['Nombre']; ?></td>
          <td style="text-align: center;">
            <p <?php if(($_ti['IdE'] == 2) || ($_ti['IdE'] == 4) || ($_ti['IdE'] == 5)){ ?> onclick="ver_docs_docente(<?php echo $_ti['IdDocDocente']; ?>)" style="cursor: pointer; color: blue;" <?php } else { echo "style='color: red;'"; } ?> ><?php echo $_ti['Estatus']; ?></p>
            <?php if(($_ti['IdE'] == 2) || ($_ti['IdE'] == 12) || ($_ti['IdE'] == 5)){ ?>
              <button onclick="subir_docs_dox(<?php echo $_ti['IdDocDocente']; ?>,1)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-upload"></i></button>
            <?php } ?>
          </td>
          <td style="text-align: center;">
            <p <?php if(($_ce['IdE'] == 2) || ($_ce['IdE'] == 4) || ($_ce['IdE'] == 5)){ ?> onclick="ver_docs_docente(<?php echo $_ce['IdDocDocente']; ?>)" style="cursor: pointer; color: blue;" <?php } else { echo "style='color: red;'"; } ?>><?php echo $_ce['Estatus']; ?></p>
            <?php if(($_ce['IdE'] == 2) || ($_ce['IdE'] == 12) || ($_ce['IdE'] == 5)){ ?>
              <button onclick="subir_docs_dox(<?php echo $_ce['IdDocDocente']; ?>,2)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-upload"></i></button>
            <?php } ?>
          </td>
          <td>
            <button onclick="del_docsx(<?php echo $_ce['Code']; ?>,<?php echo $IdUsua; ?>)" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr><?php } ?>
      </tbody>
    </table>
    <?php if($_f == 0){ ?>
    <div class="bg-red-active color-palette" style="padding: 4px; "><span style="color: yellow; font-size: 12px;"><i class="fa fa-fw fa-warning"></i> Nota: debe de subir los documento que acrediten su grado de estudio.</span></div>
    <?php } ?>
   </div>
 </div>

 <?php if(!isset($_sem["Semblanza"])){ ?>
 <div class="bg-red-active color-palette" style="padding: 4px; "><span style="color: yellow; font-size: 12px;"><i class="fa fa-fw fa-warning"></i> Nota: debe de escribir su semblanza y/o biografía.</span></div>
 <?php } ?>
 <div style="padding: 5px; background: #7c366c;"><span style="color: white;"><i class="fa fa-fw fa-user"></i> Semblanza del docente</span></div>
 <div class="box box-solid">
   <div class="box-header with-border">
     <span class="input-group-btn" style="float: right; padding-right: 107px; margin-top: -3px;">
       <button onclick="viewSemblanza()" href="javascript:void(0);" style="border-radius: 25px;" type="button" class="btn btn-warning btn-flat"><i class="fa fa-fw fa-edit"></i> Semblanza</button>
     </span>
   </div>
   <div class="box-body" style="text-align: justify;">
      <?php echo $_sem["Semblanza"]; ?>
   </div>
 </div>

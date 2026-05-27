<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];
  $IdParcial = $_POST["IdParcial"];
  $IdSemana = $_POST["IdSemana"];
  $IdActividad = $_POST["IdActividad"];
  $NoSemana = $_POST["NoSemana"];
  $IdUsua = $_SESSION["IdUsua"];
  $IdPar = $IdParcial;

  $sql_act = $db->query("SELECT
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.IdEstatus,
tblp_actividadesdocente.DesActividad,
tblp_asignacion.IdAsignacion,
tblp_asignacion.Anio,
tblp_asignacion.Mes
FROM
tblp_actividadesdocente
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_actividadesdocente.IdAsignacion
WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividad' LIMIT 1");
  $db->rows($sql_act);
  $datos_act = $db->recorrer($sql_act);

  $sql8 = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.Link, tblp_tareas.Link2, tblp_tareas.Link3 FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '".$_POST["idAsignacion"]."' AND tblp_tareas.IdActividadesDocente = '".$_POST["IdActividad"]."' AND tblp_tareas.IdAlumno= '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdTarea = $datos81["IdTarea"];
  if(!$IdTarea){
    $insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente, FecCap) VALUES ('".$_POST["idAsignacion"]."','$IdUsua','".$_POST["IdActividad"]."','$IdPar',NOW())");
    $IdTarea = $db->insert_id;
  }

  ?>
  <link rel="stylesheet" href="main.css">
  <div class="col-md-8">
    <div class="box-primary">
      <div class="box-body">
        <div class="box-header with-border">
          <i class="fa fa-pencil"></i>
          <h3 class="box-title"><?php echo $datos_act['NomActividad']; ?></h3>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box-primary">
      <div class="box-body">
        <a class="btn btn-app" onclick="subirMiTarea(<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>,<?php echo $NoSemana; ?>,<?php echo $IdActividad; ?>)" href="javascript:void(0);">
          <span class="badge bg-gren"><i class="fa fa-refresh"></i></span>
          <i class="fa fa-refresh"></i> Actualizar
        </a>
        <a class="btn btn-app" onclick="miUnidad(<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>,<?php echo $NoSemana; ?>)">
          <span class="badge bg-red"><i class="fa fa-reply"></i></span>
          <i class="fa fa-reply-all"></i> Regresar
        </a>
      </div>
    </div>
  </div>

<div class="principal">
  <form action="" id="form_subir" class="form-horizontal">
    <input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $_POST["IdActividad"]; ?>" type="hidden"/>
    <input id="IdTipo" name="IdTipo" value="2" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_POST["idAsignacion"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>


    <div class="form-group">
        <label for="inputEmail4" class="col-sm-3 control-label">Buscar tarea:</label>
        <div class="col-sm-9">
          <input type="file" name="archivo" id="archivo" required onchange="ValArchivoPDF(this,'archivo');">
        </div>
      </div>

    <div class="barra" id="barra" style="display: none;">
      <div class="barra_azul" id="barra_estado">
        <span></span>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-4">
        <div class="checkbox">
          <label>
            <input type="checkbox" id="chkLink1" name="chkLink1" >
            <?php if($datos81["Link"]) { $ar1 = $datos81["Link"];  echo "<b style= 'color: red'>(1) Archivo activo</b>"; } else { echo "<b>(1) Libre</b>"; } ?>
          </label>

        </div><br>
        <?php if($datos81["Link"]) { ?> <span onClick="window.open('assets/trabajos/<?php echo $datos_act['Anio'].'/'.$datos_act['Mes'].'/'.$datos_act['IdAsignacion'].'/tareas/'.$datos81["Link"]; ?>','_blank')" href="javascript:void(0);" style="cursor: pointer;" title="Ver archivo" class='label label-primary'> <i class="fa fa-fw fa-file"></i> <?php echo $datos81["Link"]; ?> </span> <?php  }  ?>
      </div>
      <div class="col-sm-4">
        <div class="checkbox">
          <label>
            <input type="checkbox" id="chkLink2" name="chkLink2" >
            <?php if($datos81["Link2"]) { echo "<b style= 'color: red'>(2) Archivo activo</b>"; } else { echo "<b>(2) Libre</b>"; } ?>
          </label>
        </div><br>
        <?php if($datos81["Link2"]) { ?> <span onClick="window.open('assets/trabajos/<?php echo $datos_act['Anio'].'/'.$datos_act['Mes'].'/'.$datos_act['IdAsignacion'].'/tareas/'.$datos81["Link2"]; ?>','_blank')" href="javascript:void(0);" style="cursor: pointer;" title="Ver archivo" class='label label-primary'> <i class="fa fa-fw fa-file"></i> <?php echo $datos81["Link2"]; ?> </span> <?php  }  ?>
      </div>
      <div class="col-sm-4">
        <div class="checkbox">
          <label>
            <input type="checkbox" id="chkLink3" name="chkLink3" >
            <?php if($datos81["Link3"]) { echo "<b style= 'color: red'>(3) Archivo activo</b>"; } else { echo "<b>(3) Libre</b>"; } ?>
          </label>
        </div><br>
        <?php if($datos81["Link3"]) { ?> <span onClick="window.open('assets/trabajos/<?php echo $datos_act['Anio'].'/'.$datos_act['Mes'].'/'.$datos_act['IdAsignacion'].'/tareas/'.$datos81["Link3"]; ?>','_blank')" href="javascript:void(0);" style="cursor: pointer;" title="Ver archivo" class='label label-primary'> <i class="fa fa-fw fa-file"></i> <?php echo $datos81["Link3"]; ?> </span> <?php  }  ?>
      </div>
      </div>

      <br>
      <?php if($datos_act['IdEstatus'] == 8){ ?>
    <div class="box-footer">
      <button name="bntSubir" id="bntSubir" type="button"  onclick="val_cargarTarea()" class="btn btn-success pull-right"><i class="fa fa-fw fa-save"></i> Cargar archivo</button>
    </div><?php } ?>
    <?php if($datos_act['IdEstatus'] == 26){ ?>
      <div class="bg-red-active color-palette" style="padding: 10px;"><span><i class="fa fa-fw fa-times-circle"></i> La actividad ya se encuentra finalizada.</span></div>
  <?php } ?>
    <input id="IdParcial" name="IdParcial" value="<?php echo $IdPar; ?>" type="hidden"/>
    <input id="IdTarea" name="IdTarea" value="<?php echo $IdTarea; ?>" type="hidden"/>
    <input id="IdSemana" name="IdSemana" value="<?php echo $IdSemana; ?>" type="hidden"/>
    <input id="NoSemana" name="NoSemana" value="<?php echo $NoSemana; ?>" type="hidden"/>
  </form>
</div>

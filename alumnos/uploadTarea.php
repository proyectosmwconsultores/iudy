<?php
session_start();
include('../hace.php');
  $IdUsua = $_SESSION['IdUsua'];

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();


  $sql9 = $db->query("SELECT tblp_actividadesdocente.IdParcialDocente, tblp_actividadesdocente.IdEstatus, tblp_actividadesdocente.IdSemanaDocente, tblp_actividadesdocente.NomActividad FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '".$_POST["IdActividad"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdPar = $datos91["IdParcialDocente"];
  $IdSemana = $datos91["IdSemanaDocente"];
  $IdEstatus = $datos91["IdEstatus"];

  $sql8 = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.Link, tblp_tareas.Link2, tblp_tareas.Link3 FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '".$_POST["idAsignacion"]."' AND tblp_tareas.IdActividadesDocente = '".$_POST["IdActividad"]."' AND tblp_tareas.IdAlumno= '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdTarea = $datos81["IdTarea"];
  if(!$IdTarea){
    $insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente, FecCap) VALUES ('".$_POST["idAsignacion"]."','$IdUsua','".$_POST["IdActividad"]."','$IdPar',NOW())");
    $IdTarea = $db->insert_id;
  }

  $sql7 = $db->query("SELECT tblp_semanadocente.NoSemana FROM tblp_semanadocente WHERE tblp_semanadocente.IdSemanaDocente = '$IdSemana'");
  $db->rows($sql7);
  $datos71 = $db->recorrer($sql7);
  $NoSemana = $datos71["NoSemana"];

?>

<link rel="stylesheet" href="main.css">

       <h4 class="modal-title"><?php echo $IdTarea.' - '.$datos91["NomActividad"]; ?> </h4>

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
                      <?php if($datos81["Link"]) { echo "<b style= 'color: red'>(1) Archivo activo</b>"; } else { echo "<b>(1) Libre</b>"; } ?>
                    </label>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="chkLink2" name="chkLink2" >
                      <?php if($datos81["Link2"]) { echo "<b style= 'color: red'>(2) Archivo activo</b>"; } else { echo "<b>(2) Libre</b>"; } ?>
                    </label>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="chkLink3" name="chkLink3" >
                      <?php if($datos81["Link3"]) { echo "<b style= 'color: red'>(3) Archivo activo</b>"; } else { echo "<b>(3) Libre</b>"; } ?>
                    </label>
                  </div>
                </div>
                </div>

                <br>
              <div class="box-footer">
                <button name="btnSalir" id="btnSalir" data-dismiss="modal" class="btn btn-danger"> Cancelar</button>
                <button name="bntSubir" id="bntSubir" type="button"  onclick="val_cargarTarea()" class="btn btn-success pull-right"><i class="fa fa-fw fa-save"></i> Guardar archivo</button>
              </div>
              <input id="IdParcial" name="IdParcial" value="<?php echo $IdPar; ?>" type="hidden"/>
              <input id="IdTarea" name="IdTarea" value="<?php echo $IdTarea; ?>" type="hidden"/>
              <input id="IdSemana" name="IdSemana" value="<?php echo $IdSemana; ?>" type="hidden"/>
              <input id="NoSemana" name="NoSemana" value="<?php echo $NoSemana; ?>" type="hidden"/>
            </form>
          </div>
        

<?php
  session_start();
  require('../php/clases/class.System.php');
  include('../hace.php');
  $db = new Conexion();
  $IdParcial = $_POST["IdParcial"];


  $sql2 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcial'");
  $db->rows($sql2);
  $datos21 = $db->recorrer($sql2);

  $sql = $db->query("SELECT * FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente = '$IdParcial'");

//
  ?>
  <section class="content">
    <form name="frm" id="frm" action="viewRevisarParcial.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
    <div class="row">


      <div class="col-md-12">
          <div class="box box-solid">

            <div class="col-md-12">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <i class="fa fa-gg-circle"></i>
                  <h3 class="box-title">Datos del parcial <?php echo $datos21["NoParcial"]; ?></h3>
                </div>
                <div class="box-body">
                  <dl class="dl-horizontal">
                    <dt>Tema:</dt>
                    <dd><?php echo $datos21["Tema"]; ?></dd>
                    <dt>Objetivo:</dt>
                    <dd><?php echo $datos21["Objetivo"]; ?></dd>
                  </dl>
                </div>
              </div>
          </div>
          <div class="col-md-12">



          <ul class="timeline timeline-inverse">

          <?php
          while($x = $db->recorrer($sql)){
            $IdSemana = $x["IdSemanaDocente"];

            $sql2 = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.IdActividades, tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.DesActividad, tblp_actividadesdocente.FecIni, tblp_actividadesdocente.FecFin, tblp_actividadesdocente.Porcentaje, tblc_tipoactividad.TipoActividad FROM tblp_actividadesdocente Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad WHERE tblp_actividadesdocente.IdParcialDocente = '$IdParcial' AND tblp_actividadesdocente.IdSemanaDocente = '$IdSemana'");

             ?>
          <li class="time-label">
                <span class="bg-red">
                  Semana <?php echo $x["NoSemana"]; ?>
                </span>
          </li>

          <li>
            <i class="fa fa-bookmark bg-blue"></i>

            <div class="timeline-item">
              <div class="timeline-body">
                <?php echo $x["Temas"]; ?>
              </div>
            </div>
          </li>
          <?php
          while($y = $db->recorrer($sql2)){ ?>

          <li>
            <i class="fa fa-map-signs bg-green"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-bell"></i> <?php echo $y["TipoActividad"]; ?></span>

              <h3 class="timeline-header"><?php echo $y["NomActividad"]; ?></h3>

              <div class="timeline-body">
                <?php echo $y["DesActividad"]; ?>
                <br>
                <?php if($y["FecIni"]){ ?>
                <dl class="dl-horizontal">
                  <dt>Fecha inicial:</dt>
                  <dd><?php echo obtenerFechaEnLetra($y["FecIni"]); ?></dd>
                  <dt>Fecha final:</dt>
                  <dd><?php echo obtenerFechaEnLetra($y["FecFin"]); ?></dd>
                  <dt>Porcentaje:</dt>
                  <dd><?php echo $y["Porcentaje"]; ?> %</dd>
                </dl>
                <?php } else { ?>
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Alerta</h4>
                    El asesor acad&eacute;mico no configur&oacute; los datos de esta actividad.
                  </div>
                <?php } ?>
              </div>

            </div>
          </li>


        <?php } } ?>

        </ul>
      </div>






          </div>

        </div>

    </div>
<?php if($_POST["User"] == "C"){ ?>
    <div class="form-group">
      <label>Observaciones:</label>
      <textarea name="txtObservaciones" id="txtObservaciones" class="form-control" rows="3" placeholder="Si desea hacer alguna observación puede escribirlo aquí ..."></textarea>
    </div>
    <div class="row">
                <div class="col-lg-6">
                  <div class="input-group">
                    <label>Seleccione estatus:</label>
                    <select class="form-control" name="txtIdEstatus" id="txtIdEstatus">
                      <option> - Seleccione -</option>
                      <option value="25">De regreso a revisi&oacute;n</option>
                      <option value="4">Aprobado</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="input-group">
                    <label>Seleccione bimestre:</label>
                    <select class="form-control" name="txtBimestre" id="txtBimestre">
                      <option> - Seleccione -</option>
                      <option value="1">Bimestre 1</option>
                      <option value="2">Bimestre 2</option>
                    </select>
                  </div>
                </div>
              </div><br>
    <button type="button" onclick="saveCambios(<?php echo $IdParcial; ?>)" class="btn btn-block btn-success btn-sm">Guadar cambios</button>
<?php  } ?>
  </form>



      </section>

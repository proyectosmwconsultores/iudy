<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];
  $IdParcial = $_POST["IdParcial"];

  $sql_par1 = $db->query("SELECT tblp_parcialdocente.IdParcialDocente, tblp_parcialdocente.NoParcial, tblp_parcialdocente.Tema, tblp_parcialdocente.Objetivo FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente =  '$IdParcial'");
  $db->rows($sql_par1);
  $datosp1 = $db->recorrer($sql_par1);

  $sql_sem1 = $db->query("SELECT tblp_semanadocente.IdSemanaDocente, tblp_semanadocente.NoSemana, tblp_semanadocente.Temas FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente =  '$IdParcial' ORDER BY tblp_semanadocente.NoSemana ASC ");
  ?>

<div class="row">
        <div class="col-md-6">
          <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-flag"></i> <?php echo $_SESSION['_txt']; ?> <?php echo $datosp1['NoParcial']; ?></h3>
          </div>
          <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Tema:</label>

                  <div class="col-sm-10">
                    <?php echo $datosp1['Tema']; ?>
                  </div>
                </div><br>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Objetivo:</label>

                  <div class="col-sm-10">
                    <?php echo $datosp1['Tema']; ?>
                  </div>
                </div>
              </div>
            </form>
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="box-header with-border">
              <h3 class="box-title">Mis unidades disponibles</h3>
          </div>
          <div class="box box-widget">
            <div class="box-body">
              <?php while($sem = $db->recorrer($sql_sem1)){ ?>
              <a class="btn btn-app" onclick="miUnidad(<?php echo $IdParcial; ?>,<?php echo $sem['IdSemanaDocente']; ?>,<?php echo $sem['NoSemana']; ?>)">
                <span class="badge bg-purple"><?php echo $sem['NoSemana']; ?></span>
                <i class="fa fa-file-text-o"></i> Unidad <?php echo $sem['NoSemana']; ?>
              </a><?php } ?>
            </div>
          </div>
        </div>
      </div>

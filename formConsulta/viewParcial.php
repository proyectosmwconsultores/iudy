<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdParcial = $_POST["IdParcial"];
  $IdOferta = $_POST["IdOferta"];
  $IdModulo = $_POST["IdModulo"];
  $sql = $db->query("SELECT * FROM tblp_parcial WHERE tblp_parcial.IdOferta = '$IdOferta' AND tblp_parcial.IdModulo = '$IdModulo'");

//
  ?>
  <section class="content">
    <form name="frm" id="frm" action="doMiPlaneacion.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_SESSION["IdAsignacion"]; ?>" type="hidden"/>
    <div class="row">

      <?php while($x = $db->recorrer($sql)){ $IdParcial = $x["IdParcial"];  ?>
      <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-text-width"></i>
              <h3 class="box-title">Parcial <?php echo $x["NoParcial"]; ?></h3>
            </div>
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>Tema:</dt>
                <dd><?php echo $x["Tema"]; ?></dd>
                <dt>Objetivo:</dt>
                <dd><?php echo $x["Objetivo"]; ?></dd>
              </dl>
            </div>
            <button onclick="copiarParcial(<?php echo $x["IdParcial"]; ?>)" type="button" class="btn btn-block btn-success btn-xs">Copiar parcial <?php echo $x["NoParcial"]; ?></button>
          </div>

        </div>
        <?php } ?>

        <?php if(!$IdParcial){ ?>


                <a class="btn btn-block btn-social btn-google">
                          <i class="fa fa-info-circle"></i> No existen parciales creados anteriormente.
                        </a>
              <?php } ?>
    </div>
  </form>



      </section>

<?php
include('../hace.php');
if(isset($_POST["IdServicio"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdServicio = $_POST["IdServicio"];

  $sql_s = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdServicio = '$IdServicio' ");
  $db->rows($sql_s);
  $_serv = $db->recorrer($sql_s);



  ?>
  <form name="frm22" id="frm22" action="addFirmas.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

              <div class="box-body">

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre de la Dependencia / Institución / Organismo:</label>
                  <div class="col-sm-8">
                    <input type="text" name="txtDep" id="txtDep" class="form-control"  value="<?php echo $_serv["NomDependencia"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Progama del Servicio Social:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="txtPro" id="txtPro"  value="<?php echo $_serv["NomPrograma"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Periodo:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="txtPer" id="txtPer"  value="<?php echo $_serv["Periodo"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Fecha de impresión:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="txtFecx" id="txtFecx" value="<?php echo $_serv["FecCarta"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">No oficio:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="txtNo" id="txtNo" value="<?php echo $_serv["Folio_carta"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Grado del alumno:</label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" name="txtGra" id="txtGra" value="<?php echo $_serv["Grado"]; ?>">
                  </div>
                </div>
                <div class="box-footer">
                  <?php if($_serv["FecCarta"]){ ?>
                    <button type="button" onclick="add_doc_servicio_carta(<?php echo $IdServicio; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-refresh"></i> Actualizar carta de presentación</button>
                  <button style="margin-right: 10px;" type="button" onclick="window.open('repositorio/portafolio/carta_presentacion_ss.php?tokenId=<?php echo time().$IdServicio; ?>','_blank')" href="javascript:void(0);" title="Imprimir carta de presentación de servicio social" class="btn btn-danger pull-right"> <i class="fa fa-print"></i> Imprimir carta de presentación</button>
                <?php } else { ?>
                  <button type="button" onclick="add_doc_servicio_carta(<?php echo $IdServicio; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Generar carta de presentación</button>
                <?php }?>
                </div>
              </div>
        </form>
        <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script>
        $(function () {
          //Date picker
          $('#txtFecx').datepicker({
            autoclose: true
          })

        })
        </script>
  <?php
}
?>

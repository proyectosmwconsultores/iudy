<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();



  $IdCiclo = $_POST['employee_id'];
  $sql9 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwSubP1 = $datos91["SubPeriodo1"];
  $rwSubPIni1 = $datos91["SubPerIni1"];
  $rwSubPFin1 = $datos91["SubPerFin1"];
  $rwSubP2 = $datos91["SubPeriodo2"];
  $rwSubPIni2 = $datos91["SubPerIni2"];
  $rwSubPFin2 = $datos91["SubPerFin2"];
  $rwSubP3 = $datos91["SubPeriodo3"];
  $rwSubPIni3 = $datos91["SubPerIni3"];
  $rwSubPFin3 = $datos91["SubPerFin3"];
  $rwSubP4 = $datos91["SubPeriodo4"];
  $rwSubPIni4 = $datos91["SubPerIni4"];
  $rwSubPFin4 = $datos91["SubPerFin4"];
  $rwSubP5 = $datos91["SubPeriodo5"];
  $rwSubPIni5 = $datos91["SubPerIni5"];
  $rwSubPFin5 = $datos91["SubPerFin5"];
  $rwSubP6 = $datos91["SubPeriodo6"];
  $rwSubPIni6 = $datos91["SubPerIni6"];
  $rwSubPFin6 = $datos91["SubPerFin6"];
  $rwSubP7 = $datos91["SubPeriodo7"];
  $rwSubPIni7 = $datos91["SubPerIni7"];
  $rwSubPFin7 = $datos91["SubPerFin7"];


?>
  <div class="box-info">
            <form class="form-horizontal" name="frm" id="frm" action="addSubPeriodo.php" method="POST" enctype="multipart/form-data">
            <input id="IdCiclo" name="IdCiclo" value="<?php echo $IdCiclo; ?>" type="hidden"/>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Seleccione subperiodo:</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="txtSub" id="txtSub">
                      <option value="">- Seleccione -</option>
                      <option value="1">SubPeriodo 1</option>
                      <option value="2">SubPeriodo 2</option>
                      <option value="3">SubPeriodo 3</option>
                      <option value="4">SubPeriodo 4</option>
                      <option value="5">SubPeriodo 5</option>
                      <option value="6">SubPeriodo 6</option>
                      <option value="7">SubPeriodo 7</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">SubPeriodo:</label>
                  <div class="col-sm-8">
                    <input class="form-control" placeholder="Código subperiodo" type="text" id="txtCodigo" name="txtCodigo">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Mes inicial:</label>
                  <div class="col-sm-8">
                    <input class="form-control" placeholder="Mes inicial" type="text" id="datepicker3" name="datepicker3">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Mes final:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control pull-right" placeholder="Mes final" id="datepicker4" name="datepicker4">
                  </div>
                </div>



              </div>
              <div class="box-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-info pull-right" onclick="addSubPeriodo()">Agregar</button>
              </div>
            </form>
          </div>

          <table class="table table-striped">
                <tbody>
                  <tr>
                    <th>#</th>
                    <th>SubPeriodo</th>
                    <th>Inicio</th>
                    <th>Finalizaci&oacute;n</th>
                </tr>
                <?php if($rwSubP1){ ?>
                <tr>
                  <td><button onclick="delSubPeriodo(<?php echo $IdCiclo; ?>,1)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></button></td>
                  <td>SubPeriodo 1 <br><?php echo $rwSubP1; ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPIni1); ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPFin1); ?></td>
                </tr>
                <?php } ?>
                <?php if($rwSubP2){ ?>
                <tr>
                  <td><button onclick="delSubPeriodo(<?php echo $IdCiclo; ?>,2)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></button></td>
                  <td>SubPeriodo 2 <br><?php echo $rwSubP2; ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPIni2); ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPFin2); ?></td>
                </tr>
                <?php } ?>
                <?php if($rwSubP3){ ?>
                <tr>
                  <td><button onclick="delSubPeriodo(<?php echo $IdCiclo; ?>,3)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></button></td>
                  <td>SubPeriodo 3 <br><?php echo $rwSubP3; ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPIni3); ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPFin3); ?></td>
                </tr>
                <?php } ?>
                <?php if($rwSubP4){ ?>
                <tr>
                  <td><button onclick="delSubPeriodo(<?php echo $IdCiclo; ?>,4)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></button></td>
                  <td>SubPeriodo 4 <br><?php echo $rwSubP4; ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPIni4); ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPFin4); ?></td>
                </tr>
                <?php } ?>
                <?php if($rwSubP5){ ?>
                <tr>
                  <td><button onclick="delSubPeriodo(<?php echo $IdCiclo; ?>,5)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></button></td>
                  <td>SubPeriodo 5 <br><?php echo $rwSubP5; ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPIni5); ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPFin5); ?></td>
                </tr>
                <?php } ?>
                <?php if($rwSubP6){ ?>
                <tr>
                  <td><button onclick="delSubPeriodo(<?php echo $IdCiclo; ?>,6)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></button></td>
                  <td>SubPeriodo 6 <br><?php echo $rwSubP6; ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPIni6); ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPFin6); ?></td>
                </tr>
                <?php } ?>
                <?php if($rwSubP7){ ?>
                <tr>
                  <td><button onclick="delSubPeriodo(<?php echo $IdCiclo; ?>,7)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></button></td>
                  <td>SubPeriodo 7 <br><?php echo $rwSubP7; ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPIni7); ?></td>
                  <td><?php echo obtenerFechaEnLetra($rwSubPFin7); ?></td>
                </tr>
                <?php } ?>
              </tbody></table>
          <?php
}
?>

<script>

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('yyyy/mm/dd', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()




    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })



    $('#datepicker3').datepicker({
      autoclose: true
    })
    $('#datepicker4').datepicker({
      autoclose: true
    })

  })
</script>

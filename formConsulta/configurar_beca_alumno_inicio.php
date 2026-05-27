<?php
session_start();
if (isset($_POST["IdCiclo"])) {
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST["IdCiclo"];
  $IdAdmin = $_SESSION['IdUsua'];
  $IdUsua = $_POST['IdUsua'];

  $sql_us = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'  ");
  $db->rows($sql_us);
  $_user = $db->recorrer($sql_us);
  $IdOferta = $_user['IdOferta'];
  $_idCiclo = $_user['id_ciclo_ini'];

  $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdCiclo <> '$_idCiclo' AND tblp_pagos.IdEstatus = '1' ");
  //$db->query("DELETE FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo <> '$_idCiclo' ");

  $pag = 0;
  $sql_pag = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdConcepto, tblp_pagos.Monto FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' GROUP BY tblp_pagos.IdConcepto ORDER BY tblp_pagos.IdConcepto ASC ");
  while ($_becx = $db->recorrer($sql_pag)) { $pag = 1;

    $sql_insx = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' AND tblp_beca.IdConcepto = '" . $_becx['IdConcepto'] . "' ");
    $db->rows($sql_insx);
    $_ins = $db->recorrer($sql_insx);
    
    ;

    if (isset($_ins['IdBeca'])) {
      $_insBeca = $_ins['IdBeca'];
      if (!isset($_ins['Descuento'])) {
        $Descuento = $_ins['Descuento'];
        $importe = $_becx["Monto"];
        if($descuento < 0){
          $descuento = 0;
          $total = $_becx["Monto"];
        } else {
          $total = $_becx["Total"];
          $descuento = $_becx["Descuento"];
        }
        $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$importe', tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$total' WHERE tblp_beca.IdBeca= '$_insBeca' ");
      }
    } else {
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdCiclo, Importe, Descuento, Total) VALUES('$IdUsua','" . $_becx["IdConcepto"] . "', 0, NOW(),'$IdAdmin',8,'$_idCiclo','" . $_becx["Monto"] . "','0','" . $_becx["Monto"] . "')");
    }
  }

  if($pag == 0){
    //$db->query("DELETE FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua'");
    $db->query("UPDATE tblc_usuario SET tblc_usuario.GPago = NULL WHERE tblc_usuario.IdUsua = '$IdUsua'");
  }




  $sql_cic = $db->query("SELECT tblp_beca.IdBeca, tblc_ciclo.Ciclo, tblp_beca.IdCiclo FROM tblp_beca Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_beca.IdCiclo WHERE tblp_beca.IdUsua =  '$IdUsua' GROUP BY tblp_beca.IdCiclo ORDER BY tblc_ciclo.FInicio ASC");

  $sql_ins = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' AND tblp_beca.IdConcepto = '1' ");
  $db->rows($sql_ins);
  $_ins = $db->recorrer($sql_ins);
  $_insBeca = $_ins['IdBeca'];
  $_insPorcentaje = $_ins['Porcentaje'];



  $sql_col = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' AND tblp_beca.IdConcepto = '2' ");
  $db->rows($sql_col);
  $_col = $db->recorrer($sql_col);
  $_colBeca = $_col['IdBeca'];
  $_colPorcentaje = $_col['Porcentaje'];

  $sql_rein = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' AND tblp_beca.IdConcepto = '3' ");
  $db->rows($sql_rein);
  $_rein = $db->recorrer($sql_rein);
  if(!isset($_rein['IdBeca'])){

    $sql_montoRei = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.Monto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$_idCiclo' ");
    $db->rows($sql_montoRei);
    $_montoRein = $db->recorrer($sql_montoRei);    

    $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdCiclo, Importe, Descuento, Total) VALUES('$IdUsua','3', 0, NOW(),'$IdAdmin',8,'$_idCiclo','" . $_montoRein["Monto"] . "','0','" . $_montoRein["Monto"] . "')");

    $sql_rein = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' AND tblp_beca.IdConcepto = '3' ");
    $db->rows($sql_rein);
    $_rein = $db->recorrer($sql_rein);

  }
  
  
  
  $_reinBeca = $_rein['IdBeca'];
  $_reinPorcentaje = $_rein['Porcentaje'];



  if($pag == 0){ ?>
<div class="box-info">
    <form class="form-horizontal" name="frmx" id="frmx" action="addSubPeriodo.php" method="POST" enctype="multipart/form-data">
      <div class="box-body">
        <div class="form-group" style="text-align: center;">
        <h2>El alumno no tiene sus pagos cargados.</h2>
          <img src="assets/images/iconos/_hoy.gif" style="width: 50%;">
        </div>
      </div>
    </form>
</div>

  <?php } else { ?>

  <div class="box-info">
    <form class="form-horizontal" name="frmx" id="frmx" action="addSubPeriodo.php" method="POST" enctype="multipart/form-data">
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-4 control-label">Periodo escolar:</label>
          <div class="col-sm-8">
            <select disabled class="form-control">
              <option value=""> - Seleccione - </option>
              <?php while ($_cic = $db->recorrer($sql_cic)) { ?>
                <option value="<?php echo $_cic['IdCiclo']; ?>" <?php if ($_cic['IdCiclo'] == $IdCiclo) { ?>selected="selected" <?php } ?>> <?php echo $_cic['Ciclo'] ?> </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="bg-light-blue-active color-palette" style='padding: 5px;'><span>INSCRIPCIÓN</span> <b style="text-align: right; float: right; color: yellow; font-size: 17px;">$ <?php echo number_format($_ins['Importe'], 2, '.', ','); ?> </b></div>
        <br>
        <div class="form-group">
          <label class="col-sm-8 control-label">Importe pagar inscripción:</label>
          <div class="col-sm-4">
            <input type="number" name="txt_inscri" id="txt_inscri" class="form-control" value="<?php echo $_ins['Total']; ?>">
          </div>
        </div>
      </div>
      <?php if ($_idCiclo) { ?>
      <div class="box-footer" style="text-align: right;">
        <button onclick="modificar_beca_ixd(<?php echo $IdAdmin.','.$_insBeca.','.$_ins['Importe']; ?>)" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-refresh"></i> Actualizar inscripción</button>
      </div>
    <?php } ?>
    <div class="box-body">
        <div class="bg-light-blue-active color-palette" style='padding: 5px;'><span>MENSUALIDAD</span> <b style="text-align: right; float: right; color: yellow; font-size: 17px; ">$ <?php echo number_format($_col['Importe'], 2, '.', ','); ?> </b></div>
        <br>
        <div class="form-group">
          <label class="col-sm-8 control-label">Importe pagar mensualidad:</label>
          <div class="col-sm-4">
            <input type="number" name="txt_mensuual" id="txt_mensuual" class="form-control" value="<?php echo $_col['Total']; ?>">
          </div>
        </div>
      </div>
      <?php if ($_idCiclo) { ?>
      <div class="box-footer" style="text-align: right;">
        <button onclick="modificar_beca_mens(<?php echo $IdAdmin.','.$_colBeca.','.$_col['Importe']; ?>)" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-refresh"></i> Actualizar mensualidad</button>
      </div>
    <?php } ?>

    <div class="box-body">
        <div class="bg-light-blue-active color-palette" style='padding: 5px;'><span>REINSCRIPCIÓN</span> <b style="text-align: right; float: right; color: yellow; font-size: 17px;">$ <?php echo number_format($_rein['Importe'], 2, '.', ','); ?> </b></div>
        <br>
        <div class="form-group">
          <label class="col-sm-8 control-label">Importe pagar reinscripción:</label>
          <div class="col-sm-4">
            <input type="number" name="txt_reinscripcion" id="txt_reinscripcion" class="form-control" value="<?php echo $_rein['Total']; ?>">
          </div>
        </div>
      </div>
      <?php if ($_idCiclo) { ?>
      <div class="box-footer" style="text-align: right;">
        <button onclick="modificar_beca_reins(<?php echo $IdAdmin.','.$_reinBeca.','.$_rein['Importe']; ?>)" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-refresh"></i> Actualizar reinscripción</button>
      </div>
    <?php } ?>


    </form>
  </div>
  <?php } ?>
<script>
  function modificar_beca_ixd(IdAdmin, IdBecaIns, Importe) {
    var TipoGuardar = "mod_beca_usua_x_inscr";
    var Inscripcion = document.getElementById("txt_inscri").value;

    swal({
        title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de esta beca de este alumno?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');

          $.ajax({
              url: "formConsulta/setting.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                Inscripcion: Inscripcion,
                IdBecaIns: IdBecaIns,
                Importe: Importe,
                IdAdmin: IdAdmin
              },
              success: function(data) { }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Actualizado correctamente", "La beca del alumno se ha actualizado correctamente.", "success");

                $.ajax({
                  url: "formConsulta/configurar_beca_alumno_id.php",
                  method: "POST",
                  data: {
                    IdCiclo: IdCiclo,
                    IdUsua: IdUsua
                  },
                  success: function(data) {
                    $('#employee_promxi').html(data);
                    $('#data_promxi').modal('show');
                  }
                });
              }
              if (data == 0) {
                swal("Error al cargar", "No se puede cargar, verifique sus datos.", "error");
              }
            })

            .error(function(e) {
              swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
            });

        }

      });
  }

  function modificar_beca_mens(IdAdmin, IdBecaIns, Importe) {
    var TipoGuardar = "mod_beca_usua_x_mensua";
    var Inscripcion = document.getElementById("txt_mensuual").value;

    swal({
        title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de esta beca de este alumno?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');

          $.ajax({
              url: "formConsulta/setting.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                Inscripcion: Inscripcion,
                IdBecaIns: IdBecaIns,
                Importe: Importe,
                IdAdmin: IdAdmin
              },
              success: function(data) { }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Actualizado correctamente", "La beca del alumno se ha actualizado correctamente.", "success");

                $.ajax({
                  url: "formConsulta/configurar_beca_alumno_id.php",
                  method: "POST",
                  data: {
                    IdCiclo: IdCiclo,
                    IdUsua: IdUsua
                  },
                  success: function(data) {
                    $('#employee_promxi').html(data);
                    $('#data_promxi').modal('show');
                  }
                });
              }
              if (data == 0) {
                swal("Error al cargar", "No se puede cargar, verifique sus datos.", "error");
              }
            })

            .error(function(e) {
              swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
            });

        }

      });
  }

  function modificar_beca_reins(IdAdmin, IdBecaIns, Importe) {
    var TipoGuardar = "mod_beca_usua_x_reinscripcion";
    var Inscripcion = document.getElementById("txt_reinscripcion").value;

    swal({
        title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de esta beca de este alumno?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');

          $.ajax({
              url: "formConsulta/setting.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                Inscripcion: Inscripcion,
                IdBecaIns: IdBecaIns,
                Importe: Importe,
                IdAdmin: IdAdmin
              },
              success: function(data) { }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Actualizado correctamente", "La beca del alumno se ha actualizado correctamente.", "success");

                $.ajax({
                  url: "formConsulta/configurar_beca_alumno_id.php",
                  method: "POST",
                  data: {
                    IdCiclo: IdCiclo,
                    IdUsua: IdUsua
                  },
                  success: function(data) {
                    $('#employee_promxi').html(data);
                    $('#data_promxi').modal('show');
                  }
                });
              }
              if (data == 0) {
                swal("Error al cargar", "No se puede cargar, verifique sus datos.", "error");
              }
            })

            .error(function(e) {
              swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
            });

        }

      });
  }

</script>
<?php } ?>
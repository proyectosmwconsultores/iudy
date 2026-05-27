<?php
session_start();
if (isset($_POST["IdCiclo"])) {
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST["IdCiclo"];
  $IdAdmin = $_SESSION['IdUsua'];
  $IdUsua = $_POST['IdUsua'];

  $sql_us = $db->query("SELECT tblc_usuario.IdOferta FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'  ");
  $db->rows($sql_us);
  $_user = $db->recorrer($sql_us);
  $IdOferta = $_user['IdOferta'];

  $sql_beca_cal = $db->query("SELECT tblp_calendario.IdCalendario, tblp_calendario.FecDescuento, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.NomPlan, tblc_conceptosplanes.Costo, tblp_calendario.Monto, tblc_conceptos.NomConcepto, tblc_conceptos.IdConcepto
  FROM tblp_calendario Left Join tblc_conceptosdetalle ON tblc_conceptosdetalle.IdConceptoPlan = tblp_calendario.IdConceptosPlanes Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_conceptosdetalle.IdConcepto
  WHERE tblp_calendario.IdCiclo = '$IdCiclo' AND tblc_conceptos.Grado1 = '1' AND tblc_conceptosdetalle.IdOferta = '$IdOferta'
  GROUP BY
  tblc_conceptosplanes.IdConcepto ");
  while ($_becx = $db->recorrer($sql_beca_cal)) {

    $sql_insx = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' AND tblp_beca.IdConcepto = '" . $_becx['IdConcepto'] . "' ");
    $db->rows($sql_insx);
    $_ins = $db->recorrer($sql_insx);
    $_insBeca = $_ins['IdBeca'];
    $Descuento = $_ins['Descuento'];

    if ($_insBeca) {
      if (!$Descuento) {
        $importe = $_becx["Monto"];
        $desc = ($_becx["Monto"] / 100);
        $descuento = ($desc * $_ins["Porcentaje"]);
        $total = ($importe - $descuento);

        $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$importe', tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$total' WHERE tblp_beca.IdBeca= '$_insBeca' ");
      }
    } else {
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdCiclo, Importe, Descuento) VALUES('$IdUsua','" . $_becx["IdConcepto"] . "', 0, NOW(),'$IdAdmin',8,'$IdCiclo','" . $_becx["Monto"] . "','0')");
    }
  }





  // $vax = 0;
  // //$IdBeca_ins = 0;
  // $IdBeca_col = 0;

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

?>

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
        <div class="bg-light-blue-active color-palette" style='padding: 5px;'><span>INSCRIPCIÓN</span></div>
        <br>
        <div class="form-group">
          <label class="col-sm-8 control-label">Monto total:</label>
          <div class="col-sm-4">
            <input type="number" disabled class="form-control" value="<?php echo $_ins['Importe']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-8 control-label">Importe pagar inscripción:</label>
          <div class="col-sm-4">
            <input type="number" name="txt_inscri" id="txt_inscri" class="form-control" value="<?php echo $_ins['Total']; ?>">
          </div>
        </div>
      </div>
      <?php if ($IdCiclo) { ?>
      <div class="box-footer" style="text-align: right;">
        <button onclick="modificar_beca_ixd(<?php echo $IdAdmin.','.$_insBeca.','.$_ins['Importe']; ?>)" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-refresh"></i> Actualizar Inscripción</button>
      </div>
    <?php } ?>
    <div class="box-body">
        <div class="bg-light-blue-active color-palette" style='padding: 5px;'><span>MENSUALIDAD</span></div>
        <br>
        <div class="form-group">
          <label class="col-sm-8 control-label">Monto total:</label>
          <div class="col-sm-4">
            <input type="number" disabled class="form-control" value="<?php echo $_col['Importe']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-8 control-label">Importe pagar mensualidad:</label>
          <div class="col-sm-4">
            <input type="number" name="txt_mensuual" id="txt_mensuual" class="form-control" value="<?php echo $_col['Total']; ?>">
          </div>
        </div>
      </div>
      <?php if ($IdCiclo) { ?>
      <div class="box-footer" style="text-align: right;">
        <button onclick="modificar_beca_mens(<?php echo $IdAdmin.','.$_colBeca.','.$_col['Importe']; ?>)" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-refresh"></i> Actualizar Mensualidad</button>
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

</script>
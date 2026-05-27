<?php
session_start();
if (isset($_POST["IdUsua"])) {
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST["IdCiclo"];
  $IdOferta = $_POST["IdOferta"];
  $IdCampus = $_POST["IdCampus"];
  $IdAdmin = $_SESSION['IdUsua'];
  $IdUsua = $_POST['IdUsua'];

  $sql_us = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'  ");
  $db->rows($sql_us);
  $_user = $db->recorrer($sql_us);
  $_idOferta = $_user['IdOferta'];
  $_idCampus = $_user['IdCampus'];
  $_Grado = $_user['Grado'];
  $_idCiclo = $_user['id_ciclo_ini'];

  $fecha = date("Y-m-d");
  $fecha = date("Y-m-d",strtotime($fecha."- 3 month"));


  $sql_cicl = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$_idCiclo'  ");
  $db->rows($sql_cicl);
  $_cicloxz = $db->recorrer($sql_cicl);


  $sql_campus = $db->query("SELECT * FROM tblc_campus");
  $sql_oferta = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdGrado = '$_Grado' ORDER BY tblp_educativa.Nombre ASC");
  $sql_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '".$_cicloxz['Tipo']."' AND tblc_ciclo.FInicio >= '$fecha' ORDER BY tblc_ciclo.FInicio DESC ");

  $sql_seg = $db->query("SELECT
  tblp_seguimiento.IdSeguimiento,
  tblp_seguimiento.IdUsua,
  tblp_seguimiento.IdCiclo,
  tblp_seguimiento.Fecha,
  tblp_seguimiento.FecCap,
  tblp_seguimiento.Comentario_control,
  tblp_seguimiento.IdUsua_admin,
  tblc_usuario.Nombre,
  tblc_usuario.APaterno,
  tblc_usuario.AMaterno
  FROM
  tblp_seguimiento
  Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_seguimiento.IdUsua_admin
  WHERE
  tblp_seguimiento.IdUsua =  '$IdUsua'
  ");
?>

  <div class="box-info">
    <form class="form-horizontal" name="frmx" id="frmx" action="addSubPeriodo.php" method="POST" enctype="multipart/form-data">
      <input name="_idCiclo" id="_idCiclo" value="<?php echo $_idCiclo; ?>" type="hidden">
      <div class="box-body">
         <div class="form-group">
          <label class="col-sm-4 control-label">Periodo escolar:</label>
          <div class="col-sm-8">
            <select class="form-control" id="" disabled>
              <option value=""> - Seleccione - </option>
              <?php while ($_cic = $db->recorrer($sql_cic)) { ?>
                <option value="<?php echo $_cic['IdCiclo']; ?>" <?php if ($_cic['IdCiclo'] == $IdCiclo) { ?>selected="selected" <?php } ?>> <?php echo $_cic['Ciclo'] ?> </option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 control-label">Campus:</label>
          <div class="col-sm-8">
            <select class="form-control" id="_idCampus" onchange="sel_campus_id(<?php echo $IdCiclo; ?>,<?php echo $IdUsua; ?>)">
              <option value=""> - Seleccione - </option>
              <?php while ($_camps = $db->recorrer($sql_campus)) { ?>
                <option value="<?php echo $_camps['IdCampus']; ?>" <?php if ($_camps['IdCampus'] == $IdCampus) { ?>selected="selected" <?php } ?>> <?php echo $_camps['Campus']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label">Plan de estudios:</label>
          <div class="col-sm-8">
            <select class="form-control" id="_idOferta">
              <option value=""> - Seleccione - </option>
              <?php while ($_oferta = $db->recorrer($sql_oferta)) { ?>
                <option value="<?php echo $_oferta['IdEducativa']; ?>" <?php if ($_oferta['IdEducativa'] == $IdOferta) { ?>selected="selected" <?php } ?>> <?php echo $_oferta['Nombre'] ?> </option>
              <?php } ?>
            </select>
          </div>
        </div>
       
        <div class="form-group">
          <label class="col-sm-4 control-label">Nota:</label>
          <div class="col-sm-8">
            <input type="text" name="txt_nota" id="txt_nota" class="form-control" placeholder="Nota" value="<?php echo $_user['Semblanza'] ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Comentario:</label>
          <div class="col-sm-9">
            <textarea class="form-control" rows="3" id='_comentario' placeholder="Motivo de la actualización ..."></textarea>
            <span style="color: blue; font-size: 13px;"><b>Nota: </b>Recuerde que al hacer este cambio se deberá revisar nuevamente el concepto de inscripción, colegiatura y el porcentaje de beca.</span>
          </div>
        </div>
      </div>
      <div class="box-footer" style="text-align: right;">
        <button onclick="modificar_inscricpion(<?php echo $IdUsua . ',' . $IdAdmin; ?>)" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-refresh"></i> Actualizar</button>
      </div>
    </form>
  </div>
  <table class="table table-striped">
    <tbody>
      <tr>
        <th>Comentario</th>
        <th>Responsable</th>
        <th>Fec.cap</th>
      </tr>
      <?php while ($_segx = $db->recorrer($sql_seg)) { ?>
      <tr>
        <td><?php echo $_segx['Comentario_control']; ?></td>
        <td><?php echo $_segx['Nombre'].' '.$_segx['APaterno'].' '.$_segx['AMaterno']; ?></td>
        <td><?php echo $_segx['FecCap']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <script>
    function modificar_inscricpion(IdUsua, IdAdmin) {
      var TipoGuardar = "mod_inscripcion_alumno";
      var IdCampus = document.getElementById("_idCampus").value;
      var IdOferta = document.getElementById("_idOferta").value;
      var IdCiclo = document.getElementById("_idCiclo").value;
      var Comentario = document.getElementById("_comentario").value;
      var Nota = document.getElementById("txt_nota").value;

      swal({
          title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de alumno?",
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
                  IdUsua: IdUsua,
                  IdCampus: IdCampus,
                  IdOferta: IdOferta,
                  IdCiclo: IdCiclo,
                  Comentario: Comentario,
                  IdAdmin: IdAdmin, Nota:Nota
                },
                success: function(data) {

                }
              })
              .done(function(data) {
                if (data == 1) {
                  swal("Actualizado correctamente", "La beca del alumno se ha actualizado correctamente.", "success");

                  $.ajax({
                    url: "formConsulta/configurar_perfil_alumno.php",
                    method: "POST",
                    data: {
                      IdUsua: IdUsua,
                      IdCampus: IdCampus,
                      IdCiclo: IdCiclo,
                      IdOferta: IdOferta
                    },
                    success: function(data) {
                      $('#employee_ins').html(data);
                      $('#data_ins').modal('show');
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

    function sel_campus_id(IdCiclo, IdUsua) {
      var IdOferta = 0;
      var IdCampus = document.getElementById("_idCampus").value;

      $.ajax({
        url: "formConsulta/configurar_perfil_alumno.php",
        method: "POST",
        data: {
          IdUsua: IdUsua,
          IdCampus: IdCampus,
          IdCiclo: IdCiclo,
          IdOferta: IdOferta
        },
        success: function(data) {
          $('#employee_ins').html(data);
          $('#data_ins').modal('show');
        }
      });
    }
  </script>
<?php } ?>
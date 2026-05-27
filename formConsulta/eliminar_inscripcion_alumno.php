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

  $anio = date("Y");

  $sql_campus = $db->query("SELECT * FROM tblc_campus");
  $sql_oferta = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.IdEducativa, tblp_educativa.Nombre, tblp_educativa.IdGrado FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' AND tblp_educativa.IdGrado = '$_Grado' GROUP BY tblp_modulo.IdEducativa ORDER BY tblp_educativa.IdGrado ASC");
  $sql_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio >= '$anio' ORDER BY tblc_ciclo.Tipo ASC,  tblc_ciclo.FInicio ASC ");

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
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-4 control-label">Motivo:</label>
          <div class="col-sm-8">
            <select class="form-control">
              <option value="1"> - BAJA POR CANCELACIÓN DE INSCRIPCION - </option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Comentario de la baja:</label>
          <div class="col-sm-9">
            <textarea class="form-control" rows="3" id='_comentario' placeholder="Motivo de la baja del alumno ..."></textarea>
          </div>
        </div>
      </div>
      <div class="box-footer" style="text-align: right;">
        <button onclick="procesar_baja_id(<?php echo $IdUsua . ',' . $IdAdmin; ?>)" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-save"></i> Procesar baja</button>
      </div>
    </form>
  </div>

  <script>
    function procesar_baja_id(IdUsua, IdAdmin) {
      var TipoGuardar = "cancelar_inscripcion_id";
      var Comentario = document.getElementById("_comentario").value;

      swal({
          title: "\u00BFEst\u00E1 seguro que desea eliminar el proceso de inscripción de este alumno?",
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
                  Comentario: Comentario,
                  IdAdmin: IdAdmin
                },
                success: function(data) {
                  
                }
              })
              .done(function(data) {
                if (data == 1) {
                  var Text = 'del_'+IdUsua;
                  swal("Procesado correctamente", "La eliminación de la inscripcion del alumno se ha procesado correctamente.", "success");
                  $('#data_del').modal('hide');
                  document.getElementById(Text).style.display = 'none';
                  
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
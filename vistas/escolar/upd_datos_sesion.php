<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();

$IdUsua = $_POST["IdUsua"];

$sql8 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
$IdGrupo = $datos81['IdGrupo'];
$IdOferta = $datos81['IdOferta'];



// $sql_pagos = $db->query("SELECT tblp_pagos.IdUsua, tblp_pagos.IdGrupo, tblc_usuario.IdEstatus FROM tblp_pagos LEFT JOIN tblc_usuario ON tblp_pagos.IdUsua = tblc_usuario.IdUsua WHERE tblp_pagos.IdCiclo = '63' AND tblp_pagos.IdConcepto = '3' AND tblc_usuario.IdEstatus = 8");
// while ($_pag = $db->recorrer($sql_pagos)) {
  
//   $sql_activo = $db->query("SELECT tblc_alumnos.IdActivo FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '".$_pag['IdUsua']."' AND tblc_alumnos.IdCiclo = '63' LIMIT 1");
//   $db->rows($sql_activo);
//   $_activo = $db->recorrer($sql_activo);
//   if(!isset($_activo['IdActivo'])){
//     $sql_grad = $db->query("SELECT tblc_ciclogrupo.Grado, tblp_grupo.Dia FROM tblc_ciclogrupo LEFT JOIN tblp_grupo ON tblc_ciclogrupo.IdGrupo = tblp_grupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo = '63' AND tblc_ciclogrupo.IdGrupo = '".$_pag['IdGrupo']."' LIMIT 1");
//     $db->rows($sql_grad);
//     $_grad = $db->recorrer($sql_grad);
//     if(isset($_grad['Dia'])){
//         if($_grad['Dia'] == 'P'){
//         $horario = 'P';
//         $grado = '0';
//       } else {
//         $horario = '';
//         $grado = $_grad['Grado'];
//       }
//     } else {
//       $horario = '';
//       $grado = '0';
//     }
//      $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor, Horario, aut) VALUES ('".$_pag['IdGrupo']."', '63', '".$_pag['IdUsua']."', '$grado','R', '8', NOW(), '1', '$horario', '9')");
//   }
// }


?>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-cog"></i> Datos de acceso del alumno</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Usuario:</label>
        <div class="col-sm-8">
          <input class="form-control" disabled value="<?php echo $datos81['Usuario']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Correo institucional:</label>
        <div class="col-sm-8">
          <input class="form-control" name="txt_institucional" id="txt_institucional" value="<?php echo $datos81['Correo_institucional']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Correo personal:</label>
        <div class="col-sm-8">
          <input class="form-control" name="txt_correoxy" id="txt_correoxy" value="<?php echo $datos81['Correo']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Password:</label>
        <div class="col-sm-8">
          <input class="form-control" name="txt_passx" id="txt_passx" value="<?php echo $datos81['Code']; ?>">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="procesar_materia_id(<?php echo $IdUsua; ?>)" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
    </div>
  </form>
</div>

<script>
  function procesar_materia_id(IdUsua, IdCiclo) {
    var Institucional = document.getElementById("txt_institucional").value;
    var Correo = document.getElementById("txt_correoxy").value;
    var Password = document.getElementById("txt_passx").value;


    if (Password == "") {
      swal("Error al guardar", "Debe escribir la contraseña.", "error");
      document.getElementById("txt_passx").focus();
      return 0;
    }

    var TipoGuardar = "recuperar_cuenta_id";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de este alumno?",
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
              url: "vistas/escolar/guardar_datos_escolar.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                Institucional: Institucional,
                Correo: Correo,
                Password: Password,
                IdUsua: IdUsua
              },
              success: function(data) {}
            })
            .done(function(data) {
              if (data == 1) {
                swal("Actualizado correctamente", "Los datos de inicio de sesión del alumno se ha reiniciado correctamente.", "success");
                $.ajax({
                  url: "vistas/escolar/upd_datos_sesion.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua
                  },
                  success: function(data) {
                    $('#employee_detail_ssl').html(data);
                    $('#dataModal_ssl').modal('show');
                  }
                });
              } else {
                swal("Error al asignar", "No se ha podido asignar la materia a este alumno.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        }
      });
  }
</script>
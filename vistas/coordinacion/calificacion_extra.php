<?php
session_start();
require('../../php/clases/class.System.php');
require('../../hace.php');
$db = new Conexion();

$IdUsua = $_SESSION["IdUsua"];
$IdCalificacion = $_POST["IdCalificacion"];


$sql_matx = $db->query("SELECT
tblp_calificacion_cambios.IdCambio,
tblp_calificacion_cambios.PromedioAnterior,
tblp_calificacion_cambios.PromedioNuevo,
tblp_calificacion_cambios.Motivo,
tblp_calificacion_cambios.FecCap,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto
FROM
tblp_calificacion_cambios
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacion_cambios.IdUsua
WHERE tblp_calificacion_cambios.IdCalificacion = '$IdCalificacion'
ORDER BY
tblp_calificacion_cambios.FecCap ASC
 ");


$sql_cal = $db->query("SELECT
  tblp_modulo.CodeModulo,
  tblp_modulo.NombreMod,
  tblp_calificacion.IdCalificacion,
  tblp_calificacion.IdUsua,
  tblp_calificacion.Promedio,
  tblp_calificacion.Observacion
  FROM
  tblp_calificacion
  Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
  WHERE tblp_calificacion.IdCalificacion = '$IdCalificacion'");
$db->rows($sql_cal);
$_cal = $db->recorrer($sql_cal);
$_txt = "REGULAR";

if ($_cal['Observacion'] == 'R') {
  $_txt = "RECURSADO";
}
if ($_cal['Observacion'] == 'E') {
  $_txt = "EXTRAORDINARIO";
}

$IdUsua = $_cal['IdUsua'];





$sql_permiso = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$IdUsua' AND tblc_modulousuario.IdModulo = '67'");
$db->rows($sql_permiso);
$_perm = $db->recorrer($sql_permiso);

$sql_user = $db->query("SELECT tblc_usuario.IdUsua, tblp_grupo.TipoCiclo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua =  '$IdUsua'");
$db->rows($sql_user);
$_usc = $db->recorrer($sql_user);

if($_usc['TipoCiclo'] == 'C'){ $cicx = "CUATRIMESTRE"; }
if($_usc['TipoCiclo'] == 'S'){ $cicx = "SEMESTRE"; }
if($_usc['TipoCiclo'] == 'T'){ $cicx = "TRIMESTRE"; }

$sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$cicx' ORDER BY tblc_ciclo.FInicio DESC ");


?>
<form class="form-horizontal">
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-2 control-label">MATERIA:</label>
      <div class="col-sm-10">
        <input disabled type="text" class="form-control" value="<?php echo $_cal['CodeModulo'] . ' ' . $_cal['NombreMod']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">PROMEDIO ACTUAL:</label>
      <div class="col-sm-4">
        <input style="text-align: center;" disabled type="text" class="form-control" value="<?php echo $_cal['Promedio']; ?>">
      </div>
    </div>
    
    <?php // if(isset($_perm[0])){ ?>
    <div class="form-group">
      <label class="col-sm-8 control-label">NUEVO PROMEDIO:</label>
      <div class="col-sm-4">
        <input style="text-align: center;" type="text" class="form-control" name="txt_promedio" id="txt_promedio">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-5 control-label">PERIODO ESCOLAR EN QUE LO APROBÓ:</label>
      <div class="col-sm-7">
        <select name="txt_idCiclo" id="txt_idCiclo" class="form-control">
          <option value="">-Seleccione-</option>
          <?php while($cic = $db->recorrer($sql_ciclo)){ ?>
            <option value="<?php echo $cic['IdCiclo']; ?>"> <?php echo $cic['Ciclo']; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">EVIDENCIA (opcional):</label>
      <div class="col-sm-8">
        <input type="file" class="form-control" name="txt_evidencia" id="txt_evidencia">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">MOTIVO DEL CAMBIO:</label>
      <div class="col-sm-9">
        <textarea name="txt_motivo" id="txt_motivo" class="form-control" rows="3" placeholder="Motivo del cambio de promedio ..."></textarea>
      </div>
    </div>
    
    <?php //} ?>
  </div>
  <?php //if(isset($_perm[0])){ ?>
  <div class="box-footer">
    <button type="button" onclick="sav_calificacion_final_id('<?php echo $_cal['Promedio']; ?>',<?php echo $IdCalificacion; ?>,<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>)" class="btn bg-purple btn-flat pull-right"><i class="fa fa-fw fa-refresh"></i> Promedio Extraordinario</button>
  </div><?php //} ?>

  <div class="tab-pane active" id="timeline">

    <ul class="timeline timeline-inverse">
      <?php while($x = $db->recorrer($sql_matx)){ ?>
      <li class="time-label">
        <span class="bg-red">
          <?php echo obtenerFechaCorta($x['FecCap']); ?>
        </span>
      </li>
      <li>
        <i class="fa fa-user bg-blue"></i>
        <div class="timeline-item">
          <span class="time"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($x['FecCap']); ?></span>
          <h3 class="timeline-header"><a href="#"><?php echo $x['Nombre'].' '.$x['APaterno'].' '.$x['AMaterno']; ?></a></h3>
          <div class="timeline-body">
          <?php echo $x['Motivo']; ?>
          </div>
          <div class="timeline-footer">
            <a class="btn btn-primary btn-xs">Promedio anterior: <?php echo $x['PromedioAnterior']; ?></a>
            <a class="btn btn-danger btn-xs">Promedio guardado: <?php echo $x['PromedioNuevo']; ?></a>
          </div>
        </div>
      </li>
      <?php } ?>
      <li>
        <i class="fa fa-clock-o bg-gray"></i>
      </li>
    </ul>
  </div>

</form>

<script>
  function sav_calificacion_final_id(AnteriorPromedio, IdCalificacion, IdUsua, IdAdmin) {
    var Promedio = document.getElementById("txt_promedio").value;
    var IdCiclo = document.getElementById("txt_idCiclo").value;
    var Motivo = document.getElementById("txt_motivo").value;
    var Archivo = document.getElementById("txt_evidencia").value;
		var Imagen = '#txt_evidencia';


    if (Promedio == "") {
      swal("Error al guardar", "Debe indicar el promedio del alumno.", "error");
      document.getElementById("txt_promedio").focus();
      return 0;
    }
    if (IdCiclo == "") {
      swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
      document.getElementById("txt_idCiclo").focus();
      return 0;
    }
    if (Motivo == "") {
      swal("Error al guardar", "Debe indicar el motivo del cambio de la calificacion final.", "error");
      document.getElementById("txt_motivo").focus();
      return 0;
    }

    if ((Promedio == "5") || (Promedio == "6") || (Promedio == "7") || (Promedio == "8") || (Promedio == "9")) {

    } else {
      swal("Error al guardar", "El promedio del alumno debe ser: 5, 6, 7, 8, 9", "error");
      document.getElementById("txt_promedio").focus();
      document.getElementById("txt_promedio").value = '';
      return 0;
    }

		swal({
				title: "\u00BFEst\u00E1 seguro que desea actualizar la calificación de este alumno?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
				cancelButtonText: "Cancelar",
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');

					var formData = new FormData();
					var files = $(Imagen)[0].files[0];
					formData.append('AnteriorPromedio', AnteriorPromedio);
					formData.append('IdCalificacion', IdCalificacion);
					formData.append('IdUsua', IdUsua);
					formData.append('IdAdmin', IdAdmin);
					formData.append('Promedio', Promedio);
					formData.append('IdCiclo', IdCiclo);
					formData.append('Promedio', Promedio);
					formData.append('Motivo', Motivo);
					formData.append('file', files);

					$.ajax({
							url: 'vistas/upload/cambiar_calificacion_extra.php',
							type: 'post',
							data: formData,
							contentType: false,
							processData: false,
							success: function(response) {

              }
						})
						.done(function(response) {
							if (response == 1) {
								swal("Actualizado correctamente", "La calificación ha sido actualizado correctamente.", "success");
                cargar_kardex_alumno();
                $.ajax({
                  url: "vistas/coordinacion/calificacion_extra.php",
                  method: "POST",
                  data: {
                    IdCalificacion: IdCalificacion
                  },
                  success: function(data) {
                    $('#employee_extra').html(data);
                    $('#data_extra').modal('show');
                  }
                });
                
							} else {
								swal("Error al actualizar", "Ha ocurrido un error no se ha podido actualizar.", "error");
							}
						})
						.error(function(data) {
							swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
						});
				}
			});



  }
</script>
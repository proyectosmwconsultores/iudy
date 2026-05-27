<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdModulo = $_POST['IdModulo'];

$sql9 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo = '" . $_POST["IdModulo"] . "' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);

?>
<div class="box-body">
  <div class="form-group">
    <label>Objetivo general, propósito o finalidad del programa de estudios:</label>
    <textarea name="txt_contenido_4" id="txt_contenido_4" class="form-control" rows="4" placeholder="Enter ..."> <?php echo $datos91['Mod_4']; ?> </textarea>
    <div class="box-footer">
      <button type="button" onclick="save_objcontenido(4,<?php echo $IdModulo; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-fw fa-save"></i> Guardar</button>
    </div>
  </div>
  <div class="form-group">
    <label>Objetivo cognitivo conceptual:</label>
    <textarea name="txt_contenido_5" id="txt_contenido_5" class="form-control" rows="4" placeholder="Enter ..."> <?php echo $datos91['Mod_5']; ?> </textarea>
    <div class="box-footer">
      <button type="button" onclick="save_objcontenido(5,<?php echo $IdModulo; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-fw fa-save"></i> Guardar</button>
    </div>
  </div>
  <div class="form-group">
    <label>Objetivo procedimental:</label>
    <textarea name="txt_contenido_6" id="txt_contenido_6" class="form-control" rows="4" placeholder="Enter ..."> <?php echo $datos91['Mod_6']; ?> </textarea>
    <div class="box-footer">
      <button type="button" onclick="save_objcontenido(6,<?php echo $IdModulo; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-fw fa-save"></i> Guardar</button>
    </div>
  </div>
  <div class="form-group">
    <label>Objetivo actitudinal:</label>
    <textarea name="txt_contenido_7" id="txt_contenido_7" class="form-control" rows="4" placeholder="Enter ..."> <?php echo $datos91['Mod_7']; ?> </textarea>
    <div class="box-footer">
      <button type="button" onclick="save_objcontenido(7,<?php echo $IdModulo; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-fw fa-save"></i> Guardar</button>
    </div>
  </div>
</div>

<script>
 function save_objcontenido(Id_contenido, Modulo) {
	var Cont = "txt_contenido_" + Id_contenido;
	var Contenido = document.getElementById(Cont).value;
	
	if (Contenido == '') {
		swal("Error al guardar", "Debe escribir la informaci\u00F3n del objetivo.", "error");
		return 0;
	}

	var TipoGuardar = "add_con_carta";

	var datos = 'TipoGuardar=' + TipoGuardar + '&Contenido=' + Contenido + '&Modulo=' + Modulo + '&Id_contenido=' + Id_contenido;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Datos guardados correctamente.", "success");
				$.ajax({
				url: "vistas/docente/captura_objetivos.php",
				method: "POST",
				data: {
					IdModulo: Modulo
				},
				success: function(data) {
					$('#employee_detailObj').html(data);
					$('#dataModalObjetivo').modal('show');
				}
			});
			}

			if (data == 0) {
				swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
			}
		})

}
</script>
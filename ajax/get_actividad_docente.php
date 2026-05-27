<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];

require('../php/clases/class_aula.php');
require('../hace.php');
$aula = new Aula();

$idActividad = isset($_POST['idActividad']) ? trim($_POST['idActividad']) : '';
$id_actividad = addslashes($idActividad);


if (!isset($IdUsua)) {
	echo '
    <div class="block">
        <h4>Error de sesión</h4>
        <p>Estimado usuario debe iniciar sesión nuevamente.</p>
    </div>';
	exit;
}

if ($id_actividad == '') {
	echo '
    <div class="block">
        <h4>Error al mostrar datos</h4>
        <p>No se recibió el identificador de la actividad. Favor de ingresar nuevamente a la materia.</p>
    </div>';
	exit;
}

$actividad = $aula->get_actividad($id_actividad);
$docente = $aula->get_docente_id($actividad[0]['IdAsignacion']);
$materiales = $aula->get_material_id($id_actividad);


if (!isset($actividad[0])) {
	echo '
    <div class="block">
        <h4>Error</h4>
        <p>No se encontró la actividad solicitada.</p>
    </div>';
	exit;
}

$IdEstatus = $actividad[0]['IdEstatus'];

$iconos = [
	"Actividad" => "fa-upload",
	"Foro" => "fa-comments",
	"Examen en linea" => "fa-file-text",
	"Contenido" => "fa-check"
];

$icon = $iconos[$actividad[0]['TipoActividad']] ?? "fa-book";


?>
<input type="hidden" id="IdActividadesDocente" value="<?php echo $actividad[0]['IdActividadesDocente']; ?>">
<input type="hidden" id="IdAsignacion" value="<?php echo $actividad[0]['IdAsignacion']; ?>">
<input type="hidden" id="IdParcialDocente" value="<?php echo $actividad[0]['IdParcialDocente']; ?>">
<input type="hidden" id="IdParcial" value="<?php echo $actividad[0]['IdParcialDocente']; ?>">

<div id="viewActivity">
	<div class="activity-header">

		<div class="activity-main">
			<div class="activity-type">
				<!-- <i class="fa fa-comments"></i> -->
				<i class="fa <?php echo $icon; ?>"></i>
				<?php echo $actividad[0]['TipoActividad']; ?>
			</div>

			<h2 class="activity-title">
				<?php echo $actividad[0]['NomActividad']; ?>
			</h2>
		</div>

		<div class="activity-status <?php echo strtolower($actividad[0]['Estatus']); ?>">
			<?php echo $actividad[0]['Estatus']; ?>
		</div>

	</div>


	<div class="block">
		<h4><i class="fa fa-fw fa-edit"></i> Instrucciones</h4>
		<p id="actInstructions"><?php echo $actividad[0]['DesActividad']; ?></p>

		<div class="actions">
			<?php if (isset($actividad[0]['IdRubrica'])) { ?>
				<button class="btn ver" onclick="mi_rubrica(<?php echo $id_actividad; ?>)">
					<i class="fa fa-fw fa-check-circle-o"></i> Ver rúbrica
				</button>
			<?php } ?>
		</div>
	</div>

	<div class="block">
		<h4>
			<i class="fa fa-fw fa-check-circle"></i> Información de la actividad
		</h4>
		<div class="rightBox">
			<div class="kv"><span>Fecha de inicio:</span><b><?php echo obtenerSoloFecha($actividad[0]['FecIni']); ?></b></div>
			<div class="kv"><span>Fecha término:</span><b><?php echo obtenerSoloFecha($actividad[0]['FecFin']); ?></b></div>
			<div class="kv"><span>Porcentaje:</span><b><?php echo $actividad[0]['Porcentaje']; ?>%</b></div>
			<div class="kv"><span>Estado:</span><b id="actStateText"><?php echo $actividad[0]['Estatus']; ?></b></div>
		</div>
	</div>


	<?php if ($actividad[0]['IdTipoActividad'] == 1) { 
		
			$inicio = $actividad[0]['Ini'];
			$fin    = $actividad[0]['Fin'];
			$meses = [
				1 => 'enero',
				2 => 'febrero',
				3 => 'marzo',
				4 => 'abril',
				5 => 'mayo',
				6 => 'junio',
				7 => 'julio',
				8 => 'agosto',
				9 => 'septiembre',
				10 => 'octubre',
				11 => 'noviembre',
				12 => 'diciembre'
			];

			function formatFechaEs($fecha, $meses)
			{
				$dt = new DateTime($fecha);

				$dia   = $dt->format('d');
				$mes   = $meses[(int)$dt->format('m')];
				$hora  = $dt->format('h:i a'); // 12h con am/pm

				return "{$dia} de {$mes} {$hora}";
			}

			$txtIni = formatFechaEs($inicio, $meses);
			$txtFin = formatFechaEs($fin, $meses);
			$textoImprimir = "{$txtIni} hasta el {$txtFin}";

			$iniRaw = $actividad[0]['Ini'] ?? null;
			$finRaw = $actividad[0]['Fin'] ?? null;

			$dtIni = $iniRaw ? new DateTime($iniRaw) : null;
			$dtFin = $finRaw ? new DateTime($finRaw) : null;

			$iniTs = $dtIni ? $dtIni->getTimestamp() : 0;
			$finTs = $dtFin ? $dtFin->getTimestamp() : 0;
			$nowTs = time();


		?>
			<div class="block exam-inline-block">
				<h4>
					<i class="fa fa-fw fa-folder-open"></i>
					Examen en línea
				</h4>
				<div class="exam-inline-box">
					<div class="exam-inline-info">
						<div class="exam-inline-info-item highlight">
							<div class="exam-inline-info-icon">
								<i class="fa fa-clock-o"></i>
							</div>
							<div class="exam-inline-info-content">
								<strong>Duración de <?php echo $actividad[0]['Tiempo']; ?> minutos</strong>
								<span>Considera tu tiempo antes de iniciar.</span>
							</div>
						</div>
						<div class="exam-inline-info-item">
							<div class="exam-inline-info-icon">
								<i class="fa fa-calendar"></i>
							</div>
							<div class="exam-inline-info-content">
								<strong>Fecha disponible</strong>
								<span><?php echo $textoImprimir; ?></span>
							</div>
						</div>
					</div>
					<div class="exam-inline-guide">
						<h6>¿Cómo responder el examen?</h6>
						<ul>
							<li><i class="fa fa-book"></i> Lee cuidadosamente la pregunta.</li>
							<li><i class="fa fa-check-circle"></i> Selecciona la opción correcta.</li>
							<li><i class="fa fa-arrow-right"></i> Navega con Anterior y Siguiente.</li>
							<li><i class="fa fa-tag"></i> Marca preguntas para revisarlas después.</li>
							<li><i class="fa fa-clock-o"></i> Revisa tu progreso en la navegación.</li>
							<li><i class="fa fa-check-square-o"></i> Finaliza el examen cuando termines.</li>
						</ul>
					</div>
				</div>
			</div>


		
	<?php } ?>




	<?php if (!empty($materiales)) { ?>
		<div class="block">
			<h4>
				<i class="fa fa-fw fa-folder-open"></i> Mis materiales didácticos
			</h4>
			<div class="material-grid">
				<?php foreach ($materiales as $material) {
					$extension = !empty($material['Tipo'])
						? strtolower($material['Tipo'])
						: 'file';
					$nombre = !empty($material['Nombre'])
						? $material['Nombre']
						: 'Material sin nombre';
				?>
					<div class="material-card">
						<div class="material-thumb" onclick="verBiblioteca(<?php echo $material['IdBiblioteca'] ?>)">
							<?php if ($extension == 'pdf') { ?>
								<i class="fa fa-file-pdf-o"></i>
							<?php } elseif ($extension == 'doc' || $extension == 'docx') { ?>
								<i class="fa fa-file-word-o"></i>
							<?php } elseif ($extension == 'xls' || $extension == 'xlsx') { ?>
								<i class="fa fa-file-excel-o"></i>
							<?php } elseif ($extension == 'ppt' || $extension == 'pptx') { ?>
								<i class="fa fa-file-powerpoint-o"></i>
							<?php } elseif ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') { ?>
								<i class="fa fa-file-image-o"></i>
							<?php } else { ?>
								<i class="fa fa-file-o"></i>
							<?php } ?>
						</div>
						<div class="material-body">
							<div class="material-title"><?php echo htmlspecialchars($nombre); ?>
						</div>
						<div class="material-meta">
							<?php if (!empty($material['Tipo'])) { ?>
								<span><?php echo strtoupper($material['Tipo']); ?></span>
							<?php } ?>
							<?php if (!empty($material['Tipo']) && !empty($peso)) { ?>
								<span>•</span>
							<?php } ?>
						</div>

					</div>
			</div>
		<?php } ?>
		</div>
</div>
<?php } else { ?>
	<div class="block">
		<h4>
			<i class="fa fa-fw fa-folder-open"></i>
			Mis materiales didácticos
		</h4>
		<div class="empty-material">
			<i class="fa fa-folder-open-o"></i>
			<p>
				Aún no hay materiales didácticos disponibles para esta actividad.
			</p>
		</div>
	</div>
<?php } ?>








<?php if ($actividad[0]['IdTipoActividad'] == 2) {
	$comentarios = $aula->get_foro_comentarios($id_actividad);
?>

	<div class="block">
		<h4><i class="fa fa-fw fa-comments"></i> Foro de discusión</h4>
		<?php if ($IdEstatus == 8) { ?>
			<div class="foro-box">
				<textarea id="txtComentarioForo" placeholder="Escribe tu comentario..."></textarea>
				<div class="actions" style="margin-top:10px;">
					<button type="button" class="btn primario" id="btnComentarForo">
						<i class="fa fa-fw fa-send"></i> Publicar comentario
					</button>
				</div>
			</div><?php } ?>

		<div id="listaComentariosForo">
			<?php if (!empty($comentarios)) { ?>
				<?php foreach ($comentarios as $comentario) {
					$respuestas = $aula->get_foro_respuestas($comentario['IdComentario']);
				?>
					<div class="comentario-item">
						<div class="comentario-head">
							<strong><?php echo $comentario['Nombre']; ?> <?php echo $comentario['APaterno']; ?> <?php echo $comentario['AMaterno']; ?></strong>
							<span><?php echo fecha_lms($comentario['FecCap']); ?></span>
						</div>

						<div class="comentario-body">
							<?php echo nl2br($comentario['Comentario']); ?>
						</div>
						<?php if ($IdEstatus == 8) { ?>
							<div class="comentario-actions">
								<button class="btn-responder" data-id="<?php echo $comentario['IdComentario']; ?>">
									Responder
								</button>
							</div>

							<div class="respuesta-box" id="respuesta_<?php echo $comentario['IdComentario']; ?>" style="display:none;">
								<textarea id="txt_respuesta_<?php echo $comentario['IdComentario']; ?>" placeholder="Escribe una respuesta..."></textarea>
								<button type="button" class="btn-enviar-respuesta" data-id="<?php echo $comentario['IdComentario']; ?>">
									<i class="fa fa-fw fa-send"></i> Enviar respuesta
								</button>
							</div>
						<?php } ?>

						<div class="comentario-respuestas">
							<?php if (!empty($respuestas)) { ?>
								<?php foreach ($respuestas as $respuesta) { ?>
									<div class="comentario-item comentario-item-respuesta">
										<div class="comentario-head">
											<strong><?php echo $respuesta['Nombre']; ?> <?php echo $respuesta['APaterno']; ?> <?php echo $respuesta['AMaterno']; ?></strong>
											<span><?php echo fecha_lms($respuesta['FecCap']); ?></span>
										</div>

										<div class="comentario-body">
											<?php echo nl2br($respuesta['Comentario']); ?>
										</div>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			<?php } else { ?>
				<div class="block">
					<p>No hay comentarios todavía. Sé el primero en participar.</p>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>


</div>
<script>
	
	function recargarVistaActividad_id(idActividad) {
		$('#detalleActividad').html(
			'<div class="block"><p><i class="fa fa-spinner fa-spin"></i> Cargando actividad...</p></div>'
		);

		$.ajax({
			url: 'ajax/get_actividad_docente.php',
			type: 'POST',
			data: {
				idActividad: idActividad
			},
			success: function(respuesta) {
				$('#detalleActividad').html(respuesta);
			},
			error: function() {
				$('#detalleActividad').html(
					'<div class="block"><p>Error al cargar la actividad.</p></div>'
				);
			}
		});
	}



	// Evita que el evento se registre varias veces cuando se recarga get_actividad.php por AJAX
	$(document).off('click', '#btnComentarForo').on('click', '#btnComentarForo', function(e) {

		e.preventDefault();
		e.stopPropagation();

		var $btn = $(this);
		var comentario = $('#txtComentarioForo').val().trim();
		var idActividad = $('#IdActividadesDocente').val();
		var idAsignacion = $('#IdAsignacion').val();
		var idParcial = $('#IdParcialDocente').val();

		// Validación
		if (comentario === '') {

			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'Debes escribir un comentario.',
				confirmButtonText: 'Aceptar',
				confirmButtonColor: '#2563eb'
			});

			return;
		}

		// Evita doble clic
		if ($btn.prop('disabled')) {
			return;
		}

		$btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Publicando...');

		Swal.fire({
			title: 'Publicando comentario...',
			text: 'Por favor espera.',
			allowOutsideClick: false,
			allowEscapeKey: false,
			showConfirmButton: false,
			didOpen: () => {
				Swal.showLoading();
			}
		});

		$.ajax({
			url: 'ajax/guardar_comentario_foro.php',
			type: 'POST',
			dataType: 'json',
			data: {
				IdActividadesDocente: idActividad,
				IdAsignacion: idAsignacion,
				IdParcialDocente: idParcial,
				Comentario: comentario
			},

			success: function(respuesta) {

				Swal.close();

				$btn.prop('disabled', false)
					.html('<i class="fa fa-fw fa-send"></i> Publicar comentario');

				if (respuesta.ok) {

					$('#txtComentarioForo').val('');

					Swal.fire({
						icon: 'success',
						title: 'Comentario publicado',
						text: respuesta.msg,
						confirmButtonText: 'Aceptar',
						confirmButtonColor: '#2563eb',
						allowOutsideClick: false,
						allowEscapeKey: false
					}).then(() => {

						// recargar la actividad para ver el comentario nuevo
						recargarVistaActividad_id(idActividad);

					});

				} else {

					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: respuesta.msg,
						confirmButtonText: 'Aceptar',
						confirmButtonColor: '#2563eb'
					});

				}
			},

			error: function() {

				Swal.close();

				$btn.prop('disabled', false)
					.html('<i class="fa fa-fw fa-send"></i> Publicar comentario');

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'No se pudo guardar el comentario.',
					confirmButtonText: 'Aceptar',
					confirmButtonColor: '#2563eb'
				});

			}

		});

	});

	$(document).off('click', '.btn-responder').on('click', '.btn-responder', function(e) {
		e.preventDefault();
		e.stopPropagation();

		var idComentario = $(this).data('id');
		var caja = $('#respuesta_' + idComentario);

		if (caja.length) {
			$('.respuesta-box').not(caja).slideUp(200);
			caja.slideToggle(200);
		}
	});


	$(document).off('click', '.btn-enviar-respuesta').on('click', '.btn-enviar-respuesta', function(e) {
		e.preventDefault();
		e.stopPropagation();

		var $btn = $(this);
		var idComentarioPadre = $btn.attr('data-id');
		var respuesta = $('#txt_respuesta_' + idComentarioPadre).val().trim();

		var idActividad = $('#IdActividadesDocente').val();
		var idAsignacion = $('#IdAsignacion').val();
		var idParcial = $('#IdParcialDocente').val();

		if (respuesta === '') {
			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'Debes escribir una respuesta.',
				confirmButtonText: 'Aceptar',
				confirmButtonColor: '#2563eb'
			});
			return;
		}

		if ($btn.prop('disabled')) {
			return;
		}

		$btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Enviando...');

		Swal.fire({
			title: 'Publicando respuesta...',
			text: 'Por favor espera.',
			allowOutsideClick: false,
			allowEscapeKey: false,
			showConfirmButton: false,
			didOpen: () => {
				Swal.showLoading();
			}
		});

		$.ajax({
			url: 'ajax/guardar_respuesta_foro.php',
			type: 'POST',
			dataType: 'json',
			data: {
				IdActividadesDocente: idActividad,
				IdAsignacion: idAsignacion,
				IdParcialDocente: idParcial,
				IdComentarioPadre: idComentarioPadre,
				Comentario: respuesta
			},
			success: function(respuestaAjax) {
				Swal.close();

				$btn.prop('disabled', false).html('Enviar respuesta');

				if (respuestaAjax.ok) {
					Swal.fire({
						icon: 'success',
						title: 'Respuesta publicada',
						text: respuestaAjax.msg,
						confirmButtonText: 'Aceptar',
						confirmButtonColor: '#2563eb'
					}).then(() => {
						recargarVistaActividad_id(idActividad);
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: respuestaAjax.msg,
						confirmButtonText: 'Aceptar',
						confirmButtonColor: '#2563eb'
					});
				}
			},
			error: function(xhr, status, error) {
				Swal.close();

				$btn.prop('disabled', false).html('Enviar respuesta');

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'No se pudo guardar la respuesta.',
					confirmButtonText: 'Aceptar',
					confirmButtonColor: '#2563eb'
				});
			}
		});
	});
</script>

<script>
	(() => {
		const el = document.getElementById('examAvailability');
		if (!el) return;

		const ini = Number(el.dataset.ini || 0) * 1000;
		const fin = Number(el.dataset.fin || 0) * 1000;
		const nowServer = Number(el.dataset.now || 0) * 1000;

		const btnExam = document.getElementById('btnExamDone2');
		const msgExam = document.getElementById('btnExamDone');

		if (!btnExam && !msgExam) return;

		const clientStart = Date.now();

		function getServerLikeNow() {
			return nowServer + (Date.now() - clientStart);
		}

		function setState(state) {
			if (btnExam) {
				btnExam.disabled = false;
				btnExam.style.display = 'inline-flex';
				btnExam.classList.remove('is-disabled');
			}

			if (msgExam) {
				msgExam.style.display = 'none';
				msgExam.innerHTML = '';
				msgExam.style.color = '';
				msgExam.style.fontWeight = '700';
			}

			if (state === 'open') {
				if (btnExam) {
					btnExam.disabled = false;
					btnExam.style.display = 'inline-flex';
				}
			}

			if (state === 'before') {
				if (btnExam) {
					btnExam.disabled = true;
					btnExam.style.display = 'none';
				}

				if (msgExam) {
					msgExam.style.display = 'block';
					msgExam.style.color = '#b45309';
					msgExam.innerHTML = '<i class="fa fa-clock-o"></i> El examen aún no está disponible';
				}
			}

			if (state === 'after') {
				if (btnExam) {
					btnExam.disabled = true;
					btnExam.style.display = 'none';
				}

				if (msgExam) {
					msgExam.style.display = 'block';
					msgExam.style.color = '#dc2626';
					msgExam.innerHTML = '<i class="fa fa-warning"></i> Evaluación finalizada';
				}
			}
		}

		function tick() {
			const now = getServerLikeNow();

			if (ini > 0 && now < ini) {
				setState('before');
				return;
			}

			if (fin > 0 && now > fin) {
				setState('after');
				return;
			}

			setState('open');
		}

		tick();
		setInterval(tick, 1000);
	})();
</script>
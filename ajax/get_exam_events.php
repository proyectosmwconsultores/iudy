<?php
session_start();

require('../php/clases/class.System.php');
$db = new Conexion();

$IdUsua = isset($_POST['IdUsua']) ? (int)$_POST['IdUsua'] : 0;
$IdTarea = isset($_POST['IdTarea']) ? (int)$_POST['IdTarea'] : 0;
$IdAsignacion = $_POST['IdAsignacion'];

if (!$IdUsua || !$IdAsignacion) {
	echo '
    <div class="alert alert-warning" style="margin:0;">
        Datos incompletos para consultar los eventos del examen.
    </div>';
	exit;
}
$sql = "SELECT id, session_id, event_type, event_detail, ip, user_agent, created_at FROM tblp_exam_events WHERE IdUsua = '$IdUsua' AND IdTarea = '$IdTarea' AND IdAsignacion = '$IdAsignacion' ORDER BY created_at DESC, id DESC ";
$res = $db->query($sql);
$rows = [];
if ($res) {
	while ($r = $db->recorrer($res)) {
		$rows[] = $r;
	}
}
?>
<style>
	.exam-events-wrap {
		font-family: Arial, sans-serif;
	}

	.exam-events-head {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 15px;
		padding-bottom: 10px;
		border-bottom: 1px solid #e5e5e5;
	}

	.exam-events-head h4 {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
		color: #1f2d3d;
	}

	.exam-events-count {
		font-size: 13px;
		color: #666;
		background: #f7f7f7;
		padding: 8px 12px;
		border-radius: 8px;
	}

	.exam-events-empty {
		padding: 25px;
		text-align: center;
		background: #fafafa;
		border: 1px dashed #ddd;
		border-radius: 10px;
		color: #666;
	}

	.exam-events-table thead th {
		background: #f4f6f9;
		color: #333;
		font-size: 13px;
		text-transform: uppercase;
		vertical-align: middle;
	}

	.exam-events-table tbody td {
		vertical-align: top;
		font-size: 13px;
	}

	.badge {
		padding: 6px 10px;
		border-radius: 12px;
		font-size: 11px;
		font-weight: 600;
	}

	.badge-danger {
		background: #d9534f;
		color: #fff;
	}

	.badge-success {
		background: #5cb85c;
		color: #fff;
	}

	.badge-warning {
		background: #f0ad4e;
		color: #fff;
	}

	.badge-default {
		background: #777;
		color: #fff;
	}
</style>
<div class="exam-events-wrap">
	<div class="exam-events-head">
		<h4><i class="fa fa-shield"></i> Bitácora de eventos del examen</h4>
		<div class="exam-events-count">
			Total de eventos: <b><?php echo count($rows); ?></b>
		</div>
	</div>

	<?php if (empty($rows)) { ?>
		<div class="exam-events-empty">
			<i class="fa fa-info-circle"></i>
			No se encontraron eventos registrados para este alumno en esta asignación.
		</div>
	<?php } else { ?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover exam-events-table" style="font-size: 12px;">
				<thead>
					<tr style="font-size: 12px;">
						<th style="width:50px;">#</th>
						<th style="width:140px;">Fecha</th>
						<th style="width:130px;">Tipo</th>
						<th>Detalle</th>
						<th style="width:130px;">IP</th>
					</tr>
				</thead>
				<tbody>
					<?php $n = 1; ?>
					<?php foreach ($rows as $row) { ?>
						<tr>
							<td><?php echo $n++; ?></td>
							<td><?php echo htmlspecialchars($row['created_at']); ?></td>
							<td>
								<?php
								$tipo = trim($row['event_type']);
								$badgeClass = 'badge-default';

								if ($tipo == 'blur' || $tipo == 'visibility_hidden' || $tipo == 'tab_change') {
									$badgeClass = 'badge-danger';
								} elseif ($tipo == 'focus' || $tipo == 'visibility_visible') {
									$badgeClass = 'badge-success';
								} elseif ($tipo == 'fullscreen_exit') {
									$badgeClass = 'badge-warning';
								}
								?>
								<span class="badge <?php echo $badgeClass; ?>">
									<?php echo htmlspecialchars($tipo); ?>
								</span>
							</td>
							<td>
								<div><b>Detalle:</b> <?php echo nl2br(htmlspecialchars($row['event_detail'])); ?></div>
								<div style="margin-top:4px; font-size:12px; color:#777;">
									<b>User Agent:</b> <?php echo htmlspecialchars($row['user_agent']); ?>
								</div>
							</td>
							<td><?php echo htmlspecialchars($row['ip']); ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } ?>
</div>
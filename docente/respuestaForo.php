<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdForo = $_POST['IdForo'];

  $sql_foro = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Mensaje, tblp_foro.FecCap, tblp_foro.Total, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdForo =  '$IdForo'");
  $db->rows($sql_foro);
  $foro = $db->recorrer($sql_foro);

  $sql_det = $db->query("SELECT
tblp_foro_detalle.IdForoDetalle,
tblp_foro_detalle.IdForo,
tblp_foro_detalle.Mensaje,
tblp_foro_detalle.IdUsua,
tblp_foro_detalle.FecCap,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto
FROM
tblp_foro_detalle
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro_detalle.IdUsua
WHERE
tblp_foro_detalle.IdForo =  '$IdForo' ORDER BY
tblp_foro_detalle.FecCap ASC
");

  function obtFecha($fecha){
      $num = date("j", strtotime($fecha));
      $anno = date("Y", strtotime($fecha));
      $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
      $mes = $mes[(date('m', strtotime($fecha))*1)-1];
      return $num.' '.$mes;
    }
  ?>

  <div class="box box-widget">
    <div class="box-header with-border">
      <div class="user-block">
        <img class="img-circle" src="assets/perfil/<?php echo $foro["Foto"]; ?>" alt="User Image">
        <span class="username"><a href="#"><?php echo $foro["Nombre"].' '.$foro["APaterno"].' '.$foro["AMaterno"]; ?></a></span>
        <span class="description">Publicado el <?php echo obtFecha($foro['FecCap']).' '.substr($foro['FecCap'], 11,8); ?></span>
      </div>
    </div>
    <div class="box-body" style="text-alig: justify;">
      <?php echo $foro["Mensaje"]; ?>
      <span class="pull-right text-muted"><?php echo $foro["Total"]; ?> comentarios</span>
    </div>
  </div>

<?php while($foro = $db->recorrer($sql_det)){ $noF = 1; ?>
  <div class="direct-chat-msg">
    <div class="direct-chat-info clearfix">
      <span class="direct-chat-name pull-left" style="font-size: 11px;"><?php echo $foro['Nombre'].' '.$foro['APaterno'].' '.$foro['AMaterno']; ?></span>
      <span class="direct-chat-timestamp pull-right" style="font-size: 11px;"><?php echo obtFecha($foro['FecCap']).' '.substr($foro['FecCap'], 11,8); ?></span>
    </div>
    <img class="direct-chat-img" src="assets/perfil/<?php echo $foro['Foto']; ?>" alt="Message User Image"><!-- /.direct-chat-img -->
    <div class="direct-chat-text" style="font-size: 12px;">
      <?php echo $foro['Mensaje']; ?>
    </div>
  </div>
<?php } ?>
<div class="box-footer">
  <form action="#" method="post">
    <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>">
    <img class="img-responsive img-circle img-sm" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="Alt Text">
    <div class="img-push">
      <div class="input-group input-group-sm">
                <input name="txt_Msj" id="txt_Msj" type="text" class="form-control" placeholder="Escriba su comentario">
                    <span class="input-group-btn">
                      <button onclick="saveMsj(<?php echo $IdForo; ?>)" type="button" class="btn btn-info btn-flat">Guardar</button>
                    </span>
              </div>
    </div>
  </form>
</div>

<script>
function saveMsj(IdForo){
  var Msj = document.getElementById("txt_Msj").value;
  var IdUsua = document.getElementById("IdUsua").value;

  if (Msj==""){
	   swal("Error al guardar", "Debe escribir su comentario.", "error");
      document.getElementById("txt_Msj").focus();
      return 0;
  }

  var TipoGuardar = "addComent";
  swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este comentario?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');
			var datos = 'TipoGuardar=' + TipoGuardar + '&IdForo=' + IdForo + '&Msj=' + Msj + '&IdUsua=' + IdUsua;
			$.ajax({
				type:"POST",
				url:"docente/setting.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "El comentario se ha guardado correctamente.", "success");
          $.ajax({
    					 url:"docente/respuestaForo.php",
    					 method:"POST",
    					 data:{IdForo:IdForo},
    					 success:function(data){
    								$('#employee_eva').html(data);
    								$('#dataEva').modal('show');
    					 }
    			});
				}
				if(data==0){
					swal("Error al guardar", "No se puede guardar el comentario.", "error");
				}
			})
			.error(function(data) {
				swal("Error al agregar 0x136", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}
	});


}
</script>

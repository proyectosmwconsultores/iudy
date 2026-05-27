<?php
session_start();
require('../php/clases/class.System.php');
require('../hace.php');
  $db = new Conexion();
  $_IdUs = $_SESSION['IdUsua'];

  $time = 3;
  // Capturamos el tiempo de la conexión
  $date = time();
  // Captura de la IP de conexion

  // Tiempo de espera
  $limite = $date-$time*60;
  // Si supera los 3 minutos borramos de la base de datos la conexion
  $sql = $db->query("DELETE FROM tblc_usuarios_online WHERE tblc_usuarios_online.date < $limite");

  $sql_online = $db->query("SELECT tblc_usuarios_online.id, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Foto, tblc_usuarios_online.fec_cap FROM tblc_usuarios_online Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_usuarios_online.id_usua ORDER BY tblc_usuarios_online.fec_cap DESC ");

  ?>
  <form name="frm22" id="frm22" action="updCalificacion.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <button onclick="cargar_ventana()" type="button" class="btn btn-block btn-primary btn-sm"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
    <table class="table table-striped" style='font-size: 12px;'>
      <tbody><tr>
        <th style="width: 10px">#</th>
        <th>Foto</th>
        <th>Nombre del usuario</th>
        <th>Tipo de usuario</th>
        <th>Hace</th>
      </tr>
      <?php $v = 0;  while($xy = $db->recorrer($sql_online)){ $v = ($v + 1) ?>
      <tr>
        <td><?php echo $v; ?>.- </td>
        <td><img src="assets/perfil/<?php echo $xy['Foto']; ?>" class="img-circle" style="width: 25px; height:25px;"></td>
        <td><?php echo $xy['Nombre'].' '.$xy['APaterno'].' '.$xy['AMaterno']; ?></td>
        <td><?php echo $xy['Cargo']; ?></td>
        <td><?php echo tiempo_transcurrido($xy['fec_cap']); ?></td>

      </tr><?php } ?>
    </tbody></table>
</form>

<script>

  function cargar_ventana(){
    $.ajax({
		 url:"formConsulta/lst_user_online.php",
		 method:"POST",
		 data:{},
		 success:function(data){
			$('#employee_online').html(data);
			$('#dataOnline').modal('show');
		 }
	});
  }

  function aprobadoDocs(IdDocumento,IdUsua){
    var TipoGuardar = "visto_rec_pag";

    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdDocumento:IdDocumento},
         success:function(data){
           parent.location.href='perfil.php?token=1632756458'+IdUsua; //direcciona la pagina madre
         }
    })
  }

</script>

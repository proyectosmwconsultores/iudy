<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
   $miUs = $_SESSION['IdUsua'];
    $IdUsuaEnvia = $_POST["IdUsuaEnvia"];

    $IdUsuaRecibe = $_POST["IdUsuaRecibe"];


 $IdUnico = ($IdUsuaEnvia * $IdUsuaRecibe);

  $sql_upd = $db->query("UPDATE tblp_buzon SET tblp_buzon.Visto = '0' WHERE tblp_buzon.IdUsuaRecibe = '$miUs' AND tblp_buzon.IdUsuaEnvia = '$IdUsuaRecibe'");

  $sql1 = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblc_usuario.Cargo, tblc_campus.Campus FROM tblc_usuario Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.IdUsua = '$IdUsuaRecibe'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);

  $sql2 = $db->query("SELECT
tblp_buzon.IdBuzon,
tblp_buzon.IdUsua,
tblp_buzon.Mensaje,
tblp_buzon.FecCap,
tblp_buzon.IdUnico,
tblp_buzon.Archivo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Cargo,
tblc_usuario.Foto
FROM
tblp_buzon
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_buzon.IdUsua WHERE tblp_buzon.IdUnico = '$IdUnico' ");

  ?>
  <ul class="products-list product-list-in-box" style="padding: 5px;">
    <li class="item">
      <div class="product-img">
        <img src="assets/perfil/<?php echo $datos11['Foto']; ?>" alt="Image">
      </div>
      <div class="product-info">
        <a href="javascript:void(0)" class="product-title"><?php echo $datos11['Nombre'].' '.$datos11['APaterno'].' '.$datos11['AMaterno']; ?></a>
        <span class="product-description" style="text-transform: capitalize;"><b style="color: #282828;">Usuario:</b> <?php echo $datos11['Cargo']; ?> <b  style="color: #282828;"> Campus:</b> <?php echo $datos11['Campus']; ?></span>
      </div>
    </li>
  </ul>

  <div class="direct-chat-messages">
    <?php $msj = 0; while($x = $db->recorrer($sql2)){ $msj = 1;
      if($x['IdUsua'] == $IdUsuaEnvia){ ?>
      <div class="direct-chat-msg right">

        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-right"><?php echo $x['Nombre'].' '.$x['APaterno'].' '.$x['AMaterno'].' ('.$x['Cargo'].')'; ?></span>
          <span class="direct-chat-timestamp pull-left"><?php echo $x['FecCap']; ?></span>
        </div>
        <img class="direct-chat-img" src="assets/perfil/<?php echo $x['Foto']; ?>" alt="Image">

        <div class="direct-chat-text">
          <?php if(isset($x['Archivo'])){ $fil = $x['Archivo']; echo "<a style='color: #060109;' href='assets/docs/adjunto/2021/$fil' target='_blank'><i class='fa fa-fw fa-file'></i> ".$x['Mensaje'].'</a>'; } else { echo $x['Mensaje']; } ?>
        </div>
      </div>


  <?php } else { ?>

    <div class="direct-chat-msg">
      <div class="direct-chat-info clearfix">
        <span class="direct-chat-name pull-left"><?php echo $x['Nombre'].' '.$x['APaterno'].' '.$x['AMaterno'].' ('.$x['Cargo'].')'; ?></span>
        <span class="direct-chat-timestamp pull-right"><?php echo $x['FecCap']; ?></span>
      </div>
      <img class="direct-chat-img" src="assets/perfil/<?php echo $x['Foto']; ?>" alt="Image"><!-- /.direct-chat-img -->
      <div class="direct-chat-text">
        <?php if(isset($x['Archivo'])){ $fil = $x['Archivo']; echo "<a style='color: #060109;' href='assets/docs/adjunto/2021/$fil' target='_blank'><i class='fa fa-fw fa-file'></i> ".$x['Mensaje'].'</a>'; } else { echo $x['Mensaje']; } ?>
      </div>
    </div>
  <?php }   } ?>

  <?php if($msj == 0){ ?>
    <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info-circle"></i> Bienvenido</h4>
                No tienes ningun mensaje con este usuario. Puedes enviar cualquier pregunta que puedas tener.
                Solamente escribe y luego le das enviar para comenzar una conversación.
              </div>
  <?php } ?>


  </div>
  <div class="box-footer">
    <form action="#" method="post">
      <input id="miUsua" name="miUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
      <input id="IdUsuaEnvia" name="IdUsuaEnvia" value="<?php echo $IdUsuaEnvia; ?>" type="hidden"/>
      <input id="IdUsuaRecibe" name="IdUsuaRecibe" value="<?php echo $IdUsuaRecibe; ?>" type="hidden"/>
      <div class="form-group">
        <textarea class="form-control" rows="3" name="txtComentario" id="txtComentario" placeholder="Escriba su comentario ..."></textarea>
      </div>
      <div class="box-footer">
        <button onclick="enviarComentario()" type="button" class="btn btn-info pull-right"><i class="fa fa-fw fa-send"></i> Enviar</button>
        <button onclick="addRecurso()" title="Adjuntar archivo" type="button" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-fw fa-paperclip"></i> Adjuntar</button>
      </div>
    </form>
  </div>
<script>
// document.getElementById('btn_msj').style.display = 'none';

  function enviarComentario(){
    var miUsua = document.getElementById("miUsua").value;
    var IdUsuaEnvia = document.getElementById("IdUsuaEnvia").value;
    var IdUsuaRecibe = document.getElementById("IdUsuaRecibe").value;
    var Comentario = document.getElementById("txtComentario").value;

    if (Comentario==''){
		swal("Error al guardar", "Debe escribir su mensaje que desea enviar.", "error");
        document.getElementById("txtComentario").focus();
        return 0;
    }

      var TipoGuardar = "add_comentario";
          swal({
        		title: "\u00BFEst\u00E1 seguro que desea enviar este comentario a este usuario?",
        		type: "warning",
        		showCancelButton: true,
        		confirmButtonColor: '#DD6B55',
        		confirmButtonText: 'Aceptar',
        		cancelButtonText: "Cancelar",
        	},
        	function (isConfirm) {
        		if (isConfirm) {
        			$(".confirm").attr('disabled', 'disabled');

              $.ajax({
                   url:"formConsulta/setting.php",
                   method:"POST",
                   data:{TipoGuardar:TipoGuardar, IdUsuaEnvia:miUsua, IdUsuaRecibe:IdUsuaRecibe, Comentario:Comentario},
                   success:function(data){
                     listaReciente(miUsua);
                     cargarComen(IdUsuaEnvia,IdUsuaRecibe);
                   }
              })

        		}

        	});

  }
</script>

<?php
  session_start();
  require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();

  $sql_list = $db->query("SELECT tblh_detallepagos.IdDetallePagos, tblh_detallepagos.IdUsua, tblh_detallepagos.IdPago, tblh_detallepagos.Archivo, tblh_detallepagos.FecCap, tblh_detallepagos.Formato, tblh_detallepagos.Comentario, tblh_detallepagos.Anio, tblh_detallepagos.Mes, tblh_detallepagos.Tipo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblc_usuario.Cargo FROM tblh_detallepagos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_detallepagos.IdUsua WHERE tblh_detallepagos.IdPago = '".$_POST['IdPago']."'  ORDER BY tblh_detallepagos.FecCap ASC ");

  ?>
    <div class="box-body">
      <input type="hidden" name="tipo" id="tipo" value="<?php echo $_POST['Tipo']; ?>">
      <div class="direct-chat-messages">
      <?php $_val1 = ''; $_val2 = ''; $_val3 = '';
      while($_list = $db->recorrer($sql_list)){
        $tix = $_list['Tipo'];
        $formt = $_list['Formato'];
        if($tix == 2){ $_val1 = ''; $_val2 = 'left'; $_val3 = 'right';  } else { $_val1 = 'right'; $_val2 = 'right'; $_val3 = 'left'; }
        ?>
        <div class="direct-chat-msg <?php echo $_val1; ?>">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name pull-<?php echo $_val2; ?>"><?php echo $_list['Nombre'].' '.$_list['APaterno']; ?> / <?php echo $_list['Cargo']; ?></span>
            <span class="direct-chat-timestamp pull-<?php echo $_val3; ?>">
              <?php echo fecha_pago($_list['FecCap']).' ';
              $dateString = $_list['FecCap'];
              $dateObject = new DateTime($dateString);
              echo $dateObject->format('h:i a');?>
            </span>
          </div>
          <img class="direct-chat-img" src="assets/perfil/<?php echo $_list['Foto']; ?>" alt="message user image">
          <div class="direct-chat-text">
            <?php echo $_list['Comentario']; ?>
            <?php if($formt){ $icono = "cloud";
              if(($formt == 'png') || ($formt == 'jpg') || ($formt == 'jpeg')){ $icono = "camera"; }
              if($formt == 'pdf'){ $icono = "file-pdf-o"; }
              if(($formt == 'docx') || ($formt == 'doc')){ $icono = "file-word-o"; }
               ?>
            <br>
            <div class="mailbox-attachment-info">
              <a onClick="window.open('assets/docs/comprobantes/<?php echo $_list['Anio']; ?>/<?php echo $_list['Mes']; ?>/<?php echo $_list['Archivo']; ?>','_blank')" href="javascript:void(0);" class="mailbox-attachment-name"><i class="fa fa-<?php echo $icono; ?>"></i> <?php echo $_list['Archivo']; ?></a>
            </div><?php } ?>
          </div>

        </div>
      <?php } ?>
      </div>
  </div>

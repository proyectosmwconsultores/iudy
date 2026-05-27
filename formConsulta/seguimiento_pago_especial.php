<?php
  session_start();
  require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();
  $IdPago = $_POST['IdPago'];
  $TipoPago = $_POST['TipoPago'];

  $sql_list = $db->query("SELECT tblh_detallepagos.IdDetallePagos, tblh_detallepagos.IdUsua, tblh_detallepagos.IdPago, tblh_detallepagos.Archivo, tblh_detallepagos.FecCap, tblh_detallepagos.Formato, tblh_detallepagos.Comentario, tblh_detallepagos.Anio, tblh_detallepagos.Mes, tblh_detallepagos.Tipo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblc_usuario.Cargo FROM tblh_detallepagos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_detallepagos.IdUsua WHERE tblh_detallepagos.IdPago = '".$_POST['IdPago']."' AND tblh_detallepagos.TipoPago = '".$_POST['TipoPago']."' ORDER BY tblh_detallepagos.FecCap ASC ");

  $sql9 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '".$_SESSION['IdUsua']."' AND tblc_modulousuario.IdModulo = '57'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdModUsua = $datos91['IdModUsua'];

  $sql_pagx = $db->query("SELECT tblp_pagos.IdUsua FROM tblp_pagos WHERE tblp_pagos.IdPago = '$IdPago'");
  $db->rows($sql_pagx);
  $_user = $db->recorrer($sql_pagx);
  $IdUsua = $_user['IdUsua'];


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
            </div>

          <?php } ?>
          <?php if(isset($IdModUsua)){ ?>
          <div class="direct-chat-info clearfix">
            <span onclick="del_comen_pag(<?php echo $IdPago.','.$TipoPago.','.$_list['IdDetallePagos'];?>)" class="direct-chat-name pull-left" style="color: blue; cursor: pointer;"><i class="fa fa-fw fa-trash"></i> Eliminar comentario</span>
          </div><?php } ?>
          </div>


        </div>
      <?php } ?>
      </div>

  <form role="form">
  <div class="form-group">
  <label>Archivo del comprobante:</label>
  <input onchange="validar_file(this,'txt_file');" name="txt_file" id="txt_file" type="file" class="form-control" placeholder="Enter ...">
  </div>

  <div class="form-group">
  <label>Comentario adicional:</label>
  <textarea name="txt_comentario" id="txt_comentario" class="form-control" rows="3" placeholder="Escriba un comentario a cerca de su comprobante de pago ..."></textarea>
  </div>


  <div class="box-footer">
  <button type="button" onclick="save_comprobante_id(<?php echo $_POST['IdPago']; ?>,<?php echo $IdUsua; ?>,<?php echo $_POST['TipoPago']; ?>)" class="btn btn-primary pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
  </div>
  </form>

  </div>





<script>
  function save_comprobante_id(IdPago,IdUsua,TipoPago){
    var Tipo = document.getElementById("tipo").value;
    var Archivo = document.getElementById("txt_file").value;
    var Comentario = document.getElementById("txt_comentario").value;
    var Imagen = '#txt_file';
    // if(Tipo == 2){
    //   if (Archivo==""){
    //       swal("Error al guardar", "Debe seleccionar el archivo.", "error");
    //       document.getElementById("txt_file").focus();
    //       return 0;
    //   }
    // }
    if (Comentario==""){
        swal("Error al guardar", "Debe escribir un comentario.", "error");
        document.getElementById("txt_comentario").focus();
        return 0;
    }
    var TipoGuardar = "solDocss";

      swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar estos datos?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function (isConfirm) {
        if(isConfirm) {
  			$(".confirm").attr('disabled', 'disabled');

        var formData = new FormData();
        var files = $(Imagen)[0].files[0];
        formData.append('Tipo',Tipo);
        formData.append('Comentario',Comentario);
        formData.append('IdUsua',IdUsua);
        formData.append('IdPago',IdPago);
        formData.append('TipoPago',TipoPago);

        formData.append('file',files);

        $.ajax({
            url: 'upload_comprobante.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {

            }
        }) 
        .done(function(response) {
          if(response==1){
            swal("Guardado correctamente", "El seguimiento respecto a este pago se ha guardado correctamente.", "success");

            $.ajax({
                 url:"formConsulta/seguimiento_pago.php",
                 method:"POST",
                 data:{IdPago:IdPago, Tipo:Tipo, TipoPago:TipoPago},
                 success:function(data){
                      $('#employee_pag').html(data);
                      $('#data_pag').modal('show');
                 }
            });
          }else{
            swal("Error al guardar", "No se puede guardar los datos.", "error");
          }
        })
        .error(function(data) {
          swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
        });


  		}
      });
  }

  function del_comen_pag(IdPago, TipoPago, IdDetallePagos){
    var TipoGuardar = "eliminar_pago_id";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea eliminar este comentario?",
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
             data:{TipoGuardar:TipoGuardar, IdDetallePagos:IdDetallePagos, IdPago:IdPago},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Eliminado correctamente", "El comentario se ha elimininado correctamente.", "success");
            var Tipo = 1;
            $.ajax({
                 url:"formConsulta/seguimiento_pago.php",
                 method:"POST",
                 data:{IdPago:IdPago, Tipo:Tipo, TipoPago:TipoPago},
                 success:function(data){
                      $('#employee_pag').html(data);
                      $('#data_pag').modal('show');
                 }
            });

          }

          if(data==0){
            swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
          }
        })
        .error(function(data) {
          swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
        });
      }

    });
  }

</script>

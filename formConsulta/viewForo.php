<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdAsignacion = $_POST["IdAsignacion"];
  $IdActividad = $_POST["IdActividad"];

  $sql1 = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.NomActividad FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion =  '$IdAsignacion' AND tblp_actividadesdocente.IdTipoActividad =  '2'");


  ?>
  <form name="frm5hb" id="frm5hb" action="materiaAvance.php" method="POST" enctype="multipart/form-data">
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAsignacion; ?>" type="hidden"/>
    <div class="box-body">
      <?php while($x = $db->recorrer($sql1)){ ?>
      <a onclick="cargarForoId(<?php echo $x['IdActividadesDocente']; ?>)" class="btn btn-block btn-social <?php if($IdActividad == $x['IdActividadesDocente']){ echo 'btn-twitter'; } else { echo 'btn-bitbucket'; } ?>">
        <i class="fa fa-wechat"></i> <?php echo $x['NomActividad']; ?>
      </a>
      <?php } ?>
    </div>
    <?php
    if($IdActividad){
      $sql_foro = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Mensaje, tblp_foro.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdActividad =  '$IdActividad' ORDER BY tblp_foro.FecCap DESC");
    ?>
    <div class="box-footer box-comments">
      <?php while($y = $db->recorrer($sql_foro)){ ?>
              <div class="box-comment">
                <img class="img-circle img-sm" src="assets/perfil/<?php echo $y['Foto']; ?>" alt="User Image">

                <div class="comment-text">
                      <span class="username">
                        <?php echo $y['Nombre'].' '.$y['APaterno'].' '.$y['AMaterno']; ?>
                        <span class="text-muted pull-right"><?php echo $y['FecCap']; ?></span>
                      </span>
                  <div style="text-align: justify;">
                    <?php if(($_SESSION["PerXS"] == "p2Dr0$") && ($_SESSION["Permisos"] == 1)) { ?>
                    <i style="cursor: pointer; color: red; " onclick="delMensaje(<?php echo $y['IdForo']; ?>,<?php echo $IdActividad; ?>)" class="fa fa-fw fa-trash"></i>
                  <?php } ?>
                    <?php echo $y['Mensaje']; ?></div>
                </div>
              </div>
            <?php } ?>
            </div>
          <?php } ?>


  </form>
  <script>
  function cargarForoId(IdActividad){
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    $.ajax({
         url:"formConsulta/viewForo.php",
         method:"POST",
         data:{IdAsignacion:IdAsignacion, IdActividad:IdActividad},
         success:function(data){
              $('#employee_Foro').html(data);
              $('#dataForo').modal('show');
         }
    });
  }

  function delMensaje(IdComentario,IdActividad){
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    swal({
    title: "\u00BFEst\u00E1 seguro que desea eliminar este comentario?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Aceptar',
    cancelButtonText: "Cancelar",
    //closeOnConfirm: false,
    //closeOnCancel: false
  },
  function (isConfirm) {
    if (isConfirm) {
      var TipoGuardar = "del_comentario";
      $.ajax({
           url:"formConsulta/setting.php",
           method:"POST",
           data:{TipoGuardar:TipoGuardar, IdComentario:IdComentario},
           success:function(data){
             $.ajax({
                  url:"formConsulta/viewForo.php",
                  method:"POST",
                  data:{IdAsignacion:IdAsignacion, IdActividad:IdActividad},
                  success:function(data){
                       $('#employee_Foro').html(data);
                       $('#dataForo').modal('show');
                  }
             });

           }
      })
      return true;
    } else {
      return false;
    }
  });

  }
  </script>

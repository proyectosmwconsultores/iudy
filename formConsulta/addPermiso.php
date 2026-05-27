<?php
session_start();
$IdAdmin = $_SESSION['IdUsua'];
require('../php/clases/class.System.php');
$db = new Conexion();
date_default_timezone_set('America/Mexico_City');

$IdUsua = substr($_POST["Token"], 10, 10);

$hoy = date("Y-m-d");
$sqlx = $db->query("SELECT * FROM tblp_prorroga WHERE tblp_prorroga.IdUsua = '$IdUsua' AND tblp_prorroga.IdEstatus = '8' AND tblp_prorroga.Fecha < '$hoy'");
  while($u = $db->recorrer($sqlx)){
    $sql = $db->query("UPDATE tblc_usuario SET tblc_usuario.Folio = NULL WHERE tblc_usuario.IdUsua = '".$u['IdUsua']."' ");
    $sql = $db->query("UPDATE tblp_prorroga SET tblp_prorroga.IdEstatus = '22' WHERE tblp_prorroga.IdProrroga = '".$u['IdProrroga']."' ");
}


$lst = $db->query("SELECT
tblp_prorroga.IdProrroga,
tblp_prorroga.Fecha,
tblp_prorroga.FecCap,
tblp_prorroga.Comentario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto,
tblc_estatus.Estatus
FROM
tblp_prorroga
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_prorroga.IdAdmin
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_prorroga.IdEstatus
WHERE tblp_prorroga.IdUsua = '$IdUsua'
ORDER BY tblp_prorroga.FecCap DESC
");
?>
<div class="box-body">
  <div class="col-md-12">
    <form class="form-horizontal">
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-8 control-label">Fecha límite de prorroga:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control pull-right" id="txt_fecha_lim_pag" name="txt_fecha_lim_pag" autocomplete="off">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Comentario:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="txt_comentario_pro" id="txt_comentario_pro" placeholder="Comentario">
          </div>
        </div>
      </div>
    </form>
    <button onclick="sav_prorroga_new(<?php echo $IdAdmin; ?>,<?php echo $IdUsua; ?>)" type="button" class="btn btn-block btn-danger btn-sm"><i class="fa fa-check-circle"></i> Guardar prorroga</button>
  </div>
  <div class="col-md-12" style="margin-top: 20px;">
    <ul class="timeline timeline-inverse">
      <li class="time-label">
        <span class="bg-orange">
          <i class="fa fa-list"></i> Historial de prorrogas
        </span>
      </li>
      <?php while ($x = $db->recorrer($lst)) { ?>
        <li>
          <i class="fa fa-envelope bg-blue"></i>
          <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> <?php echo $x['FecCap']; ?> </span>
            <h3 class="timeline-header"><a href="#"><?php echo $x['Nombre'] . ' ' . $x['APaterno'] . ' ' . $x['AMaterno']; ?> </a></h3>
            <div class="timeline-body">
              <?php echo $x['Comentario']; ?>
            </div>
            <div class="timeline-footer">
              <a class="btn btn-danger btn-xs"><i class="fa fa-calendar"></i> Fecha límite: <?php echo $x['Fecha']; ?></a>
              <a class="btn btn-primary btn-xs"><?php if($x['Estatus'] == 'ACTIVO'){ echo "<i class='fa fa-check'></i>"; } else { echo "<i class='fa fa-times'></i>";  } ?> <?php echo $x['Estatus']; ?></a>
              <?php if(($_SESSION['IdUsua'] == 1) && ($x['Estatus'] == 'ACTIVO')){ ?>
              <a onclick="cancelar_prorroga(<?php echo $x['IdProrroga']; ?>,<?php echo $IdUsua; ?>)" class="btn btn-warning btn-xs"> <i class="fa fa-times-circle"></i> CANCELAR</a>
              <?php } ?>
            </div>
        </li>
      <?php } ?>
      <li>
        <i class="fa fa-clock-o bg-gray"></i>
      </li>
    </ul>
  </div>
</div>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  function sav_prorroga_new(IdAdmin, IdUsua) {
    var Fecha = document.getElementById("txt_fecha_lim_pag").value;
    var Comentario = document.getElementById("txt_comentario_pro").value;

    if (Fecha == '') {
      swal("Error al guardar", "Debe selecionar la fecha limite de prorroga.", "error");
      document.getElementById("txt_fecha_lim_pag").focus();
      return 0;
    }
    if (Comentario == '') {
      swal("Error al guardar", "Debe escribir el comentario de la prorroga.", "error");
      document.getElementById("txt_comentario_pro").focus();
      return 0;
    }

    var TipoGuardar = "savProrro";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea activar esta prorroga?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsua=' + IdUsua + '&IdAdmin=' + IdAdmin + '&Fecha=' + Fecha + '&Comentario=' + Comentario;
          $.ajax({
              type: "POST",
              url: "insertar.php",
              data: datos,
              success: function(data) {

              }
            })
            .done(function(data) {
              var Token = '0000000000' + IdUsua;
              if (data == 1) {
                swal("Guardado correctamente", "Los datos han sidos guardado correctamente.", "success");
                $.ajax({
                  url: "formConsulta/addPermiso.php",
                  method: "POST",
                  data: {
                    Token: Token
                  },
                  success: function(data) {
                    $('#employee_detail8').html(data);
                    $('#dataModal8').modal('show');
                  }
                });


              }
            })
            .error(function(data) {
              swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
            });
        }
      });
  }

  function cancelar_prorroga(Id, IdUsua){
    var TipoGuardar = 'cancelar_prorroga';
    var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsua=' + IdUsua + '&Id=' + Id;
          $.ajax({
              type: "POST",
              url: "insertar.php",
              data: datos,
              success: function(data) {

              }
            })
            .done(function(data) {
              var Token = '0000000000' + IdUsua;
              if (data == 1) {
                swal("Guardado correctamente", "Los datos han sidos guardado correctamente.", "success");
                $.ajax({
                  url: "formConsulta/addPermiso.php",
                  method: "POST",
                  data: {
                    Token: Token
                  },
                  success: function(data) {
                    $('#employee_detail8').html(data);
                    $('#dataModal8').modal('show');
                  }
                });
              }
            })
            .error(function(data) {
              swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
            });
  }



  $(function() {
    //Date picker
    $('#txt_fecha_lim_pag').datepicker({
      autoclose: true
    })

  })
</script>
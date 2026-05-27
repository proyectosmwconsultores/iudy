<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $code = $_POST["employee_id"];

  $sqlH = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_educativa.Nombre,
tblp_modulo.NombreMod
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE
tblp_asignacion.IdAsignacion =  '$code'");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);



  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name='idAsignacion' id='idAsignacion' value="<?php echo $code; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div style="padding: 10px;" class="bg-teal-active color-palette"><span><?php echo $datos81['Nombre']; ?></span></div>
        <div style="padding: 10px;" class="bg-teal color-palette"><span><?php echo $datos81['NombreMod']; ?></span></div>
        <div class="box-body"><br><br>
          <p style="font-size:65px; text-align: center; " ><?php echo $code; ?></b>
            <br>
        </div>
      </div>
      <a onclick="open_clase()" href="javascript:void(0);" style="margin-left: 0px;" class="btn btn-default btn-block btn-sm bg-navy btn-flat margin"> <i class="fa fa-fw fa-check-circle"></i> Activar clase nuevamemente </a>

    </table>

  </div>


  </form>
<script>
function open_clase(){
  var idAsignacion = document.getElementById("idAsignacion").value;
  var TipoGuardar = "open_class";
  swal({
    title: "\u00BFEst\u00E1 seguro que desea activar esta clase nuevamemente?",
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
           data:{TipoGuardar:TipoGuardar, idAsignacion:idAsignacion},
           success:function(data){
           }
      })
      .done(function(data) {
        if(data==1){
          swal("Clase activada", "La clase se ha activado correctamente.", "success");
          parent.location.href='viewFinalizados.php';
        }

      })
      .error(function(data) {
        swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
      });
    }

  });
}
</script>

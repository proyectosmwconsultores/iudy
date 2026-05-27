<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $code = $_POST["employee_id"];

  $sqlH = $db->query("SELECT
    tblp_moduloalumno.IdModAlumno,
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.FecCap,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE
tblp_moduloalumno.IdAsignacion =  '$code'");

  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $code; ?>" type="hidden"/>
    <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th colspan="2">Nombre el alumno</th>
                  <th>Ajuste</th>
                </tr>
                <?php $c = 0; while($x = $db->recorrer($sqlH)){ ?>
                <tr>
                  <td><b><?php echo $c = $c + 1; ?>.- </b></td>
                  <td style="width: 46px;"><img src="assets/perfil/nuevo.png" class="img-responsive img-circle img-sm" alt="User Image"></td>
                  <td><?php echo $x['APaterno'].' '.$x['AMaterno'].' '.$x['Nombre']; ?></td>
                  <td>
                    <button type="button" class="btn bg-navy btn-flat margin btn-xs view_quitar" id="<?php echo $x['IdModuloAlumno']; ?>"><i class="fa fa-fw fa-trash-o"></i> Eliminar</button>
                    <button type="button" class="btn bg-navy btn-flat margin btn-xs" onclick="javascript:window.open('formConsulta/impListaActividades.php?tokenId=<?php echo $code; ?>&IdUsua=<?php echo time().$x['IdUsua']; ?>' , 'ventana1' , 'width=800px,height=600,scrollbars=NO,toolbar=NO');" href="javascript:void(0);" title="Descargar actividades del alumno"><i class="fa fa-fw fa-print"></i> Reporte</button>
                  </td>
                </tr>
                <?php } ?>
              </tbody></table>
  </form>
<script>
$(document).ready(function(){
     $(document).on('click', '.view_quitar', function(){
          var IdCodMod = $(this).attr("id");
          if(IdCodMod != '')
          {
              var TipoGuardar = "quitar_alumno";
              var employee_id = document.getElementById("IdAsignacion").value;

                  swal({
                    title: "\u00BFEst\u00E1 seguro que desea eliminar este alumno de esta clase?",
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
                           data:{TipoGuardar:TipoGuardar, IdCodMod:IdCodMod},
                           success:function(data){

                           }
                      })
                      .done(function(data) {
                				if(data==1){
                					swal("Eliminado correctamente", "El alumno se ha eliminado correctamente de la materia.", "success");
                          $.ajax({
         											url:"formConsulta/viewMiClase.php",
         											method:"POST",
         											data:{employee_id:employee_id},
         											success:function(data){
         													 $('#employee_Grp').html(data);
         													 $('#dataGrp').modal('show');
         											}
         								 });
                				} else{
                					swal("Error al eliminar", "No se ha podido eliminar el alumno de esta clase.", "error");
                				}
                			})
                			.error(function(data) {
                				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
                			});

                    }

                  });
          }
     });
});
</script>

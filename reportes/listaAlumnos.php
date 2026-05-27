<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdCompra = $_POST["IdCompra"];

  $sqlH = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.Foto,
tblc_campus.Campus,
tblp_educativa.Nombre AS Educativa,
tblp_grupo.CveGrupo
FROM
tblc_usuario
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
WHERE
tblc_usuario.IdEstatus = '8' AND tblc_usuario.id_compra =  '$IdCompra'");

  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="IdCompra" name="IdCompra" value="<?php echo $IdCompra; ?>" type="hidden"/>
    <table class="table table-striped" style="font-size: 12px;">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th colspan="2">Nombre el alumno</th>
                  <th>Campus</th>
                  <th>Oferta</th>
                  <th>Grupo</th>
                  <th>Ajuste</th>
                </tr>
                <?php $c = 0; while($x = $db->recorrer($sqlH)){ ?>
                <tr>
                  <td><b><?php echo $c = $c + 1; ?>.- </b></td>
                  <td style="width: 46px;"><img src="assets/perfil/<?php echo $x['Foto']; ?>" class="img-responsive img-circle img-sm" alt="User Image"></td>
                  <td><?php echo '<b>'.$x['Usuario'].'</b> - '.$x['Nombre'].' '.$x['APaterno'].' '.$x['AMaterno']; ?></td>
                  <td><?php echo $x['Campus']; ?></td>
                  <td><?php echo $x['Educativa']; ?></td>
                  <td><?php echo $x['CveGrupo']; ?></td>
                  <td>
                    <!-- <button type="button" class="btn bg-navy btn-flat margin btn-xs view_quitar" id="<?php echo $x['IdUsua']; ?>"><i class="fa fa-fw fa-trash-o"></i></button> -->
                    <div class="btn-group">
                  <button type="button" class="btn bg-navy btn-flat margin btn-xs btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-fw fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a onClick="del_alumnox(<?php echo $x['IdUsua']; ?>)" href="javascript:void(0);">Eliminar</a></li>
                    <li><a onClick="blo_alumnox(<?php echo $x['IdUsua']; ?>)" href="javascript:void(0);">Quitar de MWComenius</a></li>
                    <!-- <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li> -->
                  </ul>
                </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody></table>
  </form>
<script>
    function del_alumnox(IdUsua){
      var TipoGuardar = "eliminar_alumno";
      var IdCompra = document.getElementById("IdCompra").value;

          swal({
            title: "\u00BFEst\u00E1 seguro que desea eliminar este alumno de la Plataforma MWComenius?",
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
                   url:"reportes/setting.php",
                   method:"POST",
                   data:{TipoGuardar:TipoGuardar, IdCompra:IdCompra, IdUsua:IdUsua},
                   success:function(data){
                     // miPaquete();
                   }
              })
              .done(function(data) {
                if(data==1){

                  swal("Eliminado correctamente", "El alumno se ha eliminado correctamente de la PLataforma MWComenius.", "success");
                  $.ajax({
                       url:"reportes/listaAlumnos.php",
                       method:"POST",
                       data:{IdCompra:IdCompra},
                       success:function(data){
                            $('#employee_eva').html(data);
                            $('#dataEva').modal('show');
                       }
                  });
                } else{
                  swal("Error al eliminar", "No se ha podido eliminar el alumno de la Plataforma MWComenius.", "error");
                }
              })
              .error(function(data) {
                swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
              });

            }

          });
        }

        function blo_alumnox(IdUsua){
          var TipoGuardar = "quitar_alumno";
          var IdCompra = document.getElementById("IdCompra").value;
              swal({
                title: "\u00BFEst\u00E1 seguro que desea quitar este alumno de la Plataforma MWComenius?",
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
                       url:"reportes/setting.php",
                       method:"POST",
                       data:{TipoGuardar:TipoGuardar, IdCompra:IdCompra, IdUsua:IdUsua},
                       success:function(data){
                         // miPaquete();
                       }
                  })
                  .done(function(data) {
                    if(data==1){

                      swal("Eliminado correctamente", "El alumno se ha quitado correctamente de la PLataforma MWComenius.", "success");
                      $.ajax({
                           url:"reportes/listaAlumnos.php",
                           method:"POST",
                           data:{IdCompra:IdCompra},
                           success:function(data){
                                $('#employee_eva').html(data);
                                $('#dataEva').modal('show');
                           }
                      });
                    } else{
                      swal("Error al eliminar", "No se ha podido quitar el alumno de la Plataforma MWComenius.", "error");
                    }
                  })
                  .error(function(data) {
                    swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
                  });

                }

              });
            }

</script>

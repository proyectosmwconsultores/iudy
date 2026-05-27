<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();

$IdGral  = $_POST["employee_id"];
$porciones = explode("-", $IdGral);
$IdUsua = $porciones[0];
$IdAsig = $porciones[1];
$IdMod = $porciones[2];


$sql = $db->query("SELECT
  tblp_modulo.IdModulo,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_moduloalumno.IdAsignacion,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblc_ciclo.Ciclo,
tblp_grupo.CveGrupo
FROM
tblp_moduloalumno
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdGrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
 WHERE tblp_moduloalumno.IdModulo = '$IdMod' AND tblp_moduloalumno.Estatus = 'Activo' GROUP BY tblp_moduloalumno.IdAsignacion");

  ?>
  <form name="frm2eSar" id="frm2eSar" action="buscarAsignatura.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="updSemana" type="hidden"/>
    <input id="IdAsigAnt" name="IdAsigAnt" value="<?php echo $IdAsig; ?>" type="hidden"/>

    <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>Ajuste</th>
                    <th>IdAsignatura</th>
                    <th>Asignatura</th>
                    <th>Rango de fecha</th>
                    <th>Ciclo</th>
                    <th>Grupo</th>
                  </tr>
                  <?php while($x = $db->recorrer($sql)){ ?>
                  <tr>
                    <td><button type="button" class="btn btn-default btn-flat view_materia" href="javascript:void(0);" name="view" value="view" id="<?php echo $x["IdAsignacion"].'-'.$x["IdModulo"].'-'.$IdUsua; ?>"> <i class="fa fa-fw fa-check-circle-o"></i> </button></td>
                    <td><?php echo $x["CodeModulo"]; ?></td>
                    <td><?php echo $x["NombreMod"]; ?></td>
                    <td><?php echo $x["FecIni"].' '.$x["FecFin"]; ?></td>
                    <td><?php echo $x["Ciclo"]; ?></td>
                    <td><?php echo $x["CveGrupo"]; ?></td>
                  </tr>
                  <?php } ?>
                </tbody></table>
              </div>

  </form>
<script>

  // $(document).ready(function(){
  // 		 $(document).on('click', '.view_materia', function(){
  //        var employee_id = $(this).attr("id");
  //        var TipoGuardar = "add_asigReprobado";
  //
  //          var porciones = employee_id.split('-');
  //          var IdUsua = porciones[2]; //porción3
  //
  //        swal({
  //           title: "Esta seguro de enar este",
  //           type: "info",
  //           showCancelButton: true,
  //           confirmButtonColor: '#DD6B55',
  //           confirmButtonText: 'Aceptar',
  //           cancelButtonText: "Cancelar",
  //         },
  //         function (isConfirm) {
  //           if (isConfirm) {
  //             $(".confirm").attr('disabled', 'disabled');
  //
  //
  //   					 $.ajax({
  //   								url:"formConsulta/setting.php",
  //   								method:"POST",
  //   								data:{TipoGuardar:TipoGuardar,employee_id:employee_id},
  //   								success:function(data){
  //
  //   								}
  //   					 })
  //              .done(function(data) {
  //                if(data==1){
  //
  //                  swal({
  //                     title: "El alumno se ha agregado correctamente en esta nueva asignatura",
  //                     type: "success",
  //                     showCancelButton: false,
  //                     confirmButtonColor: '#DD6B55',
  //                     confirmButtonText: 'Aceptar',
  //                   },
  //                   function (isConfirm) {
  //                     if (isConfirm) {
  //                       $(".confirm").attr('disabled', 'disabled');
  //                       parent.location.href='adConfigAlumno.php?Id=5de94afa342575de94afa342575de94afa342575de94afa34257'+IdUsua;
  //                       return true;
  //                     } else {
  //                       return false;
  //                     }
  //                   });
  //
  //                }else{
  //                  swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
  //                }
  //              })
  //
  //             return true;
  //           } else {
  //             return false;
  //           }
  //         });
  //
  //
  //
  //
  //
  //
  //
  //
  // 		 });
  // });

  $(document).ready(function(){
  		 $(document).on('click', '.view_materia', function(){
         var employee_id = $(this).attr("id");
         var TipoGuardar = "add_asigReprobado";
         var IdAsigAnt = document.frm2eSar.IdAsigAnt.value;

         var porciones = employee_id.split('-');
         var IdUsua = porciones[2]; //porción3

         swal({
     		title: "\u00BFEst\u00E1 seguro que desea agregar este alumno?",
     		type: "warning",
     		showCancelButton: true,
     		confirmButtonColor: '#DD6B55',
     		confirmButtonText: 'Aceptar',
     		cancelButtonText: "Cancelar",
     	},
     	function (isConfirm) {
     		if (isConfirm) {
          $.ajax({
            								url:"formConsulta/setting.php",
            								method:"POST",
            								data:{TipoGuardar:TipoGuardar,employee_id:employee_id, IdAsigAnt: IdAsigAnt},
            								success:function(data){

                              parent.location.href='adConfigAlumno.php?Id=5de94afa342575de94afa342575de94afa342575de94afa34257'+IdUsua;
            								}
            					 })

     		}
     	});








  		 });
  });

</script>

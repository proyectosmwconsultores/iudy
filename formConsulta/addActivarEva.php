<?php session_start();
include('../hace.php');
if(isset($_POST["IdActividadDoc"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdActivadadDoc = $_POST["IdActividadDoc"];

  $sql8 = $db->query("SELECT tblp_actividadesdocente.IdParcialDocente, tblp_actividadesdocente.IdAsignacion, tblp_actividadesdocente.IdEstatus, tblp_actividadesdocente.Ini, tblp_actividadesdocente.Fin FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActivadadDoc' ");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  // $IdPlan = $datos81["IdPlan"];
  // $IdModulo = $datos81["IdModulo"];
  // $curso = $datos81["Curso"];

  $txtE = "Cargar la evaluación";
  $sql = $db->query("SELECT
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_examusuario.IdExamenUsua,
tblp_examusuario.FecIni,
tblp_examusuario.FecFin,
tblp_examusuario.IdEstatus,
tblp_examusuario.Valor
FROM
tblp_examusuario
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_examusuario.IdUsua
WHERE
tblp_examusuario.IdActividadesDocente =  '$IdActivadadDoc'
 ORDER BY tblc_usuario.APaterno ASC ");

  ?>
  <form name="frm22" id="frm22" action="addRvoe.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

    <input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $IdActivadadDoc; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $datos81['IdAsignacion']; ?>" type="hidden"/>
    <input id="IdParcial" name="IdParcial" value="<?php echo $datos81['IdParcialDocente']; ?>" type="hidden"/>
    <?php if(($datos81["Ini"]) && ($datos81["Fin"])){ ?><span style="color: blue;" class="username">Fecha configurada para la evaluación: <?php echo $datos81["Ini"].' al '.$datos81["Fin"]; ?></span><br><br><?php } ?>

    <table class="table table-striped" style=" font-size: 12px;">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Nombre del alumno</th>
                  <th>Inicia examen</th>
                  <th>Estatus</th>
                  <th>Ajuste</th>
                </tr>
                <?php $vc = 0; $g = 0; while($x = $db->recorrer($sql)){
                  $txtE = "Reiniciar la evaluación";
                  $vc = 1; ?>
                <tr>
                  <td><b><?php echo $g = $g + 1; ?>.- </b></td>
                  <td><?php echo $x["APaterno"].' '.$x["AMaterno"].' '.$x["Nombre"]; ?></td>
                  <td><?php echo substr($x["FecIni"], 11,8).' '.substr($x["FecFin"], 11,10); ?></td>
                  <td><?php if($x["IdEstatus"] == '12') { echo 'En proceso'; } else { echo 'Realizado'; }?></td>
                  <td>
                    <?php if($x["Valor"] == 1){ ?>
                    <button title="Desactivar evaluación" onclick="actEvaNew(<?php echo $x["IdExamenUsua"]; ?>,0)" type="button" class="btn btn-info btn-flat btn-xs"><i class="fa fa-fw fa-check-circle"></i> Activo</button>
                  <?php } else { ?>
                    <button title="Activar evaluación" onclick="actEvaNew(<?php echo $x["IdExamenUsua"]; ?>,1)" type="button" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-fw fa-times-circle"></i> Inactivo</button>
                  <?php } ?>
                  <?php // if($_SESSION['Permisos'] == 4){ ?>
                  <button title="Reiniciar evaluación para este alumno" onclick="reiniciarEva(<?php echo $x["IdExamenUsua"]; ?>)" type="button" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-refresh"></i> Reiniciar</button>
                  <?php // } ?>
                  </td>


                </tr>
              <?php } ?>

              </tbody></table>

              <div class="btn-group">
                <?php if(($vc == 1) && ($datos81['IdEstatus'] == 8)){ ?>
                <!-- <button onclick="actEvaNewTodos()" style="margin-left: 5px;" type="button" class="btn btn-success"><i class="fa fa-fw fa-check-circle"></i> Activar evaluación</button> -->
                <!-- <button onclick="ediEvalua()" style="margin-left: 5px;" type="button" class="btn btn-info"><i class="fa fa-fw fa-edit"></i> Editar evaluación</button> -->
              <?php } if($datos81['IdEstatus'] == 8){ ?>
                <!-- <button onclick="reinEvaxD()" style="margin-left: 5px;" type="button" class="btn btn-danger"><i class="fa fa-fw fa-refresh"></i> <?php echo $txtE; ?></button> -->
                <?php } ?>
              </div>
              <input type="hidden" name="v_T" id="v_T" value="<?php echo $txtE ?>">
        </form>


  <?php
}
?>
<script>
  function reiniciarEva(IdExamenUsua){
    var TipoGuardar = "exa_reiniciar";
    var IdActividadDoc = document.getElementById("IdActividadDoc").value;

        swal({
          title: "\u00BFEst\u00E1 seguro que desea reiniciar este examen para este alumno?",
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
                 data:{TipoGuardar:TipoGuardar, IdExamenUsua:IdExamenUsua},
                 success:function(data){ //alert(data);


                 }
            })
            .done(function(data) {
      				if(data==1){
      					swal("Reiniciado correctamente", "La evaluación se ha reiniciado correctamente.", "success");
                $.ajax({
            				 url:"formConsulta/addActivarEva.php",
            				 method:"POST",
            				 data:{IdActividadDoc:IdActividadDoc},
            				 success:function(data){
            							$('#employee_eva').html(data);
            							$('#dataEva').modal('show');
            				 }
            		});
      				} else{
      					swal("Error al reiniciar", "No se ha podido reiniciar la evaluacion.", "error");
      				}
      			})
      			.error(function(data) {
      				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
      			});

          }

        });
  }

  function reinEvaxD(){
    var TipoGuardar = "upd_reinEcax";
    var IdActividadDoc = document.getElementById("IdActividadDoc").value;
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    var IdParcial = document.getElementById("IdParcial").value;
    var v_T = document.getElementById("v_T").value;
        swal({
      		title: '\u00BFEst\u00E1 seguro que desea '+ v_T +'?',
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
                 data:{TipoGuardar:TipoGuardar, IdActividadDoc:IdActividadDoc, IdAsignacion:IdAsignacion, IdParcial:IdParcial},
                 success:function(data){

                   $.ajax({
               				 url:"formConsulta/addActivarEva.php",
               				 method:"POST",
               				 data:{IdActividadDoc:IdActividadDoc},
               				 success:function(data){
               							$('#employee_eva').html(data);
               							$('#dataEva').modal('show');
               				 }
               		});

                 }
            })

      		}

      	});
  }
</script>

<?php
session_start();

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $_IdUs = $_SESSION['IdUsua'];

  $sql50 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$_IdUs' AND tblc_modulousuario.IdModulo = '50'");
  $db->rows($sql50);
  $datos_50 = $db->recorrer($sql50);
  $_50 = $datos_50['IdModUsua'];
  
  $sql25 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$_IdUs' AND tblc_modulousuario.IdModulo = '25'");
  $db->rows($sql25);
  $datos_25 = $db->recorrer($sql25);
  $_25 = $datos_25['IdModUsua'];

  $sql26 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$_IdUs' AND tblc_modulousuario.IdModulo = '26'");
  $db->rows($sql26);
  $datos_26 = $db->recorrer($sql26);
  $_26 = $datos_26['IdModUsua'];

  $sql_docs = $db->query("SELECT tblp_docs_solicitados.IdDocumento, tblp_docs_solicitados.FecSubida, tblp_docs_solicitados.IdVisto, tblp_docs_solicitados.Archivo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblc_conceptosplanes.NomPlan, tblc_campus.Campus FROM tblp_docs_solicitados Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_docs_solicitados.IdUsua Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_docs_solicitados.IdConceptoPlan Left Join tblc_campus ON tblc_campus.IdCampus = tblp_docs_solicitados.IdCampus WHERE tblp_docs_solicitados.IdEstatus =  '3'");
  $ini = 0;
  $can = 0;
  if(isset($_50)){
     $ini = 1;
  }
  ?>
  <form name="frm22" id="frm22" action="updCalificacion.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

      <div class="box">

            <div class="box-body no-padding">
              <table class="table table-striped" style='font-size: 12px;'>
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Alumno</th>
                  <th>Concepto</th>
                  <th>Campus</th>
                  <th>FecSubida</th>
                  <?php if($ini == 1){?>
                  <th>Ajustes</th><?php } ?>
                </tr>
                <?php $v = 0;  while($x = $db->recorrer($sql_docs)){ $v = 1;
                    if($x['IdVisto'] <> 0){
                        $can = 1;
                    }
                ?>
                <tr>
                  <td>1.</td>
                  <td><?php echo $x['Usuario'].' - '.$x['Nombre'].' '.$x['APaterno'].' '.$x['AMaterno']; ?></td>
                  <td><?php echo $x['NomPlan']; ?></td>
                  <td><?php echo $x['Campus']; ?></td>
                  <td><?php echo $x['FecSubida']; ?></td>
                  <?php if($ini == 1){?>
                  <td style='text-align: center;'>
                      <div class="btn-group">
                      <button onclick="aprobadoDocs(<?php echo $_SESSION['IdUsua']; ?>,<?php echo $x['IdDocumento']; ?>)" href="javascript:void(0);" type="button" class="btn btn-success"><i class="fa fa-check-circle"></i></button>
                      <button onclick="declinadoDocs(<?php echo $_SESSION['IdUsua']; ?>,<?php echo $x['IdDocumento']; ?>)" href="javascript:void(0);" type="button" style='margin-left: 2px;' class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
                      <button onClick="window.open('assets/docs/Pagos/<?php echo $x['Archivo']; ?>','_blank')" href="javascript:void(0);" type="button" style='margin-left: 18px; margin-top: 2px;' class="btn btn-info"><i class="fa fa-file-image-o"></i></button>
                    </div>
                  </td><?php } ?>
                </tr><?php } ?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>


              <div class="box-body">
                <div class="box-footer">
                    <?php if(($v == 1) && ($ini == 1) && ($can == 0)){ ?>
                    <button onclick="cerrarVentana(<?php echo $_SESSION['IdUsua']; ?>)" href="javascript:void(0);"  type="button" class="btn btn-danger pull-right"> <i class="fa fa-times-circle"></i> Cerrar ventana y revisar más tarde</button>
                    <?php } else { ?>
                    <button  type="button" class="btn btn-danger pull-right" data-dismiss="modal"> <i class="fa fa-times-circle"></i> Cerrar </button>
                    <?php } ?>
                  </div>
              </div>
        </form>

<script>
  function declinadoDocs(IdUsua,IdDocumento){
    var TipoGuardar = "declinar_docs";
      swal({
    		title: "\u00BFEst\u00E1 seguro que desea quitar de la lista y que vuelva a subir su tickt de pago el alumno?",
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
                       data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdDocumento:IdDocumento},
                       success:function(data){
                         $.ajax({
            				 url:"formConsulta/lst_docs_sol.php",
            				 method:"POST",
            				 data:{},
            				 success:function(data){
            					$('#employee_docs').html(data);
            					$('#dataDocs').modal('show');
            				 }
                		});
                       }
                  })
    		}

    	});
  }

  function aprobadoDocs(IdUsua,IdDocumento){
    var TipoGuardar = "aprobar_docs";
      swal({
    		title: "\u00BFEst\u00E1 seguro que desea liberar la constancia para que el alumno lo pueda descargar?",
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
                       data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdDocumento:IdDocumento},
                       success:function(data){
                         $.ajax({
            				 url:"formConsulta/lst_docs_sol.php",
            				 method:"POST",
            				 data:{},
            				 success:function(data){
            					$('#employee_docs').html(data);
            					$('#dataDocs').modal('show');
            				 }
                		});
                       }
                  })
    		}

    	});
  }

  function cerrarVentana(IdUsua){
    var TipoGuardar = "close_ventana";
      swal({
    		title: "\u00BFEst\u00E1 seguro que desea cerrar esta ventana?",
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
               data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua},
               success:function(data){
                 $('#dataDocs').modal('hide');
               }
          })

    		}

    	});
  }

  function saveCiclo(IdGrado, Usuario, IdOferta){
    var Ciclo = document.getElementById("txtCicloX").value;
    var TipoGuardar = "addSaveCicl";
    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdGrado:IdGrado, Usuario:Usuario,IdOferta:IdOferta,Ciclo:Ciclo},
         success:function(data){
           swal("Guardado correctamente", "El ciclo fue guardado correctamente.", "success");
         }
    })
  }
</script>

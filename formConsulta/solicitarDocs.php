<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST['IdUsua'];

  $sql9 = $db->query("SELECT tblc_usuario.IdGrupo, tblc_usuario.IdOferta FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91['IdOferta'];
  $IdGrupo = $datos91['IdGrupo'];

  //$sql_cic = $db->query("SELECT tblc_ciclogrupo.IdCiclo, tblc_ciclo.Ciclo FROM tblc_ciclogrupo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo WHERE tblc_ciclogrupo.IdGrupo =  '$IdGrupo' ORDER BY tblc_ciclo.FInicio DESC LIMIT 2 ");
  $sql_cic = $db->query("SELECT
tblc_alumnos.IdCiclo,
tblc_ciclo.Ciclo
FROM
tblc_alumnos
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_alumnos.IdCiclo
WHERE
tblc_alumnos.IdUsua =  '$IdUsua'
ORDER BY
tblc_ciclo.FInicio DESC LIMIT 2");

   $sql_concp = $db->query("SELECT
tblc_conceptosdetalle.IdConceptoDetalle,
tblc_conceptosdetalle.IdConceptoPlan,
tblc_conceptosplanes.NomPlan,
tblc_conceptosplanes.Costo,
tblc_conceptosdetalle.IdConcepto,
tblc_conceptosdetalle.IdOferta
FROM
tblc_conceptosdetalle
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan
WHERE tblc_conceptosdetalle.IdOferta = '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '10' ORDER BY tblc_conceptosplanes.NomPlan ASC");

$hoy = date("Y-m-d");

$sql_pag = $db->query("SELECT
Count(tblp_pagos.IdPago) AS Total
FROM
tblp_pagos
WHERE
tblp_pagos.IdUsua =  '$IdUsua' AND
tblp_pagos.Fecha <  '$hoy' AND
tblp_pagos.IdEstatus =  '1' AND 
tblp_pagos.IdConcepto <=  '3'
 ");
  $db->rows($sql_pag);
  $_pagx = $db->recorrer($sql_pag);
  

  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="TipoGuardar" name="TipoGuardar" value="savClase" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="col-md-12">
          <div class="form-group">
            <label>Tipo de documento que puede solicitar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <select class="form-control" name="txt_Plan" id="txt_Plan">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($sql_concp)){ ?>
                <option value="<?php echo $x["IdConceptoPlan"]; ?>"> <?php echo $x["NomPlan"]; ?> - $ <?php echo $x["Costo"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Periodo escolar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <select class="form-control" name="txt_periodo" id="txt_periodo">
                <option value=""> - Seleccione - </option>
                <?php while($cic = $db->recorrer($sql_cic)){ ?>
                <option value="<?php echo $cic["IdCiclo"]; ?>"> <?php echo $cic["Ciclo"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Nota:</label> Usted tendrá 2 días a partir de hoy para realizar el pago correspondiente del documento solicitado, una vez realizado el pago con su referencia usted deberá subir su comprobante de pago, después podrá descargar el documento en el apartado de Documentos solicitados.
          </div>
        </div>
        <?php if($_pagx['Total'] > 0) { ?>
        <div class="col-md-12" style="color: red;">
          <div class="tab-content">
            <blockquote>
              <p>Usted tiene  tiene <?php echo $_pagx['Total']; ?> pago(s) pendiente(s).</p>
              <small>Por tal motivo no puede solicitar ninguna constancia.</small>
            </blockquote>
          </div>
        </div><?php } ?>
        

        <?php if(($_SESSION['IdEstatus'] == 8) && ($_pagx['Total'] == 0)){ ?>
        <div class="col-md-12">
          <div class="form-group"><br>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
              <button type="button" class="btn btn-primary pull-right" onClick="solDocss(<?php echo $_SESSION['IdUsua']; ?>)"> <i class="fa fa-fw fa-check-circle"></i> Solicitar documento</button>
            </div>
          </div>
        </div><?php } ?>
      </div>
    </table>
  </div>

  </form>

<script>
  function solDocss(IdUsua){
    var IdPlan = document.getElementById("txt_Plan").value;
    var IdCiclo = document.getElementById("txt_periodo").value;

    if (IdPlan==""){
        swal("Error al guardar", "Debe seleccionar el documento que desea solicitar.", "error");
        document.getElementById("txt_clase").focus();
        return 0;
    }
    if (IdCiclo==""){
        swal("Error al guardar", "Debe seleccionar el ciclo escolar con la que se va a emitir el documento.", "error");
        document.getElementById("txt_periodo").focus();
        return 0;
    }
      var TipoGuardar = "solDocss";

      swal({
        title: "\u00BFEst\u00E1 seguro que desea solicitar este documento?",
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
               data:{TipoGuardar:TipoGuardar, IdPlan:IdPlan, IdUsua:IdUsua, IdCiclo:IdCiclo},
               success:function(data){

               }
          })
          .done(function(data) {
            if(data==1){
              swal({
            		title: "El documento fue solicitado correctamente, favor de hacer su pago correspondiente",
            		type: "success",
            		showCancelButton: false,
            		confirmButtonColor: '#DD6B55',
            		confirmButtonText: 'Aceptar',
            	},
            	function (isConfirm) {
            		if (isConfirm) {
            			$(".confirm").attr('disabled', 'disabled');
                  parent.location.href='misPagos.php';
            		}

            	});

    				}

            if(data==0){
              swal("Error al solicitar", "No se puede solicitar el documento deseado.", "error");
    				}
    			})
    			.error(function(data) {
    				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
    			});

        }

      });
  }

</script>

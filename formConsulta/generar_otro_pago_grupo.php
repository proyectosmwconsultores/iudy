<?php
session_start();
if(isset($_POST["IdCiclo"])){
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdPlan = $_POST["IdPlan"];
  $IdAdmin = $_SESSION['IdUsua'];

  $sql_grp = $db->query("SELECT tblp_grupo.IdOferta FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
  $db->rows($sql_grp);
  $_grp = $db->recorrer($sql_grp);
  $idOferta = $_grp['IdOferta'];

  $sql_con = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosdetalle.IdOferta, tblc_conceptosdetalle.IdConcepto, tblc_conceptosplanes.NomPlan, tblc_conceptosplanes.Costo FROM tblc_conceptosdetalle Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$idOferta' AND tblc_conceptosplanes.IdConcepto =  '1'");

  $sql_pag = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblp_pagos.Monto,
tblp_pagos.IdCalendario,
tblp_pagos.FecDesc,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_estatus.Estatus,
tblc_usuario.Usuario
FROM
tblp_pagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
WHERE
tblp_pagos.IdGrupo =  '$IdGrupo' AND
tblp_pagos.IdCiclo =  '$IdCiclo' AND
tblp_pagos.IdConceptoPlan =  '$IdPlan'
ORDER BY
tblc_usuario.Usuario ASC
");


?>

<div class="box-info">
  <form class="form-horizontal" name="frmx" id="frmx" action="addSubPeriodo.php" method="POST" enctype="multipart/form-data">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Plan de pago:</label>
        <div class="col-sm-8">
          <select name="txtPlan2" id="txtPlan2" class="form-control" onchange="cambiar_plan(<?php echo $IdCiclo.','.$IdGrupo; ?>)">
            <option value=""> - Seleccione - </option>
            <?php while($_con = $db->recorrer($sql_con)){ ?>
              <option value="<?php echo $_con['IdConceptoPlan']; ?>" <?php if($IdPlan == $_con['IdConceptoPlan']){?>selected="selected"<?php }?>> <?php echo $_con['NomPlan'] ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-8 control-label">Fecha de pago:</label>
        <div class="col-sm-4">
          <input type="text" name="txt_fecha2" id="txt_fecha2" class="form-control" value="">
        </div>
      </div>
      </div>
      <div class="box-body no-padding">
      <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th style="width: 10px">#</th>
          <th>MATRICULA</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>FECHA</th>
          <th>ESTATUS</th>
          <th>MONTO</th>
        </tr>
        <?php $vx = 0; $IdCal = 0; while($_pag = $db->recorrer($sql_pag)){ $IdCal = $_pag['IdCalendario']; ?>
        <tr>
          <td><b><?php echo $vx = ($vx + 1); ?>.- </b></td>
          <td><?php echo $_pag['Usuario']; ?></td>
          <td><?php echo $_pag['APaterno'].' '.$_pag['AMaterno'].' '.$_pag['Nombre']; ?></td>
          <td><?php echo $_pag['FecDesc']; ?></td>
          <td><?php echo $_pag['Estatus']; ?></td>
          <td>$ <?php echo number_format($_pag['Monto'], 2, '.', ','); ?></td>
        </tr><?php } ?>
      </tbody></table>
  </div>

  </form>
</div>
<div class="box-footer" style="text-align: right;">
  <?php if($vx){ ?>
    <button onclick="upd_generar_pg_xid(<?php echo $IdGrupo.','.$IdAdmin.','.$IdCiclo.','.$IdCal; ?>)" type="button" class="btn bg-maroon btn-flat margin"><i class="fa fa-refresh"></i> Actualizar pago</button>
  <?php } else { ?>
    <button onclick="generar_pg_xid(<?php echo $IdGrupo.','.$IdAdmin.','.$IdCiclo; ?>)" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-refresh"></i> Generar pago</button>
  <?php } ?>
</div>
<?php } ?>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>

  function generar_pg_xid(IdGrupo, IdAdmin, IdCiclo){
      var TipoGuardar = "otro_pago_materia";
      var IdPlan = document.getElementById("txtPlan2").value;
      var Fecha = document.getElementById("txt_fecha2").value;
      if(!IdPlan){
  			swal("Error al guardar", "Debe seleccionar el plan de pago.", "error");
  			return 0;
  		}
      if(!Fecha){
  			swal("Error al guardar", "Debe seleccionar el la fecha de pago.", "error");
  			return 0;
  		}

    	swal({
    		title: "\u00BFEst\u00E1 seguro que desea generar el pago para este grupo?",
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
      	       data:{TipoGuardar:TipoGuardar, IdGrupo:IdGrupo, IdPlan:IdPlan, IdAdmin:IdAdmin, IdCiclo:IdCiclo, Fecha:Fecha},
      	       success:function(data){

      	       }
      	  })
    			.done(function(data) {
    				if(data==1){
    					swal("Generado correctamente", "El pago se ha generado correctamente.", "success");
              $.ajax({
          				 url:"formConsulta/generar_otro_pago_grupo.php",
          				 method:"POST",
          				 data:{IdCiclo:IdCiclo, IdGrupo:IdGrupo, IdPlan:IdPlan},
          				 success:function(data){
          							$('#employee_detailPx').html(data);
          							$('#dataModalPx').modal('show');
          				 }
          		});
    				}
            if(data==0){
    					swal("Error al cargar", "No se puede cargar, verifique sus datos.", "error");
    				}
    			})

          .error(function(e) {
    				swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
    			});

    		}

    	});
  }

  function upd_generar_pg_xid(IdGrupo, IdAdmin, IdCiclo, IdCalendario){
      var TipoGuardar = "upd_gen_pago_xmateria";
      var IdPlan = document.getElementById("txtPlan2").value;
      var Fecha = document.getElementById("txt_fecha2").value;
      if(!IdPlan){
  			swal("Error al guardar", "Debe seleccionar el plan de pago.", "error");
  			return 0;
  		}
      if(!Fecha){
  			swal("Error al guardar", "Debe seleccionar el la fecha de pago.", "error");
  			return 0;
  		}

    	swal({
    		title: "\u00BFEst\u00E1 seguro que desea actualizar la fecha del pago de este concepto?",
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
      	       data:{TipoGuardar:TipoGuardar, Fecha:Fecha, IdCalendario:IdCalendario},
      	       success:function(data){

      	       }
      	  })
    			.done(function(data) {
    				if(data==1){
    					swal("Actualizado correctamente", "La fecha de pago se ha actualizado correctamente.", "success");
              $.ajax({
          				 url:"formConsulta/generar_otro_pago_grupo.php",
          				 method:"POST",
          				 data:{IdCiclo:IdCiclo, IdGrupo:IdGrupo, IdPlan:IdPlan},
          				 success:function(data){
          							$('#employee_detailPx').html(data);
          							$('#dataModalPx').modal('show');
          				 }
          		});
    				}
            if(data==0){
    					swal("Error al cargar", "No se puede cargar, verifique sus datos.", "error");
    				}
    			})

          .error(function(e) {
    				swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
    			});

    		}

    	});
  }

  $(function () {

    //Date picker
    $('#txt_fecha2').datepicker({
      autoclose: true
    })

  })

  function cambiar_plan(IdCiclo, IdGrupo){
    var IdPlan = document.getElementById("txtPlan2").value;
    $.ajax({
				 url:"formConsulta/generar_otro_pago_grupo.php",
				 method:"POST",
				 data:{IdCiclo:IdCiclo, IdGrupo:IdGrupo, IdPlan:IdPlan},
				 success:function(data){
							$('#employee_detailPx').html(data);
							$('#dataModalPx').modal('show');
				 }
		});
  }
</script>

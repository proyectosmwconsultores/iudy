<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST['IdCiclo'];
  $IdGrupo = $_POST['IdGrupo'];


  $sql_lsta = $db->query("SELECT
tblp_beca.IdBeca,
tblp_beca.IdUsua,
tblp_beca.Porcentaje,
tblp_beca.IdEstatus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_beca.Crm,
tblc_estatus.Estatus,
tblp_beca.FecCap,
tblc_convenio.Convenio
FROM
tblp_beca
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_beca.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_beca.IdEstatus
Left Join tblc_convenio ON tblc_convenio.IdConvenio = tblp_beca.IdConvenio
WHERE
tblp_beca.IdCiclo =  '$IdCiclo' AND
tblp_beca.IdConcepto =  '1' AND
tblc_usuario.IdGrupo =  '$IdGrupo'
ORDER BY tblc_usuario.APaterno ASC
");

  $sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);

  $sql_grp = $db->query("SELECT tblp_grupo.TipoCiclo FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_grp);
  $_grp = $db->recorrer($sql_grp);
  if($_grp['TipoCiclo'] == 'C') { $_txG = 'CUATRIMESTRE'; } else { $_txG = 'SEMESTRE'; }
  ?>

  <div class="box-body">
    <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> PERIODO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?></div>
    <table class="table table-striped">
      <tbody>
        <tr style="background: #a6a6a6;">
          <th></th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>ESTATUS DE LA BECA</th>
          <th>CONVENIO</th>
          <th style="text-align: center;">INSCRIPCIÓN</th>
          <th style="text-align: center;">COLEGIATURA</th>
          <th>FEC.CAP</th>
        </tr>
      <?php $g = 0; while($matx = $db->recorrer($sql_lsta)){ $IdUs = $matx['IdUsua'];
        $sql_bec = $db->query("SELECT tblp_beca.Porcentaje FROM tblp_beca WHERE tblp_beca.IdCiclo = '$IdCiclo' AND tblp_beca.IdConcepto = '2' AND tblp_beca.IdUsua = '$IdUs'");
        $db->rows($sql_bec);
        $_bec = $db->recorrer($sql_bec);
         ?>
      <tr <?php if($matx['IdEstatus'] <> 8){ echo "style='color: red;'"; } ?>>
        <td><b><?php echo $g = ($g + 1); ?>.- </b></td>
        <td><?php echo $matx['APaterno'].' '.$matx['AMaterno'].' '.$matx['Nombre']; ?></td>
        <td><?php if($matx['IdEstatus'] <> 8){ echo "<b style='color: blue;'><i class='fa fa-fw fa-warning'></i></b>"; } ?> <?php echo $matx['Estatus']; ?></td>
        <td><?php echo $matx['Convenio']; ?></td>
        <td style="text-align: center;"><?php echo $matx['Porcentaje']; ?>%</td>
        <td style="text-align: center;"><?php echo $_bec['Porcentaje']; ?>%</td>
        <td><?php echo $matx['FecCap']; ?></td>
      </tr><?php } ?>
    </tbody></table>
    <?php if($g == 0){ ?>
      <br>
      <hr>
    <button onclick="generar_beca(<?php echo $IdCiclo.','.$IdGrupo.','.$IdUsua; ?>)" type="button" class="btn btn-block btn-danger btn-sm"><i class="fa fa-gear"></i> Generar beca al grupo</button>
    <?php } ?>
  </div>
  <script>
    function generar_beca(IdCiclo,IdGrupo,IdUsua){
      var TipoGuardar = "renov_beca";
    	swal({
    		title: "\u00BFEst\u00E1 seguro que desea generar las becas automáticas de este grupo?",
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
               data:{TipoGuardar:TipoGuardar, IdCiclo:IdCiclo, IdGrupo:IdGrupo, IdUsua:IdUsua},
               success:function(data){


               }
          })
    			.done(function(data) {
            if(data==1){
              swal("Generado correctamente", "Las becas se han generado correctamente, favor de revisar.", "success");
              load_user_beca();
    				}

    				if(data==0){
    					swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
    				}
    			})
    			.error(function(data) {
    				swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
    			});
    		}

    	});
    }
  </script>

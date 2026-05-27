<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST['IdCiclo'];
  $IdGrupo = $_POST['IdGrupo'];


  $porciones = explode("_", $IdGrupo);
  $Grado =  $porciones[0]; // porción1
  $IdGrupo = $porciones[1]; // porción2

  $sql_lsta = $db->query("SELECT
tblp_beca.IdBeca,
tblp_beca.IdUsua,
tblp_beca.Porcentaje,
tblp_beca.IdEstatus,
tblp_beca.Promedio,
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
tblp_beca.IdConcepto =  '2' AND
tblc_usuario.IdGrupo =  '$IdGrupo'
ORDER BY tblc_usuario.APaterno ASC
");

  $sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);

  $sql_grp = $db->query("SELECT tblp_grupo.TipoCiclo, tblp_educativa.Nombre FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_grp);
  $_grp = $db->recorrer($sql_grp);
  if($_grp['TipoCiclo'] == 'C') { $_txG = 'CUATRIMESTRE'; } else { $_txG = 'SEMESTRE'; }
  ?>

  <div class="box-body">

    <div class="bg-aqua color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-book"></i> </span><?php echo $_grp['Nombre']; ?></b></div>
    <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> PERIODO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?></div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr style="background: #a6a6a6;">
          <th></th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>ESTATUS DE LA BECA</th>
          <th>CONVENIO</th>
          <th style="text-align: center;">COLEGIATURA</th>
          <th>FEC.CAP</th>
          <th style="width: 80px;"></th>
        </tr>
      <?php $g = 0; while($matx = $db->recorrer($sql_lsta)){ $IdUs = $matx['IdUsua'];

         ?>
      <tr <?php if($matx['IdEstatus'] <> 8){ echo "style='color: red;'"; } ?>>
        <td><b><?php echo $g = ($g + 1); ?>.- </b></td>
        <td><?php echo $matx['APaterno'].' '.$matx['AMaterno'].' '.$matx['Nombre']; ?></td>
        <td><?php if($matx['IdEstatus'] <> 8){ echo "<b style='color: blue;'><i class='fa fa-fw fa-warning'></i></b>"; } ?> <?php echo $matx['Estatus']; ?></td>
        <td><?php echo $matx['Convenio']; ?></td>
        <td style="text-align: center;"><?php echo $matx['Porcentaje']; ?>%</td>
        <td><?php echo $matx['FecCap']; ?></td>
        <td>
          <button onclick="modificar_beca(<?php echo $matx['IdUsua']; ?>,<?php echo $IdCiclo; ?>)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-fw fa-cog"></i></button>
          <button onclick="window.open('repositorio/portafolio/convenio_beca.php?id=<?php echo time().$IdUs; ?>&idToks=<?php echo time().$IdCiclo; ?>','_blank')" href="javascript:void(0);" title="Descargar convenio de beca" type="button" class="btn bg-maroon btn-flat btn-xs"><i class="fa fa-fw fa-file-pdf-o"></i></button>
        </td>
      </tr><?php } ?>
    </tbody></table>
    <br>

    <?php if($g == 0){ ?>
      <br>
      <hr>
    <button onclick="generar_beca(<?php echo $IdCiclo.','.$IdGrupo.','.$IdUsua; ?>)" type="button" class="btn btn-block btn-danger btn-sm"><i class="fa fa-gear"></i> Generar beca al grupo</button>
    <?php } ?>
    <?php if($g > 1){ ?>

    <!-- <div class="col-md-12">
      <div class="form-group">
        <div class="bg-navy-active color-palette" style="padding: 10px;"><span>En este espacio podra modificar la beca de todo el grupo</span></div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Tipo de beca:</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-fw fa-key"></i>
          </div>
          <select class="form-control" name="txt_tipox" id="txt_tipox">
            <option value=""> - Seleccione - </option>
            <option value="2">COLEGIATURA</option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Porcentaje:</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-fw fa-key"></i>
          </div>
          <input type="text" name="txt_porx" id="txt_porx" class="form-control">
          <span class="input-group-btn">
            <button onclick="modificar_bex(<?php echo $IdCiclo; ?>,<?php echo $IdGrupo; ?>,<?php echo $_SESSION['IdUsua']; ?>)" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Generar beca</button>
          </span>
        </div>
      </div>
    </div> -->
  <?php } ?>
  </div>


  <script>
  function modificar_bex(IdCiclo,IdGrupo,IdUsua){
    var IdConcepto = document.getElementById("txt_tipox").value;
		var Porcentaje = document.getElementById("txt_porx").value;

		if(IdConcepto ==''){
			swal("Error al guardar", "Debe seleccionar el tipo de beca.", "error");
			return 0;
		}
		if(Porcentaje == ''){
			swal("Error al guardar", "Debe escribir el porcentaje de beca.", "error");
			return 0;
		}

      var TipoGuardar = "renov_beca_grp";
    	swal({
    		title: "\u00BFEst\u00E1 seguro que desea renovar la beca de todo este grupo?",
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
               data:{TipoGuardar:TipoGuardar, IdCiclo:IdCiclo, IdGrupo:IdGrupo, IdUsua:IdUsua, IdConcepto:IdConcepto, Porcentaje:Porcentaje},
               success:function(data){
// alert(data);

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

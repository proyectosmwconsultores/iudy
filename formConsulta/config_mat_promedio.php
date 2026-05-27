<?php
include('../hace.php');
if(isset($_POST["IdGrupo"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST['IdGrupo'];


  $sqle9 = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_grupo.IdOferta, tblp_grupo.IdCampus, tblc_campus.Campus FROM tblp_grupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
  $db->rows($sqle9);
  $datose91 = $db->recorrer($sqle9);

  $sqle8 = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo' ");
  $db->rows($sqle8);
  $datose81 = $db->recorrer($sqle8);

  $sqle7 = $db->query("SELECT tblc_ciclogrupo.Grado FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdCiclo = '$IdCiclo' AND tblc_ciclogrupo.IdGrupo = '$IdGrupo'");
  $db->rows($sqle7);
  $datose71 = $db->recorrer($sqle7);
  $_grad = $datose71['Grado'];


  $sql_mat = $db->query("SELECT tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_asignacion.IdAsignacion, tblp_asignacion.IdEstatus, tblc_ciclo.Ciclo FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.Tipo = '2' ORDER BY tblp_modulo.CodeModulo ASC ");


  $sql_all_mat = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_modulo.IdEducativa FROM tblp_modulo WHERE tblp_modulo.IdCampus =  '".$datose91['IdCampus']."' AND tblp_modulo.IdEducativa =  '".$datose91['IdOferta']."' AND tblp_modulo.Grado = '$_grad' ORDER BY tblp_modulo.CodeModulo ASC ");

?>

<div class="box-info">
  <form class="form-horizontal" name="frmx" id="frmx" action="addSubPeriodo.php" method="POST" enctype="multipart/form-data">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Campus:</label>
        <div class="col-sm-8">
          <input type="text" disabled class="form-control" value="<?php echo $datose91['Campus']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">CveGrupo:</label>
        <div class="col-sm-8">
          <input type="text" disabled class="form-control" value="<?php echo $datose91['CveGrupo']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Periodo escolar:</label>
        <div class="col-sm-8">
          <input type="text" disabled class="form-control" value="<?php echo $datose81['Ciclo']; ?>">
        </div>
      </div>
  </form>
</div>
          <div class="bg-navy-active color-palette" style="padding: 10px;"><span><i class="fa fa-edit"></i> Materias agregadas para captura de promedio final</span></div>
          <table class="table table-striped" style="font-size: 12px;">
                <tbody>
                  <tr>
                    <th style="text-align: center;">Grado</th>
                    <th>Nombre de la materia</th>
                    <th>Periodo escolar</th>
                </tr>
              <?php while($_mat = $db->recorrer($sql_mat)){ $id = $_mat["IdEstatus"];
                if(($id == 8) || ($id == 12)){ $_txt = "<br><b style='color: blue;'>(Activo en Plataforma)</b>"; } else { $_txt = ""; }
                 ?>
                <tr>
                  <td style="text-align: center;"><?php echo substr($_mat["CodeModulo"], 3, 1); ?>°</td>
                  <td><?php echo $_mat["CodeModulo"].' - '.$_mat["NombreMod"].$_txt; ?></td>
                  <td><?php echo $_mat["Ciclo"]; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table><br>
            <div class="bg-orange-active color-palette" style="padding: 45; font-size: 25px; text-align: center;"><span style="color: black;">Si usted realiza alguna carga de lista se vera reflejado en este periodo escolar:<br> <b style="color: blue;"><?php echo $datose81['Ciclo']; ?></b></span></div>

            <div class="bg-red-active color-palette" style="padding: 10px;"><span><i class="fa fa-exclamation-circle"></i> Materias libres para poder asignarlos a este Periodo Escolar</span></div>
            <table class="table table-striped" style="font-size: 12px;">
              <tbody>
                <tr>
                  <th style="text-align: center;">Grado</th>
                  <th>Nombre de la materia</th>
                  <th style="text-align: center;">Ajuste</th>
              </tr>
            <?php $idc = $datose91['IdCampus']; $_vb = 0;
              while($_all_mat = $db->recorrer($sql_all_mat)){
              $id_mod = $_all_mat['IdModulo'];
              $sqle9 = $db->query("SELECT tblp_asignacion.IdModulo FROM tblp_asignacion WHERE tblp_asignacion.IdModulo = '$id_mod' AND tblp_asignacion.IdCampus =  '$idc' AND tblp_asignacion.IdGrupo =  '$IdGrupo' ");
              $db->rows($sqle9);
              $datose91 = $db->recorrer($sqle9);
              $_idM = $datose91['IdModulo'];
              if($_idM){
                $_vb = 1;
              } else {
                $_vb = 0;
              }

              if($_vb == 0){
               ?>
              <tr>
                <td style="text-align: center;"><?php echo substr($_all_mat["CodeModulo"], 3, 1); ?>°</td>
                <td><?php echo $_all_mat["CodeModulo"].' - '.$_all_mat["NombreMod"]; ?></td>
                <td><button onclick="car_mat_promx(<?php echo $_all_mat["IdModulo"].','.$idc.','.$IdCiclo.','.$IdGrupo.','.$_all_mat["IdEducativa"]; ?>)" type="button" class="btn btn-danger"><i class="fa fa-users"></i> Cargar materia</button></td>
              </tr>
            <?php } } ?>
            </tbody>
          </table>
<?php } ?>
<script>
  function car_mat_promx(IdModulo, IdCampus, IdCiclo, IdGrupo, IdOferta){
    var TipoGuardar = "load_mat_prom";

  	swal({
  		title: "\u00BFEst\u00E1 seguro que desea cargar la lista de alumnos de esta materia para poner promedio final?",
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
    	       data:{TipoGuardar:TipoGuardar, IdModulo:IdModulo, IdCiclo:IdCiclo, IdGrupo:IdGrupo, IdOferta:IdOferta},
    	       success:function(data){

    	       }
    	  })
  			.done(function(data) {
  				if(data==1){
  					swal("Cargado correctamente", "La lista de alumnos de la materia se ha cargado correctamente.", "success");
            cargar_materias();
            $.ajax({
        				 url:"formConsulta/config_mat_promedio.php",
        				 method:"POST",
        				 data:{IdCiclo:IdCiclo,IdGrupo:IdGrupo},
        				 success:function(data){
        							$('#employee_prom').html(data);
        							$('#dataProm').modal('show');
        				 }
        		});

  				}


          if(data==0){
  					swal("Error al cargar", "No se puede cargar, verifique sus datos.", "error");
  				}
  			})

  		}

  	});
  }
</script>

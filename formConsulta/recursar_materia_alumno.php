<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $anio = date("Y");
  $IdUsua = $_POST["IdUsua"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdCiclo = $_POST["IdCiclo"];

  $sql_us = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql_us);
  $_user = $db->recorrer($sql_us);
  $_idOferta = $_user['IdOferta'];
  $_idCampus = $_user['IdCampus'];

  $sql_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio = '$anio' ");
  

  $sql_grp = $db->query("SELECT
  tblc_ciclogrupo.IdGrupo,
  tblp_grupo.CveGrupo,
  tblc_dias_clases._Dias,
  tblc_ciclogrupo.Grado
  FROM
  tblc_ciclogrupo
  Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
  Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
  WHERE tblc_ciclogrupo.IdCiclo = '$IdCiclo' AND tblp_grupo.IdOferta = '$_idOferta' AND tblp_grupo.IdCampus = '$_idCampus' ");
  
  $sql_mat = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_asignacion.IdEstatus FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdCiclo = '$IdCiclo' ");

  
  $sql_recx = $db->query("SELECT
  tblp_moduloalumno.IdModuloAlumno,
  tblp_modulo.CodeModulo,
  tblp_modulo.NombreMod,
  tblp_grupo.CveGrupo,
  tblc_ciclo.Ciclo,
  tblc_usuario.Nombre,
  tblc_usuario.APaterno,
  tblc_usuario.AMaterno
  FROM
  tblp_moduloalumno
  Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
  Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_moduloalumno.IdGrupo
  Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
  Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
  Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
WHERE
tblp_moduloalumno.IdUsua =  '$IdUsua' AND
tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.Tipo =  '2' ORDER BY tblp_modulo.CodeModulo ASC
 ");

  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
    <div class="box-body">
          <div class="form-group">
            <label class="col-sm-4 control-label">Periodo escolar:</label>
            <div class="col-sm-8">
              <select class="form-control" name="txt_cic_esc" id="txt_cic_esc"  onchange="sel_ciclo_esc(<?php echo $IdUsua; ?>,<?php echo $IdGrupo; ?>)">
                <option value=""> - Seleccione - </option>
                <?php while($_cicx = $db->recorrer($sql_cic)){ ?>
                <option value="<?php echo $_cicx["IdCiclo"]; ?>" <?php if($_cicx["IdCiclo"] == $IdCiclo ){ ?>selected="selected"<?php } ?>> <?php echo $_cicx["Ciclo"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Grupo:</label>
            <div class="col-sm-8">
              <select class="form-control" name="txt_grp_rec" id="txt_grp_rec"  onchange="sel_grupo_rec(<?php echo $IdUsua; ?>,<?php echo $IdCiclo; ?>)">
                <option value=""> - Seleccione - </option>
                <?php while($_grp = $db->recorrer($sql_grp)){ ?>
                <option value="<?php echo $_grp["IdGrupo"]; ?>" <?php if($_grp["IdGrupo"] == $IdGrupo ){ ?>selected="selected"<?php } ?>> <?php echo $_grp["Grado"]; ?>° <?php echo $_grp["CveGrupo"]; ?> / <?php echo $_grp["_Dias"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Lista de materias:</label>
            <div class="col-sm-8">
              <select class="form-control" name="txt_mat_rec" id="txt_mat_rec">
                <option value=""> - Seleccione - </option>
                <?php while($_mat = $db->recorrer($sql_mat)){ ?>
                <option value="<?php echo $_mat["IdModulo"].'_'.$_mat["IdAsignacion"]; ?>"> <?php echo $_mat["CodeModulo"]; ?> <?php echo $_mat["NombreMod"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
      </div>
    <div class="box-footer">
      <button type="button" class="btn btn-block btn-info btn" onClick="ejecutar_recursar(<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>,<?php echo $IdCiclo; ?>,<?php echo $IdGrupo; ?>)" > <i class="fa fa-save"></i> Guardar configuraci&oacute;n</button></td>
    </div>

    <table class="table table-striped" style="font-size: 12px;">
      <tbody><tr>
        <th style="width: 10px">#</th>
        <th>Nombre de la materia</th>
        <th>Grupo</th>
        <th>Periodo escolar</th>
        <th>Docente</th>
        <th></th>
      </tr>
      <?php $h = 0; while($y = $db->recorrer($sql_recx)){ ?>
      <tr>
        <td><b><?php echo $h = $h + 1; ?>.- </b></td>
        <td><?php echo $y["CodeModulo"]; ?> <?php echo $y["NombreMod"]; ?></td>
        <td><?php echo $y["CveGrupo"]; ?></td>
        <td><?php echo $y["Ciclo"]; ?></td>
        <td><?php echo $y["Nombre"].' '.$y["APaterno"].' '.$y["AMaterno"]; ?></td>
        <td>
        <button onclick="del_materia_asig(<?php echo $IdUsua; ?>,<?php echo $y["IdModuloAlumno"]; ?>,<?php echo $IdCiclo; ?>)" type="button" class="btn bg-navy btn-flat btn-sm"><i class="fa fa-fw fa-trash"></i></button>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </form>
<script>
function ejecutar_recursar(IdUsua,IdAdmin,IdCiclo, IdGrupo){
  var IdModulo = document.getElementById("txt_mat_rec").value;

  if (IdGrupo==""){
		swal("Error al guardar", "Debe seleccionar el grupo.", "error");
        document.getElementById("txt_grp_rec").focus();
        return 0;
  }
  if (IdModulo==""){
		swal("Error al guardar", "Debe seleccionar la materia que le desea asignar a alumno.", "error");
        document.getElementById("txt_mat_rec").focus();
        return 0;
  }

    var TipoGuardar = "recursar_mater_id";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea agregar esta materia al alumno?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Aceptar',
      cancelButtonText: "Cancelar",
    },
    function (isConfirm) {
      if(isConfirm) {
        $(".confirm").attr('disabled', 'disabled');
        $.ajax({
             url:"formConsulta/setting.php",
             method:"POST",
             data:{TipoGuardar:TipoGuardar, IdGrupo:IdGrupo, IdModulo:IdModulo, IdUsua:IdUsua, IdCiclo:IdCiclo},
             success:function(data){
              
             }
        })
        .done(function(data) {
          if (data == 0) {
            swal("Error al guardar", "Este proceso no se pudo realizar favor de revisar.", "error");
          }
          if(data == 1){
            swal("Guardado correctamente", "La materia ha sido asignado al alumno correctamente.", "success");
            var IdGrupo = 0;
            $.ajax({
              url: "formConsulta/recursar_materia_alumno.php",
              method: "POST",
              data: {
                IdUsua: IdUsua,
                IdGrupo: IdGrupo,
                IdCiclo:IdCiclo
              },
              success: function(data) {
                $('#employee_detail_rec').html(data);
                $('#dataModal_rec').modal('show');
              }
            });
          }

        })
        .error(function(data) {
          swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
        });
      }
    });

}


function del_materia_asig(IdUsua,IdModulo,IdCiclo){
    var TipoGuardar = "del_asignacion_materia_id";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea eliminar esta materia del alumno?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Aceptar',
      cancelButtonText: "Cancelar",
    },
    function (isConfirm) {
      if(isConfirm) {
        $(".confirm").attr('disabled', 'disabled');
        $.ajax({
             url:"formConsulta/setting.php",
             method:"POST",
             data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdModulo:IdModulo},
             success:function(data){

             }
        })
        .done(function(data) {
          if (data == 0) {
            swal("Error al guardar", "Este proceso no se pudo realizar favor de revisar.", "error");
          }
          if(data == 1){
            swal("Eliminado correctamente", "La materia ha sido eliminado correctamente  del perfil del alumno.", "success");
            var IdGrupo = 0;
            $.ajax({
              url: "formConsulta/recursar_materia_alumno.php",
              method: "POST",
              data: {
                IdUsua: IdUsua,
                IdGrupo: IdGrupo,
                IdCiclo:IdCiclo
              },
              success: function(data) {
                $('#employee_detail_rec').html(data);
                $('#dataModal_rec').modal('show');
              }
            });
          }

        })
        .error(function(data) {
          swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
        });
      }
    });

}


function sel_grupo_rec(IdUsua, IdCiclo){
  var IdGrupo = document.getElementById("txt_grp_rec").value;
	$.ajax({
			 url:"formConsulta/recursar_materia_alumno.php",
			 method:"POST",
			 data:{IdUsua:IdUsua, IdGrupo:IdGrupo, IdCiclo:IdCiclo},
			 success:function(data){
						$('#employee_detail_rec').html(data);
						$('#dataModal_rec').modal('show');
			 }
	});
}

function sel_ciclo_esc(IdUsua, IdGrupo){
  var IdCiclo = document.getElementById("txt_cic_esc").value;
	$.ajax({
			 url:"formConsulta/recursar_materia_alumno.php",
			 method:"POST",
			 data:{IdUsua:IdUsua, IdGrupo:IdGrupo, IdCiclo:IdCiclo},
			 success:function(data){
						$('#employee_detail_rec').html(data);
						$('#dataModal_rec').modal('show');
			 }
	});
}
</script>

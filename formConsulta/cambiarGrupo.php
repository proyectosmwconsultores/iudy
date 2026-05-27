<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = substr($_POST["Token"], 10, 10);
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  $IdCiclo = $_POST["IdCiclo"];
  $anio = date("Y");
  


  $sqle9 = $db->query("SELECT tblc_usuario.IdGrupo, tblc_usuario.Usuario, tblc_usuario.IdCampus, tblc_usuario.IdOferta, tblp_grupo.TipoCiclo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sqle9);
  $datose91 = $db->recorrer($sqle9);
  $IdGrupo = $datose91['IdGrupo'];
  $Usuario = $datose91['Usuario'];
  $TipoCiclo = $datose91['TipoCiclo'];

  if($datose91['TipoCiclo'] == 'C'){
    $tipoC = "CUATRIMESTRE";
  } elseif($datose91['TipoCiclo'] == 'S'){
    $tipoC = "SEMESTRE";
  } else {
    $tipoC = "TRIMESTRE";
  }

  $sql_cic_pers = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$tipoC' AND tblc_ciclo._activo = '1' ORDER BY tblc_ciclo.FInicio DESC LIMIT 3"); 

  $anio = substr($anio, 2, 2);

  $sql1 = $db->query("SELECT tblc_campus.IdCampus, tblc_campus.Campus FROM tblc_campus WHERE tblc_campus._visible = '1'");
  $sqlx = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa");


  

  $sql_grp = $db->query("SELECT
  tblc_ciclogrupo.Grado,
  tblc_ciclogrupo.IdGrupo,
  tblp_grupo.CveGrupo,
  tblc_dias_clases._Dias,
  tblp_educativa.Abreviatura
  FROM
  tblc_ciclogrupo
  Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
  Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
  WHERE
  tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblp_grupo.IdCampus = '$IdCampus' ORDER BY tblp_grupo.IdOferta ASC, tblc_ciclogrupo.Grado ASC
  ");

  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>


    <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none; margin-top: -5px;">

        <div class="col-md-12">
          <div class="form-group">
            <label>Campus:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-bank"></i>
              </div>
              <select class="form-control" name="txtCampus" id="txtCampus" onchange="cambioCampus(<?php echo $IdCiclo; ?>,<?php echo $IdOferta; ?>)">
                <option value=""> - Seleccione - </option>
                <?php while($y2 = $db->recorrer($sql1)){ ?>
                <option class="form-control"  value="<?php echo $y2["IdCampus"]; ?>"  <?php if($IdCampus==$y2["IdCampus"]){?>selected="selected"<?php }?>> <?php echo $y2["Campus"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Periodo escolar-:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-flag"></i>
              </div>
              <select class="form-control" name="txtCiclo" id="txtCiclo" onchange="cambioCiclo(<?php echo $IdOferta; ?>)">
                <option value=""> - Seleccione - </option>
                <?php while ($_perx = $db->recorrer($sql_cic_pers)) { ?>
              <option value="<?php echo $_perx["IdCiclo"]; ?>" <?php if ($_perx["IdCiclo"] == $IdCiclo) { ?>selected="selected" <?php } ?>> <?php echo $_perx["Ciclo"]; ?> </option>
            <?php } ?>
              </select>
            </div>
          </div>
        </div>
        
        <div class="col-md-12">
          <div class="form-group">
            <label>Clave de grupo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-book"></i>
              </div>
              <select class="form-control" name="txtGrupo" id="txtGrupo">
                <option value=""> - Seleccione - </option>
                <?php while($x2 = $db->recorrer($sql_grp)){ ?>
                <option class="form-control"  value="<?php echo $x2["IdGrupo"]; ?>"  <?php if($IdGrupo==$x2["IdGrupo"]){?>selected="selected"<?php }?>> <?php echo $x2["Grado"]; ?>° <?php echo $x2["CveGrupo"]; ?> / <?php echo $x2["_Dias"]; ?> / (<?php echo $x2["Abreviatura"]; ?>)</option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12" style="font-size: 13px;">
          <div class="form-group">
          <div class="bg-navy-active color-palette" style='padding: 5px;'><span><b>Nota:</b> al realizar el cambio de grupo se le cargará las materias del nuevo grupo donde se le asignará.</span></div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Comentario adicional:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-wechat"></i>
              </div>
              <textarea name="txt_comentario" id="txt_comentario" class="form-control" rows="3" placeholder="Enter ..."></textarea>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
              <button type="button" class="btn btn-block btn-info" onclick="cambiarGrupo_ok(<?php echo $_SESSION['IdUsua']; ?>,<?php echo $IdOferta; ?>)"> <i class="fa fa-save"></i> Cambiar grupo</button>
          </div>
        </div>


      </div>

    </table>
  </div>

  </form>
<script>

function cambioCampus(IdCiclo, IdOferta){
  var IdCampus = document.getElementById("txtCampus").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var Token = "4578954120"+IdUsua;

	$.ajax({
			 url:"formConsulta/cambiarGrupo.php",
			 method:"POST",
			 data:{Token:Token,IdCampus:IdCampus, IdCiclo:IdCiclo, IdOferta:IdOferta},
			 success:function(data){
						$('#employee_Grp').html(data);
						$('#dataGrp').modal('show');
			 }
	});

}

function cambioCiclo(IdOferta){
  var IdCiclo = document.getElementById("txtCiclo").value;
  var IdCampus = document.getElementById("txtCampus").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var Token = "4578954120"+IdUsua;

	$.ajax({
			 url:"formConsulta/cambiarGrupo.php",
			 method:"POST",
			 data:{Token:Token,IdCampus:IdCampus, IdCiclo:IdCiclo, IdOferta:IdOferta},
			 success:function(data){
						$('#employee_Grp').html(data);
						$('#dataGrp').modal('show');
			 }
	});

}

function cambioOferta(){
  var IdCampus = document.getElementById("txtCampus").value;
  var IdOferta = document.getElementById("txtOferta").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var Token = "4578954120"+IdUsua;

	$.ajax({
			 url:"formConsulta/cambiarGrupo.php",
			 method:"POST",
			 data:{Token:Token,IdCampus:IdCampus,IdOferta:IdOferta},
			 success:function(data){
						$('#employee_Grp').html(data);
						$('#dataGrp').modal('show');
			 }
	});

}

function cambiarGrupo_ok(IdAdmin,IdOferta){
    var IdCampus = document.getElementById("txtCampus").value;
    var IdUsua = document.getElementById("IdUsua").value;
    
    var IdGrupo = document.getElementById("txtGrupo").value;
    var IdCiclo = document.getElementById("txtCiclo").value;
    var Comentario = document.getElementById("txt_comentario").value;

    if (IdCampus ==""){
        swal("Error al guardar", "Debe seleccionar el campus.", "error");
        return 0;
    }
    if (IdCiclo ==""){
        swal("Error al guardar", "Debe seleccionar la el periodo escolar.", "error");
        return 0;
    }
    if (IdGrupo ==""){
        swal("Error al guardar", "Debe seleccionar el grupo.", "error");
        return 0;
    }
    if (Comentario ==""){
        swal("Error al guardar", "Debe escribir el comentario por el motivo de cambio de grupo.", "error");
        return 0;
    }

    var TipoGuardar = "savChangeGrp";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea cambiar de grupo a este alumno?",
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
             data:{TipoGuardar:TipoGuardar, IdAdmin:IdAdmin, IdUsua:IdUsua, IdGrupo:IdGrupo, IdCampus:IdCampus, IdOferta:IdOferta, IdCiclo:IdCiclo, Comentario:Comentario},
             success:function(data){
              
             }
        })
        .done(function(data) {

          if(data==1){
            swal("Guardado correctamente", "El cambio de grupo se ha realizaco correctamente.", "success");
            parent.location.href='perfil.php?token=1598989985'+IdUsua; //direcciona la pagina madre
          }
          if(data==3){
            swal("Error al guardar", "Favor de verificar con el área de administración ya que no se ha creado el concepto de reinscripcion.", "error");
          }
          if(data==2){
            swal("Error al guardar", "Favor de verificar con el área de administración ya que no se ha creado el concepto de las mensualidades.", "error");
          }
          if(data==0){
            swal("Error al guardar", "Ha ocurrido un error no se ha podido realizar el cambio de grupo.", "error");
          }

        })
        .error(function(data) {
          swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
        });
      }
    });

}

</script>

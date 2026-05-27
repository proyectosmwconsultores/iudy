<?php
session_start();
if(isset($_POST["IdCiclo"])){
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST["IdCiclo"];
  $IdAdmin = $_SESSION['IdUsua'];
  $IdUsua = $_POST['IdUsua'];

  $IdBeca_col = 0;


  $sql_col = $db->query("SELECT tblp_beca.IdBeca, tblp_beca.Comentario, tblp_beca.IdEstatus, tblp_beca.IdConvenio, tblp_beca.Promedio, tblp_beca.Porcentaje FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' AND tblp_beca.IdConcepto = '2'");
  $db->rows($sql_col);
  $_col = $db->recorrer($sql_col);

  $sql_con = $db->query("SELECT * FROM tblc_convenio ORDER BY tblc_convenio.Convenio ASC ");
  if($_col['IdBeca']){ $IdBeca_col = $_col['IdBeca']; } else { $IdBeca_col = 0;}
?>

<div class="box-info">
  <form class="form-horizontal" name="frmx" id="frmx" action="addSubPeriodo.php" method="POST" enctype="multipart/form-data">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Convenio de beca:</label>
        <div class="col-sm-8">
          <select name="txtConvenio" id="txtConvenio" class="form-control">
            <option value=""> - Seleccione - </option>
            <?php while($_con = $db->recorrer($sql_con)){ ?>
              <option value="<?php echo $_con['IdConvenio']; ?>" <?php if($_col['IdConvenio']==$_con['IdConvenio']){ ?>selected="selected"<?php } ?>> <?php echo $_con['Convenio'] ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-8 control-label">Porcentaje colegiatura:</label>
        <div class="col-sm-4">
          <input type="number" name="txtCol" id="txtCol" class="form-control" value="<?php echo $_col['Porcentaje']; ?>">
        </div>
      </div>
      </div>
      <div class="form-group">
        <label class="col-sm-8 control-label">Estatus de la beca:</label>
        <div class="col-sm-4">
          <select name="txtEstatus" id="txtEstatus" class="form-control">
            <option value=""> - Seleccione - </option>
              <option value="8" <?php if($_col['IdEstatus'] == 8){ ?>selected="selected"<?php } ?>> ACTIVO </option>
              <option value="1" <?php if($_col['IdEstatus'] == 1){ ?>selected="selected"<?php } ?>> PENDIENTE </option>
              <option value="22" <?php if($_col['IdEstatus'] == 22){ ?>selected="selected"<?php } ?>> CADUCADO </option>
          </select>
        </div>
      </div>
      <!-- <div class="form-group">
        <label class="col-sm-8 control-label">Promedio del periodo escolar anterior:</label>
        <div class="col-sm-4">
          <input type="text" disabled class="form-control" value="<?php echo $_col['Promedio']; ?>">
        </div>
      </div> -->
      <div class="form-group">
        <label class="col-sm-4 control-label" style="text-align: left;">Comentario Adicional:</label>
        <div class="col-sm-12">
          <textarea name="txt_comex" id="txt_comex" class="form-control" rows="3" placeholder="Enter ..."><?php if(isset($_col['Comentario'])){ echo $_col['Comentario']; } ?></textarea>
        </div>
      </div>

  </form>
</div>
<div class="box-footer" style="text-align: right;">
<button onclick="modificar_beca_id(<?php echo $IdBeca_col.','.$IdAdmin.','.$IdCiclo.','.$IdUsua; ?>)" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-refresh"></i> Actualizar beca</button>
</div>
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

  function modificar_beca_id(IdCol, IdAdmin, IdCiclo, IdUsua){
      var TipoGuardar = "mod_beca_usua";
      var IdConvenio = document.getElementById("txtConvenio").value;
      var Col = document.getElementById("txtCol").value;
      var IdEstatus = document.getElementById("txtEstatus").value;
      var Comentario = document.getElementById("txt_comex").value;
      if(Comentario == ''){
  			swal("Error al guardar", "Debe escribir el motivo del cambio de beca.", "error");
  			return 0;
  		}

    	swal({
    		title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de esta beca de este alumno?",
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
      	       data:{TipoGuardar:TipoGuardar, IdConvenio:IdConvenio, Col:Col, IdEstatus:IdEstatus, IdCol:IdCol, IdAdmin:IdAdmin, IdCiclo:IdCiclo, IdUsua:IdUsua, Comentario:Comentario},
      	       success:function(data){

      	       }
      	  })
    			.done(function(data) {
    				if(data==1){
    					swal("Guardado correctamente", "La beca del alumno se ha guardado correctamente.", "success");
              load_user_beca();
              $.ajax({
          				 url:"formConsulta/configurar_beca_alumno.php",
          				 method:"POST",
          				 data:{IdCiclo:IdCiclo,IdUsua:IdUsua},
          				 success:function(data){
          							$('#employee_promxi').html(data);
          							$('#data_promxi').modal('show');
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
</script>

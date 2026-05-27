<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdSemanaDoc = $_POST["IdSemana"];


$sql9 = $db->query("SELECT tblp_semanadocente.Tipo, tblp_semanadocente.Nombre, tblp_semanadocente.Code FROM tblp_semanadocente WHERE tblp_semanadocente.IdSemanaDocente = '$IdSemanaDoc' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);


  ?>
  <form name="frm2s_Far" id="frm2s_Far" action="updSemana.php" method="POST" enctype="multipart/form-data">
    <input id="IdSemanaDoc" name="IdSemanaDoc" value="<?php echo $IdSemanaDoc; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="addPresent" type="hidden"/>
    <div class="box box-primary" style="border-top: none;">
      <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Tipo de presentación:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-black-tie"></i>
              </div>
              <select class="form-control" name="txtTipox" id="txtTipox" >
                <option value=""> - Seleccione - </option>
                <option value="canva" <?php if($datos91["Tipo"] == 'canva'){ ?>selected="selected"<?php } ?>> Presentación en Canva </option>
                <option value="genially" <?php if($datos91["Tipo"] == 'genially'){ ?>selected="selected"<?php } ?>> Presentación en Genially </option>
                <option value="google" <?php if($datos91["Tipo"] == 'google'){ ?>selected="selected"<?php } ?>> Presentación en Google Slides </option>
                <option value="youtube" <?php if($datos91["Tipo"] == 'youtube'){ ?>selected="selected"<?php } ?>> Presentación en YouTube </option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Nombre de la presentación:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-align-left"></i>
              </div>
              <input type="text" name="txtNombrex" id="txtNombrex" class="form-control" value="<?php echo $datos91["Nombre"]; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Insertar código HTML:</label>
              <textarea name="txtCodex" id="txtCodex" class="form-control" rows="3" placeholder="Insertar código HTML"><?php echo $datos91["Code"]; ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="addPresent()"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
          <?php if(isset($datos91["Tipo"])){ ?>
          <button type="button" class="btn btn-warning pull-right" onClick="delPresentacion(<?php echo $IdSemanaDoc; ?>)"> <i class="fa fa-fw fa-trash"></i> Eliminar presentación</button>
          <?php } ?>
        </div>
        <div class="col-md-12">
          <?php echo $datos91["Code"]; ?>
        </div>



      </div>

    </div>

  </form>
<script>
  function delPresentacion(IdSemana){
    var TipoGuardar = "del_presentacion";
    swal({
  		title: "\u00BFEst\u00E1 seguro que desea eliminar esta presentación?",
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: '#DD6B55',
  		confirmButtonText: 'Aceptar',
  		cancelButtonText: "Cancelar",
  	},
  	function (isConfirm) {
  		if (isConfirm) {
  			$(".confirm").attr('disabled', 'disabled');
        var datos = 'TipoGuardar=' + TipoGuardar + '&IdSemana=' + IdSemana;
  			$.ajax({
  				type:"POST",
  				url:"formConsulta/setting.php",
  				data:datos,
  				success:function(data){

  				}
  			})
  			.done(function(data) {
          if(data==1){
  					swal("Eliminado correctamente", "La presentación se ha eliminado correctamente.", "success");
            $.ajax({
        				 url:"formConsulta/addPresentacion.php",
        				 method:"POST",
        				 data:{IdSemana:IdSemana},
        				 success:function(data){
        							$('#employee_pre').html(data);
        							$('#dataPre').modal('show');
        				 }
        		});

  				}
  				if(data==0){
  					swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
  				}
  			})
  			.error(function(data) {
  				swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
  			});
  		}

  	});
  }
</script>

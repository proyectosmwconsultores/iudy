<?php
session_start();
if(isset($_POST["IdBeca"])){
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdBeca = $_POST["IdBeca"];
  $IdAdmin = $_SESSION['IdUsua'];

  $sql_beca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdBeca =  '$IdBeca'");
  $db->rows($sql_beca);
  $_becx = $db->recorrer($sql_beca);

?>

<div class="box-info">
  <form class="form-horizontal" name="frmx" id="frmx" action="addSubPeriodo.php" method="POST" enctype="multipart/form-data">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-8 control-label">Monto:</label>
        <div class="col-sm-4">
          <input disabled type="text" class="form-control" value="<?php echo $_becx['Importe']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-8 control-label">Importe a pagar:</label>
        <div class="col-sm-4">
          <input type="number" name="txt_importe" id="txt_importe" class="form-control" value="<?php echo $_becx['Total']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-8 control-label">Estatus de la beca:</label>
        <div class="col-sm-4">
          <select name="txtEstatus" id="txtEstatus" class="form-control">
            <option value=""> - Seleccione - </option>
              <option value="8" <?php if($_becx['IdEstatus'] == 8){ ?>selected="selected"<?php } ?>> ACTIVO </option>
              <option value="1" <?php if($_becx['IdEstatus'] == 1){ ?>selected="selected"<?php } ?>> PENDIENTE </option>
              <option value="22" <?php if($_becx['IdEstatus'] == 22){ ?>selected="selected"<?php } ?>> CADUCADO </option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label" style="text-align: left;">Comentario adicional:</label>
        <div class="col-sm-12">
          <textarea name="txt_comex" id="txt_comex" class="form-control" rows="3" placeholder="Enter ..."><?php if(isset($_ins['Comentario'])){ echo $_ins['Comentario']; } ?></textarea>
        </div>
      </div>

  </form>
</div>

<div class="box-footer" style="text-align: right;">
<button onclick="modificar_beca_ixd(<?php echo $IdAdmin.','.$_becx['Importe'].','.$IdBeca; ?>)" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-refresh"></i> Actualizar beca</button>
</div>
<?php  } ?>
<script>


  function modificar_beca_ixd(IdAdmin, Monto, IdBeca){
      var TipoGuardar = "mod_beca_usua_x_admin";
      var Importe = document.getElementById("txt_importe").value;
      var IdEstatus = document.getElementById("txtEstatus").value;
 
      var Comentario = document.getElementById("txt_comex").value;
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
      	       data:{TipoGuardar:TipoGuardar, Importe:Importe, IdEstatus:IdEstatus, Monto:Monto, IdAdmin:IdAdmin, Comentario:Comentario, IdBeca:IdBeca},
      	       success:function(data){
                
      	       }
      	  })
    			.done(function(data) {
    				if(data==1){
    					swal("Actualizado correctamente", "La beca del alumno se ha actualizado correctamente.", "success");

              $.ajax({
          				 url:"formConsulta/configurar_beca_alumno_id.php",
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

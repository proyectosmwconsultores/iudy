<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsuaRecibe = $_POST["IdUsuaRecibe"];
  $IdUsuaEnvia = $_POST["IdUsuaEnvia"];

  //$sql = $db->query("SELECT * FROM tblp_recurso WHERE tblp_recurso.IdActividad = '$IdActividad'");

  ?>
  <link rel="stylesheet" href="assets/dist/css/main.css">
  <div class="principal">
    <form action="" id="form_subir" class="form-horizontal">
      <input id="IdUsuaRecibe" name="IdUsuaRecibe" value="<?php echo $IdUsuaRecibe; ?>" type="hidden"/>
      <input id="IdUsuaEnvia" name="IdUsuaEnvia" value="<?php echo $IdUsuaEnvia; ?>" type="hidden"/>
      <input id="IdParcialDoc" name="IdParcialDoc" value="" type="hidden"/>
      <input id="IdUsua" name="IdUsua" value="" type="hidden"/>



      <div class="form-group">
        <label class="col-sm-3 control-label">Buscar archivo:</label>
        <div class="col-sm-9">
          <input type="file" name="archivo" id="archivo" required>
        </div>
      </div>





      <div class="barra" id="barra" style="display: none;">
        <div class="barra_azul" id="barra_estado">
          <span></span>
        </div>
      </div>
      <div id="img" class="form-group" style="text-align: center; display: none;">
        <div class="col-sm-12">
          <img src="assets/images/cargando.gif">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Nombre del archivo adjunto:</label>
        <div class="col-sm-9">
          <input type="text" name="txtNombreF" id="txtNombreF" class="form-control">
        </div>
      </div>



<br>

      <div class="box-footer">
        <button name="btnSalir" id="btnSalir" data-dismiss="modal" class="btn btn-danger"> Cancelar</button>
        <input name="bntSubir" id="bntSubir" type="button"  onclick="val_uploadFile()" class="btn btn-primary pull-right" value="Subir archivo">
      </div>

    </form>



  </div>
<script>
  function delArchivo(IdRecurso, IdActividad){
    	var TipoGuardar = "del_recurso";
    	swal({
    		title: "\u00BFEst\u00E1 seguro que desea eliminar este recurso?",
    		type: "warning",
    		showCancelButton: true,
    		confirmButtonColor: '#DD6B55',
    		confirmButtonText: 'Aceptar',
    		cancelButtonText: "Cancelar",
    	},
    	function (isConfirm) {
    		if (isConfirm) {
    			$(".confirm").attr('disabled', 'disabled');
    			var datos = 'TipoGuardar=' + TipoGuardar + '&IdRecurso=' + IdRecurso;
    			$.ajax({
    				type:"POST",
            url:"view/ajax/insertar.php",
    				data:datos,
    				success:function(data){
              $.ajax({
                   url:"view/ajax/addRecurso.php",
                   method:"POST",
                   data:{IdActividad:IdActividad},
                   success:function(data){
                        $('#employee_detailR').html(data);
                        $('#dataModalR').modal('show');
                   }
              });
    				}
    			})
    		}

    	});

  }
</script>

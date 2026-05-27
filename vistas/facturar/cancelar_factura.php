<?php
require('../../php/clases/class.System.php');
include('../../hace.php');
$db = new Conexion();

$uuid = $_POST['uuid'];
$id = $_POST['id'];

  ?>

<form role="form">
  <div class="form-group">
    <label>Motivo de la cancelación:</label>
    <select class="form-control" name="txt_motivo" id="txt_motivo">
      <option value="">- Seleccione - </option>
      <!-- <option value="01"> Comprobantes emitidos con errores con relación </option> -->
      <!-- <option value="02"> Comprobantes emitidos con errores sin relación </option> -->
      <option value="03"> No se llevó a cabo la operación </option>
      <!-- <option value="04"> Operación nominativa relacionada en una factura global </option> -->
    </select>
  </div>
  <br>
  <button onclick="cancel_factura('<?php echo $uuid; ?>',<?php echo $id; ?>)" type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-times-circle"></i> Cancelar factura</button>
</form>
<script>
  function cancel_factura(uuid, id){
      var TipoGuardar = "cancelar_factura_id";

      var Motivo = document.getElementById("txt_motivo").value;
      if (Motivo ==''){
          swal("Error al procesar", "Debe seleccionar el motivo de la cancelación de la factura.", "error");
          document.getElementById("txt_motivo").focus();
          return 0;
      }

      swal({
        title: "\u00BFEst\u00E1 seguro que desea cancelar esta factura?",
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
                url:"vistas/facturar/setting_facturar.php",
                method:"POST",
                data:{TipoGuardar:TipoGuardar,uuid:uuid, Motivo:Motivo},
                success:function(data){

                }
           })
          .done(function(data) {
            if(data==1){

              swal({
          		title: "La factura se ha cancelado correctamente",
          		type: "success",
          		showCancelButton: false,
          		confirmButtonColor: '#DD6B55',
          		confirmButtonText: 'Aceptar'
          	},
          	function (isConfirm) {
          		if (isConfirm) {
          			$(".confirm").attr('disabled', 'disabled');
                    parent.location.href='cobrar.php?token=1681942884'+id;
          			return true;
          		} else {
          			return false;
          		}
          	});
            }
            if(data==0){
              swal("Ha ocurrido un error", "No se ha podido cancelar la factura", "error");
            }
          })
          .error(function(data) {
            swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
          });
        }

      });
  }
</script>

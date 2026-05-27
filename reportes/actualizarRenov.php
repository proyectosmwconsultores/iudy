<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdCompra = $_POST["IdCompra"];
  $IdCompraRenovar = $_POST["IdCompraRenovar"];

  $sql9 = $db->query("SELECT tblp_compra_renovar.IdPaquete FROM tblp_compra_renovar WHERE tblp_compra_renovar.IdCompraRenovar = '$IdCompraRenovar' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $_IdPaquete =  $datos91["IdPaquete"];

  $sqlH = $db->query("SELECT * FROM tblc_paquete");

  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="IdCompra" name="IdCompra" value="<?php echo $IdCompra; ?>" type="hidden"/>
    <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Seleccione paquete:</label>
                  <select name="txtPaq" id="txtPaq" class="form-control">
                    <option value="">- Seleccione -</option>
                    <?php while($paq = $db->recorrer($sqlH)){ ?>
                    <option value="<?php echo $paq['IdPaquete']; ?>" <?php if($paq['IdPaquete'] == $_IdPaquete){ ?>selected="selected"<?php } ?>>Paquete <?php echo $paq['Paquete']; ?> / Precio $ <?php echo $paq['Monto']; ?>.00 / Espacio <?php echo $paq['Espacio']; ?> usuarios</option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button onclick="updPaquete(<?php echo $IdCompraRenovar; ?>,<?php echo $IdCompra; ?>)" type="button" class="btn btn-primary">Actualizar compra de Paquete</button>
              </div>


  </form>
<script>
    function updPaquete(IdCompraR,IdCompra){
      var TipoGuardar = "updPaqueteRenv";
      var IdPaquete = document.getElementById("txtPaq").value;

          swal({
            title: "\u00BFEst\u00E1 seguro que desea actualizar el paquete de su renovación de la compra?",
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
                   url:"reportes/setting.php",
                   method:"POST",
                   data:{TipoGuardar:TipoGuardar, IdCompraR:IdCompraR, IdPaquete:IdPaquete},
                   success:function(data){
                     // miPaquete();
                   }
              })
              .done(function(data) {
                if(data==1){

                  swal("Actualizado correctamente", "El paquete se ha actualizado correctamente en la Plataforma MWComenius.", "success");
                  parent.location.href='renovar.php?idCompra=1618507368'+IdCompra;
                } else{
                  swal("Error al eliminar", "No se ha podido eliminar el alumno de la Plataforma MWComenius.", "error");
                }
              })
              .error(function(data) {
                swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
              });

            }

          });
        }



</script>

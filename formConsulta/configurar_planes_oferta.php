<?php
  session_start();
  require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdGasto = $_POST['IdGasto'];

  $lst_oferta = $db->query("SELECT * FROM tblp_educativa");
  $sql_gas = $db->query("SELECT * FROM tblp_gastos WHERE tblp_gastos.IdGasto = '$IdGasto' ");
  $db->rows($sql_gas);
  $_gas = $db->recorrer($sql_gas);
  $val = $_gas['Valor'];

  ?>

  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">

    <table class="table table-striped" style="font-size: 12px;">
      <tbody><tr>
        <th style="width: 10px"></th>
        <th>PLAN DE ESTUDIOS</th>
        <th style="width: 100px; text-align: right;">MONTO</th>
      </tr>
      <?php $sx = 0; while($_us = $db->recorrer($lst_oferta)){
        $sql_s = $db->query("SELECT * FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.IdGasto = '$IdGasto' AND tblp_gastos_detalle.IdOferta = '".$_us['IdEducativa']."' ");
        $db->rows($sql_s);
        $_serv = $db->recorrer($sql_s);
        $IdDet = $_serv['IdDetalle_g'];
        $monto = $_serv['Monto'];
        if($IdDet){
         ?>
      <tr>
        <td><b><?php echo $sx = ($sx + 1); ?>.- </b></td>
        <td><?php echo $_us['Nombre']; ?></td>
        <td style="text-align: right;">$ <?php echo number_format($monto, 2, '.', ','); ?></td>
      </tr><?php } } ?>
      </tbody></table>
  </div>
  </form>
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
$(function () {
  $('.select2').select2()
})
  function sav_gastox2(IdUsua){
    var IdAsig = document.getElementById("IdAsig").value;
    var Fecha = document.getElementById("txtFecha2").value;
    var Factura = document.getElementById("txtFactura2").value;
    var Importe = document.getElementById("txtImporte2").value;
    var Cheque = document.getElementById("txtCheque2").value;
    var Partida = document.getElementById("txtPartida2").value;
    var Descripcion = document.getElementById("txtDescripcion2").value;

    if (IdAsig ==0){
        swal("Error al guardar", "Debe seleccionar la el docente que le va a realizar el pago.", "error");
        return 0;
    }
    if (Fecha ==""){
        swal("Error al guardar", "Debe seleccionar la fecha.", "error");
        document.getElementById("txtFecha2").focus();
        return 0;
    }
    if (Importe ==""){
        swal("Error al guardar", "Debe escribir el Importe del gasto.", "error");
        document.getElementById("txtImporte2").focus();
        return 0;
    }
    if (Cheque ==""){
        swal("Error al guardar", "Debe escribir el No .Cheque.", "error");
        document.getElementById("txtCheque2").focus();
        return 0;
    }
    if (Partida ==""){
        swal("Error al guardar", "Debe escribir el No. Partida.", "error");
        document.getElementById("txtPartida2").focus();
        return 0;
    }

    var TipoGuardar = "sav_gasto_docsx";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar este gasto de pago de materia del docente?",
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
             data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, Descripcion:Descripcion, IdAsig:IdAsig, Fecha:Fecha, Cheque:Cheque, Factura:Factura, Importe:Importe, Partida:Partida},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==0){
            swal("Error al guardar", "Ha ocurrido un error, no se puede guardar el gasto.", "error");
  				} else {
            swal("Guardado correctamente", "El gasto se ha guardado correctamente.", "success");
            cargar_ultimo_gasto();
            $('#dataModal_7').modal('hide');
          }
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }


  function validar_monto(){
		var Monto = document.getElementById("txtImporte2").value;
		if( isNaN(Monto) ) {
			swal("Error en el monto", "El monto ingresado no es un numero entero.", "error");
			document.getElementById("txtImporte2").value = '';
		  return 0;
		}
	}

</script>

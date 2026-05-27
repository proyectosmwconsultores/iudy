<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdGasto = $_POST['IdGasto'];
  $IdConcepto = $_POST['IdConcepto'];

  $sql_partida = $db->query("SELECT * FROM tblc_partida ORDER BY tblc_partida.Partida ASC");
  $sql_gasto = $db->query("SELECT * FROM tblc_concepto_gasto");
  $sql_gasto2 = $db->query("SELECT * FROM tblc_concepto_gasto2 WHERE tblc_concepto_gasto2.IdGasto = '$IdConcepto'");


  ?>

  <form name="frm2xfYj" id="frm2xfYj" action="capturar_gastos.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Concepto de gasto nivel 1:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-bookmark-o"></i>
              </div>
              <select name="txtGasto" id="txtGasto" class="form-control select2" style="width: 100%;" onchange="sel_gasto()">
                <option value="">Seleccione</option>
                <?php while($_gast = $db->recorrer($sql_gasto)){ ?>
                  <option value="<?php echo $_gast["IdConcepto"]; ?>" <?php if($IdConcepto==$_gast["IdConcepto"]){?>selected="selected"<?php } ?>><?php echo $_gast["Nombre_gasto"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Concepto de gasto nivel 2:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-bookmark-o"></i>
              </div>
              <select name="txtGasto2" id="txtGasto2" class="form-control select2" style="width: 100%;">
                <option value="">Seleccione</option>
                <?php while($_gast2 = $db->recorrer($sql_gasto2)){ ?>
                  <option value="<?php echo $_gast2["IdGasto2"]; ?>"><?php echo $_gast2["Nombre_gasto2"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Fecha:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" name="txtFecha" id="txtFecha" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>No.Factura:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-file-text-o"></i>
              </div>
              <input type="text" name="txtFactura" id="txtFactura" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Importe:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <input type="text" onchange="validar_monto()" name="txtImporte" id="txtImporte" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Forma de pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <select name="txtForma" id="txtForma" class="form-control" onchange="sel_tipo_f()">
                <option value="">- Seleccione - </option>
                <option value="Cheque"> Cheque </option>
                <option value="Transferencia"> Transferencia</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label id="lbl_forma">----</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-sort-numeric-desc"></i>
              </div>
              <input type="text" name="txtCheque" id="txtCheque" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Partida:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <select name="txtPartida" id="txtPartida" class="form-control select2" style="width: 100%;">
                <option value="">Seleccione</option>
                <?php while($_part = $db->recorrer($sql_partida)){ ?>
                  <option value="<?php echo $_part["Partida"]; ?>"><?php echo $_part["Partida"]; ?>: <?php echo $_part["Descripcion"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Beneficiario:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <input type="text" name="txtBeneficiario" id="txtBeneficiario" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Descripción:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-commenting-o"></i>
              </div>
              <textarea name="txtDescripcion" id="txtDescripcion" class="form-control" rows="3" placeholder="Enter ..."></textarea>
            </div>
          </div>
        </div>


      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
        <button type="button" class="btn btn-primary pull-right" onClick="sav_gastox(<?php echo $IdUsua; ?>)"> <i class="fa fa-fw fa-save"></i> Guardar gasto</button>
      </div>
    </table>
    <?php if($IdGasto){ ?>
      <button onclick="javascript:window.open('repositorio/pdf/comprobante_gasto.php?idToks=<?php echo time().$IdGasto; ?>');" href="javascript:void(0);" title="Imprimir comprobante de gasto" type="button" class="btn btn-block btn-danger btn-flat"><i class="fa fa-download"></i> Descargar recibo de gasto </button>
    <?php } ?>
  </div>

  </form>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
$(function () {
  $('.select2').select2()
  $('#txtFecha').datepicker({
    autoclose: true
  })

})
  function sav_gastox(IdUsua){
    var IdConcepto = document.getElementById("txtGasto").value;
    var IdConcepto2 = document.getElementById("txtGasto2").value;
    var Fecha = document.getElementById("txtFecha").value;
    var Factura = document.getElementById("txtFactura").value;
    var Importe = document.getElementById("txtImporte").value;
    var Forma = document.getElementById("txtForma").value;
    var Cheque = document.getElementById("txtCheque").value;
    var Partida = document.getElementById("txtPartida").value;
    var Beneficiario = document.getElementById("txtBeneficiario").value;
    var Descripcion = document.getElementById("txtDescripcion").value;

    if (IdConcepto ==""){
        swal("Error al guardar", "Debe seleccionar el concepto de gasto nivel 1.", "error");
        document.getElementById("txtGasto").focus();
        return 0;
    }
    if (IdConcepto2 ==""){
        swal("Error al guardar", "Debe seleccionar el concepto de gasto nivel 2.", "error");
        document.getElementById("txtGasto2").focus();
        return 0;
    }
    if (Fecha ==""){
        swal("Error al guardar", "Debe seleccionar la fecha.", "error");
        document.getElementById("txtFeIni").focus();
        return 0;
    }
    if (Importe ==""){
        swal("Error al guardar", "Debe escribir el Importe del gasto.", "error");
        document.getElementById("txtImporte").focus();
        return 0;
    }
    if (Forma ==""){
        swal("Error al guardar", "Debe seleccionar la forma de pago.", "error");
        document.getElementById("txtForma").focus();
        return 0;
    }
    if (Cheque ==""){
        swal("Error al guardar", "Debe escribir el No. Cheque y/o No.Transferencia.", "error");
        document.getElementById("txtCheque").focus();
        return 0;
    }
    if (Partida ==""){
        swal("Error al guardar", "Debe escribir el No. Partida.", "error");
        document.getElementById("txtPartida").focus();
        return 0;
    }
    if (Beneficiario ==""){
        swal("Error al guardar", "Debe escribir el nombre del beneficiario.", "error");
        document.getElementById("txtBeneficiario").focus();
        return 0;
    }

    var TipoGuardar = "sav_gastosy";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar este nuevo gasto?",
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
             data:{TipoGuardar:TipoGuardar, Forma:Forma, IdUsua:IdUsua, IdConcepto:IdConcepto, IdConcepto2:IdConcepto2, Fecha:Fecha, Cheque:Cheque, Factura:Factura, Importe:Importe, Partida:Partida, Beneficiario:Beneficiario, Descripcion:Descripcion},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==0){
            swal("Error al guardar", "Ha ocurrido un error, no se puede guardar el gasto.", "error");
  				} else {
            swal("Guardado correctamente", "El gasto se ha guardado correctamente.", "success");
            cargar_ultimo_gasto();
            $('#dataModal_4').modal('hide');

          }
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }

  function sel_gasto(){
    var IdConcepto = document.getElementById("txtGasto").value;
    var IdGasto = 0;
    $.ajax({
				 url:"formConsulta/capturar_gastos.php",
				 method:"POST",
				 data:{IdGasto:IdGasto, IdConcepto:IdConcepto},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
				 }
		});
  }

  function validar_monto(){
		var Monto = document.getElementById("txtImporte").value;
		if( isNaN(Monto) ) {
			swal("Error en el monto", "El monto ingresado no es un numero entero.", "error");
			document.getElementById("txtImporte").value = '';
		  return 0;
		}
	}

  function sel_tipo_f(){
    var Forma = document.getElementById("txtForma").value;
    Forma = 'No. '+Forma+':';
    document.getElementById('lbl_forma').innerHTML = Forma;
  }
</script>

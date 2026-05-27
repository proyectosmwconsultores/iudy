<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdGasto = $_POST['IdGasto'];
  $sql_lst = $db->query("SELECT * FROM tblp_gastos WHERE tblp_gastos.IdGasto = '$IdGasto'");
  $db->rows($sql_lst);
  $_lstg = $db->recorrer($sql_lst);

  $sql_partida = $db->query("SELECT * FROM tblc_partida ORDER BY tblc_partida.Partida ASC");
  $sql_gasto = $db->query("SELECT * FROM tblc_concepto_gasto");
  $sql_gasto2 = $db->query("SELECT * FROM tblc_concepto_gasto2 WHERE tblc_concepto_gasto2.IdGasto = '".$_lstg['IdConcepto']."'");
  $sql_cancel = $db->query("SELECT * FROM tblc_concepto_gasto2 WHERE tblc_concepto_gasto2.IdGasto = '21'");




  ?>

  <form name="frm2xfYj" id="frm2xfYj" action="capturar_gastos.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
    <input type="hidden" name="_formax" id="_formax" value="<?php echo $_lstg['Forma']; ?>">
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
              <select class="form-control select2" style="width: 100%;" disabled>
                <option value="">Seleccione</option>
                <?php while($_gast = $db->recorrer($sql_gasto)){ ?>
                  <option value="<?php echo $_gast["IdConcepto"]; ?>" <?php if($_lstg['IdConcepto']==$_gast["IdConcepto"]){?>selected="selected"<?php } ?>><?php echo $_gast["Nombre_gasto"]; ?></option>
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
              <select class="form-control select2" style="width: 100%;" disabled>
                <option value="">Seleccione</option>
                <?php while($_gast2 = $db->recorrer($sql_gasto2)){ ?>
                  <option value="<?php echo $_gast2["IdGasto2"]; ?>" <?php if($_lstg['IdGasto2']==$_gast2["IdGasto2"]){?>selected="selected"<?php } ?>><?php echo $_gast2["Nombre_gasto2"]; ?></option>
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
              <input type="text" name="txt_fecha2" id="txt_fecha2" class="form-control" value="<?php echo $_lstg['Fecha']; ?>">
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
              <input type="text" name="txt_factura2" id="txt_factura2" class="form-control" value="<?php echo $_lstg['Factura']; ?>">
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
              <input disabled type="text" onchange="validar_monto()" class="form-control" value="<?php echo $_lstg['Importe']; ?>">
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
              <select class="form-control" disabled>
                <option value="">- Seleccione - </option>
                <option value="Cheque" <?php if($_lstg['Forma']=='Cheque'){?>selected="selected"<?php } ?>> Cheque </option>
                <option value="Transferencia" <?php if($_lstg['Forma']=='Transferencia'){?>selected="selected"<?php } ?>> Transferencia</option>
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
              <input type="text" name="txt_cheque2" id="txt_cheque2" class="form-control" value="<?php echo $_lstg['Cheque']; ?>">
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
              <select name="txt_partida2" id="txt_partida2" class="form-control select2" style="width: 100%;">
                <option value="">Seleccione</option>
                <?php while($_part = $db->recorrer($sql_partida)){ ?>
                  <option value="<?php echo $_part["Partida"]; ?>" <?php if($_lstg['Partida']==$_part["Partida"]){?>selected="selected"<?php } ?>><?php echo $_part["Partida"]; ?>: <?php echo $_part["Descripcion"]; ?></option>
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
              <input type="text" name="txt_beneficiario2" id="txt_beneficiario2" class="form-control" value="<?php echo $_lstg['Beneficiario']; ?>">
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
              <textarea name="txt_descripcion2" id="txt_descripcion2" class="form-control" rows="3" placeholder="Enter ..."><?php echo $_lstg['Descripcion']; ?></textarea>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cerrar</button>
        <button type="button" class="btn btn-primary pull-right" onClick="upd_xgastox(<?php echo $IdUsua; ?>, <?php echo $IdGasto; ?>)"> <i class="fa fa-fw fa-save"></i> Actualizar datos</button>
        <button type="button" id="btn_cancel" class="btn btn-danger pull-left" onClick="cancel_id(<?php echo $IdGasto; ?>)"> <i class="fa fa-fw fa-times-circle"></i> Cancelar gasto</button>
      </div>
      <div id="div_cancel" style="display: none;">
      <div class="col-md-12">
        <div class="form-group">
          <label>Motivo de la cancelación:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-bookmark-o"></i>
            </div>
            <select name="txt_cancelar2" id="txt_cancelar2" class="form-control select2" style="width: 100%;">
              <option value="">Seleccione</option>
              <?php while($_cance = $db->recorrer($sql_cancel)){ ?>
                <option value="<?php echo $_cance["IdGasto2"]; ?>" ><?php echo $_cance["Nombre_gasto2"]; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" onClick="cancel_gasto_id(<?php echo $IdGasto; ?>)"> <i class="fa fa-fw fa-times-circle"></i> Cancelar gasto</button>
      </div>
    </div>
    </table>
  </div>

  </form>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script>


$(function () {

  $('.select2').select2()
  $('#txt_fecha2').datepicker({
    autoclose: true
  })

  var Dato = document.getElementById("_formax").value;
  Forma = 'No. '+Dato+':';
  document.getElementById('lbl_forma').innerHTML = Forma;

})
  function upd_xgastox(IdUsua, IdGasto){
    var Fecha = document.getElementById("txt_fecha2").value;
    var Factura = document.getElementById("txt_factura2").value;
    var Cheque = document.getElementById("txt_cheque2").value;
    var Partida = document.getElementById("txt_partida2").value;
    var Beneficiario = document.getElementById("txt_beneficiario2").value;
    var Descripcion = document.getElementById("txt_descripcion2").value;

    if (Fecha ==""){
        swal("Error al guardar", "Debe seleccionar la fecha.", "error");
        document.getElementById("txtFeIni").focus();
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

    var TipoGuardar = "upd_gastos_id";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de este gasto?",
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
             data:{TipoGuardar:TipoGuardar, IdGasto:IdGasto, IdUsua:IdUsua, Fecha:Fecha, Cheque:Cheque, Factura:Factura, Partida:Partida, Beneficiario:Beneficiario, Descripcion:Descripcion},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==0){
            swal("Error al guardar", "Ha ocurrido un error, no se puede actualizar el gasto.", "error");
  				} else {
            swal("Actualizado correctamente", "Los datos del gasto se han actualizado correctamente.", "success");
            cargar_ultimo_gasto();
            $.ajax({
        				 url:"formConsulta/editar_gastos_id.php",
        				 method:"POST",
        				 data:{IdGasto:IdGasto},
        				 success:function(data){
        							$('#employee_detail_Ed').html(data);
        							$('#dataModal_Ed').modal('show');
        				 }
        		});

          }
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }

  function cancel_gasto_id(IdGasto){

    var IdCancelar = document.getElementById("txt_cancelar2").value;

    if (IdCancelar ==""){
        swal("Error al guardar", "Debe seleccionar el motivo de la cancelación.", "error");
        document.getElementById("txt_cancelar2").focus();
        return 0;
    }

    var TipoGuardar = "cancel_xgastos_id";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea cancelar este gasto?",
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
             data:{TipoGuardar:TipoGuardar, IdGasto:IdGasto, IdCancelar:IdCancelar},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==0){
            swal("Error al guardar", "Ha ocurrido un error, no se puede cancelar este gasto.", "error");
  				} else {
            swal("Cancelado correctamente", "El gasto se ha cancelado correctamente.", "success");
            cargar_ultimo_gasto();
            $('#dataModal_Ed').modal('hide');

          }
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }

  function sel_gasto_edit(){
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
		var Monto = document.getElementById("txt_importe2").value;
		if( isNaN(Monto) ) {
			swal("Error en el monto", "El monto ingresado no es un numero entero.", "error");
			document.getElementById("txt_importe2").value = '';
		  return 0;
		}
	}

  function cancel_id(){
    document.getElementById("btn_cancel").style.display = 'none';
    document.getElementById("div_cancel").style.display = 'block';
  }


</script>

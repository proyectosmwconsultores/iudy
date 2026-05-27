<?php
  session_start();
  require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdGasto = $_POST['IdGasto'];
  $Inicio = $_POST['Inicio'];
  $IdAsignacion = $_POST['IdAsignacion'];
  if($Inicio == 0){
    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion._idEstatus = '1' WHERE tblp_asignacion._idEstatus <> '60' ");
  }
  $monto = '';
  $sql_banco = $db->query("SELECT * FROM tblc_bancos");
  $sql_us = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.Id, tblp_asignacion.Monto, tblp_asignacion.Fec_pago, tblp_asignacion._idEstatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion._idEstatus <> 60 ORDER BY tblp_asignacion.Fec_pago ASC");
  if($IdAsignacion){

      $sql_us_id = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.Id, tblp_asignacion.Monto, tblp_asignacion.Fec_pago, tblp_asignacion._idEstatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.Id =  '$IdAsignacion'");
      $db->rows($sql_us_id);
      $_usx = $db->recorrer($sql_us_id);
      $monto = $_usx['Monto'];
  }
  $sql_partida = $db->query("SELECT * FROM tblc_partida");
  ?>

  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <input type="hidden" name="IdAsig" id="IdAsig" value="<?php echo $IdAsignacion; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">

          <?php if($IdAsignacion){ ?>
          <div class="col-md-12">
            <div class="form-group">
              <div class="bg-navy color-palette" style="padding: 5px;"><span><i class="fa fa-user"></i> <?php echo $_usx['Nombre'].' '.$_usx['APaterno'].' '.$_usx['AMaterno'].' ('.$_usx['NombreMod'].')'; ?></span></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Fecha:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" name="txtFecha2" id="txtFecha2" class="form-control">
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
                <input type="text" name="txtFactura2" id="txtFactura2" class="form-control">
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
                <input type="text" onchange="validar_monto()" name="txtImporte2" id="txtImporte2" class="form-control" value="<?php echo $monto; ?>">
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Forma de pago:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-qrcode"></i>
                </div>
                <select name="txtForma2" id="txtForma2" class="form-control" onchange="sel_tipo_f2()">
                  <option value="">- Seleccione - </option>
                  <option value="Cheque"> Cheque </option>
                  <option value="Transferencia"> Transferencia</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label id="lbl_forma2">----</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-dollar"></i>
                </div>
                <input type="text" name="txtCheque2" id="txtCheque2" class="form-control" >
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Partida:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-dollar"></i>
                </div>
                <select name="txtPartida2" id="txtPartida2" class="form-control select2" style="width: 100%;">
                  <option value="">Seleccione</option>
                  <?php while($_part = $db->recorrer($sql_partida)){ ?>
                    <option value="<?php echo $_part["Partida"]; ?>"><?php echo $_part["Partida"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Descripcion:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-dollar"></i>
                </div>
                <textarea name="txtDescripcion2" id="txtDescripcion2" class="form-control" rows="3" placeholder="Enter ..."><?php echo $_usx['NombreMod']; ?></textarea>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
                <button type="button" class="btn btn-primary pull-right" onClick="sav_gastox2(<?php echo $_SESSION['IdUsua']; ?>)"> <i class="fa fa-fw fa-save"></i> Guardar gasto</button>
              </div>
            </div>
          </div>

          <?php } ?>

        </div>

      </div>
    </table>
    <?php if($IdGasto){ ?>
      <button onclick="javascript:window.open('repositorio/pdf/comprobante_gasto.php?idToks=<?php echo time().$IdGasto; ?>');" href="javascript:void(0);" title="Imprimir comprobante de gasto" type="button" class="btn btn-block btn-danger btn-flat"><i class="fa fa-download"></i> Descargar recibo de gasto </button>
    <?php } ?>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody><tr>
        <th style="width: 10px"></th>
        <th style="width: 10px"></th>
        <th>MATERIA</th>
        <th>DOCENTE</th>
        <th>FECHA</th>
        <th style="width: 100px; text-align: right;">MONTO</th>
      </tr>
      <?php $sx = 0; $nx = 0; $f_i=0; $f_f=0; while($_us = $db->recorrer($sql_us)){ $f_i = substr($_us['Fec_pago'], 0, 7);

        if($f_i <> $f_f){ if($sx <> 0){ ?>

          <tr>
            <td colspan="5" style="text-align: right;"><b>TOTAL PAGAR:</b></td>
            <td style="text-align: right; background: yellow;"><b>$ <?php echo number_format($sx, 2, '.', ','); ?></b></td>
          </tr><?php } ?>
          <tr>
            <td colspan="6" style="background: #dfd9ff;"><b><i class="fa fa-calendar"></i> <?php echo obtener_AnioMesMAY($_us['Fec_pago']); ?></b></td>
          </tr>
        <?php $sx = 0; } $sx = ($sx + $_us["Monto"]);
         ?>
      <tr>
        <td><b><?php echo $nx = ($nx + 1); ?>.- </b></td>
        <td>
          <?php if($_us['_idEstatus'] == 1){ ?>
          <button onclick="chk_pago_dox(<?php echo $_us['Id']; ?>, 12)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-times-circle"></i></button>
        <?php } elseif($_us['_idEstatus'] == 12) { ?>
          <button onclick="chk_pago_dox(<?php echo $_us['Id']; ?>, 1)" type="button" class="btn btn-info btn-sm"><i class="fa fa-check-circle"></i></button>
        <?php } ?>
        </td>
        <td><?php echo $_us['NombreMod']; ?></td>
        <td><?php echo $_us['Nombre'].' '.$_us['APaterno'].' '.$_us['AMaterno']; ?></td>
        <td><?php echo $_us['Fec_pago']; ?></td>
        <td style="width: 100px; text-align: right;">$ <?php echo number_format($_us["Monto"], 2, '.', ','); ?></td>
      </tr><?php $f_f = substr($_us['Fec_pago'], 0, 7);  } ?>
      <tr>
        <td colspan="5" style="text-align: right;"><b>TOTAL PAGAR:</b></td>
        <td style="text-align: right; background: yellow;"><b>$ <?php echo number_format($sx, 2, '.', ','); ?></b></td>
      </tr>
      </tbody></table>

  </div>

  </form>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
$(function () {
  $('.select2').select2()
  $('#txtFecha2').datepicker({
    autoclose: true
  })

})
  function sav_gastox2(IdUsua){
    var IdAsig = document.getElementById("IdAsig").value;
    var Fecha = document.getElementById("txtFecha2").value;
    var Factura = document.getElementById("txtFactura2").value;
    var Importe = document.getElementById("txtImporte2").value;
    var Forma = document.getElementById("txtForma2").value;
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
    if (Forma ==""){
        swal("Error al guardar", "Debe seleccionar la forma de pago.", "error");
        document.getElementById("txtForma2").focus();
        return 0;
    }
    if (Cheque ==""){
        swal("Error al guardar", "Debe escribir el No .Cheque y/o No. Transferencia.", "error");
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
             data:{TipoGuardar:TipoGuardar, Forma:Forma, IdUsua:IdUsua, Descripcion:Descripcion, IdAsig:IdAsig, Fecha:Fecha, Cheque:Cheque, Factura:Factura, Importe:Importe, Partida:Partida},
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

  function sel_gasto(){
    var IdPermiso = document.getElementById("IdPermisox").value;
    var IdConcepto = document.getElementById("txtGasto").value;
    var IdGasto = 0;
    $.ajax({
				 url:"formConsulta/capturar_gastos.php",
				 method:"POST",
				 data:{IdGasto:IdGasto, IdPermiso:IdPermiso, IdConcepto:IdConcepto},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
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

  function chk_pago_dox(IdAsignacion, IdEstatus){
    var TipoGuardar = "sav_pago_docx";

    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdAsignacion:IdAsignacion, IdEstatus:IdEstatus},
         success:function(data){
           if(IdEstatus == 12){ IdAsignacion = IdAsignacion; } else { IdAsignacion = 0; }
           var IdGasto = 0;
           var Inicio = 1;
       		$.ajax({
       				 url:"formConsulta/capturar_gastos_docente.php",
       				 method:"POST",
       				 data:{IdGasto:IdGasto, IdAsignacion:IdAsignacion, Inicio:Inicio},
       				 success:function(data){
       							$('#employee_detail_7').html(data);
       							$('#dataModal_7').modal('show');
       				 }
       		});
         }
    })

  }

  function sel_tipo_f2(){
    var Forma = document.getElementById("txtForma2").value;
    Forma = 'No. '+Forma+':';
    document.getElementById('lbl_forma2').innerHTML = Forma;
  }
</script>

<?php
require('../php/clases/class.System.php');
include('../hace.php');
$db = new Conexion();

$IdUsua = $_POST['IdUsua'];

$sql_fac = $db->query("SELECT * FROM tblc_datosfactura WHERE tblc_datosfactura.IdUsua = '$IdUsua' ");
$db->rows($sql_fac);
$fac = $db->recorrer($sql_fac);


if(!isset($fac['IdDatosFacturacion'])){
  $insertar = $db->query("INSERT INTO tblc_datosfactura (IdUsua) VALUES ('$IdUsua')");
}

$uso_cfdi = $db->query("SELECT * FROM tblc_usocfdi");
$regimen = $db->query("SELECT * FROM tblc_regimen_fiscal");

$sql8 = $db->query("SELECT * FROM tblc_datosfactura WHERE tblc_datosfactura.IdUsua = '$IdUsua' ");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);

// $receptor["Rfc"] = "URE180429TM6";
// $receptor["Nombre"] = "UNIVERSIDAD ROBOTICA ESPAÑOLA";
// $receptor["DomicilioFiscalReceptor"] = "65000";
// $receptor["RegimenFiscalReceptor"] = "601";
// $receptor["UsoCFDI"] = "CP01";

  ?>
  <form role="form">
    <div class="box-body">
      <div class="form-group">
        <label>NOMBRE:</label>
        <input name="txt_nombre" id="txt_nombre" type="text" class="form-control" value="<?php echo $datos81["Razon"]; ?>">
      </div>
      <div class="form-group">
        <label>RFC:</label>
        <input name="txt_rfc" id="txt_rfc" maxlength="13" type="text" class="form-control" value="<?php echo $datos81["RFC"]; ?>">
      </div>
      <div class="form-group">
        <label>C.P. DEL DOMICILIO FISCAL:</label>
        <input name="txt_domicilio" id="txt_domicilio" maxlength="5" type="text" class="form-control" value="<?php echo $datos81["CP"]; ?>">
      </div>

      <div class="form-group">
        <label>REGIMEN FISCAL:</label>
        <select name="txt_regimen" id="txt_regimen" class="form-control" name="txt_campus" id="txt_campus">
          <option value="">- Seleccione campus - </option>
          <?php while($fiscal = $db->recorrer($regimen)){ ?>
          <option value="<?php echo $fiscal['IdRegimen']; ?>" <?php if($datos81["IdRegimen"]==$fiscal['IdRegimen']){ ?>selected="selected"<?php } ?>><?php echo $fiscal['Clave'].' - '.$fiscal['Descripcion']; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <label>USO CFDI:</label>
        <select name="txt_cfdi" id="txt_cfdi" class="form-control" name="txt_campus" id="txt_campus">
          <option value="">- Seleccione campus - </option>
          <?php while($uso = $db->recorrer($uso_cfdi)){ ?>
          <option value="<?php echo $uso['IdUso']; ?>" <?php if($datos81["IdUso"]==$uso['IdUso']){ ?>selected="selected"<?php } ?>><?php echo $uso['Clave'].' - '.$uso['Descripcion']; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <div class="box-footer" style="text-align: right;">
      <button onclick="upd_facturacion(<?php echo $IdUsua; ?>)" type="button" class="btn btn-primary"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
    </div>
</form>
<script>
  function upd_facturacion(IdUsua){
      var TipoGuardar = "upd_datos_facturacion";
      var Nombre = document.getElementById("txt_nombre").value;
      var Rfc = document.getElementById("txt_rfc").value;
      var Domicilio = document.getElementById("txt_domicilio").value;
      var Regimen = document.getElementById("txt_regimen").value;
      var Cfdi = document.getElementById("txt_cfdi").value;
      if (Nombre==""){
          swal("Error al guardar", "Debe escribir el nombre de la facturación.", "error");
          document.getElementById("txt_nombre").focus();
          return 0;
      }
      if (Rfc==""){
          swal("Error al guardar", "Debe escribir el RFC.", "error");
          document.getElementById("txt_rfc").focus();
          return 0;
      }
      if (Domicilio==""){
          swal("Error al guardar", "Debe ingresar el CP del domicilio fiscal.", "error");
          document.getElementById("txt_domicilio").focus();
          return 0;
      }
      if (Regimen==""){
          swal("Error al guardar", "Debe seleccionar el regimen fiscal.", "error");
          document.getElementById("txt_regimen").focus();
          return 0;
      }
      if (Cfdi==""){
          swal("Error al guardar", "Debe seleccionar el uso cfdi.", "error");
          document.getElementById("txt_cfdi").focus();
          return 0;
      }
      swal({
        title: "\u00BFEst\u00E1 seguro que desea actualizar estos datos para facturación?",
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
                url:"formConsulta/setting_facturar.php",
                method:"POST",
                data:{TipoGuardar:TipoGuardar,IdUsua:IdUsua, Nombre:Nombre, Rfc:Rfc, Domicilio:Domicilio, Regimen:Regimen, Cfdi:Cfdi},
                success:function(data){

                }
           })
          .done(function(data) {
            if(data==1){
              swal("Actualizado correctamente", "Los datos de facturación se han guardado correctamente.", "success");
              cargar_lista_asistencia();
              $.ajax({
        		     url:"formConsulta/datos_factura.php",
        		     method:"POST",
        		     data:{IdUsua:IdUsua},
        		       success:function(data){
        		          $('#employee_fact').html(data);
        		          $('#data_fact').modal('show');
        		       }
        		  });
            }
            if(data==0){
              swal("Error al actualizar", "No se puede actualizar, ya que no se ha podido encontrar el numero de certificado del emisor, revise el RFC.", "error");
            }
          })
          .error(function(data) {
            swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
          });
        }

      });
  }
</script>

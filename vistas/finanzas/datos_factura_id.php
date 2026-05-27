<?php session_start();
require('../../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];

  $sql_fac = $db->query("SELECT * FROM tblc_datosfactura WHERE tblc_datosfactura.IdUsua = '$IdUsua'");
  $sql_estados = $db->query("SELECT * FROM tblc_estado");
  $db->rows($sql_fac);
  $_fac = $db->recorrer($sql_fac);
  if(!$_fac['IdDatosFacturacion']){
    $sql_ins = $db->query("INSERT INTO tblc_datosfactura (IdUsua) VALUES ('$IdUsua') ");
    $sql_fac = $db->query("SELECT * FROM tblc_datosfactura WHERE tblc_datosfactura.IdUsua = '$IdUsua'");
    $db->rows($sql_fac);
    $_fac = $db->recorrer($sql_fac);
  }

  $tipoPersona = $_fac['tipoPersona'];

   
  $sql_reg = $db->query("SELECT * FROM tblc_regimen_fiscal WHERE tblc_regimen_fiscal.tipoPersona = '$tipoPersona'");
  $sql_cfdi = $db->query("SELECT * FROM tblc_usocfdi");

  ?>
  <table class="table table-bordered">
    <tbody><tr>
      <th>Tipo de persona para facturar</th>
    </tr>
    <tr>
      <td>
        <div class="btn-group">
        <button type="button" <?php if($_fac['IdEstatus'] <> 8) { ?> onclick="sel_persona(<?php echo $IdUsua; ?>, 1)" <?php } ?> class="btn btn-<?php if($_fac['tipoPersona'] == 1){ echo "info"; } else { echo "default"; } ?>"><i class="fa fa-<?php if($_fac['tipoPersona'] == 1){ echo "check"; } else { echo "circle"; } ?>-circle"></i> Persona Moral</button>
        <button type="button" <?php if($_fac['IdEstatus'] <> 8) { ?> onclick="sel_persona(<?php echo $IdUsua; ?>, 2)" <?php } ?> class="btn btn-<?php if($_fac['tipoPersona'] == 2){ echo "info"; } else { echo "default"; } ?>"><i class="fa fa-<?php if($_fac['tipoPersona'] == 1){ echo "check"; } else { echo "circle"; } ?>-circle"></i> Persona Física</button>
        <button type="button" <?php if($_fac['IdEstatus'] <> 8) { ?> onclick="sel_persona(<?php echo $IdUsua; ?>, 3)" <?php } ?> class="btn btn-<?php if($_fac['tipoPersona'] == 3){ echo "info"; } else { echo "default"; } ?>"><i class="fa fa-<?php if($_fac['tipoPersona'] == 1){ echo "check"; } else { echo "circle"; } ?>-circle"></i> Público en General</button>
        </div>
      </td>
    </tr>
    </tbody></table>
    <?php if($_fac['IdEstatus'] == 1){ ?>
    <div class="bg-red-active color-palette" style="padding: 5px;"><span><i class="fa fa-warning"></i> Su factura se encuentra en <b style="color: black;">Estatus Pendiente</b>, favor de actualizar sus datos.</span></div>
    <?php } ?>
    <?php if($_fac['IdEstatus'] == 3){ ?>
    <div class="bg-yellow-active color-palette" style="padding: 5px;"><span><i class="fa fa-warning"></i> Su factura se encuentra en <b style="color: blue;">Estatus de Revisión</b>, favor de actualizar sus datos.</span></div>
    <?php } ?>
    <?php if($_fac['IdEstatus'] == 8){ ?>
    <div class="bg-green-active color-palette" style="padding: 5px;"><span><i class="fa fa-info-circle"></i> Su factura se encuentra en <b style="color: yellow;">Activo</b>.</span></div>
    <?php } ?>
    <br>

  <form method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input type="hidden" name="_tipoP" id="_tipoP" value="<?php echo $tipoPersona; ?>">
    <div class="box-body">
      <input type="hidden" name="_idcp" id="_idcp" value="<?php echo $_fac['idcp']; ?>">
      <?php if(($tipoPersona == 1) || ($tipoPersona == 2) || ($tipoPersona == 3)){ ?>
      <div class="form-group">
        <label class="col-sm-3 control-label">Regimen fiscal:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_regimen" id="txt_regimen">
            <option value="">- Seleccione -</option>
            <?php while($_reg = $db->recorrer($sql_reg)){ ?>
            <option value="<?php echo $_reg['IdRegimen']; ?>" <?php if($_reg["IdRegimen"] == $_fac['IdRegimen']){ ?>selected="selected"<?php } ?>> <?php echo $_reg['Clave'].' - '.$_reg['Descripcion']; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Uso CFDI:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_cfdi" id="txt_cfdi">
            <option value="">- Seleccione -</option>
            <?php while($_cfdi = $db->recorrer($sql_cfdi)){ ?>
            <option value="<?php echo $_cfdi['IdUso']; ?>" <?php if($_cfdi['IdUso'] == $_fac['IdUso']){ ?>selected="selected"<?php } ?>> <?php echo $_cfdi['Clave'].' - '.$_cfdi['Descripcion']; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Razón social:</label>
        <div class="col-sm-9">
          <input class="form-control" type="text" name="txt_razon" id="txt_razon" value="<?php echo $_fac['Razon']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">RFC:</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" name="txt_rfc" id="txt_rfc" value="<?php echo $_fac['RFC']; ?>">
        </div>
        
      </div>
      <?php if(($tipoPersona == 1) || ($tipoPersona == 2) ){ ?>
        <div class="form-group">
        <label class="col-sm-3 control-label">Código postal:</label>
        <div class="col-sm-4">
          <input class="form-control" maxlength="5" type="text" name="txt_cp" id="txt_cp" value="<?php echo $_fac['CP']; ?>">
        </div>
        <div class="col-sm-4">
        <span class="input-group-btn">
          <button onclick="validar_cp()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-check-circle"></i> Validar CP</button>
        </span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Calle:</label>
        <div class="col-sm-10">
          <input class="form-control" type="text" name="txt_domicilio" id="txt_domicilio" value="<?php echo $_fac['Domicilio']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Colonia:</label>
        <div class="col-sm-4">
        <select class="form-control select2" name="txt_colonia" id="txt_colonia"> 
          <option value=""> - Seleccione - </option>
        </select>
        </div>
        <label class="col-sm-3 control-label">No. Enterior:</label>
        <div class="col-sm-3">
          <input class="form-control" type="text" name="txt_exterior" id="txt_exterior" value="<?php echo $_fac['NoExterior']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Estado:</label>
        <div class="col-sm-4">
        <select class="form-control" name="txt_estado" id="txt_estado">
            <option value="">- Seleccione -</option>
            <?php while($_estado = $db->recorrer($sql_estados)){ ?>
            <option value="<?php echo $_estado['Estado']; ?>" <?php if($_estado['Estado'] == $_fac['Estado']){ ?>selected="selected"<?php } ?>> <?php echo $_estado['Estado']; ?> </option>
            <?php } ?>
          </select>

          <!-- <input type="text" name="txt_estado" id="txt_estado" class="form-control" value="<?php echo $_fac['Estado']; ?>"> -->
        </div>
        <label class="col-sm-2 control-label">Municipio:</label>
        <div class="col-sm-4">
          <input type="text" name="txt_municipio" id="txt_municipio" class="form-control" value="<?php echo $_fac['Municipio']; ?>">
        </div>
      </div>
      <br>
      <?php } ?>
      <div class="form-group" style="float: right;">
        <div class="col-sm-12">
          <?php if($_fac['IdEstatus'] == 3){ ?>
          <button type="button" onclick="activar_fact_id(<?php echo $IdUsua; ?>)" class="btn bg-navy btn-flat margin"><i class="fa fa-check-circle"></i> Activar</button>
          <?php } ?>
          <?php if(($_fac['IdEstatus'] == 1) || ($_fac['IdEstatus'] == 3) || ($_SESSION['Permisos'] == 1) || ($_SESSION['Permisos'] == 6) || ($_SESSION['Permisos'] == 8)){ ?>
          <button type="button" onclick="sav_datos_fact(<?php echo $IdUsua; ?>,<?php echo $tipoPersona; ?>)" class="btn bg-purple btn-flat margin"><i class="fa fa-save"></i> Actualizar</button>
          <?php } ?>
        </div>
      </div>
    <?php }  ?>
    </div>
    <?php if (($tipoPersona == 1) || ($tipoPersona == 2) || ($tipoPersona == 3)) { ?>
  <div class="form-group">
    <label class="col-sm-4 control-label">Constancia de Situación Fiscal:</label>
    <div class="col-sm-8">
      <input class="form-control" name="txtArchivo" id="txtArchivo" type="file">
    </div>
  </div>
  <div class="form-group" style="float: right;">
    <div class="col-sm-12">
      <?php if($_fac['Archivo']){
        $archivo = $_fac['Archivo'];
        $link = "assets/docs/Alumnos/$archivo";
        ?>
    <button type="button" onClick="window.open('<?php echo $link; ?>','_blank')" href="javascript:void(0);" class="btn bg-orange btn-flat margin"><i class="fa fa-eye"></i> Ver constancia</button>
    <?php } ?>
    
    <button type="button" onclick="subir_archivo(<?php echo $IdUsua; ?>)" class="btn bg-purple btn-flat margin"><i class="fa fa-upload"></i> Subir constancia</button>
    
    </div>

  </div><br><br>
  <?php } ?>
</form>
<script>
  function subir_archivo(IdUsua){
    var Archivo = document.getElementById("txtArchivo").value;
    var Imagen = '#txtArchivo';

    if (Archivo ==""){
        swal("Error al guardar", "Debe seleccionar el archivo de la Constancia de Situacion Fiscal.", "error");
        return 0;
    }

    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar esta constancia de situacion fiscal?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Aceptar',
      cancelButtonText: "Cancelar",
    },
    function (isConfirm) {
      if(isConfirm) {
			$(".confirm").attr('disabled', 'disabled');

      var formData = new FormData();
      var files = $(Imagen)[0].files[0];
      formData.append('IdUsua',IdUsua);

      formData.append('file',files);

      $.ajax({
          url: 'upload_csf.php',
          type: 'post',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {


          }
      })
      .done(function(response) {
        if(response==1){
          swal("Guardado correctamente", "La constancia de situación fiscal se ha guardado correctamente.", "success");
          
          $.ajax({
          url: "vistas/finanzas/datos_factura_id.php",
          method: "POST",
          data: {
            IdUsua: IdUsua
          },
          success: function(data) {
            $('#employee_facx').html(data);
            $('#data_facx').modal('show');
          }
        });
        }else{
          swal("Error al guardar", "No se puede guardar los datos.", "error");
        }
      })
      .error(function(data) {
        swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
      });


		}
    });
  }
  
function sav_datos_fact(IdUsua, tipoPersona){
  var IdRegimen = document.getElementById("txt_regimen").value;
  var IdUso = document.getElementById("txt_cfdi").value;
  var Razon = document.getElementById("txt_razon").value;
  var Rfc = document.getElementById("txt_rfc").value;
  if((tipoPersona == 1) || (tipoPersona == 2)){
    var Domicilio = document.getElementById("txt_domicilio").value;
    var Colonia = document.getElementById("txt_colonia").value;
    var Exterior = document.getElementById("txt_exterior").value;
    var Estado = document.getElementById("txt_estado").value;
    var Municipio = document.getElementById("txt_municipio").value;
    var CPx = document.getElementById("txt_cp").value;
  }

  var TipoGuardar = "sav_datos_factura";
  if (IdRegimen==''){
    swal("Error al guardar", "Debe seleccionar el Regimen Fiscal.", "error");
    document.getElementById("txt_regimen").focus();
    return 0;
  }
  if (IdUso==''){
    swal("Error al guardar", "Debe seleccionar el Uso CFDI.", "error");
    document.getElementById("txt_cfdi").focus();
    return 0;
  }
  if (Razon==''){
    swal("Error al guardar", "Debe escribir la razón social.", "error");
    document.getElementById("txt_razon").focus();
    return 0;
  }
  if (Rfc==''){
    swal("Error al guardar", "Debe escribir el RFC.", "error");
    document.getElementById("txt_rfc").focus();
    return 0;
  }
  if((tipoPersona == 1) || (tipoPersona == 2)){
    if (Domicilio==''){
      swal("Error al guardar", "Debe escribir el domicilio.", "error");
      document.getElementById("txt_domicilio").focus();
      return 0;
    }
    if (Colonia==''){
      swal("Error al guardar", "Debe escribir la colonia.", "error");
      document.getElementById("txt_colonia").focus();
      return 0;
    }
    if (Exterior==''){
      swal("Error al guardar", "Debe escribir el número exterior.", "error");
      document.getElementById("txt_exterior").focus();
      return 0;
    }

    if (Estado==''){
      swal("Error al guardar", "Debe escribir el nombre del Estado.", "error");
      document.getElementById("txt_estado").focus();
      return 0;
    }
    if (Municipio==''){
      swal("Error al guardar", "Debe escribir el nombre del Municipio.", "error");
      document.getElementById("txt_municipio").focus();
      return 0;
    }
    if (CPx==''){
      swal("Error al guardar", "Debe escribir el Código Postal.", "error");
      document.getElementById("txt_cp").focus();
      return 0;
    }
  }
  swal({
    title: "\u00BFEst\u00E1 seguro que desea guardar estos datos de facturación?",
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
        type:"POST",
        url:"vistas/finanzas/sav_datos_finanzas.php",
        data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdRegimen:IdRegimen, IdUso:IdUso, Razon:Razon, Rfc:Rfc, Domicilio:Domicilio, Colonia:Colonia, Exterior:Exterior, Estado:Estado, Municipio:Municipio, CPx:CPx, tipoPersona:tipoPersona},
        success:function(data){
         
        }
      })
      .done(function(data) {
        if(data==1){
          swal("Guardado correctamente", "Los datos de la factura se han guardado correctamente.", "success");
          $.ajax({
               url:"vistas/finanzas/datos_factura_id.php",
               method:"POST",
               data:{IdUsua:IdUsua},
               success:function(data){
                    $('#employee_facx').html(data);
                    $('#data_facx').modal('show');
               }
          });
        } else {
          swal("Error al guardar", "Ha ocurrido un error, no se puede guardar los datos.", "error");
        }
      })
      .error(function(data) {
        swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
      });
    } else{
      document.getElementById("frm").reset();
    }
  });
}

function activar_fact_id(IdUsua){
  var TipoGuardar = "activa_datos_factura";

  swal({
    title: "\u00BFEst\u00E1 seguro que desea activar estos datos para facturar?",
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
        type:"POST",
        url:"vistas/finanzas/sav_datos_finanzas.php",
        data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua},
        success:function(data){

        }
      })
      .done(function(data) {
        if(data==1){
          swal("Activado correctamente", "Los datos del usuario se han activado para facturar.", "success");
          $.ajax({
               url:"vistas/finanzas/datos_factura_id.php",
               method:"POST",
               data:{IdUsua:IdUsua},
               success:function(data){
                    $('#employee_facx').html(data);
                    $('#data_facx').modal('show');
               }
          });
        } else {
          swal("Error al guardar", "Ha ocurrido un error, no se puede guardar los datos.", "error");
        }
      })
      .error(function(data) {
        swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
      });
    } else{
      document.getElementById("frm").reset();
    }
  });
}


  function sel_persona(IdUsua, tipoPersona){
    var TipoGuardar = "sav_tipoPersona";
      swal({ 
        title: "\u00BFEst\u00E1 seguro que desea activar este tipo de factura para este usuario?",
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
            type:"POST",
            url:"vistas/finanzas/sav_datos_finanzas.php",
            data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, tipoPersona:tipoPersona},
            success:function(data){

            }
          })
          .done(function(data) {
            if(data==1){
              swal("Guardado correctamente", "El tipo de factura seleccionado se ha guardado correctamente.", "success");
              $.ajax({
            			 url:"vistas/finanzas/datos_factura_id.php",
            			 method:"POST",
            			 data:{IdUsua:IdUsua},
            			 success:function(data){
            						$('#employee_facx').html(data);
            						$('#data_facx').modal('show');
            			 }
            	});
            }
          })
          .error(function(data) {
            swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
          });
        } else{
          document.getElementById("frm").reset();
        }
      });
  }

  function validar_cp(){
    var Codigo = document.getElementById("txt_cp").value;
    var IdCodigo = document.getElementById("_idcp").value;
		var Tipo = "validar_rfc";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, Codigo:Codigo, IdCodigo:IdCodigo}, function(data){
		    
      if(data == '<option value=""> - Seleccione -</option>'){
        swal("Código Postal no encontrado", "El Código Postal ingresado no exite en el catálogo del SAT", "error");
        document.getElementById("txt_cp").value = '';
      } else {
        $("#txt_colonia").html(data);
      }
			
		});
  }

  $(document).ready(function(){
    var Tipo = document.getElementById("_tipoP").value;
    if((Tipo == 1) || (Tipo == 2)){
      var Codigo = document.getElementById("txt_cp").value;
      if(Codigo){
        validar_cp();
      }
      
    }
    
  });
</script>

<?php
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $sql9 = $db->query("SELECT * FROM tblp_acta WHERE tblp_acta.IdUsua = '".$_POST["IdUsua"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdActa = $datos91['IdActa'];
  if(!$IdActa){
    $sql = $db->query("INSERT INTO tblp_acta (IdUsua) VALUES ('".$_POST["IdUsua"]."') ");
  }
  ?>
  <form name="frm2" id="frm2" action="addBanco.php" method="POST" enctype="multipart/form-data">
    <div class="box box-primary" style="border-top: none;">
      <div class="box-body">
      <div class="col-md-4">
        <div class="form-group">
          <label>Folio:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-black-tie"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtFolio" name="txtFolio" value="<?php echo $datos91["Folio"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>No:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-black-tie"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtNo" name="txtNo" value="<?php echo $datos91["No"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Autorización:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-black-tie"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtAutorizacion" name="txtAutorizacion" value="<?php echo $datos91["Autorizacion"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label>Ciudad:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-black-tie"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtCiudad" name="txtCiudad" value="<?php echo $datos91["Ciudad"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Hora:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-black-tie"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtHora" name="txtHora" value="<?php echo $datos91["Hora"]; ?>">
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <label>Día:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-black-tie"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtDia" name="txtDia" value="<?php echo $datos91["Dia"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Mes:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-cc-diners-club"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtMes" name="txtMes" value="<?php echo $datos91["Mes"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Año:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-cc-diners-club"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtAnio" name="txtAnio" value="<?php echo $datos91["Anio"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Lugar evento:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-cc-diners-club"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtAuditorio" name="txtAuditorio" value="<?php echo $datos91["Auditorio"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Nombre de la universidad:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-cc-diners-club"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtEscuela" name="txtEscuela" value="<?php echo $datos91["Escuela"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="form-group">
          <label>Presidente:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-user"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtPresidente" name="txtPresidente" value="<?php echo $datos91["Presidente"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>No. Cédula:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-cc-diners-club"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtCedula1" name="txtCedula1" value="<?php echo $datos91["Cedula1"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="form-group">
          <label>Secretario:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-user"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtSecretario" name="txtSecretario" value="<?php echo $datos91["Secretario"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>No. Cédula:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-cc-diners-club"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtCedula2" name="txtCedula2" value="<?php echo $datos91["Cedula2"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="form-group">
          <label>Vocal:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-user"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtVocal" name="txtVocal" value="<?php echo $datos91["Vocal"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>No. Cédula:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-cc-diners-club"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtCedula3" name="txtCedula3" value="<?php echo $datos91["Cedula3"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="form-group">
          <label>Opción de examen:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-qrcode"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtTipo" name="txtTipo" value="<?php echo $datos91["Tipo"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Deliberado como:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-qrcode"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtEstatus" name="txtEstatus" value="<?php echo $datos91["Estatus"]; ?>">
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-group">
          <label>Profesión de:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-qrcode"></i>
            </div>
            <input type="text" class="form-control pull-right" id="txtProfesion" name="txtProfesion" value="<?php echo $datos91["Profesion"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="bg-purple-active color-palette" style="padding: 10px;"><span>Fecha de impresión de documentos oficiales</span></div>
        <br>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Acta examen de grado:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" <?php if(isset($datos91["F_grado"])){ echo "disabled"; } ?> class="form-control pull-right" id="txtF_grado" name="txtF_grado" value="<?php echo $datos91["F_grado"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Constancia de terminación:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" <?php if(isset($datos91["F_constancia"])){ echo "disabled"; } ?> class="form-control pull-right" id="txtF_constancia" name="txtF_constancia" value="<?php echo $datos91["F_constancia"]; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Impresión certificado:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" <?php if(isset($datos91["F_certificado"])){ echo "disabled"; } ?> class="form-control pull-right" id="txtF_certificado" name="txtF_certificado" value="<?php echo $datos91["F_certificado"]; ?>">
          </div>
        </div>
      </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>

        <button type="button" class="btn btn-primary" onClick="updateActaP(<?php echo $_POST['IdUsua']; ?>)">Guardar datos</button>
      </div>
    </div>

  </form>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <script>

  function updateActaP(IdUsua){
    var Folio = document.getElementById("txtFolio").value;
    var No = document.getElementById("txtNo").value;
    var Autorizacion = document.getElementById("txtAutorizacion").value;
    var Ciudad = document.getElementById("txtCiudad").value;
    var Hora = document.getElementById("txtHora").value;
    var Dia = document.getElementById("txtDia").value;
    var Mes = document.getElementById("txtMes").value;
    var Anio = document.getElementById("txtAnio").value;
    var Auditorio = document.getElementById("txtAuditorio").value;
    var Escuela = document.getElementById("txtEscuela").value;
    var Presidente = document.getElementById("txtPresidente").value;
    var Secretario = document.getElementById("txtSecretario").value;
    var Vocal = document.getElementById("txtVocal").value;
    var Tipo = document.getElementById("txtTipo").value;
    var Estatus = document.getElementById("txtEstatus").value;
    var Profesion = document.getElementById("txtProfesion").value;
    var Cedula1 = document.getElementById("txtCedula1").value;
    var Cedula2 = document.getElementById("txtCedula2").value;
    var Cedula3 = document.getElementById("txtCedula3").value;
    var FGrado = document.getElementById("txtF_grado").value;
    var FConstancia = document.getElementById("txtF_constancia").value;
    var FCertificado = document.getElementById("txtF_certificado").value;


    var TipoGuardar = "upd_acta_profesional";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea estos datos para la impresión del acta profesional?",
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
    	       data:{TipoGuardar:TipoGuardar, Folio:Folio, No:No, Autorizacion:Autorizacion,Ciudad:Ciudad, Hora:Hora, Dia:Dia, Mes:Mes, Auditorio:Auditorio, Escuela:Escuela, Presidente:Presidente, Secretario:Secretario, Vocal:Vocal, Tipo:Tipo, Estatus:Estatus, Profesion:Profesion, IdUsua:IdUsua, Anio:Anio, Cedula1:Cedula1, Cedula2:Cedula2, Cedula3:Cedula3, FGrado:FGrado, FConstancia:FConstancia, FCertificado:FCertificado},
    	       success:function(data){

    	       }
    	  })
        .done(function(data) {
          if(data==1){
            swal("Gudardado correctamente", "Los datos del acta profesional se han guardado correctamente.", "success");
          }
          if(data==0){
            swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
          }
        })
        .error(function(data) {
          swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
        });
      }
    });
  }

  $(function () {

    $('#txtF_grado').datepicker({
      autoclose: true
    })
    $('#txtF_constancia').datepicker({
      autoclose: true
    })
    $('#txtF_certificado').datepicker({
      autoclose: true
    })

  })
  </script>

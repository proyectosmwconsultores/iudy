<?php session_start();

$_no = substr($_GET['idToks'], 0, 1);
$_asig = substr($_GET['idToks'], 0, 26);
$IdPago = substr($_GET['idToks'], 26, $_no);
$IdUsua = $_SESSION['IdUsua'];

require('php/clases/class_openpay.php');
require('hace.php');
$openpay = new Class_openpay();
$validar = $openpay->validar_datos_pago($IdPago, $IdUsua);
$pago = $openpay->obtener_pago_id($IdPago);
$us = $openpay->obtener_usuario_id($IdUsua);

if (($validar[0]['IdPago']) && ($_SESSION['IdUsua'])) {
    $hoy = date("Y-m-d");
    
    if(isset($validar[0]['_link'])){
        if($validar[0]['_fecha'] == $hoy){
           // $link = $validar[0]['_link'];
            //header("Location: $link");
            //exit;

        }
    }
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Procesar pago</title>
    <link rel="icon" href="assets/images/campus/icono.png" type="image/x-icon">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">

    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    <script src="assets/alert/dist/sweetalert-dev.js"></script>
	<link rel="stylesheet" href="assets/alert/dist/sweetalert.css">
  </head>
  <?php



  require(dirname(__FILE__) . '/assets/Openpay/Openpay.php');

  Openpay::setId('mamgnh5fl28kbvylfzid');
  Openpay::setApiKey('pk_9b5b3af386d74f52a9b31e7aa7d25976');
  Openpay::setProductionMode(true);
  $openpay = Openpay::getInstance('mamgnh5fl28kbvylfzid', 'sk_06aa0d852c444178bc2957723b626a08');

//$customer = $openpay->customers->get('mqy5ipaqv3ew9cyp8dvk');
//$charge = $customer->charges->get('kpk9pz6ykmnvjikgnewf');

//var_dump($charge);

  ?>
  <script type="text/javascript">
    $(document).ready(function() {

      OpenPay.setId('mamgnh5fl28kbvylfzid');
      OpenPay.setApiKey('pk_9b5b3af386d74f52a9b31e7aa7d25976');
      OpenPay.setSandboxMode(false);
      //Se genera el id de dispositivo
      var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

      $('#pay-button').on('click', function(event) {
        var Nombre = document.getElementById("nombre").value;
        var Numero = document.getElementById("numero").value;
        var Mes = document.getElementById("mes").value;
        var Anio = document.getElementById("anio").value;
        var Codigo = document.getElementById("codigo").value;
        
        var Cel = document.getElementById("_cel").value;
        var Cor = document.getElementById("_cor").value;
        if(Nombre == ''){
          swal("Error al procesar", "Favor de agregar el nombre del titular de la tarjeta.", "error");
			    return 0;
        }
        if(Numero == ''){
          swal("Error al procesar", "Favor de ingresar el numero de tarjeta.", "error");
			    return 0;
        }
        if(Mes == ''){
          swal("Error al procesar", "Favor de ingresar el mes de expiración.", "error");
			    return 0;
        }
        if(Anio == ''){
          swal("Error al procesar", "Favor de ingresar el año de expiración.", "error");
			    return 0;
        }
        if(Codigo == ''){
          swal("Error al procesar", "Favor de ingresar el codigo de seguridad.", "error");
			    return 0;
        }
        if(Cel == ''){
          swal("Error al procesar", "Favor ir al módulo de actualizar sus datos y agregar su número de celular, para poder continuar con este proceso.", "error");
			    return 0;
        }
        if(Cor == ''){
          swal("Error al procesar", "Favor ir al módulo de actualizar sus datos y agregar su correo electrónico, para poder continuar con este proceso.", "error");
			    return 0;
        }
        
        
        document.getElementById("btnPagar").style.display = 'none';
        document.getElementById("div_panel").style.display = 'none';
        document.getElementById("divMsj").style.display = 'block';
        event.preventDefault();
        $("#pay-button").prop("disabled", true);
        OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
      });

      var sucess_callbak = function(response) {
        var token_id = response.data.id;

        $('#token_id').val(token_id);
        // $('#payment-form').submit();
        // document.getElementById("divImg").style.display = 'block';


        var IdUsua = document.getElementById("IdUsua").value;
        var IdPago = document.getElementById("IdPago").value;
        timeout = setTimeout(alertError, 20000);
        $.ajax({
          type: "POST",
          url: "vistas/openpay/enviar_pago.php",
          data: {
            token_id: token_id,
            deviceSessionId: deviceSessionId,
            IdUsua: IdUsua,
            IdPago: IdPago
          },
          success: function(datax) {
            if (datax == 1) {
              document.getElementById("divMsj").style.display = 'none';
              document.getElementById("_valor").value = '1';
              swal({
                  title: "¡Pago realizado correctamente!",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: '#DD6B55',
                  confirmButtonText: 'Aceptar',
                },
                function(isConfirm) {
                  if (isConfirm) {
                    parent.location.href = 'misPagos.php?idDetalle=' + datax;
                  }
                });
            } else if(datax == 0) {
              swal({
                  title: "Ha ocurrido un error, pago no procesado",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonColor: '#DD6B55',
                  confirmButtonText: 'Aceptar',

                },
                function(isConfirm) {
                  if (isConfirm) {
                    parent.location.href = 'misPagos.php';
                  }
                });
            }else {
              swal({
                  title: "Por seguridad, se realizará la confirmación de su pago por medio de 3D Secure",
                  type: "info",
                  showCancelButton: false,
                  confirmButtonColor: '#DD6B55',
                  confirmButtonText: 'Aceptar',

                },
                function(isConfirm) {
                  if (isConfirm) {
                    parent.location.href = datax;
                  }
                });
            }

          }
        });

      };

      var error_callbak = function(response) {
        var desc = response.data.description != undefined ? response.data.description : response.message;
        // alert("ERROR [" + response.status + "] " + desc);
        // var alerta =  alert("ERROR [" + response.status + "] " + desc);
        document.getElementById("divMsj").style.display = 'none';
        document.getElementById("btnPagar").style.display = 'block';
        document.getElementById("div_panel").style.display = 'block';
        // swal("Error al pagar", "ERROR:[" + response.status + "] " + desc, "error");
        swal("Error al pagar", "Se ha producido un error, no se puede procesar el pago", "error");

        $("#pay-button").prop("disabled", false);
      };
    });

    function alertError() {
      var IdPago = document.getElementById("IdPago").value;
      var Valor = document.getElementById("_valor").value;
      if (Valor == 0) {
        swal({
            title: "Ha ocurrido un error, no se puede procesar el pago.",
            type: "error",
            showCancelButton: false,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Aceptar',

          },
          function(isConfirm) {
            if (isConfirm) {
              parent.location.href = 'misPagos.php';
            }
          });
      }
    }
  </script>
  <style>
    ::-webkit-input-placeholder {
      font-style: italic;
    }

    :-moz-placeholder {
      font-style: italic;
    }

    ::-moz-placeholder {
      font-style: italic;
    }

    :-ms-input-placeholder {
      font-style: italic;
    }

    body {
      float: left;
      margin: 0;
      padding: 0;
      width: 100%;
    }

    strong {
      font-weight: 700;
    }

    a {
      cursor: pointer;
      display: block;
      text-decoration: none;
    }

    a.button {
      border-radius: 5px 5px 5px 5px;
    -webkit-border-radius: 5px 5px 5px 5px;
    -moz-border-radius: 5px 5px 5px 5px;
    text-align: center;
    font-size: 21px;
    font-weight: 400;
    padding: 12px 0;
    width: 100%;
    display: table;
    background: #E51F04;
    background: -moz-linear-gradient(top,  #E51F04 0%, #A60000 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#E51F04), color-stop(100%,#A60000));
    background: -webkit-linear-gradient(top,  #E51F04 0%,#A60000 100%);
    background: -o-linear-gradient(top,  #E51F04 0%,#A60000 100%);
    background: -ms-linear-gradient(top,  #E51F04 0%,#A60000 100%);
    background: linear-gradient(top,  #E51F04 0%,#A60000 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#E51F04', endColorstr='#A60000',GradientType=0 );
    }

    a.button i {
      margin-right: 10px;
    }

    a.button.disabled {
      background: none repeat scroll 0 0 #ccc;
      cursor: default;
    }

    .bkng-tb-cntnt {
      float: left;
      /* width: 800px; */
    }

    .bkng-tb-cntnt a.button {
      color: #fff;
      float: right;
      font-size: 18px;
      padding: 5px 20px;
      width: auto;
    }

    .bkng-tb-cntnt a.button.o {
      background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
      color: #e51f04;
      border: 1px solid #e51f04;
    }

    .bkng-tb-cntnt a.button i {
      color: #fff;
    }

    .bkng-tb-cntnt a.button.o i {
      color: #e51f04;
    }

    .bkng-tb-cntnt a.button.right i {
      float: right;
      margin: 2px 0 0 10px;
    }

    .bkng-tb-cntnt a.button.left {
      float: left;
    }

    .bkng-tb-cntnt a.button.disabled.o {
      border-color: #ccc;
      color: #ccc;
    }

    .bkng-tb-cntnt a.button.disabled.o i {
      color: #ccc;
    }

    .pymnts {
      float: left;
      /* width: 800px; */
    }

    .pymnts * {
      float: left;
    }

    .sctn-row {
      margin-bottom: 35px;
      /* width: 800px; */
    }

    .sctn-col {
      width: 375px;
    }

    .sctn-col.l {
      width: 425px;
    }

    .sctn-col input {
      border: 1px solid #ccc;
      font-size: 14px;
      line-height: 14px;
      padding: 10px 12px;
      width: 333px;
    }

    .sctn-col label {
      font-size: 14px;
      line-height: 14px;
      margin-bottom: 10px;
      width: 100%;
    }

    .sctn-col.x3 {
      width: 300px;
    }

    .sctn-col.x3.last {
      width: 200px;
    }

    .sctn-col.x3 input {
      width: 210px;
    }

    .sctn-col.x3 a {
      float: right;
    }

    .pymnts-sctn {
      width: 800px;
    }

    .pymnt-itm {
      margin: 0 0 3px;
      /* width: 800px; */
    }

    .pymnt-itm h2 {
      background-color: #e9e9e9;
      font-size: 24px;
      line-height: 24px;
      margin: 0;
      padding: 28px 0 28px 20px;
      width: 780px;
    }

    .pymnt-itm.active h2 {
      background-color: #e9e9e9;
    font-size: 24px;
    line-height: 24px;
    margin: 0;
    padding: 28px 0 28px 20px;
    width: 780px;
    }

    .pymnt-itm div.pymnt-cntnt {
      display: none;
    }

    .pymnt-itm.active div.pymnt-cntnt {
      background-color: #f7f7f7;
      display: block;
      padding: 0 0 30px;
      width: 100%;
    }

    .pymnt-cntnt div.sctn-row {
      margin: 1px 20px 0;
      width: 104%;
    }

    .pymnt-cntnt div.sctn-row div.sctn-col {
      width: 345px;
    }

    .pymnt-cntnt div.sctn-row div.sctn-col.l {
      width: 395px;
    }

    .pymnt-cntnt div.sctn-row div.sctn-col input {
      width: 303px;
    }

    .pymnt-cntnt div.sctn-row div.sctn-col.half {
      width: 155px;
    }

    .pymnt-cntnt div.sctn-row div.sctn-col.half.l {
      float: left;
      width: 190px;
    }

    .pymnt-cntnt div.sctn-row div.sctn-col.half input {
      width: 113px;
    }

    .pymnt-cntnt div.sctn-row div.sctn-col.cvv {
      background-image: url("./assets/images/cvv.png");
      background-position: 126px center;
      background-repeat: no-repeat;
      padding-bottom: 25px;
    }

    .pymnt-cntnt div.sctn-row div.sctn-col.cvv div.sctn-col.half input {
      width: 110px;
    }

    .openpay {
      float: right;
      height: 60px;
      margin: 2px 30px 0 0;
      width: 435px;
    }

    .openpay div.logo {
      background-image: url("./assets/images/openpay.png");
      background-position: left bottom;
      background-repeat: no-repeat;
      border-right: 1px solid #ccc;
      font-size: 12px;
      font-weight: 400;
      height: 45px;
      padding: 0px 20px 0 0;
    }

    .openpay div.shield {
      background-image: url("./assets/images/security.png");
      background-position: left bottom;
      background-repeat: no-repeat;
      font-size: 12px;
      font-weight: 400;
      margin-left: 20px;
      padding: 0px 0 0 40px;
      width: 200px;
    }

    .card-expl {
      float: left;
      height: 80px;
      margin: 10px 0;
      /* width: 800px; */
    }

    .card-expl div {
      background-position: left 45px;
      background-repeat: no-repeat;
      height: 70px;
      padding-top: 10px;
    }

    .card-expl div.debit {
      background-image: url("./assets/images/cards2.png");
      margin-left: 20px;
      width: 440px;
    }

    .card-expl div.credit {
      background-image: url("./assets/images/cards1.png");
      border-right: 1px solid #ccc;
      margin-left: 30px;
      width: 209px;
    }

    .card-expl h4 {
      font-weight: 400;
      margin: 0;
    }
  </style>

  <body class="hold-transition lockscreen">
    <section class="invoice">
      <div class="row">
        <div class="col-xs-12">
          <h6 class="page-header" style="font-size: 18px;">
            <i class="fa fa-expeditedssl"></i> PAGO DE <?php echo $pago[0]["NomConcepto"] . ' ' . obtener_AnioMesMAY($pago[0]["Fecha"]); ?>
            <small class="pull-right" style="color: blue;">Recuerde que tiene 5 minutos para realizar este pago.</small>
          </h6>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12" id="divMsj" style="display: none;">
            <p style="text-align: center;">
              <img src="assets/images/cargando.gif" style='position: relative; z-index: 9999;'>
            </p>
            <p style="text-align: center;">
              <img src="assets/images/procesando_pago.jpg" style='margin-top: -217px; position: relative; z-index: 0; '>
            </p>
          </div>
        </div>
      </div>

      <div class="row" id="div_panel">
        <div class="col-md-3">
          <p class="lead">Detalle del pago a realizar</p>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <th style="width:50%">Importe:</th>
                  <td style="text-align: right;">$ <?php echo number_format($pago[0]["Monto"], 2, '.', ','); ?></td>
                </tr>
                <tr>
                  <th>Descuento:</th>
                  <td style="text-align: right;">$ <?php echo number_format($pago[0]["Descuento"], 2, '.', ','); ?></td>
                </tr>
                <tr>
                  <th>Recargo:</th>
                  <td style="text-align: right;">$ <?php echo number_format($pago[0]["Recargos"], 2, '.', ','); ?></td>
                </tr>
                <tr>
                  <th>Abono:</th>
                  <td style="text-align: right;">$ <?php echo number_format($pago[0]["TotalPagado"], 2, '.', ','); ?></td>
                </tr>
                <?php
                $importe = ($pago[0]["Monto"] + $pago[0]["Recargos"] - $pago[0]["Descuento"] - $pago[0]["TotalPagado"] - $pago[0]["Descuento2"]); ?>
                <tr>
                  <th>Total pagar:</th>
                  <td style="text-align: right;"><b>$ <?php echo number_format($importe, 2, '.', ','); ?></b></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row no-print">
            <div class="col-xs-12" style="text-align: center;"><br>
              <a style="margin-bottom: 15px;" onClick="window.open('misPagos.php','_self')" href="javascript:void(0);" class="btn btn-primary"><i class="fa fa-fw fa-caret-square-o-left"></i> Regresar a la plataforma.</a>
              <?php if((!$us[0]['Celular']) || (!$us[0]['Correo'])) { ?>
              <a style="margin-bottom: 15px;" onClick="window.open('misDatos.php','_self')" href="javascript:void(0);" class="btn btn-danger"><i class="fa fa-fw fa-edit"></i> Actualizar datos.</a>
              <?php } ?>
              
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="pymnts">
            <form action="#" method="POST" id="payment-form">
              <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden" />
              <input id="IdPago" name="IdPago" value="<?php echo $IdPago; ?>" type="hidden" />
              <input id="_valor" name="_valor" value="0" type="hidden" />
              <input type="hidden" name="token_id" id="token_id">
              <input type="hidden" name="_cel" id="_cel" value="<?php echo $us[0]['Celular']; ?>">
              <input type="hidden" name="_cor" id="_cor" value="<?php echo $us[0]['Correo']; ?>">
              <div class="pymnt-itm card active" style="width: 100%;">
                <h2 style="width: 100%;">Tarjeta de crédito o débito</h2>
                <div class="pymnt-cntnt">
                  <div class="card-expl">
                    <div class="credit">
                      <h4>Tarjetas de crédito</h4>
                    </div>
                    <div class="debit">
                      <h4>Tarjetas de débito</h4>
                    </div>
                  </div>
                  <div class="sctn-row">

                    <div class="sctn-col l" style="width: 350px;">
                      <label>Nombre del titular</label><input type="text" id="nombre" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
                    </div>
                    <div class="sctn-col">
                      <label>Número de tarjeta</label><input onchange="validar_input(this)" type="text" id="numero" maxlength="16" autocomplete="off" data-openpay-card="card_number" value="">
                    </div>
                  </div>
                  <div class="sctn-row">
                    <div class="sctn-col l" style="width: 350px;">
                      <label>Fecha de expiración</label>
                      <div class="sctn-col half l" style="width: 155px;"><input onchange="validar_input(this)" id="mes" maxlength="2" type="text" placeholder="Mes" data-openpay-card="expiration_month" value=""></div>
                      <div class="sctn-col half l"><input onchange="validar_input(this)" type="text" maxlength="2" id="anio" placeholder="Año" data-openpay-card="expiration_year" value=""></div>
                    </div>
                    <div class="sctn-col cvv"><label>Código de seguridad</label>
                      <div class="sctn-col half l"><input onchange="validar_input(this)" type="text" maxlength="4" id="codigo" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2" value=""></div>
                    </div>
                  </div>
                  <div class="openpay">
                    <div class="logo">Transacciones realizadas vía:</div>
                    <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256 bits</div>
                  </div><?php if ($pago[0]['IdEstatus'] == 1) { ?>
                    <div class="sctn-row" id='btnPagar'>
                      <a style="margin-top: 15px; width: 90%;" class="button rght" id="pay-button">Pagar</a>
                    </div><?php } ?>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script>
    function validar_input(valor){
        var numero = valor.value;
        if( isNaN(numero) ) {
          swal("Error al procesar", "Favor revisar el dato ingresado no es un número.", "error");
			    return 0;
        }
    }
</script>
  </body>

  </html>
<?php } else {
  header('Location: misPagos.php');
  exit;
} ?>
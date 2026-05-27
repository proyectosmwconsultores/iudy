<?php $_v = 50; $section = "Renovar paquete"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de comprar paquete.'); }
$IdCompra = substr($_GET['idCompra'],10,10);

$prod=$t->get_renovarId($IdCompra);

require ( dirname (__FILE__). '/alumnos/Openpay/Openpay.php' );

Openpay :: setId ( 'my4ncu75sbnfu9xy4rgp' );
Openpay :: setApiKey ( 'pk_330c0f98997c47c6801896d6f577fb07' );
Openpay::setProductionMode(false);
$openpay = Openpay::getInstance('my4ncu75sbnfu9xy4rgp', 'sk_f7feb93cd4cc4bb2a5e6fd0ed3d338a7');

?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

<script type="text/javascript">
		        $(document).ready(function() {

		            OpenPay.setId('my4ncu75sbnfu9xy4rgp');
		            OpenPay.setApiKey('pk_330c0f98997c47c6801896d6f577fb07');
		            OpenPay.setSandboxMode(true);
		            //Se genera el id de dispositivo
		            var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

		            $('#pay-button').on('click', function(event) {
									  document.getElementById("btnPagar").style.display = 'none';
		                event.preventDefault();
		                $("#pay-button").prop( "disabled", true);
		                OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
		            });

		            var sucess_callbak = function(response) {
		              var token_id = response.data.id;

		              $('#token_id').val(token_id);
		              // $('#payment-form').submit();
									// document.getElementById("divImg").style.display = 'block';
									document.getElementById("divMsj").style.display = 'block';

									var IdUsua = document.getElementById("IdUsua").value;
                  var IdCompra = document.getElementById("IdCompra").value;
									var IdCompraRenovar = document.getElementById("IdCompraRenovar").value;

									$.ajax({
		                type:"POST",
		                url:"alumnos/enviar_pago_renovar.php",
		                data:{token_id:token_id, deviceSessionId:deviceSessionId,IdUsua:IdUsua,IdCompra:IdCompra, IdCompraRenovar:IdCompraRenovar},
		                success:function(datax){ // alert(datax);
 											// document.getElementById("divImg").style.display = 'none';
 											document.getElementById("divMsj").style.display = 'none';
											swal({
												title: "Continuar con el proceso de pago...",
												type: "success",
												showCancelButton: false,
												confirmButtonColor: '#DD6B55',
												confirmButtonText: 'Continuar',

											},
											function (isConfirm) {
												if (isConfirm) {
													parent.location.href='miscompras.php?idDetalle='+datax;
												}
											});
		                }
		              });

		            };

		            var error_callbak = function(response) {
		                var desc = response.data.description != undefined ? response.data.description : response.message;
										// alert("ERROR [" + response.status + "] " + desc);
		                // var alerta =  alert("ERROR [" + response.status + "] " + desc);
										document.getElementById("btnPagar").style.display = 'block';
										swal("Error al pagar", "ERROR:[" + response.status + "] " + desc, "error");
		                $("#pay-button").prop("disabled", false);
		            };

		        });
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
    /* width: 800px; */
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
    background-color: #e51f04;
    color: #fff;
    cursor: default;
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
    width: 740px;
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
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Comprar paquete en MWComenius
				</h1>
			</section>
			<section class="content">

				<div class="row">
						 <div class="col-md-12">
	           <div class="box">
	             <div class="box-body">
	               <div class="row">

              <div class="col-md-12" id="divMsj" style="display: none;">
                <div class="alert alert-success alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 <h4><i class="icon fa fa-check"></i> ¡Pago en proceso!</h4>
                 Por favor espere... estamos procesando su pago. Gracias.
               </div>
               <p style="text-align: center;">
                 <img src="assets/images/cargando.gif" >
               </p>
              </div>


									 <div class="col-md-4">

          <p class="lead">Detalle de la renovación</p>

          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr><th colspan="2">Paquete <?php echo $prod[0]['Paquete']; ?></th></tr>
              <tr>
                <th>Espacio</th>
                <td><?php echo $prod[0]['Espacio']; ?> usuarios</td>
              </tr>
              <tr>
                <th>Precio:</th>
                <td>$ <?php echo $prod[0]['Monto']; ?></td>
              </tr>
              <tr style="background: red; color: white;">
                <th>Total pagar:</th>
                <td>$ <?php echo $prod[0]['Monto']; ?></td>
              </tr>
            </tbody></table>
            <a onclick="actualizarPaq()" href="javascript:void(0);" style="margin-left: 0px;" class="btn btn-default btn-block btn-sm bg-navy btn-flat margin"> <i class="fa fa-fw fa-refresh"></i> Cambiar Paquete </a>
          </div>

									 </div>
	                 <div class="col-md-8">
										 <div class="pymnts">
																	            <form action="#" method="POST" id="payment-form">
																								<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
                                                <input id="IdCompra" name="IdCompra" value="<?php echo $IdCompra; ?>" type="hidden"/>
																								<input id="IdCompraRenovar" name="IdCompraRenovar" value="<?php echo $prod[0]['IdCompraRenovar']; ?>" type="hidden"/>
																	                <input type="hidden" name="token_id" id="token_id">
																	                <div class="pymnt-itm card active" style="width: 90%;">


																	                    <h2 style="width: 100%;">Tarjeta de crédito o débito</h2>
																											<div class="pymnt-cntnt">
																	                        <div class="card-expl">
																	                            <div class="credit"><h4>Tarjetas de crédito</h4></div>
																	                            <div class="debit"><h4>Tarjetas de débito</h4></div>
																	                        </div>
																	                        <div class="sctn-row">

																	                            <div class="sctn-col l" style="width: 350px;">
																	                                <label>Nombre del titular</label><input type="text" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
																	                            </div>
																	                            <div class="sctn-col" >
																	                                <label>Número de tarjeta</label><input type="text" autocomplete="off" data-openpay-card="card_number" value="4242424242424242"></div>
																	                            </div>
																	                            <div class="sctn-row">
																	                                <div class="sctn-col l" style="width: 350px;">
																	                                    <label>Fecha de expiración</label>
																	                                    <div class="sctn-col half l" style="width: 155px;"><input type="text" placeholder="Mes" data-openpay-card="expiration_month" value="09"></div>
																	                                    <div class="sctn-col half l"><input type="text" placeholder="Año" data-openpay-card="expiration_year" value="29"></div>
																	                                </div>
																	                                <div class="sctn-col cvv"><label>Código de seguridad</label>
																	                                    <div class="sctn-col half l"><input type="text" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2" value="842"></div>
																	                                </div>
																	                            </div>
																	                            <div class="openpay"><div class="logo">Transacciones realizadas vía:</div>
																	                            <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256 bits</div>
																	                        </div>
																	                        <div class="sctn-row" id='btnPagar'>
																	                                <a style="margin-top: 15px; width: 90%;" class="button rght" id="pay-button">Pagar</a>
																	                        </div>
																	                    </div>
																	                </div>
																	            </form>
																	        </div>
	           				</div>

	                 </div>
	               </div>
	             </div>
	           </div>
      	</div>
			</section>

		</div>

		 <div id="dataEva"  class="modal fade">
		 		 <div class="modal-dialog">
		 					<div class="modal-content">
		 							 <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
		 										<button type="button" class="close" data-dismiss="modal">&times;</button>
		 										<h4 class="modal-title"><i class="fa fa-fw fa-refresh"></i> Actualizar paquete</h4>
		 							 </div>
		 							 <div class="modal-body" id="employee_eva">
		 							 </div>
		 					</div>
		 		 </div>
		 </div>
	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->

<script>
function actualizarPaq(){
  var IdCompra = document.getElementById("IdCompra").value;
  var IdCompraRenovar = document.getElementById("IdCompraRenovar").value;
  $.ajax({
       url:"reportes/actualizarRenov.php",
       method:"POST",
       data:{IdCompra:IdCompra,IdCompraRenovar:IdCompraRenovar},
       success:function(data){
            $('#employee_eva').html(data);
            $('#dataEva').modal('show');
       }
  });
}
</script>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- Page script -->
</body>
</html>

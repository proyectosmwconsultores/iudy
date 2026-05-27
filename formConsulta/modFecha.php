<?php
include('../hace.php');
if(isset($_POST["employee_id"])){

  $IdPago = $_POST["employee_id"];
  $Oferta = $_POST["Oferta"];
  $Grupo = $_POST["Grupo"];
  $Concepto = $_POST["Concepto"];
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdGrupo, tblp_pagos.FecLimPago FROM tblc_usuario Left Join tblp_pagos ON tblp_pagos.IdUsua = tblc_usuario.IdUsua WHERE tblc_usuario.Tipo =  '3' AND tblc_usuario.IdGrupo =  '$Grupo' AND tblc_usuario.IdOferta = '$Oferta' AND tblp_pagos.IdConcepto = '$Concepto' AND tblp_pagos.IdEstatus <> '4'  GROUP BY tblc_usuario.IdUsua");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwFecha = $datos91["FecLimPago"];
  //echo $rwFecha;
  $anio = substr($rwFecha,0,4);
  $mes = substr($rwFecha,5,2);
  $dia = substr($rwFecha,8,2);
$fecha = $anio.'/'.$mes.'/'.$dia;

  //$row=mysql_fetch_array($res1);
  $output .= '
  <form name="frm5" id="frm5" action="modFecha.php" method="POST" enctype="multipart/form-data">
  <input id="Oferta" name="Oferta" value="'.$Oferta.'" type="hidden"/>
  <input id="Grupo" name="Grupo" value="'.$Grupo.'" type="hidden"/>
  <input id="Concepto" name="Concepto" value="'.$Concepto.'" type="hidden"/>
  <input id="Fecha" name="Fecha" value="'.$fecha.'" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">

        <div class="col-md-12">
        <div class="form-group">
          <label>Fecha l&iacute;mite de pago Actual:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input disabled type="text" class="form-control pull-right" id="f" name="f" value="'.$fecha.'">
          </div>
        </div>
        </div>

        <div class="col-md-12">
        <div class="form-group">
          <label>Fecha l&iacute;mite de pago Especial:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
          </div>
        </div>
        </div>




       <div class="col-md-12">
         <div class="form-group">
           <label>Comentario:</label>
           <div class="input-group">
             <div class="input-group-addon">
               <i class="fa fa-commenting"></i>
             </div>
             <input type="text" class="form-control pull-right" id="txtComentario" name="txtComentario">
           </div>
         </div>
       </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>&nbsp;</label>
            <div class="input-group">
              <button type="button" class="btn btn-block btn-danger" onClick="val_modFecha()"> CAMBIAR FECHA</button>
            </div>
          </div>
        </div>

        </div>
      </div>
    </table>
  </div>
  </form>';
  echo $output;
}
?>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1
<script src="bower_components/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script language="javascript">
      $(document).ready(function(){
        $("#txtIdDescuento").change(function () {
          var IdDescuento = parseFloat(document.getElementById("txtIdDescuento").value);
          var Porcentaje = parseFloat(document.getElementById("txtPorcentaje").value);
          if(!IdDescuento){ IdDescuento = 0; }
          if(!Porcentaje){ Porcentaje = 0; }
          calDescuento(IdDescuento,Porcentaje);
        });
      });

      function calDescuento(IdDescuento,Porcentaje){
        if(IdDescuento == 0){
          swal("Error", "Debe seleccionar el tipo de Descuento", "info");
        } else {
          var jsdescuento = 0;
          var jsporcentaje = 0;
          var jstotDescu = 0;
          var jssumtotal = 0;
          var jsResultado = 0;

          jsporcentaje = (Porcentaje * 0.01);


          var Monto = parseFloat(document.getElementById("EnMonto").value);
          var Recargo = parseFloat(document.getElementById("EnRecargo").value);
          if(!Recargo){ Recargo = 0; }



          if((IdDescuento == 2) || (IdDescuento == 4)){
            jsdescuento = (Recargo * jsporcentaje);   // CALCULA EL MONTO A DESCONTAR
            jstotDescu = Recargo - jsdescuento;
            jsResultado = (jstotDescu + Monto);
          }
          if(IdDescuento == 3){
            jsdescuento = (Monto * jsporcentaje);   // CALCULA EL MONTO A DESCONTAR
            jstotDescu = Monto - jsdescuento;
            jsResultado = (jstotDescu + Recargo);
          }
          if(IdDescuento == 5){
            jssumtotal = Monto + Recargo;
            jsdescuento = (jssumtotal * jsporcentaje);   // CALCULA EL MONTO A DESCONTAR
            jsResultado = jssumtotal - jsdescuento;
          }

          document.getElementById("txtDescuento").value = jsdescuento;
          document.getElementById("txtTotal").value = jsResultado;

          document.getElementById("EnDescuento").value = jsdescuento;
          document.getElementById("EnTotal").value = jsResultado;

        }
      }

    </script>


<script>
// $("#txtDescuento").change(function () {
//
//
// //   var recargo = parseFloat(document.getElementById("Recargo").value);
// //   var Pagar = parseFloat(document.getElementById("Pagar").value);
// //   var sss = recargo + Pagar;
// //
// //   document.getElementById("txtPorcentaje").value = "";
// // //  document.getElementById("txtTotal").value = sss;
// //   document.getElementById("txtMontoDesc").value = "";
// //
// //   document.getElementById("montoDesc").value = "";
// //   document.getElementById("Total").value = "";
// //   document.getElementById("Recargo").value = "";
// //
// //
// //           var IdDescuento = document.getElementById("txtDescuento").value;
//
//         });



        function calcular(valor,nombre)
        {
          //$('#txtBtn').attr("disabled", true);
          var numero = valor.value;
          if(!numero){
            numero = 0;
            document.getElementById("txtPorcentaje").value = "0";
          }

          var IdDescuento = parseFloat(document.getElementById("txtIdDescuento").value);
          if(!IdDescuento){ IdDescuento = 0; }
          calDescuento(IdDescuento,numero);
        }
        //alert(numero);
//         if(numero){
//           alert(numero);
//           var IdDescuento = parseFloat(document.getElementById("txtDescuento").value);
//           var recargo = parseFloat(document.getElementById("Recargo").value);
//           var Pagar = parseFloat(document.getElementById("Pagar").value);
//           var descuento = 0;
//           var totalRec = 0;
//           var convPorcentaje = 0;
//           var suma = 0;
//
//           convPorcentaje = (numero * 0.01)          //PORCENTAJE
//           if((IdDescuento == 2) || (IdDescuento == 4)){
//             descuento = (recargo * convPorcentaje);   // CALCULA EL MONTO A DESCONTAR
//             totalRec = recargo - descuento;
//           }
//           if(IdDescuento == 3){
//             descuento = (Pagar * convPorcentaje);   // CALCULA EL MONTO A DESCONTAR
//             totalRec = Pagar - descuento;
//           }
//           if(IdDescuento == 5){
//             var sumRC = 0;
//             sumRC = recargo + Pagar;
//             descuento = (sumRC * convPorcentaje);   // CALCULA EL MONTO A DESCONTAR
//             totalRec = sumRC - descuento;
//           }
//
//
//         //  suma = Pagar + totalRec;
//
// alert(numero);
//           document.getElementById("txtMontoDesc").value = descuento;
//           document.getElementById("montoDesc").value = descuento;
//           document.getElementById("txtTotal").value = totalRec;
//         }





  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('yyyy/mm/dd', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()



    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>

<?php session_start();
  include('../hace.php');
  require('../php/clases/class.php');
  $t=new Trabajo();
  $acces = 0;
  $permiso = $_SESSION['Permisos'];
  $IdAsignacion = $_POST['IdAsignacion'];

  $valor = 0;

  $_user=$t->get_user_lista($IdAsignacion);
  $emision=$t->get_fec_emi($IdAsignacion);

  if($emision[0]['Fecha_impresion']){
    $acces = 0;
  } else {
    $acces = 1;
  }

  if(($permiso == 1) || ($permiso == 9)){
    $acces = 1;
  }


?>

  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-file-text-o"></i> Lista de asistencia</h3>
    <p class="margin" style="text-align: right;">
    <button type="button" class="btn bg-navy btn-flat margin view_fondo" id="<?php echo date("Y-m-d"); ?>" style="float: left;"> <i style="color: yellow;"  class="fa fa-fw fa-check-circle"></i> HAZ QUIC PARA PASAR ASISTENCIA </button>
      <code onclick="cargar_lista()" style="color: blue; cursor: pointer;"><i style="color: blue; cursor: pointer;" class="fa fa-fw fa-refresh"></i> Actualizar lista asistencia</code>
      <code><i style="color: black;" class="fa fa-fw fa-minus"></i> Pendiente</code>
      <code><i style="color: blue;" class="fa fa-fw fa-check-circle"></i>A =  Asistencia</code>
      <code><i style="color: orange;"  class="fa fa-fw fa-warning"></i> P = Permiso</code>
      <code><i style="color: red;"  class="fa fa-fw fa-times-circle"></i>F = Falta</code>
    </p>
  </div>
  <?php if($acces == 1){ ?>
  <div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> Espacio disponible para el pase de lista de la materia</span></div>
<?php } else { ?>
<div class="bg-yellow-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-warning"></i> En este espacio solo podra visualizar la lista de asistencia</span></div>
  <?php } ?>
  <div class="box-body no-padding">
    
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th></th>
          <th >NOMBRE DEL ALUMNO</th>
         
          <!-- <th style="background: white; text-align: center;">A</th>
          <th style="background: white; text-align: center;">P</th>
          <th style="background: white; text-align: center;">F</th> -->
        </tr>
      <?php $vn = 0; $cx = 0; $s_a = 0; $s_r = 0; $s_f = 0; $alu = 0;
      for ($x=0;$x< sizeof($_user);$x++) { $alu = ($alu + 1); ?> 

      <tr <?php if($_user[$x]['IdEstatus'] == 8){ echo "style='color: black;'"; } else { echo "style='color: red;'";  } ?> >
        <td>
          <b><?php echo $vn = ($vn + 1); ?>.-</b>
        </td>
        <td>
          <?php echo $_user[$x]['APaterno'].' '.$_user[$x]['AMaterno'].' '.$_user[$x]['Nombre']; ?>
        </td>

        <!-- <td style="text-align: center; ">1</td>
        <td style="text-align: center; ">2</td>
        <td style="text-align: center; ">3</td> -->
      </tr><?php } ?>
   </tbody></table>
  
    <div class="box-footer clearfix">
        <button onclick="javascript:window.open('repositorio/portafolio/listaAsistencia.php?tokenId=<?php echo $IdAsignacion; ?>&AnioMes=<?php echo $AnioMes; ?>');" href="javascript:void(0);" title="Descargar lista de alumnos del grupo" type="button" class="pull-right btn bg-maroon btn-flat margin">Lista de asistencia detallado <i class="fa fa-fw fa-file-pdf-o"></i></button>
      <button onClick="window.open('repositorio/portafolio/lista_asistencia.php?tokenId=<?php echo $IdAsignacion; ?>','_blank')" href="javascript:void(0);" title="Descargar lista de alumnos del grupo" type="button" class="pull-right btn bg-navy btn-flat margin">Asistencia <i class="fa fa-fw fa-file-pdf-o"></i></button>
    </div>
  </div>

<script>
$(document).ready(function(){
     $(document).on('click', '.view_fondo', function(){
          var Fecha = $(this).attr("id");
          var IdAsignacion = document.getElementById("IdAsignacion").value;
          var Pasar = 0;
          $.ajax({
              url:"formConsulta/pasarLista.php",
              method:"POST",
              data:{IdAsignacion:IdAsignacion, Fecha:Fecha, Pasar:Pasar},
              success:function(data){
                   $('#employee_fondo').html(data);
                   $('#dataFondo').modal('show');
              }
         });
     });
});

function cambiar_dia_asistencia(IdAsignacion){
  document.getElementById("div_mostrar_lista").style.display = "none";
  document.getElementById("p_imagen").style.display = "block";
  var Fecha = document.getElementById("fecha_lista").value;
  
  var Pasar = 0;
  $.ajax({
              url:"formConsulta/pasarLista.php",
              method:"POST",
              data:{IdAsignacion:IdAsignacion, Fecha:Fecha, Pasar:Pasar},
              success:function(data){
                   $('#employee_fondo').html(data);
                   $('#dataFondo').modal('show');
              }
         });
}

function cambiarMes(){
  var AnioMes = document.getElementById("AnioMes").value;
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var Capa = "#miTablaEvaluacion";

    $(Capa).load("formConsulta/lista_asistencia.php",{IdAsignacion:IdAsignacion, AnioMes: AnioMes}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("btn_img").style.display = 'none';
}

function cargar_lista(){
  var IdAsignacion = document.getElementById("IdAsignacion").value;

    var TipoGuardar = "gen_pase_lista";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea actualizar su lista de asistencia?",
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
    	       data:{TipoGuardar:TipoGuardar, IdAsignacion:IdAsignacion},
    	       success:function(data){

    	       }
    	  })
        .done(function(data) {
          if(data==1){
            swal("Actualizado correctamente", "Los datos se han actualizado correctamente.", "success");
            cambiarMes();
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
</script>

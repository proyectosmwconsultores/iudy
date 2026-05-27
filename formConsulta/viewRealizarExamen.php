<?php
session_start();
include('../hace.php');
if(isset($_POST["IdActividadDoc"])){

  $IdParcialDoc = $_POST["IdParcial"];
  $IdUsua = $_POST["IdUsua"];
  $IdActividadDoc = $_POST["IdActividadDoc"];
  $IdAsig = $_POST["IdAsignacion"];
  $IdTarea = $_POST["IdTarea"];
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  $sql8 = $db->query("SELECT * FROM tblp_examusuario WHERE tblp_examusuario.IdAsignacion = '$IdAsig' AND tblp_examusuario.IdParcialDocente = '$IdParcialDoc' AND tblp_examusuario.IdActividadesDocente = '$IdActividadDoc' AND tblp_examusuario.IdUsua = '$IdUsua' AND tblp_examusuario.IdTarea = '$IdTarea'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdExamU = $datos81["IdExamenUsua"];
  $IdEstatus = $datos81["IdEstatus"];

  if($datos81["IdEstatus"] == 12){
    $sql7 = $db->query("SELECT tblp_exampregunta.IdPregunta FROM tblp_exampregunta WHERE tblp_exampregunta.IdAsignacion = '$IdAsig' AND tblp_exampregunta.IdActividadesDocente = '$IdActividadDoc' AND tblp_exampregunta.IdParcialDocente = '$IdParcialDoc'");
    while($x = $db->recorrer($sql7)){
      $IdPreg = $x["IdPregunta"];
      $insertar = $db->query("INSERT INTO tblp_examresultado (IdUsua, IdAsignacion, IdExamenUsuario, IdParcialDocente, IdActividadesDocente, IdPregunta)VALUES('$IdUsua','$IdAsig','$IdExamU','$IdParcialDoc','$IdActividadDoc','$IdPreg')");
    }
     $min =date("i-s");
     $anio = date("Y");
     $mes = date("m");
     $dia = date("d");
     $hora = date("G") + 1;
     if($hora > 24){ $dia = $dia + 1; $hora = "01"; }

     $ini =date("Y-m-d G-i-s");
     $fin =date("Y-m-$dia $hora-i-s");

     $insertar = $db->query("UPDATE tblp_examusuario SET tblp_examusuario.IdEstatus = '8',  tblp_examusuario.FecIni = '$ini', tblp_examusuario.FecFin = '$fin' WHERE tblp_examusuario.IdExamenUsua = '$IdExamU'");

  }


 $sql = $db->query("SELECT tblp_examresultado.IdResultado, tblp_examresultado.IdPregunta, tblp_exampregunta.Pregunta FROM tblp_examresultado Left Join tblp_exampregunta ON tblp_exampregunta.IdPregunta = tblp_examresultado.IdPregunta WHERE tblp_examresultado.IdExamenUsuario = '$IdExamU' AND tblp_examresultado.IdAsignacion = '$IdAsig' AND tblp_examresultado.IdActividadesDocente = '$IdActividadDoc' AND tblp_examresultado.Valor IS NULL order BY RAND() LIMIT 1 ");

 $sql6 = $db->query("SELECT Count(tblp_examresultado.IdResultado) AS Preguntas FROM tblp_examresultado WHERE tblp_examresultado.IdExamenUsuario = '$IdExamU' AND tblp_examresultado.IdAsignacion = '$IdAsig' AND tblp_examresultado.IdActividadesDocente = '$IdActividadDoc' ");
 $db->rows($sql6);
 $datos61 = $db->recorrer($sql6);

 $sql5 = $db->query("SELECT Count(tblp_examresultado.IdResultado) AS Contestadas FROM tblp_examresultado WHERE tblp_examresultado.IdExamenUsuario =  '$IdExamU' AND tblp_examresultado.IdAsignacion =  '$IdAsig' AND tblp_examresultado.IdActividadesDocente =  '$IdActividadDoc' AND tblp_examresultado.Valor IS NOT NULL");
 $db->rows($sql5);
 $datos51 = $db->recorrer($sql5);

 $valorPre = (100 / $datos61["Preguntas"]);
 $avaPre = ($datos51["Contestadas"] * $valorPre);

$dispo = 0;
if($datos61["Preguntas"] == $datos51["Contestadas"]){
  $dispo = 1;
  $sql4 = $db->query("SELECT Sum(tblp_examresultado.Valor) AS Puntos FROM tblp_examresultado WHERE tblp_examresultado.IdUsua =  '$IdUsua' AND tblp_examresultado.IdExamenUsuario =  '$IdExamU' AND tblp_examresultado.IdParcialDocente =  '$IdParcialDoc' AND tblp_examresultado.IdActividadesDocente =  '$IdActividadDoc'");
  $db->rows($sql4);
  $datos41 = $db->recorrer($sql4);
  $buenas = $datos41["Puntos"];

  $por = $datos91["Porcentaje"];
  $IdUsua = $_SESSION["IdUsua"];
  $res1 = ($buenas / $datos61["Preguntas"]);
  $TotaOb = ($por * $res1);
  $cal = ($TotaOb / 10);

  $insertar = $db->query("UPDATE tblp_tareas SET tblp_tareas.Porcentaje = '$TotaOb', tblp_tareas.Calificacion = '$TotaOb'  WHERE tblp_tareas.IdTarea ='$IdTarea'");
  $insertar = $db->query("UPDATE tblp_examusuario SET tblp_examusuario.IdEstatus = '26' WHERE tblp_examusuario.IdExamenUsua = '$IdExamU'");
}

$x = date("H:m:s");
$final = substr($datos81["FecFin"], 11, 15);
if($x > $final){ $t = "Terminó: ";
  $dispo = 1;
  $sql4 = $db->query("SELECT Sum(tblp_examresultado.Valor) AS Puntos FROM tblp_examresultado WHERE tblp_examresultado.IdUsua =  '$IdUsua' AND tblp_examresultado.IdExamenUsuario =  '$IdExamU' AND tblp_examresultado.IdParcialDocente =  '$IdParcialDoc' AND tblp_examresultado.IdActividadesDocente =  '$IdActividadDoc'");
  $db->rows($sql4);
  $datos41 = $db->recorrer($sql4);
  $buenas = $datos41["Puntos"];

  $por = $datos91["Porcentaje"];
  $IdUsua = $_SESSION["IdUsua"];
  $res1 = ($buenas / $datos61["Preguntas"]);
  $TotaOb = ($por * $res1);
  $cal = ($TotaOb / 10);

  $insertar = $db->query("UPDATE tblp_tareas SET tblp_tareas.Porcentaje = '$cal', tblp_tareas.Calificacion = '$TotaOb'  WHERE tblp_tareas.IdTarea ='$IdTarea'");
  $insertar = $db->query("UPDATE tblp_examusuario SET tblp_examusuario.IdEstatus = '26' WHERE tblp_examusuario.IdExamenUsua = '$IdExamU'");
} else { $t = "Termina: ";}


  ?>
  <form name="frm2" id="frm2" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAsig; ?>" type="hidden"/>
    <input id="IdParcial" name="IdParcial" value="<?php echo $IdParcialDoc; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
    <input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $IdActividadDoc; ?>" type="hidden"/>
    <input id="IdTarea" name="IdTarea" value="<?php echo $IdTarea; ?>" type="hidden"/>

    <div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title"><?php echo $datos91["NomActividad"]; ?> <b style="float: right; margin-right: 10px;"><?php //echo substr($datos81["FecIni"], 11, 15); ?> <?php echo $t; ?>  <?php echo $datos81["FecFin"]; ?></b></h4>
    </div>

  <hr>
<!-- :IdAsignacion,:IdUsua,:IdParcial,:IdActividadDoc,:IdTarea -->
<?php if($dispo == 0){ ?>
  <table class="table table-hover">
                <tbody>
                <?php while($x = $db->recorrer($sql)){  ?>
                <tr style="background: #bdbdbd;">
                  <td colspan="6"><?php echo $x["Pregunta"]; ?></td>

                </tr>
                <?php $IdResultado = $x["IdResultado"];
                $IdPregunt = $x["IdPregunta"];
                $sql2 = $db->query("SELECT * FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdPregunta ='$IdPregunt' ");
                ?>
                  <tr>

                    <?php while($xy = $db->recorrer($sql2)){ ?><td> <button onclick="agregarRespuesta(<?php echo $IdResultado; ?>,<?php echo $IdPregunt; ?>,<?php echo $xy["IdRespuesta"]; ?>)" type="button" class="btn btn-default"><i class="fa fa-fw fa-check-circle"></i></button> <?php echo $xy["Respuesta"]; ?> </td> <?php } ?>


              <?php } ?>

              </tbody></table>
            <?php } ?>
            <h3>Calificaci&oacute;n obtenida: <?php echo $TotaOb; ?> </h3>
              <br><br>
              <h4>Avance de preguntas contestadas: <?php echo $datos51["Contestadas"]; ?> de <?php echo $datos61["Preguntas"]; ?></h4>
              <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avaPre; ?>%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>


            </form>

  <?php
}
?>

<script>
  function agregarRespuesta(IdResultado, IdPregunta, IdRespuesta){
    var IdAsignacion = document.getElementById("IdAsignacion").value;
		var IdUsua = document.getElementById("IdUsua").value;
    var IdParcial = document.getElementById("IdParcial").value;
    var IdActividadDoc = document.getElementById("IdActividadDoc").value;
	  var IdTarea = document.getElementById("IdTarea").value;
    var TipoGuardar = "savExamenRes";
    swal({
			title: "\u00BFEst\u00E1 seguro de enviar estar respuesta como correcta?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Aceptar',
			cancelButtonText: "Cancelar",
		},
    function (isConfirm) {
			if (isConfirm) {
        $(".confirm").attr('disabled', 'disabled');
        var datos = 'IdResultado=' + IdResultado + '&IdPregunta=' + IdPregunta + '&TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta;
        $.ajax({
          type:"POST",
          url:"insertar.php",
          data:datos,
          success:function(data){
          }
        }) //terminas
        .done(function(data) {
          if(data==1){
            swal("Guardado correctamente", "Respuesta guardada correctamente.", "success");
            document.getElementById("frm").reset();
            $.ajax({
    						 url:"formConsulta/viewRealizarExamen.php",
    						 method:"POST",
    						 data:{IdAsignacion:IdAsignacion,IdUsua:IdUsua,IdParcial:IdParcial,IdActividadDoc:IdActividadDoc,IdTarea:IdTarea},
    						 success:function(data){
    									$('#employee_detailExam').html(data);
    									$('#dataModalExam').modal('show');
    						 }
    				});
          }else{
            swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
          }
        })
        .error(function(data) {
          swal("Error al guardar 0x11", "No se puede guardar, comuniquese con el desarrollador.", "error");
        });
			}
		});


  }
</script>

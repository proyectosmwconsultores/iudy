<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  if(isset($_POST["IdAsignacion"])){
    $_SESSION['IdAsigX'] = $_POST["IdAsignacion"];
  }



  $IdAsignacion = $_SESSION['IdAsigX'];
  $IdActividadDoc = $_POST["IdActividadDoc"];
  $IdParcialDoc = $_POST["IdParcialDoc"];
  $IdOferta = $_POST["IdOferta"];
  echo $IdModulo = $_POST["IdModulo"];
  $IdUsua = $_SESSION["IdUsua"];

  $sql8 = $db->query("SELECT tblp_asignacion.IdCampus, tblp_modulo.Grado FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdCampus = $datos81["IdCampus"];
  $Grado = $datos81["Grado"];

  $sql_campus = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa");

  if($IdOferta){
    $sql_materias = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.NombreMod FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.Grado = '$Grado' AND tblp_modulo.IdCampus = '$IdCampus'");
  }



  $sql1 = $db->query("SELECT tblp_parcialdocente.IdModulo, tblp_parcialdocente.NoParcial FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcialDoc' ");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);

  $noParcial = $datos11["NoParcial"];

  $sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.DesActividad,
tblp_parcialdocente.IdParcialDocente
FROM
tblp_actividadesdocente
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente
WHERE
tblp_actividadesdocente.IdModulo =  '$IdModulo' AND
tblp_actividadesdocente.IdTipoActividad =  '1' AND
tblp_parcialdocente.NoParcial =  '$noParcial'
");

//
  ?>
  <section class="content">
    <form name="frm" id="frm" action="doMiPlaneacion.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAsignacion; ?>" type="hidden"/>
    <div class="row">
      <div class="form-group">
        <label for="exampleInputEmail1">Oferta educativa:</label>
        <select class="form-control" name="IdOferta" id="IdOferta" onchange="cambiarOferta(this,<?php echo $IdActividadDoc; ?>,<?php echo $IdParcialDoc; ?>)">
          <option value="1">- Seleccione oferta - </option>
        <?php while($c = $db->recorrer($sql_campus)){?>
            <option value="<?php echo $c['IdEducativa'];?>" <?php if($c['IdEducativa'] == $_POST['IdOferta']){?>selected="selected"<?php }?>><?php echo $c['Nombre'];?></option>
        <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Materias educativa:</label>
        <select class="form-control" name="IdModulo" id="IdModulo" onchange="selModulo(this,<?php echo $_POST['IdOferta']; ?>,<?php echo $IdActividadDoc; ?>,<?php echo $IdParcialDoc; ?>)">
          <option value="1">- Seleccione oferta - </option>
        <?php while($m = $db->recorrer($sql_materias)){?>
            <option value="<?php echo $m['IdModulo'];?>" <?php if($m['IdModulo'] == $_POST['IdModulo']){?>selected="selected"<?php }?>><?php echo $m['NombreMod'];?></option>
        <?php } ?>
        </select>
      </div>

      <?php while($x = $db->recorrer($sql)){ $IdParcial = $x["IdParcialDocente"];  if($IdParcialDoc <> $IdParcial) {
        $IdActividadDocNew = $x["IdActividadesDocente"];
        $sql3 = $db->query("SELECT tblp_exampregunta.Pregunta, tblp_exampregunta.Tipo FROM tblp_exampregunta WHERE tblp_exampregunta.IdParcialDocente = '$IdParcial' AND tblp_exampregunta.IdActividadesDocente = '$IdActividadDocNew' ");

        ?>

      <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-copy"></i>
              <h3 class="box-title"><?php echo $x["NomActividad"]; ?></h3>
            </div>
            <div class="box-body">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th>Pregunta</th>
                    <th>Tipo</th>
                  </tr>
                  <?php while($y = $db->recorrer($sql3)){ ?>
                <tr>
                  <td><?php echo $y["Pregunta"]; ?></td>
                  <td><?php if($y["Tipo"] == "O"){ echo "Opción multiple"; } else { echo "Abierta"; } ?></td>
                </tr>
                <?php } ?>
              </tbody></table>

            </div>

            <button onclick="copiarExamen(<?php echo $IdParcialDoc; ?>,<?php echo $IdActividadDoc; ?>,<?php echo $IdActividadDocNew; ?>)" type="button" class="btn btn-block btn-success btn-xs">Copiar examen</button>
          </div>

        </div>
      <?php } } ?>

        <?php if(!$IdParcial){ ?>


                <a class="btn btn-block btn-social btn-google">
                          <i class="fa fa-info-circle"></i> No existen parciales creados anteriormente.
                        </a>
              <?php } ?>
    </div>
  </form>



      </section>
<script>
function cambiarOferta(IdOfertaX,IdActividadDoc,IdParcialDoc){
    var IdOferta = IdOfertaX.value;

    $.ajax({
  			 url:"formConsulta/viewCopiarExt.php",
  			 method:"POST",
  			 data:{IdActividadDoc:IdActividadDoc,IdParcialDoc:IdParcialDoc,IdOferta:IdOferta},
  			 success:function(data){
  						$('#employee_detailViewPc').html(data);
  						$('#dataModalViewPc').modal('show');
  			 }
  	});
  }

  function selModulo(IdModuloX,IdOferta,IdActividadDoc,IdParcialDoc){
      var IdModulo = IdModuloX.value;

      $.ajax({
    			 url:"formConsulta/viewCopiarExt.php",
    			 method:"POST",
    			 data:{IdActividadDoc:IdActividadDoc,IdParcialDoc:IdParcialDoc,IdOferta:IdOferta, IdModulo:IdModulo},
    			 success:function(data){
    						$('#employee_detailViewPc').html(data);
    						$('#dataModalViewPc').modal('show');
    			 }
    	});
    }
</script>

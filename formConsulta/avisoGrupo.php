<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdUsua = $_SESSION['IdUsua'];
  $IdAviso = $_POST["IdAviso"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];

$sql1 = $db->query("SELECT tblp_coordinador.IdCampus, tblc_campus.Campus FROM tblp_coordinador Left Join tblc_campus ON tblc_campus.IdCampus = tblp_coordinador.IdCampus WHERE tblp_coordinador.IdUsua =  '$IdUsua' GROUP BY tblp_coordinador.IdCampus");


  $sqlx = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa");

  $sql2 = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.IdOferta = '$IdOferta' AND ((tblp_grupo.IdEstatus = '8') || (tblp_grupo.IdEstatus = '12')) ORDER BY tblp_grupo.Nivel ASC");

  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>


    <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none; margin-top: -5px;">

        <div class="col-md-12">
          <div class="form-group">
            <label>Campus:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <select class="form-control select2" name="txtCampus" id="txtCampus" onchange="cambioCampus(<?php echo $IdAviso; ?>)" style="width: 100%;">
                <option value=""> - Seleccione - </option>
                <?php while($y2 = $db->recorrer($sql1)){ ?>
                <option class="form-control"  value="<?php echo $y2["IdCampus"]; ?>"  <?php if($IdCampus==$y2["IdCampus"]){?>selected="selected"<?php }?>> <?php echo $y2["Campus"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Oferta educativa:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <select class="form-control select2" name="txtOferta" id="txtOferta" onchange="cambioOferta(<?php echo $IdAviso; ?>)" style="width: 100%;">
                <option value=""> - Seleccione - </option>
                <?php while($yx = $db->recorrer($sqlx)){ ?>
                <option class="form-control"  value="<?php echo $yx["IdEducativa"]; ?>"  <?php if($IdOferta==$yx["IdEducativa"]){?>selected="selected"<?php }?>> <?php echo $yx["Nombre"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row">
            <?php while($x2 = $db->recorrer($sql2)){
              $IdG = $x2["IdGrupo"];

              $sqle3 = $db->query("SELECT tblc_avisodetalle.IdAvisoD FROM tblc_avisodetalle WHERE tblc_avisodetalle.IdGrupo = '$IdG' AND tblc_avisodetalle.IdAviso = '$IdAviso'");
              $db->rows($sqle3);
              $datose31 = $db->recorrer($sqle3);
              $IdAvss = $datose31['IdAvisoD'];
               ?>
            <div class="col-sm-4 col-md-4">
              <div class="color-palette-set" style="padding: 10px; ">
                <?php if($IdAvss){ ?>
                  <button type="button" onclick="actGrupo(<?php echo $IdG; ?>,<?php echo $IdAviso; ?>,0)" class="btn btn-info"><i class="fa fa-times-circle"></i></button>
                <?php } else { ?>
                  <button type="button" onclick="actGrupo(<?php echo $IdG; ?>,<?php echo $IdAviso; ?>,1)" class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
                <?php } ?>

                <?php echo $x2["CveGrupo"]; ?>
              </div>
            </div>
          <?php } ?>
        </div><br>
          <div class="form-group">
              <button type="button" class="btn btn-block btn-success" onclick="pubAviso(<?php echo $IdAviso; ?>)"> <i class="fa fa-fw fa-check-circle"></i> Publicar aviso en todos los grupos</button>
          </div>
        </div>


      </div>

    </table>
  </div>

  </form>
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>

<script>
$(function () {

  $('.select2').select2()

})


function cambioOferta(IdAviso){
  var IdCampus = document.getElementById("txtCampus").value;
  var IdOferta = document.getElementById("txtOferta").value;
	$.ajax({
			 url:"formConsulta/avisoGrupo.php",
			 method:"POST",
			 data:{IdAviso:IdAviso,IdCampus:IdCampus,IdOferta:IdOferta},
			 success:function(data){
						$('#employee_Grp').html(data);
						$('#dataGrp').modal('show');
			 }
	});
}

function cambioCampus(IdAviso){
  var IdCampus = document.getElementById("txtCampus").value;
  var IdOferta = document.getElementById("txtOferta").value;
	$.ajax({
			 url:"formConsulta/avisoGrupo.php",
			 method:"POST",
			 data:{IdAviso:IdAviso,IdCampus:IdCampus,IdOferta:IdOferta},
			 success:function(data){
						$('#employee_Grp').html(data);
						$('#dataGrp').modal('show');
			 }
	});
}

function pubAviso(IdAviso){
  var IdCampus = document.getElementById("txtCampus").value;
  var IdOferta = document.getElementById("txtOferta").value;

    if (IdCampus ==""){
        swal("Error al guardar", "Debe seleccionar el campus.", "error");
        return 0;
    }
    if (IdOferta ==""){
        swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
        return 0;
    }

    var TipoGuardar = "savPubAvisoT";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea publicar el aviso en todos estos grupos?",
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
             data:{TipoGuardar:TipoGuardar, IdAviso:IdAviso, IdCampus:IdCampus, IdOferta:IdOferta},
             success:function(data){
               $.ajax({
             			 url:"formConsulta/avisoGrupo.php",
             			 method:"POST",
             			 data:{IdAviso:IdAviso,IdCampus:IdCampus,IdOferta:IdOferta},
             			 success:function(data){
             						$('#employee_Grp').html(data);
             						$('#dataGrp').modal('show');
             			 }
             	});

             }
        })
      }
    });

}

function actGrupo(IdGrupo,IdAviso,Valor){
  var IdCampus = document.getElementById("txtCampus").value;
  var IdOferta = document.getElementById("txtOferta").value;
  var TipoGuardar = "savGrupoAv";

  $.ajax({
       url:"formConsulta/setting.php",
       method:"POST",
       data:{TipoGuardar:TipoGuardar, IdGrupo:IdGrupo, IdAviso:IdAviso, Valor:Valor},
       success:function(data){
         $.ajax({
             url:"formConsulta/avisoGrupo.php",
             method:"POST",
             data:{IdAviso:IdAviso,IdCampus:IdCampus,IdOferta:IdOferta},
             success:function(data){
                  $('#employee_Grp').html(data);
                  $('#dataGrp').modal('show');
             }
        });
       }
  })
}

</script>

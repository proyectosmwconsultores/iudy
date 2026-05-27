<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdGrupo = $_POST["IdGrupo"];
  $IdPlan = $_POST["IdPlan"];
  $IdUsua = $_POST["IdUsua"];
  $Descuento = $_POST["Descuento"];


  $sql_grupo = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_educativa.Nombre, tblc_ciclo.Ciclo FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_grupo.IdCicloIni WHERE tblp_grupo.IdEstatus =  '12' AND tblp_educativa.IdGrado =  '8' ORDER BY tblc_ciclo.FInicio DESC");

  $sql7 = $db->query("SELECT tblp_grupo.IdCicloIni FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql7);
  $datos71 = $db->recorrer($sql7);
  $IdCiclo = $datos71["IdCicloIni"];

  $sql_plan = $db->query("SELECT tblp_calendario.IdCalendario, tblp_calendario.Monto, tblc_conceptosplanes.NomPlan FROM tblp_calendario Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes WHERE tblp_calendario.IdGrado =  '8' AND tblp_calendario.IdCiclo =  '$IdCiclo'");
  $nombre = '';
  if($IdUsua){
    $sql_us = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql_us);
    $_us = $db->recorrer($sql_us);
    $nombre = $_us["Nombre"].' '.$_us["APaterno"].' '.$_us["AMaterno"];
  }



  ?>
  <script>
  function showUserBuscar2(str) {
      if (str == "") {
          document.getElementById("txtHint").innerHTML = "";
          return;
      } else {

          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("txtHint").innerHTML = this.responseText;
              }
          };
          xmlhttp.open("GET","getuser.php?Tipo=usuario_plataform&Buscar="+str,true);
          xmlhttp.send();
      }
  }

  </script>
  <form name="frm2xfYj" id="frm2xfYj" action="usuario_plataforma.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" id="IdUsua2" name="IdUsua2" value="<?php echo $IdUsua ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Grupo:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <select class="form-control select2" name="txtGrupo2" id="txtGrupo2" onchange="cambiar_grupo()">
                  <option value=""> - Seleccione - </option>
                  <?php while($_grupo = $db->recorrer($sql_grupo)){ ?>
                  <option value="<?php echo $_grupo["IdGrupo"]; ?>" <?php if($IdGrupo==$_grupo["IdGrupo"]){?>selected="selected"<?php }?>><?php  echo $_grupo["CveGrupo"]; ?> - <?php  echo $_grupo["Nombre"]; ?> - <?php  echo $_grupo["Ciclo"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="form-group">
              <label>Plan de pago:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <select class="form-control select2" name="txtPlan2" id="txtPlan2">
                  <option value=""> - Seleccione - </option>
                  <?php while($_plan = $db->recorrer($sql_plan)){ ?>
                  <option value="<?php echo $_plan["IdCalendario"]; ?>" <?php if($IdPlan==$_plan["IdCalendario"]){?>selected="selected"<?php }?>><?php  echo $_plan["NomPlan"]; ?> / ($ <?php  echo $_plan["Monto"]; ?>)</option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Descuento:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-tags"></i>
                </div>
                <input type="text" name="txtDescuento2" id="txtDescuento2" value="<?php echo $Descuento; ?>" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Buscar nombre del usuario:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-user"></i>
                </div>
                <input class="form-control" id="txtBuscar2" name="txtBuscar2" placeholder="Escriba los datos del alumno" value="<?php echo $nombre; ?>" type="text" onKeyUp="showUserBuscar2(this.value)">
              </div>
              <div class="box-body no-padding">
                <div id="txtHint"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="sav_pago_curx()"> <i class="fa fa-fw fa-save"></i> Guardar usuario al curso</button>
        </div>
      </div>
    </table>
  </div>
  <br>

  </form>
<script>


  function sav_pago_curx(){
    var IdGrupo = document.getElementById("txtGrupo2").value;
    var IdPlan = document.getElementById("txtPlan2").value;
    var Descuento = document.getElementById("txtDescuento2").value;
    var IdUsua = document.getElementById("IdUsua2").value;

    if (IdGrupo ==""){
        swal("Error al guardar", "Debe seleccionar el grupo.", "error");
        document.getElementById("txtGrupo2").focus();
        return 0;
    }
    if (IdPlan ==""){
        swal("Error al guardar", "Debe seleccionar el plan de pago.", "error");
        document.getElementById("txtPlan2").focus();
        return 0;
    }
    if (Descuento ==""){
        swal("Error al guardar", "Debe escribir el descuento.", "error");
        document.getElementById("txtDescuento2").focus();
        return 0;
    }
    if (IdUsua ==""){
        swal("Error al guardar", "Debe buscar el nombre del usuario en la Plataforma.", "error");

        return 0;
    }

    var TipoGuardar = "sav_pcursox";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar este usuario al curso y cargarle este nuevo pago?",
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
             data:{TipoGuardar:TipoGuardar, IdGrupo:IdGrupo, IdPlan:IdPlan, Descuento:Descuento, IdUsua:IdUsua},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Guardado correctamente", "El usuario se ha agregado correctamente al grupo y se le ha generado el pago correspondiente.", "success");
            var IdGrupo = document.getElementById("txtGrupo2").value;
            var IdPlan = document.getElementById("txtPlan2").value;
            cargar_listax_usId(IdGrupo,IdPlan);

            var Descuento = 0;
            var IdUsua = 0;
            $.ajax({
                 url:"formConsulta/usuario_plataforma.php",
                 method:"POST",
                 data:{IdGrupo:IdGrupo,IdPlan:IdPlan, IdUsua:IdUsua, Descuento:Descuento},
                 success:function(data){
                      $('#employee_detail3').html(data);
                      $('#dataModal3').modal('show');
                 }
            })
  				}
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }

  function recibe_user_id(IdUsua){
    var IdGrupo = document.getElementById("txtGrupo2").value;
    var IdPlan = document.getElementById("txtPlan2").value;
    var Descuento = document.getElementById("txtDescuento2").value;
    $.ajax({
         url:"formConsulta/usuario_plataforma.php",
         method:"POST",
         data:{IdGrupo:IdGrupo,IdPlan:IdPlan, IdUsua:IdUsua, Descuento:Descuento},
         success:function(data){
              $('#employee_detail3').html(data);
              $('#dataModal3').modal('show');
         }
    });
  }

  function cambiar_grupo(){
    var IdGrupo = document.getElementById("txtGrupo2").value;
    var IdPlan = document.getElementById("txtPlan2").value;
    var Descuento = document.getElementById("txtDescuento2").value;
    var IdUsua = document.getElementById("IdUsua2").value;
    $.ajax({
         url:"formConsulta/usuario_plataforma.php",
         method:"POST",
         data:{IdGrupo:IdGrupo,IdPlan:IdPlan, IdUsua:IdUsua, Descuento:Descuento},
         success:function(data){
              $('#employee_detail3').html(data);
              $('#dataModal3').modal('show');
         }
    });
  }

  
</script>

<?php session_start();
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdGrupo = $_POST["employee_id"];
  $_IdUs = $_SESSION['IdUsua'];
  $porciones = explode("-", $_POST["employee_id"]);
  $IdOferta = $porciones[0]; // porción1
  $IdGrado = $porciones[1]; // porción2
  $Usuario = $porciones[2]; // porción2
  $IdUsua = $porciones[3]; // porción2
  $Tipo = $porciones[4]; // porción2
  if($Tipo == 'Semestre'){ $Tipo = 'SEMESTRE'; } else { $Tipo = 'CUATRIMESTRE'; }

  $sql9 = $db->query("SELECT tblp_calificacion.IdCiclo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.Usuario = '$Usuario' AND tblp_modulo.Grado = '$IdGrado'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  $sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.Promedio, tblp_calificacion.E1, tblp_calificacion.E2, tblp_modulo.NombreMod, tblp_modulo.Grado, tblp_modulo.CodeModulo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.Usuario =  '$Usuario' AND tblp_calificacion.IdOferta =  '$IdOferta' AND tblp_modulo.Grado =  '$IdGrado' ORDER BY tblp_modulo.NombreMod ASC");

  $sql2 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$Tipo' ORDER BY tblc_ciclo.FInicio ASC");

  $sql25 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$_IdUs' AND tblc_modulousuario.IdModulo = '25'");
  $db->rows($sql25);
  $datos_25 = $db->recorrer($sql25);
  $_25 = $datos_25['IdModUsua'];

  $sql26 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$_IdUs' AND tblc_modulousuario.IdModulo = '26'");
  $db->rows($sql26);
  $datos_26 = $db->recorrer($sql26);
  $_26 = $datos_26['IdModUsua'];
  ?>
  <form name="frm22" id="frm22" action="updCalificacion.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
              <div class="box-body">
                <table class="table table-striped">
                <tbody><tr>
                  <th>Materia</th>
                  <th style="text-align: center;">Promedio</th>
                  <th style="text-align: center;">Extra 1</th>
                  <th style="text-align: center;">Extra 2</th>
                </tr>
                <?php   while($x = $db->recorrer($sql)){ ?>
                <tr>
                  <td><?php echo $x["CodeModulo"].' '.$x["NombreMod"]; ?></td>
                  <td>
                    <div class="input-group input-group-sm">
                      <input type="text" id="txtCalPromedio<?php echo $x["IdCalificacion"]; ?>" name="txtCalPromedio<?php echo $x["IdCalificacion"]; ?>" class="form-control" value="<?php echo $x["Promedio"]; ?>">
                      <?php if(isset($_25)){ ?>
                      <span class="input-group-btn">
                        <button onclick="saveCall(<?php echo $x["IdCalificacion"]; ?>,'Promedio')" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-save"></i></button>
                      </span><?php } ?>
                    </div>
                  </td>
                  <td>
                    <div class="input-group input-group-sm">
                      <input type="text" id="txtCalE1<?php echo $x["IdCalificacion"]; ?>" name="txtCalE1<?php echo $x["IdCalificacion"]; ?>" class="form-control" value="<?php echo $x["E1"]; ?>">
                      <?php if(isset($_25)){ ?>
                      <span class="input-group-btn">
                        <button onclick="saveCall(<?php echo $x["IdCalificacion"]; ?>,'E1')" type="button" class="btn btn-success btn-flat"><i class="fa fa-fw fa-save"></i></button>
                      </span><?php } ?>
                    </div>
                  </td>
                  <td>
                    <div class="input-group input-group-sm">
                      <input type="text" id="txtCalE2<?php echo $x["IdCalificacion"]; ?>" name="txtCalE2<?php echo $x["IdCalificacion"]; ?>" class="form-control" value="<?php echo $x["E2"]; ?>">
                      <?php if(isset($_25)){ ?>
                      <span class="input-group-btn">
                        <button onclick="saveCall(<?php echo $x["IdCalificacion"]; ?>,'E2')" type="button" class="btn btn-danger btn-flat"><i class="fa fa-fw fa-save"></i></button>
                      </span><?php } ?>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody></table>
              <hr>
                <div class="form-group">
                  <label style="text-align: left;" class="col-sm-4 control-label">Ciclo escolar:</label>
                  <div class="col-sm-8">
                    <div class="input-group input-group-sm">
                      <select class="form-control" name="txtCicloX" id="txtCicloX">
                      <option value=""> - Seleccione - </option>
                      <?php   while($x = $db->recorrer($sql2)){ ?>
                      <option value="<?php echo $x["IdCiclo"]; ?>"<?php if($datos91["IdCiclo"]==$x["IdCiclo"]){?>selected="selected"<?php }?>><?php echo $x["Ciclo"]; ?></option>
                      <?php }  ?>
                      </select>
                      <?php if(isset($_26)){ ?>
                      <span class="input-group-btn">
                        <button onclick="saveCiclo(<?php echo $IdGrado; ?>, <?php echo $Usuario; ?>,<?php echo $IdOferta; ?>)" type="button" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i> Guardar</button>
                      </span><?php } ?>
                    </div>
                  </div>
                </div><br>
                <div class="box-footer">
                <button onClick="window.open('adCalificacion.php?tokenId=1592526540<?php echo $IdUsua; ?>&Envio=C','_self')" href="javascript:void(0);"  type="button" class="btn btn-danger pull-right"> <i class="fa fa-times-circle"></i> Salir</button>
              </div>
              </div>
        </form>

<script>
  function saveCall(IdCalificacion,Tipo){
    var TxtCal = "txtCal"+Tipo+IdCalificacion;
    var Cal = document.getElementById(TxtCal).value;
    var TipoGuardar = "addSaveCal";
    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdCalificacion:IdCalificacion, Cal:Cal, Tipo:Tipo},
         success:function(data){
         }
    })
  }

  function saveCiclo(IdGrado, Usuario, IdOferta){
    var Ciclo = document.getElementById("txtCicloX").value;
    var TipoGuardar = "addSaveCicl";
    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdGrado:IdGrado, Usuario:Usuario,IdOferta:IdOferta,Ciclo:Ciclo},
         success:function(data){
           swal("Guardado correctamente", "El ciclo fue guardado correctamente.", "success");
         }
    })
  }
</script>
<?php } ?>

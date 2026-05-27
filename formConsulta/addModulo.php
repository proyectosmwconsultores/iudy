<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$st = $_POST['Tipo'];
$sql_us = $db->query("SELECT * FROM tblx_modulo WHERE tblx_modulo.IdTipoEva = '$st'");
$sql_mod = $db->query("SELECT * FROM tblx_modulo WHERE tblx_modulo.IdTipoEva = '$st'");

$sql_bloq = $db->query("SELECT tblx_modulo.IdMod, tblx_modulo.Nombre_mod, tblx_bloque.Bloque FROM tblx_modulo Left Join tblx_bloque ON tblx_bloque.IdMod = tblx_modulo.IdMod WHERE tblx_modulo.IdTipoEva = '$st' ORDER BY tblx_modulo.IdMod ASC");


  ?>
  <form name="frm2sFr" id="frm2sFr" action="updFuente.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="TipoGuardar" id="TipoGuardar" value="addPreguts">
    <input type="hidden" name="Tipo" id="Tipo" value="<?php echo $_POST['Tipo']; ?>">

  <div class="table-responsive">
    <div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> Módulos que contiene la evaluación</span></div>
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Escriba el nombre del módulo:</label>
              <input name="txtMod" id="txtMod" class="form-control">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="add_mod_enc()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>


      <table class="table table-striped">
      <tbody>
        <tr>
          <th style="width: 10px">#</th>
          <th>Nombre del módulo</th>
        </tr>
        <?php $c = 0; while($x = $db->recorrer($sql_us)){ ?>
        <tr>
          <td><b><?php echo $c = ($c + 1); ?>.- </b></td>
          <td><?php echo $x['Nombre_mod']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <hr>
    <!-- <div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> Bloques del módulo</span></div> -->
    <!-- <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Seleccione el módulo:</label>
              <select name="txt_mod" id="txt_mod" class="form-control">
                <option value="">- Seleccione - </option>
                <?php while($mod = $db->recorrer($sql_mod)){ ?>
                <option value="<?php echo $mod['IdMod']; ?>"><?php echo $mod['Nombre_mod']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Escriba el nombre del bloque:</label>
              <input name="txtBloq" id="txtBloq" class="form-control">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="add_bloq_enc()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table> -->
    <!-- <table class="table table-striped">
    <tbody>
      <tr>
        <th style="width: 10px">#</th>
        <th>Nombre del módulo</th>
        <th>Nombre del bloque</th>
      </tr>
      <?php $h = 0; while($b = $db->recorrer($sql_bloq)){ ?>
      <tr>
        <td><b><?php echo $h = ($h + 1); ?>.- </b></td>
        <td><?php echo $b['Nombre_mod']; ?></td>
        <td><?php echo $b['Bloque']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table> -->

  </div>

  </form>

<script>
  function add_mod_enc(){
    var Mod = document.getElementById("txtMod").value;
    var Tipo = document.getElementById("Tipo").value;
    var TipoGuardar = 'sav_mod_enc';

  	if (Mod ==''){
  			swal("Error al guardar", "Debe escribir el nombre del módulo.", "error");
  			document.getElementById("txtMod").focus();
  			return 0;
  	}

  	swal({
  		title: "\u00BFEst\u00E1 seguro que desea agregar este módulo?",
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
             data:{TipoGuardar:TipoGuardar, Mod:Mod, Tipo:Tipo},
             success:function(data){

             }
        })
  			.done(function(data) {
          if(data==1){
  					swal("Guardado correctamente", "Los datos se han guardado correctamente.", "success");
            $.ajax({
                 url:"formConsulta/addModulo.php",
                 method:"POST",
                 data:{Tipo:Tipo},
                 success:function(data){
                      $('#employee_mod').html(data);
                      $('#dataModalM').modal('show');
                 }
            });
  				}
  				if(data==0){
  					swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
  				}
  			})
  			.error(function(data) {
  				swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
  			});
  		}

  	});
  }

  function add_bloq_enc(){
    var IdMod = document.getElementById("txt_mod").value;
    var Bloq = document.getElementById("txtBloq").value;
    var Tipo = document.getElementById("Tipo").value;

    var TipoGuardar = 'sav_bloq_enc';

  	if (IdMod ==''){
  			swal("Error al guardar", "Debe seleccionar el módulo.", "error");
  			document.getElementById("txt_mod").focus();
  			return 0;
  	}
    if (Bloq ==''){
  			swal("Error al guardar", "Debe escribir el nombre del bloque.", "error");
  			document.getElementById("txt_mod").focus();
  			return 0;
  	}

  	swal({
  		title: "\u00BFEst\u00E1 seguro que desea agregar este bloque?",
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
             data:{TipoGuardar:TipoGuardar, IdMod:IdMod, Tipo:Tipo, Bloq:Bloq},
             success:function(data){

             }
        })
  			.done(function(data) {
          if(data==1){
  					swal("Guardado correctamente", "Los datos se han guardado correctamente.", "success");
            $.ajax({
                 url:"formConsulta/addModulo.php",
                 method:"POST",
                 data:{Tipo:Tipo},
                 success:function(data){
                      $('#employee_mod').html(data);
                      $('#dataModalM').modal('show');
                 }
            });
  				}
  				if(data==0){
  					swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
  				}
  			})
  			.error(function(data) {
  				swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
  			});
  		}

  	});
  }
</script>

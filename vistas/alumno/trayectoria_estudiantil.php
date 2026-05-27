<?php
session_start();
include('../../hace.php');
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdUsua = $_POST["IdUsua"];
$idUser = $_SESSION['IdUsua'];
$IdTrayectoria = $_POST["IdTrayectoria"];

$sql_pag = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus =  '1' ");
$db->rows($sql_pag);
$_pag = $db->recorrer($sql_pag);

$sql_78 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua =  '$idUser' AND tblc_modulousuario.IdModulo = '78' ");
$db->rows($sql_78);
$mod78 = $db->recorrer($sql_78);

$sql_us = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
$db->rows($sql_us);
$_us = $db->recorrer($sql_us);
$grad = $_us['Grado'];

$sql_tray = $db->query("SELECT * FROM tblc_trayectoria WHERE tblc_trayectoria.IdGrado = '" . $_us['Grado'] . "' ORDER BY tblc_trayectoria.Orden ASC");

$trayectoria = $db->query("SELECT
tblp_trayectoria_alumno.IdTrayectoria,
tblp_trayectoria_alumno.IdUsua,
tblp_trayectoria_alumno.Fecha,
tblp_trayectoria_alumno.Archivo,
tblp_trayectoria_alumno.IdEstatus,
tblp_trayectoria_alumno.Nota,
tblp_trayectoria_alumno.FecCap,
tblp_trayectoria_alumno.Anio,
tblp_trayectoria_alumno.Mes,
tblc_trayectoria.Trayectoria,
tblc_trayectoria.Tipo,
tblc_estatus.Estatus,
Estatus.Estatus AS EstatusActual
FROM
tblp_trayectoria_alumno
Left Join tblc_trayectoria ON tblc_trayectoria.IdTipoTrayectoria = tblp_trayectoria_alumno.IdTipo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_trayectoria_alumno.IdEstatus
Left Join tblc_estatus AS Estatus ON Estatus.IdEstatus = tblc_trayectoria.Tipo
WHERE
tblp_trayectoria_alumno.IdUsua =  '$IdUsua'
ORDER BY
tblc_trayectoria.Orden ASC");
?>
<div class="box-body">
  <form class="form-horizontal">
    <?php if ($IdTrayectoria == 0) { ?>
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-4 control-label">Nombre del seguimiento:</label>
          <div class="col-sm-8">
            <select name="txt_tipoTrayectoria" id="txt_tipoTrayectoria" class="form-control">
              <option value="">- Seleccione - </option>
              <?php $dispo = 0; while ($_tra = $db->recorrer($sql_tray)) {
                $sql_seg = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdUsua = '$IdUsua' AND tblp_trayectoria_alumno.IdTipo = '".$_tra['IdTipoTrayectoria']."' ");
                $db->rows($sql_seg);
                $_seg = $db->recorrer($sql_seg);
                if((!isset($_seg['IdTrayectoria'])) && ($dispo == 0)){ $dispo = 1;
                ?>
                <option value="<?php echo $_tra['IdTipoTrayectoria']; ?>"><?php echo $_tra['Trayectoria']; ?></option>
              <?php } } ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-6 control-label">Fecha:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="txt_fecha" name="txt_fecha">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-6 control-label">Estatus:</label>
          <div class="col-sm-6">
            <select name="txt_estatus" id="txt_estatus" class="form-control">
              <option value=""> - Seleccione -</option>
              <option value="10"> COMPLETADO </option>
              <option value="12"> EN PROCESO </option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-6 control-label">Evidencia:</label>
          <div class="col-sm-6">
            <input type="file" class="form-control" name="txtArchivo" id="txtArchivo">
          </div>
        </div>
        <div class="form-group">
          <label>Comentario:</label>
          <textarea class="form-control" name="txt_comentario_tra" id="txt_comentario_tra" rows="2" placeholder="Enter ..."></textarea>
        </div>
      </div>
      <div class="box-footer">
        <?php if((isset($_pag['IdPago'])) && (isset($mod78['IdModUsua']))){ ?>
        <button onclick="eliminar_pagos(<?php echo $IdUsua; ?>)" type="button" class="btn bg-orange btn-flat pull-left"><i class="fa fa-trash"></i> Eliminar pagos pendientes</button>
        <?php } ?>
        <button onclick="save_trayectoria(<?php echo $IdUsua; ?>)" type="button" class="btn bg-navy btn-flat pull-right"><i class="fa fa-save"></i> Guardar</button>
      </div><br>
    <?php } ?>
    <?php if ($IdTrayectoria <> 0) {
      $sql_tra = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdTrayectoria = '$IdTrayectoria' ");
      $db->rows($sql_tra);
      $_tray = $db->recorrer($sql_tra);
    ?>
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-4 control-label">Nombre del seguimiento:</label>
          <div class="col-sm-8">
            <select name="txt_tipoTrayectoria_2" id="txt_tipoTrayectoria_2" class="form-control" disabled>
              <option value="">- Seleccione - </option>
              <?php while ($_tra = $db->recorrer($sql_tray)) { ?>
                <option value="<?php echo $_tra['IdTipoTrayectoria']; ?>" <?php if ($_tray["IdTipo"] == $_tra['IdTipoTrayectoria']) { ?>selected="selected" <?php } ?>><?php echo $_tra['Trayectoria']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-6 control-label">Fecha:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="txt_fecha_2" name="txt_fecha_2" value="<?php echo $_tray['Fecha']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-6 control-label">Estatus:</label>
          <div class="col-sm-6">
            <select name="txt_estatus_2" id="txt_estatus_2" class="form-control">
              <option value=""> - Seleccione -</option>
              <option value="10" <?php if ($_tray["IdEstatus"] == 10) { ?>selected="selected" <?php } ?>> COMPLETADO </option>
              <option value="12" <?php if ($_tray["IdEstatus"] == 12) { ?>selected="selected" <?php } ?>> EN PROCESO </option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-6 control-label">Evidencia:</label>
          <div class="col-sm-6">
            <input type="file" class="form-control" name="txtArchivo_2" id="txtArchivo_2">
          </div>
        </div>
        <div class="form-group">
          <label>Comentario:</label>
          <textarea class="form-control" name="txt_comentario_tra_2" id="txt_comentario_tra_2" rows="2" placeholder="Enter ..."><?php echo $_tray['Nota']; ?></textarea>
        </div>
      </div>
      <div class="box-footer">
        <button onclick="upd_trayectoria_id(<?php echo $IdUsua . ',' . $IdTrayectoria; ?>,<?php echo $_tray["IdTipo"]; ?>)" type="button" class="btn bg-maroon btn-flat pull-right"><i class="fa fa-refresh"></i> Actualizar</button>
      </div>
    <?php } ?>

  </form>
  <?php $xv = 0; $sx = 0; if ($IdTrayectoria == 0) {  ?>
    <ul class="timeline timeline-inverse">
      <?php $ei = 0; $ef = 0; while ($trayec = $db->recorrer($trayectoria)) { $ei = $trayec['Tipo']; $sx = ($sx + 1);
        if($trayec['Tipo'] == 61){ $color = "green"; }
        if($trayec['Tipo'] == 62){ $color = "yellow"; }
        if($trayec['Tipo'] == 55){ $color = "blue"; }

        $textc = $trayec['EstatusActual'];

        if(($sx == 1) && ($grad == 3) && ($trayec['EstatusActual'] == 'EGRESADO')){
          if($_us['IdEstatus'] == 8){
            $textc = "SIGUE ESTUDIANDO";
            $xv = 1;
          } else {
            $textc = "ALUMNO NO ACTIVO";
          }
          $color = "red"; 
        } else {
          $textc = $trayec['EstatusActual'];
        }
        
        if($ei <> $ef){
        ?>
        <li class="time-label">
          <span class="bg-<?php echo $color; ?>">
          <i class="fa fa-fw fa-graduation-cap"></i> <?php if($xv == 1){ echo $textc; } else { echo $textc; } ?>
          </span>
        </li><?php } ?>
        <li>
          <i class="fa fa-check bg-success"></i>
          <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($trayec['FecCap']); ?></span>
            <h3 class="timeline-header"><a href="#"><?php echo $trayec['Trayectoria']; ?></a> (<?php echo ucfirst(strtolower($trayec['Estatus'])); ?>)</h3>
            <div class="timeline-body">
              <?php echo $trayec['Nota']; ?>
            </div>
            <div class="timeline-footer">
              <?php if ($trayec['Archivo']) {; ?>
                <a onclick="window.open('assets/docs/files/<?php echo $trayec['Anio']; ?>/<?php echo $trayec['Mes']; ?>/<?php echo $trayec['Archivo']; ?>','_blank')" class="btn btn-warning btn-flat btn-xs"><i class="fa fa-fw fa-share-alt"></i> Evidencia</a><?php } ?>
              <a onclick="modificar_trayectoria(<?php echo $IdUsua . ',' . $trayec['IdTrayectoria']; ?>)" class="btn btn-primary btn-flat btn-xs pull-right"><i class="fa fa-edit"></i> Actualizar datos</a>
              <a onclick="window.open('assets/docs/files/<?php echo $trayec['Anio']; ?>/<?php echo $trayec['Mes']; ?>/<?php echo $trayec['Archivo']; ?>','_blank')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-fw fa-calendar"></i> <?php echo obtenerFechaCorta($trayec['Fecha']); ?></a>
            </div>
          </div>
        </li><?php  $ef = $trayec['Tipo']; } ?>
      <li>
        <i class="fa fa-clock-o bg-gray"></i>
      </li>
    </ul>
  <?php } ?>
</div>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function() {
    $('#txt_fecha').datepicker({
      autoclose: true
    })
    $('#txt_fecha_2').datepicker({
      autoclose: true
    })
  })


  function save_trayectoria(IdUsua) {
    var IdTipo = document.getElementById("txt_tipoTrayectoria").value;
    var Fecha = document.getElementById("txt_fecha").value;
    var IdEstatus = document.getElementById("txt_estatus").value;
    var Archivo = document.getElementById("txtArchivo").value;
    var Comentario = document.getElementById("txt_comentario_tra").value;
    var Imagen = '#txtArchivo';

    if (IdTipo == "") {
      swal("Error al guardar", "Debe seleccionar el tipo de seguimiento.", "error");
      return 0;
    }
    if (Fecha == "") {
      swal("Error al guardar", "Debe seleccionar la fecha.", "error");
      return 0;
    }
    if (IdEstatus == "") {
      swal("Error al guardar", "Debe seleccionar el estatus en el que se encuentra el documento.", "error");
      return 0;
    }

    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar este seguimiento de este alumno?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');

          var formData = new FormData();
          var files = $(Imagen)[0].files[0];
          formData.append('IdUsua', IdUsua);
          formData.append('IdTipo', IdTipo);
          formData.append('Fecha', Fecha);
          formData.append('IdEstatus', IdEstatus);

          formData.append('Comentario', Comentario);

          formData.append('file', files);

          $.ajax({
              url: 'upload_trayectoria_alumno.php',
              type: 'post',
              data: formData, 
              contentType: false,
              processData: false,
              success: function(response) {
              }
            })
            .done(function(response) {
              if (response == 1) {
                swal("Guardado correctamente", "El seguimiento al alumno se ha guardado correctamente.", "success");
                var IdTrayectoria = 0;
                $.ajax({
                  url: "vistas/alumno/trayectoria_estudiantil.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdTrayectoria: IdTrayectoria
                  },
                  success: function(data) {
                    $('#employee_detailTray').html(data);
                    $('#dataModalTray').modal('show');
                  }
                });
              } else if (response == 2) {
                swal("Error al guardar", "Los datos ingresados ya existen en la trayectoria del alumno(a).", "error");
                var IdTrayectoria = 0;
                $.ajax({
                  url: "vistas/alumno/trayectoria_estudiantil.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdTrayectoria: IdTrayectoria
                  },
                  success: function(data) {
                    $('#employee_detailTray').html(data);
                    $('#dataModalTray').modal('show');
                  }
                });
              } else if (response == 3) {
                swal("Error al guardar", "Los la evidencia no se pudo subir.", "error");
                var IdTrayectoria = 0;
                $.ajax({
                  url: "vistas/alumno/trayectoria_estudiantil.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdTrayectoria: IdTrayectoria
                  },
                  success: function(data) {
                    $('#employee_detailTray').html(data);
                    $('#dataModalTray').modal('show');
                  }
                });
              } else {
                swal("Error al guardar", "No se puede guardar los datos.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });


        }
      });

  }

  function eliminar_pagos(IdUsua) {
			var TipoGuardar = 'eliminar_pagos_anteriores';


			swal({
					title: "\u00BFEst\u00E1 seguro que desea eliminar los pagos activos de este alumno?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',
				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
							type: "POST",
							url: "vistas/admin/guardar_datos.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua
							},
							success: function(data) {
                parent.location.href='perfil.php?token=1690469607'+IdUsua;

							}
              
              
						})
					}

				});
		}

    function marcar_graduado(IdUsua) {
      var TipoGuardar = 'sav_estatus_alumno';

      swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar el estatus de ACTIVO a -> GRADUADO este alumno?",
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
            url: "vistas/admin/guardar_datos.php",
                method:"POST",
                data: {
                  TipoGuardar: TipoGuardar,
                  IdUsua: IdUsua
                },
                success:function(data){ //alert(data);

                }
           })
          .done(function(data) {
            var Valor1 = '';
            Valor1 = data;
            

            if(Valor1==1){

              swal({
              title: "El estatus del alumno se ha guardado correctamente.",
          		type: "success",
          		showCancelButton: false,
          		confirmButtonColor: '#DD6B55',
          		confirmButtonText: 'Aceptar',
          		//cancelButtonText: "Cancelar",
          		//closeOnConfirm: false,
          		//closeOnCancel: false
          	},
          	function (isConfirm) {
          		if (isConfirm) {
          			$(".confirm").attr('disabled', 'disabled');
                parent.location.href='perfil.php?token=1690469607'+IdUsua;
          			
          			return true;
          		} else {
          			return false;
          		}
          	});
            }
            if(Valor1==0){
              swal("Ha ocurrido un error", "No se ha podido realizar el proceso de cambio de estatus.", "error");
            }
          })
          .error(function(data) {
            swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
          });
        }

      });
  }



  function upd_trayectoria_id(IdUsua, IdTrayectoria,IdTipo) {
    // var IdTipo = document.getElementById("txt_tipoTrayectoria_2").value;
    var Fecha = document.getElementById("txt_fecha_2").value;
    var IdEstatus = document.getElementById("txt_estatus_2").value;
    var Archivo = document.getElementById("txtArchivo_2").value;
    var Comentario = document.getElementById("txt_comentario_tra_2").value;
    var Imagen = '#txtArchivo_2';

    if (Fecha == "") {
      swal("Error al guardar", "Debe seleccionar la fecha.", "error");
      return 0;
    }
    if (IdEstatus == "") {
      swal("Error al guardar", "Debe seleccionar el estatus en el que se encuentra el documento.", "error");
      return 0;
    }

    swal({
        title: "\u00BFEst\u00E1 seguro que desea actualizar el seguimiento de este alumno?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');

          var formData = new FormData();
          var files = $(Imagen)[0].files[0];
          formData.append('IdTrayectoria', IdTrayectoria);
          formData.append('IdUsua', IdUsua);
          formData.append('Fecha', Fecha);
          formData.append('IdEstatus', IdEstatus);
          formData.append('IdTipo', IdTipo);
          formData.append('Comentario', Comentario);

          formData.append('file', files);

          $.ajax({
              url: 'upload_trayectoria_alumno _upd.php',
              type: 'post',
              data: formData,
              contentType: false,
              processData: false,
              success: function(response) {

              }
            })
            .done(function(response) {
              if (response == 1) {
                var IdTrayectoria = 0;
                swal("Actualizado correctamente", "El seguimiento al alumno se ha actualizado correctamente.", "success");
                $.ajax({
                  url: "vistas/alumno/trayectoria_estudiantil.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdTrayectoria: IdTrayectoria
                  },
                  success: function(data) {
                    $('#employee_detailTray').html(data);
                    $('#dataModalTray').modal('show');
                  }
                });
              } else if (response == 2) {
                var IdTrayectoria = 0;
                swal("Error al guardar", "Los datos ingresados ya existen en la trayectoria del alumno(a).", "error");
                $.ajax({
                  url: "vistas/alumno/trayectoria_estudiantil.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdTrayectoria: IdTrayectoria
                  },
                  success: function(data) {
                    $('#employee_detailTray').html(data);
                    $('#dataModalTray').modal('show');
                  }
                });
              } else if (response == 3) {
                var IdTrayectoria = 0;
                swal("Error al guardar", "Los la evidencia no se pudo subir.", "error");
                $.ajax({
                  url: "vistas/alumno/trayectoria_estudiantil.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdTrayectoria: IdTrayectoria
                  },
                  success: function(data) {
                    $('#employee_detailTray').html(data);
                    $('#dataModalTray').modal('show');
                  }
                });
              } else {
                swal("Error al guardar", "No se puede guardar los datos.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });


        }
      });

  }

  function modificar_trayectoria(IdUsua, IdTrayectoria) {
    $.ajax({
			url: "vistas/alumno/trayectoria_estudiantil.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				IdTrayectoria: IdTrayectoria
			},
			success: function(data) {
				$('#employee_detailTray').html(data);
				$('#dataModalTray').modal('show');
			}
		});
  }
</script>
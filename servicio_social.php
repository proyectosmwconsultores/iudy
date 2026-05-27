<?php $section = "Servicio social";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el modulo de servicio social.');
}
$IdUsua = substr($_GET['IdUsua'], 10, 10);

$datosUser = $t->get_datoDocente($IdUsua);
$serv_id = $t->get_mi_servicio_id($IdUsua);

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Servicio social</h1>
				<ol class="breadcrumb">
					<li><a href=""><i class="fa fa-book"></i> Seguimiento</a></li>
					<li class="active">Servicio social</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden" />
					<div class="col-md-3">
						<div class="box box-primary">
							<div class="box-body box-profile">
								<?php if (isset($datosUser[0]["Foto"])) { ?>
									<img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $datosUser[0]["Foto"]; ?>" alt="User profile picture" style="width:100px; height: 100px;">
								<?php } else { ?>
									<img class="profile-user-img img-responsive img-circle" src="assets/perfil/nuevo.png" alt="User profile picture" style="width:100px; height: 100px;">
								<?php } ?>
								<h3 class="profile-username text-center"><?php echo $datosUser[0]["Nombre"]; ?></h3>
								<p class="text-muted text-center"><?php echo $datosUser[0]["APaterno"] . ' ' . $datosUser[0]["AMaterno"]; ?></p>
								<ul class="list-group list-group-unbordered">
									<a style='text-align: left;' onclick="javascript:window.open('perfil.php?token=<?php echo time() . $IdUsua; ?>', '_self');" href="javascript:void(0);" title="Regresar" class="btn btn-success btn-block"><i class="fa fa-fw fa-mail-reply-all"></i> Regresar</a>
									<a style='text-align: left;' onclick="expediente_inscripcion(<?php echo $IdUsua; ?>)" href="javascript:void(0);" title="Regresar" class="btn btn-info btn-block"><i class="fa fa-fw fa-cog"></i> Expediente de inscripción</a>
									<?php if((isset($serv_id[0]['IdEstatus'])) && (($serv_id[0]['IdEstatus'] == 1) || ($serv_id[0]['IdEstatus'] == 2) || ($serv_id[0]['IdEstatus'] == 3) || ($serv_id[0]['IdEstatus'] == 4))){ ?>
									<a style='text-align: left;' onclick="cancelar_servicio_social(<?php echo $IdUsua; ?>,<?php echo $serv_id[0]['IdServicio']; ?>)" href="javascript:void(0);" title="Regresar" class="btn btn-danger btn-block"><i class="fa fa-fw fa-times-circle"></i> Cancelar servicio social </a>
									<?php } ?>
									<a style='text-align: left;' onclick="historico_servicio(<?php echo $IdUsua; ?>)" href="javascript:void(0);" title="Regresar" class="btn btn-primary btn-block"><i class="fa fa-fw fa-database"></i> Historial </a>
									
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-9">
						<form class="form-horizontal" enctype="multipart/form-data">
							<div class="nav-tabs-custom">
								<div class="tab-content">
									<div class="tab-pane active" id="activity">
										<div class="bg-active color-palette" style="padding: 5px; background: #1d3462; color: white;"><span><i class="fa fa-fw fa-edit"></i> Servicio social</span></div>
										<p style="text-align: center; display: none;" id="img_cargar2">
											<img src="assets/images/cargando.gif">
										</p>
										<div id="panel_actividades"></div>
									</div>
								</div>
								<!-- /.tab-content -->
							</div>
						</form>
					</div>
				</div>
			</section>
		</div>
		<?php include("footer.php"); ?>
	</div>

	</div>
	<div id="data_docspractica" class="modal fade bs-example-modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-flag"></i> Documento recibido</h4>
				</div>
				<div class="modal-body" id="employee_docspractica">
				</div>
			</div>
		</div>
	</div>
	<div id="data_practica" class="modal fade bs-example-modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-flag"></i> Práctica profesional</h4>
				</div>
				<div class="modal-body" id="employee_practica">
				</div>
			</div>
		</div>
	</div>
	<div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-gear"></i> Configurar constancia de servicio social</h4>
				</div>
				<div class="modal-body" id="employee_detail3">

				</div>
			</div>
		</div>
	</div>
	<div id="data_expediente" class="modal fade"> <!--MODAL ME GUSTA-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-gear"></i> Expediente de inscripción al servicio social</h4>
				</div>
				<div class="modal-body" id="employee_expediente">

				</div>
			</div>
		</div>
	</div>
	<div id="data_cancelar" class="modal fade"> <!--MODAL ME GUSTA-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-times-circle"></i> Cancelar práctica profesional</h4>
				</div>
				<div class="modal-body" id="employee_cancelar">

				</div>
			</div>
		</div>
	</div>
	<div id="data_histo" class="modal fade"> <!--MODAL ME GUSTA-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-times-circle"></i> Historial de cambios</h4>
				</div>
				<div class="modal-body" id="employee_histo">

				</div>
			</div>
		</div>
	</div>

</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
	$(function() {
		var IdUsua = document.getElementById("IdUsua").value;
		mostrar_seguimiento(IdUsua);

	})

	function mostrar_seguimiento(IdUsua) {
		document.getElementById("img_cargar2").style.display = 'block';
		document.getElementById("panel_actividades").style.display = 'none';
		var Capa = "#panel_actividades";
		$(Capa).load("vistas/servicio/control_servicio_social.php", {
			IdUsua: IdUsua
		}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
			if (status == "success") {
				document.getElementById("panel_actividades").style.display = 'block';
				document.getElementById("img_cargar2").style.display = 'none';
			}
		});
	}

	function configurar_constancia_practica(IdUsua, IdPractica) {
		$.ajax({
			url: "vistas/practicas/configurar_certificado_practica.php",
			method: "POST",
			data: {
				IdPractica: IdPractica,
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_detail3').html(data);
				$('#dataModal3').modal('show');
			}
		});
	}

	function expediente_inscripcion(IdUsua) {
		var Tipo = 0;
		$.ajax({
			url: "vistas/servicio/configurar_expediente.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				Tipo:Tipo
			},
			success: function(data) {
				$('#employee_expediente').html(data);
				$('#data_expediente').modal('show');
			}
		});
	}

	function sel_tipo(IdUsua, Tipo){
		$.ajax({
			url: "vistas/servicio/configurar_expediente.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				Tipo:Tipo
			},
			success: function(data) {
				$('#employee_expediente').html(data);
				$('#data_expediente').modal('show');
			}
		});
	}

	function sel_docs_id(IdExpediente, IdUsua, IdEstatus){
		var Tipo = 0;
		var TipoGuardar = "sel_estatus_docs";
		$.ajax({
			url: "vistas/servicio/sav_desarrollo.php",
			method: "POST",
			data: {
				TipoGuardar: TipoGuardar,
				IdExpediente: IdExpediente,
				IdEstatus:IdEstatus
			},
			success: function(data) {
				$.ajax({
				url: "vistas/servicio/configurar_expediente.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					Tipo:Tipo
				},
				success: function(data) {
					$('#employee_expediente').html(data);
					$('#data_expediente').modal('show');
				}
			});
			}
		})
	}

	function inscripcion_practica(IdUsua, IdAviso, IdDetalle) {
		var Tipo = 1;
		$.ajax({
			url: "vistas/practicas/inscripcion_alumno.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				IdAviso: IdAviso,
				IdDetalle: IdDetalle,
				Tipo: Tipo
			},
			success: function(data) {
				$('#employee_practica').html(data);
				$('#data_practica').modal('show');
			}
		});
	}

	function save_docs_practica(IdUsua) {
		var Tipo = document.getElementById("txtTipoDoc").value;
		var Archivo = document.getElementById("txtArchivo").value;
		var Imagen = '#txtArchivo';

		if (Tipo == "") {
			swal("Error al guardar", "Debe seleccionar el tipo de documento que esta subiendo.", "error");
			return 0;
		}
		if (Archivo == "") {
			swal("Error al guardar", "Debe seleccionar el archivo.", "error");
			return 0;
		}

		swal({
				title: "\u00BFEst\u00E1 seguro que desea guardar este archivo seleccionado?",
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
					formData.append('Tipo', Tipo);
					formData.append('file', files);

					$.ajax({
							url: 'vistas/upload/subir_docs_practica.php',
							type: 'post',
							data: formData,
							contentType: false,
							processData: false,
							success: function(response) {}
						})
						.done(function(response) {
							if (response == 1) {
								swal("Guardado correctamente", "El archivo se ha subido correctamente.", "success");
								mostrar_seguimiento(IdUsua);
							} else {
								swal("Error al guardar", "Ha ocurrido un error no se ha podido subir el archivo.", "error");
							}
						})
						.error(function(data) {
							swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
						});
				}
			});
	}

	function del_docs_practica(IdDocs, IdUsua) {
		var TipoGuardar = "del_docs_practica";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este archivo?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
				cancelButtonText: "Cancelar",
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');

					$.ajax({
							url: "vistas/practicas/sav_desarrollo.php",
							method: "POST",
							data: {
								TipoGuardar: TipoGuardar,
								IdDocs: IdDocs
							},
							success: function(data) {}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Eliminado correctamente", "El documento se ha eliminado correctamente.", "success");
								mostrar_seguimiento(IdUsua);
							} else {
								swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
							}
						})
						.error(function(data) {
							swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
						});
				}
			});
	}

	function ver_docs_practica(IdDocs) {
		$.ajax({
			url: "vistas/servicio/ver_docs_servicio.php",
			method: "POST",
			data: {
				IdDocs: IdDocs
			},
			success: function(data) {
				$('#employee_docspractica').html(data);
				$('#data_docspractica').modal('show');
			}
		});
	}

	function generar_constancia_prac(IdPractica) {
		var IdUsua = document.getElementById("IdUsua").value;
		var Fecha = document.getElementById("txtFec_prac").value;
		var Imagen = '#txtArchivo';

		if (Fecha == "") {
			swal("Error al guardar", "Debe seleccionar la fecha con la que se emitirá la constancia de terminación de prácticas profesionales.", "error");
			return 0;
		}

		var TipoGuardar = "liberar_constancia_practica";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea emitir esta constancia de práticas profesionales con a fecha seleccionada?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
				cancelButtonText: "Cancelar",
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');

					$.ajax({
							url: "vistas/practicas/sav_desarrollo.php",
							method: "POST",
							data: {
								TipoGuardar: TipoGuardar,
								Fecha: Fecha,
								IdPractica: IdPractica
							},
							success: function(data) {
								alert(data);
							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Generado correctamente", "La constancia de terminación de prácticas profesionales se ha generado correctamente.", "success");
								mostrar_seguimiento(IdUsua);
								$.ajax({
									url: "vistas/practicas/configurar_certificado_practica.php",
									method: "POST",
									data: {
										IdPractica: IdPractica,
										IdUsua: IdUsua
									},
									success: function(data) {
										$('#employee_detail3').html(data);
										$('#dataModal3').modal('show');
									}
								});
							} else {
								swal("Error al generar", "No se puede generar, verifique sus datos.", "error");
							}
						})
						.error(function(data) {
							swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
						});
				}
			});
	}

	function generar_expediente(IdServicio,IdExpediente,IdUsua){
		var IdGiro = document.getElementById("txt_giro").value;
		var IdTipoEmpresa = document.getElementById("txt_tipoEmpresa").value;
		var Fecha = document.getElementById("txt_fecha_2").value;
		
      var TipoGuardar = 'sav_expediente_id';

      swal({
        title: "\u00BFEst\u00E1 seguro que desea generar este expediente del alumno para el servicio social?",
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
            url: "vistas/servicio/sav_desarrollo.php",
                method:"POST",
                data: {
                  TipoGuardar: TipoGuardar,
				  IdExpediente:IdExpediente,
				  IdTipoEmpresa:IdTipoEmpresa,
				  IdGiro:IdGiro,
				  IdServicio:IdServicio,
				  Fecha:Fecha
                },
                success:function(data){ //alert(data);

                }
           })
          .done(function(data) {
            var Valor1 = '';
            Valor1 = data;
            

            if(Valor1==1){

              swal({
              title: "Los datos del expediente se han guardado correctamente para un hacer el servicio social.",
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
                parent.location.href='servicio_social.php?IdUsua=1690483972'+IdUsua;
          			
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

  function cancelar_servicio_social(IdUsua,IdServicio) {
		$.ajax({
			url: "vistas/servicio/cancelar_servicio.php",
			method: "POST",
			data: {
				IdServicio: IdServicio,
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_cancelar').html(data);
				$('#data_cancelar').modal('show');
			}
		});
	}

	function procesar_cancelacion_ss_id(IdUsua, IdServicio) {
		var Motivo = document.getElementById("txt_motivo").value;
		var Fecha = document.getElementById("txt_cancelacion").value;
		var IdAlumno = document.getElementById("IdUsua").value;


		if (Motivo == "") {
			swal("Error al guardar", "Debe indicar el motivo de cancelación del Servicio Social.", "error");
			return 0;
		}
		if (Fecha == "") {
			swal("Error al guardar", "Debe seleccionar la fecha de cancelación del Servicio Social.", "error");
			return 0;
		}

		var TipoGuardar = "cancelar_servicio_ss_id";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea cancelar el Servicio Social de este alumno?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
				cancelButtonText: "Cancelar",
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');

					$.ajax({
							url: "vistas/servicio/sav_desarrollo.php",
							method: "POST",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
								Motivo: Motivo,
								Fecha: Fecha,
								IdServicio: IdServicio
							},
							success: function(data) {}
						})
						.done(function(data) {
							if (data == 1) {

								swal({
										title: "El Servicios Social del alumno se ha cancelado correctamente",
										type: "success",
										showCancelButton: false,
										confirmButtonColor: '#DD6B55',
										confirmButtonText: 'Aceptar'
									},
									function(isConfirm) {
										if (isConfirm) {
											$(".confirm").attr('disabled', 'disabled');
											parent.location.href = 'servicio_social.php?IdUsua=1672771826' + IdAlumno;
										} else {
											return false;
										}
									});

							} else {
								swal("Error al generar", "No se puede generar, verifique sus datos.", "error");
							}
						})
						.error(function(data) {
							swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
						});
				}
			});
	}

	function historico_servicio(IdUsua) {
		$.ajax({
			url: "vistas/servicio/historial_servicio.php",
			method: "POST",
			data: {
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_histo').html(data);
				$('#data_histo').modal('show');
			}
		});
	}
</script>
</body>

</html>

function val_idEnviado(valor) {
	parent.location.href = 'perfil.php?token=' + valor; //direcciona la pagina madre
}

function val_id_cobrar_us(valor) {
	parent.location.href = 'cobrar.php?token=' + valor; //direcciona la pagina madre
}

function val_ing_modulo(IdMenu) {
	var TipoGuardar = "busmenu_id";
	$.ajax({
		url: "formConsulta/setting.php",
		method: "POST",
		data: { TipoGuardar: TipoGuardar, IdMenu: IdMenu },
		success: function (data) {

			window.location.assign(data);
		}
	})
}

function val_idEnviadoAsesor(valor) {
	parent.location.href = 'asesor.php?token=' + valor; //direcciona la pagina madre
}

function val_idEnviadoPlaneacion(valor) {
	parent.location.href = 'searchPlaneacion.php?token=' + valor; //direcciona la pagina madre
}

function val_addAsignat(IdPlan, IdTema, IdModulo) {
	var TipoGuardar = "add_planAsig";
	$.ajax({
		url: "formConsulta/setting.php",
		method: "POST",
		data: { TipoGuardar: TipoGuardar, IdPlan: IdPlan, IdTema: IdTema, IdModulo: IdModulo },
		success: function (data) {
			showAsignaturas(IdTema)
		}
	})
}



function delUsuario(IdUsua) {
	var TipoGuardar = "del_usuario";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este usuario?",
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
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdUsua: IdUsua },
					success: function (data) {
						document.getElementById(IdUsua).style.display = 'none';
					}
				})

			}

		});
}

function delGrupoId(IdGrupo) {
	var TipoGuardar = "del_grupoId";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este grupo?",
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
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdGrupo: IdGrupo },
					success: function (data) {
						//document.getElementById(IdGrupo).style.display = 'none';
						$('#dataModalGrp').modal('hide');
					}
				})


			}

		});
}


function saveFechaN(IdTarea) {
	var TipoGuardar = "add_NewFwechaEn";
	var FechaXX = "txtFecha" + IdTarea;
	var Fecha = document.getElementById(FechaXX).value;
	var IdActividadDoc = document.getElementById("IdActividadDoc").value;


	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta fecha de entrega para este alumno?",
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
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdTarea: IdTarea, Fecha: Fecha },
					success: function (data) {
						$.ajax({
							url: "formConsulta/addFechaPer.php",
							method: "POST",
							data: { IdActividadDoc: IdActividadDoc },
							success: function (data) {
								$('#employee_detailModFue').html(data);
								$('#dataModalModFue').modal('show');
							}
						});

					}
				})

			}

		});
}

function actEvaNew(IdExamenUsua, Valor) {
	var TipoGuardar = "add_actNewEva";
	var IdActividadDoc = document.getElementById("IdActividadDoc").value;


	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar el estatus?",
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
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdExamenUsua: IdExamenUsua, Valor: Valor },
					success: function (data) {
						$.ajax({
							url: "formConsulta/addActivarEva.php",
							method: "POST",
							data: { IdActividadDoc: IdActividadDoc },
							success: function (data) {
								$('#employee_eva').html(data);
								$('#dataEva').modal('show');
							}
						});

					}
				})

			}

		});
}

function actEvaNewTodos() {
	var TipoGuardar = "add_actNewTods";
	var IdActividadDoc = document.getElementById("IdActividadDoc").value;

	swal({
		title: "\u00BFEst\u00E1 seguro que desea activar la evaluación para todos los alumnos?",
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
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdActividadDoc: IdActividadDoc },
					success: function (data) {
						$.ajax({
							url: "formConsulta/addActivarEva.php",
							method: "POST",
							data: { IdActividadDoc: IdActividadDoc },
							success: function (data) {
								$('#employee_eva').html(data);
								$('#dataEva').modal('show');
							}
						});

					}
				})

			}

		});
}

function ediEvalua() {
	var TipoGuardar = "add_modEvaTods";
	var IdActividadDoc = document.getElementById("IdActividadDoc").value;

	swal({
		title: "\u00BFEst\u00E1 seguro que desea editar la evaluación?",
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
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdActividadDoc: IdActividadDoc },
					success: function (data) {
						$.ajax({
							url: "formConsulta/addActivarEva.php",
							method: "POST",
							data: { IdActividadDoc: IdActividadDoc },
							success: function (data) {
								$('#employee_eva').html(data);
								$('#dataEva').modal('show');
							}
						});

					}
				})

			}

		});
}


function delFile(IdArchivo) {
	var TipoGuardar = "del_archivo";


	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este archivo?",
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
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdArchivo: IdArchivo },
					success: function (data) {
						// alert(data);
						if (data == 1) {
							document.getElementById(IdArchivo).style.display = 'none';
						}

					}
				})

			}

		});

}

function delFileDocs(IdArchivo) {
	var TipoGuardar = "del_archivoDocs";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este archivo?",
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
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdArchivo: IdArchivo },
					success: function (data) {
						if (data == 1) {
							document.getElementById(IdArchivo).style.display = 'none';
						}

					}
				})

			}

		});

}

function delFileDocsXX(IdLibro) {
	var TipoGuardar = "del_archivoDocsXX";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este archivo?",
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
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdLibro: IdLibro },
					success: function (data) {
						if (data == 1) {
							document.getElementById(IdLibro).style.display = 'none';
						}

					}
				})

			}

		});

}

function delFileAviso(IdAviso) {
	var TipoGuardar = "del_archivoAviso";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este aviso?",
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
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdAviso: IdAviso },
					success: function (data) {
						if (data == 1) {
							document.getElementById(IdAviso).style.display = 'none';
						}

					}
				})

			}

		});

}



function add_etapa(IdPlan, IdTema, Etapa) {
	var TipoGuardar = "add_etapa";
	$.ajax({
		url: "formConsulta/setting.php",
		method: "POST",
		data: { TipoGuardar: TipoGuardar, IdPlan: IdPlan, IdTema: IdTema, Etapa: Etapa },
		success: function (data) {
			showAsignaturas(IdTema)
		}
	})
}

function del_etapa(IdTema, IdEtapa) {
	var TipoGuardar = "del_etapa";
	$.ajax({
		url: "formConsulta/setting.php",
		method: "POST",
		data: { TipoGuardar: TipoGuardar, IdEtapa: IdEtapa },
		success: function (data) {
			showAsignaturas(IdTema)
		}
	})
}

function del_addAsignat(IdTema, IdAsignatura) {
	var TipoGuardar = "del_planAsig"
	$.ajax({
		url: "formConsulta/setting.php",
		method: "POST",
		data: { TipoGuardar: TipoGuardar, IdAsignatura: IdAsignatura },
		success: function (data) {
			showAsignaturas(IdTema)
		}
	})


}

function add_grupoPlan(IdGrupo, IdPlan) {
	var TipoGuardar = "add_grupoPlan";
	var employee_id = IdPlan;
	$.ajax({
		url: "formConsulta/setting.php",
		method: "POST",
		data: { TipoGuardar: TipoGuardar, IdPlan: IdPlan, IdGrupo: IdGrupo },
		success: function (data) {
			$.ajax({
				url: "formConsulta/addPlanGrupo.php",
				method: "POST",
				data: { employee_id: employee_id },
				success: function (data) {
					$('#employee_detail3').html(data);
					$('#dataModal3').modal('show');
				}
			});
		}
	})
}

function del_grupoPlan(IdGrupo, IdPlan) {
	var TipoGuardar = "del_grupoPlan";
	var employee_id = IdPlan;
	$.ajax({
		url: "formConsulta/setting.php",
		method: "POST",
		data: { TipoGuardar: TipoGuardar, IdGrupo: IdGrupo },
		success: function (data) {
			$.ajax({
				url: "formConsulta/addPlanGrupo.php",
				method: "POST",
				data: { employee_id: employee_id },
				success: function (data) {
					$('#employee_detail3').html(data);
					$('#dataModal3').modal('show');
				}
			});
		}
	})
}

function aprobarPlan(IdPlan, IdUsua) {


	var TipoGuardar = "add_cerrarPlan";
	var Estatus = document.getElementById("txtEstatusX").value;
	if (Estatus == '') {
		swal("Error al guardar", "Debe seleccionar el estatus aprobado.", "error");
		document.getElementById("txtEstatus").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea aprobar este plan de proyecto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');

				var employee_id = IdPlan;
				$.ajax({
					url: "formConsulta/setting.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdPlan: IdPlan, IdUsua: IdUsua },
					success: function (data) {
						$.ajax({
							url: "formConsulta/addPlanGrupo.php",
							method: "POST",
							data: { employee_id: employee_id },
							success: function (data) {
								$('#employee_detail3').html(data);
								$('#dataModal3').modal('show');
							}
						});
					}
				})

			}

		});

	// var employee_id = IdPlan;
	// $.ajax({
	//      url:"formConsulta/setting.php",
	//      method:"POST",
	//      data:{TipoGuardar:TipoGuardar, IdGrupo:IdGrupo},
	//      success:function(data){
	//        $.ajax({
	//             url:"formConsulta/addPlanGrupo.php",
	//             method:"POST",
	//             data:{employee_id:employee_id},
	//             success:function(data){
	//                  $('#employee_detail3').html(data);
	//                  $('#dataModal3').modal('show');
	//             }
	//        });
	//      }
	// })
}


function pasarLista() {
	//alert('hola');
}

function val_registro() {
	if (document.frm.txtNombre.value.length == '') {
		swal("Error al guardar", "Debe escribir su nombre.", "error");
		document.getElementById("txtNombre").focus();
		return 0;
	}
	if (document.frm.txtAPaterno.value.length == '') {
		swal("Error al guardar", "Debe escribir su apellido paterno.", "error");
		document.getElementById("txtAPaterno").focus();
		return 0;
	}
	if (document.frm.txtAMaterno.value.length == '') {
		swal("Error al guardar", "Debe escribir su apellido materno.", "error");
		document.getElementById("txtAMaterno").focus();
		return 0;
	}
	if (document.frm.txtTelefono.value.length == '') {
		swal("Error al guardar", "Debe escribir su n\u00FAmero de tel\u00E9fono.", "error");
		document.getElementById("txtTelefono").focus();
		return 0;
	}
	if (document.frm.txtCorreo.value.length == '') {
		swal("Error al guardar", "Debe escribir su correo.", "error");
		document.getElementById("txtCorreo").focus();
		return 0;
	}

	if (document.frm.datepicker.value.length == '') {
		swal("Error al guardar", "Debe seleccionar su fecha de nacimiento.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}
	if (document.frm.txtOferta.value.length == '') {
		swal("Error al guardar", "Debe seleccionar su la oferta educativa.", "error");
		document.getElementById("txtOferta").focus();
		return 0;
	}
	var sexo = document.frm.gender.value;
	var revalidar = document.frm.revalida.value;

	if (sexo == '') {
		swal("Error al guardar", "Debe seleccionar su sexo.", "error");
		document.getElementById("gender").focus();
		return 0;
	}
	if (revalidar == '') {
		swal("Error al guardar", "Debe seleccionar si va a revalidar alguna materia.", "error");
		document.getElementById("revalida").focus();
		return 0;
	}
	swal({
		title: "\u00BFEst\u00E1 seguro que desea registrarse a esta plataforma?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				document.frm.Mov.value = 'Guardar'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}


function loadPagosPb(IdUsua) { //IdRecurso,Link,IdAsignacion

	var IdUsua = document.frm.token.value;

	var Tipo = 'load_pagos';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea cargar los pagos de este usuario?",
		type: "info",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "Lista de pagos actualizado correctamente.", "success");
						} else {
							swal("Actualizado correctamente", "Lista de pagos actualizado correctamente.", "success");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});




}


function val_registroIesch() {
	var sexo = document.frm.gender.value;
	var revalidar = document.frm.revalida.value;

	if (document.frm.txtNombre.value.length == '') {
		swal("Error al guardar", "Debe escribir su nombre.", "error");
		document.getElementById("txtNombre").focus();
		return 0;
	}
	if (document.frm.txtAPaterno.value.length == '') {
		swal("Error al guardar", "Debe escribir su apellido paterno.", "error");
		document.getElementById("txtAPaterno").focus();
		return 0;
	}
	if (document.frm.txtAMaterno.value.length == '') {
		swal("Error al guardar", "Debe escribir su apellido materno.", "error");
		document.getElementById("txtAMaterno").focus();
		return 0;
	}
	if (document.frm.txtTelefono.value.length == '') {
		swal("Error al guardar", "Debe escribir su n\u00FAmero de tel\u00E9fono.", "error");
		document.getElementById("txtTelefono").focus();
		return 0;
	}
	if (document.frm.txtCorreo.value.length == '') {
		swal("Error al guardar", "Debe escribir su correo.", "error");
		document.getElementById("txtCorreo").focus();
		return 0;
	}
	if (sexo == '') {
		swal("Error al guardar", "Debe seleccionar su sexo.", "error");
		document.getElementById("gender").focus();
		return 0;
	}

	if (document.frm.datepicker.value.length == '') {
		swal("Error al guardar", "Debe seleccionar su fecha de nacimiento.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}
	if (document.frm.txtOferta.value.length == '') {
		swal("Error al guardar", "Debe seleccionar su la oferta educativa.", "error");
		document.getElementById("txtOferta").focus();
		return 0;
	}



	if (revalidar == '') {
		swal("Error al guardar", "Debe seleccionar si va a revalidar alguna materia.", "error");
		document.getElementById("revalida").focus();
		return 0;
	}
	swal({
		title: "\u00BFEst\u00E1 seguro que desea registrarse a esta plataforma?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
		function (isConfirm) {
			if (isConfirm) {
				document.frm.Mov.value = 'Guardar'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_registroDoc() {
	if (document.frm.txtNombre.value.length == '') {
		swal("Error al guardar", "Debe escribir su nombre.", "error");
		document.getElementById("txtNombre").focus();
		return 0;
	}
	if (document.frm.txtAPaterno.value.length == '') {
		swal("Error al guardar", "Debe escribir su apellido paterno.", "error");
		document.getElementById("txtAPaterno").focus();
		return 0;
	}
	if (document.frm.txtAMaterno.value.length == '') {
		swal("Error al guardar", "Debe escribir su apellido materno.", "error");
		document.getElementById("txtAMaterno").focus();
		return 0;
	}
	if (document.frm.txtTelefono.value.length == '') {
		swal("Error al guardar", "Debe escribir su n\u00FAmero de tel\u00E9fono.", "error");
		document.getElementById("txtTelefono").focus();
		return 0;
	}
	if (document.frm.txtCorreo.value.length == '') {
		swal("Error al guardar", "Debe escribir su correo.", "error");
		document.getElementById("txtCorreo").focus();
		return 0;
	}

	if (document.frm.datepicker.value.length == '') {
		swal("Error al guardar", "Debe seleccionar su fecha de nacimiento.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}
	var sexo = document.frm.gender.value;

	if (sexo == '') {
		swal("Error al guardar", "Debe seleccionar su sexo.", "error");
		document.getElementById("gender").focus();
		return 0;
	}
	swal({
		title: "\u00BFEst\u00E1 seguro que desea registrarse a esta plataforma?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
		function (isConfirm) {
			if (isConfirm) {
				document.frm.Mov.value = 'Guardar'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}


function val_delProspecto() {
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este prospecto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
		function (isConfirm) {
			if (isConfirm) {
				document.frm.Mov.value = 'delProspecto'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_aceptProspecto() {
	swal({
		title: "\u00BFEst\u00E1 seguro de aceptar este prospecto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoc").style.display = 'block';
				document.frm.Mov.value = 'aceptProspecto'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}


function val_delProspectoNew(IdUsua) { //IdRecurso,Link,IdAsignacion

	var Tipo = 'val_delUsuario';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este prospecto?",
		type: "success",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Eliminado correctamente", "Prospecto en proceso eliminado correctamente.", "success");
							document.getElementById(IdUsua).style.display = 'none';
						} else {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});




}



function val_delUsuariosExc() {
	var IdUsua = document.frm.IdUsua.value;

	var Tipo = 'val_delUsersExcel';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar todos estos usuarios en proceso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							//document.getElementById(IdGrupo).style.display = 'none';
							swal("Eliminado correctamente", "Lista de usuarios en proceso eliminados correctamente.", "success");
							document.getElementById("tbtabl59").style.display = 'none';
							//

						} else {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});
}


function val_delRegistroExc() {
	var IdUsua = document.frm.IdUsua.value;

	var Tipo = 'val_delRegExcel';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar todos estos usuarios en proceso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//  alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							//document.getElementById(IdGrupo).style.display = 'none';
							swal("Eliminado correctamente", "Lista de usuarios en proceso eliminados correctamente.", "success");
							document.getElementById("tbtabl59").style.display = 'none';
							//

						} else {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});
}

function val_delCatMod() {
	var IdUsua = document.frm.IdUsua.value;
	var Tipo = 'val_delCatMod';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar esta lista de asignaturas?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {

							swal("Eliminado correctamente", "Lista de asignaturas se ha eliminado correctamente.", "success");
							//document.getElementById(Id).style.display = 'none';
							//
							parent.location.href = 'adAddModulo.php';
						} else {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});
}

function val_delSaldo() {
	var IdUsua = document.frm.IdUsua.value;
	var Tipo = 'val_delSaldo';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar esta lista de saldos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {

							swal("Eliminado correctamente", "La lista de saldos se ha eliminado correctamente.", "success");
							//document.getElementById(Id).style.display = 'none';
							//
							parent.location.href = 'adAddSaldo.php';
						} else {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});
}




function val_closeGrupo() {
	var IdGrupo = document.getElementById("txtGrupo").value;
	var IdUsua = document.getElementById("IdUsua").value;

	if (IdGrupo == '') {
		swal("Error al guardar", "Debe seleccionar el grupo.", "error");
		document.getElementById("txtGrupo").focus();
		return 0;
	}

	var TipoGuardar = "val_close_grupo";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea crear este grupo con estos alumnos?",
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
					url: "formConsulta/setting_upload_grupo.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdUsua: IdUsua, IdGrupo: IdGrupo },
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Creado correctamente", "El grupo se a creado correctamente con sus nuevos alumnos.", "success");
							parent.location.href = 'addCrearGrupo.php';
						} else {
							swal("Error al crear", "No se puede crear, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
					});
			}

		});


	// var Tipo = 'val_closeGrupo';
	// swal({
	// title: "\u00BFEst\u00E1 seguro que desea crear este grupo con estos alumnos?",
	// type: "warning",
	// showCancelButton: true,
	// confirmButtonColor: '#DD6B55',
	// confirmButtonText: 'Aceptar',
	// cancelButtonText: "Cancelar",
	// },
	// function (isConfirm) {
	// if (isConfirm) {
	// 	$(".confirm").attr('disabled', 'disabled');
	//   var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua + '&IdGrupo=' + IdGrupo;
	//   $.ajax({
	//     type:"POST",
	//     url:"insertar.php",
	//     data:datos,
	//     success:function(data){
	//
	//     }
	//   })
	//   .done(function(data) {
	//     if(data==1){
	//       swal("Creado correctamente", "El grupo se a creado correctamente con sus nuevos alumnos.", "success");
	//       parent.location.href='addCrearGrupo.php';
	//     }else{
	//       swal("Error al crear", "No se puede crear, verifique sus datos.", "error");
	//     }
	//   })
	//   .error(function(data) {
	//     swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
	//   });
	// }
	// });
}

function val_savUsers() {
	var IdUsua = document.frm.IdUsua.value;


	var Tipo = 'val_savUsers';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos usuarios en la plataforma?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Creado correctamente", "La lista de usuarios se han agregado correctamente.", "success");
							parent.location.href = 'adAddUsuario.php?tok=1';
						} else {
							swal("Error al crear", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});
}

function val_savUsersNew() {
	var IdUsua = document.frm.IdUsua.value;


	var Tipo = 'val_savUsersNew';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos usuarios en la plataforma?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Creado correctamente", "La lista de usuarios se han agregado correctamente.", "success");
							parent.location.href = 'adUsuario.php?tok=1';
						} else {
							swal("Error al crear", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});
}

function val_subAsignaturas() {
	var IdUsua = document.frm.IdUsua.value;

	var Tipo = 'val_subAsignatura';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar las asignaturas de esta tabla?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {

							swal("Guardado correctamente", "La lista de asignaturas ha sido guardado correctamente.", "success");
							document.getElementById("trLine60").style.display = 'none';
							//document.getElementById(Id).style.display = 'none';
							//
							//parent.location.href='adAddModulo.php';
						} else {
							swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});
}


function val_insertSaldo() {
	var IdUsua = document.frm.IdUsua.value;

	var Tipo = 'val_addSaldoIni';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar los saldos iniciales que se muestran en la lista?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {

							swal("Guardado correctamente", "La lista de asignaturas ha sido guardado correctamente.", "success");
							document.getElementById("trLine60").style.display = 'none';
							//document.getElementById(Id).style.display = 'none';
							//
							//parent.location.href='adAddModulo.php';
						} else {
							swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});
}

function val_datoFactura() {
	if (document.frm.txtRegimen.value.length == '') {
		swal("Error al guardar", "Debe seleccionar el Regimen Fiscal.", "error");
		document.getElementById("txtRegimen").focus();
		return 0;
	}
	if (document.frm.txtUso.value.length == '') {
		swal("Error al guardar", "Debe seleccionar el Uso CFDI.", "error");
		document.getElementById("txtUso").focus();
		return 0;
	}
	if (document.frm.txtRFC.value.length == '') {
		swal("Error al guardar", "Debe escribir su RFC.", "error");
		document.getElementById("txtRFC").focus();
		return 0;
	}
	if (document.frm.txtRazon.value.length == '') {
		swal("Error al guardar", "Debe escribir la razon social.", "error");
		document.getElementById("txtRazon").focus();
		return 0;
	}
	if (document.frm.txtDomicilio.value.length == '') {
		swal("Error al guardar", "Debe escribir su domicilio.", "error");
		document.getElementById("txtDomicilio").focus();
		return 0;
	}
	if (document.frm.txtCP.value.length == '') {
		swal("Error al guardar", "Debe escribir su CP.", "error");
		document.getElementById("txtCP").focus();
		return 0;
	}
	if (document.frm.txtColonia.value.length == '') {
		swal("Error al guardar", "Debe escribir la colonia.", "error");
		document.getElementById("txtColonia").focus();
		return 0;
	}
	if (document.frm.txtMunicipio.value.length == '') {
		swal("Error al guardar", "Debe escribir el municipio.", "error");
		document.getElementById("txtMunicipio").focus();
		return 0;
	}
	if (document.frm.txtCiudad.value.length == '') {
		swal("Error al guardar", "Debe escribir la ciudad.", "error");
		document.getElementById("txtCiudad").focus();
		return 0;
	}
	if (document.frm.txtEstado.value.length == '') {
		swal("Error al guardar", "Debe escribir el Estado.", "error");
		document.getElementById("txtEstado").focus();
		return 0;
	}

	if (document.frm.txtUso.value.length == '') {
		swal("Error al guardar", "Debe seleccionar tipo de uso de CFDI.", "error");
		document.getElementById("txtUso").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea dar de esta esta informaci\u00F3n?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
		function (isConfirm) {
			if (isConfirm) {
				document.frm.Mov.value = 'saveDFactura'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addActa() {
	var Acta = document.getElementById("txtActa").value;
	if (Acta == "") {
		swal("Error al guardar", "Debe seleccionar el archivo del acta de nacimiento.", "error");
		document.getElementById("txtNombre").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta acta de nacimiento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoc").style.display = 'block';
				document.getElementById("btnActa").disabled = true;
				document.frm.Mov.value = 'SubActa'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_newCorreo() {
	var Departamento = document.getElementById("txtDepartamento").value;
	var Grupo = document.getElementById("txtGrupo").value;
	var IdAlumno = document.getElementById("txtAlumno").value;
	var Tipo = document.getElementById("Tipo").value;
	var Asunto = document.getElementById("txtAsunto").value;
	var Mensaje = document.getElementById("compose-textarea").value;
	if (Departamento == "") {
		swal("Error al guardar", "Debe seleccionar el departamento.", "error");
		document.getElementById("txtDepartamento").focus();
		return 0;
	}
	if ((Tipo == "1") || (Tipo == "2")) {
		if (Grupo == "") {
			swal("Error al guardar", "Debe seleccionar el grupo.", "error");
			document.getElementById("txtGrupo").focus();
			return 0;
		}
	}
	if (Tipo == "2") {
		if (IdAlumno == "") {
			swal("Error al guardar", "Debe seleccionar el alumno.", "error");
			document.getElementById("txtAlumno").focus();
			return 0;
		}
	}

	if (Asunto == "") {
		swal("Error al guardar", "Debe escribir el asunto del correo.", "error");
		document.getElementById("txtAsunto").focus();
		return 0;
	}
	if (Mensaje == "") {
		swal("Error al guardar", "Debe escribir su mensaje a enviar.", "error");
		document.getElementById("compose-textarea").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea enviar este correo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoc").style.display = 'block';
				document.getElementById("btnCorreo").disabled = true;
				document.getElementById("btnAtras").disabled = true;
				document.frm.Mov.value = 'envCorreo'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}


function val_addDocumento() {
	var Tipo = document.getElementById("txtTipoDoc").value;
	var Documento = document.getElementById("txtDocumento").value;
	if (Tipo == "") {
		swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
		document.getElementById("txtDocumento").focus();
		return 0;
	}
	if (Documento == "") {
		swal("Error al guardar", "Debe seleccionar el documento.", "error");
		document.getElementById("txtDocumento").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este documento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoDoc").style.display = 'block';
				document.getElementById("btnDocDocente").disabled = true;
				document.frm.Mov.value = 'SubDocumento'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function subir_recnox() {
	var Nombre = document.getElementById("txt_nombre").value;
	var Fecha = document.getElementById("txt_fecha").value;
	var Documento = document.getElementById("txtDocumento").value;
	if (Nombre == "") {
		swal("Error al guardar", "Debe escribir el nombre del reconocimiento.", "error");
		document.getElementById("txt_nombre").focus();
		return 0;
	}
	if (Fecha == "") {
		swal("Error al guardar", "Debe seleccionar la fecha de emisión del reconocimiento.", "error");
		document.getElementById("txt_fecha").focus();
		return 0;
	}
	if (Documento == "") {
		swal("Error al guardar", "Debe seleccionar el reconocimiento.", "error");
		document.getElementById("txtDocumento").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este reconocimiento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoDoc").style.display = 'block';
				document.getElementById("btnDocDocente").disabled = true;
				document.frm.Mov.value = 'SubDocumentox'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addVideo() {

	var Titulo = document.getElementById("txtTitulo").value;
	if (Titulo == "") {
		swal("Error al guardar", "Debe escribir el nombre del video.", "error");
		document.getElementById("txtTitulo").focus();
		return 0;
	}



	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar el nombre del video?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoDoc").style.display = 'block';

				document.frm.Mov2.value = 'subVideo'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

// function val_addVideo()
// {
// 	var Tipo = document.getElementById("txtDocumento").value;
// 	var Titulo = document.getElementById("txtTitulo").value;
// 	if (Titulo==""){
// 		swal("Error al guardar", "Debe escribir el nombre del video.", "error");
//         document.getElementById("txtTitulo").focus();
//         return 0;
//     }
// 	if (Tipo==""){
// 		swal("Error al guardar", "Debe buscar y seleccionar el video a subir.", "error");
//        document.getElementById("txtDocumento").focus();
//        return 0;
//     }
//
//
//     swal({
// 		title: "\u00BFEst\u00E1 seguro que desea subir este video?",
// 		type: "warning",
// 		showCancelButton: true,
// 		confirmButtonColor: '#DD6B55',
// 		confirmButtonText: 'Aceptar',
// 		cancelButtonText: "Cancelar",
// 	},
// 	function (isConfirm) {
// 		if (isConfirm) {
// 			document.getElementById("imgLoadDoDoc").style.display = 'block';
//
// 			document.frm.Mov2.value='subVideo';document.frm.submit();
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	});
// }

function val_addDocCont() {
	var IdOferta = document.getElementById("txtIdOferta").value;
	var IdModulo = document.getElementById("txtModulo").value;
	var Documento = document.getElementById("txtDocumento").value;
	if (IdOferta == "") {
		swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
		document.getElementById("txtIdOferta").focus();
		return 0;
	}
	if (IdModulo == "") {
		swal("Error al guardar", "Debe seleccionar la asignatura.", "error");
		document.getElementById("txtModulo").focus();
		return 0;
	}
	if (Documento == "") {
		swal("Error al guardar", "Debe seleccionar el documento.", "error");
		document.getElementById("txtDocumento").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este contrato?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoDoc").style.display = 'block';
				document.getElementById("btnDocDocente").disabled = true;
				document.frm.Mov.value = 'SubContrato'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}


function val_addDocAlumno() {
	var Tipo = document.getElementById("txtTipoDoc").value;
	var Documento = document.getElementById("txtDocumento").value;
	if (Tipo == "") {
		swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
		document.getElementById("txtDocumento").focus();
		return 0;
	}
	if (Documento == "") {
		swal("Error al guardar", "Debe seleccionar el documento.", "error");
		document.getElementById("txtDocumento").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este documento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoAlum").style.display = 'block';
				document.getElementById("btnDocAlumno").disabled = true;
				document.frm.Mov.value = 'SubDocAlum'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_docs_tramite() {
	var IdDocAlumno = document.getElementById("txtTipoDoc").value;
	var Documento = document.getElementById("txtDocumento").value;
	if (IdDocAlumno == "") {
		swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
		document.getElementById("txtTipoDoc").focus();
		return 0;
	}
	if (Documento == "") {
		swal("Error al guardar", "Debe seleccionar el documento.", "error");
		document.getElementById("txtDocumento").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este documento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoAlum").style.display = 'block';
				document.getElementById("btnDocAlumno").disabled = true;
				document.frm.Mov.value = 'sub_doc_tram'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_DocSolicitado() {

	var Documento = document.getElementById("txtDocumento").value;
	var IdDoc = document.getElementById("IdDoc").value;
	var TipoGuardar = "addDocSolicitado";
	if (Documento == "") {
		swal("Error al guardar", "Debe seleccionar el documento solicitado a enviar.", "error");
		document.getElementById("txtDocumento").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este documento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.Mov.value = 'Guardar'; document.frm.submit();

				// 	var datos = 'TipoGuardar=' + TipoGuardar + '&IdDoc=' + IdDoc;
				// //	alert(datos);
				// 	$.ajax({
				// 		type:"POST",
				// 		url:"insertar.php",
				// 		data:datos,
				// 		success:function(data){
				// 			alert(data);
				// 		}
				// 	})
				// 	.done(function(data) {
				// 		if(data==1){
				// 			swal("Guardado correctamente", "Comprobante de pago generado correctamente", "success");
				// 			document.getElementById("frm").reset();
				// 			parent.location.href='misPagos.php'; //direcciona la pagina madre
				// 		}
				// 		if(data==0){
				// 			swal("Error al guardar", "No se puede guardar", "error");
				// 		}
				// 	})
				// 	.error(function(data) {
				// 		swal("Error al guardar 0x17", "No se puede guardar, comuniquese con el desarrollador.", "error");
				// 	});
			}
		});
}

function val_facturaSol() {

	var Documento = document.getElementById("txtDocumento").value;
	var IdDoc = document.getElementById("IdDoc").value;
	var TipoGuardar = "addDocSolicitado";
	if (Documento == "") {
		swal("Error al guardar", "Debe seleccionar la factura creada para este alumno.", "error");
		document.getElementById("txtDocumento").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta factura?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.Mov.value = 'Guardar'; document.frm.submit();
			}
		});
}


function val_notificarUserX() {

	var Comentario = document.getElementById("txtComentario").value;


	if (Comentario == "") {
		swal("Error al guardar", "Debe escribir un comentario al prospecto.", "error");
		document.getElementById("Comentario").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea enviar esta notificación al prospecto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.Mov.value = 'Guardar'; document.frm.submit();
			}
		});
}


function val_bajaUsuario() {

	var Estatus = document.getElementById("txtEstatus").value;
	var Comentario = document.getElementById("txtComentario").value;
	if (Estatus == "") {
		swal("Error al guardar", "Debe seleccionar el estatus.", "error");
		document.getElementById("txtEstatus").focus();
		return 0;
	}
	if (Comentario == "") {
		swal("Error al guardar", "Debe escribir un comentario.", "error");
		document.getElementById("txtComentario").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar los cambios seleccionados?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.Mov.value = 'Guardar'; document.frm.submit();
			}
		});
}



function val_encuestaSave(IdUsua) {
	var IdAsignacion = document.getElementById("IdAsignacion").value;

	var TipoGuardar = "cerrarEncuesta";


	swal({
		title: "\u00BFDesea guardar los cambios de la encuesta?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsua=' + IdUsua + '&IdAsignacion=' + IdAsignacion;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Encuesta guardado correctamente", "success");
							document.getElementById("frm").reset();
							parent.location.href = 'viewFinalizados.php'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al guardar", "No se puede guardar debe terminar la encuesta.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x17", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}


function val_addDatSocial() {
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos datos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.frm.Mov.value = 'datSocial'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addPago(obj, nombre, IdPago) {
	var pago = document.getElementById(nombre).value;
	if (pago == "") {
		swal("Error al guardar", "Debe seleccionar la imagen del comprobante.", "error");
		document.getElementById(nombre).focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este comprobante de pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.IdPago.value = IdPago; document.frm.Mov.value = 'SubPago'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addPagoSaldo(obj, nombre, IdSaldo) {
	var pago = document.getElementById(nombre).value;
	if (pago == "") {
		swal("Error al guardar", "Debe seleccionar la imagen del comprobante.", "error");
		document.getElementById(nombre).focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este comprobante de pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.IdSaldo.value = IdSaldo; document.frm.Mov.value = 'SubPagoSaldo'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addExcel() {
	// var IdOferta = document.getElementById("txtOferta").value;
	var IdCampus = document.getElementById("txtCampusx").value;
	var Archivo = document.getElementById("txtArchivo").value;


	// if (IdOferta==""){
	//    swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
	//     document.getElementById("txtOferta").focus();
	//     return 0;
	// }
	if (IdCampus == "") {
		swal("Error al guardar", "Debe seleccionar el campus.", "error");
		document.getElementById("txtCampusx").focus();
		return 0;
	}
	if (Archivo == "") {
		swal("Error al guardar", "Debe seleccionar el archivo excel.", "error");
		document.getElementById("txtArchivo").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo de excel?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.Mov.value = 'subExcel'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addExcel_alumnos() {
	var IdOferta = document.getElementById("txtOferta").value;
	var IdCampus = document.getElementById("txtCampus").value;
	var Archivo = document.getElementById("txtArchivo").value;

	if (IdOferta == "") {
		swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
		document.getElementById("txtOferta").focus();
		return 0;
	}
	if (IdCampus == "") {
		swal("Error al guardar", "Debe seleccionar el campus.", "error");
		document.getElementById("txtCampusx").focus();
		return 0;
	}
	if (Archivo == "") {
		swal("Error al guardar", "Debe seleccionar el archivo excel.", "error");
		document.getElementById("txtArchivo").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo de excel?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.Mov.value = 'subExcel'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addCatAsig() {
	var Archivo = document.getElementById("txtArchivo").value;

	if (Archivo == "") {
		swal("Error al guardar", "Debe seleccionar el archivo excel.", "error");
		document.getElementById("txtArchivo").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo de excel?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.Mov.value = 'subExcel'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addSaldo() {
	var Archivo = document.getElementById("txtArchivo").value;

	if (Archivo == "") {
		swal("Error al guardar", "Debe seleccionar el archivo excel.", "error");
		document.getElementById("txtArchivo").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir los saldos iniciales de este archivo excel?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.Mov.value = 'subExcel'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_solDocumento() {
	var TipoGuardar = "addSolicitud";
	var Concepto = document.getElementById("txtConcepto").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var FechaLim = document.getElementById("FechaLim").value;
	if (Concepto == "") {
		swal("Error al guardar", "Debe seleccionar el concepto de pago.", "error");
		document.getElementById("txtConcepto").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea solicitar pago para este concepto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&Concepto=' + Concepto + '&IdUsua=' + IdUsua + '&FechaLim=' + FechaLim;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//	alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Comprobante de pago generado correctamente", "success");
							document.getElementById("frm").reset();
							parent.location.href = 'misPagos.php'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al guardar", "No se puede guardar", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x17", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function val_addAIne() {
	var Ine = document.getElementById("txtIne").value;
	if (Ine == "") {
		swal("Error al guardar", "Debe seleccionar el archivo de la credencial de elector (INE).", "error");
		document.getElementById("txtIne").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta credencial de elector?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoc").style.display = 'block';
				document.getElementById("btnIne").disabled = true;
				document.frm.Mov.value = 'SubIne'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addCurp() {
	var Curp = document.getElementById("txtCurp").value;
	if (Curp == "") {
		swal("Error al guardar", "Debe seleccionar el archivo de la curp.", "error");
		document.getElementById("txtCurp").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta curp?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoc").style.display = 'block';
				document.getElementById("btnCurp").disabled = true;
				document.frm.Mov.value = 'SubCurp'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addBachillerato() {
	var Bachillerato = document.getElementById("txtBachillerato").value;
	if (Bachillerato == "") {
		swal("Error al guardar", "Debe seleccionar su certificado de bachillerato.", "error");
		document.getElementById("txtBachillerato").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este certificado de bachillerato?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoc").style.display = 'block';
				document.getElementById("btnBach").disabled = true;
				document.frm.Mov.value = 'SubBachillerato'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addAutenticidad() {
	var Autenticidad = document.getElementById("txtAutenticidad").value;
	if (Autenticidad == "") {
		swal("Error al guardar", "Debe seleccionar su archivo de autenticidad de certificado.", "error");
		document.getElementById("txtAutenticidad").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta autenticidad de certificado?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoc").style.display = 'block';
				document.getElementById("btnAunt").disabled = true;
				document.frm.Mov.value = 'SubAutenticidad'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}


function val_responderEmail() {
	var Mensaje = document.getElementById("inputExperience").value;
	if (Mensaje == "") {
		swal("Error al guardar", "Debe escribir su respuesta a este correo.", "error");
		document.getElementById("inputExperience").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta autenticidad de certificado?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoc").style.display = 'block';
				document.getElementById("btnResponder").disabled = true;
				document.frm.Mov.value = 'saveRespuesta'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_addFoto() {
	var foto = document.getElementById("foto").value;
	if (foto == "") {
		swal("Error al guardar", "Debe seleccionar su foto tamaño infantil.", "error");
		document.getElementById("foto").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta foto tamaño infantil?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadDoc").style.display = 'block';
				document.getElementById("btnFoto").disabled = true;
				document.frm.Mov.value = 'SubFoto'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}


function ValidarImagenId(obj) {
	var uploadFile = obj.files[0];
	var fileInput = document.getElementById('foto');
	if (!window.FileReader) {
		swal("Error", "El navegador no soporta la lectura de archivos.", "error");
		return;
	}

	if (!(/\.(jpg|png|gif)$/i).test(uploadFile.name)) {
		swal("Error", "El archivo a adjuntar no es una imagen.", "error");
		document.getElementById("foto").value = '';
	}
	else {
		var img = new Image();
		img.onload = function () {
			if (this.width.toFixed(0) != 100 && this.height.toFixed(0) != 115) {
				document.getElementById("foto").value = '';
				document.getElementById("foto").focus();
				swal("Error", "Las medidas deben ser de : 100 * 115 px", "error");
			}
			// alert('Imagen correcta :)')
			if (fileInput.files && fileInput.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					document.getElementById('imagePreview').innerHTML = '<img class="profile-user-img img-responsive img-circle" src="' + e.target.result + '"/>';
				};
				reader.readAsDataURL(fileInput.files[0]);
			}

		};
		img.src = URL.createObjectURL(uploadFile);
	}
}

function validarFirma(obj) {
	var uploadFile = obj.files[0];
	var fileInput = document.getElementById('firma');
	if (!window.FileReader) {
		swal("Error", "El navegador no soporta la lectura de archivos.", "error");
		return;
	}

	if (!(/\.(jpg|png)$/i).test(uploadFile.name)) {
		swal("Error", "El archivo a adjuntar no es una imagen.", "error");
		document.getElementById("firma").value = '';
	}
}

function valImagenPago(obj, nombre) {
	var uploadFile = obj.files[0];
	var fileInput = document.getElementById(nombre);
	if (!window.FileReader) {
		swal("Error", "El navegador no soporta la lectura de archivos.", "error");
		return;
	}

	if (!(/\.(jpg|png)$/i).test(uploadFile.name)) {
		swal("Error", "El archivo a adjuntar no es una imagen.", "error");
		document.getElementById(nombre).value = '';
	}
	else {
		var img = new Image();
		img.onload = function () {
			// if (this.width.toFixed(0) != 100 && this.height.toFixed(0) != 115) {
			// 		document.getElementById(nombre).value='';
			// 		document.getElementById(nombre).focus();
			// 		swal("Error", "Las medidas deben ser de : 100 * 115 px", "error");
			// }
			// alert('Imagen correcta :)')
			// if (fileInput.files && fileInput.files[0]) {
			//     var reader = new FileReader();
			//     reader.onload = function(e) {
			//         document.getElementById('imagePreview').innerHTML = '<img class="profile-user-img img-responsive img-circle" src="'+e.target.result+'"/>';
			//     };
			// reader.readAsDataURL(fileInput.files[0]);
			// }

		};
		img.src = URL.createObjectURL(uploadFile);
	}
}

function validarPlan(obj, nombre) {
	var uploadFile = obj.files[0];
	var fileInput = document.getElementById(nombre);
	if (!window.FileReader) {
		swal("Error", "El navegador no soporta la lectura de archivos.", "error");
		return;
	}

	if (!(/\.(png)$/i).test(uploadFile.name)) {
		swal("Error", "El archivo a adjuntar no es una imagen.", "error");
		document.getElementById(nombre).value = '';
	}
	else {
		var img = new Image();
		img.onload = function () {
			if (this.width.toFixed(0) != 100 && this.height.toFixed(0) != 100) {
				document.getElementById(nombre).value = '';
				document.getElementById(nombre).focus();
				swal("Error", "Las medidas de la imagen deben ser de: 100*100 px", "error");
			}
		};
		img.src = URL.createObjectURL(uploadFile);
	}
}



function validarPDF(obj, nombre) {
	var uploadFile = obj.files[0];
	if (!window.FileReader) {
		swal("Error", "El navegador no soporta la lectura de archivos.", "error");
		return;
	}

	if (!(/\.(pdf|docx|doc|jpg|png)$/i).test(uploadFile.name)) {
		swal("Error de archivo", "Porfavor, cargue solamente archivo .pdf | .jpg | .png", "error");
		document.getElementById(nombre).value = '';
		document.getElementById(nombre).focus();
	}
	else {
		var img = new Image();
		if (uploadFile.size > 10000000) {
			swal("Error", "El peso del archivo debe ser menos a 10 MB.", "error");
			document.getElementById(nombre).value = '';
			document.getElementById(nombre).focus();
		}
		else {
			// alert('Imagen correcta :)')
		}
		// };
		img.src = URL.createObjectURL(uploadFile);
	}
}

function validarExcel(obj, nombre) {
	var uploadFile = obj.files[0];
	if (!window.FileReader) {
		swal("Error", "El navegador no soporta la lectura de archivos.", "error");
		return;
	}

	if (!(/\.(xls|xlsx)$/i).test(uploadFile.name)) {
		swal("Error", "Porfavor, cargue solamente excel .xls, .xlsx", "error");
		document.getElementById(nombre).value = '';
		document.getElementById(nombre).focus();
	}
	else {
		var img = new Image();
		if (uploadFile.size > 10000000) {
			swal("Error", "El peso del archivo debe ser menos a 10 MB.", "error");
			document.getElementById(nombre).value = '';
			document.getElementById(nombre).focus();
		}
		else {
			// alert('Imagen correcta :)')
		}
		// };
		img.src = URL.createObjectURL(uploadFile);
	}
}

function val_addCal() {
	var Archivo = document.getElementById("txtArchivo").value;


	if (Archivo == "") {
		swal("Error al guardar", "Debe seleccionar el archivo excel.", "error");
		document.getElementById("txtArchivo").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo de excel con calificaciones?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("imgLoadPagos").style.display = 'block';
				document.frm.Mov.value = 'subCal'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});
}

function val_saveCal(IdGrupo, IdCampus) {
	var Oferta = document.frm.txtOferta.value;
	var Modulo = document.frm.txtModulo.value;
	var IdCiclo = document.frm.txtCiclo.value;
	var IdUsua = document.frm.IdUsua.value;
	var IdDocente = document.frm.txtDocente.value;
	var Fecha = document.frm.txtFecha.value;
	if (Oferta == '') {
		swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
		document.getElementById("txtOferta").focus();
		return 0;
	}
	if (Modulo == '') {
		swal("Error al guardar", "Debe seleccionar la asignatura.", "error");
		document.getElementById("txtModulo").focus();
		return 0;
	}
	if (IdCiclo == '') {
		swal("Error al guardar", "Debe seleccionar el ciclo escolar.", "error");
		document.getElementById("txtCiclo").focus();
		return 0;
	}
	if (IdDocente == '') {
		swal("Error al guardar", "Debe seleccionar el docente que impartio la clase.", "error");
		document.getElementById("txtDocente").focus();
		return 0;
	}
	if (Fecha == '') {
		swal("Error al guardar", "Debe seleccionar la fecha en la que el docente subio las calificaciones.", "error");
		document.getElementById("txtFecha").focus();
		return 0;
	}

	var TipoGuardar = 'sub_ex_cal_final';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estas calificaciones?",
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
					url: "formConsulta/setting_upload_grupo.php",
					method: "POST",
					data: { TipoGuardar: TipoGuardar, IdUsua: IdUsua, Oferta: Oferta, Modulo: Modulo, IdCiclo: IdCiclo, IdDocente: IdDocente, Fecha: Fecha, IdGrupo: IdGrupo, IdCampus: IdCampus },
					success: function (data) {

					}
				})

					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "La calificación se ha guardado correctamente.", "success");
							parent.location.href = 'addSubirCal.php';
						} else {
							swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});
}





function val_delCalExc() {
	var IdUsua = document.frm.IdUsua.value;

	var Tipo = 'val_delCalExcel';
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar todos estos usuarios con calificaciones?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							//document.getElementById(IdGrupo).style.display = 'none';
							swal("Eliminado correctamente", "Lista de usuarios en proceso eliminados correctamente.", "success");
							document.getElementById("tbtabl59").style.display = 'none';
							//

						} else {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x16", "No se puede eliminar el prospecto en proceso.", "error");
					});
			}
		});
}


function validarComprimido(obj, nombre) {
	var uploadFile = obj.files[0];
	if (!window.FileReader) {
		swal("Error", "El navegador no soporta la lectura de archivos.", "error");
		return;
	}

	if (!(/\.(rar|zip)$/i).test(uploadFile.name)) {
		swal("Error", "Porfavor, cargue la factura comprimida en archivo .rar | .zip", "error");
		document.getElementById('txtDocumento').value = '';
		document.getElementById('txtDocumento').focus();
	}
	else {
		var img = new Image();
		if (uploadFile.size > 10000000) {
			swal("Error", "El peso del archivo debe ser menos a 10 MB.", "error");
			document.getElementById('txtDocumento').value = '';
			document.getElementById('txtDocumento').focus();
		}
		else {
			// alert('Imagen correcta :)')
		}
		// };
		img.src = URL.createObjectURL(uploadFile);
	}
}

function validarComprimido_pdf(obj, nombre) {
	var uploadFile = obj.files[0];
	if (!window.FileReader) {
		swal("Error", "El navegador no soporta la lectura de archivos.", "error");
		return;
	}

	if (!(/\.(pdf|rar|zip)$/i).test(uploadFile.name)) {
		swal("Error", "Porfavor, cargue la factura comprimida en archivo .pdf | .rar | .zip", "error");
		document.getElementById('txtDocumento').value = '';
		document.getElementById('txtDocumento').focus();
	}
	else {
		var img = new Image();
		if (uploadFile.size > 10000000) {
			swal("Error", "El peso del archivo debe ser menos a 10 MB.", "error");
			document.getElementById('txtDocumento').value = '';
			document.getElementById('txtDocumento').focus();
		}
		else {
			// alert('Imagen correcta :)')
		}
		// };
		img.src = URL.createObjectURL(uploadFile);
	}
}


function validarVideo(obj, nombre) {
	var uploadFile = obj.files[0];
	if (!window.FileReader) {
		swal("Error", "El navegador no soporta la lectura de archivos.", "error");
		return;
	}

	if (!(/\.(mp4|mp3|wmv)$/i).test(uploadFile.name)) {
		swal("Error", "Porfavor, cargue solamente archivo .mp4 | .mp3", "error");
		document.getElementById(nombre).value = '';
		document.getElementById(nombre).focus();
	}
	else {
		var img = new Image();
		if (uploadFile.size > 100000000) {
			swal("Error", "El peso del archivo debe ser menos a 100 MB.", "error");
			document.getElementById(nombre).value = '';
			document.getElementById(nombre).focus();
		}
		else {
			// alert('Imagen correcta :)')
		}
		// };
		img.src = URL.createObjectURL(uploadFile);
	}
}

function validarPDFCo(obj, nombre) {
	var uploadFile = obj.files[0];
	if (!window.FileReader) {
		swal("Error", "El navegador no soporta la lectura de archivos.", "error");
		return;
	}

	if (!(/\.(pdf)$/i).test(uploadFile.name)) {
		swal("Error", "Porfavor, cargue solamente archivo .pdf", "error");
		document.getElementById(nombre).value = '';
		document.getElementById(nombre).focus();
	}
	else {
		var img = new Image();
		if (uploadFile.size > 10000000) {
			swal("Error", "El peso del archivo debe ser menos a 10 MB.", "error");
			document.getElementById(nombre).value = '';
			document.getElementById(nombre).focus();
		}
		else {
			// alert('Imagen correcta :)')
		}
		// };
		img.src = URL.createObjectURL(uploadFile);
	}
}

function val_cveGrupo() {
	var TipoGuardar = "add_cveGrupoT";
	var CveGrupo = document.frm.txtGrupoAdd.value;
	var IdAlumno = document.frm.IdAlumno.value;
	var Oferta = document.frm.txtOferta.value;
	var Campus = document.frm.IdCampus.value;

	if (document.frm.txtGrupoAdd.value.length == '') {
		swal("Error al guardar", "Debe seleccionar la clave de grupo.", "error");
		document.getElementById("txtGrupoAdd").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea asigar este alumno a este grupo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&CveGrupo=' + CveGrupo + '&IdAlumno=' + IdAlumno;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Clave de grupo asignado correctamente", "success");
							document.getElementById("frm").reset();
							parent.location.href = 'ctrlCrearGrupo.php?C=' + Campus + '&O=' + Oferta; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al guardar", "No se puede guardar", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x17", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function val_cerrarGrupo() {
	var TipoGuardar = "add_cerrarGrupoX";
	var Oferta = document.frm.txtOferta.value;
	var IdGrupo = document.frm.txtGrupoCer.value;

	if (document.frm.txtGrupoCer.value.length == '') {
		swal("Error al guardar", "Debe seleccionar la clave de grupo a cerrar.", "error");
		document.getElementById("txtGrupoCer").focus();
		return 0;
	}

	swal({
		title: "Est\u00E1 seguro que desea cerrar este grupo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdGrupo=' + IdGrupo + '&Oferta=' + Oferta;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Grupo cerrado correctamente.", "success");
							document.getElementById("frm").reset();
							parent.location.href = 'ctrlCrearGrupo.php'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al guardar", "No se puede cerrar grupo.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x18", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function delRecargo(IdPago, IdUsua, IdRecargo) {
	var TipoGuardar = "del_recargo";
	var Token = '4587598645' + IdUsua;
	swal({
		title: "Est\u00E1 seguro que desea eliminar este recargo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdPago=' + IdPago + '&IdUsua=' + IdUsua + '&IdRecargo=' + IdRecargo;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Eliminado correctamente", "El recargo se ha eliminado correctamente.", "success");
							$.ajax({
								url: "formConsulta/addPago.php",
								method: "POST",
								data: { Token: Token, IdPago: IdPago },
								success: function (data) {
									$('#employee_detail7').html(data);
									$('#dataModal7').modal('show');
								}
							});
						}
						if (data == 0) {
							swal("Error al eliminar", "No se puede eliminar recargo.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x18", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function addFiltro(Filtro, Tabla, IdPago, IdUsua, IdRecargo) {
	var Token = '4587598645' + IdUsua;

	var TipoGuardar = "addFiltro";
	var datos = 'TipoGuardar=' + TipoGuardar + '&Filtro=' + Filtro + '&Tabla=' + Tabla + '&IdPago=' + IdPago + '&IdUsua=' + IdUsua + '&IdRecargo=' + IdRecargo;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {
			//alert(data);
		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Consulta generada correctamente.", "success");
				$.ajax({
					url: "formConsulta/addPago.php",
					method: "POST",
					data: { Token: Token, IdPago: IdPago },
					success: function (data) {
						$('#employee_detail7').html(data);
						$('#dataModal7').modal('show');
					}
				});
			}
			if (data == 0) {
				swal("Error al guardar", "No se puede cerrar guardar|.", "error");
			}
		})
		.error(function (data) {
			swal("Error al guardar 0x18", "No se puede guardar, comuniquese con el desarrollador.", "error");
		});

}



function val_cerrarEstatus() {
	var IdGrado = document.getElementById("IdGrado").value;
	var Fecha = document.getElementById("datepicker3").value;
	var IdOferta = document.getElementById("txtOferta").value;
	var IdAlumno = document.getElementById("IdAlumno").value;
	//var Fecha = document.getElementById("datepicker").value;
	var pago1 = document.getElementById("pago1").value;
	var pago2 = document.getElementById("pago2").value;
	var pag1 = "txtPrecio-" + pago1;
	var pag2 = "txtPrecio-" + pago2;

	var Inscripcion = document.getElementById(pag1).value;
	var Colegiatura = document.getElementById(pag2).value;
	var TipoGuardar = "cerrarEstatus";

	if (Fecha == '') {
		swal("Error al guardar", "Debe seleccionar la fecha l\u00EDmite de pago.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea cerrar estatus y generar fichas de pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdAlumno=' + IdAlumno + '&Inscripcion=' + Inscripcion + '&Colegiatura=' + Colegiatura + '&Fecha=' + Fecha + "&IdGrado=" + IdGrado;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})

					.done(function (data) {
						if (data) {
							swal({
								title: "Proceso ejecutado correctamente.",
								type: "success",
								confirmButtonColor: '#DD6B55',
								confirmButtonText: 'Aceptar',
							},
								function (isConfirm) {
									if (isConfirm) {
										parent.location.href = 'ctrlProspectos.php?Id=' + IdOferta
									}
								});
						} else {
							swal("Error", "No se pueden enviar sus datos", "error");

						}
					})


					.error(function (data) {
						swal("Error al guardar 0x19", "No se puede guardar, comuniquese con el desarrollador", "error");
					});
			}

		});
}



function val_clServicio() {
	var IdUsua = document.getElementById("IdDocente").value;
	var NomPrograma = document.getElementById("txtNomPrograma").value;
	var NomDependencia = document.getElementById("txtNomDependencia").value;
	var Periodo = document.getElementById("txtPeriodo").value;
	var Registro = document.getElementById("txtRegistro").value;
	var Fecha = document.getElementById("datepicker").value;

	if (NomPrograma == '') {
		swal("Error al guardar", "Debe escribir el nombre del programa.", "error");
		document.getElementById("txtNomPrograma").focus();
		return 0;
	}
	if (NomDependencia == '') {
		swal("Error al guardar", "Debe escribir el nombre de la instituci\u00F3n.", "error");
		document.getElementById("txtNomDependencia").focus();
		return 0;
	}
	if (Periodo == '') {
		swal("Error al guardar", "Debe escribir el periodo.", "error");
		document.getElementById("txtPeriodo").focus();
		return 0;
	}
	if (Registro == '') {
		swal("Error al guardar", "Debe escribir el # de registro.", "error");
		document.getElementById("txtRegistro").focus();
		return 0;
	}
	if (Fecha == '') {
		swal("Error al guardar", "Debe seleccionar la de impresi\u00F3n.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}
	var TipoGuardar = "closeServicio";

	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar estos datos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&NomPrograma=' + NomPrograma + '&NomDependencia=' + NomDependencia + '&Periodo=' + Periodo + '&Fecha=' + Fecha + '&IdUsua=' + IdUsua + '&Registro=' + Registro;
				//var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdAlumno=' + IdAlumno + '&Inscripcion=' + Inscripcion + '&Colegiatura=' + Colegiatura + '&Fecha=' + Fecha + "&IdGrado="+IdGrado ;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Datos guardados correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = 'docVerificar.php?Id=5755223445' + IdUsua + '&Tramite=SS'; //direcciona la pagina madre
						}
						if (data == "0") {
							swal("Erroral guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x20", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function val_cerrarComprb() {
	var IdUsua = document.getElementById("IdUsua").value;
	var Forma = document.getElementById("txtForma").value;
	var IdPago = document.getElementById("IdPago").value;
	var Comentario = document.getElementById("txtComentario").value;
	var Fecha = document.getElementById("datepicker").value;
	var IdBanco = document.getElementById("txtEstatus").value;
	var Pago = document.getElementById("txtPago").value;
	var TPagar = document.getElementById("txtTPagar").value;
	var Folio = document.getElementById("txtFolio").value;
	var TipoGuardar = "cerrarComprb";
	if (IdBanco == '') {
		swal("Error al guardar", "Debe seleccionar el estatus del pago.", "error");
		document.getElementById("txtEstatus").focus();
		return 0;
	}

	if (Forma == '') {
		swal("Error al guardar", "Debe seleccionar la forma de pago.", "error");
		document.getElementById("txtForma").focus();
		return 0;
	}
	if (Fecha == '') {
		swal("Error al guardar", "Debe seleccionar la fecha de pago.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}
	if (Pago == 0) {
		swal("Error al guardar", "Debe seleccionar los pagos que va a realizar.", "error");
		return 0;
	}
	if (Folio == 0) {
		swal("Error al guardar", "Debe escribir el folio del pago.", "error");
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos de este pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',

	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdPago=' + IdPago + '&Comentario=' + Comentario + '&Forma=' + Forma + '&IdUsua=' + IdUsua + '&Fecha=' + Fecha + '&IdBanco=' + IdBanco + '&Pago=' + Pago + '&Folio=' + Folio;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Estatus de comprobante guardado correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = 'perfil.php?token=' + IdUsua;
						}
						if (data == 0) {
							swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function val_cerrarPagoT(IdAdmin) {
	var IdUsuaCap = document.getElementById("IdUsuaCap").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var Forma = document.getElementById("txtFormaT5").value;
	var Fecha = document.getElementById("datepickert5").value;
	var TPagar = document.getElementById("TPagar").value;
	// var Descuento = document.getElementById("txtDescuento").value;
	var Division = document.getElementById("Division").value;
	var Folio = document.getElementById("txt_recibo").value;
	var Monto = document.getElementById("txt_monto").value;
	var Banco = document.getElementById("valor_banco").value;
	var Nota = document.getElementById("txt_nota").value;
	var IdProcedencia = document.getElementById("txt_procedencia").value;
	var IdBanco = 0;
	var TipoGuardar = "todosPagos";

	if (Monto == '') {
		swal("Error al guardar", "Debe escribir el monto a pagar.", "error");
		document.getElementById("txt_monto").focus();
		return 0;
	}
	if (Forma == '') {
		swal("Error al guardar", "Debe seleccionar la forma de pago.", "error");
		document.getElementById("txtFormaT5").focus();
		return 0;
	}
	if (Fecha == '') {
		swal("Error al guardar", "Debe seleccionar la fecha de pago.", "error");
		document.getElementById("datepickert5").focus();
		return 0;
	}
	if (TPagar == 0) {
		swal("Error al guardar", "Debe seleccionar los pagos que va a realizar.", "error");
		return 0;
	}
	if (Banco == 1) {
		var IdBanco = document.getElementById("txt_banco").value;

		if (IdBanco == '') {
			swal("Error al guardar", "Debe seleccionar el banco.", "error");
			document.getElementById("txt_banco").focus();
			return 0;
		}
	} else {
		IdBanco = 1;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos de este pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',

	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&Forma=' + Forma + '&IdUsua=' + IdUsua + '&Fecha=' + Fecha + '&IdUsuaCap=' + IdUsuaCap + '&Division=' + Division + '&TPagar=' + Monto + '&IdBanco=' + IdBanco + '&Nota=' + Nota + '&IdProcedencia=' + IdProcedencia + '&IdAdmin=' + IdAdmin + '&Folio=' + Folio;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Estatus de comprobante guardado correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = 'cobrar.php?token=' + IdUsua;
						}
						if (data == 2) {
							swal("Error al procesar", "El folio de recibo ingresado ya existe en la plataforma.", "error");
							//document.getElementById("frm").reset();

						}
						if (data == 0) {
							swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}



function val_saldoIni(IdUsua, IdAdmin) {
	var IdBanco = 0;
	var IdProcedencia = 0;
	var Forma = document.getElementById("txtForma").value;
	var IdPago = document.getElementById("IdPago").value;
	var Comentario = document.getElementById("txtComentario").value;
	var Fecha = document.getElementById("datepicker").value;
	var IdEstatus = document.getElementById("txtEstatus").value;
	var Pago = document.getElementById("txtPago").value;
	var TPagar = document.getElementById("txtTPagar").value;
	if ((Forma == 2) || (Forma == 3)) {
		var IdBanco = document.getElementById("txt_banco").value;
		var IdProcedencia = document.getElementById("txt_procedencia").value;
	}
	var TipoGuardar = "addSaldIni";
	if (IdEstatus == '') {
		swal("Error al guardar", "Debe seleccionar el tipo de pago.", "error");
		document.getElementById("txtEstatus").focus();
		return 0;
	}
	if (Forma == '') {
		swal("Error al guardar", "Debe seleccionar la forma de pago.", "error");
		document.getElementById("txtForma").focus();
		return 0;
	}
	if (Fecha == '') {
		swal("Error al guardar", "Debe seleccionar la fecha de pago.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}
	if (Pago == 0) {
		swal("Error al guardar", "Debe seleccionar los pagos que va a realizar.", "error");
		return 0;
	}


	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar este pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',

	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdPago=' + IdPago + '&Comentario=' + Comentario + '&Forma=' + Forma + '&IdUsua=' + IdUsua + '&Fecha=' + Fecha + '&IdBanco=' + IdBanco + '&Pago=' + Pago + '&IdProcedencia=' + IdProcedencia + '&IdEstatus=' + IdEstatus + '&IdAdmin=' + IdAdmin;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						// alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Estatus de comprobante guardado correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = 'cobrar.php?token=0987654321' + IdUsua;
						}
						if (data == 0) {
							swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}




function val_genDescuento() {
	var IdPago = document.getElementById("IdPago").value;
	var Comentario = document.getElementById("txtComentario").value;
	var IdOferta = document.getElementById("txtOferta").value;
	var IdTipoDescuento = document.getElementById("txtIdDescuento").value;
	var Porcentaje = document.getElementById("txtPorcentaje").value;
	var FecLimite = document.getElementById("datepicker").value;
	var IdConcepto = document.getElementById("txtConcepto").value;
	var Descuento = document.getElementById("EnDescuento").value;
	var IdGrupo = document.getElementById("txtGrupo").value;
	var TipoGuardar = "genDescuento";

	if (IdTipoDescuento == '') {
		swal("Error al guardar", "Debe seleccionar el tipo de descuento.", "error");
		document.getElementById("txtEstatus").focus();
		return 0;
	}

	if ((Porcentaje == '') || (Porcentaje == 0)) {
		swal("Error al guardar", "Debe ingresar el porcentaje del descuento.", "error");
		document.getElementById("txtForma").focus();
		return 0;
	}
	if (FecLimite == '') {
		swal("Error al guardar", "Debe seleccionar la fecha l\u00EDmite para este descuento.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}



	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este descuento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdPago=' + IdPago + '&IdTipoDescuento=' + IdTipoDescuento + '&Comentario=' + Comentario + '&Porcentaje=' + Porcentaje + '&FecLimite=' + FecLimite + '&Descuento=' + Descuento;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correcta", "Descuento aplicado correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = 'ctrlVerficarPagos.php?IdO=' + IdOferta + '&IdC=' + IdConcepto + '&IdG=' + IdGrupo; //direcciona la pagina madre
						}
						if (data == 2) {
							swal("Error al guardar", "Este alumno ya cuenta con un descuento vigente.", "info");
							//document.getElementById("frm").reset();
						}
						if (data == 0) {
							swal("Error al guardar", "No se puede generar descuento.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x22", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function val_addPagoNvo() {
	var IdAlumno = document.getElementById("IdAlumno").value;
	var Monto = document.getElementById("txtPagar").value;
	var Porcentaje = document.getElementById("txtPorcentaje").value;
	var FecLimite = document.getElementById("datepicker").value;
	var IdConcepto = document.getElementById("txtConcepto").value;
	var DesGenerado = document.getElementById("DesGenerado").value;
	var TipoGuardar = "addPagoNvo";

	if (IdConcepto == '') {
		swal("Error al guardar", "Debe seleccionar el tipo de concepto.", "error");
		document.getElementById("txtConcepto").focus();
		return 0;
	}

	if (FecLimite == '') {
		swal("Error al guardar", "Debe seleccionar la fecha l\u00EDmite de pago.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea generar este pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdAlumno=' + IdAlumno + '&Porcentaje=' + Porcentaje + '&FecLimite=' + FecLimite + '&IdConcepto=' + IdConcepto + '&Monto=' + Monto + '&DesGenerado=' + DesGenerado;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 3) {
							swal("Error al genera pago", "Ya existe un pago con este concepto, favor de verificar.", "error");
						}
						if (data == 1) {
							swal("Generado correcta", "Pago generado correctamente.", "success");
							$('#dataModal4').modal('hide');
						}
						if (data == 0) {
							swal("Error al generar", "No se puede generar pago.", "error");
							$('#dataModal4').modal('hide');
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x23", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function val_closePagoNvo() {
	var IdAlumno = document.getElementById("IdAlumno").value;
	var TipoGuardar = "closePagoNvo";

	swal({
		title: "\u00BFEst\u00E1 seguro que desea cerrar los pagos iniciales?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				$(".cancel").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdAlumno=' + IdAlumno;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Cerrado correcta", "Pagos iniciales cerrados correctamente.", "success");
							parent.location.href = 'cltrPagoIngreso.php'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al cerrar", "No se puede cerrar pagos iniciales, debe generar 2 conceptos de pago.", "error");
							//parent.location.href='cltrPagoIngreso.php'; //direcciona la pagina madre
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x24", "No se puede cerrar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function val_modCalifi() {
	var IdCalificacion = document.getElementById("IdCalificacion").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var Calificacion = document.getElementById("txtCalificacion").value;
	var Pass1 = document.getElementById("txtPass1").value;
	var Pass2 = document.getElementById("txtPass2").value;
	var TipoGuardar = "modCalificacion";

	if (Calificacion == '') {
		swal("Error al guardar", "Debe escribir la calificaci\u00F3n.", "error");
		document.getElementById("txtCalificacion").focus();
		return 0;
	}

	if (Pass1 == '') {
		swal("Error al guardar", "Debe ingresar la contraseña del administrador.", "error");
		document.getElementById("txtPass1").focus();
		return 0;
	}
	if (Pass2 == '') {
		swal("Error al guardar", "Debe ingresar la conntraseña del acad\u00E9mico.", "error");
		document.getElementById("txtPass2").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar esta calificaci\u00F3n?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdCalificacion=' + IdCalificacion + '&IdUsua=' + IdUsua + '&Calificacion=' + Calificacion + '&Pass1=' + Pass1 + '&Pass2=' + Pass2;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Calificaci\u00F3n actualizada correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = 'adSelAlumnoH.php'; //direcciona la pagina madre
						}
						if (data == 2) {
							swal("Error al guardar", "Ha ocurrido un error, verifique las contraseñas.", "info");
							//document.getElementById("frm").reset();
						}
						if (data == 0) {
							swal("Error al guardar", "Ha ocurrido un error, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x23", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function val_modFecha() {
	var Oferta = document.getElementById("Oferta").value;
	var Comentario = document.getElementById("txtComentario").value;
	var Grupo = document.getElementById("Grupo").value;
	var Concepto = document.getElementById("Concepto").value;
	var Fecha = document.getElementById("Fecha").value;
	var FecLimite = document.getElementById("datepicker").value;
	var TipoGuardar = "modFecha";

	if (FecLimite == '') {
		swal("Error al guardar", "Debe seleccionar la fecha l\u00EDmite.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}

	if (FecLimite < Fecha) {
		swal("Error al guardar", "La fecha debe ser mayor a la actual.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea modificar la fecha l\u00CDmite?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&Oferta=' + Oferta + '&Grupo=' + Grupo + '&Comentario=' + Comentario + '&Concepto=' + Concepto + '&FecLimite=' + FecLimite;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//		alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "Fecha actualizado correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = 'ctrlVerficarPagos.php?IdO=' + Oferta + '&IdC=' + Concepto + '&IdG=' + Grupo; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al actualizar 0x24", "No se puede actualizar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function val_docComprobacion() {
	var IdDocumento = document.getElementById("IdDocumento").value;
	var Estatus = document.getElementById("txtEstatus").value;
	var IdDocente = document.getElementById("IdDocente").value;
	var Tipo = document.getElementById("Tipo").value;
	var Tramite = document.getElementById("Tramite").value;

	var TipoGuardar = "docComprobante";

	if (Estatus == '') {
		swal("Error al guardar", "Debe seleccionar el estatus del documento.", "error");
		document.getElementById("txtEstatus").focus();
		return 0;
	}



	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos cambios?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&Estatus=' + Estatus + '&IdDocumento=' + IdDocumento + '&Tipo=' + Tipo + "&Tramite=" + Tramite;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//		alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Estatus de comprobante guardado correctamente.", "success");
							//document.getElementById("frm").reset();
							if (Tramite == "SS") {
								parent.location.href = 'docVerificar.php?IdUsua=8548787878' + IdDocente; //direcciona la pagina madre
							} else {
								parent.location.href = 'docVerificar.php?IdUsua=8548787878' + IdDocente; //direcciona la pagina madre
							}

						}
						if (data == 0) {
							swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x25", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}



function val_delDocumento(Vaia, IdDocumento) {
	var TipoGuardar = "delDocumentoDoc";

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este documento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdDocumento=' + IdDocumento;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//		alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Eliminado correctamente", "Documentos eliminado correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = 'misDocDocente.php'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x27", "No se puede eliminar, comuniquese con el administrador.", "error");
					});
			}

		});
}

function val_delDocAlumno(Vaia, IdDocumento) {
	var link = "";
	var TipoGuardar = "delDocAlumno";
	var Tramite = document.getElementById("Tramite").value;
	var Tipo = document.getElementById("Tipo").value;
	if (Tramite == "SS") {
		link = "misServicios.php";
	} else {
		link = "misDocumentos.php";
	}

	if (Tipo == 33) {
		link = "misServicios.php";
	}
	if (Tipo == 45) {
		link = "miBaja.php";
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este documento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdDocumento=' + IdDocumento + "&Tramite=" + Tramite;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//		alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Eliminado correctamente", "Documento eliminado correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = link; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x29", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function val_del_doc_trami(IdDocumento) {
	var TipoGuardar = "del_docs_tramite";

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este documento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdDocumento=' + IdDocumento;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Eliminado correctamente", "Documento eliminado correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = 'misTramites'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
							parent.location.href = 'misTramites'; //direcciona la pagina madre
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x29", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function val_delDocAspirante(Vaia, IdDocumento) {
	var link = "";
	var TipoGuardar = "delDocAspirante";
	var Tramite = "d";
	link = "registroDoc.php";

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este documento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdDocumento=' + IdDocumento + "&Tramite=" + Tramite;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Eliminado correctamente", "Documento eliminado correctamente.", "success");
							//document.getElementById("frm").reset();
							parent.location.href = link; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x30", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function val_number(valor, nombre) {
	var numero = valor.value;
	if (isNaN(numero)) {
		swal("Dato err\u00F3neo", "El dato ingresado no es un n\u00FAmero.", "error");
		document.getElementById("txtPorcentaje").value = "";
		document.getElementById("txtPorcentaje").focus();
		return 0;
	}

	if (numero > 100) {
		swal("ERROR", "El n\u00FAmero ingresado no debe ser mayor a 100.", "error");
		document.getElementById("txtPorcentaje").value = "";
		document.getElementById("txtTotal").value = "";
		document.getElementById("txtMontoDesc").value = "";
		document.getElementById("txtPorcentaje").focus();
	}
	if (numero < 0) {
		swal("ERROR", "El n\u00FAmero ingresado no debe ser menor a 0.", "error");
		document.getElementById("txtPorcentaje").value = "";
		document.getElementById("txtPorcentaje").focus();
	}
}

function val_calDescuento(valor, nombre, pagar) {
	var numero = valor.value;
	var pagar = pagar.value;

	if (isNaN(numero)) {
		swal("Dato err\u00F3neo", "El dato ingresado no es un n\u00FAmero.", "error");
		document.getElementById("txtPorcentaje").value = "0";
		document.getElementById("txtDescuento").value = "0";
		document.getElementById("txtTotalPagar").value = pagar;
		return 0;
	}

	if (numero > 100) {
		swal("ERROR", "El n\u00FAmero ingresado no debe ser mayor a 100.", "error");
		document.getElementById("txtPorcentaje").value = "0";
		document.getElementById("txtDescuento").value = "0";
		document.getElementById("txtTotalPagar").value = pagar;
		document.getElementById("txtPorcentaje").focus();
	}
	if (numero < 0) {
		swal("ERROR", "El n\u00FAmero ingresado no debe ser menor a 0.", "error");
		document.getElementById("txtPorcentaje").value = "0";
		document.getElementById("txtDescuento").value = "0";
		document.getElementById("txtTotalPagar").value = pagar;
		document.getElementById("txtPorcentaje").focus();
	}
}

function val_numeross(valor, nombre) {
	var numero = valor.value;
	if (isNaN(numero)) {
		swal("Error al guardar", "El dato ingresado no es un numero", "error");
		document.getElementById("txtCalificacion").value = "";
		document.getElementById("txtCalificacion").focus();
		return 0;
	}

	if (numero > 10) {
		swal("Error al guardar", "El numero ingresado debe ser menor a 10", "error");
		document.getElementById("txtCalificacion").value = "";
		document.getElementById("txtCalificacion").focus();
	}
	if (numero < 0) {
		swal("Error al guardar", "El numero ingresado no debe ser menor a 0", "error");
		document.getElementById("txtCalificacion").value = "";
		document.getElementById("txtCalificacion").focus();
	}
}

function val_beca(valor, nombre) {
	var numero = valor.value;
	if (isNaN(numero)) {
		swal("Error al guardar", "El dato ingresado no es un numero", "error");
		document.getElementById("txtBeca").value = "";
		document.getElementById("txtBeca").focus();
		return 0;
	}

	if (numero > 101) {
		swal("Error al guardar", "El maximo porcentaje ingresado debe ser del 100%.", "error");
		document.getElementById("txtBeca").value = "";
		document.getElementById("txtBeca").focus();
	}
	if (numero < 0) {
		swal("Error al guardar", "El porcentaje ingresado no debe ser menor a 0%.", "error");
		document.getElementById("txtBeca").value = "";
		document.getElementById("txtBeca").focus();
	}

}

function saveConfig(sel, valor, id) {
	var valorIngreso = valor.value;
	var TipoGuardar = "saveConfigur";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar esta informacion?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&valorIngreso=' + valorIngreso + "&id=" + id;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "Datos actualizados correctamente.", "success");
							if (id == 16) {
								parent.location.href = 'adPlataforma.php'; //direcciona la pagina madre
							}
						}
						if (data == 0) {
							swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al actualizar 0x30", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function saveCostoCpt(sel, valor, campo, idconcepto) {
	var valorIngreso = valor.value;
	var TipoGuardar = "saveConcepto";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este precio?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&valorIngreso=' + valorIngreso + "&campo=" + campo + "&idconcepto=" + idconcepto;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "Precio de concepto agregado correctamente.", "success");
						}
						if (data == 0) {
							swal("Error al actualizar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al actualizar 0x30", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function delConcepto(idconcepto) {
	var TipoGuardar = "deleteConcepto";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este concepto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&idconcepto=' + idconcepto;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Eliminado correctamente", "Concepto eliminado correctamente.", "success");
							parent.location.href = 'adConceptos.php'; //direcciona la pagina madre
						}
						if (data == 2) {
							swal("Error al eliminar", "No se puede eliminar, el concepto ya tiene registros.", "error");
						}
					})
					.error(function (data) {
						swal("Error al eliminar 0x60", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function saveNewDocs(sel, valor) {
	var Grado = document.getElementById("txtGrado").value;

	if (Grado == '') {
		swal("Error al guardar", "Debe seleccionar el grado de estudio.", "error");
		document.getElementById("txtGrado").focus();
		return 0;
	}
	var valorIngreso = valor.value;
	var TipoGuardar = "saveNewDocs";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este nuevo documento?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&valorIngreso=' + valorIngreso + '&Grado=' + Grado;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Agregado correctamente", "Documento dado de alta correctamente.", "success");
							parent.location.href = 'adDocsSolici.php?Grado=' + Grado; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al actualizar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al actualizar 0x30", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function saveConceptoN(sel, valor) {
	var valorIngreso = valor.value;

	var Nombre = document.getElementById("txtNombre").value;

	var TipoGuardar = "docContrato";

	if (Nombre == '') {
		swal("Error al guardar", "Debe escribir el nombre del concepto.", "error");
		document.getElementById("txtNombre").focus();
		return 0;
	}

	var TipoGuardar = "saveConceptoN";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este nuevo concepto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&valorIngreso=' + valorIngreso;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Agregado correctamente", "Concepto dado de alta correctamente.", "success");
							parent.location.href = 'adConceptos.php'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al actualizar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al actualizar 0x30", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function saveBanco() {
	var IdCampus = document.getElementById("IdCampus").value;
	var Nombre = document.getElementById("txtNombre").value;
	var Convenio = document.getElementById("txtConvenio").value;
	var Banco = document.getElementById("txtBanco").value;
	var Cuenta = document.getElementById("txtCuenta").value;
	var Clabe = document.getElementById("txtClabe").value;

	if (Nombre == '') {
		swal("Error al guardar", "Debe escribir el nombre de la cuenta.", "error");
		document.getElementById("txtNombre").focus();
		return 0;
	}

	if (Banco == '') {
		swal("Error al guardar", "Debe escribir el nombre del banco.", "error");
		document.getElementById("txtBanco").focus();
		return 0;
	}

	var TipoGuardar = "savBanco";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta nueva cuenta de banco?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&Nombre=' + Nombre + '&Banco=' + Banco + '&Cuenta=' + Cuenta + '&Clabe=' + Clabe + '&Convenio=' + Convenio + '&IdCampus=' + IdCampus;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Agregado correctamente", "Cuenta de banco agregado correctamente.", "success");
							parent.location.href = 'adBancos.php'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function saveParcial() {
	var NoParcial = document.getElementById("txtEtiqueta").value;
	var Tema = document.getElementById("txtTema").value;
	var Objetivo = document.getElementById("txtObjetivoP").value;
	var IdOferta = document.getElementById("IdOferta").value;
	var IdModulo = document.getElementById("IdModulo").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var FIni = document.getElementById("datepicker1Xp").value;
	var FFin = document.getElementById("datepicker2Xp").value;
	var Texto1 = "";
	var Texto2 = "";
	var Texto3 = "";
	if ((NoParcial == 11) || (NoParcial == 12)) {
		Texto1 = "Este extraordinario ya existe, favor de verificar.";
		Texto2 = "Extraordinario creado correctamente.";
		Texto3 = "extraordinario?";
	} else {
		Texto1 = "Este parcial ya existe, favor de verificar.";
		Texto2 = "Parcial creado correctamente.";
		Texto3 = "parcial?";
	}

	if (NoParcial == '') {
		swal("Error al guardar", "Debe escribir el nombre de la etiqueta que desea crear.", "error");
		document.getElementById("txtEtiqueta").focus();
		return 0;
	}

	if (Tema == '') {
		swal("Error al guardar", "Debe escribir el tema principal.", "error");
		document.getElementById("txtTema").focus();
		return 0;
	}

	if (Objetivo == '') {
		swal("Error al guardar", "Debe escribir el objetivo espec\u00EDfico.", "error");
		document.getElementById("txtObjetivoP").focus();
		return 0;
	}

	if (FIni == '') {
		swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
		document.getElementById("datepicker1Xp").focus();
		return 0;
	}

	if (FFin == '') {
		swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
		document.getElementById("datepicker2Xp").focus();
		return 0;
	}




	var TipoGuardar = "savParcial";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar \u00E9ste nuevo contenido principal",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdModulo=' + IdModulo + '&NoParcial=' + NoParcial + '&Tema=' + Tema + '&Objetivo=' + Objetivo + '&IdUsua=' + IdUsua + '&IdAsignacion=' + IdAsignacion;
				var datos = $('#frm2iYue').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
					}
				})
					.done(function (data) {
						if (data == 2) {
							swal("Error al crear", Texto1, "error");
						}
						if (data == 1) {
							swal("Guardado correctamente", "Los datos se han guardado correctamente.", "success");
							// swal("Agregado correctamente", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion;

						}
						if (data == 0) {
							swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function updParcial() {

	var IdParcialDoc = document.getElementById("IdParcialDoc").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var NoParcial = document.getElementById("txt_Titulo").value;
	var Tema = document.getElementById("txtTema").value;
	var Objetivo = document.getElementById("txtObjetivoX").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var FIni = document.getElementById("datepicker1XpU").value;
	var FFin = document.getElementById("datepicker2XpU").value;

	if (Tema == '') {
		swal("Error al guardar", "Debe escribir el tema principal.", "error");
		document.getElementById("txtTema").focus();
		return 0;
	}

	if (Objetivo == '') {
		swal("Error al guardar", "Debe escribir el objetivo espec\u00EDfico.", "error");
		document.getElementById("txtObjetivoX").focus();
		return 0;
	}
	if (FIni == '') {
		swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
		document.getElementById("datepicker1XpU").focus();
		return 0;
	}
	if (FFin == '') {
		swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
		document.getElementById("datepicker2XpU").focus();
		return 0;
	}




	var TipoGuardar = "updParcial";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar estos datos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2arTe').serialize();
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdParcialDoc=' + IdParcialDoc + '&Tema=' + Tema + '&Objetivo=' + Objetivo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 2) {
							swal("Error al actualizar", "Ha ocurrido un error, no se ha podido actualizar.", "error");
						}
						if (data == 1) {
							swal("Actualizado correctamente", "Los datos se han actualizado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcialDoc;

						}
						if (data == 0) {
							swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function addAsignaturaT() {

	var IdUsua = document.getElementById("IdUsua").value;
	var CodeModulo = document.getElementById("txtCodeModulo").value;
	var Asignatura = document.getElementById("txtAsignatura").value;


	if (CodeModulo == '') {
		swal("Error al guardar", "Debe escribir el IdAsignatura.", "error");
		document.getElementById("txtCodeModulo").focus();
		return 0;
	}

	if (Asignatura == '') {
		swal("Error al guardar", "Debe escribir nombre de la asignatura.", "error");
		document.getElementById("txtAsignatura").focus();
		return 0;
	}

	var TipoGuardar = "addAsignatura";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta nueva asignatura?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&CodeModulo=' + CodeModulo + '&Asignatura=' + Asignatura;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 2) {
							swal("Error al guardar", "Ha ocurrido un error, la asignatura ya existe.", "error");
						}
						if (data == 1) {
							swal("Agregado correctamente", "La asignatura ha sido creadad correctamente.", "success");
							parent.location.href = 'adAddModConfig.php';
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function saveAsignatura() {
	var Oferta = document.getElementById("txtOferta").value;
	var Campus = document.getElementById("txtCampus").value;
	var Asignatura = document.getElementById("txtAsignatura").value;


	if (Oferta == '') {
		swal("Error al guardar", "Debe seleccionar el plan de estudios.", "error");
		document.getElementById("txtOferta").focus();
		return 0;
	}

	if (Campus == '') {
		swal("Error al guardar", "Debe seleccionar el campus/escuela.", "error");
		document.getElementById("txtCampus").focus();
		return 0;
	}
	if (Asignatura == '') {
		swal("Error al guardar", "Debe escribir el nombre de la asignatura.", "error");
		document.getElementById("txtAsignatura").focus();
		return 0;
	}

	var TipoGuardar = "add_Asignaturax";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta nueva asignatura?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&Oferta=' + Oferta + '&Asignatura=' + Asignatura + '&Campus=' + Campus;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 2) {
							swal("Error al guardar", "Ha ocurrido un error, la asignatura ya existe.", "error");
						}
						if (data == 1) {
							swal("Agregado correctamente", "La asignatura ha sido creadad correctamente.", "success");
							parent.location.href = 'adAddAsignatura.php?idC=' + Campus + '&idO=' + Oferta;
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function updSemana() {
	var IdSemanaDoc = document.getElementById("IdSemanaDoc").value;
	var IdParcialDoc = document.getElementById("IdParcialDoc").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var Tema = document.getElementById("txt_Tema").value;
	var Temas = document.getElementById("txtTemasXd").value;
	var IdUsua = document.getElementById("IdUsua").value;

	if (Tema == '') {
		swal("Error al guardar", "Debe escribir el tema.", "error");
		document.getElementById("txt_Tema").focus();
		return 0;
	}
	if (Temas == '') {
		swal("Error al guardar", "Debe escribir los subtemas.", "error");
		document.getElementById("txtTemasXd").focus();
		return 0;
	}

	var TipoGuardar = "updSemana";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar estos datos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2sFar').serialize();
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdSemanaDoc=' + IdSemanaDoc + '&Temas=' + Temas + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 2) {
							swal("Error al actualizar", "Ha ocurrido un error, no se ha podido actualizar.", "error");
						}
						if (data == 1) {
							swal("Actualizado correctamente", "Los datos se han actualizado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcialDoc;

						}
						if (data == 0) {
							swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function addPresent() {
	var IdSemanaDoc = document.getElementById("IdSemanaDoc").value;

	var Tipo = document.getElementById("txtTipox").value;
	var Codex = document.getElementById("txtCodex").value;
	var Nombre = document.getElementById("txtNombrex").value;


	if (Tipo == '') {
		swal("Error al guardar", "Debe seleccionar el tipo de presentación.", "error");
		document.getElementById("txtTipox").focus();
		return 0;
	}
	if (Nombre == '') {
		swal("Error al guardar", "Debe escribir el nombre de la presentación.", "error");
		document.getElementById("txtNombrex").focus();
		return 0;
	}
	if (Codex == '') {
		swal("Error al guardar", "Debe pegar el código html de la presentación.", "error");
		document.getElementById("txtCodex").focus();
		return 0;
	}


	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta presentación?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2s_Far').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 2) {
							swal("Error al insertar", "Ha ocurrido un error, el codigo HTML no es correcto.", "error");
						}
						if (data == 1) {
							swal("Guardado correctamente", "La presentación se ha guardado correctamente.", "success");
							$.ajax({
								url: "formConsulta/addPresentacion.php",
								method: "POST",
								data: { IdSemana: IdSemanaDoc },
								success: function (data) {
									$('#employee_pre').html(data);
									$('#dataPre').modal('show');
								}
							});

						}
						if (data == 0) {
							swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function updFuente() {
	var IdFuente = document.getElementById("IdFuente").value;
	var IdParcialDoc = document.getElementById("IdParcialDoc").value;
	var Fuente = document.getElementById("txtFuenteA").value;
	var Permisos = document.getElementById("Permisos").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var IdPlan = document.getElementById("IdPlaneacion").value;

	if (Fuente == '') {
		swal("Error al guardar", "Debe escribir la fuente de consulta.", "error");
		document.getElementById("txtFuenteA").focus();
		return 0;
	}

	var TipoGuardar = "updFuente";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar estos datos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2sFer').serialize();
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdSemanaDoc=' + IdSemanaDoc + '&Temas=' + Temas + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "Los datos se han actualizado correctamente.", "success");
							if (Permisos == 2) {
								parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcialDoc;
							} else {
								parent.location.href = 'planeacionAcademica.php?toks=1574981614' + IdPlan;
							}


						}
						if (data == 0) {
							swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function addCampus() {
	var Campus = document.getElementById("txtCampus").value;

	if (Campus == '') {
		swal("Error al guardar", "Debe escribir el nombre del campus.", "error");
		document.getElementById("txtCampus").focus();
		return 0;
	}


	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este nuevo campus?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2sFr').serialize();
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdSemanaDoc=' + IdSemanaDoc + '&Temas=' + Temas + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Los datos se han guardado correctamente.", "success");
							parent.location.href = 'adAltas.php';
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function addEvalsx() {
	var Nombre = document.getElementById("txtNombre").value;
	var Permiso = document.getElementById("txtPermiso").value;

	if (Nombre == '') {
		swal("Error al guardar", "Debe escribir el nombre de la evaluacion.", "error");
		document.getElementById("txtNombre").focus();
		return 0;
	}

	if (Permiso == '') {
		swal("Error al guardar", "Debe selecionar para quien es la evaluacion.", "error");
		document.getElementById("txtPermiso").focus();
		return 0;
	}


	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta nueva evaluación?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2sFr').serialize();
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdSemanaDoc=' + IdSemanaDoc + '&Temas=' + Temas + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Los datos se han guardado correctamente.", "success");
							parent.location.href = 'adEvaluacion.php';
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}



function savResp(IdRespuesta, IdPregunta) {
	var Valorx = "txtValor-" + IdRespuesta;
	var Respuestax = "txtTexto-" + IdRespuesta;
	var Estatusx = "txtEstatus-" + IdRespuesta;

	var Valor = document.getElementById(Valorx).value;
	var Respuesta = document.getElementById(Respuestax).value;
	var Estatus = document.getElementById(Estatusx).value;

	var TipoGuardar = "addRespuex";


	if (Respuesta == '') {
		swal("Error al guardar", "Debe escribir la respuesta.", "error");
		document.getElementById(Respuestax).focus();
		return 0;
	}


	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar esta respuesta?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&Valor=' + Valor + '&Respuesta=' + Respuesta + '&Estatus=' + Estatus;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						$.ajax({
							url: "formConsulta/addRespuestax.php",
							method: "POST",
							data: { IdPregunta: IdPregunta },
							success: function (data) {
								$('#employee_detail').html(data);
								$('#dataModal').modal('show');
							}
						});

					}
				})

			}

		});
}

function saveRespx(IdPregunta) {
	var Valor = document.getElementById("txtValor").value;
	var Respuesta = document.getElementById("txtTexto").value;

	var TipoGuardar = "addRespuexNew";
	if (Valor == '') {
		swal("Error al guardar", "Debe seleccionar el valor de la respuesta.", "error");
		document.getElementById("txtValor").focus();
		return 0;
	}
	if (Respuesta == '') {
		swal("Error al guardar", "Debe escribir la respuesta.", "error");
		document.getElementById("txtTexto").focus();
		return 0;
	}


	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta respuesta?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&Valor=' + Valor + '&Respuesta=' + Respuesta + '&IdPregunta=' + IdPregunta;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						$.ajax({
							url: "formConsulta/addRespuestax.php",
							method: "POST",
							data: { IdPregunta: IdPregunta },
							success: function (data) {
								$('#employee_detail').html(data);
								$('#dataModal').modal('show');
							}
						});

					}
				})

			}

		});
}

function upddCampus() {
	var Campus = document.getElementById("txCampus").value;

	if (Campus == '') {
		swal("Error al guardar", "Debe escribir el nombre del campus.", "error");
		document.getElementById("txCampus").focus();
		return 0;
	}


	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar este campus?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2sr').serialize();
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdSemanaDoc=' + IdSemanaDoc + '&Temas=' + Temas + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "Los datos se han guardado correctamente.", "success");
							parent.location.href = 'adAltas.php';
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function updEvals() {
	var Tipo = document.getElementById("txtTipo").value;
	var Permiso = document.getElementById("txtPermiso").value;

	if (Tipo == '') {
		swal("Error al guardar", "Debe escribir el nombre de la evaluacion.", "error");
		document.getElementById("txtTipo").focus();
		return 0;
	}


	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar este nombre?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2srx').serialize();
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdSemanaDoc=' + IdSemanaDoc + '&Temas=' + Temas + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "Los datos se han guardado correctamente.", "success");
							parent.location.href = 'adEvaluacion.php';
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function updEPregs() {
	var Pregunta = document.getElementById("txtPregunta").value;
	var Tipo = document.getElementById("Tipo").value;

	if (Pregunta == '') {
		swal("Error al guardar", "Debe escribir la pregunta.", "error");
		document.getElementById("txtPregunta").focus();
		return 0;
	}


	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar esta pregunta?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2sr').serialize();
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdSemanaDoc=' + IdSemanaDoc + '&Temas=' + Temas + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "Los datos se han guardado correctamente.", "success");
							parent.location.href = 'adPreguntas.php?idToks=1614021249' + Tipo;
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function changePassXXXX() {
	var IdUsuaXL = document.getElementById("IdUsuaXL").value;
	var Anterior = document.getElementById("txtAnterior").value;
	var Nueva = document.getElementById("txtNueva").value;

	if (Anterior == '') {
		swal("Error al actualizar", "Debe escribir la contraseña actual.", "error");
		document.getElementById("txtAnterior").focus();
		return 0;
	}

	if (Nueva == '') {
		swal("Error al actualizar", "Debe escribir su nueva contraseña.", "error");
		document.getElementById("txtNueva").focus();
		return 0;
	}

	var TipoGuardar = "changePass";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar su contraseña?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				//  var datos=$('#frm2srA').serialize();
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsuaXL=' + IdUsuaXL + '&Anterior=' + Anterior + '&Nueva=' + Nueva;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "La contraseña se ha actualizado correctamente.", "success");

						}
						if (data == 2) {
							swal("Error al actualizar", "Los datos no coinciden con su usuario.", "error");
							//  parent.location.href='doMiPlaneacion.php?tok='+IdParcialDoc;
						}
						if (data == 0) {
							swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function saveSemana() {
	var NoSemana = document.getElementById("txtSemana").value;
	var Tema = document.getElementById("txtTema").value;
	var Temas = document.getElementById("txtTemas").value;
	var IdOferta = document.getElementById("IdOferta").value;
	var IdModulo = document.getElementById("IdModulo").value;
	var IdParcial = document.getElementById("IdParcial").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var IdUsua = document.getElementById("IdUsua").value;

	if (NoSemana == '') {
		swal("Error al guardar", "Debe escribir el nombre de la etiqueta.", "error");
		document.getElementById("txtSemana").focus();
		return 0;
	}

	if (Tema == '') {
		swal("Error al guardar", "Debe escribir el tema.", "error");
		document.getElementById("txtTema").focus();
		return 0;
	}
	if (Temas == '') {
		swal("Error al guardar", "Debe escribir los subtemas.", "error");
		document.getElementById("txtTemas").focus();
		return 0;
	}

	var TipoGuardar = "savSemana";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta información en este contenido?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2sGr').serialize();
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdModulo=' + IdModulo + '&NoSemana=' + NoSemana + '&Temas=' + Temas + '&IdParcial=' + IdParcial + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 2) {
							swal("Error al crear", "Esta unidad ya existe, favor de verificar.", "error");
						}
						if (data == 1) {
							swal("Agregado correctamente", "Unidad creado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcial;
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function saveSemblanza() {
	var Semblanza = document.getElementById("txtSemblanza").value;
	var IdUsua = document.getElementById("IdUsua").value;

	if (Semblanza == '') {
		swal("Error al guardar", "Debe escribir su semblanza.", "error");
		document.getElementById("txtSemblanza").focus();
		return 0;
	}

	var TipoGuardar = "savSemblanza";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar esta informaci\u00F3n?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&Semblanza=' + Semblanza + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "La informaci\u00F3n de la semblanza se ha guardado correctamente.", "success");
							datos_docente(IdUsua);
							$('#dataModalViewPc').modal('hide');
						}
						if (data == 0) {
							swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}



function delGrado(IdGrado) {


	var TipoGuardar = "delGrados";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este grado de estudio?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdGrado=' + IdGrado;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Eliminado correctamente", "El grado de estudio se ha eliminado correctamente.", "success");
							document.getElementById(IdGrado).style.display = 'none';
						}
						if (data == 0) {
							swal("Error al guardar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function saveBeca() {
	var Concepto = document.getElementById("txtConcepto").value;
	var Beca = document.getElementById("txtBeca").value;
	var Tok = document.getElementById("IdUsua").value;


	if (Concepto == '') {
		swal("Error al guardar", "Debe seleccionar el plan de concepto.", "error");
		document.getElementById("txtConcepto").focus();
		return 0;
	}
	if (Beca == '') {
		swal("Error al guardar", "Debe escribir la beca que desea otorgar.", "error");
		document.getElementById("txtBeca").focus();
		return 0;
	}

	var TipoGuardar = "savBeca";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar \u00E9sta nueva beca?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdModulo=' + IdModulo + '&IdSemana=' + IdSemana + '&TipoA=' + TipoA + '&IdParcial=' + IdParcial + '&Descripcion=' + Descripcion + '&Actividad=' + Actividad + '&IdUsua=' + IdUsua + '&IdAsignacion=' +IdAsignacion + '&FecIni=' + FecIni + '&FecFin=' + FecFin + '&Porcentaje=' + Porcentaje;
				var datos = $('#frm2xfYj').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Agregado correctamente", "Actividad creada correctamente.", "success");
							parent.location.href = 'cobrar.php?token=' + Tok;
						}
						if (data == 2) {
							swal("Error al guardar", "Este usuario ya tiene un descuento activo con este concepto.", "error");
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function saveFuente() {

	var Descripcion = document.getElementById("txtDescripcion").value;
	var IdOferta = document.getElementById("IdOferta").value;
	var IdModulo = document.getElementById("IdModulo").value;
	var IdParcial = document.getElementById("IdParcial").value;
	var IdSemana = document.getElementById("IdSemana").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;

	if (Descripcion == '') {
		swal("Error al guardar", "Debe describir la fuente de consulta.", "error");
		document.getElementById("txtDescripcion").focus();
		return 0;
	}

	var TipoGuardar = "savFuente";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar \u00E9sta fuente de consulta?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdModulo=' + IdModulo + '&IdSemana=' + IdSemana + '&IdParcial=' + IdParcial + '&Descripcion=' + Descripcion + '&IdUsua=' + IdUsua + '&IdAsignacion=' +IdAsignacion;
				var datos = $('#frm2dHa').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Agregado correctamente", "Fuente de consulta creado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcial;
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function updActividadDoc() {
	var IdActividadDoc = document.getElementById("IdActividadDoc").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var TipoA = document.getElementById("txtTipoAU").value;
	var Actividad = document.getElementById("txtActividad1").value;
	var Descripcion = document.getElementById("txtDescripcion1").value;
	var FecIni = document.getElementById("datepicker111").value;
	var FecFin = document.getElementById("datepicker222").value;
	var Porcentaje = document.getElementById("txtPorcentajex").value;
	var IdParcialDoc = document.getElementById("IdParcialDoc").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var Proyecto = document.getElementById("Proyecto").value;
	var EntregaU = document.getElementById("txtEntregaU").value;


	if (TipoA == '') {
		swal("Error al guardar", "Debe selecionar el tipo de actividad.", "error");
		document.getElementById("txtTipoA").focus();
		return 0;
	}

	if (Actividad == '') {
		swal("Error al guardar", "Debe escribir el nombre de la actividad.", "error");
		document.getElementById("txtActividad").focus();
		return 0;
	}

	if (Proyecto == 1) {
		var Etapa = document.getElementById("txtEtapaU").value;
		if (Etapa == '') {
			swal("Error al guardar", "Debe seleccionar la etapa de la metodolog\u00EDa ABP.", "error");
			document.getElementById("txtEtapaU").focus();
			return 0;
		}
	}

	if (Descripcion == '') {
		swal("Error al guardar", "Debe describir la actividad a realizar.", "error");
		document.getElementById("txtDescripcion1").focus();
		return 0;
	}

	// if (Descripcion ==''){
	// 		swal("Error al guardar", "Debe describir la actividad a realizar.", "error");
	// 		document.getElementById("txtDescripcion").focus();
	// 		return 0;
	// }
	if (FecIni == '') {
		swal("Error al guardar", "Debe selecionar la fecha de activaci\u00F3n.", "error");
		document.getElementById("datepicker111").focus();
		return 0;
	}
	if (FecFin == '') {
		swal("Error al guardar", "Debe seleecionar la fecha final.", "error");
		document.getElementById("datepicker222").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar estos datos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2Vb').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Actualizado correctamente", "Actividad actualizado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcialDoc;
						}
						if (data == 2) {
							swal("Error al guardar", "Revise el porcentaje a asignar.", "error");
						}
						if (data == 3) {
							swal("Error al guardar", "Revise el rango de fecha de la actividad.", "error");
						}
						if (data == 0) {
							swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function savDatCurso() {
	var Usua = document.getElementById("txtUsua").value;
	var Fec1 = document.getElementById("datepicker11").value;
	var Fec2 = document.getElementById("datepicker11").value;
	var IdModulo = document.getElementById("IdModulo").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;

	if (Usua == '') {
		swal("Error al guardar", "Debe selecionar el asesor.", "error");
		document.getElementById("txtUsua").focus();
		return 0;
	}

	if (Fec1 == '') {
		swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
		document.getElementById("datepicker11").focus();
		return 0;
	}

	if (Fec2 == '') {
		swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
		document.getElementById("datepicker22").focus();
		return 0;
	}


	//var TipoGuardar = "savDattCurso";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos datos de este curso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdActividadDoc=' + IdActividadDoc + '&Descripcion=' + Descripcion + '&Actividad=' + Actividad + '&FecIni=' + FecIni + '&FecFin=' + FecFin + '&Porcentaje=' + Porcentaje + '&IdUsua=' + IdUsua;
				var datos = $('#frm5Vb').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Guardado correctamente", "Datos actulizados correctamente.", "success");
							$.ajax({
								url: "formConsulta/configCurso.php",
								method: "POST",
								data: { IdModulo: IdModulo },
								success: function (data) {
									$('#employee_detailModAct').html(data);
									$('#dataModalModAct').modal('show');
								}
							});
						}

						if (data == 0) {
							swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function enviarRevision(IdUsua) {

	var IdPlaneacion = document.getElementById("IdPlaneacion").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;

	var TipoGuardar = "envioRevision";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea enviarlo a su coordinaci\u00F3n acad\u00E9mico para su revisi\u00F3n?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsua=' + IdUsua + '&IdAsignacion=' + IdAsignacion + '&IdPlaneacion=' + IdPlaneacion;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Enviado correctamente", "Los datos se han enviado a la Coordinaci\u00F3n acad\u00E9mica para su revisi\u00F3n.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion;
						}
						if (data == 0) {
							swal("Error al enviar", "No se puede enviar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function updateBanco() {
	var IdBanco = document.getElementById("IdBanco").value;
	var Nombre = document.getElementById("txtNombre").value;
	var Convenio = document.getElementById("txtConvenio").value;
	var Banco = document.getElementById("txtBanco").value;
	var Cuenta = document.getElementById("txtCuenta").value;
	var Clabe = document.getElementById("txtClabe").value;

	if (Nombre == '') {
		swal("Error al guardar", "Debe escribir el nombre de la cuenta.", "error");
		document.getElementById("txtNombre").focus();
		return 0;
	}

	if (Banco == '') {
		swal("Error al guardar", "Debe escribir el nombre del banco.", "error");
		document.getElementById("txtBanco").focus();
		return 0;
	}

	var TipoGuardar = "updateBanco";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar esta cuenta de banco?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&Nombre=' + Nombre + '&Banco=' + Banco + '&Cuenta=' + Cuenta + '&Clabe=' + Clabe + '&IdBanco=' + IdBanco + '&Convenio=' + Convenio;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "Cuenta de banco actualizado correctamente.", "success");
							parent.location.href = 'adBancos.php'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}

function copiarParcial(IdParcial) {
	var IdUsua = document.getElementById("IdUsua").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;

	var TipoGuardar = "copyParcial";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea copiar los datos de este parcial?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdParcial=' + IdParcial + '&IdUsua=' + IdUsua + '&IdAsignacion=' + IdAsignacion;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
					}
				})
					.done(function (data) {
						if (data == 2) {
							swal("Error al copiar", "No se puede copiar ya que existe el parcial en su planeaci\u00F3n acad\u00E9mica.", "error");
						}
						if (data == 1) {
							swal("Copiado correctamente", "Datos del parcial copiado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion;
						}
						if (data == 0) {
							swal("Error al copiar", "No se puede copiar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}

function copiarExamen(IdParcial, IdActividad, IdActividadAnt) {
	var IdUsua = document.getElementById("IdUsua").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;

	var TipoGuardar = "copyExamen";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea copiar este examen?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				$(".cancel").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdParcial=' + IdParcial + '&IdUsua=' + IdUsua + '&IdAsignacion=' + IdAsignacion + '&IdActividad=' + IdActividad + '&IdActividadAnt=' + IdActividadAnt;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
					}
				})
					.done(function (data) {
						if (data == 2) {
							swal("Error al copiar", "No se puede copiar ya que existe el parcial en su planeaci\u00F3n acad\u00E9mica.", "error");
						}
						if (data == 1) {
							swal("Copiado correctamente", "Datos del parcial copiado correctamente.", "success");
							parent.location.href = 'doAddConfigExamen.php?idToks=' + IdAsignacion + '&tok=8958745410' + IdActividad + '&p=' + IdParcial;
							// <a onClick="window.open('doAddConfigExamen.php?idToks=<?php echo $_GET["idToks"]; ?>&tok=<?php echo time().$actividades[$ac]["IdActividadesDocente"];  ?>&p=<?php echo $IdParcial;  ?>','_self')" href="javascript:void(0);" class="btn btn-primary"><i class="fa fa-fw fa-gg-circle"></i> Configurar evaluaci&oacute;n</a>
						}
						if (data == 0) {
							swal("Error al copiar", "No se puede copiar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}

function copiarPlaneacion(IdParcial) {
	var IdUsua = document.getElementById("IdUsua").value;

	var TipoGuardar = "copyPlaneacion";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea copiar los datos de \u00E9sta planeaci\u00F3n acad\u00E9mica?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdParcial=' + IdParcial + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
					}
				})
					.done(function (data) {
						if (data == 2) {
							swal("Error al copiar", "No se puede copiar ya que existe una planeaci\u00F3n acad\u00E9mica creada.", "error");
						}
						if (data == 1) {
							swal("Copiado correctamente", "Datos de la planeaci\u00F3n acad\u00E9mica parcial copiado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php';
						}
						if (data == 0) {
							swal("Error al copiar", "No se puede copiar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}

function saveCambios(IdUsua) {
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var IdEstatus = document.getElementById("txtIdEstatus").value;
	var IdPlaneacion = document.getElementById("IdPlaneacion").value;

	if (IdEstatus == '') {
		swal("Error al guardar", "Debe selecionar el estatus.", "error");
		document.getElementById("txtIdEstatus").focus();
		return 0;
	}

	var TipoGuardar = "cambiosParcial";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos cambios?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdAsignacion=' + IdAsignacion + '&IdUsua=' + IdUsua + '&IdEstatus=' + IdEstatus + '&IdPlaneacion=' + IdPlaneacion;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Guardado correctamente", "Datos  guardados correctamente.", "success");
							parent.location.href = 'planeacionAcademica.php?toks=1574983138' + IdPlaneacion;

						}
						if (data == 0) {
							swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}

function activarActividad(IdActividad, IdParcial) {
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var Boton = "btnP-" + IdActividad;

	var TipoGuardar = "activarActividad";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea publicar esta actividad para sus alumnos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById(Boton).style.display = 'none';
				$(".confirm").attr('disabled', 'disabled');

				var datos = 'TipoGuardar=' + TipoGuardar + '&IdActividad=' + IdActividad + '&IdParcial=' + IdParcial;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Publicado correctamente", "La actividad ha sido publicado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcial;
						}
						if (data == 0) {
							swal("Error al publicar", "No se puede publicar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}

function EstatusBanco(Estatus) {
	var IdBanco = document.getElementById("IdBanco").value;

	var TipoGuardar = "estatusBanco";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea cambiar el estatus de esta cuenta de banco?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdBanco=' + IdBanco + '&Estatus=' + Estatus;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Actualizado correctamente", "Estatus de cuenta de banco actualizado correctamente.", "success");
							parent.location.href = 'adBancos.php'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al actualizar", "No se puede actualizar estatus de cuenta de banco, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}


function getval_facturar(sel, IdPago, IdUsua) {
	var TipoValor = sel.value;
	var TipoGuardar = "facturarPago";
	var IdEsttus = document.getElementById("id_estatus").value;

	if (IdEsttus == '8') {

	} else {
		swal("Error al solicitar", "Para solicitar una factura debe de revisar sus datos de factura.", "error");
		document.getElementById("id_estatus").focus();
		return 0;
	}
	var datos = 'TipoGuardar=' + TipoGuardar + '&IdPago=' + IdPago + "&TipoValor=" + TipoValor + "&IdUsua=" + IdUsua;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {
			//alert(data);
		}
	})
		.done(function (data) {
			if (data == 4) {
				swal("Guardado correctamente", "Datos guardados correctamente.", "success");
				//document.getElementById("frm").reset();
				parent.location.href = 'misdatosFact.php'; //direcciona la pagina madre
			}
			if (data == 0) {
				swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
			}
		})


}

function addHorario(IdHorario) {
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var HraIni = document.getElementById("txtHraIni-" + IdHorario).value;
	var MinIni = document.getElementById("txtMinIni-" + IdHorario).value;
	var HraFin = document.getElementById("txtHraFin-" + IdHorario).value;
	var MinFin = document.getElementById("txtMinFin-" + IdHorario).value;
	var Total = document.getElementById("txtTotal-" + IdHorario).value;
	var TipoGuardar = "addHorario";



	// if (HraIni ==''){
	//     swal("Error al guardar", "Debe selecionar la hora inicial.", "error");
	//     document.getElementById("txtHraIni-"+IdHorario).focus();
	//     return 0;
	// }
	// if (MinIni ==''){
	//     swal("Error al guardar", "Debe selecionar el minuto inicial.", "error");
	//     document.getElementById("txtMinIni-"+IdHorario).focus();
	//     return 0;
	// }
	// if (HraFin ==''){
	//     swal("Error al guardar", "Debe selecionar la hora final.", "error");
	//     document.getElementById("txtHraFin-"+IdHorario).focus();
	//     return 0;
	// }
	// if (MinFin ==''){
	//     swal("Error al guardar", "Debe selecionar el minuto final.", "error");
	//     document.getElementById("txtMinIniFin-"+IdHorario).focus();
	//     return 0;
	// }
	// if (Total ==''){
	//     swal("Error al guardar", "Debe selecionar las horas totales.", "error");
	//     document.getElementById("txtTotal-"+IdHorario).focus();
	//     return 0;
	// }


	var datos = 'TipoGuardar=' + TipoGuardar + '&IdAsignacion=' + IdAsignacion + '&IdHorario=' + IdHorario + '&HraIni=' + HraIni + '&MinIni=' + MinIni + '&HraFin=' + HraFin + '&MinFin=' + MinFin + '&Total=' + Total;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Horario guardado correctamente.", "success");
			}
			if (data == 2) {
				swal("Error al guardar", "Favor de verificar el horario asignado.", "error");
				document.getElementById("txtFin-" + IdHorario).value = '';
			}
			if (data == 0) {
				swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
			}
		})


}

function addFechaFin(IdParcialDoc) {
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var Fec = "datepicker1-" + IdParcialDoc;
	var Fecha = document.getElementById(Fec).value;

	var TipoGuardar = "addFechfIN";



	if (Fecha == '') {
		swal("Error al guardar", "Debe agregar la fecha final.", "error");
		return 0;
	}

	var datos = 'TipoGuardar=' + TipoGuardar + '&IdParcialDoc=' + IdParcialDoc + '&Fecha=' + Fecha;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Fecha final guardado correctamente.", "success");
			}

			if (data == 0) {
				swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
			}
		})


}

function addHoras() {
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var HraD = document.getElementById("txtHraD").value;
	var HraI = document.getElementById("txtHraI").value;

	var TipoGuardar = "addHorarioDoIn";



	if (HraD == '') {
		swal("Error al guardar", "Debe escribir la hora docente.", "error");
		document.getElementById("txtHraD").focus();
		return 0;
	}
	if (HraI == '') {
		swal("Error al guardar", "Debe escribir la hora independiente.", "error");
		document.getElementById("txtHraI").focus();
		return 0;
	}


	var datos = 'TipoGuardar=' + TipoGuardar + '&IdAsignacion=' + IdAsignacion + '&HraD=' + HraD + '&HraI=' + HraI;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Horas guardado correctamente.", "success");
			}

			if (data == 0) {
				swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
			}
		})


}

function addRvoe(IdRvoe) {
	var Oferta = document.getElementById("txt_oferta").value;
	var Rvoe = document.getElementById("txtRvoe").value;
	var Vigencia = document.getElementById("txtVigencia").value;
	var Turno = document.getElementById("txtTurno").value;
	var Modalidad = document.getElementById("txtModalidad").value;
	var Escuela = document.getElementById("txtEscuela").value;
	var Localidad = document.getElementById("txtLocalidad").value;
	var Clave = document.getElementById("txtClave").value;
	var Clave_dgp = document.getElementById("txtClave_dgp").value;
	var Clave_rpe = document.getElementById("txtRegistro").value;
	
	var TipoGuardar = "addRvoe";



	if (Rvoe == '') {
		swal("Error al guardar", "Debe escribir el Rvoe.", "error");
		document.getElementById("txtRvoe").focus();
		return 0;
	}
	if (Vigencia == '') {
		swal("Error al guardar", "Debe escribir la vigencia.", "error");
		document.getElementById("txtVigencia").focus();
		return 0;
	}
	if (Turno == '') {
		swal("Error al guardar", "Debe escribir el turno.", "error");
		document.getElementById("txtTurno").focus();
		return 0;
	}
	if (Modalidad == '') {
		swal("Error al guardar", "Debe escribir la modalidad.", "error");
		document.getElementById("txtModalidad").focus();
		return 0;
	}


	var datos = 'TipoGuardar=' + TipoGuardar + '&Rvoe=' + Rvoe + '&Vigencia=' + Vigencia + '&Turno=' + Turno + '&Modalidad=' + Modalidad + '&IdRvoe=' + IdRvoe + '&Escuela=' + Escuela + '&Localidad=' + Localidad + '&Clave=' + Clave + '&Clave_dgp=' + Clave_dgp + '&Oferta=' + Oferta + '&Clave_rpe=' + Clave_rpe;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Datos del rvoe ha sido guardado correctamente.", "success");
			}

			if (data == 0) {
				swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
			}
		})


}

function updGrupoP() {
	var IdGrupo = document.getElementById("IdGrupo").value;
	var Estatus = document.getElementById("txtEstatus").value;
	var Periodo = document.getElementById("txtPeriodoX").value;
	var Disponible = document.getElementById("txtDisponible").value;
	var Inicio = document.getElementById("txtFeInix").value;
	var Final = document.getElementById("txtFeFinx").value;


	var TipoGuardar = "updGrupoP";

	var datos = 'TipoGuardar=' + TipoGuardar + '&IdGrupo=' + IdGrupo + '&Estatus=' + Estatus + '&Periodo=' + Periodo + '&Disponible=' + Disponible + '&Inicio=' + Inicio + '&Final=' + Final;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Datos del periodo del grupo guardado correctamente.", "success");

				$.ajax({
					url: "vistas/escolar/actualizar_grupo.php",
					method: "POST",
					data: { employee_id: IdGrupo },
					success: function (data) {
						$('#employee_detailGrp').html(data);
						$('#dataModalGrp').modal('show');
					}
				});
			}

			if (data == 0) {
				swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
			}
		})


}

function addFirma() {
	var Rector = document.getElementById("txtRector").value;
	var Escolar = document.getElementById("txtEscolar").value;
	var Oficina = document.getElementById("txtOficina").value;
	var Departamento = document.getElementById("txtDepartamento").value;
	var Elaboro = document.getElementById("txtElaboro").value;
	var IdCampus = document.getElementById("IdCampus").value;
	var Educacion = document.getElementById("txtEducacion").value;
	var Coordinadora = document.getElementById("txtCoordindadora").value;
	var Responsable = document.getElementById("txtResponsable").value;
	var Servicio = document.getElementById("txtServicio").value;
	var TipoGuardar = "addFirma";
	if (Rector == '') {
		swal("Error al guardar", "Debe escribir el nombre del rector.", "error");
		document.getElementById("txtRector").focus();
		return 0;
	}
	if (Escolar == '') {
		swal("Error al guardar", "Debe escribir el nombre de servicios escolares.", "error");
		document.getElementById("txtEscolar").focus();
		return 0;
	}
	if (Oficina == '') {
		swal("Error al guardar", "Debe escribir el nombre del jefe de oficina.", "error");
		document.getElementById("txtOficina").focus();
		return 0;
	}
	if (Departamento == '') {
		swal("Error al guardar", "Debe escribir el nombre del jefe de departamento.", "error");
		document.getElementById("txtDepartamento").focus();
		return 0;
	}



	var datos = 'TipoGuardar=' + TipoGuardar + '&Rector=' + Rector + '&Escolar=' + Escolar + '&Oficina=' + Oficina + '&Departamento=' + Departamento + '&IdCampus=' + IdCampus + '&Elaboro=' + Elaboro + '&Educacion=' + Educacion + '&Coordinadora=' + Coordinadora + '&Responsable=' + Responsable + '&Servicio=' + Servicio;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Los datos de los firmantes ha sido guardado correctamente.", "success");
			}

			if (data == 0) {
				swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
			}
		})


}

function add_doc_servicio(IdServicio) {
	var Dep = document.getElementById("txtDep").value;
	var Pro = document.getElementById("txtPro").value;
	var Per = document.getElementById("txtPer").value;
	var Fec = document.getElementById("txtFec").value;
	var Regx = document.getElementById("txtRegx").value;

	var TipoGuardar = "gen_constcnai_ser";
	if (Dep == '') {
		swal("Error al generar", "Debe escribir nombre de la Dependencia.", "error");
		document.getElementById("txtDep").focus();
		return 0;
	}
	if (Pro == '') {
		swal("Error al generar", "Debe escribir el nombre del programa.", "error");
		document.getElementById("txtPro").focus();
		return 0;
	}
	if (Per == '') {
		swal("Error al generar", "Debe escribir el perido.", "error");
		document.getElementById("txtPer").focus();
		return 0;
	}
	if (Fec == '') {
		swal("Error al generar", "Debe selecionar la fecha de la impresión de la constancia.", "error");
		document.getElementById("txtFec").focus();
		return 0;
	}
	if (Regx == '') {
		swal("Error al generar", "Debe ingresar el No. Registro.", "error");
		document.getElementById("txtRegx").focus();
		return 0;
	}



	var datos = 'TipoGuardar=' + TipoGuardar + '&IdServicio=' + IdServicio + '&Dep=' + Dep + '&Pro=' + Pro + '&Per=' + Per + '&Fec=' + Fec + '&Regx=' + Regx;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Generado correctamente", "La constancia de servicio social se ha generado correctamente.", "success");
				$.ajax({
					url: "formConsulta/configurar_servicio_social.php",
					method: "POST",
					data: { IdServicio: IdServicio },
					success: function (data) {
						$('#employee_detail3').html(data);
						$('#dataModal3').modal('show');
					}
				});
			}

			if (data == 0) {
				swal("Error al generar", "No se puede generar, verifique sus datos.", "error");
			}
		})


}

function add_doc_servicio_carta(IdServicio) {
	var Dep = document.getElementById("txtDep").value;
	var Pro = document.getElementById("txtPro").value;
	var Per = document.getElementById("txtPer").value;
	var Fec = document.getElementById("txtFecx").value;
	var No = document.getElementById("txtNo").value;
	var Gra = document.getElementById("txtGra").value;
	var Res = 'x';

	var TipoGuardar = "gen_constcnai_ser_cart";
	if (Dep == '') {
		swal("Error al generar", "Debe escribir nombre de la Dependencia.", "error");
		document.getElementById("txtDep").focus();
		return 0;
	}
	if (Pro == '') {
		swal("Error al generar", "Debe escribir el nombre del programa.", "error");
		document.getElementById("txtPro").focus();
		return 0;
	}
	if (Per == '') {
		swal("Error al generar", "Debe escribir el perido.", "error");
		document.getElementById("txtPer").focus();
		return 0;
	}
	if (Fec == '') {
		swal("Error al generar", "Debe selecionar la fecha de la carta de presentación.", "error");
		document.getElementById("txtFecx").focus();
		return 0;
	}
	if (No == '') {
		swal("Error al generar", "Debe escribir el No de folio la carta de presentación.", "error");
		document.getElementById("txtNo").focus();
		return 0;
	}
	if (Gra == '') {
		swal("Error al generar", "Debe escribir el grado actual del alumno.", "error");
		document.getElementById("txtGra").focus();
		return 0;
	}
	if (Res == '') {
		swal("Error al generar", "Debe escribir el nombre del Responsable de Servicios Escolares.", "error");
		document.getElementById("txtRes").focus();
		return 0;
	}



	var datos = 'TipoGuardar=' + TipoGuardar + '&IdServicio=' + IdServicio + '&Dep=' + Dep + '&Pro=' + Pro + '&Per=' + Per + '&Fec=' + Fec + '&No=' + No + '&Gra=' + Gra + '&Res=' + Res;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Generado correctamente", "La carta de presentación de servicio social se ha generado correctamente.", "success");
				$.ajax({
					url: "formConsulta/configurar_carta_servicio_social.php",
					method: "POST",
					data: { IdServicio: IdServicio },
					success: function (data) {
						$('#employee_detailc').html(data);
						$('#dataModalc').modal('show');
					}
				});
			}

			if (data == 0) {
				swal("Error al generar", "No se puede generar, verifique sus datos.", "error");
			}
		})


}


function saveDatos(IdTipo) {
	var Modulo = document.getElementById("txtModulo").value;
	var Oferta = document.getElementById("txtOferta").value;
	if (IdTipo == 1) {
		var Texto = document.getElementById("txtObjetivo").value;
	} else {
		var Texto = document.getElementById("txtIntro").value;
	}


	if (Texto == '') {
		swal("Error al guardar", "Debe escribir la informaci\u00F3n requerida.", "error");
		return 0;
	}

	var TipoGuardar = "addInfoAsig";

	var datos = 'TipoGuardar=' + TipoGuardar + '&Texto=' + Texto + '&Modulo=' + Modulo + '&IdTipo=' + IdTipo + '&Oferta=' + Oferta;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Datos guardados correctamente.", "success");
			}

			if (data == 0) {
				swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
			}
		})


}



function addPregunta() {
	var Pregunta = document.getElementById("txtPregunta").value;
	var Tipo = document.getElementById("txtTipo").value;
	var IdActividadDoc = document.getElementById("IdActividadDoc").value;
	var IdParcialDoc = document.getElementById("IdParcialDoc").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;


	if (Pregunta == '') {
		swal("Error al guardar", "Debe escribir la pregunta.", "error");
		return 0;
	}
	if (Tipo == '') {
		swal("Error al guardar", "Debe seleccionar el tipo de pregunta.", "error");
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta pregunta?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				document.frm.Mov.value = 'Guardar'; document.frm.submit();
				return true;
			} else {
				return false;
			}
		});

}

function addRespuestaEx(IdPregunta) {
	var Pregunta = document.getElementById("IdPregunta").value;
	var A = document.getElementById("txtA").value;
	var B = document.getElementById("txtB").value;
	var C = document.getElementById("txtC").value;
	var D = document.getElementById("txtD").value;
	var E = document.getElementById("txtE").value;
	var F = document.getElementById("txtF").value;

	var Respuesta = document.getElementById("txtRespuesta").value;


	if (A == '') {
		swal("Error al guardar", "Debe escribir la respuesta del inciso A.", "error");
		return 0;
	}
	if (B == '') {
		swal("Error al guardar", "Debe escribir la respuesta del inciso B.", "error");
		return 0;
	}

	if (Respuesta == '') {
		swal("Error al guardar", "Debe selecionar la opcion de la respuesta correcta.", "error");
		return 0;
	}

	var TipoGuardar = "addRespuesEx";
	document.getElementById(Pregunta).style.display = 'none';
	var datos = 'TipoGuardar=' + TipoGuardar + '&Pregunta=' + Pregunta + '&Respuesta=' + Respuesta + '&A=' + A + '&B=' + B + '&C=' + C + '&D=' + D + '&E=' + E + '&F=' + F;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Respuestas guardadas correctamente.", "success");

				$('#dataModalPreg').modal('hide');
			}

			if (data == 0) {
				swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
			}
		})


}

function delRespuestas(IdPregunta) {
	var TipoGuardar = "delRespuesEx";

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar estas respuestas?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdPregunta=' + IdPregunta;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Eliminado correctamente", "Respuestas eliminadas correctamente.", "success");
							$('#dataModalPreg').modal('hide');
						}
						if (data == 0) {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}



function mostrarEva(IdActividad, IdParcial) {
	var IdAsignacion = document.getElementById("IdAsignacion").value;

	var TipoGuardar = "mostrarEvalua";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea iniciar esta evaluaci\u00F3n a su grupo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdActividad=' + IdActividad + '&IdParcial=' + IdParcial;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Mostrado correctamente", "La evaluaci\u00F3n ha sido publicado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcial;
						}
						if (data == 2) {
							swal("Error al mostrar", "No se puede mostrar la evaluaci\u00F3n, debe crear primero la evaluaci\u00F3n.", "success");
						}
						if (data == 3) {
							swal("Error al mostrar", "No se puede mostrar la evaluaci\u00F3n, debe configurar el tiempo de evaluaci\u00F3n.", "error");
						}
						if (data == 0) {
							swal("Error al publicar", "No se puede publicar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}

function savCosto() {

	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var Costo = document.getElementById("txtCosto").value;
	var TipoGuardar = "updCosto";

	if (Costo == '') {
		swal("Error al guardar", "Debe escribir el costo Hora/Semana/Mes.", "error");
		document.getElementById("txtCosto").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos costos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdAsignacion=' + IdAsignacion + '&Costo=' + Costo + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Guardado correctamente", "Los costos han sidos guardados correctamente.", "success");
						}
						if (data == 0) {
							swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}



function delActividad(IdActividadDoc, IdParcial) {
	var TipoGuardar = "delActividad";
	var IdAsignacion = document.getElementById("IdAsignacion").value;

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar esta actividad?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdActividadDoc=' + IdActividadDoc;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Eliminado correctamente", "La actividad se ha eliminado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcial; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function delBeca(IdBeca) {
	var TipoGuardar = "delBeca";
	var IdUsua = document.getElementById("token").value;

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar esta beca?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdBeca=' + IdBeca;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							var boton = "bec_" + IdBeca;
							swal("Eliminado correctamente", "La beca se ha eliminado correctamente.", "success");
							document.getElementById(boton).style.display = 'none';

							// parent.location.href='cobrar.php?token='+IdUsua; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function enviarPlan(IdPlan) {
	var TipoGuardar = "sendPlan";

	swal({
		title: "\u00BFEst\u00E1 seguro que desea enviar este plan de proyecto a revisi\u00F3n?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdPlan=' + IdPlan;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Enviado correctamente", "El plan de proyecto ha sido enviado correctamente.", "success");
							parent.location.href = 'planProyecto.php'; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al enviar", "No se puede enviar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function addPlanPag(IdOferta, IdConceptoPlan, IdConcepto, IdCampus) {
	var TipoGuardar = "addPlanPa";
	var employee_id = IdConceptoPlan;
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta oferta educativa a este concepto de pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdConceptoPlan=' + IdConceptoPlan + '&IdConcepto=' + IdConcepto;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Guardado correctamente", "La oferta educativa se ha incorporado a este concepto de pago correctamente.", "success");
							$.ajax({
								url: "formConsulta/ofertasConcepto.php",
								method: "POST",
								data: { employee_id: employee_id, IdCampus: IdCampus },
								success: function (data) {
									$('#employee_detail3').html(data);
									$('#dataModal3').modal('show');
								}
							});
						}
						if (data == 0) {
							swal("Error al enviar", "No se puede enviar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function delPlanPag(IdOferta, IdConceptoPlan, IdConcepto, IdCampus) {
	var TipoGuardar = "delPlanPa";
	var employee_id = IdConceptoPlan;
	swal({
		title: "\u00BFEst\u00E1 seguro que desea quitar esta oferta educativa de este concepto de pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdConceptoPlan=' + IdConceptoPlan + '&IdConcepto=' + IdConcepto;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Eliminado correctamente", "La oferta educativa se ha quitado a este concepto de pago correctamente.", "success");
							$.ajax({
								url: "formConsulta/ofertasConcepto.php",
								method: "POST",
								data: { employee_id: employee_id, IdCampus: IdCampus },
								success: function (data) {
									$('#employee_detail3').html(data);
									$('#dataModal3').modal('show');
								}
							});
						}
						if (data == 0) {
							swal("Error al enviar", "No se puede enviar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function delEnlace(IdCicloGrupo, IdGrupo, IdCiclo) {
	var TipoGuardar = "delCicloGrupo";

	swal({
		title: "\u00BFEst\u00E1 seguro que desea quitar este grupo de este ciclo escolar?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdCicloGrupo=' + IdCicloGrupo + '&IdGrupo=' + IdGrupo + '&IdCiclo=' + IdCiclo;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Quitado correctamente", "El grupo se ha quitado correctamente.", "success");
							parent.location.href = 'adAddConfigCiclo.php'; //direcciona la pagina madre
						}
						if (data == 2) {
							swal("Error al ejecutar", "No se puede quitar el grupo, ya que fue asignado a un asesor y un grupo.", "error");
						}
						if (data == 0) {
							swal("Error al quitar", "No se puede quitar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function addmatr(IdOferta, IdCampus, Valor) {
	var TipoGuardar = "addMatriSe";
	var Tipo = document.getElementById("txtTipo").value;

	swal({
		title: "\u00BFEst\u00E1 seguro que desea realizar este proceso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdCampus=' + IdCampus + '&Tipo=' + Tipo + '&Valor=' + Valor;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Ejecutado correctamente", "Datos guardado correctamente.", "success");
							parent.location.href = 'adConfigSer.php?M=' + Tipo + '&C=' + IdCampus; //direcciona la pagina madre
						}
						if (data == 2) {
							swal("Error al agregar", "Esta oferta educativa ya tiene asignado una seriación.", "error");
						}

					})
					.error(function (data) {
						swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function delAlumno(IdUsua) {
	var TipoGuardar = "delUsuaario";


	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este usuario?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Eliminado correctamente", "El usuario ha sido eliminado correctamente.", "success");
							document.getElementById(IdUsua).style.display = 'none';
						}

					})
					.error(function (data) {
						swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function saveBecaGpal() {
	var IdGrupo = document.getElementById("txtClaveGrp").value;
	var IdCampus = document.getElementById("txtCampus").value;
	var IdPlan = document.getElementById("txtPlan").value;
	var Beca = document.getElementById("txtBeca").value;
	var TipoGuardar = "addBecaGrp";
	if (Beca == '') {
		swal("Error al guardar", "Debe escribir la beca que desea agregar.", "error");
		document.getElementById("txtBeca").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta beca a este grupo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdGrupo=' + IdGrupo + '&IdCampus=' + IdCampus + '&IdPlan=' + IdPlan + '&Beca=' + Beca;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Guardado correctamente", "Beca generado al grupo correctamente.", "success");
							parent.location.href = 'alSelBeca.php?C=' + IdCampus + '&G=' + IdGrupo + '&P=' + IdPlan; //direcciona la pagina madre
						}

						if (data == 0) {
							swal("Error al agregar", "No se puede agregar beca, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x128", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function mostrarPermisos(IdUsua) {

	$.ajax({
		url: "formConsulta/viewPermisos.php",
		method: "POST",
		data: { IdUsua: IdUsua },
		success: function (data) {
			$('#empl_ModPermisos').html(data);
			$('#dataModPermisos').modal('show');
		}
	});

}


function saveActividad() {
	var TipoA = document.getElementById("txtTipoA").value;
	var Actividad = document.getElementById("txtActividad").value;

	var IdOferta = document.getElementById("IdOferta").value;
	var IdModulo = document.getElementById("IdModulo").value;
	var IdParcial = document.getElementById("IdParcial").value;
	var IdSemana = document.getElementById("IdSemana").value;
	var IdUsua = document.getElementById("IdUsua").value;
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var FecIni = document.getElementById("datepicker1").value;
	var FecFin = document.getElementById("datepicker2").value;
	var Porcentaje = document.getElementById("txtPorcentaje").value;
	var Proyecto = document.getElementById("Proyecto").value;
	var Entrega = document.getElementById("txtEntrega").value;
	var Estrategia = document.getElementById("txtEstrategias").value;
	var Tecnica = document.getElementById("txtTecnica").value;
	var Herramienta = document.getElementById("txtHerramienta").value;

	if (TipoA == '') {
		swal("Error al guardar", "Debe seleccionar el tipo de actividad.", "error");
		document.getElementById("txtTipoA").focus();
		return 0;
	}
	if (Actividad == '') {
		swal("Error al guardar", "Debe escribir el nombre de la actividad.", "error");
		document.getElementById("txtActividad").focus();
		return 0;
	}

	if (FecIni == '') {
		swal("Error al guardar", "Debe seleecionar la fecha de activaci\u00F3n.", "error");
		document.getElementById("datepicker1").focus();
		return 0;
	}
	if (FecFin == '') {
		swal("Error al guardar", "Debe seleecionar la fecha final.", "error");
		document.getElementById("datepicker2").focus();
		return 0;
	}

	if ((TipoA == 1) || (TipoA == 2) || (TipoA == 3)) {
		if (Porcentaje == '') {
			swal("Error al guardar", "Debe escribir el porcentaje.", "error");
			document.getElementById("txtPorcentaje").focus();
			return 0;
		}
	}
	if (TipoA == 3) {
		if (Entrega == '') {
			swal("Error al guardar", "Debe seleccionar el tipo de entrega.", "error");
			document.getElementById("txtEntrega").focus();
			return 0;
		}
	}
	if (Estrategia == '') {
		swal("Error al guardar", "Debe seleccionar la estrategia.", "error");
		document.getElementById("txtEstrategias").focus();
		return 0;
	}
	if (Tecnica == '') {
		swal("Error al guardar", "Debe seleccionar la técnica.", "error");
		document.getElementById("txtTecnica").focus();
		return 0;
	}
	if (Herramienta == '') {
		swal("Error al guardar", "Debe seleccionar la herramienta.", "error");
		document.getElementById("txtHerramienta").focus();
		return 0;
	}
	var TipoGuardar = "savActividad";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar \u00E9sta nueva actividad?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2TYj').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Agregado correctamente", "Actividad creada correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcial;
						}
						if (data == 2) {
							swal("Error al guardar", "Revise el porcentaje a asignar.", "error");
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						alert(data);
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function savClase() {
	var Campus = document.getElementById("txt_campus").value;
	var Oferta = document.getElementById("txt_oferta").value;
	var Materia = document.getElementById("txt_materia").value;
	var Ciclo = document.getElementById("txt_ciclo").value;
	var Grupo = document.getElementById("txt_grupo").value;

	if (Campus == '') {
		swal("Error al guardar", "Debe seleccionar el campus/escuela.", "error");
		document.getElementById("txt_campus").focus();
		return 0;
	}
	if (Oferta == '') {
		swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
		document.getElementById("txt_oferta").focus();
		return 0;
	}

	if (Materia == '') {
		swal("Error al guardar", "Debe seleccionar la materia.", "error");
		document.getElementById("txt_materia").focus();
		return 0;
	}
	if (Ciclo == '') {
		swal("Error al guardar", "Debe seleccionar el ciclo escolar.", "error");
		document.getElementById("txt_ciclo").focus();
		return 0;
	}
	if (Grupo == '') {
		swal("Error al guardar", "Debe seleccionar el grupo.", "error");
		document.getElementById("txt_grupo").focus();
		return 0;
	}

	swal({
		title: "\u00BFEst\u00E1 seguro que desea crear esta nueva clase?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdModulo=' + IdModulo + '&IdSemana=' + IdSemana + '&TipoA=' + TipoA + '&IdParcial=' + IdParcial + '&Descripcion=' + Descripcion + '&Actividad=' + Actividad + '&IdUsua=' + IdUsua + '&IdAsignacion=' +IdAsignacion + '&FecIni=' + FecIni + '&FecFin=' + FecFin + '&Porcentaje=' + Porcentaje;
				var datos = $('#frm2TYj').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Creado correctamente", "La clase fue creada correctamente.", "success");
							parent.location.href = 'misClases.php';
						}
						if (data == 2) {
							swal("Error al guardar", "Esta clase ya fue creada.", "error");
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function carMaterias() {
	var IdCiclo = document.getElementById("IdCicloX").value;
	var IdGrupo = document.getElementById("IdGrupoX").value;
	var Grado = document.getElementById("txtGradoX").value;
	var Cargar = document.getElementById("Cargar").value;

	if (Grado == '') {
		swal("Error al guardar", "Debe seleccionar el grado de estudio.", "error");
		document.getElementById("txtEntrega").focus();
		return 0;
	}

	var TipoGuardar = "loadMatrs";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea cargar las materias de este grado de estudio?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdOferta=' + IdOferta + '&IdModulo=' + IdModulo + '&IdSemana=' + IdSemana + '&TipoA=' + TipoA + '&IdParcial=' + IdParcial + '&Descripcion=' + Descripcion + '&Actividad=' + Actividad + '&IdUsua=' + IdUsua + '&IdAsignacion=' +IdAsignacion + '&FecIni=' + FecIni + '&FecFin=' + FecFin + '&Porcentaje=' + Porcentaje;
				var datos = $('#frm2TYjS').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Agregado correctamente", "Actividad creada correctamente.", "success");
							parent.location.href = 'adHorario.php?idC=' + IdCiclo + '&idG=' + IdGrupo;
						}

						if (data == 0) {
							swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


function val_viewForo(IdActividad, IdUsua) {
	var mensaje = document.getElementById("txtMensaje-" + IdActividad).value;
	var IdAsignacion = document.getElementById("Id").value;
	var Tipo = "val_viewForo";
	var txtAre = "#txtMensaje-" + IdActividad;
	if (mensaje == "") {
		swal("Error al guardar", "Debe escribir su comentario.", "error");
		document.getElementById("txtMensaje-" + IdActividad).focus(); return 0;
	}
	var datos = 'IdActividad=' + IdActividad + '&Mensaje=' + mensaje + '&TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua + '&IdAsignacion=' + IdAsignacion;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	}).done(function (data) {
		if (data == 1) {
			swal("Guardado correctamente", "Comentario agregado correctamente.", "success");
			recargarTabla(IdActividad);

		} else {
			swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
		}
	})

}

function envioRespuesta(IdResultado) {
	var Respuesta = document.getElementById("txtRespuesta").value;
	var IdActividadDoc = document.getElementById("IdActividadDoc").value;
	var IdParcialDoc = document.getElementById("IdParcialDoc").value;
	var IdTarea = document.getElementById("IdTarea").value;

	if (Respuesta == '') {
		swal("Error al guardar", "Debe escribir su respuesta a esta pregunta.", "error");
		document.getElementById("txtRespuesta").focus();
		return 0;
	}


	var TipoGuardar = "savRespuetsaExs";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea enviar esta respuesta?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&Respuesta=' + Respuesta + '&IdResultado=' + IdResultado;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Guardado correctamente", "Respuesta ha sido guardado correctamente.", "success");
							parent.location.href = 'viewEvaYseC.php?Id=8752342637' + IdActividadDoc + '&IdP=3647589753' + IdParcialDoc + '&IdT=8630253762' + IdTarea;
						}
						if (data == 2) {
							swal("Error al mostrar", "No se puede mostrar la evaluaci\u00F3n, debe crear primero la evaluaci\u00F3n.", "success");

						}
						if (data == 0) {
							swal("Error al publicar", "No se puede publicar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}


function savPermUser() {
	var IdUsua = document.getElementById("IdUsua").value;
	var FechaActivo = document.getElementById("Fecha").value;
	var Fecha = document.getElementById("datepicker").value;
	var Token = IdUsua;
	if (FechaActivo) {
		chkL = document.getElementById("txtChk").checked;

		if (chkL == true) { chkLink = 1; } else { chkLink = 0; }

	} else {
		chkLink = 0;
	}



	if (Fecha == '') {
		swal("Error al guardar", "Debe seleccionar la fecha limite de ingreso de este usuario.", "error");
		document.getElementById("datepicker").focus();
		return 0;
	}



	var TipoGuardar = "savPerUser";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos cambios?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsua=' + IdUsua + '&Fecha=' + Fecha + '&chkLink=' + chkLink;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Guardado correctamente", "Los datos han sidos guardado correctamente.", "success");
							$.ajax({
								url: "formConsulta/addPermiso.php",
								method: "POST",
								data: { Token: Token },
								success: function (data) {
									$('#employee_detail8').html(data);
									$('#dataModal8').modal('show');
								}
							});


						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}


function savProrro() {
	var IdUsua = document.getElementById("IdUsua").value;
	var Token = IdUsua;

	chkL = document.getElementById("txtChkPro").checked;

	if (chkL == true) { chkLink = 1; } else { chkLink = 0; }

	var TipoGuardar = "savProrro";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos cambios de prorroga?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsua=' + IdUsua + '&chkLink=' + chkLink;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Guardado correctamente", "Los datos han sidos guardado correctamente.", "success");
							$.ajax({
								url: "formConsulta/addPermiso.php",
								method: "POST",
								data: { Token: Token },
								success: function (data) {
									$('#employee_detail8').html(data);
									$('#dataModal8').modal('show');
								}
							});


						}
					})
					.error(function (data) {
						swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}
		});
}

function delParcial(IdParcial) {
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var TipoGuardar = "delParcial";

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este parcial, recuerde que si tiene unidades, actividades se eliminar\u00E1n tambi\u00E9n?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdParcial=' + IdParcial;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {

						if (data == 1) {
							swal("Eliminado correctamente", "El parcial se ha eliminado correctamente.", "success");
							parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion; //direcciona la pagina madre
							// parent.location.href='doMiPlaneacion.php?idToks='+IdAsignacion; //direcciona la pagina madre
						}
						if (data == 0) {
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function addNewRecursar(valor) { document.frm.IdAsig.value = valor; swal({ title: "\u00BFEst\u00E1 seguro que desea asignar a este alumno a esta materia?", type: "warning", showCancelButton: true, confirmButtonColor: '#DD6B55', confirmButtonText: 'Aceptar', cancelButtonText: "Cancelar", }, function (isConfirm) { if (isConfirm) { document.frm.Mov.value = 'AddMRecursar'; document.frm.submit(); return true; } else { return false; } }); }

function delPagoAprob(IdPago, IdUsua, IdFolio, IdAdmin) {
	var TipoGuardar = "del_pagoAprobado";
	var Token = '4587598645' + IdUsua;
	swal({
		title: "Est\u00E1 seguro que desea eliminar este pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdPago=' + IdPago + '&IdUsua=' + IdUsua + '&IdFolio=' + IdFolio + '&IdAdmin=' + IdAdmin;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {
						//alert(data);
					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Eliminado correctamente", "El pago se ha eliminado correctamente.", "success");
							$.ajax({
								url: "formConsulta/addPago.php",
								method: "POST",
								data: { Token: Token, IdPago: IdPago },
								success: function (data) {
									$('#employee_detail7').html(data);
									$('#dataModal7').modal('show');
								}
							});
						}
						if (data == 0) {
							swal("Error al eliminar", "No se puede eliminar recargo.", "error");
						}
					})
					.error(function (data) {
						swal("Error al guardar 0x18", "No se puede guardar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function matAvance() {
	var IdModulo = document.getElementById("IdModulo").value;
	var IdGrado = document.getElementById("txtIdGrado").value;
	var Code = document.getElementById("txtCode").value;

	if (IdGrado == '') {
		swal("Error al guardar", "Debe selecionar el cuatrimestre.", "error");
		document.getElementById("txtIdGrado").focus();
		return 0;
	}
	if (Code == '') {
		swal("Error al guardar", "Debe escribir el CodeModulo.", "error");
		document.getElementById("txtIdGrado").focus();
		return 0;
	}

	//var TipoGuardar = "savDattCurso";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos cambios?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdActividadDoc=' + IdActividadDoc + '&Descripcion=' + Descripcion + '&Actividad=' + Actividad + '&FecIni=' + FecIni + '&FecFin=' + FecFin + '&Porcentaje=' + Porcentaje + '&IdUsua=' + IdUsua;
				var datos = $('#frm5Vkb').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Datos actulizados correctamente.", "success");
						}

						if (data == 0) {
							swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

function saveHra(IdModulo, Campo) {
	var Code = document.getElementById("txtCode").value;
	var Horas = document.getElementById(Campo).value;

	if (Horas == '') {
		swal("Error al guardar", "Debe ingresar el numero de horas.", "error");
		document.getElementById(Campo).focus();
		return 0;
	}


	var TipoGuardar = "add_hora";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar estos cambios?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = 'TipoGuardar=' + TipoGuardar + '&IdModulo=' + IdModulo + '&Code=' + Code + '&Campo=' + Campo + '&Horas=' + Horas;
				// var datos=$('#frm5hb').serialize();
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Datos actulizados correctamente.", "success");
						}

						if (data == 0) {
							swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}

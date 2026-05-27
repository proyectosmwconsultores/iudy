<?php
require('php/clases/class.php');
$t=new Trabajo();
$tipo = $_POST["TipoGuardar"];
// if($tipo == "Login"){
// 		echo $t->LoginUser();

// 	}else
	
	if($tipo == "val_adAddOferta"){
			echo $t->add_OfertaE();

	}elseif($tipo == "savCedula"){
			echo $t->add_cedula();

	}elseif($tipo == "sav_cedula_id"){
			echo $t->add_cedula_id();

	}elseif($tipo == "val_adAddPlan"){
			echo $t->add_planProy();

	}elseif($tipo == "val_delCalExcel"){
	$IdUsua = $_POST['IdUsua'];
echo $t->del_calExcel($IdUsua);

}elseif($tipo == "val_savCali"){
	$IdUsua = $_POST['IdUsua'];
	$Oferta = $_POST['Oferta'];
	$Modulo = $_POST['Modulo'];
	$IdCiclo = $_POST['IdCiclo'];
	$IdDocente = $_POST['IdDocente'];
	$Fecha = $_POST['Fecha'];
	$IdGrupo = $_POST['IdGrupo'];
	$IdCampus = $_POST['IdCampus'];

echo $t->add_savCali($IdUsua,$Oferta,$Modulo,$IdCiclo,$IdDocente,$Fecha,$IdGrupo,$IdCampus);
}elseif($tipo == "val_adAddCveGrupo"){
			echo $t->add_cveGrupo();

	}elseif($tipo == "val_addCveGrp"){
				echo $t->add_addCveGprs();

		}elseif($tipo == "adAddCicloEscV"){
			echo $t->add_CicloEscolar();

	}elseif($tipo == "mi_Editor"){
			echo $t->add_miEditor();

	}elseif($tipo == "savCursodat"){
			echo $t->add_daCrusorT();

	}elseif($tipo == "addTemas"){
			echo $t->add_Temas();

	}elseif($tipo == "mi_Updeditor"){
			echo $t->upd_miEditor();

	}elseif($tipo == "updCicloEscV"){
		$IdCiclo = $_POST['IdCiclo'];
		$FecIni = $_POST['FecIni'];
		$FecFin = $_POST['FecFin'];
		$Codigo = $_POST['Codigo'];
			echo $t->upd_CicloEscolar($IdCiclo,$FecIni,$FecFin,$Codigo);

	}elseif($tipo == "addSubPeriodo"){
		$IdCiclo = $_POST['IdCiclo'];
		$FecIni = $_POST['FecIni'];
		$FecFin = $_POST['FecFin'];
		$Codigo = $_POST['Codigo'];
		$Sub = $_POST['Sub'];
			echo $t->add_subPeriodo($IdCiclo,$FecIni,$FecFin,$Codigo,$Sub);

	}elseif($tipo == "addApertura"){
		$IdCiclo = $_POST['IdCiclo'];
		$FecFin = $_POST['FecFin'];
		$Tipo = $_POST['Tipo'];
		$Parcial = $_POST['Parcial'];
			echo $t->add_apertura($IdCiclo,$FecFin,$Tipo,$Parcial);

	}elseif($tipo == "delSubPeriodo"){
		$IdCiclo = $_POST['IdCiclo'];
		$SubPeriodo = $_POST['SubPeriodo'];
			echo $t->del_subPeriodo($IdCiclo,$SubPeriodo);

	}elseif($tipo == "delApertura"){
		$IdApertura = $_POST['IdApertura'];
			echo $t->del_apertura($IdApertura);

	}elseif($tipo == "delTema"){
		$IdTema = $_POST['IdTema'];
			echo $t->del_Tema($IdTema);

	}elseif($tipo == "savBanco"){
		$IdCampus = $_POST['IdCampus'];
		$Nombre = $_POST['Nombre'];
		$Banco = $_POST['Banco'];
		$Cuenta = $_POST['Cuenta'];
		$Clabe = $_POST['Clabe'];
		$Convenio = $_POST['Convenio'];
		echo $t->add_savBanco($Nombre,$Banco,$Cuenta,$Clabe,$Convenio,$IdCampus);

	}elseif($tipo == "savParcial"){
		echo $t->add_savParcial();

	}elseif($tipo == "updParcial"){
		// $IdParcialDoc = $_POST['IdParcialDoc'];
		// $Tema = $_POST['Tema'];
		// $Objetivo = $_POST['Objetivo'];
		// $IdUsua = $_POST['IdUsua'];

		// echo $t->add_updParcial($IdParcialDoc,$Tema,$Objetivo,$IdUsua);
		echo $t->add_updParcial();

	}elseif($tipo == "addAsignatura"){
		$CodeModulo = $_POST['CodeModulo'];
		$Asignatura = $_POST['Asignatura'];

		echo $t->add_asignatura($CodeModulo,$Asignatura);

	}elseif($tipo == "add_Asignaturax"){
		$Oferta = $_POST['Oferta'];
		$Asignatura = $_POST['Asignatura'];
		$Campus = $_POST['Campus'];

		echo $t->add_asigNew($Oferta,$Asignatura,$Campus);

	}elseif($tipo == "updSemana"){
		echo $t->add_updSemana();

	}elseif($tipo == "addPresent"){

		echo $t->add_Present();
	}elseif($tipo == "updFuente"){

		echo $t->add_updFuente();
	}elseif($tipo == "changePass"){
		$IdUsua = $_POST['IdUsuaXL'];
		$Anterior = $_POST['Anterior'];
		$Nueva = $_POST['Nueva'];

		echo $t->add_changePass($IdUsua,$Anterior,$Nueva);
	}elseif($tipo == "savSemana"){
		echo $t->add_savSemana();

	}elseif($tipo == "savSemblanza"){
		$Semblanza = $_POST['Semblanza'];
		$IdUsua = $_POST['IdUsua'];

		echo $t->add_savSemblanza($Semblanza,$IdUsua);

	}elseif($tipo == "savGrados"){
		$Grado = $_POST['Grado'];
		$Nombre = $_POST['Nombre'];
		$IdUsua = $_POST['IdUsua'];

		echo $t->add_savGrados($Grado,$Nombre,$IdUsua);

	}elseif($tipo == "delGrados"){
		$IdGrado = $_POST['IdGrado'];

		echo $t->add_delGrados($IdGrado);

	}elseif($tipo == "savActividad"){

		echo $t->add_savActividad();
	}elseif($tipo == "savClase"){

		echo $t->add_savClase();
	}elseif($tipo == "loadMatrs"){
		echo $t->add_loadMtrss();


	}elseif($tipo == "savBeca"){

		echo $t->add_savBeca();


	}elseif($tipo == "savFuente"){
		// $IdOferta = $_POST['IdOferta'];
		// $IdModulo = $_POST['IdModulo'];
		// $IdParcial = $_POST['IdParcial'];
		// $IdSemana = $_POST['IdSemana'];
		// $Descripcion = $_POST['Descripcion'];
		// $IdUsua = $_POST['IdUsua'];
		// $IdAsignacion = $_POST['IdAsignacion'];
		echo $t->add_savFuente();
		// echo $t->add_savFuente($IdOferta,$IdModulo,$IdParcial,$IdSemana,$Descripcion,$IdUsua,$IdAsignacion);

	}elseif($tipo == "updActividadDoc"){

		echo $t->add_updActividadDoc();

	}elseif($tipo == "envioRevision"){
		$IdUsua = $_POST['IdUsua'];
		$IdAsignacion = $_POST['IdAsignacion'];
		$IdPlaneacion = $_POST['IdPlaneacion'];

		echo $t->add_envioRevision($IdUsua,$IdAsignacion,$IdPlaneacion);

	}elseif($tipo == "updateBanco"){
		$IdBanco = $_POST['IdBanco'];
		$Nombre = $_POST['Nombre'];
		$Banco = $_POST['Banco'];
		$Cuenta = $_POST['Cuenta'];
		$Clabe = $_POST['Clabe'];
		$Convenio = $_POST['Convenio'];
		echo $t->add_updateBanco($IdBanco,$Nombre,$Banco,$Cuenta,$Clabe,$Convenio);

	}elseif($tipo == "copyParcial"){
		$IdParcial = $_POST['IdParcial'];
		$IdUsua = $_POST['IdUsua'];
		$IdAsignacion = $_POST['IdAsignacion'];
		echo $t->add_copiParcial($IdParcial,$IdUsua,$IdAsignacion);

	}elseif($tipo == "copyExamen"){
		$IdParcial = $_POST['IdParcial'];
		$IdUsua = $_POST['IdUsua'];
		$IdAsignacion = $_POST['IdAsignacion'];
		$IdActividad = $_POST['IdActividad'];
		$IdActividadAnt = $_POST['IdActividadAnt'];
		echo $t->add_copyExamen($IdParcial,$IdUsua,$IdAsignacion,$IdActividad,$IdActividadAnt);

	}elseif($tipo == "copyPlaneacion"){
		$IdParcial = $_POST['IdParcial'];
		$IdUsua = $_POST['IdUsua'];
		echo $t->add_copiPlaneacion($IdParcial,$IdUsua);

	}elseif($tipo == "cambiosParcial"){
		$IdAsignacion = $_POST['IdAsignacion'];
		$IdUsua = $_POST['IdUsua'];
		$IdEstatus = $_POST['IdEstatus'];
		$IdPlaneacion = $_POST['IdPlaneacion'];
		echo $t->add_cambiosParcial($IdAsignacion,$IdUsua,$IdEstatus,$IdPlaneacion);

	}elseif($tipo == "activarActividad"){
		$IdActividad = $_POST['IdActividad'];
		$IdParcial = $_POST['IdParcial'];

		echo $t->add_activarActividad($IdActividad,$IdParcial);

	}elseif($tipo == "activar_evaluacion_id"){
		$IdActividad = $_POST['IdActividad'];
		$IdParcial = $_POST['IdParcial'];

		echo $t->add_activar_eva_id($IdActividad,$IdParcial);

	}elseif($tipo == "estatusBanco"){
		$IdBanco = $_POST['IdBanco'];
		$Estatus = $_POST['Estatus'];
		echo $t->add_estatusBanco($IdBanco,$Estatus);

	}elseif($tipo == "saveConfigur"){
		$valorIngreso = $_POST['valorIngreso'];
		$id = $_POST['id'];
		echo $t->upd_configuracion($valorIngreso,$id);

	}
	elseif($tipo == "saveConcepto"){
		$valorIngreso = $_POST['valorIngreso'];
		$campo = $_POST['campo'];
		$idconcepto = $_POST['idconcepto'];
		echo $t->upd_precioCpt($valorIngreso,$campo,$idconcepto);

	}elseif($tipo == "deleteConcepto"){
		$idconcepto = $_POST['idconcepto'];
		echo $t->del_concepto($idconcepto);

	}elseif($tipo == "saveNewDocs"){
		$valorIngreso = $_POST['valorIngreso'];
		$grado = $_POST['Grado'];
		echo $t->upd_newDocsIng($valorIngreso,$grado);

	}elseif($tipo == "saveConceptoN"){
		$valorIngreso = $_POST['valorIngreso'];
		echo $t->add_newConcepto($valorIngreso);

	}elseif($tipo == "addEnlazar"){
			echo $t->add_Enlazar();

	}elseif($tipo == "val_adUpdOferta"){
			echo $t->upd_OfertaE();

	} elseif($tipo == "val_adUpdModulo"){
		echo $t->Upd_Modulo();

	}elseif($tipo == "val_adAddModConfig"){
		echo $t->add_ModuloDocente();

	}elseif($tipo == "val_adUpdModConfig"){
		echo $t->upd_ModuloDocente();


	}elseif($tipo == "addMatricula"){
		echo $t->add_Matricula();

	}
	elseif($tipo == "val_adAddUsuario"){
		echo $t->add_Usuario();

	}elseif($tipo == "add_alumno"){
		echo $t->add_alumno();

	}elseif($tipo == "add_alumno_ex"){
		echo $t->add_alumno_ex();

	}elseif($tipo == "val_adUpdUsuario"){
			echo $t->upd_Usuario();

	}elseif($tipo == "val_adAddGrupo"){
		$IdAsignacion = $_POST['IdAsignacion'];
		$Equipo = $_POST['Equipo'];
		$IdUsua = $_POST['alumno'];
		echo $t->add_GrupoAlumno($IdAsignacion,$Equipo,$IdUsua);

	}elseif($tipo == "delUsuaario"){
		$IdUsua = $_POST['IdUsua'];
		echo $t->add_delUsua($IdUsua);

	}elseif($tipo == "val_adAddCalificar"){
	$IdAsignacion = $_POST['IdAsignacion'];
	$IdAlumno = $_POST['IdAlumno'];
	$Calificacion = $_POST['calificacion'];
	$IdTarea = $_POST['IdTarea'];
	$IdUsua = $_POST['IdUsua'];
	$TipoCalificar = $_POST['TipoCalificar'];
	$equipo = $_POST['equipo'];
	$MaxCalificacion = $_POST['MaxCalificacion'];
	$IdActividadDoc = $_POST['IdActividadDoc'];

	echo $t->add_Calificaciones($IdAsignacion,$IdAlumno,$Calificacion,$IdTarea,$IdUsua,$TipoCalificar,$equipo,$MaxCalificacion,$IdActividadDoc);

	}elseif($tipo == "val_viewForo"){
	$IdActividad = $_POST['IdActividad'];
	$Mensaje = $_POST['Mensaje'];
	$IdUsua = $_POST['IdUsua'];
	$IdAsignacion = $_POST['IdAsignacion'];
	echo $t->add_ForoRespuestas($IdActividad,$Mensaje,$IdUsua,$IdAsignacion);

	}elseif($tipo == "val_doAddConfigExamen"){
		$IdAsignacion = $_POST['IdAsignacion'];
		$NoActividad = $_POST['NoActividad'];
		$txtNoPregunta = $_POST['txtNoPregunta'];
		$txtPregunta = $_POST['txtPregunta'];
		echo $t->add_preguntaExamen($IdAsignacion,$NoActividad,$txtNoPregunta,$txtPregunta);

	}elseif($tipo == "mostrarExamen"){
		$IdAsignacion = $_POST['IdAsignacion'];
		$NoActividad = $_POST['NoActividad'];
		echo $t->add_mostrarExamen($IdAsignacion,$NoActividad);

	}elseif($tipo == "AddPregunta"){
		$IdExamen = $_POST['IdExamen'];
		$txtRespuesta1 = $_POST['txtRespuesta1'];
		$txtRespuesta2 = $_POST['txtRespuesta2'];
		$txtRespuesta3 = $_POST['txtRespuesta3'];
		$txtValor = $_POST['txtValor'];
		echo $t->add_respuestaspreguntaExamen($IdExamen,$txtRespuesta1,$txtRespuesta2,$txtRespuesta3,$txtValor);

	}elseif($tipo == "var_respuesta"){
	$IdRespuesta = $_POST['IdRespuesta'];
	$NoPregunta = $_POST['NoPregunta'];
	$IdUsua = $_POST['IdUsua'];
	$IdAsignacion = $_POST['IdAsignacion'];
	$NoActividad = $_POST['NoActividad'];
	echo $t->add_respuestaAlumno($IdRespuesta,$NoPregunta,$IdUsua,$IdAsignacion,$NoActividad);

	}elseif($tipo == "savExamenRes"){
	$IdResultado = $_POST['IdResultado'];
	$IdPregunta = $_POST['IdPregunta'];
	$IdRespuesta = $_POST['IdRespuesta'];

	echo $t->add_resExamen($IdResultado,$IdPregunta,$IdRespuesta);

	}elseif($tipo == "var_eliminarR"){
	$IdRespuesta = $_POST['IdRespuesta'];
	echo $t->del_respuesta($IdRespuesta);

	}elseif($tipo == "var_eliminarPreg"){
	$IdExamen = $_POST['IdExamen'];
	echo $t->del_preguntas($IdExamen);

	}elseif($tipo == "val_addserf"){
	$Clave = $_POST['Clave'];
	echo $t->add_claveSer($Clave);

}elseif($tipo == "val_delUsuario"){
$IdUsua = $_POST['IdUsua'];
echo $t->del_prospectoNew($IdUsua);

}elseif($tipo == "load_pagos"){
$IdUsua = $_POST['IdUsua'];
echo $t->load_padosPen($IdUsua);

}elseif($tipo == "val_delRegExcel"){
	$IdUsua = $_POST['IdUsua'];
echo $t->del_excel($IdUsua);

}elseif($tipo == "val_delUsersExcel"){
	$IdUsua = $_POST['IdUsua'];
echo $t->del_usersExcel($IdUsua);

}elseif($tipo == "val_delCatMod"){
	$IdUsua = $_POST['IdUsua'];
echo $t->del_catMod($IdUsua);

}elseif($tipo == "val_delSaldo"){
	$IdUsua = $_POST['IdUsua'];
echo $t->del_Saldo($IdUsua);

}elseif($tipo == "val_closeGrupo"){
	$IdUsua = $_POST['IdUsua'];
	$IdGrupo = $_POST['IdGrupo'];
echo $t->add_closeGrupo($IdUsua,$IdGrupo);
}elseif($tipo == "val_savUsers"){
	$IdUsua = $_POST['IdUsua'];
echo $t->add_savUsers($IdUsua);
}elseif($tipo == "val_subAsignatura"){
	$IdUsua = $_POST['IdUsua'];

echo $t->add_addAsignaturasTb($IdUsua);
}elseif($tipo == "val_addSaldoIni"){
	$IdUsua = $_POST['IdUsua'];

echo $t->add_addSaldoIni($IdUsua);
}elseif($tipo == "addUserCurso"){
		$IdUsua = $_POST['IdUsua'];
		$IdAsignacion = $_POST['IdAsignacion'];
		$IdEducativa = $_POST['IdEducativa'];
		$Modulo = $_POST['Modulo'];
		echo $t->add_userCurso($IdUsua,$IdAsignacion,$IdEducativa,$Modulo);

	}elseif($tipo == "delUserCurso"){
			$IdUsua = $_POST['IdUsua'];
			$IdAsignacion = $_POST['IdAsignacion'];
			$IdEducativa = $_POST['IdEducativa'];
			$Modulo = $_POST['Modulo'];
			echo $t->del_userCurso($IdUsua,$IdAsignacion,$IdEducativa,$Modulo);

			}elseif($tipo == "AddTareaComentario"){
	$IdTarea = $_POST['IdTarea'];
	$txtMensaje = $_POST['txtMensaje'];
	$IdUsua = $_POST['IdUsua'];
	$IdUsua_recibe = $_POST['IdUsua_recibe'];
	$IdActividadDoc = $_POST['IdActividadDoc'];
	$Tipo = $_POST['Tipo'];
	echo $t->add_tareacomentario($IdTarea,$txtMensaje,$IdUsua,$Tipo,$IdUsua_recibe,$IdActividadDoc);

}elseif($tipo == "chatPlaneacion"){
$Tipo = $_POST['Tipo'];
$IdAsignacion = $_POST['IdAsignacion'];
$IdPlaneacion = $_POST['IdPlaneacion'];
$IdUsua = $_POST['IdUsua'];
$Chat = $_POST['Chat'];
echo $t->add_chatPlaneacion($Tipo,$IdAsignacion,$IdUsua,$Chat,$IdPlaneacion);

}elseif($tipo == "addNotificacion"){
$IdEncargado = $_POST['IdEncargado'];
$txtMensaje = $_POST['Mensaje'];
$IdUsua = $_POST['IdUsua'];
$IdPermiso = $_POST['IdPermiso'];
echo $t->add_notificarP($IdEncargado,$txtMensaje,$IdUsua,$IdPermiso);

}elseif($tipo == "activarExtra"){
	$IdParcialDoc = $_POST['IdParcialDoc'];
$IdPlaneacion = $_POST['IdPlaneacion'];
echo $t->add_activarExtra($IdParcialDoc,$IdPlaneacion);

}elseif($tipo == "actExtraAlum"){
	$IdUsua = $_POST['IdUsua'];
  $IdAsignacion = $_POST['IdAsignacion'];
echo $t->add_actExtraAlumno($IdAsignacion,$IdUsua);

}elseif($tipo == "actLista"){
	$IdLista = $_POST['IdLista'];
	$Dia = $_POST['Dia'];
  $TipoAsis = $_POST['TipoAsis'];
echo $t->add_actLista($IdLista,$Dia,$TipoAsis);

}elseif($tipo == "pasarList"){
	$IdAsistencia = $_POST['IdAsistencia'];
	$IdTipo = $_POST['IdTipo'];

echo $t->add_pasarLista($IdAsistencia,$IdTipo);

}elseif($tipo == "actExtraAlum2"){
	$IdUsua = $_POST['IdUsua'];
  $IdAsignacion = $_POST['IdAsignacion'];
echo $t->add_actExtraAlumno2($IdAsignacion,$IdUsua);

}elseif($tipo == "actExtraAlum3"){
	$IdUsua = $_POST['IdUsua'];
  $IdAsignacion = $_POST['IdAsignacion'];
echo $t->add_actExtraAlumno3($IdAsignacion,$IdUsua);

}elseif($tipo == "actRecursarAlum"){
	$IdUsua = $_POST['IdUsua'];
  $IdAsignacion = $_POST['IdAsignacion'];
echo $t->add_actRecursarAlum($IdAsignacion,$IdUsua);

}elseif($tipo == "add_cveGrupoT"){
$CveGrupo = $_POST['CveGrupo'];
$IdUsua = $_POST['IdAlumno'];
echo $t->add_cveGrupoT($IdUsua,$CveGrupo);

} elseif($tipo == "cerrarEstatus"){
$IdOferta = $_POST['IdOferta'];
$IdUsua = $_POST['IdAlumno'];
$Inscripcion = $_POST['Inscripcion'];
$Colegiatura = $_POST['Colegiatura'];
$Fecha = $_POST['Fecha'];
$IdGrado = $_POST['IdGrado'];
echo $t->add_cerrarEstatus($IdOferta,$IdUsua,$Inscripcion,$Colegiatura,$Fecha,$IdGrado);

}elseif($tipo == "closeServicio"){
$NomPrograma = $_POST['NomPrograma'];
$NomDependencia = $_POST['NomDependencia'];
$Periodo = $_POST['Periodo'];
$Fecha = $_POST['Fecha'];
$IdUsua = $_POST['IdUsua'];
$Registro = $_POST['Registro'];
echo $t->add_closeServicio($NomPrograma,$NomDependencia,$Periodo,$Fecha,$IdUsua,$Registro);

}elseif($tipo == "NewPago"){
$IdUsua = $_POST['IdUsua'];
$Plan = $_POST['Plan'];
$Ciclo = $_POST['Ciclo'];
echo $t->add_newPago($IdUsua,$Plan,$Ciclo);

}elseif($tipo == "new_pago_posgrado"){
$IdUsua = $_POST['IdUsua'];
$Plan = $_POST['Plan'];
$Ciclo = $_POST['Ciclo'];
$Fecha = $_POST['Fecha'];
$IdAdmin = $_POST['IdAdmin'];
echo $t->new_pago_posgrado($IdUsua,$Plan,$Ciclo,$Fecha,$IdAdmin);

}elseif($tipo == "addSaldIni"){
$IdPago = $_POST['IdPago'];
$Comentario = $_POST['Comentario'];
$Forma = $_POST['Forma'];
$IdUsua = $_POST['IdUsua'];
$Fecha = $_POST['Fecha'];
$IdBanco = $_POST['IdBanco'];
$Pago = $_POST['Pago'];
$IdEstatus = $_POST['IdEstatus'];
$IdProcedencia = $_POST['IdProcedencia'];
$IdAdmin = $_POST['IdAdmin'];

echo $t->add_cerrarSalIni($IdPago,$Comentario,$Forma,$IdUsua,$Fecha,$IdBanco,$Pago,$IdEstatus,$IdProcedencia,$IdAdmin);

}elseif($tipo == "addNewReinco"){
$IdUsua = $_POST['IdUsua'];
$IdGrupo = $_POST['Grupo'];
$IdCiclo = $_POST['Ciclo'];

echo $t->add_newReincor($IdUsua,$IdGrupo,$IdCiclo);

}elseif($tipo == "add_cerrarGrupoX"){
$IdGrupo = $_POST['IdGrupo'];
$Oferta = $_POST['Oferta'];
echo $t->add_cerrarGrupoX($IdGrupo,$Oferta);

}elseif($tipo == "docComprobante"){
$Estatus = $_POST['Estatus'];
$IdDocumento = $_POST['IdDocumento'];
$Tipo = $_POST['Tipo'];
$Tramite = $_POST['Tramite'];
echo $t->add_docComproban($Estatus,$IdDocumento,$Tipo,$Tramite);

}
elseif($tipo == "delDocumentoDoc"){
$IdDocumento = $_POST['IdDocumento'];
echo $t->add_delDocumentoD($IdDocumento);

}
elseif($tipo == "delContratoDoc"){
$IdContrato = $_POST['IdContrato'];
echo $t->add_delContrato($IdContrato);

}
elseif($tipo == "delDocAlumno"){
	$IdDocumento = $_POST['IdDocumento'];
	$Tramite = $_POST['Tramite'];

echo $t->add_delDocAlumno($IdDocumento,$Tramite);

}elseif($tipo == "delDocAspirante"){
	$IdDocumento = $_POST['IdDocumento'];
	$Tramite = $_POST['Tramite'];

echo $t->add_delDocAspirante($IdDocumento,$Tramite);

}elseif($tipo == "genDescuento"){
	$IdPago = $_POST['IdPago'];
	$IdTipoDescuento = $_POST['IdTipoDescuento'];
	$Comentario = $_POST['Comentario'];
	$Porcentaje = $_POST['Porcentaje'];
	$FecLimite = $_POST['FecLimite'];
	$Descuento = $_POST['Descuento'];

echo $t->add_genDescuento($IdPago,$IdTipoDescuento,$Comentario,$Porcentaje,$FecLimite,$Descuento);
}elseif($tipo == "addPagoNvo"){
	$IdAlumno = $_POST['IdAlumno'];
	$Porcentaje = $_POST['Porcentaje'];
	$FecLimite = $_POST['FecLimite'];
	$IdConcepto = $_POST['IdConcepto'];
	$Monto = $_POST['Monto'];
	$DesGenerado = $_POST['DesGenerado'];

echo $t->add_PagoNvoIng($IdAlumno,$Porcentaje,$FecLimite,$IdConcepto,$Monto,$DesGenerado);
}elseif($tipo == "closePagoNvo"){
	$IdAlumno = $_POST['IdAlumno'];

echo $t->add_closePagoNvo($IdAlumno);
}elseif($tipo == "modCalificacion"){
	$IdCalificacion = $_POST['IdCalificacion'];
	$IdUsua = $_POST['IdUsua'];
	$Calificacion = $_POST['Calificacion'];
	$Pass1 = $_POST['Pass1'];
	$Pass2 = $_POST['Pass2'];

echo $t->add_modCalificacion($IdCalificacion,$IdUsua,$Calificacion,$Pass1,$Pass2);
}elseif($tipo == "facturarPago"){
	$IdPago = $_POST['IdPago'];
	$TipoValor = $_POST['TipoValor'];
	$IdUsua = $_POST['IdUsua'];

echo $t->upd_facPago($IdPago,$TipoValor,$IdUsua);
}elseif($tipo == "addHorario"){
	$IdAsignacion = $_POST['IdAsignacion'];
	$IdHorario = $_POST['IdHorario'];
	$HraIni = $_POST['HraIni'];
	$MinIni = $_POST['MinIni'];
	$HraFin = $_POST['HraFin'];
	$MinFin = $_POST['MinFin'];
	$Total = $_POST['Total'];

echo $t->upd_horario($IdAsignacion,$IdHorario,$HraIni,$MinIni,$HraFin,$MinFin,$Total);
}elseif($tipo == "addFechfIN"){
	$IdParcialDoc = $_POST['IdParcialDoc'];
	$Fecha = $_POST['Fecha'];


echo $t->upd_fechaFinPar($IdParcialDoc,$Fecha);
}elseif($tipo == "addHorarioDoIn"){
	$IdAsignacion = $_POST['IdAsignacion'];
	$HraD = $_POST['HraD'];
	$HraI = $_POST['HraI'];

echo $t->upd_horarioFos($IdAsignacion,$HraD,$HraI);
}elseif($tipo == "addRvoe"){
	$Rvoe = $_POST['Rvoe'];
	$Vigencia = $_POST['Vigencia'];
	$Turno = $_POST['Turno'];
	$Modalidad = $_POST['Modalidad'];
	$IdRvoe = $_POST['IdRvoe'];
	$Escuela = $_POST['Escuela'];
	$Localidad = $_POST['Localidad'];
	$Clave_dgp = $_POST['Clave_dgp'];
	$Oferta = $_POST['Oferta'];
	$Clave_rpe = $_POST['Clave_rpe'];
	$Ciclo = $_POST['Ciclo'];
	$Anio = $_POST['Anio'];
	$Duracion = $_POST['Duracion'];
	$Cct = $_POST['Cct'];
	$Clave_estadistica = $_POST['Clave_estadistica'];
	
	

echo $t->add_rvoe($Rvoe,$Vigencia,$Turno,$Modalidad,$IdRvoe,$Escuela,$Localidad,$Clave_dgp,$Oferta,$Clave_rpe,$Ciclo,$Anio,$Duracion,$Cct,$Clave_estadistica);
}elseif($tipo == "updGrupoP"){
	$IdGrupo = $_POST['IdGrupo'];
	$Estatus = $_POST['Estatus'];
	$Periodo = $_POST['Periodo'];
	$Disponible = $_POST['Disponible'];
	$Inicio = $_POST['Inicio'];
	$Final = $_POST['Final'];

echo $t->add_updGrupo($IdGrupo,$Estatus,$Periodo,$Disponible,$Inicio,$Final);
}elseif($tipo == "addFirma"){
	$Rector = $_POST['Rector'];
	$Escolar = $_POST['Escolar'];
	$Oficina = $_POST['Oficina'];
	$Departamento = $_POST['Departamento'];
	$IdCampus = $_POST['IdCampus'];
	$Elaboro = $_POST['Elaboro'];
	$Educacion = $_POST['Educacion'];
	$Coordinadora = $_POST['Coordinadora'];
	$Responsable = $_POST['Responsable'];
	$Servicio = $_POST['Servicio'];

echo $t->add_firmas($Rector,$Escolar,$Oficina,$Departamento,$IdCampus,$Elaboro,$Educacion,$Coordinadora,$Responsable,$Servicio);
}elseif($tipo == "addInfoAsig"){
	$Modulo = $_POST['Modulo'];
	$Texto = $_POST['Texto'];
	$IdTipo = $_POST['IdTipo'];
	$Oferta = $_POST['Oferta'];

echo $t->upd_datAsig($Modulo,$Texto,$IdTipo,$Oferta);
}elseif($tipo == "add_con_carta"){
	$Modulo = $_POST['Modulo'];
	$Contenido = $_POST['Contenido'];
	$Id_contenido = $_POST['Id_contenido'];

echo $t->upd_conte_carta($Modulo,$Contenido,$Id_contenido);
}elseif($tipo == "addPregunEx"){
	$Pregunta = $_POST['Pregunta'];
	$IdActividadDoc = $_POST['IdActividadDoc'];
	$IdParcialDoc = $_POST['IdParcialDoc'];
	$IdUsua = $_POST['IdUsua'];
	$IdAsignacion = $_POST['IdAsignacion'];

echo $t->add_examPreg($Pregunta,$IdActividadDoc,$IdParcialDoc,$IdUsua,$IdAsignacion);
}elseif($tipo == "addRespuesEx"){
	$Pregunta = $_POST['Pregunta'];
	$Respuesta = $_POST['Respuesta'];
	$A = $_POST['A'];
	$B = $_POST['B'];
	$C = $_POST['C'];
	$D = $_POST['D'];
	$E = $_POST['E'];
	$F = $_POST['F'];

echo $t->add_examResp($Pregunta,$Respuesta,$A,$B,$C,$D,$E,$F);
}elseif($tipo == "delRespuesEx"){
	$IdPregunta = $_POST['IdPregunta'];

echo $t->del_respusEx($IdPregunta);
}elseif($tipo == "delPreguntaEx"){
	$IdPregunta = $_POST['IdPregunta'];

echo $t->del_preguntEx($IdPregunta);
}elseif($tipo == "updCosto"){
	$IdAsignacion = $_POST['IdAsignacion'];
	$Costo = $_POST['Costo'];
	$IdUsua = $_POST['IdUsua'];

echo $t->upd_costoPlan($IdAsignacion,$Costo,$IdUsua);
}elseif($tipo == "addCostPlan"){
	$IdCampus = $_POST['IdCampus'];
	$Nombre = $_POST['Nombre'];
	$IdNivel = $_POST['IdNivel'];
	$Costo = $_POST['Costo'];
	$Concepto = $_POST['Concepto'];
	$IdUsua = $_POST['IdUsua'];
	$Recargo = $_POST['Recargo'];
	$Unidad = $_POST['Unidad'];
	$Producto = $_POST['Producto'];

echo $t->add_costoPlan($IdCampus,$Nombre,$IdNivel,$IdUsua,$Concepto,$Costo,$Recargo,$Producto,$Unidad);
}elseif($tipo == "addSolicitud"){
	$Concepto = $_POST['Concepto'];
	$IdUsua = $_POST['IdUsua'];
	$FechaLim = $_POST['FechaLim'];
echo $t->add_solPago($Concepto,$IdUsua,$FechaLim);
}
elseif($tipo == "addDocSolicitado"){
	$IdDoc = $_POST['IdDoc'];
echo $t->add_docSolicitado($IdDoc);
}elseif($tipo == "addEncuesta"){
	$IdRespuesta = $_POST['IdRespuesta'];
	$Valor = $_POST['Valor'];
echo $t->add_resEncuesta($IdRespuesta,$Valor);
}elseif($tipo == "addEncuestaCal"){
	$IdRespuesta = $_POST['IdRespuesta'];
	$Valor = $_POST['Valor'];
echo $t->add_resEncuestaCal($IdRespuesta,$Valor);
}elseif($tipo == "addEncuestaOtro"){
	$IdRespuesta = $_POST['IdRespuesta'];
	$Texto = $_POST['Texto'];
echo $t->add_resEncuestaOtro($IdRespuesta,$Texto);
}elseif($tipo == "cerrarEncuesta"){
	$IdUsua = $_POST['IdUsua'];
	$IdAsignacion = $_POST['IdAsignacion'];
echo $t->add_cerrarEncuesta($IdUsua,$IdAsignacion);
}elseif($tipo == "delActividad"){
	$IdActividadDoc = $_POST['IdActividadDoc'];

echo $t->del_delActividad($IdActividadDoc);
}elseif($tipo == "delBeca"){
	$IdBeca = $_POST['IdBeca'];

echo $t->del_delBeca($IdBeca);
}elseif($tipo == "sendPlan"){
	$IdPlan = $_POST['IdPlan'];

echo $t->add_senPLan($IdPlan);
}elseif($tipo == "addPlanPa"){
	$IdOferta = $_POST['IdOferta'];
	$IdConceptoPlan = $_POST['IdConceptoPlan'];
	$IdConcepto = $_POST['IdConcepto'];

echo $t->add_addPlanPa($IdOferta,$IdConceptoPlan,$IdConcepto);
}elseif($tipo == "delPlanPa"){
	$IdOferta = $_POST['IdOferta'];
	$IdConceptoPlan = $_POST['IdConceptoPlan'];
	$IdConcepto = $_POST['IdConcepto'];

echo $t->del_delPlanPa($IdOferta,$IdConceptoPlan,$IdConcepto);
}elseif($tipo == "delCicloGrupo"){
	$IdCicloGrupo = $_POST['IdCicloGrupo'];
	$IdGrupo = $_POST['IdGrupo'];
	$IdCiclo = $_POST['IdCiclo'];

echo $t->del_enlaceGrupo($IdCicloGrupo,$IdGrupo,$IdCiclo);
}elseif($tipo == "addMatriSe"){
	$IdOferta = $_POST['IdOferta'];
	$IdCampus = $_POST['IdCampus'];
	$Tipo = $_POST['Tipo'];
	$Valor = $_POST['Valor'];

echo $t->add_mstruics($IdOferta,$IdCampus,$Tipo,$Valor);
}elseif($tipo == "delAsignacion"){
	$IdAsignacion = $_POST['employee_id'];


echo $t->del_asignacion($IdAsignacion);
}elseif($tipo == "savCurso"){
	$IdCurso = $_POST['IdCurso'];
	$Curso = $_POST['Curso'];
	$IdCampus = $_POST['IdCampus'];

echo $t->add_savCurso($IdCurso,$Curso,$IdCampus);
}elseif($tipo == "addFiltro"){
	$Filtro = $_POST['Filtro'];
	$Tabla = $_POST['Tabla'];
	$IdPago = $_POST['IdPago'];
	$IdUsua = $_POST['IdUsua'];
	$IdRecargo = $_POST['IdRecargo'];


echo $t->add_filtro($Filtro,$Tabla,$IdPago,$IdUsua,$IdRecargo);
}elseif($tipo == "del_recargo"){
	$IdPago = $_POST['IdPago'];
	$IdUsua = $_POST['IdUsua'];
	$IdRecargo = $_POST['IdRecargo'];

echo $t->del_recargo($IdPago,$IdUsua,$IdRecargo);
}elseif($tipo == "addBecaGrp"){
	$IdGrupo = $_POST['IdGrupo'];
	$IdCampus = $_POST['IdCampus'];
	$IdPlan = $_POST['IdPlan'];
	$Beca = $_POST['Beca'];

echo $t->add_becagrp($IdGrupo,$IdCampus,$IdPlan,$Beca);
}elseif($tipo == "mostrarEvalua"){
		$IdActividad = $_POST['IdActividad'];
		$IdParcial = $_POST['IdParcial'];

		echo $t->add_mostrarEcav($IdActividad,$IdParcial);

	}elseif($tipo == "savRespuetsaExs"){
		$IdResultado = $_POST['IdResultado'];
		$Respuesta = $_POST['Respuesta'];

		echo $t->add_savresExav($IdResultado,$Respuesta);

	}elseif($tipo == "savPerUser"){
		$IdUsua = $_POST['IdUsua'];
		$Fecha = $_POST['Fecha'];
		$Chk = $_POST['chkLink'];


		echo $t->add_savPerUs($IdUsua,$Fecha,$Chk);

	}
	elseif($tipo == "savProrro"){
		$IdUsua = $_POST['IdUsua'];
		$IdAdmin = $_POST['IdAdmin'];
		$Fecha = $_POST['Fecha'];
		$Comentario = $_POST['Comentario'];

		echo $t->add_savProrro($IdUsua,$IdAdmin,$Fecha,$Comentario);
	}elseif($tipo == "cancelar_prorroga"){
		$IdUsua = $_POST['IdUsua'];
		$Id = $_POST['Id'];
		
		echo $t->cancel_prorroga_id($IdUsua,$Id);
	}elseif($tipo == "delParcial"){
	$IdParcial = $_POST['IdParcial'];

echo $t->del_delParcial($IdParcial);
}elseif($tipo == "del_pagoAprobado"){
	$IdPago = $_POST['IdPago'];
	$IdUsua = $_POST['IdUsua'];
	$IdFolio = $_POST['IdFolio'];
	$IdAdmin = $_POST['IdAdmin'];

echo $t->del_pagoAprobado($IdPago,$IdUsua,$IdFolio,$IdAdmin);
} elseif($tipo == "matAvance"){
			echo $t->upd_matAvance();

}elseif($tipo == "add_hora"){
	$IdModulo = $_POST['IdModulo'];
	$Code = $_POST['Code'];
	$Campo = $_POST['Campo'];
	$Horas = $_POST['Horas'];

echo $t->add_hora($IdModulo,$Code,$Campo,$Horas);
}elseif($tipo == "addCampusNew"){

	echo $t->add_newCampus();
}elseif($tipo == "updCampuss"){

	echo $t->add_updCampus();
}elseif($tipo == "updEvals"){

	echo $t->add_updEvals();
}elseif($tipo == "addEvalsf"){

	echo $t->add_newEvals();
}elseif($tipo == "updPreguts"){

	echo $t->add_updPregs();
}elseif($tipo == "addPreguts"){

	echo $t->add_newPregunts();
}elseif($tipo == "addRespuex"){
	$IdRespuesta = $_POST['IdRespuesta'];
	$Valor = $_POST['Valor'];
	$Respuesta = $_POST['Respuesta'];
	$Estatus = $_POST['Estatus'];

echo $t->addRespuexNew($IdRespuesta,$Valor,$Respuesta,$Estatus);
}elseif($tipo == "addRespuexNew"){
	$IdPregunta = $_POST['IdPregunta'];
	$Valor = $_POST['Valor'];
	$Respuesta = $_POST['Respuesta'];

echo $t->add_respuesNew($IdPregunta,$Valor,$Respuesta);
}elseif($tipo == "todosPagos"){
$Forma = $_POST['Forma'];
$IdUsua = $_POST['IdUsua'];
$Fecha = $_POST['Fecha'];
$Folio = $_POST['Folio'];
// $Descuento = $_POST['Descuento'];
$IdUsuaCap = $_POST['IdUsuaCap'];
$Division = $_POST['Division'];
$TPagar = $_POST['TPagar'];
$IdBanco = $_POST['IdBanco'];
$Nota = $_POST['Nota'];
$IdProcedencia = $_POST['IdProcedencia'];
$IdAdmin = $_POST['IdAdmin'];

echo $t->add_pagosTodos($Forma,$IdUsua,$Fecha,$IdUsuaCap,$Division,$TPagar,$IdBanco,$Nota,$IdProcedencia,$IdAdmin,$Folio);

}elseif($tipo == "sav_pagos_especial"){
	$Forma = $_POST['Forma'];
	$IdUsua = $_POST['IdUsua'];
	$Fecha = $_POST['Fecha'];
	$Folio = $_POST['Folio'];
	$IdUsuaCap = $_POST['IdUsuaCap'];
	$Division = $_POST['Division'];
	$TPagar = $_POST['TPagar'];
	$IdBanco = $_POST['IdBanco'];
	$Nota = $_POST['Nota'];
	$IdProcedencia = $_POST['IdProcedencia'];
	$IdAdmin = $_POST['IdAdmin'];
	$IdTemporal = $_POST['IdTemporal'];
	
	echo $t->add_pagos_especiales_all($Forma,$IdUsua,$Fecha,$IdUsuaCap,$Division,$TPagar,$IdBanco,$Nota,$IdProcedencia,$IdAdmin,$Folio,$IdTemporal);
	
}elseif($tipo == "sav_pagos_especial_addx"){
	$IdUsua = $_POST['IdUsua'];
	$Division = $_POST['Division'];
	$TPagar = $_POST['TPagar'];
	$Nota = $_POST['Nota'];
	$IdAdmin = $_POST['IdAdmin'];
	$IdTemporal = $_POST['IdTemporal'];
	
	echo $t->add_pag_espex_all($IdUsua,$Division,$TPagar,$Nota,$IdAdmin,$IdTemporal);
	
}elseif($tipo == "gen_constcnai_ser"){
$IdServicio = $_POST['IdServicio'];
$Dep = $_POST['Dep'];
$Pro = $_POST['Pro'];
$Per = $_POST['Per'];
$Fec = $_POST['Fec'];
$Regx = $_POST['Regx'];


echo $t->add_gen_constanci_ser($IdServicio,$Dep,$Pro,$Per,$Fec,$Regx);
} elseif($tipo == "gen_constcnai_ser_cart"){
	$IdServicio = $_POST['IdServicio'];
	$Dep = $_POST['Dep'];
	$Pro = $_POST['Pro'];
	$Per = $_POST['Per'];
	$Fec = $_POST['Fec'];
	$No = $_POST['No'];
	$Gra = $_POST['Gra'];
	$Res = $_POST['Res'];

echo $t->add_gen_constanci_ser_cart($IdServicio,$Dep,$Pro,$Per,$Fec,$No,$Gra,$Res);
}elseif($tipo == "del_docs_tramite"){
	$IdDocumento = $_POST['IdDocumento'];
echo $t->add_del_docs_tramite($IdDocumento);

}




?>

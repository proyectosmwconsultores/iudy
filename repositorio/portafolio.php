<?php
require('system.php');
class Imprimir
{

	public function get_dias_clases($IdAsignacion,$Tiempo) {
    $db = new Conexion();
    $get_dias_clases = [];
		if($Tiempo == 0){ $cond = ""; } else { $cond = " AND tblp_asistencia.AnioMes = '$Tiempo'"; }

    $sql = $db->query("SELECT tblp_asistencia.IdAsistencia, tblp_asistencia.Fecha FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion =  '$IdAsignacion' $cond GROUP BY tblp_asistencia.Fecha ORDER BY tblp_asistencia.Fecha ASC");
    while($x = $db->recorrer($sql)){
      $get_dias_clases[] = $x;
    }
    return $get_dias_clases;
	}

	public function get_usuario_id($IdUsua) {
		$db = new Conexion();
		$get_usuario_id = [];

		$sql = $db->query("SELECT
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblp_educativa.Nombre AS Educativa,
tblp_grupo.CveGrupo,
tblp_grupo.Modalidad,
tblc_grado._Grado,
tblp_informacion.P_depende,
tblp_informacion.P_civil,
tblp_informacion.D_direccion,
tblp_informacion.E_opcion_titulacion,
tblp_informacion.Trabaja,
tblp_informacion.Tel_trabajo,
tblp_informacion.Fecha_titulacion,
tblp_informacion.IdTitulacion,
tblp_informacion.IdPeriodo_egreso,
tblp_informacion.Monto,
tblc_tipo_titulacion.Nombre_titulacion,
tblc_periodo.Periodo,
tblp_educativa.IdGrado
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado
Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua
Left Join tblc_tipo_titulacion ON tblc_tipo_titulacion.IdTitulacion = tblp_informacion.IdTitulacion
Left Join tblc_periodo ON tblc_periodo.IdPeriodo = tblp_informacion.IdPeriodo_egreso WHERE tblc_usuario.IdUsua = '$IdUsua'");
		while($x = $db->recorrer($sql)){
			$get_usuario_id[] = $x;
		}
		return $get_usuario_id;
	}

	public function get_docs_id($IdUsua) {
		$db = new Conexion();
		$get_docs_id = [];
		$sql = $db->query("SELECT tblp_documentos.IdDocumento, tblp_documentos.IdUsua, tblp_documentos.Si, tblp_documentos.Co, tblh_tipodocumento.Nombre FROM tblp_documentos Left Join tblh_tipodocumento ON tblh_tipodocumento.IdTipoDoc = tblp_documentos.IdTipoDocumento WHERE tblp_documentos.IdUsua =  '$IdUsua'");
		while($x = $db->recorrer($sql)){
			$get_docs_id[] = $x;
		}
		return $get_docs_id;
	}
	
	public function get_costos_pag($IdOferta,$IdCiclo) {
		$db = new Conexion();
		$get_docs_id = [];
		$sql = $db->query("SELECT
tblc_conceptosdetalle.IdConceptoDetalle,
tblc_conceptosplanes.NomPlan,
tblc_costos_ciclo.Monto,
tblc_costos_ciclo.Numero
FROM
tblc_conceptosdetalle
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan
Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan
WHERE
tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND
tblc_costos_ciclo.IdCiclo =  '$IdCiclo'
");
		while($x = $db->recorrer($sql)){
			$get_docs_id[] = $x;
		}
		return $get_docs_id;
	}
	
	public function get_mis_docs_id($IdUsua) {
		$db = new Conexion();
		$sql9 = $db->query("SELECT tblc_usuario.Grado FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
          $db->rows($sql9);
          $datos91 = $db->recorrer($sql9);
          $_grado = $datos91["Grado"];
          $docs = $db->query("SELECT * FROM tblh_tipodocumento WHERE tblh_tipodocumento.IdEstatus = '8' AND tblh_tipodocumento.Grado = '$_grado'");
           while($_docs = $db->recorrer($docs)){
             $_idTipoD = $_docs['IdTipoDoc'];
        
             $sqlx = $db->query("SELECT tblp_documentos.IdDocumento FROM tblp_documentos WHERE tblp_documentos.IdUsua = '$IdUsua' AND tblp_documentos.IdTipoDocumento = '$_idTipoD'");
             $db->rows($sqlx);
             $dxs = $db->recorrer($sqlx);
             $_idDocx = $dxs["IdDocumento"];
             if(!$_idDocx){
               $sql = $db->query("INSERT INTO tblp_documentos (IdUsua, IdTipoDocumento) VALUES ('$IdUsua','$_idTipoD') ");
             }
        
           }
   
		$get_mis_docs_id = [];
		$sql = $db->query("SELECT tblp_documentos.IdDocumento, tblp_documentos.IdUsua, tblp_documentos.Si, tblp_documentos.No, tblp_documentos.Co, tblh_tipodocumento.Nombre FROM tblp_documentos Left Join tblh_tipodocumento ON tblh_tipodocumento.IdTipoDoc = tblp_documentos.IdTipoDocumento WHERE tblp_documentos.IdUsua =  '$IdUsua' AND tblh_tipodocumento.IdEstatus = '8' AND tblh_tipodocumento.Solicitado = 1 ");
		while($x = $db->recorrer($sql)){
			$get_mis_docs_id[] = $x;
		}
		return $get_mis_docs_id;
	}
	
	
	public function get_datos_campus_rvoe($IdUsua) {
		$db = new Conexion();
		$get_datos_campus_rvoe = [];
		$sql = $db->query("SELECT tblc_usuario.IdUsua, tblp_grupo.id_rvoe, tblp_grupo.id_campus, tblc_campus._logoPdf, tblc_campus._titulo, tblc_usuario.IdGrupo, tblc_rvoe.Educativa FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.id_campus Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblp_grupo.id_rvoe WHERE tblc_usuario.IdUsua =  '$IdUsua'");
		while($x = $db->recorrer($sql)){
			$get_datos_campus_rvoe[] = $x;
		}
		return $get_datos_campus_rvoe;
	}

	public function dats_constancia($qrCode) {
		$db = new Conexion();
		$dats_constancia = [];

		$sql = $db->query("SELECT
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_docs_solicitados.IdDocumento,
tblc_ciclo.Ciclo,
tblp_docs_solicitados.FecCap,
tblp_docs_solicitados.Anio,
tblp_docs_solicitados.Mes,
tblp_docs_solicitados.FecLimite,
tblp_docs_solicitados.Fecha,
tblp_docs_solicitados.qrCode,
tblc_ciclo.FInicio,
tblc_ciclo.FFinal,
tblc_usuario.Usuario,
tblp_educativa.Nombre AS Educativa,
tblc_modalidad.Modalidad,
tblp_grupo.Modalidad AS `Mod`,
tblc_ciclogrupo.Grado
FROM
tblp_docs_solicitados
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_docs_solicitados.IdUsua
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs_solicitados.IdCiclo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_docs_solicitados.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_docs_solicitados.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_docs_solicitados.IdGrupo
WHERE
tblp_docs_solicitados.qrCode =  '$qrCode'
");
		while($x = $db->recorrer($sql)){
			$dats_constancia[] = $x;
		}
		return $dats_constancia;
	}

	public function get_seguimiento_us($IdUsua) {
		$db = new Conexion();
		$get_seguimiento_us = [];
		$sql = $db->query("SELECT
	tblp_seguimiento.IdSeguimiento,
	tblp_seguimiento.FecCap,
	tblp_seguimiento.Comentario_control,
	tblp_seguimiento.Comentario_usuario,
	tblc_ciclo.Ciclo,
	tblc_usuario.Nombre,
	tblc_usuario.APaterno,
	tblc_usuario.AMaterno,
	tblc_usuario.Foto,
	tblc_tipo_seguimiento.Seguimiento
	FROM
	tblp_seguimiento
	Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_seguimiento.IdCiclo
	Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_seguimiento.IdUsua_admin
	Left Join tblc_tipo_seguimiento ON tblc_tipo_seguimiento.IdTipoSeguimiento = tblp_seguimiento.IdTipoSeguimiento
	WHERE tblp_seguimiento.IdUsua = '$IdUsua' ORDER BY tblp_seguimiento.FecCap DESC");
		while($x = $db->recorrer($sql)){
			$get_seguimiento_us[] = $x;
		}
		return $get_seguimiento_us;
	}

	public function get_lstFir($IdCampus,$IdGrado){
		$db = new Conexion();
		$gCixcl8U = [];
		$sql = $db->query("SELECT * FROM tblc_firmas WHERE tblc_firmas.IdCampus = '$IdCampus' AND tblc_firmas.IdGrado = '$IdGrado'");
		while($x = $db->recorrer($sql)){
			$gCixcl8U[] = $x;
		}
		return $gCixcl8U;
	}
	
	public function get_horas_id($IdAsignacion){
		$db = new Conexion();
		$gCixcl8U = [];
		$sql = $db->query("SELECT Sum(tblp_horario.Total) AS Total FROM tblp_horario WHERE tblp_horario.IdAsignacion =  '$IdAsignacion' ");
		while($x = $db->recorrer($sql)){
			$gCixcl8U[] = $x;
		}
		return $gCixcl8U;
	}
	
	public function get_materia_id($IdAsignacion){
		$db = new Conexion();
		$get_materia_id = [];
		
		$sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_modulo.Grado,
tblp_modulo.NombreMod,
tblc_periodo.Periodo,
tblc_ciclo.Tipo,
tblc_ciclo.Ciclo,
tblp_educativa.IdGrado,
tblp_educativa.Nombre
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblc_periodo ON tblc_periodo.IdPeriodo = tblc_ciclo.IdPeriodo
LEFT JOIN tblp_educativa ON tblp_asignacion.IdEducativa = tblp_educativa.IdEducativa
WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2' ");
		while($x = $db->recorrer($sql)){
			$get_materia_id[] = $x;
		}
		return $get_materia_id;
	}

  public function get_user_lista($IdAsignacion) {
    $db = new Conexion();
    $get_user_lista = [];
		$sql = $db->query("SELECT tblp_moduloalumno.IdUsua, tblc_usuario.Usuario, tblc_usuario.Foto, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' ORDER BY tblc_usuario.APaterno ASC");
    while($x = $db->recorrer($sql)){
      $get_user_lista[] = $x;
    }
    return $get_user_lista;
	}
	
	  public function get_contrato_id($IdAsignacion) {
        $db = new Conexion();
        $get_contrato_id = [];
    		$sql = $db->query("SELECT * FROM tblp_contrato WHERE tblp_contrato.IdAsignacion =  '$IdAsignacion' ");
        while($x = $db->recorrer($sql)){
          $get_contrato_id[] = $x;
        }
        return $get_contrato_id;
	}
	
	public function get_datos_docente_id($IdAsignacion) {
    $db = new Conexion();
    $get_datos_docente_id = [];
		$sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdUsua,
tblp_asignacion._fec_contrato,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.id_paquete,
tblc_usuario._nacimiento,
tblc_usuario._nacionalidad,
tblc_usuario._rfc,
tblc_usuario._escolaridad,
tblc_usuario._banco,
tblc_usuario._cuenta,
tblc_usuario._elector,
tblc_usuario._prefijo,
tblc_usuario._domicilio,
tblc_usuario.Curp,
tblc_usuario.FecNac
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
WHERE
tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND
tblp_asignacion.Tipo =  '2'
");
    while($x = $db->recorrer($sql)){
      $get_datos_docente_id[] = $x;
    }
    return $get_datos_docente_id;
	}
	

	public function get_prom_grupo($IdAsignacion,$Promedio) {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Promedio = '$Promedio' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
	}

	public function get_imp_reconocimiento($Id) {
		$db = new Conexion();
		$get_lstAlumno = [];
		$sql = $db->query("SELECT tblp_constancia_lista.Lugar, tblp_constancia_lista.Promedio, tblc_ciclo.Ciclo, tblp_educativa.IdGrado, tblp_educativa.Nombre AS Educativa, tblc_grado.Descripcion, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_constancia_lista.Fecha FROM tblp_constancia_lista Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_constancia_lista.IdCiclo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_constancia_lista.IdOferta Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado Left Join tblc_usuario ON tblc_usuario.Usuario = tblp_constancia_lista.Usuario WHERE tblp_constancia_lista.IdConstancia =  '$Id' ");
		while($x = $db->recorrer($sql)){
			$get_imp_reconocimiento[] = $x;
		}
		return $get_imp_reconocimiento;
	}


  public function get_valos_asis($IdAsignacion,$IdUsua,$Fecha) {
    $db = new Conexion();
    $get_valos_asis = [];

    $sql = $db->query("SELECT
tblp_asistencia.IdAsistencia,
tblc_tipo_asistencia.Icono,
tblc_tipo_asistencia.Letra,
tblc_tipo_asistencia.IdTipo,
tblp_asistencia.Observaciones
FROM
tblp_asistencia
Left Join tblc_tipo_asistencia ON tblc_tipo_asistencia.IdTipo = tblp_asistencia.IdTipo
WHERE tblp_asistencia.IdAsignacion = '$IdAsignacion' AND tblp_asistencia.IdUsua = '$IdUsua' AND tblp_asistencia.Fecha = '$Fecha'");
    while($x = $db->recorrer($sql)){
      $get_valos_asis[] = $x;
    }
    return $get_valos_asis;
	}

	public function get_lstGrupo($IdAsignacion) {
		$db = new Conexion();
		$get_lstGrupo = [];
		$sql = $db->query("SELECT tblp_moduloalumno.IdUsua, tblp_moduloalumno.Promedio, tblc_usuario.Usuario, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblc_usuario.IdCampus FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '50')) ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC, tblc_usuario.Nombre ASC ");
		while($x = $db->recorrer($sql)){
			$get_lstGrupo[] = $x;
		}
		return $get_lstGrupo;
	}

	public function get_calificacion_grupo_final($IdAsignacion) {
		$db = new Conexion();
		$get_calificacion_grupo_final = [];
		$sql = $db->query("SELECT tblc_usuario.IdCampus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblp_calificacion.IdCalificacion, tblp_calificacion.P1, tblp_calificacion.P2, tblp_calificacion.E1, tblp_calificacion.E2, tblp_calificacion.Promedio, tblp_calificacion.A, tblp_calificacion.F FROM tblp_calificacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacion.IdUsua WHERE tblp_calificacion.IdAsignacion =  '$IdAsignacion' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC, tblc_usuario.Nombre ASC");
		while($x = $db->recorrer($sql)){
			$get_calificacion_grupo_final[] = $x;
		}
		return $get_calificacion_grupo_final;
	}

	public function get_sat_us($IdUsua) {
		$db = new Conexion();
		$get_sat_us = [];
	
		$sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.IdGrupo,
tblc_usuario.Correo,
tblc_usuario.IdOferta,
tblc_usuario.Telefono,
tblc_usuario.SemCua,
tblc_usuario.Grado,
tblc_usuario.Celular,
tblc_usuario.FecNac,
tblc_usuario.id_paquete,
tblc_usuario.Sexo,
tblc_usuario.Foto,
tblc_usuario.id_ciclo_ini,
tblp_educativa.Nombre AS Educativa,
tblp_grupo.IdGrupo,
tblp_grupo.TipoCiclo,
tblp_grupo.Grupo,
tblp_grupo.Dia,
tblc_grado.IdGrado,
tblc_grado._Grado,
tblc_dias_clases._Dias,
tblc_modalidad._Modalidad
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
WHERE
tblc_usuario.IdUsua =  '$IdUsua'
");
		while($x = $db->recorrer($sql)){
			$get_sat_us[] = $x;
		}
		return $get_sat_us;
	}

	public function get_enca_list($IdAsignacion) {
		$db = new Conexion();
		$get_enca_list = [];
		
		// $sql = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.Fecha = '2023-02-06'");
		// $sql = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.Fecha = '2024-03-25'");
		// $sql = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.Fecha = '2024-03-26'");
		// $sql = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.Fecha = '2024-03-27'");
		// $sql = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.Fecha = '2024-03-28'");
		// $sql = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.Fecha = '2024-03-29'");
		// $sql = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.Fecha = '2024-03-30'");
		// $sql = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.Fecha = '2024-03-31'");
		
		

		$sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_educativa.Nombre AS Educativa,
tblp_modulo.NombreMod,
tblc_ciclogrupo.Grado,
tblp_grupo.Grupo,
tblp_grupo.Ingles,
tblp_grupo.CveGrupo,
tblp_grupo.TipoCiclo,
tblc_ciclo.Ciclo,
tblc_ciclo.FFinal,
tblc_periodo.Periodo
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_asignacion.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo
Left Join tblc_periodo ON tblc_periodo.IdPeriodo = tblc_ciclo.IdPeriodo
WHERE
tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND
tblp_asignacion.Tipo =  '2'");
		while($x = $db->recorrer($sql)){
			$get_enca_list[] = $x;
		}
		return $get_enca_list;
	}

	public function get_lista_alumnos($IdAsignacion) {
		$db = new Conexion();
		$get_enca_list = [];

		$sql = $db->query("SELECT tblp_moduloalumno.IdUsua, tblc_usuario.Usuario, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_estatus.Estatus FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC");
		while($x = $db->recorrer($sql)){
			$get_enca_list[] = $x;
		}
		return $get_enca_list;
	}

	public function get_lst_asis($IdAsignacion) {
		$db = new Conexion();
		$get_lst_asis = [];
		$sql = $db->query("SELECT
tblp_asistencia.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario
FROM
tblp_asistencia
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asistencia.IdUsua
WHERE
tblp_asistencia.IdAsignacion =  '$IdAsignacion'
GROUP BY
tblp_asistencia.IdUsua
ORDER BY
tblc_usuario.Usuario ASC");
		while($x = $db->recorrer($sql)){
			$get_lst_asis[] = $x;
		}
		return $get_lst_asis;
	}
	
	public function get_lst_alumno_asis($IdAsignacion) {
		$db = new Conexion();
		$get_lst_asis = [];
		$sql = $db->query("SELECT
tblp_asistencia.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario
FROM
tblp_asistencia
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asistencia.IdUsua
WHERE
tblp_asistencia.IdAsignacion =  '$IdAsignacion'
GROUP BY
tblp_asistencia.IdUsua
ORDER BY
tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC");
		while($x = $db->recorrer($sql)){
			$get_lst_asis[] = $x;
		}
		return $get_lst_asis;
	}

	public function get_lst_prom($IdAsignacion) {
		$db = new Conexion();
		$get_lst_prom = [];

		$sql = $db->query("SELECT
tblp_calificacion.IdCalificacion,
tblp_calificacion.Promedio,
tblp_calificacion.P1,
tblp_calificacion.P2,
tblp_calificacion.P3,
tblp_calificacion.F1,
tblp_calificacion.F2,
tblp_calificacion.F3,
tblp_calificacion._obs,
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario
FROM
tblp_calificacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacion.IdUsua
WHERE
tblp_calificacion.IdAsignacion =  '$IdAsignacion'
ORDER BY
tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC
");
		while($x = $db->recorrer($sql)){
			$get_lst_prom[] = $x;
		}
		return $get_lst_prom;
	}

	public function get_lst_dias($IdAsignacion) {
		$db = new Conexion();
		$get_lst_dias = [];
		$sql = $db->query("SELECT tblp_asistencia.Fecha FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_asistencia.Fecha ORDER BY tblp_asistencia.Fecha ASC ");
		while($x = $db->recorrer($sql)){
			$get_lst_dias[] = $x;
		}
		return $get_lst_dias;
	}

	public function get_lst_mat($IdGrupo, $grado) {
		$db = new Conexion();
		$get_lst_mat = [];

		$sqlx9 = $db->query("SELECT tblp_grupo.IdOferta FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
		$db->rows($sqlx9);
		$datosx91 = $db->recorrer($sqlx9);
		$IdOferta = $datosx91['IdOferta'];


		$sql = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.Code, tblp_modulo.Oferta, tblp_modulo.CodeModulo, tblp_modulo.Tipo, tblp_modulo.NombreMod FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.Grado =  '$grado' ORDER BY tblp_modulo.CodeModulo ASC");
		while($x = $db->recorrer($sql)){
			$get_lst_mat[] = $x;
		}
		return $get_lst_mat;
	}

	public function get_all_mat($IdGrupo, $grado) {
		$db = new Conexion();
		$get_all_mat = [];
		$sqlx9 = $db->query("SELECT tblp_grupo.IdOferta FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
		$db->rows($sqlx9);
		$datosx91 = $db->recorrer($sqlx9);
		$IdOferta = $datosx91['IdOferta'];

		$sql = $db->query("SELECT Count(tblp_modulo.IdModulo) AS Total FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.Grado =  '$grado' AND tblp_modulo.Tipo =  '1'");
		while($x = $db->recorrer($sql)){
			$get_all_mat[] = $x;
		}
		return $get_all_mat;
	}

	public function get_cal_mat($IdUsua, $IdModulo) {
		$db = new Conexion();
		$get_cal_mat = [];

		$sql = $db->query("SELECT tblp_calificacion.E1, tblp_calificacion.E2, tblp_calificacion.P1, tblp_calificacion.P2, tblp_calificacion.P3, tblp_calificacion.Promedio FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdModulo = '$IdModulo' ");
		while($x = $db->recorrer($sql)){
			$get_cal_mat[] = $x;
		}
		return $get_cal_mat;
	}

	public function get_chk_falta($IdAsignacion,$Parcial) {
		$db = new Conexion();

		$sql5 = $db->query("SELECT tblp_parcialdocente.FecIni, tblp_parcialdocente.FecFin FROM tblp_parcialdocente WHERE  tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.NoParcial = '$Parcial'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
		$FecIni = $datos51["FecIni"];
    $FecFin = $datos51["FecFin"];

		$sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.IdUsua FROM tblp_calificacion WHERE tblp_calificacion.IdAsignacion =  '$IdAsignacion' ");
		while($x = $db->recorrer($sql)){

			$sql_fal = $db->query("SELECT Count(tblp_asistencia.IdAsistencia) AS Total FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion =  '$IdAsignacion' AND tblp_asistencia.IdUsua =  '".$x['IdUsua']."' AND tblp_asistencia.IdTipo =  '4' AND tblp_asistencia.Fecha BETWEEN  '$FecIni' AND '$FecFin'");
	    $db->rows($sql_fal);
	    $_fal = $db->recorrer($sql_fal);
			$Total = $_fal["Total"];
	    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.F$Parcial = '$Total' WHERE tblp_calificacion.IdCalificacion = '".$x['IdCalificacion']."'");
		}

	}

	public function get_chk_lista_as($IdAsignacion,$Parcial) {
		$db = new Conexion();

		$sql5 = $db->query("SELECT tblp_parcialdocente.FecIni, tblp_parcialdocente.FecFin FROM tblp_parcialdocente WHERE  tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.NoParcial = '$Parcial'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
		$FecIni = $datos51["FecIni"];
    $FecFin = $datos51["FecFin"];

		$get_chk_lista_as = [];


		$sql = $db->query("SELECT tblp_asistencia.Fecha FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion =  '$IdAsignacion' AND tblp_asistencia.Fecha BETWEEN '$FecIni' AND '$FecFin' GROUP BY tblp_asistencia.Fecha ");
		while($x = $db->recorrer($sql)){
			$get_chk_lista_as[] = $x;
		}
		return $get_chk_lista_as;

	}

	public function get_chk_lista_eje($IdAsignacion) {
		$db = new Conexion();



		$sql5 = $db->query("SELECT tblp_asignacion.FecIni, tblp_asignacion.FecFin FROM tblp_asignacion WHERE  tblp_asignacion.IdAsignacion = '$IdAsignacion'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
		$FecIni = $datos51["FecIni"];
    $FecFin = $datos51["FecFin"];

		$get_chk_lista_as = [];


		$sql = $db->query("SELECT tblp_asistencia.IdUsua, tblp_asistencia.Fecha FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion =  '$IdAsignacion' AND tblp_asistencia.Fecha BETWEEN '$FecIni' AND '$FecFin' GROUP BY tblp_asistencia.Fecha ");
		while($x = $db->recorrer($sql)){
			$get_chk_lista_as[] = $x;
		}
		return $get_chk_lista_as;

	}

	public function get_asis_id($IdUsua,$Fecha,$IdAsignacion) {
		$db = new Conexion();
		$get_asis_id = [];

		$sql = $db->query("SELECT
tblp_asistencia.IdAsistencia,
tblc_tipo_asistencia.IdTipo,
tblc_tipo_asistencia.Imprimir
FROM
tblp_asistencia
Left Join tblc_tipo_asistencia ON tblc_tipo_asistencia.IdTipo = tblp_asistencia.IdTipo
WHERE
tblp_asistencia.IdAsignacion =  '$IdAsignacion' AND
tblp_asistencia.IdUsua =  '$IdUsua' AND
tblp_asistencia.Fecha =  '$Fecha'
");
		while($x = $db->recorrer($sql)){
			$get_asis_id[] = $x;
		}
		return $get_asis_id;
	}

	public function get_asis_id_p($IdUsua,$Fecha,$IdAsignacion) {
		$db = new Conexion();
		$get_asis_id_p = [];

		$sql = $db->query("SELECT
tblp_asistencia.IdAsistencia,
tblc_tipo_asistencia.Imprimir
FROM
tblp_asistencia
Left Join tblc_tipo_asistencia ON tblc_tipo_asistencia.IdTipo = tblp_asistencia.IdTipo
WHERE
tblp_asistencia.IdAsignacion =  '$IdAsignacion' AND
tblp_asistencia.Fecha =  '$Fecha' AND
tblp_asistencia.IdUsua =  '$IdUsua'

");
		while($x = $db->recorrer($sql)){
			$get_asis_id_p[] = $x;
		}
		return $get_asis_id_p;
	}

	public function get_cic_activo_personalizado($IdUsua) {
		$db = new Conexion();
		$get_cic_activo_personalizado = [];
	
		$sql = $db->query("SELECT
		tblp_personalizado.IdHorario,
		tblp_personalizado.IdCiclo,
		tblc_ciclo.Ciclo
		FROM
		tblp_personalizado
		Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_personalizado.IdCiclo
		WHERE
		tblp_personalizado.IdUsua =  '$IdUsua'
		ORDER BY
		tblc_ciclo.FInicio DESC
		");
		while($x = $db->recorrer($sql)){
		  $get_cic_activo_personalizado[] = $x;
		}
		return $get_cic_activo_personalizado;
	  }

	public function get_ciclo_ac($IdCiclo,$IdGrupo) {
		$db = new Conexion();
		$get_sat_us = [];

		$sql = $db->query("SELECT
tblc_ciclogrupo.IdCicloGrupo,
tblc_ciclogrupo.IdCiclo,
tblc_ciclo.Ciclo,
tblc_ciclo.Fec_tramite,
tblc_ciclogrupo.Grado,
tblc_periodo.Periodo
FROM
tblc_ciclogrupo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo
Left Join tblc_periodo ON tblc_periodo.IdPeriodo = tblc_ciclo.IdPeriodo
WHERE
tblc_ciclogrupo.IdGrupo =  '$IdGrupo' AND
tblc_ciclogrupo.IdCiclo =  '$IdCiclo' ");
		while($x = $db->recorrer($sql)){
			$get_ciclo_ac[] = $x;
		}
		return $get_ciclo_ac;
	}

	public function get_infor_cel($IdUsua) {
		$db = new Conexion();
		$get_infor_cel = [];

		$sql = $db->query("SELECT tblp_informacion._Enfermedad, tblp_informacion.EParentesco, tblp_informacion.correo_tutor, tblp_informacion._Cual, tblp_informacion._Medicamento, tblp_informacion.ECelular, tblp_informacion.P_trabaja, tblp_informacion.ENombre, tblp_informacion.ETelefono, tblp_informacion.Pos_estado, tblp_informacion.Pos_ini, tblp_informacion.Pos_fin, tblp_informacion.P_curp, tblp_informacion.Sangre, tblp_informacion.Medio, tblp_informacion.LCorreo, tblp_informacion.LDireccion, tblp_informacion.LTelefono, tblp_informacion.LExtension, tblp_informacion.LNombre, tblp_informacion.PNombre, tblp_informacion.PUniversidad, tblp_informacion.E_posgrado, tblp_informacion.E_estado_procedencia, tblp_informacion.E_tipo, tblp_informacion.E_promedio, tblp_informacion.E_escuela_procedencia, tblp_informacion.E_titulo, tblp_informacion.E_estudio, tblp_informacion.Domicilio, tblp_informacion.P_civil, tblp_informacion.Fecha_impresion, tblp_informacion.Folio_egreso, tblp_informacion.LTelefono, tblp_informacion.D_direccion, tblc_estado.Estado, tblc_municipio.Nom_municipio FROM tblp_informacion Left Join tblc_estado ON tblc_estado.Cve_estado = tblp_informacion.Estado Left Join tblc_municipio ON tblc_municipio.Cve_mun = tblp_informacion.Ciudad AND tblc_municipio.Cve_entidad = tblp_informacion.Estado WHERE tblp_informacion.IdUsua = '$IdUsua'");
		while($x = $db->recorrer($sql)){
			$get_infor_cel[] = $x;
		}
		return $get_infor_cel;
	}

	public function get_lista_docs($IdUsua) {
		$db = new Conexion();
		$get_lista_docs = [];

		$sql = $db->query("SELECT tblp_documentos.IdDocumento, tblp_documentos.IdUsua, tblp_documentos.Si, tblp_documentos.No, tblp_documentos.Co, tblh_tipodocumento.Nombre FROM tblp_documentos Left Join tblh_tipodocumento ON tblh_tipodocumento.IdTipoDoc = tblp_documentos.IdTipoDocumento WHERE tblp_documentos.IdUsua =  '$IdUsua' AND tblh_tipodocumento.IdEstatus =  '8'");
		while($x = $db->recorrer($sql)){
			$get_lista_docs[] = $x;
		}
		return $get_lista_docs;
	}

	public function get_estado_p($IdEstado) {
		$db = new Conexion();
		$get_estado_p = [];
		$sql = $db->query("SELECT tblc_estado._Estado FROM tblc_estado WHERE tblc_estado.IdEstado = '$IdEstado'");
		while($x = $db->recorrer($sql)){
			$get_estado_p[] = $x;
		}
		return $get_estado_p;
	}

	public function get_infor_egre($IdGrupo) {
		$db = new Conexion();
		$get_infor_egre = [];
		$sql = $db->query("SELECT tblc_ciclogrupo.Grado, tblc_ciclo.Ciclo FROM tblc_ciclogrupo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo WHERE tblc_ciclogrupo.IdGrupo =  '$IdGrupo' ORDER BY tblc_ciclogrupo.Grado DESC LIMIT 1 ");
		while($x = $db->recorrer($sql)){
			$get_infor_egre[] = $x;
		}
		return $get_infor_egre;
	}

	public function get_beca_activa($IdUsua, $IdCiclo) {
		$db = new Conexion();
		$get_beca_activa = [];
		$sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdConcepto, tblp_pagos.Monto FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdCiclo =  '$IdCiclo' GROUP BY tblp_pagos.IdConcepto ORDER BY tblp_pagos.IdConcepto ASC LIMIT 2  ");
		while($x = $db->recorrer($sql)){
			$get_beca_activa[] = $x;
		}
		return $get_beca_activa;
	}

	public function get_desc_beca_id($IdConcepto,$IdUsua,$IdCiclo) {
		$db = new Conexion();
		$get_desc_beca_id = [];

		$sql = $db->query("SELECT
tblp_beca.IdBeca,
tblp_beca.Porcentaje,
tblc_convenio.Convenio
FROM
tblp_beca
Left Join tblc_convenio ON tblc_convenio.IdConvenio = tblp_beca.IdConvenio
WHERE
tblp_beca.IdUsua =  '$IdUsua' AND
tblp_beca.IdConcepto =  '$IdConcepto' AND
tblp_beca.IdCiclo =  '$IdCiclo' AND
tblp_beca.IdEstatus =  '8'
 ");
		while($x = $db->recorrer($sql)){
			$get_desc_beca_id[] = $x;
		}
		return $get_desc_beca_id;
	}

	public function get_mi_beca_id($IdUsua,$IdCiclo) {
		$db = new Conexion();
		$get_mi_beca_id = [];

		$sql = $db->query("SELECT tblc_conceptos._concepto, tblp_beca.IdUsua, tblp_beca.Porcentaje FROM tblp_beca Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_beca.IdConcepto WHERE tblp_beca.IdUsua =  '$IdUsua' AND tblp_beca.IdCiclo =  '$IdCiclo'");
		while($x = $db->recorrer($sql)){
			$get_mi_beca_id[] = $x;
		}
		return $get_mi_beca_id;
	}

	public function get_const_ser_soc($IdServicio) {
		$db = new Conexion();
		$get_const_ser_soc = [];

		$sql = $db->query("SELECT
tblp_servicio.IdServicio,
tblp_servicio.NomDependencia,
tblp_servicio.NomPrograma,
tblp_servicio.Periodo,
tblp_servicio.FecImpresion,
tblp_servicio.Registro,
tblp_servicio.Folio_carta,
tblp_servicio.Grado,
tblp_servicio.FecCarta,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.IdGrupo,
tblc_usuario.IdCampus,
tblc_campus.Campus,
tblp_educativa.Nombre AS Educativa,
tblp_grupo.TipoCiclo
FROM
tblp_servicio
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_servicio.IdUsua
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
WHERE tblp_servicio.IdServicio = '$IdServicio'
");
		while($x = $db->recorrer($sql)){
			$get_const_ser_soc[] = $x;
		}
		return $get_const_ser_soc;
	}

	public function get_prom_grupo_id($IdCiclo,$IdGrupo) {
		$db = new Conexion();
		$get_prom_grupo_id = [];

		$sql = $db->query("SELECT
	tblp_asignacion.IdAsignacion,
	tblp_modulo.CodeModulo,
	tblp_modulo.NombreMod,
	tblp_modulo.Grado,
	tblp_asignacion.IdCampus,
	tblp_asignacion.Promedio
	FROM
	tblp_asignacion
	Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
	WHERE
	tblp_asignacion.IdCiclo =  '$IdCiclo' AND
	tblp_asignacion.IdGrupo =  '$IdGrupo' AND
	tblp_asignacion.Tipo =  '2'
	ORDER BY
	tblp_modulo.CodeModulo ASC");
		while($x = $db->recorrer($sql)){
			$get_prom_grupo_id[] = $x;
		}
		return $get_prom_grupo_id;
	}

	public function get_asistenia_concentrado($IdAsignacion) {
		$db = new Conexion();
		$get_asistenia_concentrado = [];
		$sql = $db->query("SELECT tblp_moduloalumno.IdUsua, tblc_usuario.IdCampus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblp_moduloalumno.A, tblp_moduloalumno.F, tblp_moduloalumno.R FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' ORDER BY tblc_usuario.APaterno ASC ");
		while($x = $db->recorrer($sql)){
			$get_asistenia_concentrado[] = $x;
		}
		return $get_asistenia_concentrado;
	}


	public function get_lstAlumno($IdAsignacion) {
		$db = new Conexion();
		$get_lstAlumno = [];
		$sql = $db->query("SELECT tblp_moduloalumno.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblc_usuario.IdCampus, tblc_estatus.Estatus FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC, tblc_usuario.Nombre ASC");
		while($x = $db->recorrer($sql)){
			$get_lstAlumno[] = $x;
		}
		return $get_lstAlumno;
	}

	public function get_campus_id($IdCampus) {
		$db = new Conexion();
		$get_campus_id = [];
		$sql = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
		while($x = $db->recorrer($sql)){
			$get_campus_id[] = $x;
		}
		return $get_campus_id;
	}

	public function get_firma($IdAsignacion) {
		$db = new Conexion();
		$get_firma = [];
		$sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblc_usuario.id_paquete FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
		while($x = $db->recorrer($sql)){
			$get_firma[] = $x;
		}
		return $get_firma;
	}

	public function get_menDatos($IdGrupo){
		$db = new Conexion();

		$sql6 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
	  $db->rows($sql6);
	  $datos61 = $db->recorrer($sql6);
	  $IdCampus = $datos61["IdCampus"];
	  $IdOferta = $datos61["IdOferta"];
		$gGars8U = [];

		$sql = $db->query("SELECT
tblp_rvoe.IdRvoe,
tblp_rvoe.IdEducativa,
tblp_rvoe.IdCampus,
tblp_rvoe.Rvoe,
tblp_rvoe.Vigencia,
tblp_rvoe.Turno,
tblp_rvoe.Clave,
tblp_rvoe.Modalidad,
tblp_rvoe.Escuela,
tblp_rvoe.Localidad,
tblp_educativa.Nombre,
tblp_educativa.IdGrado,
tblc_campus.Campus
FROM
tblp_rvoe
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_rvoe.IdEducativa
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_rvoe.IdCampus

WHERE
tblp_rvoe.IdCampus =  '$IdCampus' AND tblp_rvoe.IdEducativa = '$IdOferta'
");
		while($x = $db->recorrer($sql)){
			$gGars8U[] = $x;
		}
		return $gGars8U;
	}

	public function get_dat_grupo($IdGrupo) {
		$db = new Conexion();
		$get_dat_grupo = [];
		$sql = $db->query("SELECT
tblp_grupo.IdGrupo,
tblp_grupo.Modalidad,
tblc_modalidad._Modalidad,
tblp_grupo.Grupo,
tblp_educativa.Nombre,
tblp_educativa.IdGrado,
tblp_grupo.IdCampus
FROM
tblp_grupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
WHERE tblp_grupo.IdGrupo = '$IdGrupo'
");
		while($x = $db->recorrer($sql)){
			$get_dat_grupo[] = $x;
		}
		return $get_dat_grupo;
	}

	public function get_mat_extra($IdCiclo,$IdGrupo) {
		$db = new Conexion();


		$get_mat_extra = [];
		$sql = $db->query("SELECT
tblp_calificacion.IdModulo,
tblp_modulo.NombreMod,
tblp_asignacion.Fec_extra
FROM
tblp_calificacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_calificacion.IdAsignacion
WHERE
tblp_calificacion.IdCiclo =  '$IdCiclo' AND
tblp_calificacion.IdGrupo =  '$IdGrupo' AND
tblp_calificacion.E1 IS NOT NULL
GROUP BY
tblp_calificacion.E1
ORDER BY
tblp_modulo.CodeModulo ASC
");
		while($x = $db->recorrer($sql)){
			$get_mat_extra[] = $x;
		}
		return $get_mat_extra;
	}

	public function get_alumn_extra($IdCiclo,$IdGrupo) {
		$db = new Conexion();
		$get_alumn_extra = [];
		$sql = $db->query("SELECT
			tblp_asignacion.IdAsignacion,
tblp_moduloalumno.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario
FROM
tblp_asignacion
Left Join tblp_moduloalumno ON tblp_moduloalumno.IdAsignacion = tblp_asignacion.IdAsignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE
tblp_asignacion.IdGrupo =  '$IdGrupo' AND
tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.Tipo =  '2' AND
tblp_moduloalumno.Extra1 =  '1'
GROUP BY
tblp_moduloalumno.IdUsua
ORDER BY
tblc_usuario.APaterno ASC

");
		while($x = $db->recorrer($sql)){
			$get_alumn_extra[] = $x;
		}
		return $get_alumn_extra;
	}

	public function get_cal_extra1($IdCiclo,$IdGrupo,$IdUsua,$IdModulo) {
		$db = new Conexion();
		$get_cal_extra1 = [];
		$sql = $db->query("SELECT tblp_calificacion.E1 FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdModulo = '$IdModulo' AND tblp_calificacion.IdGrupo = '$IdGrupo' AND tblp_calificacion.IdCiclo = '$IdCiclo'");
		while($x = $db->recorrer($sql)){
			$get_cal_extra1[] = $x;
		}
		return $get_cal_extra1;
	}

	public function get_dat_cic($IdGrupo) {
		$db = new Conexion();
		$get_dat_cic = [];
		$sql = $db->query("SELECT
tblc_ciclo.IdCiclo,
tblc_ciclo.Ciclo,
tblc_periodo.Periodo
FROM
tblc_ciclo
Left Join tblc_periodo ON tblc_periodo.IdPeriodo = tblc_ciclo.IdPeriodo
WHERE tblc_ciclo.IdCiclo = '$IdGrupo'
");
		while($x = $db->recorrer($sql)){
			$get_dat_cic[] = $x;
		}
		return $get_dat_cic;
	}

	public function get_lst_us($IdCiclo,$IdGrupo) {
		$db = new Conexion();
		$get_lst_us = [];
		$sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.fecha_baja,
tblc_estatus.Estatus
FROM
tblc_usuario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE
tblc_usuario.id_ciclo_fin =  '$IdCiclo' AND
tblc_usuario.IdGrupo =  '$IdGrupo'

");
		while($x = $db->recorrer($sql)){
			$get_lst_us[] = $x;
		}
		return $get_lst_us;
	}



	public function get_horario($IdGrupo) {
		$db = new Conexion();
		$get_horario = [];

		$sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_horario.IdHorario,
tblp_horario.IdDia,
tblp_horario.HraIni,
tblp_horario.MinIni,
tblp_horario.HraFin,
tblp_horario.MinFin,
tblp_horario.Total,
tblp_horario.Modulo,
tblc_dia.Dia,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_horario ON tblp_horario.IdAsignacion = tblp_asignacion.IdAsignacion
Left Join tblc_dia ON tblc_dia.IdDia = tblp_horario.IdDia
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
WHERE
tblp_asignacion.IdGrupo =  '$IdGrupo' AND
tblp_asignacion.Estatus =  'Activo' AND
tblp_asignacion.Tipo =  '2' AND
tblp_horario.Total  IS NOT NULL
GROUP BY
tblp_asignacion.IdAsignacion
ORDER BY
tblp_modulo.CodeModulo ASC
");
		while($x = $db->recorrer($sql)){
			$get_horario[] = $x;
		}
		return $get_horario;
	}

	public function get_encz1($IdGrupo) {
		$db = new Conexion();
		$get_encz1 = [];
		$sql = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.Modalidad, tblc_grado.Descripcion, tblp_grupo.Turno FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
		while($x = $db->recorrer($sql)){
			$get_encz1[] = $x;
		}
		return $get_encz1;
	}

	public function get_encz2($IdGrupo) {
		$db = new Conexion();
		$get_encz2 = [];
		$sql = $db->query("SELECT tblc_ciclo.Ciclo, tblp_modulo.Grado, tblp_asignacion.IdAsignacion FROM tblp_asignacion Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.IdEstatus =  '8' AND tblp_asignacion.Tipo =  '2' LIMIT 1");
		while($x = $db->recorrer($sql)){
			$get_encz2[] = $x;
		}
		return $get_encz2;
	}

	public function get_lstGrupoId($IdGrupo) {
		$db = new Conexion();
		$get_lstGrupoId = [];
		$sql = $db->query("SELECT tblc_usuario.Usuario, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.IdGrupo =  '$IdGrupo' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC, tblc_usuario.Nombre ASC ");
		while($x = $db->recorrer($sql)){
			$get_lstGrupoId[] = $x;
		}
		return $get_lstGrupoId;
	}

	public function get_encabezado1($IdAsignacion) {
		$db = new Conexion();
		$get_encabezado1 = [];

		$sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.Nombre AS Educativa, tblp_modulo.NombreMod, tblp_modulo.Objetivo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_grupo.CveGrupo, tblc_campus.Direccion, tblc_campus.Img_reporte, tblc_campus.Campus, tblc_modalidad._Modalidad, tblc_dias_clases._Dias FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
		while($x = $db->recorrer($sql)){
			$get_encabezado1[] = $x;
		}
		return $get_encabezado1;
	}

	public function get_datos_impresion($IdAsignacion) {
		$db = new Conexion();
		$get_datos_impresion = [];

		$sql2 = $db->query("SELECT tblp_calificacion.IdOferta, tblp_calificacion.IdModulo, tblp_calificacion.IdCiclo, tblp_calificacion.IdGrupo, tblp_calificacion.IdTipo FROM tblp_calificacion WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
		$IdTipo = $datos21["IdTipo"];

		if($IdTipo == 1){
			$sql = $db->query("SELECT
tblp_calificacion.IdCalificacion,
tblp_educativa.Nombre As Educativa,
tblp_modulo.NombreMod,
tblc_ciclo.Ciclo,
tblp_grupo.CveGrupo,
tblc_dias_clases._Dias,
tblc_modalidad._Modalidad,
tblc_campus.Campus,
tblc_campus.Img_reporte,
tblc_campus.Direccion
FROM
tblp_calificacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_calificacion.IdOferta
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo AND tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_calificacion.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
WHERE
tblp_calificacion.IdAsignacion =  '$IdAsignacion'
GROUP BY
tblp_calificacion.IdAsignacion
");

		} else {

			$sql = $db->query("SELECT tblp_asignacion.Fec_extra, tblp_asignacion.Fec_emi_bim1, tblp_asignacion.Fec_emi_bim2, tblp_asignacion.Fecha_impresion, tblp_asignacion.IdAsignacion, tblp_educativa.Nombre AS Educativa, tblp_modulo.NombreMod, tblp_modulo.Objetivo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_grupo.CveGrupo, tblc_campus.Direccion, tblc_campus.Img_reporte, tblc_campus.Campus, tblc_modalidad._Modalidad, tblc_dias_clases._Dias, tblc_ciclo.Ciclo, tblp_grupo.TipoCiclo, tblp_grupo.Grupo, tblp_modulo.Grado, tblc_grado._Grado FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
		}



		while($x = $db->recorrer($sql)){
			$get_datos_impresion[] = $x;
		}
		return $get_datos_impresion;
	}




	public function get_lstParcial($IdAsignacion) {
		$db = new Conexion();
		$get_lstParcial = [];

		$sql = $db->query("SELECT tblp_parcialdocente.IdParcialDocente, tblp_parcialdocente.NoParcial, tblp_parcialdocente.Tema, tblp_parcialdocente.Objetivo FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion =  '$IdAsignacion'");
		while($x = $db->recorrer($sql)){
			$get_lstParcial[] = $x;
		}
		return $get_lstParcial;
	}

	public function get_bajas_grp($IdCampus,$IdCiclo) {
		$db = new Conexion();
		$get_bajas_grp = [];

		$sql = $db->query("SELECT
	tblc_usuario.IdUsua,
	tblc_usuario.Nombre,
	tblc_usuario.APaterno,
	tblc_usuario.AMaterno,
	tblc_usuario.Telefono,
	tblc_usuario.Correo,
	tblc_usuario.Usuario,
	tblc_usuario.fecha_baja,
	tblp_grupo.CveGrupo,
	tblc_usuario.IdGrupo,
	tblp_educativa.Nombre AS NomEducativa,
	tblc_estatus.Estatus
	FROM
	tblc_usuario
	Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
	Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
	Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
	WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.IdCampus = '$IdCampus' AND tblc_usuario.id_ciclo_fin = '$IdCiclo' ");
		while($x = $db->recorrer($sql)){
			$get_bajas_grp[] = $x;
		}
		return $get_bajas_grp;
	}

	public function get_bajas_plan($IdCampus,$IdCiclo) {
		$db = new Conexion();
		$get_bajas_plan = [];

		$sql = $db->query("SELECT
		Count(tblc_usuario.IdUsua) AS Total,
		tblp_educativa.Nombre AS NomEducativa
		FROM
		tblc_usuario
		Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
		WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.IdCampus = '$IdCampus' AND tblc_usuario.id_ciclo_fin = '$IdCiclo'
		GROUP BY
		tblc_usuario.IdOferta
		ORDER BY
		tblp_educativa.IdGrado ASC ");
		while($x = $db->recorrer($sql)){
			$get_bajas_plan[] = $x;
		}
		return $get_bajas_plan;
	}

	public function get_datos_cic($IdCiclo) {
		$db = new Conexion();
		$get_datos_cic = [];

		$sql = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo' ");
		while($x = $db->recorrer($sql)){
			$get_datos_cic[] = $x;
		}
		return $get_datos_cic;
	}

	public function get_encabezado2($IdGrupo) {
		$db = new Conexion();
		$get_encabezado2 = [];

		$sql = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_grupo.Modalidad, tblc_campus.Campus, tblc_campus.Logo, tblc_campus.Ubicacion, tblp_educativa.Nombre FROM tblp_grupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
		while($x = $db->recorrer($sql)){
			$get_encabezado2[] = $x;
		}
		return $get_encabezado2;
	}

	public function get_semanas($IdParcial) {
		$db = new Conexion();
		$get_semanas = [];

		$sql = $db->query("SELECT tblp_semanadocente.IdSemanaDocente, tblp_semanadocente.NoSemana, tblp_semanadocente.Temas FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente =  '$IdParcial' ORDER BY tblp_semanadocente.NoSemana ASC ");
		while($x = $db->recorrer($sql)){
			$get_semanas[] = $x;
		}
		return $get_semanas;
	}

	public function get_actividades($IdParcial,$IdSemana) {
		$db = new Conexion();
		$get_actividades = [];

		$sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.DesActividad,
tblp_actividadesdocente.Porcentaje,
tblp_actividadesdocente.FecIni,
tblp_actividadesdocente.FecFin,
tblc_tipoactividad.TipoActividad
FROM
tblp_actividadesdocente
Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad
WHERE
tblp_actividadesdocente.IdParcialDocente =  '$IdParcial' AND
tblp_actividadesdocente.IdSemanaDocente =  '$IdSemana'
 ");
		while($x = $db->recorrer($sql)){
			$get_actividades[] = $x;
		}
		return $get_actividades;
	}



}
?>

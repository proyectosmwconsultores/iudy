<?php
require('system.php');
class Formatos
{
	public function obtener_lista_materias($IdUsua) {
    $db = new Conexion();

        $sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.IdUsua, tblp_calificacion.Usuario, tblp_calificacion.Promedio, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblc_ciclo.Ciclo, tblc_ciclo.FInicio, tblc_ciclo.FFinal, tblp_calificacion.IdCiclo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo WHERE tblp_calificacion.IdEstatus = '10' AND tblp_calificacion.IdUsua =  '$IdUsua' ORDER BY tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC");
        while($x = $db->recorrer($sql)){
          $obtener_lista_materias[] = $x;
        }
        return $obtener_lista_materias;
      }
      
    public function obtener_datos_titulo($code) {
    $db = new Conexion();
        $obtener_datos_titulo = [];
        $sql = $db->query("SELECT
tblp_certificado.IdCertificado,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Grado,
tblc_usuario.Curp,
tblp_tipo_titulacion.Tipo1,
tblp_tipo_titulacion.Tipo2,
tblp_certificado.IdUsua,
tblp_certificado.CCT,
tblp_certificado.Estudios,
tblp_certificado.Entidad,
tblp_certificado.Institucion,
tblp_certificado.Cer_inicio,
tblp_certificado.Cer_final,
tblp_certificado.t_inicio,
tblp_certificado.t_final,
tblp_certificado.t_fecha_examen,
tblp_certificado.t_impresion,
tblp_certificado.t_no,
tblp_certificado.t_foja,
tblp_certificado.t_gestion,
tblp_certificado.t_control,
tblp_certificado.acta_hora,
tblp_certificado.acta_fecha,
tblp_certificado.acta_aprobo,
tblc_rvoe.Educativa,
tblc_rvoe._imprimir,
tblc_rvoe.Rvoe,
tblc_rvoe.Vigencia,
tblc_rvoe.Turno,
tblc_rvoe.oferta,
tblc_rvoe.Modalidad,
tblc_rvoe.Escuela,
tblc_rvoe.Clave,
tblc_rvoe.Clave_dgp,
tblc_rvoe.Clave_rpe,
tblp_informacion.P_curp
FROM
tblp_certificado
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_certificado.IdUsua
Left Join tblp_tipo_titulacion ON tblp_tipo_titulacion.idTipo = tblp_certificado.t_idTipo
Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe
Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua
WHERE
tblp_certificado.Code =  '$code'
");
        while($x = $db->recorrer($sql)){
          $obtener_datos_titulo[] = $x;
        }
        return $obtener_datos_titulo;
    }
      
      
    function get_baja_alumno_id($IdBaja) {
    $db = new Conexion();
	
        $sql = $db->query("SELECT
tblh_bajausuario.IdBaja,
tblh_bajausuario.IdUsua,
tblh_bajausuario.IdEstatus,
tblh_bajausuario.Comentario,
tblh_bajausuario.FecCap,
tblh_bajausuario.IdCiclo,
tblh_bajausuario.IdMotivo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_rvoe.Educativa,
tblc_rvoe.Rvoe,
tblc_usuario._horario,
tblc_campus.Campus,
tblc_dias_clases._Dias,
tblc_estatus.Estatus
FROM
tblh_bajausuario
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_bajausuario.IdUsua
Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe
Inner Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblh_bajausuario.IdEstatus
WHERE
tblh_bajausuario.IdBaja =  '$IdBaja'
");
        while($x = $db->recorrer($sql)){
          $obtener_lista_materias[] = $x;
        }
        return $obtener_lista_materias;
      }

  public function get_datos_reincorporacion($IdUsua) {
    $db = new Conexion();
    $get_datos_reincorporacion = [];
    $sql = $db->query("SELECT
    tblp_reincorporacion.IdReincorporacion,
    tblp_reincorporacion.Nota,
    tblp_reincorporacion.IdGestion,
    tblc_ciclo.Ciclo,
    tblp_grupo.Dia
    FROM
    tblp_reincorporacion
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_reincorporacion.IdCiclo
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_reincorporacion.IdGrupo
    WHERE tblp_reincorporacion.IdUsua = '$IdUsua' ORDER BY tblp_reincorporacion.FecCap DESC ");
    while($x = $db->recorrer($sql)){
      $get_datos_reincorporacion[] = $x;
    }
    return $get_datos_reincorporacion;
  }

  public function obtener_datos_rvoe($IdUsua) {
    $db = new Conexion();
    $obtener_datos_rvoe = [];
    
    $sql = $db->query("SELECT
    tblc_usuario.IdUsua,
    tblc_usuario.IdGrupo,
    tblc_rvoe.IdEducativa,
    tblc_rvoe.Educativa,
    tblc_rvoe.Rvoe,
    tblc_rvoe.Vigencia,
    tblc_rvoe.Turno,
    tblc_rvoe.Modalidad,
    tblc_rvoe.Escuela,
    tblc_rvoe.Clave_dgp,
    tblc_rvoe.Clave_rpe,
    tblc_rvoe.Clave,
    tblc_rvoe.Localidad,
    tblc_rvoe.Creditos,
    tblc_rvoe.Materias,
    tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario._fecReincorporacion,
tblc_usuario._tipoReincorporacion,
tblc_usuario.Curp
    FROM
    tblc_usuario
    Left Join tblc_rvoe ON tblc_rvoe.IdEducativa = tblc_usuario._idOferta AND tblc_rvoe.IdCampus = tblc_usuario._idCampus
    WHERE
    tblc_usuario.IdUsua =  '$IdUsua'
    ");
    while($x = $db->recorrer($sql)){
      $obtener_datos_rvoe[] = $x;
    }
    return $obtener_datos_rvoe;
  }

  public function obtener_datos_certificado($IdUsua) {
    $db = new Conexion();
    $obtener_datos_certificado = [];
    
    $sql = $db->query("SELECT * FROM tblp_certificado WHERE tblp_certificado.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $obtener_datos_certificado[] = $x;
    }
    return $obtener_datos_certificado;
  }
  
  public function usuario_id($IdUsua) {
    $db = new Conexion();
    $usuario_id = [];
    
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $usuario_id[] = $x;
    }
    return $usuario_id;
  }
  
  public function obtener_donacion_id($code) {
    $db = new Conexion();
    $obtener_donacion_id = [];
    
    $sql3 = $db->query("SELECT tblp_donacion.Ruta WHERE tblp_donacion.Code = '$code'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    if(!isset($datos31["Ruta"])){
         $anio = date('Y');
        $mes = date('m');
        require '../../assets/qrcode/qrlib.php';
        $dir = '../../assets/images/qr/' . $anio . '/' . $mes . '/';
    
        if (!file_exists($dir))
        mkdir($dir);
        $ruta = $anio . '/' . $mes;
        
        $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitud = 20;
        $cad =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
    
        $insertar = $db->query("UPDATE tblp_donacion SET tblp_donacion.Ruta = '$ruta' WHERE tblp_donacion.Code = '$code'");
        $filename = $dir.$code.'.png';
    
        $tamanio = 10;
        $level = 'M';
        $frameSize = 3;
    
        $contenido = 'https://sciudy.com/repositorio/formatos/donacion.php?idToks=' . $code;
    
        QRCode::png($contenido, $filename, $level, $tamanio, $frameSize);
    }
    
    $sql = $db->query("SELECT
	tblp_donacion.IdDonacion, 
	tblp_donacion.IdFolio, 
	tblp_donacion.Folio, 
	tblp_donacion.Ruta, 
	tblp_donacion.Numero, 
	tblp_donacion.Monto, 
	tblp_donacion.Code, 
	tblp_donacion.FecCap, 
	tblc_usuario.Nombre, 
	tblc_usuario.APaterno, 
	tblc_usuario.AMaterno, 
	tblc_usuario.Usuario, 
	tblp_educativa.Nombre AS Educativa,
	tblp_foliospago.IdAdmin
FROM
	tblp_donacion
	LEFT JOIN
	tblp_foliospago
	ON 
		tblp_donacion.IdFolio = tblp_foliospago.IdFolio
	LEFT JOIN
	tblc_usuario
	ON 
		tblp_foliospago.IdUsua = tblc_usuario.IdUsua
	LEFT JOIN
	tblp_educativa
	ON 
		tblc_usuario.IdOferta = tblp_educativa.IdEducativa
WHERE
	tblp_donacion.Code = '$code'");
    while($x = $db->recorrer($sql)){
      $obtener_donacion_id[] = $x;
    }
    return $obtener_donacion_id;
  }

  public function obtener_promedio_user($IdUsua,$IdOferta) {
    $db = new Conexion();
    $obtener_promedio_user = [];
    $sql = $db->query("SELECT
    Avg(tblp_calificacion.Promedio) AS Promedio
    FROM
    tblp_calificacion
    WHERE
    tblp_calificacion.IdUsua =  '$IdUsua' AND
    tblp_calificacion.IdEstatus =  '10' AND
    tblp_calificacion.IdOferta =  '$IdOferta'
    GROUP BY
    tblp_calificacion.IdUsua");
    while($x = $db->recorrer($sql)){
      $obtener_promedio_user[] = $x;
    }
    return $obtener_promedio_user;
  }

  

  public function obtener_datos_practica($IdPractica) {
    $db = new Conexion();
	
    $sql = $db->query("SELECT
    tblp_practicas.IdPractica,
    tblp_practicas.Empresa,
    tblp_practicas.IdUsua,
    tblp_practicas.Grado_responsable,
    tblp_practicas.Nombre_responsable,
    tblp_practicas.Cargo,
    tblp_practicas.Domicilio,
    tblp_practicas.CP,
    tblp_practicas.Telefono,
    tblp_practicas.Fecha_inicio,
    tblp_practicas.Persona_enlace,
    tblp_practicas.Telefono_enlace,
    tblp_practicas.Area_asignado,
    tblp_practicas.Folio,
    tblp_practicas.Fecha_impresion,
    tblp_practicas.Anio,
    tblp_practicas.Grado,
    tblp_practicas.IdGestion,
    tblp_practicas._cer_fecha_liberacion,
    tblp_practicas._cer_registro,
    tbla_aviso_practicas.Pra_ini,
    tbla_aviso_practicas.Pra_fin,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_usuario.Usuario,
    tblc_usuario.Celular,
    tblp_educativa.Nombre AS Educativa
    FROM
    tblp_practicas
    Left Join tbla_aviso_practicas ON tbla_aviso_practicas.IdAviso = tblp_practicas.IdAviso
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_practicas.IdUsua
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
    WHERE tblp_practicas.IdPractica = '$IdPractica'");
    while($x = $db->recorrer($sql)){
      $obtener_datos_practica[] = $x;
    }
    return $obtener_datos_practica;
  }
  
  public function obtener_datos_servicio($IdServicio) {
    $db = new Conexion();
	
    $sql = $db->query("SELECT
    tblp_servicio.IdServicio,
    tblp_servicio.Empresa,
    tblp_servicio.IdUsua,
    tblp_servicio.Grado_responsable,
    tblp_servicio.Nombre_responsable,
    tblp_servicio.Cargo,
    tblp_servicio.Domicilio,
    tblp_servicio.CP,
    tblp_servicio.Telefono,
    tblp_servicio.Fecha_inicio,
    tblp_servicio.Persona_enlace,
    tblp_servicio.Telefono_enlace,
    tblp_servicio.Area_asignado,
    tblp_servicio.Folio,
    tblp_servicio.Fecha_impresion,
    tblp_servicio.Anio,
    tblp_servicio.Grado,
    tblp_servicio.IdGestion,
    tblp_servicio._cer_fecha_liberacion,
    tblp_servicio._cer_registro,
    tbla_aviso_servicio.Pra_ini,
    tbla_aviso_servicio.Pra_fin,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_usuario.Usuario,
    tblc_usuario.Celular,
    tblp_educativa.Nombre AS Educativa
    FROM
    tblp_servicio
    Left Join tbla_aviso_servicio ON tbla_aviso_servicio.IdAviso = tblp_servicio.IdAviso
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_servicio.IdUsua
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
    WHERE tblp_servicio.IdServicio = '$IdServicio'");
    while($x = $db->recorrer($sql)){
      $obtener_datos_servicio[] = $x;
    }
    return $obtener_datos_servicio;
  }

  public function obtener_datos_domicilio($IdUsua) {
    $db = new Conexion();
	
    $sql = $db->query("SELECT
    tblp_informacion.D_estado,
    tblp_informacion.D_municipio,
    tblp_informacion.D_cp,
    tblp_informacion.D_direccion,
    tblc_estado.Estado,
    tblc_municipio.Nom_municipio
    FROM
    tblp_informacion
    Left Join tblc_estado ON tblc_estado.Cve_estado = tblp_informacion.D_estado
    Left Join tblc_municipio ON tblc_municipio.Cve_entidad = tblp_informacion.D_estado AND tblc_municipio.Cve_mun = tblp_informacion.D_municipio
    WHERE
    tblp_informacion.IdUsua =  '$IdUsua'
    ");
    while($x = $db->recorrer($sql)){
      $obtener_datos_domicilio[] = $x;
    }
    return $obtener_datos_domicilio;
  }

  public function get_datos_campus_rvoe($IdUsua) {
		$db = new Conexion();
		$get_datos_campus_rvoe = [];
		
		$sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdOferta, tblp_grupo.id_rvoe, tblp_grupo.id_campus, tblc_campus._logoPdf, tblc_campus._titulo, tblc_usuario.IdGrupo, tblc_rvoe.Modalidad, tblc_rvoe.Educativa FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.id_campus Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblp_grupo.id_rvoe WHERE tblc_usuario.IdUsua =  '$IdUsua'");
		while($x = $db->recorrer($sql)){
			$get_datos_campus_rvoe[] = $x;
		}
		return $get_datos_campus_rvoe;
	}
	
	public function get_promedio_alumno_id($IdUsua) {
		$db = new Conexion();
		$get_promedio_alumno_id = [];
		
		$sql = $db->query("SELECT
Avg(tblp_calificacion.Promedio) AS Promedio
FROM
tblp_calificacion
WHERE
tblp_calificacion.IdUsua =  '$IdUsua' AND
tblp_calificacion.IdEstatus =  '10'
");
		while($x = $db->recorrer($sql)){
			$get_promedio_alumno_id[] = $x;
		}
		return $get_promedio_alumno_id;
	}
	
	
  public function get_total_creditos($IdOferta,$IdCampus) {
		$db = new Conexion();
		$get_total_creditos = [];
		
	
		$sql = $db->query("SELECT
Sum(tblp_modulo.Creditos) AS Total
FROM
tblp_modulo
WHERE
tblp_modulo.IdEducativa =  '$IdOferta' AND
tblp_modulo.IdCampus =  '$IdCampus'
");
		while($x = $db->recorrer($sql)){
			$get_total_creditos[] = $x;
		}
		return $get_total_creditos;
	}
	

	

	

  public function get_firma_gestion($IdUsua) {
		$db = new Conexion();
		$get_firma_gestion = [];
    
		$sql = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.id_paquete FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
		while($x = $db->recorrer($sql)){
			$get_firma_gestion[] = $x;
		}
		return $get_firma_gestion;
	}
	
	public function get_materias_activas($IdUsua,$IdCiclo) {
		$db = new Conexion();
		$get_materias_activas = [];
    
		$sql = $db->query("SELECT
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_moduloalumno.IdModuloAlumno
FROM
tblp_moduloalumno
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE
tblp_moduloalumno.IdUsua =  '$IdUsua' AND
tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.Fecha_impresion IS NULL 
ORDER BY
tblp_modulo.CodeModulo ASC
");
		while($x = $db->recorrer($sql)){
			$get_materias_activas[] = $x;
		}
		return $get_materias_activas;
	}
	
	
	  public function get_promedio_id($IdUsua) {
		$db = new Conexion();
		$get_promedio_id = [];
    
		$sql = $db->query("SELECT
tblp_calificacion.IdCalificacion,
Avg(tblp_calificacion.Promedio) AS Promedio
FROM
tblp_calificacion
WHERE
tblp_calificacion.IdUsua =  '$IdUsua' AND
tblp_calificacion.IdEstatus =  '10'
GROUP BY
tblp_calificacion.IdUsua
");
		while($x = $db->recorrer($sql)){
			$get_promedio_id[] = $x;
		}
		return $get_promedio_id;
	}
	
    public function get_datos_constancia($code) {
		$db = new Conexion();
		
		$sql_docs = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdEstatus = 4 AND tblp_pagos.Capturado = 5 ");
        while ($docs = $db->recorrer($sql_docs)) {
          $insertar = $db->query("UPDATE tblp_docs_solicitados SET tblp_docs_solicitados.IdEstatus = '4', tblp_docs_solicitados.FecAprobado = NOW() WHERE tblp_docs_solicitados.IdPago = '" . $docs['IdPago'] . "' ");
          $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Capturado = '4' WHERE tblp_pagos.IdPago = '" . $docs['IdPago'] . "' ");
        }
		
		$get_datos_constancia = [];
		
    
		$sql = $db->query("SELECT
tblp_docs_solicitados.IdDocumento,
tblp_docs_solicitados.Fecha,
tblp_docs_solicitados.IdUsua,
tblp_docs_solicitados.qrCode,
tblp_docs_solicitados.Grado,
tblp_docs_solicitados.IdCiclo,
tblp_docs_solicitados.IdVisto,
tblp_docs_solicitados.Tipo,
tblp_docs_solicitados.IdOferta,
tblp_docs_solicitados.IdCampus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_rvoe.Educativa,
tblc_rvoe.Rvoe,
tblp_docs_solicitados.Anio,
tblp_docs_solicitados.Mes,
tblp_docs_solicitados.FecAprobado,
tblc_ciclo.FInicio,
tblc_ciclo.FFinal,
tblc_ciclo.Vacacional
FROM
tblp_docs_solicitados
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_docs_solicitados.IdUsua
Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs_solicitados.IdCiclo
WHERE
tblp_docs_solicitados.qrCode =  '$code'
");
		while($x = $db->recorrer($sql)){
			$get_datos_constancia[] = $x;
		}
		return $get_datos_constancia;
	}
	
	
	
	

  public function get_alumno_id($IdUsua) {
		$db = new Conexion();
		$get_alumno_id = [];
		$sql = $db->query("SELECT
    tblc_usuario.IdUsua,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_usuario.Termino,
    tblc_usuario.IdOferta,
    tblc_usuario.Usuario
    FROM
    tblc_usuario
    WHERE
    tblc_usuario.IdUsua =  '$IdUsua'
    ");
		while($x = $db->recorrer($sql)){
			$get_alumno_id[] = $x;
		}
		return $get_alumno_id;
	}

  public function get_kardex_alumno_id($IdUsua) {
		$db = new Conexion();
		$get_kardex_alumno_id = [];
		$sql = $db->query("SELECT
    tblp_calificacion.IdCalificacion,
    tblp_calificacion.IdCiclo,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblp_modulo.Creditos,
    tblp_calificacion.Promedio,
    tblp_calificacion.Observacion,
    tblp_calificacion._obs,
    tblc_ciclo.Ciclo,
    tblp_modulo.Grado,
    tblp_grupo.TipoCiclo
    FROM
    tblp_calificacion
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_calificacion.IdGrupo
    WHERE
    tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus = '10'
    ORDER BY
    tblc_ciclo.FInicio ASC,
    tblp_modulo.Grado ASC,
    tblp_modulo.CodeModulo ASC
    
    
    ");
		while($x = $db->recorrer($sql)){
			$get_kardex_alumno_id[] = $x;
		}
		return $get_kardex_alumno_id;
	}
	
		public function obtener_ciclo_impresion($IdCiclo, $Grado) {
		$db = new Conexion();
		
		$sql9 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo' ");
		$db->rows($sql9);
		$datos91 = $db->recorrer($sql9);
		$Tipo = $datos91['Tipo'];
		$Numero = $datos91['Numero'];
		if($Grado == 1){
			$Numero = $datos91['Numero'];
		} else {
		    $Grado = ($Grado - 1);
			$Numero = ($Numero + $Grado);
		}

		$obtener_ciclo_impresion = [];
		$sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$Tipo' AND tblc_ciclo.Numero = '$Numero' ");
		while($x = $db->recorrer($sql)){
		  $obtener_ciclo_impresion[] = $x;
		}
		return $obtener_ciclo_impresion;
	  }
	  
	
	public function get_kardex_alumno_id_especial($IdUsua) {
		$db = new Conexion();
		$get_kardex_alumno_id_especial = [];
		$sql = $db->query("SELECT
    tblp_calificacion.IdCalificacion,
    tblp_calificacion.IdCiclo,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblp_modulo.Creditos,
    tblp_calificacion.Promedio,
    tblp_calificacion.Observacion,
    tblp_calificacion._obs,
    tblc_ciclo.Ciclo,
    tblp_modulo.Grado,
    tblp_grupo.TipoCiclo
    FROM
    tblp_calificacion
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_calificacion.IdGrupo
    WHERE
    tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus = '10'
    ORDER BY
    tblp_modulo.Grado ASC,
    tblp_modulo.CodeModulo ASC
    
    
    ");
		while($x = $db->recorrer($sql)){
			$get_kardex_alumno_id_especial[] = $x;
		}
		return $get_kardex_alumno_id_especial;
	}
	
	public function get_kardex_alumno_personz_id($IdUsua) {
		$db = new Conexion();
		$get_kardex_alumno_id = [];
		$sql = $db->query("SELECT
    tblp_calificacion.IdCalificacion,
    tblp_calificacion.IdCiclo AS Ciclo,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblp_modulo.Creditos,
    tblp_calificacion.Promedio,
    tblp_calificacion.Observacion,
    tblc_ciclo.Ciclo,
    tblp_modulo.Grado AS IdCiclo,
    tblp_grupo.TipoCiclo
    FROM
    tblp_calificacion
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_calificacion.IdGrupo
    WHERE
    tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus = '10'
    ORDER BY
    tblp_modulo.Grado ASC,
    tblp_modulo.CodeModulo ASC
    
    
    ");
		while($x = $db->recorrer($sql)){
			$get_kardex_alumno_id[] = $x;
		}
		return $get_kardex_alumno_id;
	}

  public function get_boleta_id($IdUsua,$IdCiclo) {
		$db = new Conexion();
		$get_alumno_id = [];
   
		$sql = $db->query("SELECT
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_usuario.Usuario,
    tblp_calificacion.IdOferta,
    tblp_calificacion.IdModulo,
    tblp_calificacion.Promedio,
    tblp_calificacion.Observacion,
    tblc_ciclo.Ciclo,
    tblp_educativa.Nombre AS Educativa,
    tblp_modulo.CodeModulo,
    tblp_modulo.Grado,
    tblp_modulo.NombreMod,
    tblc_ciclo.IdCiclo,
    tblp_grupo.CveGrupo,
    tblp_grupo.TipoCiclo
    FROM
    tblc_usuario
    Left Join tblp_calificacion ON tblp_calificacion.IdUsua = tblc_usuario.IdUsua
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_calificacion.IdOferta
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
    WHERE
    tblc_usuario.IdUsua =  '$IdUsua' AND
    tblp_calificacion.IdCiclo =  '$IdCiclo'
    ORDER BY
    tblp_modulo.CodeModulo ASC
    
    ");
		while($x = $db->recorrer($sql)){
			$get_alumno_id[] = $x;
		}
		return $get_alumno_id;
	}

}

<?php
require('../../php/clases/class.System.php');
class Imprimir
{

	public function obtener_lista_materias_part1($IdUsua) {
		$db = new Conexion();
		
		$sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.IdOferta, tblp_calificacion.IdUsua, tblp_calificacion._obs, tblp_calificacion.Usuario, tblp_calificacion.Promedio, tblp_modulo.Grado, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblc_ciclo.Ciclo, tblc_ciclo.FInicio, tblc_ciclo.FFinal, tblp_calificacion.IdCiclo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo WHERE tblp_calificacion.IdEstatus = '10' AND tblp_calificacion.IdUsua =  '$IdUsua' ORDER BY tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC LIMIT 0, 35 ");
		while($x = $db->recorrer($sql)){
		  $obtener_lista_materias[] = $x;
		}
		return $obtener_lista_materias;
	  }
	  public function obtener_lista_materias_part2($IdUsua) {
		$db = new Conexion();
		$obtener_lista_materias_part2 = [];
		$sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.IdUsua, tblp_calificacion._obs, tblp_calificacion.Usuario, tblp_calificacion.Promedio, tblp_modulo.Grado, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblc_ciclo.Ciclo, tblc_ciclo.FInicio, tblc_ciclo.FFinal, tblp_calificacion.IdCiclo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo WHERE tblp_calificacion.IdEstatus = '10' AND tblp_calificacion.IdUsua =  '$IdUsua' ORDER BY tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC LIMIT 35, 90 ");
		while($x = $db->recorrer($sql)){
		  $obtener_lista_materias_part2[] = $x;
		}
		return $obtener_lista_materias_part2;
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

	  public function get_mis_creditos($IdUsua) {
		$db = new Conexion();
		$get_mis_creditos = [];
	
		$sql = $db->query("SELECT Sum(tblp_modulo.Creditos) AS Total FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus =  '10' AND tblp_calificacion.Promedio >  '5' ");
		while($x = $db->recorrer($sql)){
			$get_mis_creditos[] = $x;
		}
		return $get_mis_creditos;
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





	public function get_mis_materias($IdUsua) {
		$db = new Conexion();
		$get_mis_materias = [];
	
		$sql = $db->query("SELECT Count(tblp_modulo.IdModulo) AS Total FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus =  '10' AND tblp_calificacion.Promedio >  '5' ");
		while($x = $db->recorrer($sql)){
			$get_mis_materias[] = $x;
		}
		return $get_mis_materias;
	}
	
	public function get_oferta_id($IdOferta) {
		$db = new Conexion();
		$get_oferta_id = [];
	
		$sql = $db->query("SELECT * FROM tblp_educativa  WHERE tblp_educativa.IdEducativa =  '$IdOferta' ");
		while($x = $db->recorrer($sql)){
			$get_oferta_id[] = $x;
		}
		return $get_oferta_id;
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
	  
	  public function obtener_informacion_ido($IdUsua) {
		$db = new Conexion();
		$obtener_informacion_ido = [];
		$sql = $db->query("SELECT * FROM tblp_informacion WHERE tblp_informacion.IdUsua = '$IdUsua'");
		while($x = $db->recorrer($sql)){
		  $obtener_informacion_ido[] = $x;
		}
		return $obtener_informacion_ido;
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
		tblp_calificacion.IdOferta =  '$IdOferta'
		GROUP BY
		tblp_calificacion.IdUsua");
		while($x = $db->recorrer($sql)){
		  $obtener_promedio_user[] = $x;
		}
		return $obtener_promedio_user;
	  }
}
	?>

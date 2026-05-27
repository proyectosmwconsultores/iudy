<?php
session_start();
header('Content-Type: application/json');
require('../php/clases/class.System.php');
$db = new Conexion();

// 1. Validación de sesión (Formato JSON)
if (!isset($_SESSION['IdUsua']) || empty($_SESSION['IdUsua'])) {
    echo json_encode([
        'ok' => false,
        'msg' => 'Tu sesión ha expirado. Debes iniciar sesión nuevamente.'
    ]);
    exit;
}

try {
    // Datos generales
    $idCiclo   = $_POST['txtCicloEscolar'];
    $idGrupo   = $_POST['txtClaveGrp'];
    $idModulo  = $_POST['txtModulo'];
    $idDocente = $_POST['txtDocente'];
    $idTutor   = $_POST['txtTutor'];
    $fInicio   = $_POST['datepicker'];
    $fFin      = $_POST['datepicker2'];

    $anio = date("Y");
    $mes = date("m");
    $anioo = substr($anio, 2, 2);

    // Verificar si ya existe la asignación
    $sql6 = $db->query("SELECT IdAsignacion FROM tblp_asignacion WHERE IdModulo = '$idModulo' AND IdGrupo = '$idGrupo' AND IdCiclo = '$idCiclo' LIMIT 1");
    $datos61 = $db->recorrer($sql6);

    if (!isset($datos61["IdAsignacion"])) {
        
        // --- Generación de Identificador y Carpetas ---
        $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $IdAsig = substr(str_shuffle($caracteres_permitidos), 0, 15);
        $dirBase = "./../assets/trabajos/$anio/$mes/$IdAsig"; // Ajusté la ruta relativa si es necesario

        if (!file_exists($dirBase)) {
            mkdir($dirBase, 0777, true);
            mkdir($dirBase . "/tareas", 0777, true);
        }

        // --- Obtener datos de apoyo ---
        $sql8 = $db->query("SELECT Grupo, Dia FROM tblp_grupo WHERE IdGrupo = '$idGrupo'");
        $datos81 = $db->recorrer($sql8);
        $grupo = $datos81["Grupo"];
        $_dia = $datos81["Dia"];

        $sql3 = $db->query("SELECT FInicio, FFinal FROM tblc_ciclo WHERE IdCiclo = '$idCiclo'");
        $datos31 = $db->recorrer($sql3);

        $sql5 = $db->query("SELECT COALESCE(Max(Folio), 0) AS Folio FROM tblp_planeacion WHERE IdUsua = '$idDocente'");
        $datos51 = $db->recorrer($sql5);
        $FFolio = $datos51["Folio"] + 1;

        $sql23 = $db->query("SELECT IdCampus, Nombre, APaterno FROM tblc_usuario WHERE IdUsua = '$idDocente'");
        $datos231 = $db->recorrer($sql23);
        $idCam = $datos231["IdCampus"];
        $codNomPat = substr($datos231["Nombre"], 0, 1) . substr($datos231["APaterno"], 0, 1);

        $sql9 = $db->query("SELECT IdEducativa, Grado, CodeModulo, IdCampus, NombreMod FROM tblp_modulo WHERE IdModulo = '$idModulo'");
        $datos91 = $db->recorrer($sql9);
        $IdOferta = $datos91["IdEducativa"];
        $semcua = $datos91["Grado"];
        $IdCamp = $datos91["IdCampus"];
        
        $cadFol = str_pad($FFolio, 3, "0", STR_PAD_LEFT);
        $cod = substr($datos91["CodeModulo"], 8, 1) . $codNomPat . $anioo . $cadFol;

        $sql_n = $db->query("SELECT g.IdGrado, g.Contenido FROM tblp_educativa e Left Join tblc_grado g ON g.IdGrado = e.IdGrado WHERE e.IdEducativa = '$IdOferta'");
        $datos_n = $db->recorrer($sql_n);
        $_texto = $datos_n["Contenido"];

        // --- INSERCIONES ---
        $Estatus = "Activo";
        
        // Insertar Docente (Tipo 2)
        $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdEducativa, IdModulo, Grupo, IdUsua, FecIni, FecFin, Estatus, FecCap, Tipo, IdGrupo, IdCiclo, IdEstatus, IdCampus, Anio, Mes, Fondo, _texto, _idEstatus) VALUES ('$IdAsig','$IdOferta','$idModulo','$grupo','$idDocente','$fInicio','$fFin','$Estatus',NOW(),'2','$idGrupo','$idCiclo','12','$IdCamp','$anio','$mes','img_1.jpg','$_texto','1')");
        
        // Insertar Tutor (Tipo 4)
        $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdEducativa, IdModulo, Grupo, IdUsua, FecIni, FecFin, Estatus, FecCap, Tipo, IdGrupo, IdCiclo, IdEstatus, IdCampus, Anio, Mes, Fondo, _texto, _idEstatus) VALUES ('$IdAsig','$IdOferta','$idModulo','$grupo','$idTutor','$fInicio','$fFin','$Estatus',NOW(),'4','$idGrupo','$idCiclo','12','$IdCamp','$anio','$mes','img_1.jpg','$_texto','1')");
        
        // Insertar Planeación
        $db->query("INSERT INTO tblp_planeacion (IdAsignacion, IdUsua, FecAsignacion, Folio, Planeacion, IdEstatus, IdCampus) VALUES ('$IdAsig','$idDocente',NOW(),'$FFolio','$cod','31','$IdCamp')");

        // Alumnos
        if ($_dia <> 'P') {
            $sqly = $db->query("SELECT IdUsua FROM tblc_alumnos WHERE IdCiclo= '$idCiclo' AND IdGrupo= '$idGrupo' AND IdEstatus = 8");
            while ($z = $db->recorrer($sqly)) {
                $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('$IdOferta','$idModulo','$grupo','" . $z["IdUsua"] . "','Activo',NOW(),'$IdAsig','$idGrupo')");
            }
        }

        // --- PROCESAR HORARIOS ---
        if (isset($_POST['horariosDetalle'])) {
           
		// ... (Tus validaciones previas e inserción de la cabecera $IdAsig) ...

			$horarios = json_decode($_POST['horariosDetalle'], true);

			if (is_array($horarios)) {
				// 1. Mapeo de Días a IDs
				$mapaDias = [
					'LUN' => 1,
					'MAR' => 2,
					'MIE' => 3,
					'JUE' => 4,
					'VIE' => 5,
					'SÁB' => 6,
					'DOM' => 7
				];

				$totalHorasSemana = 0; // Variable para sumar las horas

				foreach ($horarios as $diaLetra => $horas) {
					$idDia = $mapaDias[$diaLetra]; // Obtenemos el ID numérico
					$h_ini = $horas['inicio'];
					$h_fin = $horas['fin'];

					// 2. Cálculo de horas de clase por día
					$inicio = new DateTime($h_ini);
					$fin    = new DateTime($h_fin);
					$diferencia = $inicio->diff($fin);
					
					// Convertimos la diferencia a horas decimales (Ej: 2 horas 30 min = 2.5)
					$horasDecimales = $diferencia->h + ($diferencia->i / 60);
					$totalHorasSemana += $horasDecimales;

					// 3. Insertar en la base de datos usando el ID del día
					// Nota: He corregido un paréntesis faltante al final de tu consulta SQL
					$sql = "INSERT INTO tblp_horario (IdAsignacion, IdDia, HraIni, HraFin, Total) 
							VALUES ('$IdAsig', '$idDia', '$h_ini', '$h_fin','$horasDecimales')";
					
					$insertar = $db->query($sql);
				}

				// Al finalizar el ciclo, $totalHorasSemana tiene la suma total.
				// Puedes guardar este total en tu tabla principal si lo necesitas:
				// $db->query("UPDATE tblp_configuracion SET TotalHoras = '$totalHorasSemana' WHERE IdAsig = '$IdAsig'");
			}
        }

        // Actualizar Grado del Grupo
        $db->query("UPDATE tblp_grupo SET IdGrado = '$semcua' WHERE IdGrupo = '$idGrupo'");

        echo json_encode([
            'ok' => true,
            'msg' => 'Asignación configurada correctamente.'
        ]);

    } else {
        echo json_encode([
            'ok' => false,
            'msg' => 'Esta asignatura ya se encuentra asignada a este grupo y ciclo.'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'ok' => false,
        'msg' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}
<?php
date_default_timezone_set('America/Mexico_City');
require('class.System.php');
ob_start();
class Login {
  private $user;
  private $pass;
  public function logueo() {
    $db = new Conexion();

    if (isset($_SESSION['IdUsua'])) {
      header("Location:index.php");
      exit();
    }

    
    $user = $db->real_escape_string($_POST['txtUser']);
    $passs = $db->real_escape_string($_POST['txtPass']);

    $user = limpiar_cadena($user);
    $passs = limpiar_cadena($passs);
    
    $FecIns=date("Y-m-d");
		
    $pass_php = Password::hash($passs);
    
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Pass_php='$pass_php' AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '61') || (tblc_usuario.IdEstatus = '62')) AND ((tblc_usuario.Correo='$user') || (tblc_usuario.Usuario='$user')) ");
      if($db->rows($sql) > 0){
        $datos = $db->recorrer($sql);
        $codex = md5(rand() * time());
        $_SESSION['codex'] = $codex;
        $_SESSION['inicio'] = time();
        $d= $_SESSION['inicio'];
         $IdUser = $datos["IdUsua"];
         $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._hace = NOW() WHERE tblc_usuario.IdUsua = '$IdUser'");
        $insertar = $db->query("INSERT INTO tblh_log (IdUsua, Fecha, FecIng) VALUES ('$IdUser','$FecIns',NOW())");
        $insertar = $db->query("INSERT INTO tblh_contador (IdUsua, Tipo, FecIng, Codex, Inicio) VALUES ('$IdUser','I',NOW(),'$codex','$d')");
        $_SESSION['IdUsua'] = $datos["IdUsua"];
        $_SESSION['NombreUser'] = $datos["Nombre"].' '.$datos["APaterno"];
        $_SESSION['Cargo'] = $datos["Cargo"];
        $_SESSION['Permisos'] = $datos["Permisos"];
				$_SESSION['IdEstatus'] = $datos["IdEstatus"];
        $_SESSION['Foto'] = $datos["Foto"];
        $_SESSION['CodeId'] = $datos["Code"];
				$_SESSION['IdGrupo'] = $datos["IdGrupo"];
        $_SESSION['IdOferta'] = $datos["IdOferta"];
        $_SESSION['IdCampus'] = $datos["IdCampus"];
        $_SESSION['Correo'] = $datos["Correo"];
        $_SESSION['PerXS'] = $datos["Tipo"];
        $_SESSION['_Grado'] = $datos["Grado"];
        $IdE = $datos["IdEstatus"];
        $idCam = $datos["IdCampus"];

        $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
        $db->rows($sql_camp);
        $_camp = $db->recorrer($sql_camp);

        $_SESSION['sis_small'] = $_camp["Campus"];
        $_SESSION['sis_long'] = $_camp["Campus"];

        if($datos["IdUsua"] <> 1){
          $insertar = $db->query("INSERT INTO tblh_ingresos (IdUsua, Pagina, FecCap) VALUES ('$IdUser', 'Ha Iniciado sesion en la Plataforma MWComenius', NOW())");
        }
				if(($_SESSION['IdEstatus'] == 8) || ($_SESSION['IdEstatus'] == 50) || ($_SESSION['IdEstatus'] == 61) || ($_SESSION['IdEstatus'] == 62)) {
          if(($_SESSION['Permisos'] == 2) || ($_SESSION['Permisos'] == 4)) {
            $_SESSION['Tipo'] = 2;

            if($_SESSION['Permisos'] == 4){
              header("Location:viewSupervisor.php");
            }
            header("Location:misClases.php");

          }elseif($_SESSION['Permisos'] == 3) {

            $_SESSION['Tipo'] = 2;
            header("Location:clase.php");
          } else {
              $_SESSION['Tipo'] = 1;
              header("Location:welcome.php");
          }
				} else {
					header("Location:index.php?e=$IdE");
				}
      } else {
        $sql4 = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblc_usuario.IdUsua, tblc_usuario.IdEstatus FROM tblc_usuario WHERE Usuario='$user' AND Pass_php='$pass_php' ");
        $db->rows($sql4);
        $datos41 = $db->recorrer($sql4);
        $est = $datos41["IdEstatus"];
        if($est == 55){
          $_SESSION['_idUsua'] = $datos41["IdUsua"];
          $_SESSION['_nombre'] = $datos41["Nombre"];
          $_SESSION['_apellido'] = $datos41["APaterno"].' '.$datos41["AMaterno"];
          $_SESSION['_foto'] = $datos41["Foto"];
          echo "<script type='text/javascript'>window.location='trayectoria.php';</script>";  
        } else {
          echo "<script type='text/javascript'>window.location='index.php?e=1000025419$est';</script>";
        }
        
      }
	}

}

class Password {
    const SALT = 'MwC%6gA6w1W#8s';
    public static function hash($password) {
        return hash('sha512', self::SALT . $password);
    }
    public static function verify($password, $hash) {
        return ($hash == self::hash($password));
    }
}

function conversorSegundosHoras($tiempo_en_segundos) {
    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);

    if($horas < 10){ $horas = '0'.$horas; } else { $horas = $horas; }
    if($minutos < 10){ $minutos = '0'.$minutos; } else { $minutos = $minutos; }
    if($segundos < 10){ $segundos = '0'.$segundos; } else { $segundos = $segundos; }

    return $horas . ':' . $minutos . ":" . $segundos;
}


function conocerDiaXXX($fecha) {
	$dias = array('7', '1', '2', '3', '4', '5', '6');
	$dia = $dias[date('w', strtotime($fecha))];
	return $dia;

}


function limpiar_cadena($cadena)
{
  $cadena = trim($cadena);
  $cadena = stripslashes($cadena);
  $cadena = str_ireplace("<script>", "", $cadena);
  $cadena = str_ireplace("</script>", "", $cadena);
  $cadena = str_ireplace("<script src", "", $cadena);
  $cadena = str_ireplace("<script type=", "", $cadena);
  $cadena = str_ireplace("SELECT * FROM", "", $cadena);
  $cadena = str_ireplace("DELETE FROM", "", $cadena);
  $cadena = str_ireplace("INSERT INTO", "", $cadena);
  $cadena = str_ireplace("DROP TABLE", "", $cadena);
  $cadena = str_ireplace("DROP DATABASE", "", $cadena);
  $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
  $cadena = str_ireplace("SHOW TABLES", "", $cadena);
  $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
  $cadena = str_ireplace("<?php", "", $cadena);
  $cadena = str_ireplace("?>", "", $cadena);
  $cadena = str_ireplace("--", "", $cadena);
  $cadena = str_ireplace("^", "", $cadena);
  $cadena = str_ireplace("==", "", $cadena);
  $cadena = str_ireplace("'", "´", $cadena);
  $cadena = str_ireplace("::", "", $cadena);
  $cadena = str_ireplace("  ", "", $cadena);
  $cadena = stripslashes($cadena);
  $cadena = trim($cadena);
  return $cadena;
}

?>

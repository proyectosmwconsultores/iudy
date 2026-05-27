<?php
  require('../php/clases/class.System.php');
  $db = new Conexion();
  date_default_timezone_set('America/Mexico_City');
  $tipoGuardar = $_POST["TipoGuardar"];



  if($tipoGuardar == "updPaquete"){
    $IdPaquete = $_POST["IdPaquete"];
    $IdCompra = $_POST["IdCompra"];

    $sql9 = $db->query("SELECT * FROM tblc_paquete WHERE tblc_paquete.IdPaquete = '$IdPaquete' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $monto = $datos91["Monto"];
    $espacio = $datos91["Espacio"];

    $insertar = $db->query("UPDATE tblp_compra SET tblp_compra.IdPaquete = '$IdPaquete', tblp_compra.Monto = '$monto', tblp_compra.Total = '$espacio' WHERE tblp_compra.IdCompra = '$IdCompra' ");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "updPaqueteRenv"){
    $IdPaquete = $_POST["IdPaquete"];
    $IdCompraR = $_POST["IdCompraR"];

    $sql9 = $db->query("SELECT * FROM tblc_paquete WHERE tblc_paquete.IdPaquete = '$IdPaquete' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $monto = $datos91["Monto"];
    $espacio = $datos91["Espacio"];

    $insertar = $db->query("UPDATE tblp_compra_renovar SET tblp_compra_renovar.IdPaquete = '$IdPaquete' WHERE tblp_compra_renovar.IdCompraRenovar = '$IdCompraR' ");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "quitar_alumno"){
    $IdUsua = $_POST["IdUsua"];
    $IdCompra = $_POST["IdCompra"];

    $sql9 = $db->query("SELECT
  tblp_compra.IdCompra,
  tblp_compra.Total,
  tblp_compra.Activos
  FROM
  tblp_compra
  WHERE tblp_compra.IdCompra =  '$IdCompra' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $total = $datos91["Total"];
    $activos = $datos91["Activos"] - 1;

    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '50' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    $insertar = $db->query("UPDATE tblp_compra SET tblp_compra.Activos = '$activos' WHERE tblp_compra.IdCompra = '$IdCompra' ");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "buscar_User"){
    $Code = $_POST["Code"];
    $valor = '0-0';
    $sql9 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Permisos FROM tblc_usuario WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.Correo =  '$Code' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdUsua = $datos91["IdUsua"];
    $Tipo = $datos91["Permisos"];

    if($IdUsua){
      if(($Tipo == 2) || ($Tipo == 3)){
        $valor = $Tipo.'-'.time().$IdUsua;
      } else {
        $valor = '1-'.time().$IdUsua;
      }
    } else {
      $valor = '0-0';
    }



    $db->close();
    echo $valor;
  }

  if($tipoGuardar == "actAlumnoD"){
    $IdUsua = $_POST["IdUsua"];
    $IdDocente = $_POST["IdDocente"];
    $IdOferta = $_POST["IdOferta"];
    $IdCampus = $_POST["IdCampus"];

    $sql8 = $db->query("SELECT tblp_compra.IdCompra, tblp_compra.Total, tblp_compra.Activos FROM tblp_compra WHERE tblp_compra.IdUsua =  '$IdDocente' AND tblp_compra.IdEstatus =  '8'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdCompra_ = $datos81["IdCompra"];
    $Total_ = $datos81["Total"];
    $Activos_ = $datos81["Activos"];
    $disponible = ($Total_ - $Activos_);
    if($disponible <=0 ){
      echo 4;
      exit();
    } else {

      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdOferta = '$IdOferta', tblc_usuario.IdCampus = '$IdCampus', tblc_usuario.IdEstatus = '8', tblc_usuario.IdGrupo = NULL, tblc_usuario.id_usua = '$IdDocente', tblc_usuario.id_compra = '$IdCompra_' WHERE tblc_usuario.IdUsua = '$IdUsua'");

      $Activos_ = $Activos_ + 1;
      $insertar = $db->query("UPDATE tblp_compra SET tblp_compra.Activos = '$Activos_' WHERE tblp_compra.IdCompra = '$IdCompra_'");

      $db->close();
      echo $insertar;
    }
  }

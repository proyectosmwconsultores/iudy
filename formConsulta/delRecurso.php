<?php
include('../hace.php');
if (isset($_POST["Id"])) {
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblp_biblioteca WHERE tblp_biblioteca.IdBiblioteca = '" . $_POST["Id"] . "'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwLink = $datos91["Link"];
  $principal = $datos91["Principal"];


  if ($datos91["servidor"] == 1) {
    if ($principal == 1) {
      $delDoc = "../assets/biblioteca/$rwLink";
      if (file_exists($delDoc)) {
        unlink($delDoc);
      }
    }

    $insertar = $db->query("DELETE FROM tblp_biblioteca WHERE tblp_biblioteca.IdBiblioteca = '" . $_POST["Id"] . "'");
    $db->close();

    if ($insertar) {
      $output =  1;
    } else {
      $output =  0;
    }
  } else {
    if ($principal == 1) {
      $elimnado = 1;

      $url = $datos91["Link"];
      $rutaServicio = "https://fileservice.s3mwc.com/api/eliminar";
  
      try {
        $curl = curl_init();
        $postData = [
          "archivo" => $url
        ];
        $headers = [
          "T-Access: vJ7yzm8Tyd-MWmeC3VJ9q7q"
        ];
  
        curl_setopt_array($curl, [
          CURLOPT_URL => $rutaServicio,
          CURLOPT_POST => true,
          CURLOPT_POSTFIELDS => $postData,
          CURLOPT_HTTPHEADER => $headers,
          CURLOPT_RETURNTRANSFER => true
        ]);
  
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
          throw new Exception("Error en la solicitud cURL: " . curl_error($curl));
        }
  
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
  
        $decodedResponse = json_decode($response, true);
        
        if ($decodedResponse['status_code'] != 200) {
          $elimnado = 0;
          // echo "Error en el formato de materias";
          // die();
        }
      } catch (Exception $e) {
        echo $e->getMessage();
        // die();
      }
  
      if ($elimnado == 1) {
        $output =  1;
        $insertar = $db->query("DELETE FROM tblp_biblioteca WHERE tblp_biblioteca.IdBiblioteca = '" . $_POST["Id"] . "'");
        $db->close();
      } else {
        $output =  0;
      }

    } else {
      $output =  1;
      $insertar = $db->query("DELETE FROM tblp_biblioteca WHERE tblp_biblioteca.IdBiblioteca = '" . $_POST["Id"] . "'");
      $db->close();
    }
    
  }

  echo $output;
}

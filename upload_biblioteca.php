<?php
session_start();
require('php/clases/class.System.php');
$db = new Conexion();

$hoy = date("Y-m-d");
$Tipo =  $_POST["Tipo"];
$Nombre =  $_POST["Nombre"];
$TipoDoc =  $_POST["TipoDoc"];

$IdUsua = $_SESSION['IdUsua'];
$IdToks = $_POST["IdToks"];
$IdActividad = $_POST["IdActividad"];

if ($Tipo == 0) {

    // Verificar si se subió un archivo
    if (is_array($_FILES) && count($_FILES) > 0 && isset($_FILES['file'])) {
        $tipo = $_FILES['file']['type'];
        $archivo = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $maxFileSize = 50 * 1024 * 1024; // 50 MB en bytes

        if ($fileSize > $maxFileSize) {
            echo 2;
            exit();
        }

        if ($archivo) {
            // Obtener la extensión
            $info = new SplFileInfo($archivo);
            $tipox =  $info->getExtension();

            // Enviar el archivo al FileService
            $rutaServicio = "https://fileservice.s3mwc.com/api/almacenar";
            $nombre_carpeta = "sciudy/biblioteca";
            $headers = [
                "T-Access: vJ7yzm8Tyd-MWmeC3VJ9q7q"
            ];

            $fullFilePath = $_FILES["file"]['tmp_name']; // Archivo temporal

            try {
                $curl = curl_init();
                $postData = [
                    "cliente" => $nombre_carpeta,
                    "archivo" => new CURLFile($fullFilePath, $tipo, $archivo)
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
                $decodedResponse['status_code']; 
                //var_dump($decodedResponse);

                if ($decodedResponse['status_code'] == 200) {
                    if (isset($decodedResponse['data']['archivo'])) {
                        $rutaArchivoFileService = $decodedResponse['data']['archivo'];
                        
                        
                        $insertar = $db->query("INSERT INTO tblp_biblioteca (IdAsignacion, Nombre, Link, IdTema,IdUsua,FecCap,Tipo,IdActividadesDocente, servidor) VALUES('$IdToks','$Nombre','$rutaArchivoFileService','$TipoDoc','$IdUsua',NOW(),'$tipox','$IdActividad',2)");
                       
            echo $insertar;
             $db->close();
            exit();
                    } else {
                        echo 0;
                        exit();
                    }
                } else {
                    echo "Error en el formato de materias";
                    die();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                die();
            }

            // Ahora usar $rutaArchivoFileService como ruta en la BD en lugar de la ruta local

            


            $db->close();
            echo $insertar;
            exit();
        } else {
            echo 1;
            exit();
        }
    } else {
        echo 0;
        exit();
    }

    echo 3;
    exit();
} else {
    $archivo = $_POST["Video"];

    $resultado1 = str_replace("560", "100%", $archivo);
    $resultado2 =  str_replace("960", "100%", $resultado1);
    $resultado3 =  str_replace("560", "100%", $resultado2);
    $resultado4 =  str_replace("960", "100%", $resultado3);
    $resultado5 =  str_replace("569", "400", $resultado4);

    $insertar = $db->query("INSERT INTO tblp_biblioteca (IdAsignacion, Nombre, Link, IdTema,IdUsua,FecCap,Tipo,IdActividadesDocente, servidor)  VALUES('$IdToks','$Nombre','$resultado5','$TipoDoc','$IdUsua',NOW(),'youtube','$IdActividad',1)");
    echo 1;
    exit();
}

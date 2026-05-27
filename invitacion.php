<?php
if(isset($_GET['idToken'])){

$token = $_GET['idToken'];
require('php/clases/class.System.php');
$db = new Conexion();

$sql_user = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdUsua,
tblp_asignacion.IdCiclo,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Correo,
tblc_usuario.Foto
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
WHERE
tblp_asignacion.IdAsignacion =  '$token' AND
tblp_asignacion.Tipo =  '2'
 ");
$db->rows($sql_user);
$_user = $db->recorrer($sql_user);

if(!isset($_user['IdUsua'])){
	header('Location: https://sciudy.com/');
	exit;
}

$IdUsua = $_user['IdUsua'];
$IdCiclo = $_user['IdCiclo'];

$sql_all = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEstatus,
tblp_modulo.NombreMod,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_grupo.CveGrupo,
tblp_asignacion._grado,
tblp_educativa.Nombre
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
WHERE
tblp_asignacion._estatus =  'V' AND
tblp_asignacion.IdUsua =  '$IdUsua' AND
tblp_asignacion.IdCiclo =  '$IdCiclo'
ORDER BY
tblp_educativa.IdGrado ASC,
tblp_educativa.Nombre ASC,
tblp_grupo.CveGrupo ASC

");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de clases</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 980px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .profile {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: #1d3462;
            color: white;
            border-radius: 10px;
        }
        .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid white;
        }
        .profile-info {
            flex: 1;
        }
        .profile-info h2 {
            margin: 0;
        }
        .profile-info p {
            margin: 5px 0;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
			font-size: 14px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #1d3462;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<?php

?>
<body>
    <div class="container">
        <div class="profile">
            <img src="assets/perfil/<?php echo $_user['Foto']; ?>" alt="Perfil Docente">
            <div class="profile-info">
                <h2><?php echo $_user['Nombre']; ?> <?php echo $_user['APaterno']; ?> <?php echo $_user['AMaterno']; ?></h2>
                <p><strong>Correo:</strong> <?php echo $_user['Correo']; ?></p>
            </div>
        </div>
        <h1 style="font-size: 24px;">Mi lista de materias</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Carrera</th>
                    <th>Materia</th>
                    <th>Grupo</th>
                    <th>Fecha</th>
                    <th>Invitación</th>
                </tr>
            </thead>
            <tbody>
			<?php $n = 0; while ($all = $db->recorrer($sql_all)) {  ?>
                <tr>
                    <td><?php echo $n = ($n + 1); ?></td>
                    <td><?php echo $all['Nombre']; ?></td>
                    <td><?php echo $all['NombreMod']; ?></td>
                    <td><?php echo $all['_grado']; ?>° <?php echo $all['CveGrupo']; ?></td>
                    <td><?php echo $all['FecIni']; ?> al <?php echo $all['FecFin']; ?></td>
					<td><?php if($all['IdEstatus'] == 1){ echo "PENDIENTE"; } else { echo "ACEPTADO"; } ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php 

} else {
	header('Location: https://sciudy.com/');
	exit;
}

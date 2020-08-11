<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: token, Content-Type');
header('Access-Control-Max-Age: 1728000');
header('Content-Length: 0');
header('Content-Type: application/json');
include 'conexion.php';
$op = $_POST['op'];
if ($op === null) {
    echo "Error";
} else {
    switch ($op) {
        case 'insertAlumno':
            header('Content-Type: application/json');
            $cedula = $_POST['EST_CED'];
            $nombre = $_POST['EST_NOM'];
            $apellido = $_POST['EST_APE'];
            $direccion = $_POST['EST_DIR'];
            $telefono = $_POST['EST_TEL'];
            $sexo = $_POST['EST_SEX'];
            $sqlInsert = "INSERT INTO estudiantes(EST_CED,EST_NOM,EST_APE,EST_DIR,EST_TEL,EST_SEX) 
                        VALUES ('$cedula','$nombre','$apellido','$direccion','$telefono','$sexo')";
            if ($mysqli->query($sqlInsert) === TRUE) {
                echo json_encode("Se guardo correctamente");
            } else {
                echo "Error..." . $sqlInsert . "<br>" . $mysqli->error;
            }
            $mysqli->close();
            break;


        case 'updateAlumno':
            header('Content-Type: application/json');
            $cedula = $_POST['EST_CED'];
            $nombre = $_POST['EST_NOM'];
            $sqlUpdate = "UPDATE estudiantes SET EST_NOM = '$nombre' WHERE EST_CED = '$cedula'";
            if ($mysqli->query($sqlUpdate) === TRUE) {
                echo json_encode("Se actualizo correctamente");
            } else {
                echo "Error:" . $sqlUpdate . "<br>" . $mysqli->error;
            }
            $mysqli->close();
            break;

        case 'deleteAlumno':
            header('Content-Type: application/json');
            $cedula = $_POST['EST_CED'];
            if (isset($cedula)) {
                $sqlDelete = "DELETE FROM estudiantes WHERE EST_CED = $cedula";
                $resultado = $mysqli->query($sqlDelete);
                echo json_encode(array("correcto" => $resultado));
                $mysqli->close();
            }

            break;
    }
}
?>

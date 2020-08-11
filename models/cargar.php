<?php

include "conexion.php";
$query = "SELECT * FROM estudiantes";
if (isset($_POST['EST_CED']) != "") {
    $q = $conn->real_escape_string($_POST['EST_CED']);
    $query = "SELECT * FROM estudiantes WHERE EST_CED LIKE '%" . $q . "%'";
}
$buscarAlumno = $conn->query($query);
$result = array();
if ($buscarAlumno->num_rows > 0) {
    while ($filaAlumno = $buscarAlumno->fetch_assoc()) {
        array_push($result, $filaAlumno);
    }
} else {
    $result = "No se encontraron estudiantes";
}

echo json_encode($result);
?>

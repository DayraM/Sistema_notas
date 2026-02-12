<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'conexion.php';

// 1. REGISTRAR ALUMNO
if (isset($_POST['registrar_alumno'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha_nacimiento'];

    $sql = "INSERT INTO alumnos (nombre, apellido, correo, telefono, fecha_nacimiento) VALUES ('$nombre', '$apellido', '$correo', '$telefono', '$fecha')";
    $conn->query($sql);
    header("Location: index.php");
}

// 2. ACTUALIZAR DATOS DEL ALUMNO
if (isset($_POST['actualizar_alumno'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha_nacimiento'];

    $sql = "UPDATE alumnos SET nombre='$nombre', apellido='$apellido', correo='$correo', telefono='$telefono', fecha_nacimiento='$fecha' WHERE id=$id";
    $conn->query($sql);
    header("Location: index.php");
}

// 3. REGISTRAR NOTA NUEVA
if (isset($_POST['registrar_nota'])) {
    $id_alumno = $_POST['id_alumno'];
    $materia = $_POST['materia'];
    $nota = $_POST['nota'];

    if ($nota >= 0 && $nota <= 10) {
        $sql = "INSERT INTO notas (id_alumno, materia, nota) VALUES ('$id_alumno', '$materia', '$nota')";
        $conn->query($sql);
    }
    header("Location: index.php");
}

// 4. MODIFICAR NOTA EXISTENTE 
if (isset($_POST['modificar_nota'])) {
    $id_nota = $_POST['id_nota'];
    $nota = $_POST['nota'];
    
    // Obtenemos el ID del alumno antes de actualizar 
    $res = $conn->query("SELECT id_alumno FROM notas WHERE id = $id_nota");
    $row = $res->fetch_assoc();
    $id_alumno = $row['id_alumno'];

    $sql = "UPDATE notas SET nota = '$nota' WHERE id = $id_nota";
    $conn->query($sql);
    
    header("Location: notas.php?id=" . $id_alumno);
}

// 5. ELIMINAR NOTA INDIVIDUAL
if (isset($_GET['eliminar_nota'])) {
    $id_nota = $_GET['eliminar_nota'];
    
    // Si viene el id_alumno por URL, regresamos a notas.php, si no, a index.php
    $conn->query("DELETE FROM notas WHERE id = $id_nota");
    
    if (isset($_GET['id_alumno'])) {
        header("Location: notas.php?id=" . $_GET['id_alumno']);
    } else {
        header("Location: index.php");
    }
}

// 6. ELIMINAR ALUMNO COMPLETO
if (isset($_GET['eliminar_alumno'])) {
    $id = $_GET['eliminar_alumno'];
 
    $conn->query("DELETE FROM notas WHERE id_alumno = $id");
    $conn->query("DELETE FROM alumnos WHERE id = $id");
    header("Location: index.php");
}
?>
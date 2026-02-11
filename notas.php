<!DOCTYPE html>
<?php
include 'conexion.php';
$id_alumno = $_GET['id'];

// Obtener nombre del alumno
$res_alumno = $conn->query("SELECT nombre, apellido FROM alumnos WHERE id = $id_alumno");
$alumno = $res_alumno->fetch_assoc();

// Obtener sus notas
$notas = $conn->query("SELECT * FROM notas WHERE id_alumno = $id_alumno");
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="public/vendor/bootstrap-5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/vendor/bootstrap-icons-1.13.1/bootstrap-icons.css">
    <title>Gestionar Notas</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                
                <a href="index.php" class="btn btn-outline-light btn-sm">Volver al Inicio</a>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Nota</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
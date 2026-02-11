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
                <h4>Notas de: <?php echo $alumno['nombre'] . " " . $alumno['apellido']; ?></h4>
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
                        <?php while($n = $notas->fetch_assoc()): ?>
                        <tr>
                            <form action="acciones.php" method="POST">
                                <td><?php echo $n['materia']; ?></td>
                                <td>
                                    <input type="number" name="nota" step="0.01" min="0" max="10" 
                                           class="form-control form-control-sm" value="<?php echo $n['nota']; ?>">
                                    <input type="hidden" name="id_nota" value="<?php echo $n['id']; ?>">
                                </td>
                                <td>
                                    <button type="submit" name="modificar_nota" class="btn btn-sm btn-success">
                                        <i class="bi bi-check-lg"></i> Guardar
                                    </button>
                                    <a href="acciones.php?eliminar_nota=<?php echo $n['id']; ?>&id_alumno=<?php echo $id_alumno; ?>" 
                                       class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta nota?')">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                </td>
                            </form>
                        </tr>
                        <?php endwhile; ?>                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html
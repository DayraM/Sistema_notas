<?php
include 'conexion.php';
$id_alumno = $_GET['id'];

// Obtener nombre del alumno
$res_alumno = $conn->query("SELECT nombre, apellido FROM alumnos WHERE id = $id_alumno");
$alumno = $res_alumno->fetch_assoc();

// Obtener sus notas
$notas = $conn->query("SELECT * FROM notas WHERE id_alumno = $id_alumno");
?>
<!DOCTYPE html>
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
                    <thead class="table-secondary">
                        <tr>
                            <th>Materia</th>
                            <th>Nota</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        $cantidad = 0;

                        while($n = $notas->fetch_assoc()): 
                            $total += $n['nota'];
                            $cantidad++;
                        ?>
                        <tr>
                            <td><?php echo $n['materia']; ?></td>

                            <td>
                                <form action="acciones.php" method="POST">

                                    <input type="number" 
                                        name="nota" 
                                        step="0.01" 
                                        min="0" 
                                        max="10" 
                                        class="form-control form-control-sm"
                                        value="<?php echo $n['nota']; ?>" required>

                                    <input type="hidden" name="id_nota" value="<?php echo $n['id']; ?>">

                            </td>

                            <td>
                                    <button type="submit" name="modificar_nota" class="btn btn-sm btn-success">
                                        <i class="bi bi-check-lg"></i>
                                    </button>

                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            onclick="confirmarEliminacion(<?php echo $n['id']; ?>, <?php echo $id_alumno; ?>)">
                                        <i class="bi bi-x-lg"></i>
                                    </button>

                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>


                        <?php 
                        $promedio = ($cantidad > 0) ? $total / $cantidad : 0;

                        // Estado cualitativo
                        $estado = "Sin notas";
                        $clase = "table-secondary";

                        if ($cantidad > 0) {
                            if ($promedio >= 9) { $estado = "Sobresaliente"; $clase = "table-primary"; }
                            elseif ($promedio >= 7) { $estado = "Notable"; $clase = "table-success"; }
                            elseif ($promedio >= 5) { $estado = "Bien"; $clase = "table-warning"; }
                            else { $estado = "Suspenso"; $clase = "table-danger"; }
                        }
                        ?>

                        <!-- FILA FINAL DEL PROMEDIO -->
                        <tr class="<?php echo $clase; ?> fw-bold">
                            <td>Promedio General (<?php echo $estado; ?>)</td>
                            <td><?php echo number_format($promedio, 2); ?></td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="public/vendor/jquery-3.5.1.js"></script>
    <script src="public/vendor/sweetalert2-11.0.16/js/sweetalert2.min.js"></script>
    <script src="public/js/controles.js"></script>
</body>
</html>
